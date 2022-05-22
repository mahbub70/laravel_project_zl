<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\Console\Input\Input;

class ProductRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
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
            'category_id'=>'required|integer',
            'brand'=>'bail|required|alpha|max:30',
            'model'=>'bail|required|max:50',
            'title'=>'bail|required|max:100',
            'color'=>'bail|alpha_space_comma|max:100',
            'description'=>'bail|required|max:5000',
            'price'=>'bail|required|numeric|digits_between:0,11',
            'image.*'=>'required|mimes:png,jpg,jpeg,svg',
            'phone'=>'nullable',
            'discount'=>'bail|nullable|numeric|digits_between:0,100',
            'optional_phone'=>'bail|nullable|numeric|digits_between:11,11',
        ];
    }

    public function messages(){
        return [
            'category_id.required'=>'Please select <strong>caetgory</strong>',
            'category_id.integer'=>'Invalid Category.',
            'brand.required'=>'Please enter product <strong>brand</strong>.',
            'brand.alpha'=>'Brand is <strong>not valid</strong>.',
            'brand.max'=>'Brand contains <strong>maximam 30 characters.</strong>',
            'model.required'=>'Please enter product <strong>model</strong>.',
            'model.max'=>'Model contains <strong>maximam 50 characters</strong>.',
            'title.required'=>'Please enter your <strong>title</strong>.',
            'title.max'=>'Title contains <strong>maximam 100 characters</strong>.',
            'color.alpha_space_comma'=>'Multiple color seperated by <strong>comma</strong>.',
            'color.max'=>'Color contains <strong>maximam 100 characters</strong>.',
            'description.required'=>'Please enter product <strong>description</strong>.',
            'description.max'=>'Description contains <strong>maximam 5000 characters</strong>.',
            'price.required'=>'Plese enter product <strong>price</strong>.',
            'price.numeric'=>'This price is <strong>not valid</strong>.',
            'price.digits_between'=>'Price contains <strong>maximam 11 digits</strong>.',
            'image.*.required'=>'Pelase select product <strong>image</strong>.',
            'image.*.mimes'=>'Image must be type of <strong>jpg,jpeg,png,svg</strong>.',
            'discount.numeric'=>'Discount is <strong>not valid</strong>.',
            'discount.digits_between'=>'Discount is <strong>not valid</strong>.',
            'optional_phone.numeric'=>'This phone number is <strong>not valid</strong>.',
            'optional_phone.digits_between'=>'This phone number is <strong>not valid</strong>.',
        ];
    }
}
