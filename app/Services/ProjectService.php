<?php

namespace App\Services;

use Exception;
use App\Project;
use App\ProjectUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProjectService
{
    public $attributes;
    private $project;

    /**
     * Create a new project service instance.
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function setProject(Project $project)
    {
        $this->project = $project;   
    }

    public function create()
    {
        DB::beginTransaction();

        try
        {
            $this->saveProject();
            $this->project->users()->attach($this->attributes['user_id']);
            
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update()
    {
        DB::beginTransaction();

        try
        {
            $this->saveProject();
            $this->project->users()->sync($this->attributes['user_id']);
            
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function saveProject()
    {
        $this->project = $this->project ?? new Project();
        $this->project->fill($this->attributes);
        $this->project->company_id = Auth::user()->company->id;

        $this->project->save();
    }
}
