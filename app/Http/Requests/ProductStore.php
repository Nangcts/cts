<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStore extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'chkCategory' => 'required',
            'iptName'   => 'required',
            'iptCustomSlug' => 'unique:article,slug|unique:cate,slug|unique:categories,slug|unique:products,slug',
        ];

        foreach($this->request->get('iptPrice') as $key => $val)
        {
            $rules['iptPrice.'.$key] = 'required|integer';
        }
        foreach($this->request->get('iptSalePrice') as $key => $val)
        {
            $rules['iptSalePrice.'.$key] = 'integer';
        }
        foreach($this->request->get('iptImages') as $key => $val)
        {
            $rules['iptImages.'.$key] = 'required|image';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'chkCategory.required' => 'Chưa chọn danh mục',
            'iptName.required'    => 'Chưa nhập tên sản phẩm',
            'iptCustomSlug.unique'    => 'Đường dẫn đã tồn tại',
        ];
        foreach($this->request->get('iptPrice') as $key => $val)
        {
            $messages['iptPrice.'.$key.'.required'] = 'Trường "Giá bán thứ:  '.$key.'" chưa được nhập';
            $messages['iptPrice.'.$key.'.integer'] = 'Trường "Giá bán thứ:  '.$key.'" phải là số nguyên dương';
        }
        foreach($this->request->get('iptSalePrice') as $key => $val)
        {
            $messages['iptSalePrice.'.$key.'.integer'] = 'Trường "Giá khuyến mãi thứ:  '.$key.'" phải là số nguyên dương';
        }
        foreach($this->request->get('iptImages') as $key => $val)
        {
            $messages['iptImages.'.$key.'.required'] = 'Ảnh sản phẩm thứ: '.$key.'" chưa được nhập';
            $messages['iptImages.'.$key.'.image'] = 'Ảnh sản phẩm thứ: '.$key.'" không hợp lệ, vui lòng chọn file ảnh';
        }
        return $messages;
    }
}
