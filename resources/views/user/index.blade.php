@extends('layouts.main')
   
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="float-left">Users</h5>
        <a href="{{ route('user.create') }}" class="btn btn-primary float-right">Add</a>
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
                                <th>Email</th>
                                <th>First Role</th>
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
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ ucfirst($user->name) }}</td>
                                <td>{{ ucfirst($user->email) }}</td>
                                <td>{{ ucfirst($user->roles[0]->name) }}</td>
                                <td>{{ ucfirst(config('params.user.status')[$user->status]) }}</td>
                                <td>{{ date('d M Y', strtotime($user->created_at)) }}</td>
                                <td>{{ date('d M Y', strtotime($user->updated_at)) }}</td>
                                <td style="display: inline-flex;">
                                    <a href="{{ route('user.show', $user->id) }} " 
                                        class="btn btn-info mr-1">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('user.edit', $user->id) }} " 
                                        class="btn btn-success mr-1">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <form action="{{ route('user.destroy', $user->id)}}" 
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
                    {!! $users->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection  
