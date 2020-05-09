@extends('layouts.main')
   
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="float-left">User: {{ $user->name }}</h5>
        <div class="float-right">
            <a href="{{ route('user.edit', $user->id) }} " class="btn btn-success mr-1">
                <i class="fa fa-pen"></i>
            </a>
            <form class="float-right" action="{{ route('user.destroy', $user->id)}}" 
                method="post">
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
                                <th>Name</th>
                                <td>{{ ucfirst($user->name) }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ ucfirst(config('params.user.status')[$user->status]) }}</td>
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
        <h5 class="float-left">{{ $user->name }} roles</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            @foreach($user->roles as $role)
                            <tr>
                                <th>{{ ucfirst($role->name) }}</th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection  
