@extends('layouts.app')

@section('title', 'Settings')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <style>
        /* Penyesuaian agar selaras dengan desain premium Guhresto */
        .swal2-popup {
            border-radius: 15px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Settings</h1>
            </div>

            <div class="section-body">
                {{-- 🔐 TWO FACTOR AUTH CARD --}}
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Security & Authentication</h4>
                    </div>

                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="p-3 rounded-circle bg-light">
                                    <i class="fas fa-shield-alt text-primary" style="font-size: 24px;"></i>
                                </div>
                            </div>
                            <div class="col">
                                <h6>Two-Factor Authentication (2FA)</h6>
                                <p class="mb-0 text-muted">
                                    Tambahkan lapisan keamanan ekstra pada akun Anda dengan verifikasi kode unik.
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            @if (auth()->user()->two_factor_enabled)
                                <div class="alert alert-light border shadow-sm d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="badge badge-success mb-2">Aktif</span>
                                        <p class="mb-0">Akun Anda saat ini terlindungi oleh 2FA.</p>
                                    </div>
                                    <form id="form-disable-2fa" action="{{ route('2fa.disable') }}" method="POST">
                                        @csrf
                                        <button type="button" onclick="confirmDisable2FA()" class="btn btn-danger btn-lg shadow-sm">
                                            Nonaktifkan
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="alert alert-warning border-0">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    2FA belum diaktifkan. Kami sangat menyarankan Anda untuk mengaktifkannya.
                                </div>
                                <a href="{{ route('2fa.setup') }}" class="btn btn-primary btn-lg shadow-sm">
                                    Aktifkan Sekarang
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
    {{-- Libs --}}
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Logic Alert --}}
    <script>
        // 1. Handler Konfirmasi Nonaktifkan 2FA
        function confirmDisable2FA() {
            Swal.fire({
                title: 'Matikan Keamanan 2FA?',
                text: "Akun Anda akan menjadi lebih rentan terhadap akses yang tidak sah.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fc544b', // Stisla Danger Color
                cancelButtonColor: '#6777ef', // Stisla Primary Color
                confirmButtonText: 'Ya, Nonaktifkan!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        didOpen: () => { Swal.showLoading() },
                        allowOutsideClick: false
                    });
                    document.getElementById('form-disable-2fa').submit();
                }
            })
        }

        // 2. Tampilkan Alert Sukses dari Session Laravel
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        @endif

        // 3. Tampilkan Alert Error (Jika ada)
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}",
                confirmButtonColor: '#6777ef'
            });
        @endif
    </script>
@endpush
