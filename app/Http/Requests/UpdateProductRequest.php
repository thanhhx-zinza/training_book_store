<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            "name" => "required|unique:products,name,".$this->id,
            "description" => "required",
            'price' => "required|numeric",
            'slug' => "unique:products,slug",
            "image" => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ];
    }
}
