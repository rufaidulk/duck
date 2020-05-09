<?php

namespace App\Http\Controllers;

use App\Issue;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxFilterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'companyAuthorization']);
    }

    public function projectAssignee(Request $request)
    {
        $users = User::where('name', 'LIKE', '%'. $request->term .'%')
                    ->where('company_id', Auth::user()->company_id)
                    ->get(['id', 'name as text']);
        
        return ['results' => $users];
    }

    public function issue(Request $request)
    {
        $issues = Issue::where('subject', 'LIKE', '%'. $request->term .'%')
                    ->where('project_id', $request->project_id)
                    ->get(['id', 'subject as text']);
        
        return ['results' => $issues];
    }
}
