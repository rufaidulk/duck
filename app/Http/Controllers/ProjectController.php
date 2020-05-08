<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Project;
use App\ProjectUser;
use App\Services\ProjectService;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    private $projectService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProjectService $projectService)
    {
        $this->middleware(['auth', 'companyAuthorization']);
        $this->authorizeResource(Project::class, 'project');
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::where('company_id', Auth::user()->company_id)
                        ->orderBy('name', 'asc')->paginate(15);

        return view('project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = (new User)->getUsersByCompanyId(Auth::user()->company_id)->pluck('email', 'id');
        
        return view('project.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        try
        {       
            $this->projectService->attributes = $request->validated();
            $this->projectService->create();
        }
        catch (Exception $e) {throw $e;
            logger($e);
            return back()->with('error', 'Oops something went wrong!')->withInput();
        }

        return redirect()->route('project.index')->with('success', 'Project created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $users = $project->getProjectUsersGroupByRole($project->id);
        
        return view('project.show', compact('project', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $users = (new User)->getUsersByCompanyId(Auth::user()->company_id)->pluck('email', 'id');
        
        return view('project.edit', compact('project', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        try
        {       
            $this->projectService->setProject($project);
            $this->projectService->attributes = $request->validated();
            $this->projectService->update();
        }
        catch (Exception $e) {
            logger($e);
            return back()->with('error', 'Oops something went wrong!')->withInput();
        }

        return redirect()->route('project.index')->with('success', 'Project updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
