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
            <div class="card-header" style="background-color: {{ $group->color }}">
                {{ $group->name }} <a href="{{ route('edit_group', $group->id) }}" class="float-right"><i class="fas fa-edit"></i></a>
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $group->description }}</h5>
                <div class="card" style="width: 18rem;">
                    <div class="card-header" style="background-color: {{ $group->color }}">
                        Group Members
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($group->users as $user)
                        <li class="list-group-item">{{ $user }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="card-footer text-muted">
                Ostatnio dodany rachunek: 2 days ago
            </div>
        </div>
        @endforeach

    </div>
@endsection



@section('script')@endsection
