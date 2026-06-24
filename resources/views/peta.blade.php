<x-app-layout>
    <!-- Leaflet & jQuery via CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fuse.js@7.0.0/dist/fuse.min.js"></script>

    <style>
        /* Custom UI Premium Glassmorphism & Leaflet Elements */
        .leaflet-popup-content-wrapper {
            border-radius: 1rem !important;
            padding: 4px !important;
            backdrop-filter: blur(12px);
            background: rgba(15, 23, 42, 0.95) !important;
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.5) !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .leaflet-popup-content {
            margin: 12px !important;
            width: 280px !important;
            color: #f1f5f9 !important;
        }
        .leaflet-popup-tip {
            background: rgba(15, 23, 42, 0.95) !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        /* Custom Tooltip Styling */
        .gis-tooltip {
            background: rgba(15, 23, 42, 0.85) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: #f8fafc !important;
            font-weight: 600 !important;
            font-size: 11px !important;
            border-radius: 0.5rem !important;
            padding: 4px 8px !important;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.3) !important;
        }
        .bg-sigab-dark-premium {
            background-color: #020617;
        }
        .glass-panel {
            backdrop-filter: blur(16px);
            background: rgba(15, 23, 42, 0.65);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .glass-panel-dark {
            backdrop-filter: blur(20px);
            background: rgba(2, 6, 23, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        #sidebar-left {
            position: relative;
            transition: transform 0.3s ease, width 0.3s ease, border 0.3s ease, padding 0.3s ease;
            min-width: 0;
        }

        #sidebar-left.sidebar-collapsed {
            width: 0 !important;
            min-width: 0 !important;
            transform: translateX(-100%);
            border-right: 0 !important;
            overflow: visible;
            padding: 0 !important;
        }

        #sidebar-left.sidebar-collapsed > :not(#collapse-sidebar-toggle) {
            opacity: 0;
            pointer-events: none;
        }

        #collapse-sidebar-toggle {
            position: absolute;
            top: 50%;
            right: -24px;
            transform: translateY(-50%);
            width: 44px;
            height: 96px;
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, 0.16);
            background: rgba(15, 23, 42, 0.95);
            color: #cbd5e1;
            box-shadow: 0 22px 40px rgba(0, 0, 0, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 50;
        }

        #collapse-sidebar-toggle:hover {
            background: rgba(15, 23, 42, 1);
        }

        #sidebar-left.sidebar-collapsed #collapse-sidebar-toggle {
            transform: translateY(-50%) translateX(16px);
        }

        /* Menyembunyikan default attribute control agar UI bersih */
        .leaflet-control-attribution {
            background: rgba(15, 23, 42, 0.6) !important;
            color: #64748b !important;
            font-size: 9px !important;
        }
        /* Custom scrollbar untuk sidebar kiri */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 9999px;
        }
    </style>

    <!-- MAIN DASHBOARD CONTENT CONTAINER -->
    <div class="h-screen w-screen bg-sigab-dark-premium overflow-hidden flex relative font-sans text-slate-200">

        <!-- SIDEBAR KIRI (25% - 30% Width) -->
        <aside id="sidebar-left" class="w-80 md:w-96 h-full flex flex-col justify-between bg-[#0f172a] border-r border-slate-800/80 transition-all duration-300 z-30 shrink-0 relative">
            <div class="flex flex-col flex-1 min-h-0">
                <!-- Header Aplikasi -->
                <div class="p-5 border-b border-slate-800/60 bg-[#020617]/40 flex items-center gap-3">
    <div class="h-9 w-9 rounded-xl bg-slate-800/80 border border-slate-700/60 flex items-center justify-center text-slate-300 shadow-md">
        💻
    </div>
    <div>
        <div class="flex items-center gap-1.5">
            <h2 class="text-xs font-bold uppercase tracking-widest text-slate-200">Panel Kendali</h2>
            <span class="px-1.5 py-0.5 bg-amber-500/10 text-amber-400 text-[9px] font-mono rounded ring-1 ring-amber-500/20">LIVE</span>
        </div>
        <p class="text-[10px] text-slate-400 font-medium tracking-wide">Digitasi & Manajemen Data Spasial</p>
    </div>
</div>

                <!-- Konten Internal Scrollable -->
                <div class="p-5 flex-1 overflow-y-auto custom-scrollbar space-y-6">

                    <!-- NOTIFIKASI INFORMASI ALERT -->
                    @if(session('success'))
                        <div class="p-3 bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 rounded-xl text-xs flex items-start gap-2 shadow-sm animate-fade-in">
                            <span class="mt-0.5">🔔</span>
                            <div><span class="font-bold">Sukses:</span> {{ session('success') }}</div>
                        </div>
                    @endif

                    <!-- STATISTIK REALTIME DATA -->
                    <div>
                        <h2 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Monitoring Statistik</h2>
                        <div class="grid grid-cols-3 gap-2.5">
                            <div class="p-3 rounded-xl bg-[#020617]/60 border border-slate-800 text-center hover:scale-[1.03] transition-transform shadow-md">
                                <div id="stat-pos-count" class="text-base font-extrabold text-amber-400">12</div>
                                <div class="text-[9px] font-medium text-slate-400 mt-1 leading-tight">Pos Kebencanaan</div>
                            </div>
                            <div class="p-3 rounded-xl bg-[#020617]/60 border border-slate-800 text-center hover:scale-[1.03] transition-transform shadow-md">
                                <div id="stat-area-count" class="text-base font-extrabold text-red-400">5</div>
                                <div class="text-[9px] font-medium text-slate-400 mt-1 leading-tight">Area Bencana</div>
                            </div>
                            <div class="p-3 rounded-xl bg-[#020617]/60 border border-slate-800 text-center hover:scale-[1.03] transition-transform shadow-md flex flex-col justify-center items-center">
                                <div class="h-2 w-2 rounded-full bg-emerald-500 animate-ping absolute"></div>
                                <div class="h-2 w-2 rounded-full bg-emerald-500"></div>
                                <div class="text-[9px] font-bold text-emerald-400 mt-2 tracking-wider uppercase">Online</div>
                            </div>
                        </div>
                    </div>

                    <!-- FITUR UTAMA OPERASIONAL (FULL WIDTH ACTION BUTTONS) -->
                    <div class="space-y-3 pt-2">
                        <h2 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Aksi Manajemen Spasial</h2>

                        <!-- Tambah Pos Baru -->
                        <button type="button" id="btn-add-post" onclick="setMode('add-post')" class="btn-tool w-full flex items-center justify-between gap-3 rounded-xl bg-slate-800/80 border border-slate-700/50 text-slate-200 px-4 py-3.5 text-xs font-bold transition-all duration-200 hover:scale-[1.01] shadow-md group">
                            <div class="flex items-center gap-3">
                                <div class="h-7 w-7 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-400 ring-1 ring-amber-500/30 group-hover:bg-amber-500 group-hover:text-slate-950 transition-colors">
                                    📍
                                </div>
                                <span class="tracking-wide">Tambah Posko Kebencanaan</span>
                            </div>
                            <span class="text-[9px] px-2 py-0.5 bg-slate-900 rounded-md text-amber-400 font-mono">POINT</span>
                        </button>

                        <!-- Tambah Riwayat Area Bencana (Teks disesuaikan sesuai permintaan) -->
                        <button type="button" id="btn-add-history" onclick="setMode('add-history')" class="btn-tool w-full flex items-center justify-between gap-3 rounded-xl bg-slate-800/80 border border-slate-700/50 text-slate-200 px-4 py-3.5 text-xs font-bold transition-all duration-200 hover:scale-[1.01] shadow-md group">
                            <div class="flex items-center gap-3 text-left">
                                <div class="h-7 w-7 shrink-0 rounded-lg bg-red-500/10 flex items-center justify-center text-red-400 ring-1 ring-red-500/30 group-hover:bg-red-500 group-hover:text-white transition-colors">
                                    🌋
                                </div>
                                <span class="tracking-wide leading-tight">Input Riwayat Area Bencana</span>
                            </div>
                            <span class="text-[9px] px-2 py-0.5 bg-slate-900 rounded-md text-red-400 font-mono shrink-0">POLYGON</span>
                        </button>

                        <!-- Selesai Digitasi Button (Hidden By Default, Triggered dynamically) -->
                        <button type="button" id="btn-done-polygon" onclick="selesaiDigitasiPolygon()" class="w-full hidden items-center justify-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-3.5 text-xs font-black shadow-lg shadow-emerald-600/20 animate-bounce transition-all">
                            💾 SELESAI DIGITASI AREA (SIMPAN)
                        </button>
                    </div>

                </div>
            </div>

            <!-- Bagian Info Mode Aktif Footer Sidebar -->
            <div class="p-4 border-t border-slate-800/80 bg-[#020617]/60 flex items-center justify-between">
                <div>
                    <p class="text-[9px] font-bold text-slate-500 uppercase tracking-wider">Engine Spasial</p>
                    <p id="status-mode" class="text-[11px] font-bold text-sky-400 mt-0.5">Mode: Navigasi Peta</p>
                </div>
                <div class="text-[10px] text-slate-500 font-mono">v12.0 (PostGIS)</div>
            </div>

            <!-- BUTTON COLLAPSE SIDEBAR (MELAYANG DI SISI KANAN SIDEBAR) -->
            <button id="collapse-sidebar-toggle" type="button" onclick="toggleSidebar()" class="cursor-pointer">
                <span id="collapse-icon">◀</span>
            </button>
        </aside>

        <!-- MAP VIEWPORT CONTAINER PANEL (CASING CASING PREMIUM) -->
        <main class="flex-1 h-full p-3 md:p-4 bg-sigab-dark-premium relative z-10 flex flex-col">
            <div class="w-full h-full rounded-2xl border border-slate-800/80 overflow-hidden relative shadow-inner bg-[#020617] flex-1">

                <!-- LEAFLET MOUNT INSTANCE -->
                <div id="map" class="w-full h-full" style="z-index: 1; cursor: grab;"></div>

                <!-- FLOATING INTERACTION LAYER OVER THE MAP -->

                <!-- FLOATING TOOL GIS COMPACT BAR (Pojok Kiri Atas Peta) -->
                <div class="absolute left-4 top-4 z-20 flex flex-col gap-1 shadow-2xl glass-panel p-1 rounded-xl">
                    <button type="button" id="btn-pan" onclick="setMode('pan')" title="Navigasi Peta" class="btn-tool h-9 w-9 flex items-center justify-center rounded-lg bg-sky-600 text-white font-bold text-sm transition shadow-sm">
                        🖐
                    </button>
                    <button type="button" id="btn-select" onclick="setMode('select')" title="Atribut Identifikasi" class="btn-tool h-9 w-9 flex items-center justify-center rounded-lg bg-slate-900/60 text-slate-300 hover:bg-slate-800 text-sm transition">
                        ⌖
                    </button>
                    <div class="w-full h-[1px] bg-slate-700/50 my-0.5"></div>
                    <button type="button" onclick="map.zoomIn()" title="Zoom In" class="h-9 w-9 flex items-center justify-center rounded-lg bg-slate-900/60 text-slate-300 hover:bg-slate-800 text-sm font-bold transition">
                        ➕
                    </button>
                    <button type="button" onclick="map.zoomOut()" title="Zoom Out" class="h-9 w-9 flex items-center justify-center rounded-lg bg-slate-900/60 text-slate-300 hover:bg-slate-800 text-sm font-bold transition">
                        ➖
                    </button>
                </div>

                <!-- FLOATING SEARCH BAR MODERN (Atas Tengah Peta) -->
                <div class="absolute left-1/2 -translate-x-1/2 top-4 z-20 w-full max-w-sm px-4">
    <div class="relative w-full">
        <div class="w-full rounded-full glass-panel-dark shadow-2xl border border-white/10 flex items-center p-1 bg-slate-900/90 backdrop-blur-md">
            <span class="pl-3 pr-2 text-slate-400 text-sm">🔍</span>
            <input type="text" id="search-input" placeholder="Cari posko, lokasi, atau area bencana..."
            class="w-full bg-transparent border-none text-xs text-slate-100 placeholder-slate-400/70 focus:ring-0 focus:outline-none py-1.5 pr-4">
        </div>

        <div id="search-results-dropdown" class="absolute left-0 right-0 mt-1 hidden max-h-60 overflow-y-auto rounded-xl
        border border-slate-700/60 bg-slate-900/95 p-1.5 shadow-2xl backdrop-blur-md z-50"></div>
    </div>
</div>

                <!-- FLOATING LOCATION & DISASTER TOOLS (Kanan Atas Peta) -->
                <div class="absolute right-4 top-4 z-20 flex flex-col gap-2">
                    <button type="button" title="Deteksi Lokasi Saya" class="flex items-center gap-2 px-3.5 py-2.5 rounded-xl glass-panel-dark text-xs font-bold text-slate-200 hover:bg-slate-800/90 border border-white/5 shadow-xl hover:scale-[1.02] transition-all">
                        <span>📍</span> Lokasi Saya
                    </button>
                    <button type="button" title="Analisis Posko Terdekat" class="flex items-center gap-2 px-3.5 py-2.5 rounded-xl glass-panel-dark text-xs font-bold text-slate-200 hover:bg-slate-800/90 border border-white/5 shadow-xl hover:scale-[1.02] transition-all">
                        <span>🧭</span> Posko Terdekat
                    </button>
                </div>

                <!-- FLOATING SYSTEM MAP PANEL CARD (Pojok Kanan Bawah Peta) -->
                <div class="absolute right-4 bottom-4 z-20 w-52 p-4 rounded-2xl glass-panel shadow-2xl text-[11px] space-y-2 border border-white/10">
                    <div class="flex items-center justify-between border-b border-slate-700/50 pb-1.5">
                        <span class="font-bold text-slate-400 uppercase tracking-wider">Status Sistem</span>
                        <span class="text-emerald-400 font-bold flex items-center gap-1"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Live</span>
                    </div>
                    <div class="flex justify-between text-slate-300">
                        <span>Total Pos Terbuka:</span>
                        <span id="panel-pos-count" class="font-mono font-bold text-amber-400">0</span>
                    </div>
                    <div class="flex justify-between text-slate-300">
                        <span>Cakupan Bencana:</span>
                        <span id="panel-area-count" class="font-mono font-bold text-red-400">0</span>
                    </div>
                    <div class="flex justify-between text-slate-300">
                        <span>Operator Sesi:</span>
                        <span class="font-mono text-sky-400 font-semibold">Online</span>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- MODAL INPUT POS KEBENCANAAN BARU -->
    <div id="modalInputPos" class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm hidden justify-center items-center opacity-0 transition-opacity duration-300" style="z-index: 9999;">
        <div class="bg-slate-900 text-slate-100 rounded-2xl p-6 w-full max-w-md shadow-2xl transform scale-95 transition-transform duration-300 border border-slate-800">
            <h3 class="text-base font-black text-white mb-4 border-b border-slate-800 pb-3 flex items-center gap-2">📍 Input Pos Kebencanaan Baru</h3>
            <form action="{{ route('disaster-posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="latitude" id="in_post_lat">
                <input type="hidden" name="longitude" id="in_post_lng">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Pos</label>
                    <input type="text" name="nama_pos" required class="mt-1 block w-full rounded-xl bg-slate-950 border-slate-800 text-slate-200 text-xs focus:ring-amber-500 focus:border-amber-500 p-2.5">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jenis Pos</label>
                    <select name="jenis_pos" required class="mt-1 block w-full rounded-xl bg-slate-950 border-slate-800 text-slate-200 text-xs focus:ring-amber-500 focus:border-amber-500 p-2.5">
                        <option value="Posko Utama">Posko Utama</option>
                        <option value="Pos Pengungsian">Pos Pengungsian</option>
                        <option value="Pos Logistik">Pos Logistik</option>
                        <option value="Pos Kesehatan">Pos Kesehatan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Deskripsi / Fasilitas</label>
                    <textarea name="deskripsi" rows="2" class="mt-1 block w-full rounded-xl bg-slate-950 border-slate-800 text-slate-200 text-xs focus:ring-amber-500 focus:border-amber-500 p-2.5"></textarea>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Foto Pendukung (Tanpa Spasi)</label>
                    <input type="file" name="foto" accept="image/*" class="mt-1 block w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-bold file:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700">
                </div>
                <div class="flex justify-end space-x-2 pt-3 border-t border-slate-800">
                    <button type="button" onclick="tutupModal('modalInputPos')" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold rounded-xl transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-black rounded-xl shadow-lg shadow-amber-500/20 transition">Simpan Pos</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL INPUT RIWAYAT AREA BENCANA (POLYGON) -->
    <div id="modalInputHistory" class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm hidden justify-center items-center opacity-0 transition-opacity duration-300" style="z-index: 9999;">
        <div class="bg-slate-900 text-slate-100 rounded-2xl p-6 w-full max-w-md shadow-2xl transform scale-95 transition-transform duration-300 border border-slate-800">
            <h3 class="text-base font-black text-white mb-4 border-b border-slate-800 pb-3 flex items-center gap-2">🌋 Input Riwayat Area Bencana</h3>
            <form action="{{ route('disaster-histories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="coordinates" id="in_hist_coordinates">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Kejadian Bencana</label>
                    <input type="text" name="nama_bencana" required placeholder="Misal: Area Terdampak Luapan Lahar" class="mt-1 block w-full rounded-xl bg-slate-950 border-slate-800 text-slate-200 text-xs focus:ring-red-500 focus:border-red-500 p-2.5">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jenis Bencana</label>
                    <select name="jenis_bencana" required class="mt-1 block w-full rounded-xl bg-slate-950 border-slate-800 text-slate-200 text-xs focus:ring-red-500 focus:border-red-500 p-2.5">
                        <option value="Gunung Meletus">Gunung Meletus</option>
                        <option value="Gempa Bumi">Gempa Bumi</option>
                        <option value="Tanah Longsor">Tanah Longsor</option>
                        <option value="Banjir">Banjir</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tanggal Kejadian</label>
                    <input type="date" name="tanggal_kejadian" required class="mt-1 block w-full rounded-xl bg-slate-950 border-slate-800 text-slate-200 text-xs focus:ring-red-500 focus:border-red-500 p-2.5">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Deskripsi / Dampak</label>
                    <textarea name="keterangan" rows="2" placeholder="Tuliskan deskripsi luasan area dan kerugian..." class="mt-1 block w-full rounded-xl bg-slate-950 border-slate-800 text-slate-200 text-xs focus:ring-red-500 focus:border-red-500 p-2.5"></textarea>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Foto Dokumentasi (Tanpa Spasi)</label>
                    <input type="file" name="foto" accept="image/*" class="mt-1 block w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-bold file:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700">
                </div>
                <div class="flex justify-end space-x-2 pt-3 border-t border-slate-800">
                    <button type="button" onclick="cancelDigitasi()" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold rounded-xl transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white text-xs font-black rounded-xl shadow-lg shadow-red-600/20 transition">Simpan Area Riwayat</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT UNIVERSAL DATA SPASIAL -->
    <div id="modalEditUniversal" class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm hidden justify-center items-center opacity-0 transition-opacity duration-300" style="z-index: 9999;">
        <div class="bg-slate-900 text-slate-100 rounded-2xl p-6 w-full max-w-md shadow-2xl transform scale-95 transition-transform duration-300 border border-slate-800">
            <div class="flex justify-between items-center mb-4 border-b border-slate-800 pb-3">
                <h3 id="modal_title" class="text-base font-black text-white">Detail Entitas Spasial</h3>
                <button type="button" onclick="tutupModal('modalEditUniversal')" class="text-slate-400 hover:text-white text-xl font-bold leading-none">&times;</button>
            </div>

            <form id="form_edit_universal" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf @method('PUT')

                <!-- Field Khusus Pos Kebencanaan -->
                <div id="container_pos_fields">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Pos</label>
                        <input type="text" name="nama_pos" id="edit_nama_pos" class="mt-1 block w-full rounded-xl bg-slate-950 border-slate-800 text-slate-200 text-xs focus:ring-amber-500 focus:border-amber-500 p-2.5">
                    </div>
                    <div class="mt-3">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jenis Pos</label>
                        <select name="jenis_pos" id="edit_jenis_pos" class="mt-1 block w-full rounded-xl bg-slate-950 border-slate-800 text-slate-200 text-xs focus:ring-amber-500 focus:border-amber-500 p-2.5">
                            <option value="Posko Utama">Posko Utama</option>
                            <option value="Pos Pengungsian">Pos Pengungsian</option>
                            <option value="Pos Logistik">Pos Logistik</option>
                            <option value="Pos Kesehatan">Pos Kesehatan</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi_pos" rows="2" class="mt-1 block w-full rounded-xl bg-slate-950 border-slate-800 text-slate-200 text-xs focus:ring-amber-500 focus:border-amber-500 p-2.5"></textarea>
                    </div>
                </div>

                <!-- Field Khusus Riwayat Bencana -->
                <div id="container_history_fields" class="hidden">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Bencana</label>
                        <input type="text" name="nama_bencana" id="edit_nama_bencana" class="mt-1 block w-full rounded-xl bg-slate-950 border-slate-800 text-slate-200 text-xs focus:ring-amber-500 focus:border-amber-500 p-2.5">
                    </div>
                    <div class="mt-3">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jenis Bencana</label>
                        <select name="jenis_bencana" id="edit_jenis_bencana" class="mt-1 block w-full rounded-xl bg-slate-950 border-slate-800 text-slate-200 text-xs focus:ring-amber-500 focus:border-amber-500 p-2.5">
                            <option value="Gunung Meletus">Gunung Meletus</option>
                            <option value="Gempa Bumi">Gempa Bumi</option>
                            <option value="Tanah Longsor">Tanah Longsor</option>
                            <option value="Banjir">Banjir</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tanggal Kejadian</label>
                        <input type="date" name="tanggal_kejadian" id="edit_tanggal_bencana" class="mt-1 block w-full rounded-xl bg-slate-950 border-slate-800 text-slate-200 text-xs focus:ring-amber-500 focus:border-amber-500 p-2.5">
                    </div>
                    <div class="mt-3">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Keterangan / Dampak</label>
                        <textarea name="keterangan" id="edit_keterangan_bencana" rows="2" class="mt-1 block w-full rounded-xl bg-slate-950 border-slate-800 text-slate-200 text-xs focus:ring-amber-500 focus:border-amber-500 p-2.5"></textarea>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Ganti File Foto (Tanpa Spasi)</label>
                    <input type="file" name="foto" accept="image/*" class="mt-1 block w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-bold file:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700">
                </div>
                <div class="flex justify-end space-x-2 pt-3 border-t border-slate-800">
                    <button type="button" onclick="tutupModal('modalEditUniversal')" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold rounded-xl transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-black rounded-xl shadow-lg shadow-amber-500/20 transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Hidden Form Global Method Destroyer -->
    <form id="form_delete_universal" method="POST" class="hidden">
        @csrf @method('DELETE')
    </form>

    <!-- CORE GIS ENGINE JAVASCRIPT -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Setup dasar Peta Leaflet Yogyakarta
        const map = L.map('map', { zoomControl: false }).setView([-7.7956, 110.3695], 11);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(map);

        let currentMode = 'pan';

        // Variable pembantu digitasi polygon
        let activePolygonPoints = [];
        let tempPolygonLayer = null;
        let tempMarkers = [];

        // Fungsi Collapse / Hide Sidebar Kiri
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar-left');
            const icon = document.getElementById('collapse-icon');
            sidebar.classList.toggle('sidebar-collapsed');
            if (sidebar.classList.contains('sidebar-collapsed')) {
                icon.innerText = "▶";
            } else {
                icon.innerText = "◀";
            }
            setTimeout(() => { map.invalidateSize(); }, 310);
        }

        // Toolbar Mode Controller
        function setMode(mode) {
            currentMode = mode;
            // Reset style state dari semua tool button
            $('.btn-tool').removeClass('bg-sky-600 bg-emerald-600 bg-amber-600 bg-red-600 shadow-lg text-white ring-2 ring-amber-500/50 ring-red-500/50').addClass('bg-slate-900/60 text-slate-300 hover:bg-slate-800');
            $('#btn-done-polygon').addClass('hidden').removeClass('inline-flex');
            const mapContainer = document.getElementById('map');

            clearTempPolygon();

            if (mode === 'pan') {
                $('#btn-pan').removeClass('bg-slate-900/60 text-slate-300 hover:bg-slate-800').addClass('bg-sky-600 text-white shadow-lg');
                $('#status-mode').text('Mode: Navigasi Peta').className = "text-[11px] font-bold text-sky-400 mt-0.5";
                mapContainer.style.cursor = 'grab';
            } else if (mode === 'select') {
                $('#btn-select').removeClass('bg-slate-900/60 text-slate-300 hover:bg-slate-800').addClass('bg-emerald-600 text-white shadow-lg');
                $('#status-mode').text('Mode: Telusuri Atribut Data').className = "text-[11px] font-bold text-emerald-400 mt-0.5";
                mapContainer.style.cursor = 'help';
            } else if (mode === 'add-post') {
                $("[id='btn-add-post']").removeClass('bg-slate-900/60 text-slate-300 bg-slate-800/60').addClass('bg-amber-600 text-white shadow-lg ring-2 ring-amber-500/50');
                $('#status-mode').text('Mode: Tambah Pos Baru').className = "text-[11px] font-bold text-amber-400 mt-0.5";
                mapContainer.style.cursor = 'crosshair';
            } else if (mode === 'add-history') {
                $("[id='btn-add-history']").removeClass('bg-slate-900/60 text-slate-300 bg-slate-800/60').addClass('bg-red-600 text-white shadow-lg ring-2 ring-red-500/50');
                $('#status-mode').text('Mode: Gambar Area Bencana').className = "text-[11px] font-bold text-red-400 mt-0.5";
                mapContainer.style.cursor = 'polyline';
                $('#btn-done-polygon').removeClass('hidden').addClass('inline-flex');
            }
        }

        // Logic Click Event Handler Pada Peta
        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            if (currentMode === 'add-post') {
                if (window.autoAddPosko) {
                    // Create a temporary marker to show selection
                    const autoMarker = L.marker([lat, lng]).addTo(map);
                    tempMarkers.push(autoMarker);

                    document.getElementById('in_post_lat').value = lat.toFixed(6);
                    document.getElementById('in_post_lng').value = lng.toFixed(6);

                    // clear UI badge and flag, then open modal for final input
                    removeModeBadge();
                    window.autoAddPosko = false;
                    bukaModal('modalInputPos');
                } else {
                    document.getElementById('in_post_lat').value = lat.toFixed(6);
                    document.getElementById('in_post_lng').value = lng.toFixed(6);
                    bukaModal('modalInputPos');
                }
            } else if (currentMode === 'add-history') {
                activePolygonPoints.push([lat, lng]);

                let m = L.circleMarker([lat, lng], { radius: 5, color: '#dc2626', fillColor: '#ffffff', fillOpacity: 1, weight: 2 }).addTo(map);
                tempMarkers.push(m);

                if (activePolygonPoints.length > 1) {
                    if (tempPolygonLayer) {
                        map.removeLayer(tempPolygonLayer);
                    }
                    tempPolygonLayer = L.polygon(activePolygonPoints, { color: '#dc2626', fillColor: '#ef4444', fillOpacity: 0.4, weight: 2 }).addTo(map);
                }
            }
        });

        function selesaiDigitasiPolygon() {
            if (activePolygonPoints.length < 3) {
                alert('Minimal tentukan 3 titik di peta untuk membentuk area cakupan bencana!');
                return;
            }
            document.getElementById('in_hist_coordinates').value = JSON.stringify(activePolygonPoints);
            // If auto-draw mode was active, clear badge and flag after polygon is finished
            if (window.autoDrawPolygon) {
                removeModeBadge();
                window.autoDrawPolygon = false;
            }
            bukaModal('modalInputHistory');
        }

        function clearTempPolygon() {
            activePolygonPoints = [];
            if (tempPolygonLayer) { map.removeLayer(tempPolygonLayer); tempPolygonLayer = null; }
            tempMarkers.forEach(m => map.removeLayer(m));
            tempMarkers = [];
        }

        function cancelDigitasi() {
            tutupModal('modalInputHistory');
            clearTempPolygon();
            // also clear any auto-mode flags/badges
            window.autoDrawPolygon = false;
            window.autoAddPosko = false;
            removeModeBadge();
            setMode('pan');
        }

        // Show a small badge overlay on the map when auto-mode is active
        function showModeBadge(title, subtitle) {
            removeModeBadge();
            const container = document.getElementById('map');
            if (!container) return;
            const badge = document.createElement('div');
            badge.id = 'auto-mode-badge';
            badge.className = 'z-50 pointer-events-none';
            badge.style.position = 'absolute';
            badge.style.top = '12px';
            badge.style.left = '50%';
            badge.style.transform = 'translateX(-50%)';
            badge.style.padding = '8px 12px';
            badge.style.background = 'linear-gradient(90deg, rgba(0,0,0,0.6), rgba(2,6,23,0.6))';
            badge.style.border = '1px solid rgba(255,255,255,0.04)';
            badge.style.borderRadius = '10px';
            badge.style.color = '#fff';
            badge.style.fontSize = '12px';
            badge.style.textAlign = 'center';
            badge.innerHTML = `<div style="font-weight:800">${title}</div><div style="font-size:11px;margin-top:3px;color:#d1d5db">${subtitle}</div>`;
            container.parentElement.appendChild(badge);
        }

        function removeModeBadge() {
            const el = document.getElementById('auto-mode-badge');
            if (el && el.parentElement) el.parentElement.removeChild(el);
        }

        function bukaModal(id) {
            const el = document.getElementById(id);
            el.classList.remove('hidden'); el.classList.add('flex');
            setTimeout(() => { el.classList.remove('opacity-0'); el.querySelector('div').classList.remove('scale-95'); }, 10);
        }

        function tutupModal(id) {
            const el = document.getElementById(id);
            el.classList.add('opacity-0'); el.querySelector('div').classList.add('scale-95');
            setTimeout(() => { el.classList.remove('flex'); el.classList.add('hidden'); }, 300);
        }

        // LOAD DATA SPASIAL & REDRAW RENDERING UI
        function renderLayerData() {

            // 1. Fetch & Render Data Pos Kebencanaan (Point)
            $.getJSON("{{ route('api.disaster-posts') }}", function(data) {
                disasterPostsData = data;
                loadedPosts = true;
                updateSearchIndexIfReady();

                // Update text statistika di dashboard
                $('#stat-pos-count').text(data.length);
                $('#panel-pos-count').text(data.length);

                data.forEach(function(item) {
                    const marker = L.marker([item.latitude, item.longitude]).addTo(map);
                    registerSearchLayer('post', item.id, marker);

                    // TOOLTIP HOVER MODERN ON MARKER
                    marker.bindTooltip(`
                        <div class="text-left">
                            <div class="font-bold text-slate-100">⛺ ${item.nama_pos}</div>
                            <div class="text-[10px] text-amber-400 font-medium">${item.jenis_pos}</div>
                        </div>
                    `, { direction: 'top', className: 'gis-tooltip', sticky: true });

                    let fotoHtml = item.foto
                        ? `<img src="/storage/foto_pos/${item.foto}" class="w-full h-28 object-cover rounded-lg my-1.5 border border-slate-700">`
                        : `<div class="w-full h-16 bg-slate-950 text-slate-500 flex items-center justify-center text-[10px] rounded-lg my-1.5 border border-dashed border-slate-800">Tidak ada dokumentasi foto</div>`;

                    let popupContent = `
                        <div class="text-xs">
                            <div class="text-sm font-black text-white flex items-center gap-1">⛺ ${item.nama_pos}</div>
                            <div class="text-[10px] text-amber-400 font-bold mt-0.5">${item.jenis_pos}</div>
                            <div class="text-slate-300 mt-2 bg-slate-950/80 p-2 rounded-lg border border-slate-800 leading-relaxed">${item.deskripsi || 'Tidak ada deskripsi fasilitas.'}</div>
                            ${fotoHtml}
                            <div class="mt-3 flex flex-col gap-1">
                                <button type="button" onclick="bukaFormEdit('pos', ${item.id}, '${escape(item.nama_pos)}', '${escape(item.jenis_pos)}', '${escape(item.deskripsi || '')}', null)" class="w-full bg-amber-500 text-slate-950 font-bold py-1.5 rounded-lg text-center transition hover:bg-amber-400">✏️ Edit Pos</button>
                                <button type="button" onclick="eksekusiHapus('/disaster-posts/${item.id}')" class="w-full bg-red-600 text-white font-bold py-1.5 rounded-lg text-center transition hover:bg-red-500">🗑️ Hapus Pos</button>
                            </div>
                        </div>
                    `;

                    marker.bindPopup(popupContent);
                    marker.on('click', function(e) { if(currentMode !== 'select') map.closePopup(); });
                });
            });

            // 2. Fetch & Render Data Riwayat Bencana dari PostGIS (Polygon WKT String)
            $.getJSON("{{ route('api.disaster-histories') }}", function(data) {
                disasterHistoriesData = data;
                loadedHistories = true;
                updateSearchIndexIfReady();

                // Update text statistika di dashboard
                $('#stat-area-count').text(data.length);
                $('#panel-area-count').text(data.length);

                data.forEach(function(item) {
                    if (!item.geometry_wkt) return;

                    let coords = [];
                    try {
                        let wktRaw = item.geometry_wkt.replace(/polygon\(\(/i, "").replace(/\)\)/, "");
                        let splitPoints = wktRaw.split(",");

                        splitPoints.forEach(function(pt) {
                            let coordPair = pt.trim().split(/\s+/);
                            if (coordPair.length === 2) {
                                let lng = parseFloat(coordPair[0]);
                                let lat = parseFloat(coordPair[1]);
                                if (!isNaN(lat) && !isNaN(lng)) {
                                    coords.push([lat, lng]);
                                }
                            }
                        });
                    } catch(e) {
                        console.error("Gagal parsing WKT PostGIS ID: " + item.id, e);
                        return;
                    }

                    if (coords.length < 3) return;

                    // Render Polygon ke layer map
                    const polygonArea = L.polygon(coords, {
                        color: "#dc2626", weight: 2.5, opacity: 0.9, fillColor: "#ef4444", fillOpacity: 0.35
                    }).addTo(map);
                    registerSearchLayer('history', item.id, polygonArea);

                    // TOOLTIP HOVER MODERN ON POLYGON
                    polygonArea.bindTooltip(`
                        <div class="text-left">
                            <div class="font-bold text-slate-100">🌋 ${item.nama_bencana}</div>
                            <div class="text-[10px] text-red-400 font-medium">${item.jenis_bencana} (${item.tanggal_kejadian})</div>
                        </div>
                    `, { direction: 'center', className: 'gis-tooltip', sticky: true });

                    let fotoHtml = item.foto
                        ? `<img src="/storage/foto_bencana/${item.foto}" class="w-full h-28 object-cover rounded-lg my-1.5 border border-slate-700">`
                        : `<div class="w-full h-16 bg-slate-950 text-slate-500 flex items-center justify-center text-[10px] rounded-lg my-1.5 border border-dashed border-slate-800">Tidak ada dokumentasi foto</div>`;

                    let popupContent = `
                        <div class="text-xs">
                            <div class="text-sm font-black text-white flex items-center gap-1">🌋 ${item.nama_bencana}</div>
                            <div class="text-[10px] text-red-400 font-bold mt-0.5">Jenis: ${item.jenis_bencana} (${item.tanggal_kejadian})</div>
                            <div class="text-slate-300 mt-2 bg-slate-950/80 p-2 rounded-lg border border-slate-800 leading-relaxed">${item.keterangan || 'Tidak ada keterangan.'}</div>
                            ${fotoHtml}
                            <div class="mt-3 flex flex-col gap-1">
                                <button type="button" onclick="bukaFormEdit('history', ${item.id}, '${escape(item.nama_bencana)}', '${escape(item.jenis_bencana)}', '${escape(item.keterangan || '')}', '${item.tanggal_kejadian}')" class="w-full bg-amber-500 text-slate-950 font-bold py-1.5 rounded-lg text-center transition hover:bg-amber-400">✏️ Edit Riwayat</button>
                                <button type="button" onclick="eksekusiHapus('/disaster-histories/${item.id}')" class="w-full bg-red-600 text-white font-bold py-1.5 rounded-lg text-center transition hover:bg-red-500">🗑️ Hapus Riwayat</button>
                            </div>
                        </div>
                    `;

                    polygonArea.bindPopup(popupContent);
                    polygonArea.on('click', function(e) { if(currentMode !== 'select') map.closePopup(); });
                });
            });
        }

        // Logic Switch Form Edit Modal Universal (Tetap Utuh)
        function bukaFormEdit(type, id, name, category, desc, date) {
            if (type === 'pos') {
                $('#modal_title').text('✏️ Edit Pos Kebencanaan');
                $('#container_pos_fields').removeClass('hidden');
                $('#container_history_fields').addClass('hidden');
                document.getElementById('edit_nama_pos').value = unescape(name);
                document.getElementById('edit_jenis_pos').value = unescape(category);
                document.getElementById('edit_deskripsi_pos').value = unescape(desc);
                document.getElementById('form_edit_universal').action = `{{ url('/disaster-posts') }}/${id}`;
            } else {
                $('#modal_title').text('✏️ Edit Riwayat Area Bencana');
                $('#container_pos_fields').addClass('hidden');
                $('#container_history_fields').removeClass('hidden');
                document.getElementById('edit_nama_bencana').value = unescape(name);
                document.getElementById('edit_jenis_bencana').value = unescape(category);
                document.getElementById('edit_tanggal_bencana').value = date;
                document.getElementById('edit_keterangan_bencana').value = unescape(desc);
                document.getElementById('form_edit_universal').action = `{{ url('/disaster-histories') }}/${id}`;
            }
            bukaModal('modalEditUniversal');
        }

        function eksekusiHapus(urlAction) {
            if(confirm('Apakah anda yakin ingin menghapus data spasial ini secara permanen?')) {
                const form = document.getElementById('form_delete_universal');
                form.action = `{{ url('') }}${urlAction}`;
                form.submit();
            }
        }

        // Inisialisasi awal pemuatan layer data dan perbaikan ukuran rendering peta
        renderLayerData();

        setTimeout(function () {
            map.invalidateSize();
        }, 250);

        // Variables untuk manajemen pelacakan lokasi pengguna secara realtime
        let userLocationMarker = null;
        let userAccuracyCircle = null;
        let firstLocationFound = false;

        // Mencari tombol berdasarkan teks "Lokasi Saya" di dalam peta
        const btnLokasiSaya = Array.from(document.querySelectorAll('button, a')).find(el => el.textContent.includes('Lokasi Saya'));

        if (btnLokasiSaya) {
            btnLokasiSaya.addEventListener('click', function () {
                if (!navigator.geolocation) {
                    alert("Browser Anda tidak mendukung fitur Geolocation.");
                    return;
                }

                // Mengaktifkan pelacakan realtime koordinat GPS pengguna
                navigator.geolocation.watchPosition(
                    function (position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const accuracy = position.coords.accuracy;
                        const latlng = [lat, lng];

                        // Konten popup dinamis yang selalu diperbarui
                        const popupContent = `
                            <div class="font-sans text-xs p-1" style="color: #f1f5f9;">
                                <div class="text-sm font-bold text-white mb-2 flex items-center gap-1.5 border-b border-slate-700/50 pb-1">
                                    <span class="text-base">📍</span> Lokasi Saya
                                </div>
                                <div class="space-y-1 text-slate-300">
                                    <div>Latitude: <span class="font-mono font-bold text-amber-400">${lat.toFixed(6)}</span></div>
                                    <div>Longitude: <span class="font-mono font-bold text-amber-400">${lng.toFixed(6)}</span></div>
                                </div>
                                <div class="text-slate-400 mt-2 pt-1.5 border-t border-slate-700/40 italic text-[11px]">
                                    Akurasi GPS: <span class="text-emerald-400 font-semibold font-mono">${accuracy.toFixed(1)} meter</span>
                                </div>
                            </div>
                        `;

                        if (!userLocationMarker) {
                            // Membuat marker biru bergaya Google Maps & lingkaran akurasi pertama kali
                            userAccuracyCircle = L.circle(latlng, {
                                radius: accuracy,
                                color: '#3b82f6',
                                fillColor: '#93c5fd',
                                fillOpacity: 0.15,
                                weight: 1.5
                            }).addTo(map);

                            userLocationMarker = L.marker(latlng, {
                                icon: L.divIcon({
                                    className: 'custom-user-marker',
                                    html: `<div class="relative flex h-4 w-4">
                                             <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                             <span class="relative inline-flex rounded-full h-4 w-4 bg-blue-600 border-2 border-white shadow-md"></span>
                                           </div>`,
                                    iconSize: [16, 16],
                                    iconAnchor: [8, 8]
                                })
                            }).addTo(map).bindPopup(popupContent);
                        } else {
                            // Memperbarui posisi & radius jika marker sudah terbuat sebelumnya
                            userLocationMarker.setLatLng(latlng).setPopupContent(popupContent);
                            userAccuracyCircle.setLatLng(latlng).setRadius(accuracy);
                        }

                        // Auto-zoom hanya berjalan satu kali di awal penemuan koordinat
                        if (!firstLocationFound) {
                            map.setView(latlng, 16);
                            firstLocationFound = true;
                        }
                    },
                    function (error) {
                        if (error.code === error.PERMISSION_DENIED) {
                            alert("Izin lokasi diperlukan untuk menampilkan posisi Anda.");
                        }
                    },
                    {
                        enableHighAccuracy: true,
                        maximumAge: 0,
                        timeout: 10000
                    }
                );
            });
        }

        // Variabel global menampung layer rute terdekat (Gunakan kembali yang sudah ada)
        if (typeof nearestRouteLayer === 'undefined') {
            var nearestRouteLayer = null;
        }

        // Mencari tombol berdasarkan teks "Posko Terdekat" secara dinamis
        const btnPoskoTerdekat = Array.from(document.querySelectorAll('button, a')).find(el => el.textContent.includes('Posko Terdekat'));

        if (btnPoskoTerdekat) {
            btnPoskoTerdekat.addEventListener('click', async function () {
                // 1. Pastikan lokasi pengguna tersedia
                if (!userLocationMarker) {
                    alert("Lokasi Anda belum ditemukan.");
                    return;
                }

                const userLatLng = userLocationMarker.getLatLng();
                const userLat = userLatLng.lat;
                const userLng = userLatLng.lng;

                // 2. Kumpulkan semua objek Polygon Riwayat Bencana yang aktif di peta Leaflet
                let disasterPolygons = [];
                map.eachLayer(function(layer) {
                    if (layer instanceof L.Polygon && !(layer instanceof L.Rectangle) && layer !== tempPolygonLayer && layer !== userAccuracyCircle) {
                        const latlngs = layer.getLatLngs()[0];
                        let geoJsonCoords = latlngs.map(pt => [pt.lng, pt.lat]);
                        if (geoJsonCoords.length > 0 &&
                            (geoJsonCoords[0][0] !== geoJsonCoords[geoJsonCoords.length - 1][0] ||
                             geoJsonCoords[0][1] !== geoJsonCoords[geoJsonCoords.length - 1][1])) {
                            geoJsonCoords.push([geoJsonCoords[0][0], geoJsonCoords[0][1]]);
                        }
                        try {
                            disasterPolygons.push(turf.polygon([geoJsonCoords]));
                        } catch (err) {
                            console.error("Gagal konversi ke Turf Polygon:", err);
                        }
                    }
                });

                // 3. Ambil seluruh data Pos Kebencanaan dari API endpoint
                $.getJSON("{{ route('api.disaster-posts') }}", async function(posts) {
                    if (!posts || posts.length === 0) {
                        alert("Tidak ada data Pos Kebencanaan yang tersedia di peta.");
                        return;
                    }

                    let allPostsWithRoutes = [];

                    // Request OSRM dengan mengaktifkan parameter rute alternatif (alternatives=true)
                    const promises = posts.map(async function(post) {
                        const url = `https://router.project-osrm.org/route/v1/driving/${userLng},${userLat};${post.longitude},${post.latitude}?overview=full&geometries=geojson&alternatives=true`;
                        try {
                            const response = await fetch(url);
                            const data = await response.json();

                            if (data.routes && data.routes.length > 0) {
                                // Tampung semua rute alternatif yang dikembalikan oleh OSRM untuk pos ini
                                let candidates = data.routes.map(route => ({
                                    distance: route.distance, // meter
                                    duration: route.duration, // detik
                                    coordinates: route.geometry.coordinates // GeoJSON [[lng, lat], ...]
                                }));

                                // Cari rute alternatif dengan jarak terpendek default (index 0) untuk acuan sorting awal pos terdekat
                                const defaultDistance = candidates[0].distance;

                                allPostsWithRoutes.push({
                                    post: post,
                                    defaultDistance: defaultDistance,
                                    routes: candidates
                                });
                            }
                        } catch (error) {
                            console.error("Gagal mengambil rute OSRM untuk pos: " + post.nama_pos, error);
                        }
                    });

                    // Tunggu semua request OSRM selesai
                    await Promise.all(promises);

                    // Prioritas 1: Urutkan posko berdasarkan jarak rute utama paling dekat (Ascending)
                    allPostsWithRoutes.sort((a, b) => a.defaultDistance - b.defaultDistance);

                    let safeNearestPost = null;
                    let safeRouteCoordinates = null;
                    let safeDistance = null;
                    let safeDuration = null;

                    // Lakukan pengecekan berjenjang per posko
                    for (let i = 0; i < allPostsWithRoutes.length; i++) {
                        const currentPostData = allPostsWithRoutes[i];

                        // Kumpulkan alternatif rute khusus untuk pos ini yang lolos/aman dari polygon bencana
                        let safeAlternativesForThisPost = [];

                        for (let r = 0; r < currentPostData.routes.length; r++) {
                            const routeOption = currentPostData.routes[r];
                            const turfLine = turf.lineString(routeOption.coordinates);
                            let isIntersect = false;

                            // Periksa persinggungan dengan semua polygon bencana
                            for (let j = 0; j < disasterPolygons.length; j++) {
                                if (turf.booleanIntersects(turfLine, disasterPolygons[j])) {
                                    isIntersect = true;
                                    break;
                                }
                            }

                            // Jika rute alternatif ini aman, masukkan ke dalam daftar kandidat rute aman pos ini
                            if (!isIntersect) {
                                safeAlternativesForThisPost.push(routeOption);
                            }
                        }

                        // Perilaku baru: Jika ada alternatif rute yang aman untuk POS YANG SAMA
                        if (safeAlternativesForThisPost.length > 0) {
                            // Prioritas 3: Cari jarak rute paling pendek di antara rute alternatif aman tersebut
                            safeAlternativesForThisPost.sort((a, b) => a.distance - b.distance);

                            const bestSafeRoute = safeAlternativesForThisPost[0];
                            safeNearestPost = currentPostData.post;
                            safeRouteCoordinates = bestSafeRoute.coordinates;
                            safeDistance = bestSafeRoute.distance;
                            safeDuration = bestSafeRoute.duration;

                            // Berhenti dari loop pos karena pos terdekat ini memiliki jalur alternatif yang aman
                            break;
                        }

                        // HANYA JIKA seluruh alternatif rute menuju pos ini memotong polygon, loop berlanjut ke pos berikutnya
                        console.log(`Seluruh rute menuju ${currentPostData.post.nama_pos} terblokir area bencana. Mencari pos berikutnya...`);
                    }

                    // 4. Visualisasi Hasil Evaluasi Rute ke Peta
                    if (nearestRouteLayer) {
                        map.removeLayer(nearestRouteLayer);
                    }

                    if (safeNearestPost && safeRouteCoordinates) {
                        const leafletCoords = safeRouteCoordinates.map(coord => [coord[1], coord[0]]);

                        // Gambar polyline rute aman berwarna hijau (#10B981)
                        nearestRouteLayer = L.polyline(leafletCoords, {
                            color: '#10B981',
                            weight: 6,
                            opacity: 0.85
                        }).addTo(map);

                        map.fitBounds(nearestRouteLayer.getBounds(), { padding: [50, 50] });

                        const distanceKm = (safeDistance / 1000).toFixed(2);
                        const durationMinutes = Math.ceil(safeDuration / 60);

                        const popupContent = `
                            <div class="font-sans text-xs p-1" style="color: #f1f5f9;">
                                <div class="text-sm font-bold text-emerald-400 mb-2 flex items-center gap-1.5 border-b border-slate-700/50 pb-1">
                                    <span>🟢</span> Rute Aman Ditemukan
                                </div>
                                <div class="space-y-1.5 text-slate-300">
                                    <div>Nama Pos: <span class="font-bold text-white">${safeNearestPost.nama_pos}</span></div>
                                    <div>Jenis Pos: <span class="px-1.5 py-0.5 bg-slate-800 text-slate-300 text-[10px] font-semibold rounded ring-1 ring-white/10">${safeNearestPost.jenis_pos}</span></div>
                                    <div class="pt-1.5 border-t border-slate-800 flex justify-between gap-4">
                                        <div>Jarak: <span class="text-sky-400 font-bold font-mono">${distanceKm} km</span></div>
                                        <div>Estimasi: <span class="text-emerald-400 font-bold font-mono">${durationMinutes} menit</span></div>
                                    </div>
                                    <div class="text-[11px] text-emerald-400/90 font-medium pt-1 italic">
                                        ✓ Status: Tidak melewati area bencana
                                    </div>
                                </div>
                            </div>
                        `;

                        L.popup()
                            .setLatLng([safeNearestPost.latitude, safeNearestPost.longitude])
                            .setContent(popupContent)
                            .openOn(map);

                    } else {
                        alert("⚠️ Tidak ditemukan rute menuju pos yang bebas dari area bencana.");
                    }
                });
            });
        }

        // =========================================================================
        // FITUR BARU: SMART FUZZY SEARCH (POSKO & AREA BENCANA)
        // =========================================================================
        let disasterPostsData = [];
        let disasterHistoriesData = [];
        let searchIndexData = [];
        let fuseInstance = null;
        let originalLayers = { posts: {}, histories: {} };
        let loadedPosts = false;
        let loadedHistories = false;

        function registerSearchLayer(type, itemId, layer) {
            if (type === 'post') {
                originalLayers.posts[`post_${itemId}`] = layer;
            } else if (type === 'history') {
                originalLayers.histories[`hist_${itemId}`] = layer;
            }
        }

        function updateSearchIndexIfReady() {
            if (!loadedPosts || !loadedHistories) return;
            buildSearchIndex();
        }

        function buildSearchIndex() {
            searchIndexData = [];

            disasterPostsData.forEach(function(post) {
                searchIndexData.push({
                    id: `post_${post.id}`,
                    type: 'post',
                    title: post.nama_pos || 'Posko Tidak Bernama',
                    category: post.jenis_pos || 'Posko',
                    textToSearch: `${post.nama_pos || ''} ${post.jenis_pos || ''} ${post.deskripsi || ''} ${post.lokasi || ''}`.trim()
                });
            });

            disasterHistoriesData.forEach(function(history) {
                searchIndexData.push({
                    id: `hist_${history.id}`,
                    type: 'history',
                    title: history.nama_bencana || 'Area Bencana',
                    category: history.jenis_bencana || 'Bencana',
                    textToSearch: `${history.nama_bencana || ''} ${history.jenis_bencana || ''} ${history.keterangan || ''} ${history.lokasi || ''}`.trim()
                });
            });

            const options = {
                keys: ['title', 'category', 'textToSearch'],
                threshold: 0.42,
                distance: 100,
                ignoreLocation: true
            };
            fuseInstance = new Fuse(searchIndexData, options);
        }

        const searchInput = document.getElementById('search-input');
        const resultsDropdown = document.getElementById('search-results-dropdown');

        if (searchInput && resultsDropdown) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                if (!query || !fuseInstance) {
                    resultsDropdown.innerHTML = '';
                    resultsDropdown.classList.add('hidden');
                    return;
                }

                const searchResults = fuseInstance.search(query, { limit: 8 }).slice(0, 8);
                if (!searchResults.length) {
                    resultsDropdown.innerHTML = '<div class="text-[11px] text-slate-500 p-2 text-center">Data tidak ditemukan</div>';
                    resultsDropdown.classList.remove('hidden');
                    return;
                }

                let htmlItems = '';
                searchResults.forEach(result => {
                    const item = result.item;
                    const icon = item.type === 'post' ? '📍' : '🌋';
                    const badgeClass = item.type === 'post' ? 'bg-blue-500/10 text-blue-400 ring-blue-500/20' : 'bg-red-500/10 text-red-400 ring-red-500/20';

                    htmlItems += `
                        <div onclick="handleSearchItemClick('${item.type}', '${item.id}')" class="flex items-center justify-between gap-3 px-3 py-2 rounded-lg hover:bg-slate-800/80 cursor-pointer transition-colors group">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="text-sm shrink-0">${icon}</span>
                                <div class="truncate">
                                    <div class="text-xs font-bold text-slate-200 group-hover:text-white truncate">${item.title}</div>
                                    <div class="text-[10px] text-slate-400 truncate">${item.category}</div>
                                </div>
                            </div>
                            <span class="text-[9px] px-1.5 py-0.5 rounded ring-1 shrink-0 uppercase font-mono tracking-wider ${badgeClass}">
                                ${item.type === 'post' ? 'Posko' : 'Bencana'}
                            </span>
                        </div>
                    `;
                });

                resultsDropdown.innerHTML = htmlItems;
                resultsDropdown.classList.remove('hidden');
            });

            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !resultsDropdown.contains(e.target)) {
                    resultsDropdown.classList.add('hidden');
                }
            });
        }

        function handleSearchItemClick(type, id) {
            if (resultsDropdown) resultsDropdown.classList.add('hidden');

            if (type === 'post') {
                const layer = originalLayers.posts[id];
                if (!layer) return;

                const latlng = layer.getLatLng();
                map.setView(latlng, 16);
                layer.openPopup();

                if (layer._icon) {
                    let blink = 0;
                    const origOpacity = layer._icon.style.opacity || '1';
                    const interval = setInterval(() => {
                        layer._icon.style.opacity = blink % 2 === 0 ? '0.3' : '1';
                        blink += 1;
                        if (blink >= 6) {
                            clearInterval(interval);
                            layer._icon.style.opacity = origOpacity;
                        }
                    }, 200);
                }
            }

            if (type === 'history') {
                const layer = originalLayers.histories[id];
                if (!layer) return;

                map.fitBounds(layer.getBounds(), { padding: [40, 40] });
                layer.openPopup();

                const originalStyle = {
                    weight: layer.options.weight || 2,
                    fillOpacity: layer.options.fillOpacity || 0.35,
                    color: layer.options.color || '#dc2626'
                };
                if (typeof layer.setStyle === 'function') {
                    layer.setStyle({ weight: 5, fillOpacity: 0.65, color: '#f97316' });
                    setTimeout(() => {
                        layer.setStyle(originalStyle);
                    }, 1800);
                }
            }
        }

        // Handle ?mode=posko or ?mode=riwayat without auto-opening modals.
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const params = new URLSearchParams(window.location.search);
                const mode = params.get('mode');
                if (mode === 'posko') {
                    window.autoAddPosko = true;
                    setMode('add-post');
                    showModeBadge('📍 MODE PENAMBAHAN POSKO AKTIF', 'Klik lokasi pada peta untuk menambahkan Posko Kebencanaan');
                } else if (mode === 'riwayat') {
                    window.autoDrawPolygon = true;
                    setMode('add-history');
                    showModeBadge('🔺 MODE DIGITASI AREA BENCANA AKTIF', 'Gambarkan polygon pada peta');
                }
            } catch (err) {
                console.error('Mode param handling failed', err);
            }
        });
    </script>
</x-app-layout>
