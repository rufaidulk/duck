@extends('layouts.main')

@section('content')
<form class="user" method="POST" action="{{ route('project.update', $project->id) }}">
    @csrf
    @method('PATCH')
    <div class="card">
        <div class="card-header">
            <h5>Edit Project : {{ ucfirst($project->name) }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter name" value="{{ $project->name }}">
                        @error('name')
                            <p class="help-block text-danger">{{ $message }} </p>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ $project->description }}</textarea>
                        @error('description')
                            <p class="help-block text-danger">{{ $message }} </p>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="permission">Status</label>
                        <select class="form-control" name="status">
                            <option>Select status</option>
                        @foreach (config('params.project.status') as $id => $status)
                            <option value="{{ $id }}" {{ $project->status == $id ? "Selected" : "" }}>
                                {{ $status }}
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
                        <label for="permission">Users</label>
                        <select id="user-select" multiple="multiple" class="form-control" name="user_id[]">
                        @foreach ($users as $id => $user)
                            <option value="{{ $id }}">
                                {{ $user }}
                            </option>
                        @endforeach
                        </select>
                        @error('user_id')
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

        $('#user-select').multiSelect({
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
        
        $('#user-select').multiSelect('select', <?= json_encode(array_map('strval', $project->users->pluck('id')->toArray())) ?>);

    </script>
    @stop

@endsection
