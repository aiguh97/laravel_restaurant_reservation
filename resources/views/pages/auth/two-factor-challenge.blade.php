@extends('layouts.auth')

@section('title', 'Two Factor Authentication')

@section('main')
<div class="card card-primary">
    <div class="card-header">
        <h4>Two-Factor Authentication</h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('2fa.challenge.verify') }}">
            @csrf

            <div class="form-group">
                <label>Kode Authenticator</label>
                <input type="text"
                       name="code"
                       class="form-control"
                       placeholder="6 digit kode"
                       autofocus
                       required>

                @error('code')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button class="btn btn-primary btn-lg btn-block">
                Verifikasi
            </button>
        </form>
    </div>
</div>
@endsection
