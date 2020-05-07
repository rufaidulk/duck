<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|max:255|min:8',
            'role' => 'required',
            'status' => [
                'required',
                Rule::in(array_keys(config('params.user.status')))
            ]
        ];
    }

    /**
     * @return array
     */
    private function updateRules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required', 'string', 'max:255',
                Rule::unique('users')->ignore($this->route('user')),
            ],
            'password' => 'nullable|string|max:255|min:8',
            'role' => 'required',
            'status' => [
                'required',
                Rule::in(array_keys(config('params.user.status')))
            ]
        ];
    }
}
