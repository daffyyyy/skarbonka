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
                'required_unless:unlimited_amount,on',
                'numeric',
                'nullable',
                'max:10000',
            ],
            'unlimited_amount' => [
                'sometimes',
            ],
            'cost' => [
                'required_unless:unlimited_cost,on',
                'numeric',
                'nullable',
                'max:5',
            ],
            'unlimited_cost' => [
                'sometimes',
            ],
            'contact' => [
                'required',
                'string',
                'min:8',
                'max:512',
            ],
            'type' => [
                'in:1,2',
                'required',
                'numeric',
            ],
            'category_id' => [
                'required',
                'numeric',
                'exists:announcements_category,id'
            ],
        ];
    }
}
