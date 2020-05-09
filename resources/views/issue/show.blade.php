@extends('layouts.main')
   
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="float-left">Issue: {{ ucfirst($issue->subject) }}</h5>
        <div class="float-right">
            <a href="{{ route('issue.edit', $issue->id) }} " class="btn btn-success mr-1">
                <i class="fa fa-pen"></i>
            </a>
            <form class="float-right" action="{{ route('issue.destroy', $issue->id)}}" method="post">
                {{ csrf_field() }}
                @method('DELETE')
                <button class="btn btn-danger" type="submit">
                    <i class="fa fa-trash"></i>
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Project</th>
                                <td>{{ ucfirst($issue->project->name) }}</td>
                            </tr>
                            <tr>
                                <th>Subject</th>
                                <td>{{ ucfirst($issue->subject) }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $issue->description }}</td>
                            </tr>
                            <tr>
                                <th>Assignee</th>
                                <td>{{ ucfirst($issue->assignee->name) }}</td>
                            </tr>
                            <tr>
                                <th>Author</th>
                                <td>{{ ucfirst($issue->author->name) }}</td>
                            </tr>
                            <tr>
                                <th>Parent Issue</th>
                                <td>
                                    @if($issue->parentIssue)
                                        {{ $issue->parentIssue->subject }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Due Date</th>
                                <td>{{ date('d M Y', strtotime($issue->due_date)) }}</td>
                            </tr>
                            <tr>
                                <th>Estimated time</th>
                                <td>
                                    @if($issue->estimated_time)
                                        {{ $issue->estimated_time . ' Hrs' }}
                                    @else
                                        {{ '0 Hrs' }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Tracker</th>
                                <td>{{ ucfirst(config('params.tracker')[$issue->tracker]) }}</td>
                            </tr>
                            <tr>
                                <th>Priority</th>
                                <td>{{ ucfirst(config('params.priority')[$issue->priority]) }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ ucfirst(config('params.issue.status')[$issue->status]) }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ date('d M Y', strtotime($issue->created_at)) }}</td>
                            </tr>
                            <tr>
                                <th>Update At</th>
                                <td>{{ date('d M Y', strtotime($issue->updated_at)) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection  
