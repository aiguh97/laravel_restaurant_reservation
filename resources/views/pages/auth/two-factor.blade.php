@extends('layouts.app')

@section('title', 'Two Factor Authentication')

@section('main')
<div class="main-content">
    <section class="section">
        <h4>Scan QR Code</h4>

        <img src="{{ $qr }}" alt="QR Code">

        <p class="mt-3">Atau masukkan manual:</p>
        <code>{{ $secret }}</code>

        <form method="POST" action="{{ route('2fa.verify') }}" class="mt-4">
            @csrf
            <input type="text"
                   name="code"
                   class="form-control mb-2"
                   placeholder="6 digit code"
                   required>

            <button class="btn btn-primary">
                Aktifkan 2FA
            </button>
        </form>
    </section>
</div>
@endsection
