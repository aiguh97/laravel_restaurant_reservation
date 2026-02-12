
@extends('layouts.app')

@section('title', 'Two Factor Authentication')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Two Factor Authentication</h1>
        </div>

        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">

                    {{-- Alert jika ada error dari session --}}
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif

                    <div class="card shadow">
                        <div class="card-header">
                            <h4>Setup Authenticator</h4>
                        </div>

                        <div class="card-body text-center">
                            <p class="mb-4 text-muted">Buka aplikasi <b>Google Authenticator</b>, pindai QR Code di bawah ini untuk mendapatkan kode verifikasi.</p>

                            <div class="mb-4 d-flex justify-content-center">
                                <div style="background: white; padding: 15px; border: 1px solid #eee; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                    {!! $qrCode !!}
                                </div>
                            </div>

                            <p class="text-muted mb-2">Atau masukkan kode rahasia secara manual:</p>
                            <div class="mb-4">
                                <span class="badge badge-light p-2" style="font-size: 15px; letter-spacing: 2px; border: 1px dashed #999; color: #333;">
                                    {{ $secret }}
                                </span>
                            </div>

                            <hr>

                            <form method="POST" action="{{ route('2fa.enable') }}">
                                @csrf
                                <div class="form-group">
                                    <label class="font-weight-bold">6 Digit Kode Konfirmasi</label>
                                    <input type="text"
                                           name="code"
                                           class="form-control text-center @error('code') is-invalid @enderror"
                                           placeholder="------"
                                           maxlength="6"
                                           pattern="\d{6}"
                                           inputmode="numeric"
                                           autocomplete="one-time-code"
                                           style="font-size: 24px; font-weight: bold; letter-spacing: 8px; height: 60px;"
                                           required>
                                    @error('code')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg btn-block shadow-sm">
                                    Verifikasi & Aktifkan
                                </button>

                                <a href="{{ url('/settings') }}" class="btn btn-link btn-block text-muted">Kembali ke Pengaturan</a>
                            </form>
                        </div>
                    </div>

                    <div class="text-center mt-3 text-small text-muted">
                        <i class="fas fa-info-circle"></i> Pastikan waktu di HP Anda sinkron dengan waktu server.
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
