@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

@if (Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
@endif

@section('alertScript')
    <script>
        $(document).ready(function() {
            if ($('.alert').length > 0) {
                setTimeout(function() {
                    $('.alert').slideUp(300, function(){
                        $(this).remove();
                    });
                }, 3000);
            }
        });
    </script>
@endsection
