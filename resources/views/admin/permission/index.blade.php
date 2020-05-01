@extends('admin.layouts.main')
   
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="float-left">Permissions</h5>
        <a href="{{ route('admin.permission.create') }}" class="btn btn-primary float-right">Add</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $permission->id }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>{{ date('d M Y', strtotime($permission->created_at)) }}</td>
                                <td>{{ date('d M Y', strtotime($permission->updated_at)) }}</td>
                                <td style="display: inline-flex;">
                                    <a href="{{ route('admin.permission.edit',$permission->id)}}" 
                                        class="btn btn-success mr-1">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.permission.destroy', $permission->id)}}" 
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
                    {!! $permissions->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection  
