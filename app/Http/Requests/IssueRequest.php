<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class IssueRequest extends FormRequest
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
            'project_id' => [
                'required',
                Rule::exists('projects', 'id')->where(function($query){
                    $query->where('company_id', Auth::user()->company_id);
                }),
            ],
            'subject' => [
                'required',
                'string',
                'max:255',
                Rule::unique('issues')->where(function($query){
                    $query->where('project_id', $this->project_id);
                }),
            ],
            'description' => 'required|string|max:255',
            'tracker' => [
                'required',
                Rule::in(array_keys(config('params.tracker')))
            ],
            'priority' => [
                'required',
                Rule::in(array_keys(config('params.priority')))
            ],
            'parent_issue_id' => [
                'nullable',
                Rule::exists('issues', 'id')->where(function($query){
                    $query->where('project_id', $this->project_id);
                }),
            ],
            'status' => [
                'required',
                Rule::in(array_keys(config('params.issue.status')))
            ],
            'assignee_user_id' => [
                'required',
                Rule::exists('users', 'id')->where(function($query){
                    $query->where('company_id', Auth::user()->company_id);
                }),
            ],
            'estimated_time' => 'nullable|numeric',
            'due_date' => 'nullable|date'
        ];
    }

    /**
     * @return array
     */
    private function updateRules()
    {
        return [
            'project_id' => [
                'required',
                Rule::exists('projects', 'id')->where(function($query){
                    $query->where('company_id', Auth::user()->company_id);
                }),
            ],
            'subject' => [
                'required',
                'string',
                'max:255',
                Rule::unique('issues')->ignore($this->route('issue'))
                    ->where(function($query){
                        $query->where('project_id', $this->project_id);
                    }),
            ],
            'description' => 'required|string|max:255',
            'tracker' => [
                'required',
                Rule::in(array_keys(config('params.tracker')))
            ],
            'priority' => [
                'required',
                Rule::in(array_keys(config('params.priority')))
            ],
            'parent_issue_id' => [
                'nullable',
                Rule::exists('issues', 'id')->where(function($query){
                    $query->where('project_id', $this->project_id);
                }),
            ],
            'status' => [
                'required',
                Rule::in(array_keys(config('params.issue.status')))
            ],
            'assignee_user_id' => [
                'required',
                Rule::exists('users', 'id')->where(function($query){
                    $query->where('company_id', Auth::user()->company_id);
                }),
            ],
            'estimated_time' => 'nullable|numeric',
            'due_date' => 'nullable|date'
        ];
    }
}
