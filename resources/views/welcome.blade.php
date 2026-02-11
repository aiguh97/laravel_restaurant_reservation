<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guhresto - Solusi Manajemen Restoran Modern</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-display {
            font-family: 'Playfair Display', serif;
        }

        /* AOS Logic */
        [data-aos] {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-aos].aos-animate {
            opacity: 1;
            transform: translate(0, 0);
        }

        [data-aos="fade-left"] {
            transform: translateX(50px);
        }

        [data-aos="fade-right"] {
            transform: translateX(-50px);
        }

        /* Glassmorphism Navbar */
        .nav-scrolled {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 12px 0 !important;
        }

        .mobile-menu-active {
            transform: translateX(0) !important;
        }
    </style>
</head>

<body class="bg-[#FFF8F3] text-slate-900 overflow-x-hidden">

    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 py-6">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center gap-2">
               <a href="{{ url('/') }}">
                    <x-brand-logo />
                </a>
            </div>

            <div class="hidden md:flex items-center gap-8">
                <a href="#features" class="font-medium text-slate-600 hover:text-teal-600 transition-colors">Fitur</a>
                <a href="#showcase"
                    class="font-medium text-slate-600 hover:text-teal-600 transition-colors">Showcase</a>
                {{-- <a href="#stats" class="font-medium text-slate-600 hover:text-teal-600 transition-colors">Statistik</a> --}}
                <a href="#about" class="font-medium text-slate-600 hover:text-teal-600 transition-colors">Tentang</a>
                {{-- <button
                    class="bg-teal-600 text-white px-8 py-2.5 rounded-full font-bold hover:bg-teal-700 transition-all shadow-lg shadow-teal-100">
                    Login
                </button> --}}
                <a href="{{ route('login') }}" class="bg-teal-600 text-white px-8 py-2.5 rounded-full font-bold hover:bg-teal-700 transition-all shadow-lg shadow-teal-100">
        Login
    </a>
            </div>

            <button class="md:hidden p-2 text-slate-600" id="menu-open">
                <i data-lucide="menu"></i>
            </button>
        </div>
    </nav>

    <div id="mobile-sidebar"
        class="fixed inset-0 z-[60] transform translate-x-full transition-transform duration-500 md:hidden">
        <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" id="menu-overlay"></div>
        <div class="absolute right-0 top-0 h-full w-3/4 bg-white shadow-2xl p-8 flex flex-col gap-6">
            <div class="flex justify-between items-center mb-4">
                <span class="font-bold text-teal-800 italic">Menu</span>
                <button id="menu-close"><i data-lucide="x"></i></button>
            </div>
            <a href="#features" class="mobile-link text-xl font-semibold border-b pb-2">Fitur</a>
            <a href="#showcase" class="mobile-link text-xl font-semibold border-b pb-2">Showcase</a>
            <a href="#stats" class="mobile-link text-xl font-semibold border-b pb-2">Statistik</a>
            <a href="#about" class="mobile-link text-xl font-semibold border-b pb-2">Tentang</a>
            <a href="{{ route('login') }}"
            class="mt-4 bg-teal-600 text-white py-4 rounded-xl font-bold text-center block">
            Login App
            </a>
        </div>
    </div>
    <main class="relative pt-32 pb-20 overflow-hidden">
        <div
            class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-[600px] h-[600px] bg-teal-100 rounded-full blur-[120px] opacity-50">
        </div>
        <div
            class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/4 w-[500px] h-[500px] bg-orange-100 rounded-full blur-[100px] opacity-50">
        </div>

        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">
            <div class="relative z-10 text-center md:text-left">
                <div data-aos="fade-down"
                    class="inline-flex items-center gap-2 bg-orange-100 text-orange-700 px-4 py-2 rounded-full text-sm font-bold mb-6 border border-orange-200">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                    </span>
                    Sistem Kasir Modern #1 di Indonesia
                </div>
                <h1 data-aos="fade-up" data-aos-delay="100"
                    class="text-5xl md:text-7xl font-extrabold leading-[1.1] mb-6">
                    Kelola Restoran <br />
                    <span class="text-gradient">Tanpa Ribet.</span>
                </h1>
                <p data-aos="fade-up" data-aos-delay="200"
                    class="text-lg text-slate-600 mb-10 max-w-lg leading-relaxed">
                    Sistem manajemen lengkap dari POS, Kitchen Display, hingga laporan keuangan otomatis. Didesain untuk
                    mempercepat pelayanan Anda.
                </p>
                <div data-aos="fade-up" data-aos-delay="300"
                    class="flex flex-wrap justify-center md:justify-start gap-4">
                    <button
                        class="bg-teal-600 text-white px-8 py-4 rounded-2xl font-bold text-lg shadow-xl shadow-teal-200 hover:bg-teal-700 hover:-translate-y-1 transition-all flex items-center gap-2">
                        Mulai Sekarang <i data-lucide="arrow-right"></i>
                    </button>
                    <button
                        class="bg-white text-slate-700 border-2 border-slate-100 px-8 py-4 rounded-2xl font-bold text-lg hover:border-teal-200 transition-all">
                        Lihat Demo
                    </button>
                </div>
            </div>

            <div class="relative">
                <div class="relative z-20 rounded-[2.5rem] p-3 bg-white shadow-2xl border border-slate-100"
                    data-aos="zoom-in" data-aos-delay="400">
                    <img src="https://cdn.magicpatterns.com/uploads/vQtC2yxFDhWM1co66NbEwr/banner.png"
                        class="rounded-[2rem] w-full" alt="Dashboard">
                </div>

                <div data-aos="fade-left" data-aos-delay="600"
                    class="absolute -top-10 -right-5 z-30 bg-white p-4 rounded-2xl shadow-xl border border-slate-50 animate-float">
                    <div class="flex items-center gap-3">
                        <div class="bg-teal-100 p-2 rounded-lg text-teal-600">
                            <i data-lucide="check-circle"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase">Status</p>
                            <p class="font-bold">Order Selesai</p>
                        </div>
                    </div>
                </div>

                <div data-aos="fade-right" data-aos-delay="800"
                    class="absolute -bottom-8 -left-8 z-30 bg-white p-5 rounded-2xl shadow-2xl border border-slate-50 animate-float animate-delay-1">
                    <p class="text-sm font-bold text-slate-400 mb-1 uppercase">Total Pendapatan</p>
                    <p class="text-2xl font-extrabold text-slate-900">Rp 12.450.000</p>
                    <div class="flex items-center gap-1 text-green-500 text-xs font-bold mt-2">
                        <i data-lucide="trending-up" class="w-3 h-3"></i> +14% dari kemarin
                    </div>
                </div>
            </div>
        </div>
    </main>
    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 data-aos="fade-up" class="text-4xl font-bold mb-4">Fitur Unggulan</h2>
                <p data-aos="fade-up" data-aos-delay="100" class="text-slate-500">Didesain khusus untuk efisiensi
                    dapur
                    dan kenyamanan pelanggan.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div data-aos="fade-up" data-aos-delay="100"
                    class="p-8 rounded-[2rem] bg-[#F9FAFB] border border-slate-100 hover:bg-white hover:shadow-xl transition-all group">
                    <div
                        class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i data-lucide="smartphone"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Mobile POS</h3>
                    <p class="text-slate-500 leading-relaxed">Pelayan bisa langsung input order dari meja menggunakan
                        smartphone/tablet.</p>
                </div>

                <div data-aos="fade-up" data-aos-delay="200"
                    class="p-8 rounded-[2rem] bg-[#F9FAFB] border border-slate-100 hover:bg-white hover:shadow-xl transition-all group">
                    <div
                        class="w-14 h-14 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i data-lucide="chef-hat"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Kitchen Display</h3>
                    <p class="text-slate-500 leading-relaxed">Dapur menerima order secara real-time tanpa kertas. Lebih
                        bersih, lebih cepat.</p>
                </div>

                <div data-aos="fade-up" data-aos-delay="300"
                    class="p-8 rounded-[2rem] bg-[#F9FAFB] border border-slate-100 hover:bg-white hover:shadow-xl transition-all group">
                    <div
                        class="w-14 h-14 bg-teal-100 text-teal-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i data-lucide="bar-chart"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Laporan Detail</h3>
                    <p class="text-slate-500 leading-relaxed">Pantau stok bahan, menu terlaris, hingga laba bersih
                        dalam satu dashboard.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="showcase"
        class="py-24 bg-[#064e3b] text-white overflow-hidden relative min-h-screen flex items-center">
        <div class="absolute top-10 left-10 w-64 h-64 border border-white/5 rounded-full"></div>
        <div class="absolute bottom-[-100px] right-[-50px] w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/4 w-32 h-32 border border-white/10 rounded-full animate-float"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid md:grid-cols-2 gap-16 items-center">

                <div class="flex justify-center md:justify-start" data-aos="fade-right">
                    <div class="relative group">
                        <div
                            class="absolute inset-0 bg-teal-400/20 blur-[100px] rounded-full opacity-50 group-hover:opacity-100 transition-opacity duration-700">
                        </div>

                        <div
                            class="relative z-10 w-[280px] md:w-[320px] bg-slate-950 rounded-[3rem] p-3 shadow-[0_0_50px_rgba(0,0,0,0.5)] border-4 border-slate-800">
                            <div
                                class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-6 bg-slate-800 rounded-b-2xl z-20">
                            </div>

                            <div class="overflow-hidden rounded-[2.2rem] bg-white aspect-[9/19.5]">
                                <img src="https://cdn.magicpatterns.com/uploads/sutDb1iNzTfCnads2M4im6/home.jpg"
                                    alt="Guhresto App Interface" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-8" data-aos="fade-left">
                    <div>
                        <p class="text-teal-400 font-bold text-sm uppercase tracking-[0.2em] mb-4">Tampilan Aplikasi
                        </p>
                        <h2 class="text-4xl md:text-6xl font-extrabold leading-tight">
                            Desain Modern & <br />
                            <span class="text-teal-400">Mudah Digunakan</span>
                        </h2>
                    </div>

                    <p class="text-teal-100/70 text-lg leading-relaxed max-w-lg">
                        Antarmuka yang intuitif membuat karyawan baru bisa langsung menggunakan aplikasi tanpa pelatihan
                        lama. Didesain khusus untuk kecepatan pelayanan.
                    </p>

                    <ul class="space-y-4">
                        <li class="flex items-center gap-4 group" data-aos="fade-left" data-aos-delay="100">
                            <div
                                class="w-6 h-6 rounded-full border border-teal-400/50 flex items-center justify-center text-teal-400 group-hover:bg-teal-400 group-hover:text-slate-900 transition-all">
                                <i data-lucide="check" class="w-4 h-4"></i>
                            </div>
                            <span class="text-lg font-medium text-white/90">Tampilan menu visual yang menarik</span>
                        </li>
                        <li class="flex items-center gap-4 group" data-aos="fade-left" data-aos-delay="200">
                            <div
                                class="w-6 h-6 rounded-full border border-teal-400/50 flex items-center justify-center text-teal-400 group-hover:bg-teal-400 group-hover:text-slate-900 transition-all">
                                <i data-lucide="check" class="w-4 h-4"></i>
                            </div>
                            <span class="text-lg font-medium text-white/90">Manajemen meja visual & interaktif</span>
                        </li>
                        <li class="flex items-center gap-4 group" data-aos="fade-left" data-aos-delay="300">
                            <div
                                class="w-6 h-6 rounded-full border border-teal-400/50 flex items-center justify-center text-teal-400 group-hover:bg-teal-400 group-hover:text-slate-900 transition-all">
                                <i data-lucide="check" class="w-4 h-4"></i>
                            </div>
                            <span class="text-lg font-medium text-white/90">Proses pembayaran cepat (QRIS, Cash,
                                Transfer)</span>
                        </li>
                        <li class="flex items-center gap-4 group" data-aos="fade-left" data-aos-delay="400">
                            <div
                                class="w-6 h-6 rounded-full border border-teal-400/50 flex items-center justify-center text-teal-400 group-hover:bg-teal-400 group-hover:text-slate-900 transition-all">
                                <i data-lucide="check" class="w-4 h-4"></i>
                            </div>
                            <span class="text-lg font-medium text-white/90">Kitchen display real-time</span>
                        </li>
                    </ul>

                    <div class="pt-4">
                        <button
                            class="bg-white text-[#064e3b] px-10 py-4 rounded-full font-bold text-lg hover:bg-teal-50 transition-all hover:scale-105 active:scale-95 shadow-xl flex items-center gap-3 group">
                            Lihat Demo Aplikasi
                            <i data-lucide="arrow-right"
                                class="w-5 h-5 group-hover:translate-x-2 transition-transform"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section id="about" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <p class="text-teal-600 font-bold tracking-widest uppercase text-sm mb-4" data-aos="fade-up">Testimoni
                </p>
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900" data-aos="fade-up"
                    data-aos-delay="100">Kata Mereka</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-[#F8FAFC] p-8 rounded-3xl border border-slate-100 hover:shadow-xl transition-all"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="flex gap-1 mb-6 text-amber-400">
                        <i data-lucide="star" class="fill-current w-5 h-5"></i>
                        <i data-lucide="star" class="fill-current w-5 h-5"></i>
                        <i data-lucide="star" class="fill-current w-5 h-5"></i>
                        <i data-lucide="star" class="fill-current w-5 h-5"></i>
                        <i data-lucide="star" class="fill-current w-5 h-5"></i>
                    </div>
                    <p class="text-slate-600 italic mb-8 leading-relaxed">"Guhresto mengubah cara kami mengelola
                        restoran. Pesanan lebih cepat, kesalahan berkurang drastis!"</p>
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-teal-100 flex items-center justify-center font-bold text-teal-700">
                            A</div>
                        <div>
                            <p class="font-bold text-slate-900">Ahmad Rizki</p>
                            <p class="text-sm text-slate-400">Pemilik Warung Nusantara</p>
                        </div>
                    </div>
                </div>

                <div class="bg-[#F8FAFC] p-8 rounded-3xl border border-slate-100 hover:shadow-xl transition-all"
                    data-aos="fade-up" data-aos-delay="300">
                    <div class="flex gap-1 mb-6 text-amber-400">
                        <i data-lucide="star" class="fill-current w-5 h-5"></i>
                        <i data-lucide="star" class="fill-current w-5 h-5"></i>
                        <i data-lucide="star" class="fill-current w-5 h-5"></i>
                        <i data-lucide="star" class="fill-current w-5 h-5"></i>
                        <i data-lucide="star" class="fill-current w-5 h-5"></i>
                    </div>
                    <p class="text-slate-600 italic mb-8 leading-relaxed">"Kitchen display-nya luar biasa. Chef kami
                        bisa langsung lihat pesanan tanpa kertas yang berantakan."</p>
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-teal-100 flex items-center justify-center font-bold text-teal-700">
                            S</div>
                        <div>
                            <p class="font-bold text-slate-900">Siti Nurhaliza</p>
                            <p class="text-sm text-slate-400">Manager Cafe Kopi Senja</p>
                        </div>
                    </div>
                </div>

                <div class="bg-[#F8FAFC] p-8 rounded-3xl border border-slate-100 hover:shadow-xl transition-all"
                    data-aos="fade-up" data-aos-delay="400">
                    <div class="flex gap-1 mb-6 text-amber-400">
                        <i data-lucide="star" class="fill-current w-5 h-5"></i>
                        <i data-lucide="star" class="fill-current w-5 h-5"></i>
                        <i data-lucide="star" class="fill-current w-5 h-5"></i>
                        <i data-lucide="star" class="fill-current w-5 h-5"></i>
                        <i data-lucide="star" class="fill-current w-5 h-5"></i>
                    </div>
                    <p class="text-slate-600 italic mb-8 leading-relaxed">"Laporan penjualan yang detail membantu kami
                        membuat keputusan bisnis yang lebih baik setiap hari."</p>
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-teal-100 flex items-center justify-center font-bold text-teal-700">
                            B</div>
                        <div>
                            <p class="font-bold text-slate-900">Budi Santoso</p>
                            <p class="text-sm text-slate-400">Owner Resto Padang Jaya</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-[#0f172a] text-slate-400 pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-2 mb-6 text-white">
                        <div class="bg-teal-600 p-2 rounded-xl">
                            <i data-lucide="chef-hat" class="w-5 h-5"></i>
                        </div>
                        <span class="text-2xl font-bold font-display italic">Guhresto</span>
                    </div>
                    <p class="max-w-sm mb-8 leading-relaxed">Platform manajemen restoran terpadu untuk membantu bisnis
                        kuliner tumbuh dan berkembang di era digital.</p>
                    <div class="flex gap-3">
                        <a href="#"
                            class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-teal-600 transition-colors text-white font-bold">F</a>
                        <a href="#"
                            class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-teal-600 transition-colors text-white font-bold">IN</a>
                        <a href="#"
                            class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-teal-600 transition-colors text-white font-bold">IG</a>
                        <a href="#"
                            class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-teal-600 transition-colors text-white font-bold">TW</a>
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider text-sm mb-6">Produk</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="hover:text-teal-400 transition-colors">Fitur</a></li>
                        <li><a href="#" class="hover:text-teal-400 transition-colors">Harga</a></li>
                        <li><a href="#" class="hover:text-teal-400 transition-colors">Hardware</a></li>
                        <li><a href="#" class="hover:text-teal-400 transition-colors">Integrasi</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider text-sm mb-6">Perusahaan</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="hover:text-teal-400 transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-teal-400 transition-colors">Kontak</a></li>
                        <li><a href="#" class="hover:text-teal-400 transition-colors">Karir</a></li>
                        <li><a href="#" class="hover:text-teal-400 transition-colors">Blog</a></li>
                    </ul>
                </div>
            </div>

            <div
                class="border-t border-slate-800 pt-8 flex flex-col md:row justify-between items-center gap-4 text-sm">
                <p>© 2026 Guhresto. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // AOS Observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('aos-animate');
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('[data-aos]').forEach(el => observer.observe(el));

        // Navbar Scroll Effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('nav-scrolled');
            } else {
                nav.classList.remove('nav-scrolled');
            }
        });

       // Mobile Menu Logic
const openBtn = document.getElementById('menu-open');
const closeBtn = document.getElementById('menu-close');
const sidebar = document.getElementById('mobile-sidebar');
const overlay = document.getElementById('menu-overlay');
const links = document.querySelectorAll('.mobile-link');

// Fungsi untuk menutup menu
const closeMenu = () => sidebar.classList.add('translate-x-full');
const openMenu = () => sidebar.classList.remove('translate-x-full');

openBtn.addEventListener('click', openMenu);
closeBtn.addEventListener('click', closeMenu);
overlay.addEventListener('click', closeMenu);

// Tutup menu saat link navigasi (#features, dll) diklik
links.forEach(link => {
    link.addEventListener('click', (e) => {
        // Jika link mengandung '#', tutup menu (navigasi internal)
        if (link.getAttribute('href').includes('#')) {
            closeMenu();
        }
    });
});
    </script>
</body>

</html>
