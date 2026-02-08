@extends('layouts.app')

@section('title', 'Settings')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Settings</h1>
            </div>

            <div class="section-body">

                {{-- 🔐 TWO FACTOR AUTH --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Security</h4>
                    </div>

                    <div class="card-body">
                        <p>
                            Two-Factor Authentication menambahkan lapisan keamanan tambahan
                            pada akun Anda.
                        </p>

                        <div class="mt-3">
                            @if (auth()->user()->two_factor_enabled)
                                {{-- Jika Aktif, tampilkan Form untuk Nonaktifkan --}}
                                <form action="{{ route('2fa.disable') }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menonaktifkan 2FA?')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        Nonaktifkan Two Factor
                                    </button>
                                </form>
                            @else
                                {{-- Jika Belum Aktif, tampilkan Link ke halaman Setup --}}
                                <a href="{{ route('2fa.setup') }}" class="btn btn-primary">
                                    Aktifkan Two Factor
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
@endpush
