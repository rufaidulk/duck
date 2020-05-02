@extends('admin.layouts.main')

@section('content')
<form class="user" method="POST" action="{{ route('admin.role.revokePermission', $role->id) }}">
    @csrf
    <div class="card">
        <div class="card-header">
            <h5>Remove Permission from {{ ucfirst($role->name) }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="permission">Permissions</label>
                        <select class="custom-select form-control" name="permission">
                            <option>Select Permission</option>
                        @foreach ($permissions as $id => $permission)
                            <option value="{{ $id }}">{{ $permission }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>    
</form>
@endsection
