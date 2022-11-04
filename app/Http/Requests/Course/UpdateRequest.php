<?php

namespace App\Http\Requests\Course;

use App\Models\Course;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => [
                'bail',
                'required',
                'string',
                 Rule::unique(Course::class)->ignore($this->course),
            ],
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute Bắt buộc phải điền',
            'unique' => ':attribute đã được dùng ',
        ];
    }

    public function attributes()
    {
         return [
            'name' => 'Name',
        ];
    }
}