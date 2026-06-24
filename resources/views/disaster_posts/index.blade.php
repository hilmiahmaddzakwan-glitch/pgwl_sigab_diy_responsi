<x-app-layout>
    <div class="min-h-screen bg-[#020617] text-slate-100 font-sans antialiased pb-12">

        <div class="relative overflow-hidden bg-[#0f172a]/60 border-b border-slate-800/80 py-8 px-6 backdrop-blur-md">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-transparent pointer-events-none"></div>
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-6 relative z-10">
                <div>
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="px-2 py-0.5 bg-blue-500/10 text-blue-400 text-[10px] font-mono rounded-md ring-1 ring-blue-500/20 uppercase tracking-wider">Pusat Data Terpadu</span>
                        <span class="px-2 py-0.5 bg-emerald-500/10 text-emerald-400 text-[10px] font-mono rounded-md ring-1 ring-emerald-500/20 uppercase tracking-wider">SIGAB DIY</span>
                    </div>
                    <h1 class="text-2xl font-black text-white tracking-wide uppercase">DATABASE KEBENCANAAN DIY</h1>
                    <p class="text-xs text-slate-400 font-medium">Pusat Data Posko dan Riwayat Kebencanaan Terintegrasi</p>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
                    <div class="relative w-full sm:w-80">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs">🔍</span>
                        <input type="text" id="global-search" onkeyup="filterGlobalData()" placeholder="Cari posko, lokasi, area bencana, atau jenis bencana..."
                            class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-[#020617]/90 border border-slate-800 text-xs text-slate-100 placeholder-slate-500 focus:border-blue-500 focus:ring-0 transition-all shadow-inner">
                    </div>

                    <div class="flex gap-2 shrink-0">
                        <a href="/peta?mode=posko" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shadow-md transition-colors flex items-center gap-1.5">
                            ⛺ + Posko
                        </a>
                        <a href="/peta?mode=riwayat" class="px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white text-xs font-bold shadow-md transition-colors flex items-center gap-1.5">
                            🌋 + Riwayat
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 space-y-8">

            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border-l-4 border-emerald-500 text-emerald-400 rounded-xl text-xs font-medium backdrop-blur-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="rounded-2xl bg-[#0f172a]/40 border border-slate-800/80 p-5 shadow-lg backdrop-blur-sm relative overflow-hidden group">
                    <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Total Posko</div>
                    <div class="text-3xl font-black text-blue-400 font-mono mt-1">{{ count($posts ?? []) }}</div>
                    <span class="absolute right-4 bottom-2 text-3xl opacity-[0.03] text-white select-none pointer-events-none group-hover:scale-110 transition-transform">⛺</span>
                </div>
                <div class="rounded-2xl bg-[#0f172a]/40 border border-slate-800/80 p-5 shadow-lg backdrop-blur-sm relative overflow-hidden group">
                    <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Total Area Bencana</div>
                    <div id="stat-total-bencana" class="text-3xl font-black text-red-400 font-mono mt-1">...</div>
                    <span class="absolute right-4 bottom-2 text-3xl opacity-[0.03] text-white select-none pointer-events-none group-hover:scale-110 transition-transform">🌋</span>
                </div>
                <div class="rounded-2xl bg-[#0f172a]/40 border border-slate-800/80 p-5 shadow-lg backdrop-blur-sm relative overflow-hidden group">
                    <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Dokumentasi Foto</div>
                    <div id="stat-total-foto" class="text-3xl font-black text-amber-400 font-mono mt-1">
                        {{ collect($posts ?? [])->filter(fn($p) => !empty($p->foto))->count() }}
                    </div>
                    <span class="absolute right-4 bottom-2 text-3xl opacity-[0.03] text-white select-none pointer-events-none group-hover:scale-110 transition-transform">🖼️</span>
                </div>
                <div class="rounded-2xl bg-[#0f172a]/40 border border-slate-800/80 p-5 shadow-lg backdrop-blur-sm relative overflow-hidden group">
                    <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Update Terakhir</div>
                    <div class="text-xs font-bold text-emerald-400 font-mono mt-3 truncate">
                        @php
                            $latestPost = collect($posts ?? [])->max('updated_at');
                        @endphp
                        {{ $latestPost ? \Carbon\Carbon::parse($latestPost)->locale('id')->diffForHumans() : 'Baru saja' }}
                    </div>
                    <span class="absolute right-4 bottom-2 text-3xl opacity-[0.03] text-white select-none pointer-events-none group-hover:scale-110 transition-transform">⏱️</span>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 bg-[#0f172a]/30 border border-slate-800/60 p-3 rounded-2xl backdrop-blur-sm">
                <div class="flex bg-[#020617]/80 p-1 rounded-xl border border-slate-800/80 self-start">
                    <button type="button" onclick="switchTab('posko')" id="tab-btn-posko" class="px-5 py-2 rounded-lg text-xs font-bold tracking-wide transition-all duration-200 bg-blue-600 text-white shadow-md">
                        ⛺ Posko Kebencanaan
                    </button>
                    <button type="button" onclick="switchTab('bencana')" id="tab-btn-bencana" class="px-5 py-2 rounded-lg text-xs font-medium tracking-wide transition-all duration-200 text-slate-400 hover:text-slate-200">
                        🌋 Riwayat Area Bencana
                    </button>
                </div>

                <div class="flex flex-wrap items-center gap-2.5">
                    <select id="filter-kategori-posko" onchange="applyAdvancedFilters()" class="rounded-xl bg-[#020617] border-slate-800 text-[11px] font-bold text-slate-300 focus:ring-0 focus:border-slate-700">
                        <option value="ALL">Semua Jenis Posko</option>
                        <option value="Logistik">📦 Logistik & Dapur Umum</option>
                        <option value="Kesehatan">🏥 Posko Kesehatan</option>
                        <option value="Pengungsian">⛺ Tempat Evakuasi / Pengungsian</option>
                        <option value="Komando">🚨 Pusat Komando Operasi</option>
                    </select>

                    <select id="filter-jenis-bencana" onchange="applyAdvancedFilters()" class="hidden rounded-xl bg-[#020617] border-slate-800 text-[11px] font-bold text-slate-300 focus:ring-0 focus:border-slate-700">
                        <option value="ALL">Semua Jenis Bencana</option>
                        <option value="Banjir">🌊 Banjir / Luapan Sungai</option>
                        <option value="Tanah Longsor">⛰️ Tanah Longsor</option>
                        <option value="Erupsi Gunung">🌋 Erupsi Gunungapi</option>
                        <option value="Gempa Bumi">🫨 Gempa Bumi</option>
                        <option value="Angin Kencang">🌪️ Angin Kencang</option>
                    </select>

                    <select id="data-sorter" onchange="applyAdvancedFilters()" class="rounded-xl bg-[#020617] border-slate-800 text-[11px] font-bold text-slate-300 focus:ring-0 focus:border-slate-700">
                        <option value="LATEST">📅 Terbaru</option>
                        <option value="OLDEST">⏳ Terlama</option>
                        <option value="AZ">🔤 Nama A - Z</option>
                        <option value="ZA">🔤 Nama Z - A</option>
                    </select>
                </div>
            </div>

            <div id="tab-content-posko" class="tab-pane-view space-y-6">
                @if(count($posts ?? []) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="grid-posko-master">
                        @foreach($posts as $pos)
                            <div class="card-item-container rounded-2xl bg-[#0f172a]/30 border border-slate-800/80 overflow-hidden shadow-xl hover:border-slate-700/60 transition-all flex flex-col group"
                                 data-title="{{ $pos->nama_pos }}" data-category="{{ $pos->jenis_pos }}" data-time="{{ strtotime($pos->created_at ?? now()) }}">
                                <div class="h-44 bg-slate-950 relative overflow-hidden shrink-0">
                                    @if(!empty($pos->foto))
                                        <img src="{{ asset('storage/foto_pos/' . $pos->foto) }}" alt="{{ $pos->nama_pos }}" onerror="this.onerror=null;this.src='/images/no-image.png';" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center bg-[#020617] text-slate-600 gap-2">
                                            <span class="text-3xl">⛺</span>
                                            <span class="text-[10px] uppercase tracking-widest font-mono">No Documentation</span>
                                        </div>
                                    @endif
                                    <span class="absolute top-3 left-3 px-2 py-0.5 rounded-md bg-slate-900/90 text-sky-400 font-bold text-[10px] border border-slate-700/50 backdrop-blur-md">
                                        {{ $pos->jenis_pos }}
                                    </span>
                                </div>
                                <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                                    <div class="space-y-1.5">
                                        <h3 class="font-bold text-sm text-white tracking-wide truncate-title">{{ $pos->nama_pos }}</h3>
                                        <div class="flex items-center gap-1 text-[10px] font-mono text-slate-400">
                                            <span>📍</span> <span class="truncate">{{ number_format($pos->latitude ?? 0, 4) }}, {{ number_format($pos->longitude ?? 0, 4) }}</span>
                                        </div>
                                        <p class="text-xs text-slate-400 leading-relaxed line-clamp-3 font-medium">
                                            {{ $pos->deskripsi ?? 'Tidak ada keterangan deskripsi tambahan.' }}
                                        </p>
                                    </div>

                                    <div class="pt-4 border-t border-slate-800/60 flex items-center justify-between mt-auto">
                                        <span class="text-[10px] font-mono text-slate-500">{{ $pos->created_at ? \Carbon\Carbon::parse($pos->created_at)->locale('id')->translatedFormat('d M Y') : '-' }}</span>
                                        <div class="flex items-center gap-1.5">
                                            <button type="button" onclick="showDataDetail('post', '{{ addslashes($pos->nama_pos) }}', '{{ $pos->jenis_pos }}', '{{ $pos->latitude }}, {{ $pos->longitude }}', '{{ addslashes($pos->deskripsi ?? '') }}', '{{ !empty($pos->foto) ? asset('storage/foto_pos/' . $pos->foto) : '' }}', '{{ $pos->created_at ? \Carbon\Carbon::parse($pos->created_at)->locale('id')->translatedFormat('d F Y') : '-' }}')"
                                                class="h-7 w-7 rounded-lg bg-slate-800/80 hover:bg-slate-700 text-slate-300 flex items-center justify-center text-xs font-bold transition-colors" title="Lihat Detail">👁️</button>
                                            <a href="{{ route('disaster-posts.edit', $pos->id) }}" class="h-7 w-7 rounded-lg bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-white flex items-center justify-center text-xs font-bold transition-all" title="Ubah">✏️</a>
                                            <form action="{{ route('disaster-posts.destroy', $pos->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus posko ini?')" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="h-7 w-7 rounded-lg bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white flex items-center justify-center text-xs font-bold transition-all" title="Hapus">🗑️</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 text-slate-500 text-sm">Belum ada data pos kebencanaan.</div>
                @endif
            </div>

            <div id="tab-content-bencana" class="tab-pane-view space-y-6 hidden">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="grid-bencana-master">
                    <div class="col-span-full text-center py-12 text-slate-500 text-xs">Memuat data riwayat kebencanaan...</div>
                </div>
            </div>

            <div id="laravel-pagination-wrapper" class="pt-6 border-t border-slate-800/60">
                @if(method_exists($posts, 'links'))
                    <div class="custom-pagination-dark">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    <div id="modalDataDetailViewer" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4">
        <div class="relative w-full max-w-2xl bg-[#0f172a] border border-slate-800 rounded-2xl shadow-2xl overflow-hidden text-slate-200">
            <div id="md-frame-img" class="h-64 w-full bg-slate-950 relative hidden">
                <img id="md-view-foto" src="" alt="Detail Media" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-transparent to-transparent"></div>
            </div>

            <div class="p-6 space-y-5">
                <div class="flex justify-between items-start">
                    <div>
                        <span id="md-view-badge" class="px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase ring-1">Kategori</span>
                        <h2 id="md-view-title" class="text-lg font-black text-white uppercase tracking-wide mt-2">Nama Data</h2>
                    </div>
                    <button type="button" onclick="closeDataDetailModal()" class="text-slate-400 hover:text-white bg-slate-800/60 p-1.5 rounded-xl border border-slate-700/40 transition-colors">✕</button>
                </div>

                <div class="grid grid-cols-2 gap-4 bg-[#020617]/50 p-4 rounded-xl border border-slate-800/60 text-xs font-medium">
                    <div>
                        <div class="text-[10px] uppercase text-slate-500 font-bold tracking-wider mb-0.5">Lokasi / Geometri</div>
                        <div id="md-view-location" class="text-slate-200 font-mono">0.0000, 0.0000</div>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase text-slate-500 font-bold tracking-wider mb-0.5">Waktu</div>
                        <div id="md-view-time" class="text-slate-200 font-mono">-</div>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <div class="text-[10px] uppercase text-slate-500 font-bold tracking-wider">Uraian / Deskripsi Lengkap</div>
                    <p id="md-view-desc" class="text-xs text-slate-300 leading-relaxed bg-[#020617]/20 p-4 rounded-xl border border-slate-800/30 whitespace-pre-line font-medium"></p>
                </div>

                <div class="pt-3 flex justify-end border-t border-slate-800/60">
                    <button type="button" onclick="closeDataDetailModal()" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold transition-colors">Tutup Jendela</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let activeTab = 'posko';
        let apiHistoriesData = [];
        let fotoCountPost = {{ collect($posts ?? [])->filter(fn($p) => !empty($p->foto))->count() }};

        // Ambil Data Riwayat Bencana dari API Internal Aplikasi saat halaman dimuat
        document.addEventListener("DOMContentLoaded", function() {
            fetch("{{ url('/api/disaster-histories') }}")
                .then(response => response.json())
                .then(data => {
                    apiHistoriesData = data;
                    document.getElementById('stat-total-bencana').innerText = data.length;

                    // Hitung akumulasi foto dokumentasi dari kedua dataset
                    let fotoCountHistory = data.filter(h => h.foto).length;
                    document.getElementById('stat-total-foto').innerText = fotoCountPost + fotoCountHistory;

                    renderBencanaCards(data);
                })
                .catch(err => {
                    console.error("Gagal memuat API disaster-histories:", err);
                    document.getElementById('grid-bencana-master').innerHTML = '<div class="col-span-full text-center py-12 text-red-400 text-xs">Gagal memuat data riwayat bencana.</div>';
                });
        });

        function renderBencanaCards(items) {
            const container = document.getElementById('grid-bencana-master');
            if(!container) return;

            if(items.length === 0) {
                container.innerHTML = '<div class="col-span-full text-center py-12 text-slate-500 text-sm">Belum ada data riwayat area bencana.</div>';
                return;
            }

            let html = '';
            items.forEach(item => {
                let imgHtml = `<div class="w-full h-full flex flex-col items-center justify-center bg-[#020617] text-slate-600 gap-2"><span class="text-3xl">🌋</span><span class="text-[10px] uppercase tracking-widest font-mono">No Documentation</span></div>`;
                if(item.foto_url) {
                    console.log(item.foto_url);
                    imgHtml = `<img src="${item.foto_url}" alt="${item.nama_bencana}" onerror="this.onerror=null;this.src='/images/no-image.png';" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">`;
                }

                let tglFormat = item.tanggal_bencana ? new Date(item.tanggal_bencana).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'}) : '-';
                let tglFull = item.tanggal_bencana ? new Date(item.tanggal_bencana).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) : '-';
                let timestamp = item.created_at ? new Date(item.created_at).getTime() / 1000 : Math.floor(Date.now() / 1000);

                html += `
                    <div class="card-item-container rounded-2xl bg-[#0f172a]/30 border border-slate-800/80 overflow-hidden shadow-xl hover:border-slate-700/60 transition-all flex flex-col group"
                         data-title="${item.nama_bencana}" data-category="${item.jenis_bencana}" data-time="${timestamp}">
                        <div class="h-44 bg-slate-950 relative overflow-hidden shrink-0">
                            ${imgHtml}
                            <span class="absolute top-3 left-3 px-2 py-0.5 rounded-md bg-slate-900/90 text-red-400 font-bold text-[10px] border border-slate-700/50 backdrop-blur-md">
                                ${item.jenis_bencana}
                            </span>
                        </div>
                        <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                            <div class="space-y-1.5">
                                <h3 class="font-bold text-sm text-white tracking-wide truncate-title">${item.nama_bencana}</h3>
                                <div class="flex items-center gap-1 text-[10px] font-mono text-slate-400">
                                    <span>📅 Kejadian:</span> <span class="font-semibold text-slate-300">${tglFormat}</span>
                                </div>
                                <p class="text-xs text-slate-400 leading-relaxed line-clamp-3 font-medium">
                                    ${item.keterangan_bencana || 'Tidak ada catatan uraian rincian dampak bencana.'}
                                </p>
                            </div>
                            <div class="pt-4 border-t border-slate-800/60 flex items-center justify-between mt-auto">
                                <span class="text-[10px] font-mono text-slate-500">Bencana DIY</span>
                                <div class="flex items-center gap-1.5">
                                    <button type="button" onclick="showDataDetail('history', '${item.nama_bencana.replace(/'/g, "\\'")}', '${item.jenis_bencana}', 'Polygon Terpetakan', '${(item.keterangan_bencana || '').replace(/'/g, "\\'")}', '${item.foto_url || ''}', '${tglFull}')"
                                        class="h-7 w-7 rounded-lg bg-slate-800/80 hover:bg-slate-700 text-slate-300 flex items-center justify-center text-xs font-bold transition-colors" title="Lihat Detail">👁️</button>
                                    <a href="${window.location.origin}/disaster-histories/${item.id}/edit" class="h-7 w-7 rounded-lg bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-white flex items-center justify-center text-xs font-bold transition-all" title="Ubah">✏️</a>
                                    <form action="${window.location.origin}/disaster-histories/${item.id}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat bencana ini?')" class="inline">
                                        <input type="hidden" name="_token" value="${document.querySelector('meta[name=\"csrf-token\"]')?.content || ''}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="h-7 w-7 rounded-lg bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white flex items-center justify-center text-xs font-bold transition-all" title="Hapus">🗑️</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            container.innerHTML = html;
        }

        function switchTab(targetTab) {
            activeTab = targetTab;
            document.getElementById('global-search').value = '';

            const btnPosko = document.getElementById('tab-btn-posko');
            const btnBencana = document.getElementById('tab-btn-bencana');
            const contentPosko = document.getElementById('tab-content-posko');
            const contentBencana = document.getElementById('tab-content-bencana');
            const selectPosko = document.getElementById('filter-kategori-posko');
            const selectBencana = document.getElementById('filter-jenis-bencana');
            const paginationWrapper = document.getElementById('laravel-pagination-wrapper');

            if (targetTab === 'posko') {
                btnPosko.className = "px-5 py-2 rounded-lg text-xs font-bold tracking-wide transition-all duration-200 bg-blue-600 text-white shadow-md";
                btnBencana.className = "px-5 py-2 rounded-lg text-xs font-medium tracking-wide transition-all duration-200 text-slate-400 hover:text-slate-200";
                contentPosko.classList.remove('hidden');
                contentBencana.classList.add('hidden');
                selectPosko.classList.remove('hidden');
                selectBencana.classList.add('hidden');
                paginationWrapper.classList.remove('hidden'); // Pagination Laravel aktif untuk posko
            } else {
                btnBencana.className = "px-5 py-2 rounded-lg text-xs font-bold tracking-wide transition-all duration-200 bg-red-600 text-white shadow-md";
                btnPosko.className = "px-5 py-2 rounded-lg text-xs font-medium tracking-wide transition-all duration-200 text-slate-400 hover:text-slate-200";
                contentBencana.classList.remove('hidden');
                contentPosko.classList.add('hidden');
                selectBencana.classList.remove('hidden');
                selectPosko.classList.add('hidden');
                paginationWrapper.classList.add('hidden'); // Sembunyikan pagination posko saat di tab bencana
            }
            applyAdvancedFilters();
        }

        function applyAdvancedFilters() {
            const searchQuery = document.getElementById('global-search').value.toLowerCase().trim();
            const sortingType = document.getElementById('data-sorter').value;

            let currentGridId = activeTab === 'posko' ? 'grid-posko-master' : 'grid-bencana-master';
            let currentFilterVal = activeTab === 'posko' ? document.getElementById('filter-kategori-posko').value : document.getElementById('filter-jenis-bencana').value;

            const gridContainer = document.getElementById(currentGridId);
            if (!gridContainer) return;

            let cardElements = Array.from(gridContainer.getElementsByClassName('card-item-container'));
            let visibleCount = 0;

            cardElements.forEach(card => {
                const cardTitle = card.getAttribute('data-title').toLowerCase();
                const cardCat = card.getAttribute('data-category');
                const cardDesc = card.querySelector('p').innerText.toLowerCase();

                let isFilterValid = (currentFilterVal === 'ALL' || cardCat.toLowerCase().includes(currentFilterVal.toLowerCase()));
                let isSearchValid = !searchQuery || cardTitle.includes(searchQuery) || cardDesc.includes(searchQuery) || cardCat.toLowerCase().includes(searchQuery);

                if (isFilterValid && isSearchValid) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            // Sorting Algorithm
            cardElements.sort((a, b) => {
                if (sortingType === 'LATEST') return b.getAttribute('data-time') - a.getAttribute('data-time');
                if (sortingType === 'OLDEST') return a.getAttribute('data-time') - b.getAttribute('data-time');
                if (sortingType === 'AZ') return a.getAttribute('data-title').localeCompare(b.getAttribute('data-title'));
                if (sortingType === 'ZA') return b.getAttribute('data-title').localeCompare(a.getAttribute('data-title'));
                return 0;
            });

            cardElements.forEach(card => gridContainer.appendChild(card));

            // Dynamic Empty State
            let existingEmpty = gridContainer.parentElement.querySelector('.dynamic-empty-state');
            if (visibleCount === 0) {
                if (!existingEmpty) {
                    gridContainer.insertAdjacentHTML('afterend', `
                        <div class="dynamic-empty-state border border-dashed border-slate-800 p-12 text-center max-w-md mx-auto my-6 space-y-2">
                            <span class="text-3xl block">🔍</span>
                            <h4 class="text-xs font-bold text-white uppercase">Data Tidak Ditemukan</h4>
                            <p class="text-[11px] text-slate-400">Kata kunci atau filter pencarian tidak cocok dengan data terdaftar.</p>
                        </div>`);
                }
            } else if (existingEmpty) {
                existingEmpty.remove();
            }
        }

        function filterGlobalData() {
            applyAdvancedFilters();
        }

        function showDataDetail(type, title, category, location, desc, imgUrl, timeStr) {
            document.getElementById('md-view-title').innerText = title;
            document.getElementById('md-view-badge').innerText = category;
            document.getElementById('md-view-location').innerText = location;
            document.getElementById('md-view-time').innerText = timeStr;
            document.getElementById('md-view-desc').innerText = desc || 'Tidak ada uraian rincian deskripsi.';

            const badgeEl = document.getElementById('md-view-badge');
            if (type === 'post') {
                badgeEl.className = "px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase ring-1 bg-blue-500/10 text-blue-400 ring-blue-500/30";
            } else {
                badgeEl.className = "px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase ring-1 bg-red-500/10 text-red-400 ring-red-500/30";
            }

            const frameImg = document.getElementById('md-frame-img');
            const imgEl = document.getElementById('md-view-foto');
            if (imgUrl) {
                imgEl.src = imgUrl;
                frameImg.classList.remove('hidden');
            } else {
                frameImg.classList.add('hidden');
                imgEl.src = '';
            }

            document.getElementById('modalDataDetailViewer').classList.remove('hidden');
        }

        function closeDataDetailModal() {
            document.getElementById('modalDataDetailViewer').classList.add('hidden');
        }
    </script>
</x-app-layout>
