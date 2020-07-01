<?php

namespace App\Http\Controllers\Admin\Home;

use App\Model\Floor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Files;
use Validator;
use Excption;
use DB;

class FloorController extends Controller
{
    use Files;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $floors = Floor::all();
        return view('admin.settings.floor.index', compact('floors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $floor = null;
        return view('admin.settings.floor.add', compact('floor'));

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

                Floor::create($request->except('_token'));
                DB::commit();
                $floors = Floor::all();
                return view('admin.settings.floor.index', compact('floors'));
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
        $floor = Floor::where('id', $id)->first();
        $isDeleted = $this->deleteFile(basename($floor->image_src));
        if ($isDeleted) {
            $floor->delete();
        }
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
