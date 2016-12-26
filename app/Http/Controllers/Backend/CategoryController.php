<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Traits\Controllers\AjaxFieldsChangerTrait;
use App\Models\Category;
use Illuminate\Contracts\Routing\ResponseFactory;
use Meta;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use FlashMessages;
use Datatables;
use DB;
use Redirect;

class CategoryController extends BackendController
{

    use AjaxFieldsChangerTrait;

    public $module = "category";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $accessMap = [
        'index'           => 'category.read',
        'create'          => 'category.create',
        'store'           => 'category.create',
        'show'            => 'category.read',
        'edit'            => 'category.read',
        'update'          => 'category.write',
        'destroy'         => 'category.delete',
        'ajaxFieldChange' => 'category.write',
    ];

    public function __construct(ResponseFactory $response/*, /*PageService $pageService*/)
    {
        parent::__construct($response);

        //$this->pageService = $pageService;

        Meta::title(trans('labels.categories'));

        $this->breadcrumbs(trans('labels.categories'), route('admin.category.index'));

        $this->middleware('slug.set', ['only' => ['store', 'update']]);
    }

    public function index(Request $request)
    {
        if ($request->get('draw')) {
            $list = Category::with(['parent'])->withTranslations()->joinTranslations('categories', 'category_translations')->select(
                'categories.id',
                'category_translations.name',
                'status',
                'position',
                'parent_id',
                'slug'
            );

            return $dataTables = Datatables::of($list)
                ->filterColumn('id', 'where', 'categories.id', '=', '$1')
                ->filterColumn('category_translations.name', 'where', 'category_translations.name', 'LIKE', '%$1%')
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
                ->removeColumn('meta_keywords')
                ->removeColumn('meta_title')
                ->removeColumn('meta_description')
                ->removeColumn('parent')
                ->removeColumn('translations')
                ->removeColumn('parent_id')
                ->removeColumn('slug')
                ->make();
        }

        $this->_fillAdditionTemplateData();

        $this->data('page_title', trans('labels.categories'));
        $this->breadcrumbs(trans('labels.categories_list'));

        return $this->render('views.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->_fillAdditionTemplateData();

        $this->data('model', new Category);

        $this->data('page_title', trans('labels.category_create'));

        $this->breadcrumbs(trans('labels.category_create'));

        return $this->render('views.category.create');
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

        $input['parent_id'] = isset($input['parent_id']) ? $input['parent_id'] : null;

        DB::beginTransaction();

        try {
            $model = new Category($input);
            //prd($model);
            $model->save();

            //$this->pageService->setExternalUrl($model);

            DB::commit();

            FlashMessages::add('success', trans('messages.save_ok'));

            return Redirect::route('admin.category.index');
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
            $model = Category::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            FlashMessages::add('error', trans('messages.record_not_found'));

            return Redirect::route('admin.category.index');
        }

        $this->data('page_title', '"'.$model->name.'"');

        $this->breadcrumbs(trans('labels.category_editing'));

        $this->_fillAdditionTemplateData($model);

        return $this->render('views.category.edit', compact('model'));
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
            $model = Category::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            FlashMessages::add('error', trans('messages.record_not_found'));

            return Redirect::route('admin.category.index');
        }

        $input = $request->all();
        $input['parent_id'] = isset($input['parent_id']) ? $input['parent_id'] : null;

        DB::beginTransaction();

        try {
            $model->fill($input);

            $model->update();

            DB::commit();

            FlashMessages::add('success', trans('messages.save_ok'));

            return Redirect::route('admin.category.index');
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
            $model = Category::findOrFail($id);

            if (!$model->delete()) {
                FlashMessages::add("error", trans("messages.destroy_error"));
            } else {
                FlashMessages::add('success', trans("messages.destroy_ok"));
            }
        } catch (ModelNotFoundException $e) {
            FlashMessages::add('error', trans('messages.record_not_found'));
        }

        return Redirect::route('admin.category.index');
    }

    private function _fillAdditionTemplateData($model = null)
    {
        if ($model) {
            $list = Category::with('translations')->where('id', '<>', $model->id)
                ->where(
                    function ($query) use ($model) {
                        $query->orWhere('parent_id', '<>', $model->id)
                            ->orWhere('parent_id', '=', null);
                    }
                )->get();
        } else {
            $list = Category::with('translations')->get();
        }
        $parents = ['' => trans('labels.no')];
        foreach ($list as $item) {
            $parents[$item->id] = $item->name;
        }
        $this->data('parents', $parents);
    }
}
