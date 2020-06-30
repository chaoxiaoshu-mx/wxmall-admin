<?php

namespace App\Http\Controllers\Admin\Home;

use App\Model\Swiper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Traits\Files;
use Validator;
use Excption;
use DB;
use App\Http\Requests\SwiperValidate;

class SwiperController extends Controller
{
    use Files;

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
    public function store(Request $request)
    {

        $validator = $this->m_validate($request->all());
        if ($validator){
            return $validator;
        }

        $upload = $this->upload($request->file);
        if ($upload) {
            $request['image_src'] = config('filesystems.url') . $upload;
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
        $swiper = Swiper::where('id', $id)->first();
        $swiper->delete();
        $isDeleted = $this->deleteFile(basename($swiper->image_src));
        if ($isDeleted) {
            $swiper->delete();
        }
    }   

    public function m_validate($input)
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
            'goods_id.required' => '商品ID不能为空',
            'goods_id.min' => '商品ID必须是大于0的数字',
        ];
        // 验证
        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } 
        return false;
    }
    

}
