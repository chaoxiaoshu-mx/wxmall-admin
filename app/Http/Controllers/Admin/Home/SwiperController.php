<?php

namespace App\Http\Controllers\Admin\Home;

use App\Model\Swiper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Validator;

class SwiperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home_setting.swiper');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.home_setting.swiper-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'navigator_url' => 'required|max:255',
            'open_type' => 'required',
            'goods_id' => 'required|numeric|min:1',
        ]);
 
        $uploadSuccess = $this->upload($request->file);
        if ($uploadSuccess) {
            // 上传成功
            return response()->json('success', 200);
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
    public function edit(Swiper $swiper)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Swiper  $swiper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Swiper $swiper)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Swiper  $swiper
     * @return \Illuminate\Http\Response
     */
    public function destroy(Swiper $swiper)
    {
        //
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
            return $bool;
        }
    }
}
