@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group mr-2" role="group" aria-label="Main panel">
                <button id="addCategory" class="btn btn-primary">Add Category</button>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col">
                <table class="table" id="categoryTable">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($categories as $category)
                        <tr>
                            <th scope="row">{{ $category->id }}</th>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#categoryTable').DataTable();
    });
</script>
@endsection
