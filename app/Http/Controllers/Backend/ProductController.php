<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use App\Traits\Controllers\AjaxFieldsChangerTrait;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth;
use Meta;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use FlashMessages;
use Datatables;
use DB;
use Redirect;

class ProductController extends BackendController
{
    use AjaxFieldsChangerTrait;

    /**
     * @var string
     */
    public $module = "product";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $accessMap = [
        'index'           => 'product.read',
        'create'          => 'product.create',
        'store'           => 'product.create',
        'show'            => 'product.read',
        'edit'            => 'product.read',
        'update'          => 'product.write',
        'destroy'         => 'product.delete',
        'ajaxFieldChange' => 'product.write',
    ];

    public function __construct(ResponseFactory $response)
    {
        parent::__construct($response);

        Meta::title(trans('labels.products'));

        $this->breadcrumbs(trans('labels.products'), route('admin.product.index'));

        $this->middleware('slug.set', ['only' => ['store', 'update']]);
    }

    public function index(Request $request)
    {
        if ($request->get('draw')) {
            $list = Product::with(['category'])->withTranslations()->joinTranslations('products', 'product_translations')
                ->select(
                'products.id',
                'product_translations.name',
                'price',
                'volume',
                'category_id',
                'status',
                'position',
                'parent_id',
                'slug'
            );

            return $dataTables = Datatables::of($list)
                ->filterColumn('id', 'where', 'products.id', '=', '$1')
                ->filterColumn('product_translations.name', 'where', 'product_translations.name', 'LIKE', '%$1%')
                ->filterColumn('price','where','price','LIKE','%$1%')
                ->filterColumn('volume','where','volume','LIKE','%$1%')
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
                ->removeColumn('image')
                ->removeColumn('description')
                ->removeColumn('category_id')
                ->removeColumn('category')
                ->make();
        }

        $this->_fillAdditionTemplateData();

        $this->data('page_title', trans('labels.products'));
        $this->breadcrumbs(trans('labels.products_list'));
        return $this->render('views.product.index');
    }

    public function create()
    {
        $this->_fillAdditionTemplateData();

        $this->data('model', new Product);

        $this->data('page_title', trans('labels.product_create'));

        $this->breadcrumbs(trans('labels.product_create'));

        return $this->render('views.product.create');
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
        $input['category_id'] = $input['category_id'] !== '' ? $input['category_id'] : null;

        DB::beginTransaction();

        try {
            $model = new Product($input);
            //prd($model);
            $model->save();

            //$this->pageService->setExternalUrl($model);

            DB::commit();

            FlashMessages::add('success', trans('messages.save_ok'));

            return Redirect::route('admin.product.index');
        } catch (Exception $e) {
            DB::rollBack();

            FlashMessages::add('error', trans('messages.save_failed'));

            return Redirect::back()->withInput();
        }
    }


    /**
     * Display the specified resource.
     * GET /product/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        return $this->edit($id);
    }

    public function edit($id)
    {
        try {
            $model = Product::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            FlashMessages::add('error', trans('messages.record_not_found'));

            return Redirect::route('admin.product.index');
        }

        $this->data('page_title', '"'.$model->name.'"');

        $this->breadcrumbs(trans('labels.product_editing'));

        $this->_fillAdditionTemplateData($model);

        return $this->render('views.product.edit', compact('model'));
    }


    public function update(Request $request, $id)
    {
        try {
            $model = Product::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            FlashMessages::add('error', trans('messages.record_not_found'));

            return Redirect::route('admin.product.index');
        }

        $input = $request->all();
        $input['parent_id'] = isset($input['parent_id']) ? $input['parent_id'] : null;
        $input['category_id'] = $input['category_id'] !== '' ? $input['category_id'] : null;

        DB::beginTransaction();

        try {
            $model->fill($input);

            $model->update();

            DB::commit();

            FlashMessages::add('success', trans('messages.save_ok'));

            return Redirect::route('admin.product.index');
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

        return Redirect::route('admin.product.index');
    }

    private function _fillAdditionTemplateData($model = null)
    {
        if ($model) {
            $list = Category::with('translations')->get();
        } else {
            $list = Category::with('translations')->get();
        }
        $categories = [null => trans('labels.no')];
        foreach ($list as $item) {
            $categories[$item->id] = $item->name;
        }
        $this->data('categories', $categories);
    }
}
