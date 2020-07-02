<?php

namespace App\Http\Controllers\Admin\Product;

use App\Model\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Excption;
use DB;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_categorys = ProductCategory::all();
        return view('admin.product.category.index', compact('product_categorys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_category = null;
        return view('admin.product.category.add', compact('product_category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->m_validate($request->all());
        if ($validator){
            return $validator;
        }

        DB::beginTransaction();
        try{

            ProductCategory::create($request->except('_token'));
            DB::commit();
            $product_categorys = ProductCategory::all();
            return view('admin.product.category.index', compact('product_categorys'));
            // return response()->json(['code' => '200', '保存成功']);
        }catch(Exception $e) {
            DB::rollBack();
            return response()->json(['code' => '0', '保存失败', 'data' => $e->getMessage()]);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product_category = ProductCategory::find($id);
        $product_category->delete();
    }

    public function m_validate($input)
    {
        // 自定义验证规则
        $rules = [
            'name' => 'required|max:255',
        ];
        // 自定义验证信息
        $messages = [
            'name.required' => '名称不能为空',
        ];
        // 验证
        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } 
        return false;
    }
}
