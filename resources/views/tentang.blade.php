<x-app-layout>
    <div class="min-h-screen bg-gradient-to-b from-[#020617] via-[#071028] to-[#0F172A] text-slate-100 antialiased overflow-x-hidden">
        <div class="max-w-7xl mx-auto px-6 py-16 space-y-24">

            <section class="relative transition-all duration-300 transform hover:translate-y-[-2px]">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-5 space-y-6">
                        <div class="inline-flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-xs font-bold text-emerald-400 tracking-wider uppercase">SIGAB DIY</span>
                            <span class="px-3 py-1 rounded-full bg-slate-800/50 border border-slate-700/50 text-xs text-slate-300">WebGIS Platform</span>
                        </div>

                        <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-tight">
                            SIGAB DIY
                            <span class="block text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-emerald-400 text-2xl lg:text-3xl font-semibold mt-2">
                                Sistem Informasi Geospasial Kebencanaan Daerah Istimewa Yogyakarta
                            </span>
                        </h1>

                        <p class="text-slate-300 leading-relaxed text-base">
                            SIGAB DIY merupakan platform WebGIS yang dirancang untuk mendukung visualisasi, pengelolaan, dan analisis informasi kebencanaan secara terintegrasi. Sistem ini menggabungkan data spasial, lokasi posko kebencanaan, riwayat kejadian bencana, serta navigasi berbasis peta interaktif dalam satu lingkungan kerja yang modern dan responsif.
                        </p>

                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <div class="flex items-center gap-2 text-sm font-medium text-slate-200">
                                <span class="text-emerald-400 font-bold">✓</span> Peta Interaktif
                            </div>
                            <div class="flex items-center gap-2 text-sm font-medium text-slate-200">
                                <span class="text-cyan-400 font-bold">✓</span> Posko Kebencanaan
                            </div>
                            <div class="flex items-center gap-2 text-sm font-medium text-slate-200">
                                <span class="text-amber-400 font-bold">✓</span> Riwayat Area Bencana
                            </div>
                            <div class="flex items-center gap-2 text-sm font-medium text-slate-200">
                                <span class="text-red-400 font-bold">✓</span> Navigasi Posko Terdekat
                            </div>
                        </div>

                        <div class="pt-4 flex items-center gap-4">
                            <a href="/peta" class="px-5 py-3 rounded-xl bg-gradient-to-r from-cyan-500 to-emerald-500 text-slate-950 font-bold shadow-lg shadow-cyan-500/20 hover:shadow-cyan-500/40 transition-all duration-300 transform hover:scale-[1.02]">
                                Buka Peta Interaktif
                            </a>
                            <a href="/dashboard" class="px-5 py-3 rounded-xl bg-slate-800/80 border border-slate-700/60 text-slate-200 font-medium hover:bg-slate-700/80 transition-all duration-300">
                                Ke Dashboard
                            </a>
                        </div>
                    </div>

                    <div class="lg:col-span-7 relative group">
                        <div class="absolute -inset-1.5 bg-gradient-to-r from-cyan-500 to-emerald-500 rounded-3xl blur opacity-25 group-hover:opacity-40 transition duration-300"></div>

                        <div class="relative rounded-3xl bg-slate-900/40 border border-white/10 p-3 backdrop-blur-md overflow-hidden shadow-2xl shadow-cyan-950/50">
                            <div class="absolute top-6 left-6 z-10">
                                <span class="px-3 py-1.5 rounded-lg bg-slate-950/80 border border-cyan-500/40 text-[10px] font-bold tracking-widest text-cyan-400 uppercase backdrop-blur-sm shadow-md">
                                    ● LIVE WEBGIS SYSTEM
                                </span>
                            </div>

                            <div class="overflow-hidden rounded-2xl bg-slate-950">
                                <img src="{{ asset('images/about/hero-peta.png') }}" alt="Hero Peta SIGAB DIY" class="w-full h-auto object-cover transform group-hover:scale-[1.02] transition-transform duration-300">
                            </div>

                            <div class="mt-3 px-3 pb-1 text-center lg:text-left">
                                <p class="text-xs text-slate-400 italic">
                                    Tampilan utama SIGAB DIY yang digunakan untuk pemantauan spasial dan pengambilan keputusan kebencanaan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-slate-900/40 border border-slate-800/60 rounded-3xl p-8 backdrop-blur-sm shadow-lg">
                    <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                        <span class="text-red-500">■</span> Latar Belakang
                    </h2>
                    <p class="mt-4 text-slate-300 leading-relaxed text-sm">
                        Daerah Istimewa Yogyakarta merupakan wilayah yang memiliki potensi berbagai jenis bencana seperti gempa bumi, banjir, tanah longsor, erupsi gunung api, dan cuaca ekstrem. Informasi terkait lokasi kejadian bencana maupun fasilitas penanganan darurat sering kali tersebar pada berbagai sumber yang berbeda sehingga sulit diakses secara cepat ketika dibutuhkan. SIGAB DIY dikembangkan sebagai Sistem Informasi Geospasial Kebencanaan berbasis WebGIS yang mengintegrasikan data spasial posko kebencanaan dan riwayat kejadian bencana dalam satu platform yang mudah diakses dan divisualisasikan secara interaktif.
                    </p>
                </div>
                <div class="bg-slate-900/40 border border-slate-800/60 rounded-3xl p-8 backdrop-blur-sm shadow-lg flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <span class="text-emerald-500">■</span> Alur Sistem
                        </h3>
                        <p class="text-xs text-slate-400 mt-1">Pemrosesan data spasial berbasis PostGIS</p>
                    </div>
                    <div class="space-y-2 mt-4 text-xs font-semibold text-slate-300">
                        <div class="p-2 bg-slate-800/50 border border-slate-700/40 rounded-xl">1. Input & Validasi Data</div>
                        <div class="p-2 bg-slate-800/50 border border-slate-700/40 rounded-xl">2. Penyimpanan PostGIS</div>
                        <div class="p-2 bg-slate-800/50 border border-slate-700/40 rounded-xl">3. Visualisasi Leaflet & OSM</div>
                        <div class="p-2 bg-slate-800/50 border border-slate-700/40 rounded-xl">4. Analisis & Keputusan</div>
                    </div>
                </div>
            </section>

            <section class="space-y-8">
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <h2 class="text-3xl font-bold tracking-tight text-white">Fitur Unggulan Sistem</h2>
                    <p class="text-slate-400 text-sm">
                        Fitur yang dirancang untuk mendukung kesiapsiagaan dan pengelolaan kebencanaan berbasis lokasi.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div class="group relative order-last lg:order-first">
                        <div class="absolute -inset-1.5 bg-gradient-to-r from-emerald-500 to-cyan-500 rounded-3xl blur opacity-25 group-hover:opacity-35 transition duration-300"></div>
                        <div class="relative rounded-3xl bg-slate-900/40 border border-white/10 p-3 backdrop-blur-md shadow-xl overflow-hidden">
                            <div class="overflow-hidden rounded-2xl bg-slate-950">
                                <img src="{{ asset('images/about/fitur-navigasi.png') }}" alt="Fitur Navigasi SIGAB DIY" class="w-full h-auto object-cover transform group-hover:scale-[1.02] transition-transform duration-300">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-5 rounded-2xl bg-slate-900/50 border border-slate-800/80 shadow-md transform hover:-translate-y-1 hover:shadow-cyan-500/10 transition-all duration-300 group">
                            <div class="text-2xl mb-2">📍</div>
                            <h4 class="font-bold text-white group-hover:text-cyan-400 transition-colors duration-200 text-sm">Pemetaan Posko Kebencanaan</h4>
                            <p class="text-xs text-slate-400 mt-2 leading-relaxed">Menampilkan lokasi posko operasional secara spasial untuk mempercepat distribusi bantuan.</p>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-900/50 border border-slate-800/80 shadow-md transform hover:-translate-y-1 hover:shadow-cyan-500/10 transition-all duration-300 group">
                            <div class="text-2xl mb-2">🛰️</div>
                            <h4 class="font-bold text-white group-hover:text-cyan-400 transition-colors duration-200 text-sm">Lokasi Pengguna Real-Time</h4>
                            <p class="text-xs text-slate-400 mt-2 leading-relaxed">Mengetahui posisi pengguna secara langsung pada peta menggunakan modul Geolocation.</p>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-900/50 border border-slate-800/80 shadow-md transform hover:-translate-y-1 hover:shadow-cyan-500/10 transition-all duration-300 group">
                            <div class="text-2xl mb-2">🛣️</div>
                            <h4 class="font-bold text-white group-hover:text-cyan-400 transition-colors duration-200 text-sm">Navigasi Posko Terdekat</h4>
                            <p class="text-xs text-slate-400 mt-2 leading-relaxed">Mencari jalur rute evakuasi menuju posko terdekat berdasarkan jaringan jalan.</p>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-900/50 border border-slate-800/80 shadow-md transform hover:-translate-y-1 hover:shadow-cyan-500/10 transition-all duration-300 group">
                            <div class="text-2xl mb-2">⚠️</div>
                            <h4 class="font-bold text-white group-hover:text-cyan-400 transition-colors duration-200 text-sm">Deteksi Area Riwayat Bencana</h4>
                            <p class="text-xs text-slate-400 mt-2 leading-relaxed">Menganalisis dan meninjau kedekatan serta kerawanan pengguna terhadap area terdampak masa lalu.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="space-y-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-5 space-y-6">
                        <div class="space-y-2">
                            <h2 class="text-3xl font-bold tracking-tight text-white">Basis Data Kebencanaan Terintegrasi</h2>
                            <div class="h-1 w-20 bg-emerald-500 rounded-full"></div>
                        </div>

                        <p class="text-slate-300 leading-relaxed text-sm">
                            SIGAB DIY tidak hanya berfungsi sebagai media visualisasi peta, tetapi juga sebagai sistem manajemen basis data kebencanaan. Data posko dan riwayat kejadian bencana dapat disimpan, diperbarui, ditelusuri, dan dianalisis secara terpusat melalui antarmuka admin dashboard yang mudah digunakan.
                        </p>

                        <div class="grid grid-cols-2 gap-2 text-sm font-semibold text-slate-300">
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-400">✓</span> Data Posko
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-400">✓</span> Riwayat Bencana
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-400">✓</span> Dokumentasi Foto
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-400">✓</span> Informasi Lokasi
                            </div>
                            <div class="flex items-center gap-2 col-span-2">
                                <span class="text-emerald-400">✓</span> Atribut Kebencanaan Lengkap
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-7 group relative">
                        <div class="absolute -inset-1.5 bg-gradient-to-r from-emerald-600 to-teal-500 rounded-3xl blur opacity-25 group-hover:opacity-40 transition duration-300"></div>

                        <div class="relative rounded-3xl bg-slate-900/60 border border-white/10 p-3 backdrop-blur-xl shadow-2xl shadow-emerald-950/40">
                            <div class="overflow-hidden rounded-2xl bg-slate-950">
                                <img src="{{ asset('images/about/database-kebencanaan.png') }}" alt="Database Kebencanaan SIGAB DIY" class="w-full h-auto object-cover transform group-hover:scale-[1.01] transition-transform duration-300">
                            </div>

                            <div class="mt-3 px-2 text-center">
                                <p class="text-xs text-slate-400 font-medium">
                                    Halaman pengelolaan database kebencanaan SIGAB DIY.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <div class="bg-slate-900/30 border border-slate-800/60 rounded-2xl p-6 backdrop-blur-sm">
                    <h4 class="font-bold text-base text-cyan-400">Teknologi WebGIS</h4>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <span class="px-2 py-1 rounded-md bg-slate-800 text-xs">Laravel 11</span>
                        <span class="px-2 py-1 rounded-md bg-slate-800 text-xs">PostgreSQL</span>
                        <span class="px-2 py-1 rounded-md bg-slate-800 text-xs">PostGIS Ext</span>
                        <span class="px-2 py-1 rounded-md bg-slate-800 text-xs">Leaflet JS</span>
                        <span class="px-2 py-1 rounded-md bg-slate-800 text-xs">Tailwind CSS</span>
                    </div>
                </div>
                <div class="bg-slate-900/30 border border-slate-800/60 rounded-2xl p-6 backdrop-blur-sm">
                    <h4 class="font-bold text-base text-emerald-400">Sasaran Pengguna</h4>
                    <p class="mt-2 text-xs text-slate-400 leading-relaxed">
                        Dirancang optimal bagi kolaborasi interaktif antara <span class="text-slate-200 font-semibold">Masyarakat Umum</span> untuk evakuasi mandiri, serta <span class="text-slate-200 font-semibold">Pemerintah / Instansi</span> terkait manajemen koordinasi.
                    </p>
                </div>
            </section>

            <section class="pt-8 border-t border-slate-800/50">
                <div class="bg-gradient-to-br from-[#0b1329] to-[#0f172a] border border-slate-800 rounded-3xl p-8 lg:p-12 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 text-7xl opacity-5 select-none pointer-events-none">🗺️</div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        <div class="lg:col-span-7 space-y-4 text-slate-300 text-sm leading-relaxed">
                            <p>
                                SIGAB DIY dikembangkan sebagai implementasi Sistem Informasi Geografis berbasis Web untuk mendukung penyajian informasi kebencanaan secara lebih informatif, interaktif, dan mudah diakses.
                            </p>
                            <p>
                                Melalui integrasi peta interaktif, basis data spasial, serta fitur navigasi, sistem ini diharapkan dapat membantu proses pemantauan, dokumentasi, dan pengambilan keputusan terkait kebencanaan.
                            </p>
                        </div>

                        <div class="lg:col-span-5">
                            <div class="relative group">
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-cyan-500 to-emerald-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-300"></div>

                                <div class="relative rounded-2xl bg-slate-950/50 border border-cyan-500/20 p-6 backdrop-blur-xl shadow-lg space-y-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-cyan-500 to-emerald-500 flex items-center justify-center text-xl shadow-inner">
                                            🎓
                                        </div>
                                        <div>
                                            <div class="text-xs uppercase font-bold tracking-wider text-cyan-400">Dikembangkan Oleh</div>
                                            <h4 class="font-bold text-white text-base">Hilmi Ahmad Dzakwan</h4>
                                        </div>
                                    </div>

                                    <div class="text-xs text-slate-400 space-y-1 border-t border-slate-800/80 pt-3">
                                        <p class="text-slate-300 font-medium">Program Studi Sistem Informasi Geografis</p>
                                        <p>Universitas Gadjah Mada</p>
                                        <p class="pt-2 text-[11px] font-mono text-slate-500">Praktikum Pemrograman Geospasial Web Lanjut</p>
                                        <p class="text-[11px] font-mono text-slate-500">2026</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <footer class="text-center text-slate-500 text-xs pt-4">
                <div class="max-w-2xl mx-auto space-y-1">
                    <div class="font-bold text-slate-400 tracking-wide">SIGAB DIY</div>
                    <div>Sistem Informasi Geospasial Kebencanaan Daerah Istimewa Yogyakarta</div>
                    <div class="text-[11px] text-slate-600 pt-2">© 2026 SIGAB DIY — Developed by Hilmi Ahmad Dzakwan</div>
                </div>
            </footer>
        </div>
    </div>
</x-app-layout>
