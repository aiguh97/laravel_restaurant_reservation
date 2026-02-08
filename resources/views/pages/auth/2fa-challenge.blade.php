@extends('layouts.auth')

@section('title', 'Two Factor Verification')

@section('main')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Two Factor Authentication</h4>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success mb-3">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger mb-3">
                    {{ session('error') }}
                </div>
            @endif

            <p class="text-muted">
                Masukkan kode 6 digit dari aplikasi authenticator atau klik link di bawah untuk kirim via email.
            </p>

            <form method="POST" action="{{ route('2fa.challenge.verify') }}">
                @csrf
                <div class="form-group">
                    <input type="text" name="code" class="form-control text-center @error('code') is-invalid @enderror"
                        placeholder="000000" maxlength="6" inputmode="numeric" required autofocus>
                    @error('code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="text-center mb-4">
                    <a href="{{ route('2fa.challenge.send-email') }}" class="text-primary font-weight-bold">
                        <i class="fas fa-envelope mr-1"></i> Kirim kode via email
                    </a>
                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block">
                    Verifikasi
                </button>
            </form>
        </div>
    </div>
@endsection
