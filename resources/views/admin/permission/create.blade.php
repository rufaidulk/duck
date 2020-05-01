@extends('admin.layouts.main')

@section('content')
<form class="user" method="POST" action="{{ route('admin.permission.store') }}">
    @csrf
    <div class="card">
        <div class="card-header">
            <h5>Create Permission</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name">Permission</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter permission">
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>    
</form>
@endsection
