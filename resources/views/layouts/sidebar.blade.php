<aside class="hidden md:flex md:flex-col md:w-64 md:h-screen md:sticky md:top-0 bg-white border-r border-primary/5">
    <div class="p-6">
        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-primary">Tracking Konten</a>
    </div>

    <nav class="flex-1 px-2 pb-4 space-y-1">
        <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-3 text-sm font-medium text-primary hover:bg-mist rounded-lg">
            <svg class="h-5 w-5 mr-3 text-primary/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18"/></svg>
            Dashboard
        </a>

        <a href="{{ route('postingan.create') }}" class="group flex items-center px-4 py-3 text-sm font-medium text-primary hover:bg-mist rounded-lg">
            <svg class="h-5 w-5 mr-3 text-primary/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Input Konten
        </a>

        <a href="{{ route('postingan.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium text-primary hover:bg-mist rounded-lg">
            <svg class="h-5 w-5 mr-3 text-primary/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
            Daftar Postingan
        </a>

    </nav>
</aside>
