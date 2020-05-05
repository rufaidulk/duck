<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\ProjectRequest;
use App\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;

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
        // $this->authorizeResource(Company::class, 'company');
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::orderBy('name', 'asc')->paginate(15);

        return view('project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        try{       
            $this->projectService->create($request->validated());
        }
        catch (Exception $e) {
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
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
