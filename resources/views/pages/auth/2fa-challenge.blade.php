@extends('layouts.auth')

@section('title', 'Two Factor Verification')

@section('main')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Two Factor Authentications</h4>
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
                Masukkan kode 6 digit dari email atau aplikasi authenticator Anda.
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
                    <p id="timer-container" class="text-muted small" style="display: none;">
                        Kirim ulang tersedia dalam <span id="timer" class="font-weight-bold">02:00</span>
                    </p>
                    <button type="button" id="resend-link" class="btn btn-link text-primary font-weight-bold p-0">
                        <i class="fas fa-envelope mr-1"></i> Kirim kode via email
                    </button>

                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block">
                    Verifikasi
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resendBtn = document.getElementById('resend-link');
            const timerContainer = document.getElementById('timer-container');
            const timerDisplay = document.getElementById('timer');

            let interval = null;

            function disableButton(seconds) {
                resendBtn.disabled = true;
                resendBtn.classList.add('text-muted');
                timerContainer.style.display = 'block';

                let end = Math.floor(Date.now() / 1000) + seconds;
                localStorage.setItem('otp_cooldown', end);

                runTimer();
            }

            function runTimer() {
                clearInterval(interval);

                interval = setInterval(() => {
                    let end = localStorage.getItem('otp_cooldown');
                    let now = Math.floor(Date.now() / 1000);
                    let remain = end - now;

                    if (remain <= 0) {
                        clearInterval(interval);
                        resendBtn.disabled = false;
                        resendBtn.classList.remove('text-muted');
                        timerContainer.style.display = 'none';
                        localStorage.removeItem('otp_cooldown');
                        return;
                    }

                    let m = Math.floor(remain / 60);
                    let s = remain % 60;

                    timerDisplay.textContent =
                        String(m).padStart(2, '0') + ':' +
                        String(s).padStart(2, '0');
                }, 1000);
            }

            // restore timer saat refresh
            if (localStorage.getItem('otp_cooldown')) {
                runTimer();
                resendBtn.disabled = true;
                timerContainer.style.display = 'block';
            }

            resendBtn.addEventListener('click', async function() {

                disableButton(30); // ⬅️ 30 detik

                try {
                    let res = await fetch("{{ route('2fa.challenge.send-email') }}", {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'Accept': 'application/json'
                        }
                    });

                    let data = await res.json();

                    if (!data.status) {
                        alert(data.message);
                        return;
                    }

                    // sinkron dengan waktu server
                    localStorage.setItem('otp_cooldown', data.cooldown_until);
                    runTimer();

                } catch (e) {
                    alert('Gagal kirim kode');
                }
            });

        });
    </script>

@endsection
