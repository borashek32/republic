<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateCategoryUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {

        $categories = config('model-types.types');

        return [
            'post_id'        => 'reuqired|exists:posts,id',
            'postable_type'  => 'bail|required|string|in:' . implode(',', array_keys($categories)),
            'postable_id'    =>  Rule::exists($categories[$this->postable_type], 'id')
        ];
    }
}
