<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class novel extends FormRequest
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
            'name' => 'bail|required|unique:novels|max:255',
            'desc' => 'bail|required',
            'author' => 'bail|required',
            'card_id' => 'bail|required',
            'pic' => 'bail|required',
        ];
    }
}
