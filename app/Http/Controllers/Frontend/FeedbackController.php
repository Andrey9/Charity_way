<?php namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Frontend\Feedback\FeedbackRequest;
use App\Models\User;
use Exception;
use Mail;

/**
 * Class FeedbackController
 * @package App\Http\Controllers\Frontend
 */
class FeedbackController extends FrontendController
{
    /**
     * @var string
     */
    public $module = 'feedback';

    /**
     * @param FeedbackRequest $request
     *
     * @return array
     */
    public function store(FeedbackRequest $request)
    {
        /*Mail::queue(
            'emails.admin.new_feedback',
            [
                'fio'          => $request->get('fio'),
                'phone'        => $request->get('phone'),
                'user_message' => $request->get('message'),
            ],
            function ($message) {
                $message->to(config('app.email'), config('app.name'))->subject(trans('subjects.new_feedback'));
            }
        );*/

        /*return json_encode([
            'status'  => 'success',
            'message' => trans('messages.thanks for your feedback')
        ]);*/
        try {
            Mail::send(
                'emails.admin.new_feedback',
                [
                    'fio'          => $request->get('fio'),
                    'phone'        => $request->get('phone'),
                    'user_message' => $request->get('message'),
                ],
                function ($message) use ($request) {
                    $message->from(config('mail.username'), $request->get('fio'));

                    $message->to(config('mail.username'), config('app.name'))->subject(trans('subjects.new_feedback'));
                }
            );

            return json_encode([
                'status'  => 'success',
                'message' => trans('messages.thanks for your feedback')
            ]);
        } catch (Exception $e) {
            return json_encode([
                'status'  => 'error',
                'message' => trans('messages.an error has occurred, try_later')
            ]);
        }
    }
}