<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SwiperValidate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'navigator_url' => 'required|max:255',
            'open_type' => 'required',
            'goods_id' => 'required|numeric|min:1',
            'file'      => 'required|image'
        ];
    }

    public function messages()
    {
        return [
            'navigator_url.required' => '跳转链接不能为空',
            'goods_id.min' => '商品ID必须是大于0的数字',
            'file.image'    => '只能上传图片文件'
        ];
    }
}
