@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Group Members</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('update_group', $group->id) }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input id="name"
                                           type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name"
                                           value="{{ $group->name }}"
                                           required
                                           autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description"
                                       class="col-md-4 col-form-label text-md-right">Description</label>

                                <div class="col-md-6">
                                    <input id="description"
                                           type="text"
                                           class="form-control @error('description') is-invalid @enderror"
                                           name="description"
                                           value="{{ $group->description }}"
                                           required
                                           autofocus>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="users"
                                       class="col-md-4 col-form-label text-md-right">Users</label>

                                <div class="col-md-6">
                                    <select id="users"
                                            name="users[]"
                                            placeholder="Select users assigned to the group"
                                            multiple="multiple">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->name }}" @if(in_array($user->name, $members, true)) selected @endif>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="color"
                                       class="col-md-4 col-form-label text-md-right">Color</label>

                                <div class="col-md-6">
                                    <input type="color" id="color" name="color" value="{{ $group->color }}">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="{{ route('index_groups') }}" class="btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            var multipleCancelButton = new Choices('#users', {
                removeItemButton: true,
                maxItemCount:10,
                searchResultLimit:5,
                renderChoiceLimit:5
            });
        });
    </script>
@endsection
