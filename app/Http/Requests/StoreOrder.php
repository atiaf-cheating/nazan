<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrder extends FormRequest
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
            'status' => 'required',
            'merchant_id' => 'required',
            'customer_name' => 'required',
            'customer_email' => 'required',
            'customer_phone' => 'required',
            'city_id' => 'required',
            'parent_city_id' => 'required',
            'city_arabic_name' => 'required',
            'city_english_name' => 'required',
            'street' => 'required',
            'building_number' => 'required',
            'coupon_code' => 'required',
            'coupon_discount percentage' => 'required',
            'coupon_expiry_date' => 'required',
        ];
    }
}
