@extends('layouts.main')
   
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="float-left">Project: {{ ucfirst($project->name) }}</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ ucfirst($project->name) }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $project->description }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ ucfirst(config('params.project.status')[$project->status]) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mt-5">
    <div class="card-header">
        <h5 class="float-left">Members</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                @foreach($users as $role => $members)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>{{ ucfirst($role) }}</th>
                        </thead>
                        <tbody>
                        @foreach($members as $member)
                            <tr>
                                <td>{{ $member->email }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection  
