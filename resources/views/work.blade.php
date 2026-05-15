<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Work — STORYTALE</title>

  <!-- GSAP + ScrollTrigger -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=Bebas+Neue&display=swap" rel="stylesheet" />

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: { yellow: '#FFE500', black: '#0A0A0A' },
          fontFamily: {
            brutal: ['Bebas Neue', 'sans-serif'],
            body:   ['Space Grotesk', 'sans-serif'],
          },
          boxShadow: {
            brutal:    '4px 4px 0px #0A0A0A',
            'brutal-lg': '8px 8px 0px #0A0A0A',
            'brutal-xl': '12px 12px 0px #0A0A0A',
          },
        },
      },
    }
  </script>

  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { background: #FFE500; color: #0A0A0A; font-family: 'Space Grotesk', sans-serif; overflow: hidden; }

    body::before {
      content: '';
      position: fixed; inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
      pointer-events: none;
      z-index: 9999;
    }

    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #FFE500; }
    ::-webkit-scrollbar-thumb { background: #0A0A0A; }

    .burger-line {
      display: block; width: 28px; height: 3px;
      background: #0A0A0A;
      transition: all 0.25s ease;
      transform-origin: center;
    }
    .burger-open .burger-line:nth-child(1) { transform: translateY(9px) rotate(45deg); }
    .burger-open .burger-line:nth-child(2) { opacity: 0; transform: scaleX(0); }
    .burger-open .burger-line:nth-child(3) { transform: translateY(-9px) rotate(-45deg); }

    @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
    .marquee-track { animation: marquee 14s linear infinite; }

    #mobile-nav {
      transform: translateX(100%);
      transition: transform 0.3s cubic-bezier(0.77, 0, 0.175, 1);
    }
    #mobile-nav.open { transform: translateX(0); }

    .nav-link { position: relative; overflow: hidden; }
    .nav-link::after {
      content: '';
      position: absolute; bottom: -2px; left: 0;
      width: 100%; height: 3px;
      background: #0A0A0A;
      transform: scaleX(0); transform-origin: left;
      transition: transform 0.2s ease;
    }
    .nav-link:hover::after { transform: scaleX(1); }
    .nav-link.active::after { transform: scaleX(1); }

    /* ── PRELOADER ─────────────────────────── */
    #preloader {
      position: fixed; inset: 0;
      z-index: 10000;
      background: #0A0A0A;
      display: flex; flex-direction: column;
      overflow: hidden;
    }

    #preloader::before {
      content: '';
      position: absolute; inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.06'/%3E%3C/svg%3E");
      pointer-events: none; z-index: 0;
    }

    .pre-inner { position: relative; z-index: 1; }

    #preloader-count {
      font-family: 'Bebas Neue', sans-serif;
      color: #FFE500;
      font-size: clamp(8rem, 24vw, 24rem);
      line-height: 0.82;
      letter-spacing: -0.02em;
    }

    @keyframes scan {
      0%   { top: 0%; opacity: 0.6; }
      100% { top: 100%; opacity: 0; }
    }
    #preloader-scan {
      position: absolute; left: 0; right: 0; height: 2px;
      background: linear-gradient(90deg, transparent, rgba(255,229,0,0.3), transparent);
      animation: scan 1.8s linear infinite;
      z-index: 2;
    }

    .pre-bracket {
      position: absolute;
      width: 40px; height: 40px;
      border-color: rgba(255,229,0,0.2);
      border-style: solid;
    }
    .pre-bracket-tl { top: 20px; left: 20px; border-width: 3px 0 0 3px; }
    .pre-bracket-tr { top: 20px; right: 20px; border-width: 3px 3px 0 0; }
    .pre-bracket-bl { bottom: 20px; left: 20px; border-width: 0 0 3px 3px; }
    .pre-bracket-br { bottom: 20px; right: 20px; border-width: 0 3px 3px 0; }

    /* ── MASONRY GALLERY ───────────────────── */
    .masonry-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      grid-auto-rows: 300px;
      gap: 4px;
    }
    @media (max-width: 900px) {
      .masonry-grid { grid-template-columns: repeat(2, 1fr); grid-auto-rows: 240px; }
    }
    @media (max-width: 520px) {
      .masonry-grid { grid-template-columns: 1fr; grid-auto-rows: 280px; }
    }

    .gallery-card { grid-row: span 1; }
    .gallery-card[data-size="tall"] { grid-row: span 2; }

    .gallery-card {
      position: relative;
      overflow: hidden;
      background: #0A0A0A;
      cursor: pointer;
      will-change: transform;
      border: 2px solid #0A0A0A;
      transition: box-shadow 0.15s ease;
    }
    .gallery-card:hover { box-shadow: 8px 8px 0 #0A0A0A; z-index: 2; border-color: rgba(255,229,0,0.5); }
    .gallery-card:hover .card-overlay { opacity: 1; }
    .gallery-card:hover .card-arrow { transform: translate(3px, -3px); }
    .gallery-card:hover .card-img img { transform: scale(1.07); filter: brightness(0.3); }
    .gallery-card:hover .card-center { opacity: 1; transform: translateY(0); }
    .gallery-card:hover .card-info { border-color: rgba(255,229,0,0.35); }

    .card-img {
      position: absolute;
      inset: 0;
      bottom: 96px;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }
    .card-img-num {
      font-family: 'Bebas Neue', sans-serif;
      font-size: clamp(5rem, 10vw, 11rem);
      line-height: 1;
      color: rgba(0,0,0,0.18);
      user-select: none;
      pointer-events: none;
    }
    .card-overlay {
      position: absolute;
      inset: 0;
      bottom: 0;
      background: rgba(10,10,10,0.72);
      bottom: 0;
      opacity: 0;
      transition: opacity 0.4s ease;
    }
    .card-img img { transition: transform 0.55s cubic-bezier(.25,.46,.45,.94), filter 0.55s ease; }
    .card-center {
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      text-align: center; padding: 20px;
      opacity: 0; transform: translateY(14px);
      transition: opacity 0.35s ease, transform 0.35s ease;
      pointer-events: none; z-index: 3;
    }
    .card-center-tag { font-family:'Space Grotesk',sans-serif; font-size:0.52rem; font-weight:700; text-transform:uppercase; letter-spacing:0.35em; color:#FFE500; opacity:0.6; margin-bottom:8px; }
    .card-center-title { font-family:'Bebas Neue',sans-serif; font-size:clamp(1.3rem,2.2vw,2rem); color:#FFE500; letter-spacing:0.05em; line-height:1.1; }
    .card-center-cta { margin-top:14px; font-family:'Space Grotesk',sans-serif; font-size:0.58rem; font-weight:700; text-transform:uppercase; letter-spacing:0.22em; color:#0A0A0A; background:#FFE500; padding:6px 14px; }
    .card-info {
      position: absolute;
      bottom: 0; left: 0; right: 0;
      height: 96px;
      padding: 12px 16px;
      background: #0A0A0A;
      border-top: 2px solid rgba(255,229,0,0.12);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .card-tag {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 0.55rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.3em;
      color: #FFE500;
      background: rgba(255,229,0,0.1);
      padding: 2px 8px;
      display: inline-block;
      border: 1px solid rgba(255,229,0,0.2);
    }
    .card-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: clamp(0.85rem, 1.4vw, 1.1rem);
      letter-spacing: 0.04em;
      line-height: 1.1;
      color: #FFE500;
    }
    .card-client {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 0.6rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.2em;
      color: #FFE500;
      opacity: 0.4;
    }
    .card-arrow {
      color: #FFE500;
      opacity: 0.5;
      font-size: 0.9rem;
      transition: transform 0.15s ease;
    }

    /* Filter buttons */
    .filter-btn {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 0.7rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.15em;
      padding: 6px 16px;
      border: 2px solid #0A0A0A;
      cursor: pointer;
      background: transparent;
      color: #0A0A0A;
      transition: background 0.15s ease, color 0.15s ease;
    }
    .filter-btn:hover, .filter-btn.active {
      background: #0A0A0A;
      color: #FFE500;
    }

    /* Page hero */
    @keyframes pageHeroIn {
      from { opacity: 0; transform: translateY(40px) skewY(1deg); }
      to   { opacity: 1; transform: translateY(0) skewY(0); }
    }

    /* CTA section */
    .cta-band {
      background: #0A0A0A;
      border-top: 4px solid #0A0A0A;
      border-bottom: 4px solid #0A0A0A;
    }
  </style>
</head>
<body>

  <!-- ═══════════════════════════════════
       PRELOADER
  ═══════════════════════════════════ -->
  <div id="preloader">
    <div id="preloader-scan"></div>
    <div class="pre-bracket pre-bracket-tl"></div>
    <div class="pre-bracket pre-bracket-tr"></div>
    <div class="pre-bracket pre-bracket-bl"></div>
    <div class="pre-bracket pre-bracket-br"></div>

    <div class="pre-inner" style="padding: 2rem 2.5rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,229,0,0.08);">
      <span style="font-family:'Bebas Neue',sans-serif; color:#FFE500; font-size:1.4rem; letter-spacing:0.2em;">STORYTALE</span>
      <span style="font-family:'Space Grotesk',sans-serif; color:#FFE500; font-size:0.6rem; opacity:0.3; letter-spacing:0.35em; text-transform:uppercase;">Work</span>
    </div>

    <div class="pre-inner" style="flex:1; display:flex; flex-direction:column; justify-content:center; padding: 0 2.5rem;">
      <div style="font-family:'Space Grotesk',sans-serif; color:rgba(255,229,0,0.35); font-size:0.6rem; letter-spacing:0.5em; text-transform:uppercase; margin-bottom:0.75rem;">Loading</div>
      <div id="preloader-count">100</div>
      <div style="font-family:'Space Grotesk',sans-serif; color:rgba(255,229,0,0.2); font-size:0.65rem; letter-spacing:0.3em; text-transform:uppercase; margin-top:1.5rem;">Our Projects & Case Studies</div>
    </div>

    <div class="pre-inner" style="padding: 1.5rem 2.5rem 2rem;">
      <div style="height:2px; background:rgba(255,229,0,0.1); position:relative; overflow:hidden; margin-bottom:0.6rem;">
        <div id="preloader-bar" style="height:100%; width:0%; background:#FFE500; position:absolute; left:0; top:0; transition:none;"></div>
      </div>
      <div style="display:flex; justify-content:space-between; align-items:center;">
        <span style="font-family:'Space Grotesk',sans-serif; color:#FFE500; font-size:0.6rem; opacity:0.25; letter-spacing:0.35em; text-transform:uppercase;">Jakarta, ID</span>
        <span id="preloader-pct" style="font-family:'Space Grotesk',sans-serif; color:#FFE500; font-size:0.6rem; opacity:0.35; letter-spacing:0.25em; font-weight:700;">0%</span>
      </div>
    </div>
  </div>


  @include('partials.header')


  <!-- ═══════════════════════════════════
       PAGE HERO
  ═══════════════════════════════════ -->
  <section id="page-hero"
    class="relative bg-[#FFE500] border-b-4 border-[#0A0A0A] overflow-hidden"
    style="padding-top: var(--header-h, 100px);">

    <!-- Grid lines -->
    <div class="absolute inset-0 pointer-events-none"
      style="background-image:repeating-linear-gradient(0deg,transparent,transparent 79px,rgba(10,10,10,0.07) 79px,rgba(10,10,10,0.07) 80px),repeating-linear-gradient(90deg,transparent,transparent 79px,rgba(10,10,10,0.07) 79px,rgba(10,10,10,0.07) 80px);">
    </div>

    <!-- Decorative big number -->
    <div class="absolute right-6 lg:right-16 bottom-0 font-brutal text-[#0A0A0A] opacity-[0.04] leading-none select-none pointer-events-none"
      style="font-size: clamp(10rem, 28vw, 30rem); line-height: 0.8;">
      WORK
    </div>

    <div id="hero-content" class="relative z-10 max-w-[1440px] mx-auto px-6 lg:px-12 py-16 lg:py-20" style="opacity:0;">

      <!-- Breadcrumb -->
      <div class="flex items-center gap-3 mb-6">
        <a href="/" class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-40 hover:opacity-70 no-underline transition-opacity">Home</a>
        <span class="font-body text-xs text-[#0A0A0A] opacity-30">/</span>
        <span class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A]">Work</span>
      </div>

      <!-- Heading row -->
      <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 border-b-4 border-[#0A0A0A] pb-10">
        <div>
          <span class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-40">§ Selected Projects</span>
          <h1 class="font-brutal text-[clamp(4rem,10vw,12rem)] uppercase text-[#0A0A0A] leading-none tracking-tight mt-1">
            Our<br/>Work
          </h1>
        </div>

        <div class="lg:max-w-sm lg:pb-4">
          <p class="font-body text-base text-[#0A0A0A] opacity-60 leading-relaxed font-medium">
            Digital ads, rich media, video production, websites, CRM, and AI-powered apps — here's a selection of the work we've built to move audiences and grow businesses.
          </p>
          <!-- Stats -->
          <div class="flex gap-0 border-2 border-[#0A0A0A] shadow-brutal mt-6 w-fit">
            <div class="flex flex-col items-center justify-center px-6 py-4 border-r-2 border-[#0A0A0A]">
              <span class="font-brutal text-4xl text-[#0A0A0A] leading-none">87</span>
              <span class="font-body text-[9px] font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50 mt-1">Projects</span>
            </div>
            <div class="flex flex-col items-center justify-center px-6 py-4 border-r-2 border-[#0A0A0A]">
              <span class="font-brutal text-4xl text-[#0A0A0A] leading-none">8+</span>
              <span class="font-body text-[9px] font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50 mt-1">Years</span>
            </div>
            <div class="flex flex-col items-center justify-center px-6 py-4">
              <span class="font-brutal text-4xl text-[#0A0A0A] leading-none">★4</span>
              <span class="font-body text-[9px] font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50 mt-1">Awards</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ═══════════════════════════════════
       WORK GALLERY
  ═══════════════════════════════════ -->
  <section id="gallery-section" class="bg-[#FFE500] border-b-4 border-[#0A0A0A] pt-12 pb-28">

    <!-- Filter + count row -->
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12 mb-8">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

        <!-- Filter buttons -->
        <div id="gallery-filters" class="flex flex-wrap gap-2">
          <button class="filter-btn active" data-filter="all">All</button>
          <button class="filter-btn" data-filter="digital-ads">Digital Ads</button>
          <button class="filter-btn" data-filter="rich-media">Rich Media</button>
          <button class="filter-btn" data-filter="newsletter">Newsletter</button>
          <button class="filter-btn" data-filter="digital-strategy">Strategy</button>
          <button class="filter-btn" data-filter="video-ads">Video Ads</button>
          <button class="filter-btn" data-filter="website">Website</button>
          <button class="filter-btn" data-filter="crm">CRM</button>
          <button class="filter-btn" data-filter="ai-apps">AI Apps</button>
        </div>

        <!-- Project count -->
        <div class="flex items-baseline gap-2">
          <span id="gallery-count" class="font-brutal text-[#0A0A0A] text-5xl leading-none opacity-20">—</span>
          <span class="font-body text-[10px] font-bold uppercase tracking-widest text-[#0A0A0A] opacity-40">Projects</span>
        </div>
      </div>
    </div>

    <!-- Masonry grid -->
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
      <div id="gallery-grid" class="masonry-grid">
        <div id="gallery-loading" style="grid-column:1/-1; display:flex; align-items:center; justify-content:center; padding:5rem 0;">
          <span class="font-brutal text-[#0A0A0A] text-3xl tracking-widest opacity-20">Loading...</span>
        </div>
      </div>
    </div>

  </section>


  <!-- ═══════════════════════════════════
       CTA BAND
  ═══════════════════════════════════ -->
  <section class="cta-band py-20 lg:py-28">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
      <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-10">

        <div>
          <span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-40">Ready to work together?</span>
          <h2 class="font-brutal text-[clamp(2.5rem,6vw,7rem)] text-[#FFE500] leading-none tracking-tight mt-2 uppercase">
            Let's Tell<br/>Your Story.
          </h2>
        </div>

        <div class="flex flex-col gap-4">
          <p class="font-body text-sm text-[#FFE500] opacity-50 max-w-xs leading-relaxed">
            Have a project in mind? We'd love to hear about it. Reach out and let's build something remarkable together.
          </p>
          <div class="flex flex-wrap gap-4">
            <a href="/#contact"
              class="inline-block bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-sm uppercase tracking-widest px-8 py-4 border-2 border-[#FFE500] shadow-brutal hover:translate-x-[3px] hover:translate-y-[3px] hover:shadow-none transition-all duration-150 no-underline"
              style="box-shadow: 4px 4px 0px rgba(255,229,0,0.3);">
              Start a Project →
            </a>
            <a href="mailto:hello@storytale.id"
              class="inline-block bg-transparent text-[#FFE500] font-body font-bold text-sm uppercase tracking-widest px-8 py-4 border-2 border-[#FFE500] hover:bg-[#FFE500] hover:text-[#0A0A0A] transition-all duration-150 no-underline">
              hello@storytale.id
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>


  <!-- ═══════════════════════════════════
       FOOTER
  ═══════════════════════════════════ -->
  @include('partials.footer')


  <!-- ═══════════════════════════════════
       SCRIPTS
  ═══════════════════════════════════ -->
  <script>
  (function () {

    // ── Header height sync ─────────────────────────────────
    const header = document.getElementById('site-header');
    function syncHeaderHeight() {
      document.documentElement.style.setProperty(
        '--header-h', header.getBoundingClientRect().height + 'px'
      );
    }
    syncHeaderHeight();
    window.addEventListener('resize', syncHeaderHeight);


    // ── Preloader ──────────────────────────────────────────
    const countEl   = document.getElementById('preloader-count');
    const barEl     = document.getElementById('preloader-bar');
    const pctEl     = document.getElementById('preloader-pct');
    const preloader = document.getElementById('preloader');
    const counter   = { val: 100 };

    gsap.to(counter, {
      val: 0,
      duration: 1.8,
      ease: 'power2.inOut',
      onUpdate() {
        const v = Math.round(counter.val);
        countEl.textContent = String(v).padStart(3, '0');
        barEl.style.width   = (100 - v) + '%';
        if (pctEl) pctEl.textContent = (100 - v) + '%';
      },
      onComplete() {
        gsap.to(preloader, {
          yPercent: -105,
          duration: 0.9,
          ease: 'expo.inOut',
          delay: 0.2,
          onStart() {
            gsap.to(barEl, { width: '100%', duration: 0.1 });
          },
          onComplete() {
            preloader.style.display = 'none';
            document.body.style.overflow = 'auto';
            animatePageIn();
          }
        });
      }
    });


    // ── Page entrance ─────────────────────────────────────
    function animatePageIn() {
      gsap.registerPlugin(ScrollTrigger);

      gsap.fromTo('#hero-content',
        { opacity: 0, y: 40 },
        { opacity: 1, y: 0, duration: 0.8, ease: 'power3.out' }
      );

      initGallery();
    }


    // ── Mobile nav ─────────────────────────────────────────
    const burgerBtn = document.getElementById('burger-btn');
    const mobileNav = document.getElementById('mobile-nav');
    const closeNav  = document.getElementById('close-nav');
    const overlay   = document.getElementById('nav-overlay');

    function openMenu() {
      mobileNav.classList.add('open');
      overlay.classList.remove('hidden');
      setTimeout(() => overlay.classList.add('opacity-100'), 10);
      burgerBtn.classList.add('burger-open');
      document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
      mobileNav.classList.remove('open');
      overlay.classList.remove('opacity-100');
      setTimeout(() => overlay.classList.add('hidden'), 300);
      burgerBtn.classList.remove('burger-open');
      document.body.style.overflow = '';
    }

    burgerBtn.addEventListener('click', () =>
      mobileNav.classList.contains('open') ? closeMenu() : openMenu()
    );
    closeNav.addEventListener('click', closeMenu);
    overlay.addEventListener('click', closeMenu);


    // ── Work gallery ───────────────────────────────────────
    const CAT_COLORS = {
      'digital-ads':      { bg: '#FF2D2D' },
      'rich-media':       { bg: '#FF6B00' },
      'newsletter':       { bg: '#9900DD' },
      'digital-strategy': { bg: '#2255FF' },
      'video-ads':        { bg: '#E91E8C' },
      'website':          { bg: '#00AA50' },
      'crm':              { bg: '#0088CC' },
      'ai-apps':          { bg: '#0A0A0A' },
      'default':          { bg: '#222222' },
    };

    /* subtle bg textures per category */
    const CAT_PATTERNS = {
      'digital-ads':      'repeating-linear-gradient(0deg,transparent,transparent 19px,rgba(0,0,0,0.06) 19px,rgba(0,0,0,0.06) 20px),repeating-linear-gradient(90deg,transparent,transparent 19px,rgba(0,0,0,0.06) 19px,rgba(0,0,0,0.06) 20px)',
      'rich-media':       'radial-gradient(circle,rgba(0,0,0,0.1) 1px,transparent 1px)',
      'newsletter':       'repeating-linear-gradient(-45deg,transparent,transparent 12px,rgba(0,0,0,0.06) 12px,rgba(0,0,0,0.06) 13px)',
      'digital-strategy': 'repeating-linear-gradient(45deg,transparent,transparent 12px,rgba(0,0,0,0.06) 12px,rgba(0,0,0,0.06) 13px)',
      'video-ads':        'repeating-linear-gradient(-60deg,transparent,transparent 14px,rgba(0,0,0,0.06) 14px,rgba(0,0,0,0.06) 15px)',
      'website':          'radial-gradient(circle,rgba(0,0,0,0.1) 1px,transparent 1px)',
      'crm':              'repeating-linear-gradient(0deg,transparent,transparent 19px,rgba(0,0,0,0.06) 19px,rgba(0,0,0,0.06) 20px),repeating-linear-gradient(90deg,transparent,transparent 19px,rgba(0,0,0,0.06) 19px,rgba(0,0,0,0.06) 20px)',
      'ai-apps':          'repeating-linear-gradient(45deg,transparent,transparent 12px,rgba(255,229,0,0.05) 12px,rgba(255,229,0,0.05) 13px)',
      'default':          'repeating-linear-gradient(-45deg,transparent,transparent 12px,rgba(255,255,255,0.04) 12px,rgba(255,255,255,0.04) 13px)',
    };
    const PAT_SIZES = { 'rich-media': '20px 20px', 'website': '20px 20px' };

    const SIZE_PATTERN = ['tall', 'small', 'tall', 'small', 'small', 'tall'];

    const FALLBACK = [
      { id:1, title:'Kopi Nusantara — Search & Display Ads',   client:'Kopi Nusantara',  category_slug:'digital-ads',       category_name:'Digital Ads',       slug:'kopi-nusantara-digital-ads',  project_year:2024 },
      { id:2, title:'BeautyLab — HTML5 Rich Media Banners',    client:'BeautyLab',        category_slug:'rich-media',        category_name:'Rich Media',        slug:'beautylab-rich-media',        project_year:2024 },
      { id:3, title:'Lawson ID — Email Newsletter Campaign',   client:'Lawson Indonesia', category_slug:'newsletter',        category_name:'Newsletter',        slug:'lawson-id-newsletter',        project_year:2023 },
      { id:4, title:'EduPath — Annual Digital Strategy',       client:'EduPath',          category_slug:'digital-strategy',  category_name:'Digital Strategy',  slug:'edupath-digital-strategy',    project_year:2024 },
      { id:5, title:'Toko Sehat — TikTok & YouTube Video Ads', client:'Toko Sehat',       category_slug:'video-ads',         category_name:'Video Ads',         slug:'toko-sehat-video-ads',        project_year:2024 },
      { id:6, title:'Pondok Asri — Website Redesign',          client:'Pondok Asri',      category_slug:'website',           category_name:'Website',           slug:'pondok-asri-website',         project_year:2023 },
      { id:7, title:'Matahari — CRM Setup & Automation',       client:'Matahari',         category_slug:'crm',               category_name:'CRM',               slug:'matahari-crm',                project_year:2024 },
      { id:8, title:'GreenSpace — AI Customer Chatbot',        client:'GreenSpace ID',    category_slug:'ai-apps',           category_name:'AI Apps',           slug:'greenspace-ai-chatbot',       project_year:2025 },
      { id:9, title:'Wahana Kuliner — Meta & Google Ads',      client:'Wahana Kuliner',   category_slug:'digital-ads',       category_name:'Digital Ads',       slug:'wahana-kuliner-digital-ads',  project_year:2024 },
    ];

    let allProjects = [];

    function buildCard(project, index) {
      const size    = SIZE_PATTERN[index % SIZE_PATTERN.length];
      const color   = CAT_COLORS[project.category_slug] || CAT_COLORS.default;
      const pat     = CAT_PATTERNS[project.category_slug] || CAT_PATTERNS.default;
      const patSize = PAT_SIZES[project.category_slug] || '';
      const num     = String(project.id).padStart(2, '0');
      const cat     = project.category_name || '';
      const isAi    = project.category_slug === 'ai-apps';
      const dimC    = isAi ? 'rgba(255,229,0,0.08)' : 'rgba(0,0,0,0.10)';
      const brkC    = isAi ? 'rgba(255,229,0,0.22)' : 'rgba(0,0,0,0.20)';
      const lblC    = isAi ? 'rgba(255,229,0,0.22)' : 'rgba(0,0,0,0.22)';

      const card = document.createElement('a');
      card.href = '/work/' + project.slug;
      card.className = 'gallery-card';
      card.style.textDecoration = 'none';
      card.dataset.size     = size;
      card.dataset.category = project.category_slug || '';

      const hasCover = project.cover_image && project.cover_image.trim();

      card.innerHTML = `
        <div class="card-img" style="background:${hasCover ? '#111' : color.bg};">

          ${hasCover ? `<img src="${project.cover_image}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" loading="lazy"/>` : `
          <!-- texture pattern -->
          <div style="position:absolute;inset:0;pointer-events:none;
            background-image:${pat};
            ${patSize ? `background-size:${patSize};` : ''}"></div>

          <!-- rotated diamond accent -->
          <div style="position:absolute;top:50%;left:50%;
            transform:translate(-50%,-55%) rotate(45deg);
            width:clamp(52px,6.5vw,90px);height:clamp(52px,6.5vw,90px);
            border:2px solid ${brkC};pointer-events:none;z-index:1;"></div>

          <!-- project number (centered) -->
          <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;
            pointer-events:none;z-index:1;">
            <span style="font-family:'Bebas Neue',sans-serif;
              font-size:clamp(4.5rem,9vw,10rem);line-height:1;
              color:${dimC};letter-spacing:-0.02em;">${num}</span>
          </div>`}

          <!-- corner brackets (always shown) -->
          <div style="position:absolute;top:14px;left:14px;width:18px;height:18px;
            border-top:2px solid ${brkC};border-left:2px solid ${brkC};pointer-events:none;z-index:2;"></div>
          <div style="position:absolute;top:14px;right:14px;width:18px;height:18px;
            border-top:2px solid ${brkC};border-right:2px solid ${brkC};pointer-events:none;z-index:2;"></div>

          <!-- vertical category label -->
          <div style="position:absolute;bottom:18px;right:12px;pointer-events:none;z-index:1;
            font-family:'Space Grotesk',sans-serif;font-size:0.42rem;font-weight:700;
            text-transform:uppercase;letter-spacing:0.38em;color:${lblC};
            writing-mode:vertical-rl;transform:rotate(180deg);white-space:nowrap;">${cat}</div>

          <div class="card-overlay"></div>
          <div class="card-center">
            ${cat ? `<div class="card-center-tag">${cat}</div>` : ''}
            <div class="card-center-title">${project.title}</div>
            <div class="card-center-cta">View Project →</div>
          </div>
        </div>
        <div class="card-info">
          <div style="display:flex;justify-content:space-between;align-items:center;">
            <span class="card-tag">${cat}</span>
            <span class="card-arrow">↗</span>
          </div>
          <div>
            <div class="card-title">${project.title}</div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-top:3px;">
              <span class="card-client">${project.client}</span>
              <span class="card-client">${project.project_year || ''}</span>
            </div>
          </div>
        </div>`;

      return card;
    }

    function renderGallery(projects) {
      const grid = document.getElementById('gallery-grid');
      grid.innerHTML = '';

      if (!projects.length) {
        grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:5rem 0; font-family:\'Bebas Neue\',sans-serif; color:#0A0A0A; opacity:0.25; font-size:2rem; letter-spacing:0.2em;">No projects found</div>';
        return;
      }

      projects.forEach((p, i) => grid.appendChild(buildCard(p, i)));

      gsap.fromTo('.gallery-card',
        { opacity: 0, y: 24 },
        {
          opacity: 1, y: 0,
          duration: 0.5, stagger: 0.05, ease: 'power2.out',
          scrollTrigger: { trigger: '#gallery-section', start: 'top 88%', once: true }
        }
      );
    }

    function updateCount(n) {
      const el = document.getElementById('gallery-count');
      if (el) el.textContent = String(n).padStart(2, '0');
    }

    function initGallery() {
      fetch('/api/projects')
        .then(r => { if (!r.ok) throw new Error(); return r.json(); })
        .then(data => { allProjects = data; updateCount(data.length); renderGallery(data); })
        .catch(() => { allProjects = FALLBACK; updateCount(FALLBACK.length); renderGallery(FALLBACK); });
    }

    document.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const f = btn.dataset.filter;
        const filtered = f === 'all' ? allProjects : allProjects.filter(p => p.category_slug === f);
        updateCount(filtered.length);
        renderGallery(filtered);
      });
    });

  })();
  </script>

<script>
fetch("/api/settings").then(r=>r.json()).then(cfg=>{const wa=(cfg.contact||{}).whatsapp;if(wa){const u="https://wa.me/"+wa.replace(/\D/g,"");const el=document.getElementById("navbar-wa-link");if(el)el.href=u;}}).catch(()=>{});
</script>
</body>
</html>
