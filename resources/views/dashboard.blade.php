<x-app-layout>
    <div class="min-h-screen bg-gradient-to-b from-[#020617] via-[#071028] to-[#0F172A] text-slate-100 antialiased overflow-x-hidden">
        <div class="max-w-7xl mx-auto px-6 py-12 space-y-20">

            <section class="relative transition-all duration-300 transform hover:translate-y-[-2px]">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-5 space-y-6">
                        <div class="inline-flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/30 text-xs font-bold text-cyan-400 tracking-wider uppercase">Dashboard Utama</span>
                            <span class="px-3 py-1 rounded-full bg-slate-800/50 border border-slate-700/50 text-xs text-slate-300">v2.0 Beta</span>
                        </div>

                        <h1 class="text-4xl lg:text-6xl font-extrabold tracking-tight text-white leading-none">
                            SIGAB DIY
                        </h1>
                        <h2 class="text-xl lg:text-2xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-emerald-400">
                            Sistem Informasi Geospasial Kebencanaan Daerah Istimewa Yogyakarta
                        </h2>

                        <p class="text-slate-300 leading-relaxed text-base">
                            Platform WebGIS untuk visualisasi, pengelolaan, dan analisis data kebencanaan berbasis peta interaktif.
                        </p>

                        <div class="pt-4 flex flex-wrap items-center gap-4">
                            <a href="/peta" class="px-5 py-3 rounded-xl bg-gradient-to-r from-cyan-500 to-emerald-500 text-slate-950 font-bold shadow-lg shadow-cyan-500/20 hover:shadow-cyan-500/40 transition-all duration-300 transform hover:scale-[1.02]">
                                Buka Peta Interaktif
                            </a>
                            <a href="/dashboard/database" class="px-5 py-3 rounded-xl bg-slate-800/80 border border-slate-700/60 text-slate-200 font-medium hover:bg-slate-700/80 transition-all duration-300">
                                Database Kebencanaan
                            </a>
                            <a href="/tentang" class="px-5 py-3 rounded-xl bg-slate-900/60 border border-slate-800/80 text-slate-400 font-medium hover:text-slate-200 hover:bg-slate-800/40 transition-all duration-300">
                                Tentang Sistem
                            </a>
                        </div>
                    </div>

                    <div class="lg:col-span-7 relative group">
                        <div class="absolute -inset-1.5 bg-gradient-to-r from-cyan-500 to-emerald-500 rounded-3xl blur opacity-20 group-hover:opacity-35 transition duration-300"></div>

                        <div class="relative rounded-3xl bg-slate-900/40 border border-white/10 p-3 backdrop-blur-md overflow-hidden shadow-2xl shadow-cyan-950/50">
                            <div class="overflow-hidden rounded-2xl bg-slate-950">
                                <img src="{{ asset('images/dashboard/dashboard-overview.png') }}" alt="Dashboard Overview" class="w-full h-auto object-cover transform group-hover:scale-[1.02] transition-transform duration-300">
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-6 rounded-2xl bg-slate-900/40 border border-slate-800/80 shadow-lg backdrop-blur-sm relative overflow-hidden group hover:border-emerald-500/30 transition-all duration-300">
                    <div class="absolute top-0 right-0 p-4 text-4xl opacity-10 group-hover:opacity-20 transition-opacity">📍</div>
                    <p class="text-sm font-medium text-slate-400">Total Pos Kebencanaan</p>
                    <p class="text-3xl font-extrabold text-white mt-2 font-mono">
                        {{ $totalPosko ?? '0' }}
                    </p>
                    <div class="text-[11px] text-emerald-400 mt-2 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Terpetakan secara spasial
                    </div>
                </div>

                <div class="p-6 rounded-2xl bg-slate-900/40 border border-slate-800/80 shadow-lg backdrop-blur-sm relative overflow-hidden group hover:border-red-500/30 transition-all duration-300">
                    <div class="absolute top-0 right-0 p-4 text-4xl opacity-10 group-hover:opacity-20 transition-opacity">⚠️</div>
                    <p class="text-sm font-medium text-slate-400">Total Riwayat Bencana</p>
                    <p class="text-3xl font-extrabold text-white mt-2 font-mono">
                        {{ $totalBencana ?? $totalRiwayat ?? '0' }}
                    </p>
                    <div class="text-[11px] text-red-400 mt-2 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Catatan kejadian bencana
                    </div>
                </div>

                <div class="p-6 rounded-2xl bg-slate-900/40 border border-slate-800/80 shadow-lg backdrop-blur-sm relative overflow-hidden group hover:border-cyan-500/30 transition-all duration-300">
                    <div class="absolute top-0 right-0 p-4 text-4xl opacity-10 group-hover:opacity-20 transition-opacity">👥</div>
                    <p class="text-sm font-medium text-slate-400">Total Pengguna Sistem</p>
                    <p class="text-3xl font-extrabold text-white mt-2 font-mono">
                        {{ $totalPengguna ?? $totalUser ?? '0' }}
                    </p>
                    <div class="text-[11px] text-cyan-400 mt-2 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span> Akun terdaftar
                    </div>
                </div>

                <div class="p-6 rounded-2xl bg-slate-900/40 border border-slate-800/80 shadow-lg backdrop-blur-sm relative overflow-hidden group hover:border-cyan-500/30 transition-all duration-300">
                    <div class="absolute top-0 right-0 p-4 text-4xl opacity-10 group-hover:opacity-20 transition-opacity">🌐</div>
                    <p class="text-sm font-medium text-slate-400">Status Sistem</p>
                    <p class="text-3xl font-extrabold text-emerald-400 mt-2 tracking-wide flex items-center gap-2">
                        ONLINE
                    </p>
                    <div class="text-[11px] text-slate-400 mt-2 flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span> Seluruh modul berjalan normal
                    </div>
                </div>
            </section>


            <section class="space-y-6">
                <div class="border-l-4 border-cyan-500 pl-4">
                    <h3 class="text-xl font-bold tracking-tight text-white">Akses Cepat Platform</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Navigasi instan menuju modul utama SIGAB DIY</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 rounded-2xl bg-slate-900/50 border border-slate-800/80 shadow-md transform hover:-translate-y-1 hover:shadow-cyan-500/10 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-cyan-500/10 border border-cyan-500/30 flex items-center justify-center text-xl text-cyan-400 mb-4 group-hover:bg-cyan-500 group-hover:text-slate-950 transition-all duration-300">
                                🗺️
                            </div>
                            <h4 class="text-base font-bold text-white group-hover:text-cyan-400 transition-colors duration-200">Peta Interaktif</h4>
                            <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                                Visualisasi spasial real-time, sebaran lokasi posko bencana, zonasi kerawanan, dan navigasi pencarian jalan terdekat.
                            </p>
                        </div>
                        <div class="mt-6 border-t border-slate-800/60 pt-4">
                            <a href="/peta" class="text-xs font-bold text-cyan-400 hover:text-cyan-300 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                                Buka Peta &rarr;
                            </a>
                        </div>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-900/50 border border-slate-800/80 shadow-md transform hover:-translate-y-1 hover:shadow-emerald-500/10 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-xl text-emerald-400 mb-4 group-hover:bg-emerald-500 group-hover:text-slate-950 transition-all duration-300">
                                🗄️
                            </div>
                            <h4 class="text-base font-bold text-white group-hover:text-emerald-400 transition-colors duration-200">Database Kebencanaan</h4>
                            <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                                Manajemen terpusat data posko taktis dan riwayat log bencana berbasis tabulasi data tabular yang terintegrasi PostGIS.
                            </p>
                        </div>
                        <div class="mt-6 border-t border-slate-800/60 pt-4">
                            <a href="/dashboard/database" class="text-xs font-bold text-emerald-400 hover:text-emerald-300 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                                Kelola Basis Data &rarr;
                            </a>
                        </div>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-900/50 border border-slate-800/80 shadow-md transform hover:-translate-y-1 hover:shadow-slate-500/10 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-slate-800/80 border border-slate-700/60 flex items-center justify-center text-xl text-slate-300 mb-4 group-hover:bg-slate-200 group-hover:text-slate-950 transition-all duration-300">
                                ℹ️
                            </div>
                            <h4 class="text-base font-bold text-white group-hover:text-slate-300 transition-colors duration-200">Tentang Sistem</h4>
                            <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                                Informasi lengkap mengenai latar belakang perancangan sistem informasi geografis, tujuan mitigasi, dan profil tim pengembang.
                            </p>
                        </div>
                        <div class="mt-6 border-t border-slate-800/60 pt-4">
                            <a href="/tentang" class="text-xs font-bold text-slate-400 hover:text-slate-200 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                                Detail Sistem &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </section>


            <section class="bg-[#0b1329]/40 border border-slate-800/80 rounded-3xl p-8 lg:p-12 relative overflow-hidden backdrop-blur-sm">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-7 group relative">
                        <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500 to-emerald-500 rounded-2xl blur opacity-15 group-hover:opacity-35 transition duration-300"></div>
                        <div class="relative rounded-2xl bg-slate-950 p-2 overflow-hidden shadow-xl border border-white/5">
                            <img src="{{ asset('images/dashboard/dashboard-map-preview.png') }}" alt="Map Preview" class="w-full h-auto object-cover transform group-hover:scale-[1.01] transition-transform duration-300">
                        </div>
                    </div>

                    <div class="lg:col-span-5 space-y-6">
                        <div class="space-y-1">
                            <h3 class="text-2xl font-bold tracking-tight text-white">Kapabilitas Spasial SIGAB</h3>
                            <p class="text-xs text-slate-400">Integrasi kapabilitas WebGIS mutakhir dalam satu aplikasi</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex items-start gap-2 p-3 rounded-xl bg-slate-900/60 border border-slate-800/50">
                                <span class="text-emerald-400 font-bold mt-0.5">✓</span>
                                <div>
                                    <h5 class="text-xs font-bold text-slate-200">Lokasi Real Time</h5>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Penentuan koordinat live GPS.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2 p-3 rounded-xl bg-slate-900/60 border border-slate-800/50">
                                <span class="text-cyan-400 font-bold mt-0.5">✓</span>
                                <div>
                                    <h5 class="text-xs font-bold text-slate-200">Posko Terdekat</h5>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Identifikasi fasilitas terdekat.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2 p-3 rounded-xl bg-slate-900/60 border border-slate-800/50">
                                <span class="text-emerald-400 font-bold mt-0.5">✓</span>
                                <div>
                                    <h5 class="text-xs font-bold text-slate-200">Routing Jalan</h5>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Pembuatan rute evakuasi jalan.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2 p-3 rounded-xl bg-slate-900/60 border border-slate-800/50">
                                <span class="text-red-400 font-bold mt-0.5">✓</span>
                                <div>
                                    <h5 class="text-xs font-bold text-slate-200">Deteksi Area Bencana</h5>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Zonasi area terdampak historis.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2 p-3 rounded-xl bg-slate-900/60 border border-slate-800/50">
                                <span class="text-cyan-400 font-bold mt-0.5">✓</span>
                                <div>
                                    <h5 class="text-xs font-bold text-slate-200">Database Kebencanaan</h5>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Penyimpanan terstruktur.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2 p-3 rounded-xl bg-slate-900/60 border border-slate-800/50">
                                <span class="text-emerald-400 font-bold mt-0.5">✓</span>
                                <div>
                                    <h5 class="text-xs font-bold text-slate-200">Visualisasi Spasial</h5>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Engine Leaflet & OSM.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</x-app-layout>
