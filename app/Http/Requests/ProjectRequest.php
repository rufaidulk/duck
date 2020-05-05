<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return $this->createRules();
        }

        return $this->updateRules();
    }

    /**
     * @return array
     */
    private function createRules()
    {
        return [
            'name' => 'required|unique:projects|string|max:255',
            'description' => 'required|string|max:255',
            'status' => [
                'required',
                Rule::in(array_keys(config('params.project.status')))
            ]
        ];
    }

    /**
     * @return array
     */
    private function updateRules()
    {
        // return [
        //     'name' => [
        //         'required',
        //         'string', 'max:255',
        //         Rule::unique('companies')->ignore($this->route('company')),
        //     ],
        //     'description' => 'required|string|max:255',
        //     'user_id' => 'required|exists:users,id'
        // ];
    }
}
