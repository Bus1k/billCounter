@extends('layouts.app')

@section('head')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script
@endsection

@section('content')
    <div class="container">
        <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Liczba rachunków dodanych w miesiącu <span id="monthName">{{ $monthName }}</span></h5>
                        <h2 id="currentMonthQuantity" class="card-text">{{ $stats['currentMonthQuantity'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Suma wydanych pieniędzy</h5>
                        <h2 id="currentMonthSum" class="card-text">{{ $stats['currentMonthSum'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group mr-2" role="group" aria-label="Main panel">
                <a href="{{ route('create_bill') }}" class="btn btn-primary">Add Bill</a>
            </div>
            <div class="input-group">
                <div class="input-group-prepend">
                    <input type="button" name="month_select" id="month_select" value="Select" class="btn btn-success" />
                </div>
                <input type="month" name="bill_date" id="bill_date" class="form-control" />
            </div>
        </div>

        <div class="row justify-content-center">
            <table class="table" id="billTable">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">User</th>
                    <th scope="col">Description</th>
                    <th scope="col">Category</th>
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
                        <td>{{ $bill->category->name }}</td>
                        <td>{{ $bill->amount }}</td>
                        <td>
                            @if( $bill->photo_name )
                                <a target="_blank" href="{{ url( 'storage/bills/' . $bill->photo_name ) }}">
                                    <button type="button" class="btn btn-success">
                                        <i class="fas fa-file-image"></i>
                                    </button>
                                </a>
                            @endif
                        </td>
                        <td>{{ $bill->created_at }}</td>
                        <td>{{ $bill->updated_at }}</td>
                        <td>
                            <a href="{{ route('edit_bill', $bill->id) }}" class="btn btn-primary"><i class="far fa-edit"></i></a>
                            <a id="delete_bill" href="{{ route('delete_bill', $bill->id) }}" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


@section('script')

<script>
    $(document).ready(function() {
        $('#billTable').DataTable();

        function fetch_data(table_type, date='')
        {
            $.ajax({
                url: "{{ route('ajax_bill') }}",
                type:"POST",
                dataType: "JSON",
                data: {
                    _token: "{{ csrf_token() }}",
                    table_type:table_type,
                    selected_date:date,
                },
            }).done(function(response) {
                $('#billTable').DataTable({
                    data: response.data
                });
                changeStats(response.additional);
            });
        }

        function changeStats(additional){
            $('#monthName').text(additional.monthName);
            $('#currentMonthQuantity').text(additional.currentMonthQuantity);
            $('#currentMonthSum').text(additional.currentMonthSum);

            console.log(additional);
        }

        $('#month_select').click(function(){
            const date = $('#bill_date').val();

            if(date != ''){
                $('#billTable').DataTable().destroy();
                fetch_data('billTable', date);
            }
        });
    } );
</script>
@endsection

