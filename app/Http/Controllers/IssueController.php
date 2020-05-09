<?php

namespace App\Http\Controllers;

use App\Http\Requests\IssueRequest;
use App\Issue;
use App\Project;
use App\Services\IssueService;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IssueController extends Controller
{
    private $issueService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(IssueService $issueService)
    {
        $this->middleware(['auth', 'companyAuthorization']);
        // $this->authorizeResource(Project::class, 'project');
        $this->issueService = $issueService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $issues = Issue::with('assignee')
            ->whereHas('project', function($query){
                $query->where('company_id', Auth::user()->company_id);
            })
            ->orderBy('subject', 'asc')->paginate(15);

        return view('issue.index', compact('issues'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = (new Project)->getProjectsByCompany(Auth::user()->company_id)->pluck('name', 'id');
        
        return view('issue.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IssueRequest $request)
    {
        try
        {
            $this->issueService->attributes = $request->validated();
            $this->issueService->create();
        }
        catch (Exception $e) {
            logger($e);
            return back()->with('error', 'Oops something went wrong!')->withInput();
        }

        return redirect()->route('issue.index')->with('success', 'Issue created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function show(Issue $issue)
    {
        return view('issue.show', compact('issue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function edit(Issue $issue)
    {
        $projects = (new Project)->getProjectsByCompany(Auth::user()->company_id)->pluck('name', 'id');
        
        return view('issue.edit', compact('issue', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function update(IssueRequest $request, Issue $issue)
    {
        try
        {
            $this->issueService->setIssue($issue);
            $this->issueService->attributes = $request->validated();
            $this->issueService->update();
        }
        catch (Exception $e) {
            logger($e);
            return back()->with('error', 'Oops something went wrong!')->withInput();
        }

        return redirect()->route('issue.index')->with('success', 'Issue updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue)
    {
        //
    }
}
