<?php

namespace App\Services;

use Exception;
use App\Project;
use App\ProjectUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProjectService
{
    private $project;

    /**
     * Create a new project service instance.
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function create($attributes)
    {
        DB::beginTransaction();

        try
        {
            $this->saveProject($attributes);
            // $this->saveProjectUser();
            
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function saveProject($attributes)
    {
        $this->project = new Project();
        $this->project->fill($attributes);
        $this->project->company_id = Auth::user()->company->id;

        $this->project->save();
    }

    private function saveProjectUser()
    {
        $projectUser = new ProjectUser();
        $projectUser->user_id = Auth::user()->id;
        $projectUser->project_id = $this->project->id;

        $projectUser->save();
    }
}
