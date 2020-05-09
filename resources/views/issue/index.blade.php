@extends('layouts.main')
   
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="float-left">Issues</h5>
        <a href="{{ route('issue.create') }}" class="btn btn-primary float-right">Add</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Project</th>
                                <th>Subject</th>
                                <th>Tracker</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Assignee</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $index = 1;
                        @endphp
                        @foreach($issues as $issue)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ ucfirst($issue->project->name) }}</td>
                                <td>{{ ucfirst($issue->subject) }}</td>
                                <td>{{ ucfirst(config('params.tracker')[$issue->tracker]) }}</td>
                                <td>{{ ucfirst(config('params.priority')[$issue->priority]) }}</td>
                                <td>{{ ucfirst(config('params.issue.status')[$issue->status]) }}</td>
                                <td>{{ ucfirst($issue->assignee->name) }}</td>
                                <td>{{ date('d M Y', strtotime($issue->created_at)) }}</td>
                                <td>{{ date('d M Y', strtotime($issue->updated_at)) }}</td>
                                <td style="display: inline-flex;">
                                    <a href="{{ route('issue.show', $issue->id) }} " 
                                        class="btn btn-info mr-1">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('issue.edit', $issue->id) }} " 
                                        class="btn btn-success mr-1">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <form action="{{ route('issue.destroy', $issue->id)}}" 
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
                    {!! $issues->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection  
