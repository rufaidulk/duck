@extends('admin.layouts.main')
   
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="float-left">Roles</h5>
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
                                <th>Created at</th>
                                <th>Updated at</th>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $index = 1;
                        @endphp
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ ucfirst($role->name) }}</td>
                                <td>{{ date('d M Y', strtotime($role->created_at)) }}</td>
                                <td>{{ date('d M Y', strtotime($role->updated_at)) }}</td>
                                <td style="display: inline-flex;">
                                    <a href="{{ route('admin.role.show', $role->id) }} " 
                                        class="btn btn-info mr-1">
                                        <i class="fa fa-eye"></i>
                                    </a>                                    
                                    <a href="{{ route('admin.role.assign', $role->id) }} " 
                                        class="btn btn-success">
                                        <i class="fa fa-location-arrow"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $roles->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection  
