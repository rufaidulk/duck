@extends('layouts.main')
   
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="float-left">Projects</h5>
        <a href="{{ route('project.create') }}" class="btn btn-primary float-right">Add</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $index = 1;
                        @endphp
                        @foreach($projects as $project)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ ucfirst($project->name) }}</td>
                                <td>{{ ucfirst($project->description) }}</td>
                                <td>{{ ucfirst($project->status) }}</td>
                                <td>{{ date('d M Y', strtotime($project->created_at)) }}</td>
                                <td>{{ date('d M Y', strtotime($project->updated_at)) }}</td>
                                <td style="display: inline-flex;">
                                    <a href="{{ route('project.edit', $project->id) }} " 
                                        class="btn btn-info mr-1">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <form action="{{ route('project.destroy', $project->id)}}" 
                                        method="post">
                                        {{ csrf_field() }}
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $projects->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection  
