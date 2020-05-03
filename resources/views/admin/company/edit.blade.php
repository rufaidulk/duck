@extends('admin.layouts.main')

@section('content')
<form class="user" method="POST" action="{{ route('admin.company.update', $company->id) }}">
    @csrf
    @method('PATCH')
    <div class="card">
        <div class="card-header">
            <h5>Edit Company : {{ $company->name }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter name" 
                            value="{{ $company->name }}">
                        @error('name')
                            <p class="help-block text-danger">{{ $message }} </p>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="permission">Company Admin</label>
                        <select class="custom-select form-control" name="user_id">
                            <option>Select user</option>
                        @foreach ($users as $id => $user)
                            <option value="{{ $id }}" {{ ($company->user_id == $id) ? 'selected' : '' }}>
                                {{ $user }}
                            </option>
                        @endforeach
                        </select>
                        @error('user_id')
                            <p class="help-block text-danger">{{ $message }} </p>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ $company->description }}</textarea>
                        @error('description')
                            <p class="help-block text-danger">{{ $message }} </p>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>    
</form>
@endsection
