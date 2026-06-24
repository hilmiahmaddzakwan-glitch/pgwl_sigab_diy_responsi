<nav x-data="{ open: false }" class="bg-[#0f172a] border-b border-slate-800/80 shadow-2xl relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex items-center">
                <div class="shrink-0 flex items-center gap-3">
                    <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-red-600 to-amber-500 flex items-center justify-center shadow-lg shadow-red-600/20 ring-1 ring-white/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-center gap-1.5">
                            <span class="text-base font-black tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-white via-slate-100 to-slate-300">SIGAB DIY</span>
                            <span class="px-1.5 py-0.5 bg-red-500/10 text-red-400 text-[8px] font-bold uppercase tracking-widest rounded ring-1 ring-red-500/20">EMS</span>
                        </div>
                        <span class="text-[9px] text-slate-400 font-medium tracking-wide -mt-0.5">Sistem Informasi Geospasial Kebencanaan DIY</span>
                    </div>
                </div>
            </div>

            <div class="hidden md:flex space-x-1 items-center">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="px-4 py-2 rounded-xl text-xs font-bold tracking-wide transition-all duration-150 border-b-0 {{ request()->routeIs('dashboard') ? 'bg-slate-800 text-white ring-1 ring-white/5' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    {{ __('Dashboard') }}
                </x-nav-link>

                <x-nav-link :href="url('/peta')" :active="request()->is('peta')" class="px-4 py-2 rounded-xl text-xs font-bold tracking-wide transition-all duration-150 border-b-0 {{ request()->is('peta') ? 'bg-slate-800 text-white ring-1 ring-white/5' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    {{ __('Peta Interaktif') }}
                </x-nav-link>

                <x-nav-link :href="route('disaster-posts.index')" :active="request()->routeIs('disaster-posts.*')" class="px-4 py-2 rounded-xl text-xs font-bold tracking-wide transition-all duration-150 border-b-0 {{ request()->routeIs('disaster-posts.*') ? 'bg-slate-800 text-white ring-1 ring-white/5' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    {{ __('Database Kebencanaan') }}
                </x-nav-link>

                <x-nav-link :href="url('/tentang')" :active="request()->is('tentang')" class="px-4 py-2 rounded-xl text-xs font-bold tracking-wide transition-all duration-150 border-b-0 {{ request()->is('tentang') ? 'bg-slate-800 text-white ring-1 ring-white/5' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    {{ __('Tentang') }}
                </x-nav-link>
            </div>

            <div class="hidden md:flex sm:items-center sm:ms-6 gap-4">
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-[#020617]/80 ring-1 ring-white/5 shadow-inner">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-500 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-400 font-mono">Sistem Online</span>
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 rounded-xl bg-slate-800/60 border border-slate-700/50 text-xs font-bold text-slate-300 hover:text-white hover:bg-slate-800 hover:border-slate-600 focus:outline-none transition-all shadow-sm">
                            <div class="flex items-center gap-2">
                                <div class="h-5 w-5 rounded-md bg-slate-700 flex items-center justify-center text-[10px] text-slate-300 border border-white/5">
                                    👤
                                </div>
                                <div>{{ Auth::user()->name }}</div>
                            </div>
                            <div class="ms-1.5">
                                <svg class="fill-current h-3 w-3 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden backdrop-blur-2xl">
                            <x-dropdown-link :href="route('profile.edit')" class="text-xs font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition-colors">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        class="text-xs font-bold text-red-400 hover:bg-red-500/10 hover:text-red-300 border-t border-slate-800/60 transition-colors"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-slate-200 hover:bg-slate-800 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-[#020617] border-t border-slate-800/80 animate-fade-in">
        <div class="pt-2 pb-3 space-y-1 px-3">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="rounded-xl px-4 py-2.5 text-xs font-bold tracking-wide {{ request()->routeIs('dashboard') ? 'bg-slate-800 text-white border-l-4 border-l-red-500' : 'text-slate-400 hover:bg-slate-900' }}">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="url('/peta')" :active="request()->is('peta')" class="rounded-xl px-4 py-2.5 text-xs font-bold tracking-wide {{ request()->is('peta') ? 'bg-slate-800 text-white border-l-4 border-l-red-500' : 'text-slate-400 hover:bg-slate-900' }}">
                {{ __('Peta Interaktif') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('disaster-posts.index')" :active="request()->routeIs('disaster-posts.*')" class="rounded-xl px-4 py-2.5 text-xs font-bold tracking-wide {{ request()->routeIs('disaster-posts.*') ? 'bg-slate-800 text-white border-l-4 border-l-red-500' : 'text-slate-400 hover:bg-slate-900' }}">
                {{ __('Database Kebencanaan') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="url('/tentang')" :active="request()->is('tentang')" class="rounded-xl px-4 py-2.5 text-xs font-bold tracking-wide {{ request()->is('tentang') ? 'bg-slate-800 text-white border-l-4 border-l-red-500' : 'text-slate-400 hover:bg-slate-900' }}">
                {{ __('Tentang') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-4 border-t border-slate-800/80 px-4 flex items-center justify-between bg-[#0f172a]/60">
            <div>
                <div class="font-bold text-sm text-slate-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-xs text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="flex flex-col gap-2 items-end">
                <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-[#020617] ring-1 ring-white/5">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[9px] font-bold uppercase tracking-wider text-emerald-400 font-mono">Online</span>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs font-bold text-red-400 hover:text-red-300 transition-colors">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
