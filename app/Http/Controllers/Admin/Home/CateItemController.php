<?php

namespace App\Http\Controllers\Admin\Home;

use App\Model\CateItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Files;
use Validator;
use Excption;
use DB;

class CateItemController extends Controller
{
    use Files;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cate_items = CateItem::all();
        return view('admin.settings.cate_item.index', compact('cate_items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cate_items = null;
        return view('admin.settings.cate_item.add', compact('cate_items'));
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
        
        $upload = $this->upload($request->file);
        if ($upload) {
            $request['image_src'] = config('filesystems.url') . $upload;
            // 上传成功
            DB::beginTransaction();
            try{

                CateItem::create($request->except('_token'));
                DB::commit();
                $cate_items = CateItem::all();
                return view('admin.settings.cate_item.index', compact('cate_items'));
                // return response()->json(['code' => '200', '保存成功']);
            }catch(Exception $e) {
                DB::rollBack();
                return response()->json(['code' => '0', '保存失败', 'data' => $e->getMessage()]);
            }
        } else {
            return response()->json('fail', 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\CateItem  $cateItem
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\CateItem  $cateItem
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
     * @param  \App\Model\CateItem  $cateItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\CateItem  $cateItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cateItem = CateItem::where('id', $id)->first();
        $isDeleted = $this->deleteFile(basename($cateItem->image_src));
        if ($isDeleted) {
            $cateItem->delete();
        }
    }

    public function m_validate($input)
    {
        $rules = [
            'name' => 'required|max:255',
            'navigator_url' => 'required|max:255',
            'open_type' => 'required',
            'file'      => 'required|image'
        ];
        // 自定义验证信息
        $messages = [
            'name.required' => '名称不能为空',
            'navigator_url.required' => '跳转链接不能为空',
            'file.image'    => '只能上传图片文件'
        ];
        // 验证
        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        return false;
    }
}
