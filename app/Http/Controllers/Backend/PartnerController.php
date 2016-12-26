<?php

namespace App\Http\Controllers\Backend;

use App\Models\Partner;
use App\Traits\Controllers\AjaxFieldsChangerTrait;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use Meta;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use FlashMessages;
use Datatables;
use DB;
use Redirect;
use App\Http\Requests;

class PartnerController extends BackendController
{

    use AjaxFieldsChangerTrait;

    public $module = "partner";

    public $accessMap = [
        'index'           => 'partner.read',
        'create'          => 'partner.create',
        'store'           => 'partner.create',
        'show'            => 'partner.read',
        'edit'            => 'partner.read',
        'update'          => 'partner.write',
        'destroy'         => 'partner.delete',
        'ajaxFieldChange' => 'partner.write',
    ];

    public function __construct(ResponseFactory $response)
    {
        parent::__construct($response);

        Meta::title(trans('labels.partners'));

        $this->breadcrumbs(trans('labels.partners'), route('admin.partner.index'));

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
            $list = Partner::withTranslations()->joinTranslations('partners', 'partner_translations')->select(
                'partners.id',
                'partner_translations.title',
                'status',
                'position'
            );

            return $dataTables = Datatables::of($list)
                ->filterColumn('id', 'where', 'partners.id', '=', '$1')
                ->filterColumn('partner_translations.title', 'where', 'partner_translations.title', 'LIKE', '%$1%')
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
                ->removeColumn('translations')
                ->removeColumn('content')
                ->make();
        }

        /*$this->_fillAdditionTemplateData();*/

        $this->data('page_title', trans('labels.partners'));
        $this->breadcrumbs(trans('labels.partners_list'));

        return $this->render('views.partner.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->data('model', new Partner);

        $this->data('page_title', trans('labels.partner_create'));

        $this->breadcrumbs(trans('labels.partner_create'));

        return $this->render('views.partner.create');
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
            $model = new Partner($input);

            $model->save();

            DB::commit();

            FlashMessages::add('success', trans('messages.save_ok'));

            return Redirect::route('admin.partner.index');
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
            $model = Partner::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            FlashMessages::add('error', trans('messages.record_not_found'));

            return Redirect::route('admin.partner.index');
        }

        $this->data('page_title', '"'.$model->title.'"');

        $this->breadcrumbs(trans('labels.partner_editing'));

        /*$this->_fillAdditionTemplateData($model);*/

        return $this->render('views.partner.edit', compact('model'));
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
            $model = Partner::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            FlashMessages::add('error', trans('messages.record_not_found'));

            return Redirect::route('admin.partner.index');
        }

        $input = $request->all();

        DB::beginTransaction();

        try {
            $model->fill($input);

            $model->update();

            DB::commit();

            FlashMessages::add('success', trans('messages.save_ok'));

            return Redirect::route('admin.partner.index');
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
            $model = Partner::findOrFail($id);

            if (!$model->delete()) {
                FlashMessages::add("error", trans("messages.destroy_error"));
            } else {
                FlashMessages::add('success', trans("messages.destroy_ok"));
            }
        } catch (ModelNotFoundException $e) {
            FlashMessages::add('error', trans('messages.record_not_found'));
        }

        return Redirect::route('admin.partner.index');
    }
}
