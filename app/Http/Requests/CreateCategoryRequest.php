<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'data'=>'required',
            'data.attributes'=>'required',
            'data.attributes.name'=>'required|string',
            'data.attributes.slug'=>'required|string',
            'data.attributes.province'=>'required',
            'data.attributes.district'=>'required',
            'data.attributes.subdistrict'=>'required',
            'data.attributes.street'=>'required',
            'data.atributes.suggestion_price'=>'required',
            'data.author'=>'required',
        ];
    }
}
