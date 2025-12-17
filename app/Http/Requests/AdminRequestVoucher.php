<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequestVoucher extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('id');
        $uniqueCode = 'unique:vouchers,vc_code';
        if ($id) {
            $uniqueCode .= ',' . $id;
        }

        return [
            'vc_name' => 'required|string|min:3|max:190',
            'vc_code' => 'required|string|min:3|max:50|' . $uniqueCode,
            'vc_type' => 'required|in:1,2',
            'vc_value' => 'required|integer|min:1',
            'vc_max_discount' => 'nullable|integer|min:1',
            'vc_quantity' => 'nullable|integer|min:0',
            'vc_started_at' => 'nullable|date',
            'vc_ended_at' => 'nullable|date|after_or_equal:vc_started_at',
            'vc_status' => 'required|in:0,1',
        ];
    }

    public function messages()
    {
        return [
            'vc_name.required' => 'Tên voucher không được để trống',
            'vc_code.required' => 'Mã voucher không được để trống',
            'vc_code.unique' => 'Mã voucher đã tồn tại',
            'vc_type.required' => 'Chọn loại voucher',
            'vc_value.required' => 'Giá trị voucher không được để trống',
            'vc_value.integer' => 'Giá trị voucher phải là số',
            'vc_max_discount.integer' => 'Giá trị giảm tối đa phải là số',
            'vc_quantity.integer' => 'Số lượng phải là số',
            'vc_ended_at.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu',
            'vc_status.required' => 'Chọn trạng thái',
        ];
    }
}
