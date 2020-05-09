@extends('layouts.main')

@section('content')
<form class="user" method="POST" action="{{ route('issue.update', $issue->id) }}">
    @csrf
    @method('PATCH')
    <div class="card">
        <div class="card-header">
            <h5>Edit : {{ $issue->subject }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="project">Project</label>
                        <select id="project_id" class="select2-enable form-control" name="project_id">
                            <option>Select project</option>
                        @foreach ($projects as $id => $name)
                            <option value="{{ $id }}" {{ $issue->project_id == $id ? "Selected" : "" }}>
                                {{ $name }}
                            </option>
                        @endforeach
                        </select>
                        @error('project_id')
                            <p class="help-block text-danger">{{ $message }} </p>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="tracker">Tracker</label>
                        <select class="select2-enable form-control" name="tracker">
                            <option>Select tracker</option>
                        @foreach (config('params.tracker') as $id => $name)
                            <option value="{{ $id }}" {{ $issue->tracker == $id ? "Selected" : "" }}>
                                {{ $name }}
                            </option>
                        @endforeach
                        </select>
                        @error('tracker')
                            <p class="help-block text-danger">{{ $message }} </p>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="priority">Priority</label>
                        <select class="select2-enable form-control" name="priority">
                            <option>Select priority</option>
                        @foreach (config('params.priority') as $id => $name)
                            <option value="{{ $id }}" {{ $issue->priority == $id ? "Selected" : "" }}>
                                {{ $name }}
                            </option>
                        @endforeach
                        </select>
                        @error('priority')
                            <p class="help-block text-danger">{{ $message }} </p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" name="subject" class="form-control" placeholder="Enter subject" value="{{ $issue->subject }}">
                        @error('subject')
                            <p class="help-block text-danger">{{ $message }} </p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="name">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ $issue->description }}</textarea>
                        @error('description')
                            <p class="help-block text-danger">{{ $message }} </p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="parent issue">Parent Issue</label>
                        <select id="parent-issue" class="form-control" name="parent_issue_id">
                            <option value="">Select parent issue</option>
                        </select>
                        @error('parent_issue_id')
                            <p class="help-block text-danger">{{ $message }} </p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="select2-enable form-control" name="status">
                            <option>Select status</option>
                        @foreach (config('params.issue.status') as $id => $status)
                            <option value="{{ $id }}" {{ $issue->status == $id ? "Selected" : "" }}>
                                {{ $status }}
                            </option>
                        @endforeach
                        </select>
                        @error('status')
                            <p class="help-block text-danger">{{ $message }} </p>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="assignee">Assignee</label>
                        <select id="assignee-user" class="form-control" name="assignee_user_id">
                            <option>Select assignee</option>
                        </select>
                        @error('assignee_user_id')
                            <p class="help-block text-danger">{{ $message }} </p>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="estimated_time">Estimated Time</label>
                        <input type="text" name="estimated_time" class="form-control" placeholder="Enter time in hours" value="{{ $issue->estimated_time }}">
                        @error('estimated_time')
                            <p class="help-block text-danger">{{ $message }} </p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="due_date">Due Date</label>
                        <input type="date" name="due_date" class="form-control" value="{{ $issue->due_date }}" min="{{ date('Y-m-d') }}">
                        @error('due_date')
                            <p class="help-block text-danger">{{ $message }} </p>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>    
</form>

    @section('page-script')
    <script type="text/javascript">

        $('#assignee-user').select2({
            data: [
                {
                    id: {{ $issue->assignee->id }}, 
                    text: '{{ $issue->assignee->name }}', 
                    selected: true
                }
            ],
            ajax: {
                url: '{{ route("ajax.project.assignee") }}',
                data: function (params) {
                    var query = {
                        term: params.term,
                    }

                    return query;
                },
                dataType: 'json'
            }
        });

        $('#parent-issue').select2({
            data: [
                {
                    id: '{!! $issue->parentIssue ? $issue->parentIssue->id : ''; !!}', 
                    text: '{!! $issue->parentIssue ? $issue->parentIssue->subject : ''; !!}', 
                    selected: true
                }
            ],
            ajax: {
                url: '{{ route("ajax.issue.index") }}',
                data: function (params) {
                    var query = {
                        term: params.term,
                        project_id : $('#project_id').val()
                    }

                    return query;
                },
                dataType: 'json'
            }
        });
    
    </script>
    @stop

@endsection
