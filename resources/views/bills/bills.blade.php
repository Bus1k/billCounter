@extends('layouts.app')

@section('head')

@endsection

@section('content')
    <div class="container">

        <a href="{{ route('create_bill') }}" class="btn btn-primary">Add Bill</a>

        <div class="row justify-content-center">
            <table class="table" id="billTable">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">User</th>
                    <th scope="col">Description</th>
                    <th scope="col">Type</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($bills as $bill)
                    <tr>
                        <th scope="row">{{ $bill->id }}</th>
                        <td>{{ $bill->user->name }}</td>
                        <td>{{ $bill->description }}</td>
                        <td>{{ $bill->type }}</td>
                        <td>{{ $bill->amount }}</td>
                        <td>{{ $bill->photo_name }}</td>
                        <td>{{ $bill->created_at }}</td>
                        <td>{{ $bill->updated_at }}</td>
                        <td>DUPA</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


@section('script')
<script>
    $(document).ready( function () {
        console.log('DUPA');
    });
</script>
@endsection

