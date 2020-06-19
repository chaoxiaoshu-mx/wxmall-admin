<?php

namespace App\Http\Controllers\Admin\Home;

use App\Model\Swiper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Validator;
use Excption;
use DB;
use App\Http\Requests\SwiperValidate;

class SwiperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $swipers = Swiper::all();
        return view('admin.settings.swiper.index', compact('swipers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $swiper = null;
        return view('admin.settings.swiper.add', compact('swiper'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SwiperValidate $request)
    {
        // 自定义验证规则
        $rules = [
            'navigator_url' => 'required|max:255',
            'open_type' => 'required',
            'goods_id' => 'required|numeric|min:1',
            'file'      => 'required|image'
        ];
        // 自定义验证信息
        $messages = [
            'navigator_url.required' => '跳转链接不能为空',
            'goods_id.min' => '商品ID必须是大于0的数字',
            'file.image'    => '只能上传图片文件'
        ];
        // 验证
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $upload = $this->upload($request->file);
        if ($upload) {
            $request['image_src'] = '/upload/files/' . $upload;
            // $request->merge('image_src', $upload);  
            // dd($request->except('_token'));
            // 上传成功
            DB::beginTransaction();
            try{

                Swiper::create($request->except('_token'));
                DB::commit();
                $swipers = Swiper::all();
                return view('admin.settings.swiper.index', compact('swipers'));
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
     * @param  \App\Model\Swiper  $swiper
     * @return \Illuminate\Http\Response
     */
    public function show(Swiper $swiper)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Swiper  $swiper
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $swiper = Swiper::find($id);
        if (!$swiper) {
            return null;
        }
        return view('admin.settings.swiper.edit', compact('swiper'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Swiper  $swiper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 自定义验证规则
        $rules = [
            'navigator_url' => 'required|max:255',
            'open_type' => 'required',
            'goods_id' => 'required|numeric|min:1',
        ];
        // 自定义验证信息
        $messages = [
            'navigator_url.required' => '跳转链接不能为空',
            'goods_id.min' => '商品ID必须是大于0的数字',
        ];
        // 验证
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if ($request->file !== null) {
            $upload = $this->upload($request->file);
            $request['image_src'] = '/upload/files/' . $upload;
        }
        DB::beginTransaction();
        try{
            $swiper = Swiper::find($id);
            $result = $swiper -> update($request->except('_token'));

            DB::commit();
            $swipers = Swiper::all();
            return view('admin.settings.swiper.index', compact('swipers'));
            return response()->json(['code' => '200', '保存成功']);
        }catch(Exception $e) {
            DB::rollBack();
            return response()->json(['code' => '0', '保存失败', 'data' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Swiper  $swiper
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $swiper = Swiper::find($id);
        $swiper->delete();
    }   


    public function upload($file)
    {
        // 判断文件是否存在
        if ($file->isValid()){
            // 原文件名
            $originalName = $file->getClientOriginalName();
            // 扩展名
            $ext = $file->getClientOriginalExtension();
            // MimeType
            $type = $file->getClientMimeType();
            // 临时绝对路径
            $realPath = $file->getRealPath();
            $filename = uniqid().'.'.$ext;
            $bool = Storage::disk()->put($filename,file_get_contents($realPath));
            // 是否上传成功
            if ($bool) {
                return $filename;
            }
            return false;
        }
    }

    

}
