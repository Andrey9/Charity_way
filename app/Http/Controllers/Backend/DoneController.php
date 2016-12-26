<?php

namespace App\Http\Controllers\Backend;

use App\Models\Done;
use App\Traits\Controllers\AjaxFieldsChangerTrait;
use Illuminate\Contracts\Routing\ResponseFactory;
use Meta;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use FlashMessages;
use Datatables;
use DB;
use Redirect;
use Illuminate\Http\Request;


use App\Http\Requests;

class DoneController extends BackendController
{
    use AjaxFieldsChangerTrait;

    public $module = "done";

    public $accessMap = [
        'index'           => 'done.read',
        'create'          => 'done.create',
        'store'           => 'done.create',
        'show'            => 'done.read',
        'edit'            => 'done.read',
        'update'          => 'done.write',
        'destroy'         => 'done.delete',
        'ajaxFieldChange' => 'done.write',
    ];

    public function __construct(ResponseFactory $response)
    {
        parent::__construct($response);

        Meta::title(trans('labels.done'));

        $this->breadcrumbs(trans('labels.done'), route('admin.done.index'));

        $this->middleware('slug.set', ['only' => ['store', 'update']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->get('draw')) {
            $list = Done::select(
                'dones.id',
                'content',
                'status',
                'position'
            );

            return $dataTables = Datatables::of($list)
                ->filterColumn('id', 'where', 'dones.id', '=', '$1')
                ->editColumn(
                    'status',
                    function ($model) {
                        return view(
                            'partials.datatables.toggler',
                            ['model' => $model, 'type' => $this->module, 'field' => 'status']
                        )->render();
                    }
                )
                ->editColumn(
                    'position',
                    function ($model) {
                        return view(
                            'partials.datatables.text_input',
                            ['model' => $model, 'type' => $this->module, 'field' => 'position']
                        )->render();
                    }
                )
                ->editColumn(
                    'actions',
                    function ($model) {
                        return view(
                            'partials.datatables.control_buttons',
                            ['model' => $model, 'front_link' => false, 'type' => $this->module]
                        )->render();
                    }
                )
                ->setIndexColumn('id')
                ->make();
        }

        /*$this->_fillAdditionTemplateData();*/

        $this->data('page_title', trans('labels.done'));
        $this->breadcrumbs(trans('labels.done_list'));

        return $this->render('views.done.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data('model', new Done);

        $this->data('page_title', trans('labels.done_create'));

        $this->breadcrumbs(trans('labels.done_create'));

        return $this->render('views.done.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        DB::beginTransaction();

        try {
            $model = new Done($input);

            $model->save();

            DB::commit();

            FlashMessages::add('success', trans('messages.save_ok'));

            return Redirect::route('admin.done.index');
        } catch (Exception $e) {
            DB::rollBack();

            FlashMessages::add('error', trans('messages.save_failed'));

            return Redirect::back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->edit($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $model = Done::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            FlashMessages::add('error', trans('messages.record_not_found'));

            return Redirect::route('admin.done.index');
        }

        $this->data('page_title', trans('labels.done').' '.$model->id);

        $this->breadcrumbs(trans('labels.editing'));

        return $this->render('views.done.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $model = Done::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            FlashMessages::add('error', trans('messages.record_not_found'));

            return Redirect::route('admin.done.index');
        }

        $input = $request->all();

        DB::beginTransaction();

        try {
            $model->fill($input);

            $model->update();

            DB::commit();

            FlashMessages::add('success', trans('messages.save_ok'));

            return Redirect::route('admin.done.index');
        } catch (Exception $e) {
            DB::rollBack();

            FlashMessages::add("error", trans('messages.update_error').': '.$e->getMessage());

            return Redirect::back()->withInput($input);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $model = Done::findOrFail($id);

            if (!$model->delete()) {
                FlashMessages::add("error", trans("messages.destroy_error"));
            } else {
                FlashMessages::add('success', trans("messages.destroy_ok"));
            }
        } catch (ModelNotFoundException $e) {
            FlashMessages::add('error', trans('messages.record_not_found'));
        }

        return Redirect::route('admin.done.index');
    }
}
