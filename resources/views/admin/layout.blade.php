<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'Dashboard') — STORYTALE CMS</title>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=Bebas+Neue&display=swap" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  @stack('styles')
  <script>
    tailwind.config = {
      theme: { extend: {
        fontFamily: { brutal: ['Bebas Neue','sans-serif'], body: ['Space Grotesk','sans-serif'] },
        colors: { brand: '#FFE500' },
      }}
    }
  </script>
  <style>
    * { box-sizing: border-box; }
    body { font-family: 'Space Grotesk', sans-serif; }
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: #111; }
    ::-webkit-scrollbar-thumb { background: #FFE500; }

    .nav-item {
      display: flex; align-items: center; gap: 10px;
      padding: 10px 16px;
      font-family: 'Space Grotesk', sans-serif;
      font-size: 0.7rem; font-weight: 700;
      text-transform: uppercase; letter-spacing: 0.15em;
      color: rgba(255,229,0,0.5);
      text-decoration: none;
      border-left: 3px solid transparent;
      transition: all 0.15s ease;
    }
    .nav-item:hover { color: #FFE500; background: rgba(255,229,0,0.05); }
    .nav-item.active { color: #FFE500; border-left-color: #FFE500; background: rgba(255,229,0,0.07); }

    .badge {
      display: inline-flex; align-items: center;
      font-size: 0.55rem; font-weight: 700;
      text-transform: uppercase; letter-spacing: 0.2em;
      padding: 2px 8px; border: 1px solid currentColor;
    }
    .badge-published { color: #00AA50; border-color: rgba(0,170,80,0.3); background: rgba(0,170,80,0.08); }
    .badge-draft     { color: rgba(255,229,0,0.4); border-color: rgba(255,229,0,0.15); background: rgba(255,229,0,0.05); }
    .badge-featured  { color: #FFE500; border-color: rgba(255,229,0,0.3); background: rgba(255,229,0,0.08); }
  </style>
</head>
<body class="bg-[#0D0D0D] text-[#FFE500] min-h-screen flex">

  <!-- ── Sidebar ── -->
  <aside class="w-56 flex-shrink-0 bg-[#0A0A0A] border-r border-[rgba(255,229,0,0.08)] flex flex-col" style="min-height:100vh;">

    <!-- Logo -->
    <div class="px-5 py-6 border-b border-[rgba(255,229,0,0.08)]">
      <a href="{{ route('admin.work.index') }}" class="flex items-center gap-2 no-underline">
        <div class="w-8 h-8 bg-[#FFE500] flex items-center justify-center flex-shrink-0">
          <span class="font-brutal text-[#0A0A0A] text-lg leading-none">S</span>
        </div>
        <div>
          <div class="font-brutal text-[#FFE500] text-lg tracking-widest leading-none">STORYTALE</div>
          <div class="font-body text-[9px] text-[#FFE500] opacity-30 uppercase tracking-widest">CMS</div>
        </div>
      </a>
    </div>

    <!-- Nav -->
    <nav class="flex-1 py-4">
      <div class="px-5 mb-2">
        <span class="font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-20">Content</span>
      </div>
      <a href="{{ route('admin.work.index') }}"
        class="nav-item {{ request()->routeIs('admin.work.*') ? 'active' : '' }}">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        Work
      </a>
      <a href="{{ route('admin.journal.index') }}"
        class="nav-item {{ request()->routeIs('admin.journal.*') ? 'active' : '' }}">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/><path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/></svg>
        Journal
      </a>
      <a href="{{ route('admin.service.index') }}"
        class="nav-item {{ request()->routeIs('admin.service.*') ? 'active' : '' }}">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93l-1.41 1.41M4.93 4.93l1.41 1.41M19.07 19.07l-1.41-1.41M4.93 19.07l1.41-1.41M12 2v2M12 20v2M2 12h2M20 12h2"/></svg>
        Services
      </a>
      <a href="{{ route('admin.about.index') }}"
        class="nav-item {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        Studio / Team
      </a>

      <div class="px-5 mt-6 mb-2">
        <span class="font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-20">Config</span>
      </div>
      <a href="{{ route('admin.settings') }}"
        class="nav-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93l-1.41 1.41M4.93 4.93l1.41 1.41M12 2v2M12 20v2M2 12h2M20 12h2M19.07 19.07l-1.41-1.41M4.93 19.07l1.41-1.41"/></svg>
        Site Settings
      </a>

      <div class="px-5 mt-4 mb-2">
        <span class="font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-20">Preview</span>
      </div>
      <a href="/" target="_blank" class="nav-item">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
        View Site
      </a>
    </nav>

    <!-- Logout -->
    <div class="p-4 border-t border-[rgba(255,229,0,0.08)]">
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit"
          class="w-full font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-40 hover:opacity-100 text-left flex items-center gap-2 transition-opacity py-2">
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          Sign Out
        </button>
      </form>
    </div>
  </aside>

  <!-- ── Main ── -->
  <div class="flex-1 flex flex-col min-w-0">

    <!-- Top bar -->
    <header class="bg-[#0A0A0A] border-b border-[rgba(255,229,0,0.08)] px-8 py-4 flex items-center justify-between flex-shrink-0">
      <div>
        <h1 class="font-brutal text-[#FFE500] text-2xl tracking-wider leading-none">@yield('page-title', 'Dashboard')</h1>
        @hasSection('page-sub')
          <p class="font-body text-[10px] text-[#FFE500] opacity-30 uppercase tracking-widest mt-0.5">@yield('page-sub')</p>
        @endif
      </div>
      @yield('header-action')
    </header>

    <!-- Flash -->
    @if(session('success'))
      <div class="mx-8 mt-6 flex items-center gap-3 border-2 border-[rgba(0,170,80,0.4)] bg-[rgba(0,170,80,0.08)] px-5 py-3">
        <svg width="16" height="16" fill="none" stroke="#00AA50" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        <p class="font-body text-[#00AA50] text-xs font-bold">{{ session('success') }}</p>
      </div>
    @endif

    <!-- Content -->
    <main class="flex-1 p-8 overflow-auto">
      @yield('content')
    </main>
  </div>

</body>
</html>
