<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
            'name'=>['bail','required','max:35'],
            'image'=>'mimes:jpg,png,jpeg,svg',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Please enter your <strong>category name</strong>.',
            'name.max'=>'Name can be contains <strong>maximum 35 characters</strong>.',
            'image.mimes'=>'Make sure your image is <strong>jpg, jpeg, png or svg</strong>.',
        ];
    }
}
