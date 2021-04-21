@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('partials.alert')
                <div class="card">
                    <div class="card-header">Settings</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('store_settings') }}">
                            @csrf
                            <h4 class="mb-3">Google Drive</h4>
                            <div class="form-group">
                                <label for="clientId">Client ID</label>
                                <input type="text" class="form-control" id="clientId" name="clientId" @isset($google_drive['clientId']) value="{{ $google_drive['clientId'] }}" @endisset>
                            </div>

                            <div class="form-group">
                                <label for="secret">Secret</label>
                                <input type="password" class="form-control" id="secret" name="secret" @isset($google_drive['clientId']) value="****************************" @endisset>
                            </div>

                            <div class="form-group">
                                <label for="refreshToken">Refresh Token</label>
                                <input type="text" class="form-control" id="refreshToken" name="refreshToken" @isset($google_drive['refreshToken']) value="{{ $google_drive['refreshToken'] }}" @endisset>
                            </div>

                            <div class="form-group">
                                <label for="folderId">Folder ID</label>
                                <input type="text" class="form-control" id="folderId" name="folderId" @isset($google_drive['folderId']) value="{{ $google_drive['folderId'] }}" @endisset>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('index_bill') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
