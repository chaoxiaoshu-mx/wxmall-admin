<?php
namespace App\Traits;
use Illuminate\Support\Facades\Storage;

Trait Files {



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
            // $bool = $file->move($path, $filename);
            // dd($bool);
            $bool = Storage::disk()->put($filename,file_get_contents($realPath));
            // 是否上传成功
            if ($bool) {
                return $filename;
            }
            return false;
        }
    }

    public function deleteFile($filePath)
    {
    	if (!Storage::disk()->exists($filePath) ||
    		Storage::disk()->delete($filePath)) {
    		return true;
    	} else {
    		return false;
    	}

    	// $bool = Storage::disk()->delete($filePath);
    	// return $bool;
    }
}