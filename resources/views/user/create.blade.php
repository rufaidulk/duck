@extends('layouts.main')

@section('content')
<form class="user" method="POST" action="{{ route('user.store') }}">
    @csrf
    <div class="card">
        <div class="card-header">
            <h5>New User</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter name" value="{{ old('name') }}">
                        @error('name')
                            <p class="help-block text-danger">{{ $message }} </p>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email" value="{{ old('email') }}">
                        @error('email')
                            <p class="help-block text-danger">{{ $message }} </p>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password" value="{{ old('password') }}">
                        @error('password')
                            <p class="help-block text-danger">{{ $message }} </p>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="permission">Roles</label>
                        <select id="role-select" multiple class="form-control" name="role[]">
                        @foreach ($roles as $role)
                            <option value="{{ $role }}" {{ old("role") == $role ? "Selected" : "" }}>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                        </select>
                        @error('role')
                            <p class="help-block text-danger">{{ $message }} </p>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="permission">Status</label>
                        <select class="form-control" name="status">
                            <option>Select status</option>
                        @foreach (config('params.user.status') as $id => $status)
                            <option value="{{ $id }}" {{ old("status") == $id ? "Selected" : "" }}>
                                {{ $status }}
                            </option>
                        @endforeach
                        </select>
                        @error('status')
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

        $('#role-select').multiSelect({
            selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='Search' style='width: -moz-available;margin-bottom: 10px;'>",
            selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='Search' style='width: -moz-available;margin-bottom: 10px;'>",
            afterInit: function(ms){
                var that = this,
                    $selectableSearch = that.$selectableUl.prev(),
                    $selectionSearch = that.$selectionUl.prev(),
                    selectableSearchString = '#' + that.$container.attr('id') + 
                        ' .ms-elem-selectable:not(.ms-selected)',
                    selectionSearchString = '#' + that.$container.attr('id') + 
                        ' .ms-elem-selection.ms-selected';

                that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                .on('keydown', function(e){
                    if (e.which === 40){
                        that.$selectableUl.focus();
                        return false;
                    }
                });

                that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                .on('keydown', function(e){
                    if (e.which == 40){
                        that.$selectionUl.focus();
                        return false;
                    }
                });
            },
            afterSelect: function(){
                this.qs1.cache();
                this.qs2.cache();
            },
            afterDeselect: function(){
                this.qs1.cache();
                this.qs2.cache();
            }
        });
    
    </script>
@stop

@endsection
