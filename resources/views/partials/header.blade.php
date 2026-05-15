<style>
  .burger-line {
    display: block; width: 28px; height: 3px;
    background: #0A0A0A;
    transition: all 0.25s ease;
    transform-origin: center;
  }
  .burger-open .burger-line:nth-child(1) { transform: translateY(9px) rotate(45deg); }
  .burger-open .burger-line:nth-child(2) { opacity: 0; transform: scaleX(0); }
  .burger-open .burger-line:nth-child(3) { transform: translateY(-9px) rotate(-45deg); }

  #mobile-nav {
    transform: translateX(100%);
    transition: transform 0.3s cubic-bezier(0.77, 0, 0.175, 1);
  }
  #mobile-nav.open { transform: translateX(0); }

  .nav-link { position: relative; overflow: hidden; }
  .nav-link::after {
    content: '';
    position: absolute; bottom: -2px; left: 0;
    width: 100%; height: 3px; background: #0A0A0A;
    transform: scaleX(0); transform-origin: left;
    transition: transform 0.2s ease;
  }
  .nav-link:hover::after { transform: scaleX(1); }
  .nav-link.active::after { transform: scaleX(1); }

  @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
  .marquee-track { animation: marquee 14s linear infinite; }
</style>

<header id="site-header" class="fixed top-0 left-0 right-0 z-50 bg-[#FFE500] border-b-4 border-[#0A0A0A]">

  <div class="bg-[#0A0A0A] text-[#FFE500] overflow-hidden py-1">
    <div class="flex whitespace-nowrap">
      <div class="marquee-track flex gap-0 font-body text-xs font-bold tracking-widest uppercase">
        <span class="px-8">★ Stories That Sell</span><span class="px-8">★ Digital Marketing</span>
        <span class="px-8">★ Portfolio 2026</span><span class="px-8">★ Content × Strategy</span>
        <span class="px-8">★ Stories That Sell</span><span class="px-8">★ Digital Marketing</span>
        <span class="px-8">★ Portfolio 2026</span><span class="px-8">★ Content × Strategy</span>
      </div>
    </div>
  </div>

  <nav class="max-w-[1440px] mx-auto px-6 lg:px-12 flex items-center justify-between h-[72px]">

    <a href="/" class="flex items-center gap-2 no-underline">
      <div class="w-9 h-9 bg-[#0A0A0A] border-2 border-[#0A0A0A] flex items-center justify-center">
        <span class="text-[#FFE500] font-brutal text-xl leading-none">S</span>
      </div>
      <span class="font-brutal text-2xl tracking-widest text-[#0A0A0A] uppercase leading-none">STORYTALE</span>
    </a>

    <ul class="hidden lg:flex items-center gap-8 list-none">
      <li><a href="/work"     class="nav-link {{ request()->is('work*') ? 'active' : '' }} font-body font-bold text-sm uppercase tracking-widest text-[#0A0A0A] no-underline">Work</a></li>
      <li><a href="/studio"   class="nav-link {{ request()->is('studio') ? 'active' : '' }} font-body font-bold text-sm uppercase tracking-widest text-[#0A0A0A] no-underline">Studio</a></li>
      <li><a href="/services" class="nav-link {{ request()->is('services') ? 'active' : '' }} font-body font-bold text-sm uppercase tracking-widest text-[#0A0A0A] no-underline">Services</a></li>
      <li><a href="/journal"  class="nav-link {{ request()->is('journal') ? 'active' : '' }} font-body font-bold text-sm uppercase tracking-widest text-[#0A0A0A] no-underline">Journal</a></li>
    </ul>

    <div class="hidden lg:flex items-center gap-4">
      <a href="{{ $waUrl ?? '#' }}" target="_blank" rel="noopener"
        class="w-9 h-9 bg-[#25D366] border-2 border-[#0A0A0A] flex items-center justify-center text-white hover:translate-x-[2px] hover:translate-y-[2px] transition-all duration-150 shadow-brutal hover:shadow-none no-underline flex-shrink-0"
        title="Chat on WhatsApp">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
      </a>
      <a href="#contact"
        class="inline-block bg-[#0A0A0A] text-[#FFE500] font-body font-bold text-sm uppercase tracking-widest px-6 py-3 border-2 border-[#0A0A0A] shadow-brutal hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-150 no-underline">
        Let's Talk →
      </a>
    </div>

    <button id="burger-btn"
      class="lg:hidden flex flex-col gap-[6px] p-2 border-2 border-[#0A0A0A] bg-[#FFE500] hover:bg-[#0A0A0A] group transition-colors duration-150 focus:outline-none"
      aria-label="Toggle menu">
      <span class="burger-line group-hover:bg-[#FFE500]"></span>
      <span class="burger-line group-hover:bg-[#FFE500]"></span>
      <span class="burger-line group-hover:bg-[#FFE500]"></span>
    </button>
  </nav>

  <div id="mobile-nav"
    class="fixed top-0 right-0 h-screen w-4/5 max-w-sm bg-[#0A0A0A] border-l-4 border-[#FFE500] z-50 flex flex-col p-10 pt-20">
    <button id="close-nav"
      class="absolute top-6 right-6 w-10 h-10 border-2 border-[#FFE500] flex items-center justify-center text-[#FFE500] text-xl font-bold hover:bg-[#FFE500] hover:text-[#0A0A0A] transition-colors">✕</button>
    <ul class="list-none flex flex-col gap-6 mt-4">
      <li><a href="/work"     class="font-brutal text-[#FFE500] text-5xl tracking-widest uppercase opacity-90 hover:opacity-100 no-underline block">Work</a></li>
      <li><a href="/studio"   class="font-brutal text-[#FFE500] text-5xl tracking-widest uppercase opacity-90 hover:opacity-100 no-underline block">Studio</a></li>
      <li><a href="/services" class="font-brutal text-[#FFE500] text-5xl tracking-widest uppercase opacity-90 hover:opacity-100 no-underline block">Services</a></li>
      <li><a href="/journal"  class="font-brutal text-[#FFE500] text-5xl tracking-widest uppercase opacity-90 hover:opacity-100 no-underline block">Journal</a></li>
    </ul>
    <div class="mt-auto">
      <a href="#contact"
        class="block text-center bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-sm uppercase tracking-widest px-6 py-4 border-2 border-[#FFE500] no-underline hover:opacity-90 transition-opacity">
        Let's Talk →
      </a>
      <p class="text-[#FFE500] font-body text-xs opacity-40 uppercase tracking-widest mt-6">hello@storytale.id</p>
    </div>
  </div>

  <div id="nav-overlay" class="fixed inset-0 bg-black/50 z-40 hidden opacity-0 transition-opacity duration-300"></div>
</header>

<script>
(function(){
  const btn = document.getElementById('burger-btn');
  const nav = document.getElementById('mobile-nav');
  const close = document.getElementById('close-nav');
  const overlay = document.getElementById('nav-overlay');
  if (!btn) return;
  function openNav() {
    nav.classList.add('open');
    btn.classList.add('burger-open');
    overlay.classList.remove('hidden');
    setTimeout(() => overlay.classList.add('opacity-100'), 10);
    document.body.style.overflow = 'hidden';
  }
  function closeNav() {
    nav.classList.remove('open');
    btn.classList.remove('burger-open');
    overlay.classList.remove('opacity-100');
    setTimeout(() => overlay.classList.add('hidden'), 300);
    document.body.style.overflow = '';
  }
  btn.addEventListener('click', openNav);
  close.addEventListener('click', closeNav);
  overlay.addEventListener('click', closeNav);
})();
</script>
