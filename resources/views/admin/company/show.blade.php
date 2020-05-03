@extends('admin.layouts.main')
   
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="float-left">Permissions of {{ ucfirst($role->name) }}</h5>
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
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $index = 1;
                        @endphp
                        @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ ucfirst($permission->name) }}</td>
                                <td>{{ date('d M Y', strtotime($permission->created_at)) }}</td>
                                <td>{{ date('d M Y', strtotime($permission->updated_at)) }}</td>
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
