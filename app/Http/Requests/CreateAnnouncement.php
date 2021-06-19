<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAnnouncement extends FormRequest
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
            'title' => [
                'required',
                'min:8',
                'max:64',
                'string',
            ],
            'description' => [
                'required',
                'string',
            ],
            'amount' => [
                'required',
                'numeric',
            ],
            'cost' => [
                'required',
                'numeric',
            ],
            'contact' => [
                'required',
                'string',
                'min:8',
                'max:512',
            ],
            'cost' => [
                'required',
                'numeric',
            ],
            'category_id' => [
                'required',
                'numeric',
            ],
        ];
    }
}
