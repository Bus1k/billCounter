@extends('layouts.app')

@section('content')
    <div class="container">
        @include('partials.alert')
        <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group mr-2" role="group" aria-label="Main panel">
                <a href="{{ route('create_group') }}" id="addGroup" class="btn btn-primary">Add Group</a>
            </div>
        </div>

        @foreach ($groups as $group)
        <div class="card text-center mt-4">
            <div class="card-header">
                {{ $group->name }}
            </div>
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
            <div class="card-footer text-muted">
                2 days ago
            </div>
        </div>
        @endforeach

    </div>
@endsection



@section('script')@endsection
