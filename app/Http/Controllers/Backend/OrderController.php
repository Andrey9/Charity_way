<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order_item;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Traits\Controllers\AjaxFieldsChangerTrait;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Models\Order;
use FlashMessages;
use Datatables;
use Redirect;
use Meta;
use DB;

/**
 * Class OrderController
 * @package App\Http\Controllers\Backend
 */
class OrderController extends BackendController
{
    use AjaxFieldsChangerTrait;

    public $module = "order";

    public $accessMap = [
        'index'           => 'order.read',
        'create'          => 'order.create',
        'store'           => 'order.create',
        'show'            => 'order.read',
        'edit'            => 'order.read',
        'update'          => 'order.write',
        'destroy'         => 'order.delete',
        'ajaxFieldChange' => 'order.write',
    ];

    /**
     * OrderController constructor.
     * @param ResponseFactory $response
     */
    public function __construct(ResponseFactory $response)
    {
        parent::__construct($response);

        Meta::title(trans('labels.orders'));

        $this->breadcrumbs(trans('labels.orders'), route('admin.order.index'));

        $this->middleware('slug.set', ['only' => ['store', 'update']]);
    }

    /**
     * Display a listing of the resource.
     * GET /order
     *
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {
        if ($request->get('draw')) {
            $list = Order::select(
                'orders.id',
                'status',
                'comment',
                'created_at'
            );

            return $dataTables = Datatables::of($list)
                ->filterColumn('id', 'where', 'orders.id', '=', '$1')
                ->editColumn(
                    'created_at',
                    function ($model) {
                        return $model->created_at->format('d.m.y H:i:s');
                    }
                )
                ->editColumn(
                    'status',
                    function ($model) {
                        return trans('labels.'.$model->status);
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

        $this->data('page_title', trans('labels.orders'));
        $this->breadcrumbs(trans('labels.orders_list'));

        return $this->render('views.order.index');
    }

    /**
     * Show the form for creating a new resource.
     * GET /order/create
     *
     * @return $this
     */
    public function create()
    {
        $this->_fillAdditionTemplateData();

        $this->data('model', new Order);

        $this->data('page_title', trans('labels.order_create'));

        $this->breadcrumbs(trans('labels.order_create'));

        return $this->render('views.order.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST /order
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $input = $request->all();

        DB::beginTransaction();

        try {
            $model = new Order($input);

            $model->save();

            $this->_processItems($model);

            DB::commit();

            FlashMessages::add('success', trans('messages.save_ok'));

            return Redirect::route('admin.order.index');
        } catch (Exception $e) {
            DB::rollBack();

            FlashMessages::add('error', trans('messages.save_failed'));

            return Redirect::back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     * GET /order/{id}
     *
     * @param $id
     * @return $this
     */
    public function show($id)
    {
        return $this->edit($id);
    }

    /**
     * Show the form for editing the specified resource.
     * GET /order/{id}/edit
     *
     * @param $id
     * @return $this
     */
    public function edit($id)
    {
        try {
            $model = Order::with(['order_items', 'order_items.product', 'order_items.product'])->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            FlashMessages::add('error', trans('messages.record_not_found'));

            return Redirect::route('admin.order.index');
        }

        $this->data('page_title', trans('labels.order').' №'.$model->id);

        $this->breadcrumbs(trans('labels.order_editing'));

        $this->_fillAdditionTemplateData($model);

        return $this->render('views.order.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     * PUT /order/{id}
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        try {
            $model = Order::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            FlashMessages::add('error', trans('messages.record_not_found'));

            return Redirect::route('admin.order.index');
        }

        $input = $request->all();

        DB::beginTransaction();

        try {
            $model->fill($input);

            $model->update();

            $this->_processItems($model);

            DB::commit();

            FlashMessages::add('success', trans('messages.save_ok'));

            return Redirect::route('admin.order.index');
        } catch (Exception $e) {
            DB::rollBack();

            FlashMessages::add("error", trans('messages.update_error').': '.$e->getMessage());

            return Redirect::back()->withInput($input);
        }
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /order/{id}
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        try {
            $model = Order::findOrFail($id);

            if (!$model->delete()) {
                FlashMessages::add("error", trans("messages.destroy_error"));
            } else {
                FlashMessages::add('success', trans("messages.destroy_ok"));
            }
        } catch (ModelNotFoundException $e) {
            FlashMessages::add('error', trans('messages.record_not_found'));
        }

        return Redirect::route('admin.order.index');
    }

    /**
     * set to template addition variables for add\update order
     *
     * @param null $model
     */
    private function _fillAdditionTemplateData($model = null)
    {
        /*$list = Product::with('translations')->get();

        $products = ['' => trans('labels.no')];

        foreach ($list as $item)
        {
            $products[$item->id] = $item->name.' | '.$item->volume.trans('labels.ml').' | '.$item->price.trans('labels.grn');
        }

        $this->data('products',$products);*/
    }

    /**
     * @param \App\Models\Order $model
     */
    private function _processItems(Order $model)
    {

        $data = request('items.remove', []);
        //dd($data);
        foreach ($data as $id) {
            try {
                $item = $model->order_items()->findOrFail($id);
                $item->delete();
            } catch (Exception $e) {
                FlashMessages::add("error", trans("messages.item destroy failure"." ".$id.". ".$e->getMessage()));
                continue;
            }
        }

        $data = request('items.old', []);
        foreach ($data as $key => $item) {
            try {
                $_item = Order_item::findOrFail($key);
                $_item->update($item);
            } catch (Exception $e) {
                FlashMessages::add(
                    "error",
                    trans("messages.item update failure"." ".$item['name'].". ".$e->getMessage())
                );
                continue;
            }
        }

        $data = request('items.new', []);
        foreach ($data as $item) {
            try {
                $item = new Order_item($item);
                $model->order_items()->save($item);
            } catch (Exception $e) {
                FlashMessages::add(
                    "error",
                    trans("messages.item save failure"." ".$item['name'].". ".$e->getMessage())
                );
                continue;
            }
        }
    }

    public function find_products(Request $request)
    {
        $value = $request->input('value');
        $products = [];
        if ($value[0] == '#'){
            $products = Product::distinct()
                ->joinTranslations('products')
                ->where('products.id', '=', ltrim($value, '#'))
                ->select(
                    'products.id',
                    'products.price',
                    'products.volume',
                    'product_translations.name'
                )
                ->get();
        }
        else {
            $products = Product::distinct()
                ->joinTranslations('products')
                ->where('product_translations.name', 'LIKE', "%$value%")
                ->select(
                    'products.id',
                    'products.price',
                    'products.volume',
                    'product_translations.name'
                )
                ->get();
        }

        return view('partials.find_products.index', compact('products'))->render();
    }

    public function add_product(Request $request)
    {

//            return $request->get('id');

        $product = Product::with('translations')->findOrFail($request->get('id'));
        $pos = $request->get('pos');
        return view('partials.find_products.add', compact('product', 'pos'))->render();

    }
}
