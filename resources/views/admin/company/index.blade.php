@extends('admin.layouts.main')
   
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="float-left">Companies</h5>
        <a href="{{ route('admin.company.create') }}" class="btn btn-primary float-right">Add</a>
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
                                <th>User</th>
                                <th>Description</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $index = 1;
                        @endphp
                        @foreach($companies as $company)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ ucfirst($company->name) }}</td>
                                <td>{{ ucfirst($company->user->email) }}</td>
                                <td>{{ ucfirst($company->name) }}</td>
                                <td>{{ date('d M Y', strtotime($company->created_at)) }}</td>
                                <td>{{ date('d M Y', strtotime($company->updated_at)) }}</td>
                                <td style="display: inline-flex;">
                                    <a href="{{ route('admin.company.edit', $company->id) }} " 
                                        class="btn btn-info mr-1">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.company.destroy', $company->id)}}" 
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
                    {!! $companies->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection  
