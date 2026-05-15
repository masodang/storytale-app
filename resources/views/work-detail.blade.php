<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title id="page-title">Project — STORYTALE</title>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=Bebas+Neue&display=swap" rel="stylesheet" />
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
      pointer-events: none; z-index: 9999;
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
      width: 100%; height: 3px; background: #0A0A0A;
      transform: scaleX(0); transform-origin: left;
      transition: transform 0.2s ease;
    }
    .nav-link:hover::after { transform: scaleX(1); }
    .nav-link.active::after { transform: scaleX(1); }

    /* ── PRELOADER ─────────────────────────── */
    #preloader {
      position: fixed; inset: 0; z-index: 10000;
      background: #0A0A0A;
      display: flex; flex-direction: column; overflow: hidden;
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
      line-height: 0.82; letter-spacing: -0.02em;
    }
    @keyframes scan {
      0%   { top: 0%; opacity: 0.6; }
      100% { top: 100%; opacity: 0; }
    }
    #preloader-scan {
      position: absolute; left: 0; right: 0; height: 2px;
      background: linear-gradient(90deg, transparent, rgba(255,229,0,0.3), transparent);
      animation: scan 1.8s linear infinite; z-index: 2;
    }
    .pre-bracket {
      position: absolute; width: 40px; height: 40px;
      border-color: rgba(255,229,0,0.2); border-style: solid;
    }
    .pre-bracket-tl { top: 20px; left: 20px;   border-width: 3px 0 0 3px; }
    .pre-bracket-tr { top: 20px; right: 20px;  border-width: 3px 3px 0 0; }
    .pre-bracket-bl { bottom: 20px; left: 20px;  border-width: 0 0 3px 3px; }
    .pre-bracket-br { bottom: 20px; right: 20px; border-width: 0 3px 3px 0; }

    /* ── PROJECT HERO ─────────────────────── */
    .hero-cover {
      position: relative;
      overflow: hidden;
      border-bottom: 4px solid #0A0A0A;
    }

    /* ── IMAGE GALLERY ────────────────────── */
    .img-gallery {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 4px;
    }
    @media (max-width: 640px) {
      .img-gallery { grid-template-columns: 1fr; }
    }
    .img-gallery-item {
      aspect-ratio: 4/3;
      overflow: hidden;
      background: #0A0A0A;
      border: 2px solid #0A0A0A;
      display: flex; align-items: center; justify-content: center;
      position: relative;
    }
    .img-gallery-item img {
      width: 100%; height: 100%; object-fit: cover;
      transition: transform 0.5s ease;
    }
    .img-gallery-item:hover img { transform: scale(1.04); }
    .img-gallery-item.wide { grid-column: span 2; aspect-ratio: 16/7; }
    @media (max-width: 640px) { .img-gallery-item.wide { grid-column: span 1; aspect-ratio: 4/3; } }

    /* ── METRIC CARD ──────────────────────── */
    .metric-card {
      background: #0A0A0A;
      border: 2px solid #0A0A0A;
      padding: 1.5rem 1.75rem;
      display: flex; flex-direction: column; gap: 0.3rem;
      position: relative; overflow: hidden;
    }
    .metric-card::before {
      content: '';
      position: absolute; inset: 0;
      background: var(--mc, #FF2D2D);
      transform: translateY(101%);
      transition: transform 0.4s cubic-bezier(0.77,0,0.175,1);
      z-index: 0;
    }
    .metric-card:hover::before { transform: translateY(0); }
    .metric-card > * { position: relative; z-index: 1; }
    .metric-card:hover .mc-val,
    .metric-card:hover .mc-label { color: #0A0A0A; }

    /* ── NEXT PROJECT ─────────────────────── */
    .next-project-card {
      position: relative;
      overflow: hidden;
      background: #0A0A0A;
      border: 2px solid #0A0A0A;
      cursor: pointer;
      display: block;
      text-decoration: none;
      transition: box-shadow 0.15s ease;
      aspect-ratio: 16/7;
    }
    @media (max-width: 640px) { .next-project-card { aspect-ratio: 4/3; } }
    .next-project-card:hover { box-shadow: 12px 12px 0 #0A0A0A; }
    .next-project-card:hover .npc-arrow { transform: translate(6px, -6px); }
    .npc-overlay {
      position: absolute; inset: 0;
      background: rgba(0,0,0,0.55);
      display: flex; flex-direction: column;
      justify-content: flex-end;
      padding: 2.5rem;
    }
    .npc-arrow {
      transition: transform 0.2s ease;
      display: inline-block;
    }

    /* ── NOT FOUND ────────────────────────── */
    #not-found { display: none; }
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
      <span id="pre-category-label" style="font-family:'Space Grotesk',sans-serif; color:#FFE500; font-size:0.6rem; opacity:0.3; letter-spacing:0.35em; text-transform:uppercase;">Case Study</span>
    </div>

    <div class="pre-inner" style="flex:1; display:flex; flex-direction:column; justify-content:center; padding: 0 2.5rem;">
      <div style="font-family:'Space Grotesk',sans-serif; color:rgba(255,229,0,0.35); font-size:0.6rem; letter-spacing:0.5em; text-transform:uppercase; margin-bottom:0.75rem;">Loading</div>
      <div id="preloader-count">100</div>
      <div id="pre-project-label" style="font-family:'Space Grotesk',sans-serif; color:rgba(255,229,0,0.2); font-size:0.65rem; letter-spacing:0.3em; text-transform:uppercase; margin-top:1.5rem;">Project Detail</div>
    </div>

    <div class="pre-inner" style="padding: 1.5rem 2.5rem 2rem;">
      <div style="height:2px; background:rgba(255,229,0,0.1); position:relative; overflow:hidden; margin-bottom:0.6rem;">
        <div id="preloader-bar" style="height:100%; width:0%; background:#FFE500; position:absolute; left:0; top:0;"></div>
      </div>
      <div style="display:flex; justify-content:space-between; align-items:center;">
        <span style="font-family:'Space Grotesk',sans-serif; color:#FFE500; font-size:0.6rem; opacity:0.25; letter-spacing:0.35em; text-transform:uppercase;">Jakarta, ID</span>
        <span id="preloader-pct" style="font-family:'Space Grotesk',sans-serif; color:#FFE500; font-size:0.6rem; opacity:0.35; letter-spacing:0.25em; font-weight:700;">0%</span>
      </div>
    </div>
  </div>


  @include('partials.header')


  <!-- ═══════════════════════════════════
       NOT FOUND STATE
  ═══════════════════════════════════ -->
  <div id="not-found" style="padding-top: var(--header-h, 100px);">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12 py-32 text-center">
      <div class="font-brutal text-[clamp(4rem,15vw,16rem)] text-[#0A0A0A] opacity-10 leading-none">404</div>
      <h1 class="font-brutal text-[clamp(2rem,5vw,5rem)] text-[#0A0A0A] uppercase tracking-tight -mt-4">Project not found</h1>
      <p class="font-body text-sm text-[#0A0A0A] opacity-50 mt-4 mb-8">This project doesn't exist or has been removed.</p>
      <a href="/work" class="inline-block bg-[#0A0A0A] text-[#FFE500] font-body font-bold text-sm uppercase tracking-widest px-8 py-4 border-2 border-[#0A0A0A] shadow-brutal hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-150 no-underline">
        ← Back to Work
      </a>
    </div>
  </div>


  <!-- ═══════════════════════════════════
       PROJECT CONTENT (filled by JS)
  ═══════════════════════════════════ -->
  <div id="project-wrap" style="opacity:0;">

    <!-- ── PROJECT HERO ──────────────────────────────────── -->
    <section id="project-hero" class="hero-cover" style="padding-top: var(--header-h, 100px);">

      <!-- Grid lines -->
      <div class="absolute inset-0 pointer-events-none"
        style="background-image:repeating-linear-gradient(0deg,transparent,transparent 79px,rgba(10,10,10,0.07) 79px,rgba(10,10,10,0.07) 80px),repeating-linear-gradient(90deg,transparent,transparent 79px,rgba(10,10,10,0.07) 79px,rgba(10,10,10,0.07) 80px);">
      </div>

      <!-- Ghost title in bg -->
      <div id="hero-ghost" class="absolute right-0 bottom-0 font-brutal text-[#0A0A0A] opacity-[0.04] leading-none select-none pointer-events-none text-right"
        style="font-size: clamp(6rem, 18vw, 22rem); line-height: 0.85; padding-right: 1rem;"></div>

      <div class="relative z-10 max-w-[1440px] mx-auto px-6 lg:px-12 pt-12 pb-0">

        <!-- Breadcrumb -->
        <div class="flex items-center gap-3 mb-8">
          <a href="/" class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-40 hover:opacity-70 no-underline transition-opacity">Home</a>
          <span class="text-[#0A0A0A] opacity-30 text-xs">/</span>
          <a href="/work" class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-40 hover:opacity-70 no-underline transition-opacity">Work</a>
          <span class="text-[#0A0A0A] opacity-30 text-xs">/</span>
          <span id="breadcrumb-title" class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] truncate max-w-[200px]"></span>
        </div>

        <!-- Meta row -->
        <div class="flex flex-wrap items-center gap-3 mb-6">
          <span id="hero-category-tag" class="font-body text-xs font-bold uppercase tracking-[0.25em] text-[#FFE500] px-3 py-1 border border-[rgba(255,229,0,0.2)]" style="background: rgba(255,229,0,0.1)"></span>
          <span class="font-body text-[10px] font-bold uppercase tracking-widest text-[#0A0A0A] opacity-30">×</span>
          <span id="hero-year" class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50"></span>
        </div>

        <!-- Title -->
        <h1 id="hero-title" class="font-brutal text-[clamp(2.8rem,6.5vw,8rem)] text-[#0A0A0A] leading-none tracking-tight uppercase mb-8" style="max-width: 900px;"></h1>

        <!-- Info bar -->
        <div class="flex flex-col sm:flex-row gap-0 border-t-4 border-b-4 border-[#0A0A0A]">
          <div class="flex-1 border-b-2 sm:border-b-0 sm:border-r-2 border-[#0A0A0A] py-5 pr-8">
            <div class="font-body text-[9px] font-bold uppercase tracking-[0.35em] text-[#0A0A0A] opacity-40 mb-1">Client</div>
            <div id="hero-client" class="font-brutal text-2xl text-[#0A0A0A] tracking-widest uppercase"></div>
          </div>
          <div class="flex-1 border-b-2 sm:border-b-0 sm:border-r-2 border-[#0A0A0A] py-5 px-0 sm:px-8">
            <div class="font-body text-[9px] font-bold uppercase tracking-[0.35em] text-[#0A0A0A] opacity-40 mb-1">Service</div>
            <div id="hero-service" class="font-brutal text-2xl text-[#0A0A0A] tracking-widest uppercase"></div>
          </div>
          <div class="flex-1 py-5 pl-0 sm:pl-8">
            <div class="font-body text-[9px] font-bold uppercase tracking-[0.35em] text-[#0A0A0A] opacity-40 mb-1">Year</div>
            <div id="hero-year-bar" class="font-brutal text-2xl text-[#0A0A0A] tracking-widest uppercase"></div>
          </div>
        </div>
      </div>

      <!-- Cover image / color block -->
      <div id="hero-cover-block" class="w-full mt-0" style="height: clamp(280px, 40vw, 560px);">
        <div id="hero-cover-inner" class="w-full h-full relative flex items-center justify-center overflow-hidden">
          <span id="hero-cover-num" class="font-brutal text-[#0A0A0A] opacity-10 select-none pointer-events-none" style="font-size: clamp(12rem, 30vw, 32rem); line-height:1;"></span>
        </div>
      </div>
    </section>


    <!-- ── PROJECT BODY ──────────────────────────────────── -->
    <section class="bg-[#FFE500] border-b-4 border-[#0A0A0A] pt-20 pb-24 lg:pt-24">
      <div class="max-w-[1440px] mx-auto px-6 lg:px-12">

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_400px] gap-16 lg:gap-20">

          <!-- Left: description + content -->
          <div>
            <div class="font-body text-[9px] font-bold uppercase tracking-[0.4em] text-[#0A0A0A] opacity-40 mb-4">Overview</div>
            <p id="project-description" class="font-body text-lg lg:text-xl text-[#0A0A0A] leading-relaxed font-medium" style="max-width: 640px;"></p>

            <div id="project-content-wrap" class="mt-10 hidden">
              <div id="project-content" class="font-body text-base text-[#0A0A0A] leading-relaxed opacity-70 prose" style="max-width: 640px;"></div>
            </div>
          </div>

          <!-- Right: metrics -->
          <div>
            <div class="font-body text-[9px] font-bold uppercase tracking-[0.4em] text-[#0A0A0A] opacity-40 mb-4">Results</div>
            <div id="metrics-grid" class="grid grid-cols-2 gap-[3px]">
              <!-- filled by JS -->
            </div>

            <!-- Tags -->
            <div class="mt-8">
              <div class="font-body text-[9px] font-bold uppercase tracking-[0.4em] text-[#0A0A0A] opacity-40 mb-3">Scope</div>
              <div id="scope-tags" class="flex flex-wrap gap-2"></div>
            </div>
          </div>

        </div>
      </div>
    </section>


    <!-- ── IMAGE GALLERY ─────────────────────────────────── -->
    <section id="gallery-section" class="bg-[#0A0A0A] border-b-4 border-[#0A0A0A] pt-16 pb-20">
      <div class="max-w-[1440px] mx-auto px-6 lg:px-12">

        <div class="flex items-end justify-between mb-8 border-b border-[rgba(255,229,0,0.1)] pb-6">
          <div>
            <div class="font-body text-[9px] font-bold uppercase tracking-[0.4em] text-[#FFE500] opacity-40 mb-1">Visual</div>
            <h2 class="font-brutal text-[clamp(2rem,4vw,5rem)] text-[#FFE500] uppercase tracking-tight leading-none">Project Gallery</h2>
          </div>
          <span id="img-count" class="font-brutal text-[#FFE500] opacity-10 text-6xl leading-none"></span>
        </div>

        <!-- Embed (iframe/video) -->
        <div id="embed-wrap" class="hidden mb-6 overflow-hidden border-2 border-[rgba(255,229,0,0.1)]" style="line-height:0;"></div>

        <div id="img-gallery" class="img-gallery"></div>
      </div>
    </section>


    <!-- ── NEXT PROJECT ──────────────────────────────────── -->
    <section id="next-section" class="bg-[#FFE500] border-b-4 border-[#0A0A0A] pt-16 pb-20 hidden">
      <div class="max-w-[1440px] mx-auto px-6 lg:px-12">

        <div class="flex items-center justify-between mb-8">
          <div class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-40">Up Next</div>
          <a href="/work" class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50 hover:opacity-100 no-underline transition-opacity">All Projects →</a>
        </div>

        <a id="next-project-link" href="/work" class="next-project-card">
          <div id="next-project-bg" class="absolute inset-0"></div>
          <div id="next-project-num" class="absolute inset-0 flex items-center justify-center font-brutal text-[#0A0A0A] opacity-10 select-none pointer-events-none" style="font-size: clamp(8rem, 22vw, 24rem);"></div>
          <div class="npc-overlay">
            <div class="font-body text-[9px] font-bold uppercase tracking-[0.35em] text-[#FFE500] opacity-50 mb-3">Next Project</div>
            <div class="flex items-end justify-between">
              <div>
                <div id="next-category" class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-60 mb-2"></div>
                <div id="next-title" class="font-brutal text-[clamp(1.8rem,4vw,5rem)] text-[#FFE500] leading-none uppercase tracking-tight"></div>
                <div id="next-client" class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mt-2"></div>
              </div>
              <div class="font-brutal text-[#FFE500] text-5xl npc-arrow">↗</div>
            </div>
          </div>
        </a>
      </div>
    </section>


    <!-- ── CTA ───────────────────────────────────────────── -->
    <section class="bg-[#0A0A0A] py-20 lg:py-28">
      <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-10">
          <div>
            <span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-40">Like what you see?</span>
            <h2 class="font-brutal text-[clamp(2.5rem,6vw,7rem)] text-[#FFE500] leading-none tracking-tight mt-2 uppercase">
              Let's Work<br/>Together.
            </h2>
          </div>
          <div class="flex flex-col gap-4">
            <p class="font-body text-sm text-[#FFE500] opacity-50 max-w-xs leading-relaxed">
              Have a project in mind? Let's build something remarkable.
            </p>
            <div class="flex flex-wrap gap-4">
              <a href="/#contact"
                class="inline-block bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-sm uppercase tracking-widest px-8 py-4 border-2 border-[#FFE500] hover:bg-transparent hover:text-[#FFE500] transition-all duration-150 no-underline">
                Start a Project →
              </a>
              <a href="/work"
                class="inline-block bg-transparent text-[#FFE500] font-body font-bold text-sm uppercase tracking-widest px-8 py-4 border-2 border-[rgba(255,229,0,0.3)] hover:border-[#FFE500] transition-all duration-150 no-underline">
                ← All Work
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- ── FOOTER ────────────────────────────────────────── -->
    @include('partials.footer')

  </div><!-- /#project-wrap -->


  <!-- ═══════════════════════════════════
       SCRIPTS
  ═══════════════════════════════════ -->
  <script>
  (function () {

    // ── Header height sync ────────────────────────────────
    const header = document.getElementById('site-header');
    function syncHeaderHeight() {
      document.documentElement.style.setProperty('--header-h', header.getBoundingClientRect().height + 'px');
    }
    syncHeaderHeight();
    window.addEventListener('resize', syncHeaderHeight);


    // ── Get slug from URL ─────────────────────────────────
    const slug = location.pathname.replace(/^\/work\//, '').replace(/\/$/, '');


    // ── Fallback data ─────────────────────────────────────
    const CAT_COLORS = {
      'digital-ads':      '#FF2D2D',
      'rich-media':       '#FF6B00',
      'newsletter':       '#9900DD',
      'digital-strategy': '#2255FF',
      'video-ads':        '#E91E8C',
      'website':          '#00AA50',
      'crm':              '#0088CC',
      'ai-apps':          '#0A0A0A',
      'default':          '#222222',
    };

    const METRICS_MAP = {
      'digital-ads':      [{ val:'4.2×',  label:'ROAS' },               { val:'↓38%',  label:'CPL Reduction' },    { val:'↑220%', label:'Click-Through Rate' }, { val:'12×',   label:'Revenue Growth' }],
      'rich-media':       [{ val:'↑380%', label:'Engagement Rate' },     { val:'98%',   label:'Viewability Score' }, { val:'3.5×',  label:'CTR vs Static' },     { val:'50M+',  label:'Impressions Served' }],
      'newsletter':       [{ val:'42%',   label:'Open Rate' },           { val:'↑290%', label:'Click Rate' },        { val:'8×',    label:'ROI' },                { val:'↓60%',  label:'Unsubscribe Rate' }],
      'digital-strategy': [{ val:'Full',  label:'Channel Audit' },       { val:'12mo',  label:'Roadmap' },           { val:'↑310%', label:'Qualified Leads' },   { val:'★5',    label:'Client Rating' }],
      'video-ads':        [{ val:'2M+',   label:'Organic Views' },       { val:'↑450%', label:'Brand Recall' },      { val:'↑180%', label:'Conversion Rate' },   { val:'35K',   label:'New Followers' }],
      'website':          [{ val:'↑270%', label:'Organic Traffic' },     { val:'↓45%',  label:'Bounce Rate' },       { val:'3.8×',  label:'Conversion Rate' },   { val:'★5',    label:'PageSpeed Score' }],
      'crm':              [{ val:'↓52%',  label:'Lead Response Time' },  { val:'↑190%', label:'Pipeline Value' },    { val:'100%',  label:'Data Migration' },    { val:'3mo',   label:'Full Rollout' }],
      'ai-apps':          [{ val:'↓70%',  label:'Manual Workload' },     { val:'24/7',  label:'Availability' },      { val:'↑400%', label:'Query Resolution' },  { val:'<1s',   label:'Response Time' }],
      'default':          [{ val:'87',    label:'Projects Done' },        { val:'8+',    label:'Years' },             { val:'★4',    label:'Awards' },             { val:'100%',  label:'Client Satisfaction' }],
    };

    const SCOPE_MAP = {
      'digital-ads':      ['Search Ads', 'Display Ads', 'Social Advertising', 'Programmatic', 'Remarketing', 'Analytics'],
      'rich-media':       ['HTML5 Banners', 'Interactive Units', 'Dynamic Creatives', 'Landing Pages', 'A/B Testing'],
      'newsletter':       ['Campaign Design', 'Copywriting', 'Automation Flows', 'Segmentation', 'A/B Testing', 'Reporting'],
      'digital-strategy': ['Market Research', 'Channel Planning', 'Content Calendar', 'KPI Framework', 'Quarterly Reviews'],
      'video-ads':        ['Video Production', 'TikTok & Reels', 'YouTube Pre-roll', 'Motion Graphics', 'Script Writing'],
      'website':          ['UI/UX Design', 'Web Development', 'CRO Strategy', 'SEO Foundation', 'Performance Optimisation'],
      'crm':              ['CRM Setup', 'Data Migration', 'Workflow Automation', 'Customer Segmentation', 'Dashboard'],
      'ai-apps':          ['AI Chatbot', 'LLM Integration', 'Automation Scripts', 'Data Pipelines', 'Custom AI Tools'],
      'default':          ['Strategy', 'Execution', 'Reporting'],
    };

    const FALLBACK_PROJECTS = [
      { id:1, title:'Kopi Nusantara — Search & Display Ads',   slug:'kopi-nusantara-digital-ads',  client:'Kopi Nusantara',  description:'Launched multi-channel search and display campaigns achieving 4.2× ROAS and 38% reduction in cost-per-lead within 3 months.', project_year:2024, category:{ name:'Digital Ads', slug:'digital-ads' }, images:[] },
      { id:2, title:'BeautyLab — HTML5 Rich Media Banners',    slug:'beautylab-rich-media',         client:'BeautyLab',        description:'Designed and developed a suite of interactive HTML5 ad units delivering 380% higher engagement vs. standard static banners.',  project_year:2024, category:{ name:'Rich Media', slug:'rich-media' }, images:[] },
      { id:3, title:'Lawson ID — Email Newsletter Campaign',   slug:'lawson-id-newsletter',         client:'Lawson Indonesia', description:'Built an automated newsletter system from scratch, achieving a 42% open rate and 8× ROI across 6 monthly campaigns.',           project_year:2023, category:{ name:'Newsletter', slug:'newsletter' }, images:[] },
      { id:4, title:'EduPath — Annual Digital Strategy',       slug:'edupath-digital-strategy',     client:'EduPath',          description:'Developed a full-year digital strategy roadmap across 5 channels, resulting in 310% growth in qualified inbound leads.',       project_year:2024, category:{ name:'Digital Strategy', slug:'digital-strategy' }, images:[] },
      { id:5, title:'Toko Sehat — TikTok & YouTube Video Ads', slug:'toko-sehat-video-ads',         client:'Toko Sehat',       description:'Produced 24 short-form video ads for TikTok and YouTube pre-roll, driving 2M+ views and 180% lift in conversion rate.',        project_year:2024, category:{ name:'Video Ads', slug:'video-ads' }, images:[] },
      { id:6, title:'Pondok Asri — Website Redesign',          slug:'pondok-asri-website',          client:'Pondok Asri',      description:'End-to-end website redesign focused on conversion — new site achieved 270% more organic traffic and 45% lower bounce rate.',   project_year:2023, category:{ name:'Website', slug:'website' }, images:[] },
      { id:7, title:'Matahari — CRM Setup & Automation',       slug:'matahari-crm',                 client:'Matahari',         description:'Migrated legacy data and built automated CRM workflows, cutting lead response time by 52% and increasing pipeline value by 190%.', project_year:2024, category:{ name:'CRM', slug:'crm' }, images:[] },
      { id:8, title:'GreenSpace — AI Customer Chatbot',        slug:'greenspace-ai-chatbot',        client:'GreenSpace ID',    description:'Built a custom LLM-powered chatbot handling 70% of customer queries autonomously, live 24/7 with under 1-second response time.', project_year:2025, category:{ name:'AI Apps', slug:'ai-apps' }, images:[] },
    ];

    let allProjects = [];


    // ── Preloader ─────────────────────────────────────────
    const countEl   = document.getElementById('preloader-count');
    const barEl     = document.getElementById('preloader-bar');
    const pctEl     = document.getElementById('preloader-pct');
    const preloader = document.getElementById('preloader');
    const counter   = { val: 100 };

    gsap.to(counter, {
      val: 0, duration: 1.6, ease: 'power2.inOut',
      onUpdate() {
        const v = Math.round(counter.val);
        countEl.textContent = String(v).padStart(3, '0');
        barEl.style.width   = (100 - v) + '%';
        if (pctEl) pctEl.textContent = (100 - v) + '%';
      },
      onComplete() {
        gsap.to(preloader, {
          yPercent: -105, duration: 0.9, ease: 'expo.inOut', delay: 0.18,
          onStart() { gsap.to(barEl, { width: '100%', duration: 0.1 }); },
          onComplete() {
            preloader.style.display = 'none';
            document.body.style.overflow = 'auto';
            renderProject();
          }
        });
      }
    });


    // ── Mobile nav ────────────────────────────────────────
    const burgerBtn = document.getElementById('burger-btn');
    const mobileNav = document.getElementById('mobile-nav');
    const closeNav  = document.getElementById('close-nav');
    const navOverlay = document.getElementById('nav-overlay');

    function openMenu() {
      mobileNav.classList.add('open');
      navOverlay.classList.remove('hidden');
      setTimeout(() => navOverlay.classList.add('opacity-100'), 10);
      burgerBtn.classList.add('burger-open');
      document.body.style.overflow = 'hidden';
    }
    function closeMenu() {
      mobileNav.classList.remove('open');
      navOverlay.classList.remove('opacity-100');
      setTimeout(() => navOverlay.classList.add('hidden'), 300);
      burgerBtn.classList.remove('burger-open');
      document.body.style.overflow = '';
    }
    burgerBtn.addEventListener('click', () => mobileNav.classList.contains('open') ? closeMenu() : openMenu());
    closeNav.addEventListener('click', closeMenu);
    navOverlay.addEventListener('click', closeMenu);


    // ── Fetch project ─────────────────────────────────────
    function fetchProject(cb) {
      // Fetch the specific project (includes images) and the full list (for next project)
      Promise.all([
        fetch('/api/projects/' + slug).then(r => { if (!r.ok) throw new Error('not_found'); return r.json(); }),
        fetch('/api/projects').then(r => { if (!r.ok) throw new Error(); return r.json(); }),
      ])
        .then(([project, all]) => {
          allProjects = all;
          cb(project, all);
        })
        .catch(err => {
          allProjects = FALLBACK_PROJECTS;
          const project = FALLBACK_PROJECTS.find(p => p.slug === slug);
          cb(project || null, FALLBACK_PROJECTS);
        });
    }


    // ── Render ────────────────────────────────────────────
    function renderProject() {
      gsap.registerPlugin(ScrollTrigger);

      fetchProject((project, all) => {
        if (!project) {
          document.getElementById('not-found').style.display = 'block';
          document.body.style.overflow = 'auto';
          return;
        }

        const catSlug  = project.category?.slug || 'default';
        const catName  = project.category?.name || '';
        const color    = CAT_COLORS[catSlug] || CAT_COLORS.default;
        /* prefer CMS-entered values, fall back to auto-generated */
        const metrics  = (project.custom_metrics && project.custom_metrics.length)
                           ? project.custom_metrics
                           : (METRICS_MAP[catSlug] || METRICS_MAP.default);
        const scope    = (project.custom_scope && project.custom_scope.length)
                           ? project.custom_scope
                           : (SCOPE_MAP[catSlug] || SCOPE_MAP.default);
        const num      = String(project.id).padStart(2, '0');

        // Page title
        document.title = project.title + ' — STORYTALE';
        document.getElementById('pre-category-label').textContent = catName;
        document.getElementById('pre-project-label').textContent  = project.client;

        // Hero
        document.getElementById('breadcrumb-title').textContent = project.client;
        document.getElementById('hero-title').textContent       = project.title;
        document.getElementById('hero-client').textContent      = project.client;
        document.getElementById('hero-service').textContent     = catName;
        document.getElementById('hero-year-bar').textContent    = project.project_year || '—';
        document.getElementById('hero-year').textContent        = project.project_year || '';

        const catTag = document.getElementById('hero-category-tag');
        catTag.textContent   = catName;
        catTag.style.background = color + '22';
        catTag.style.borderColor = color + '44';
        catTag.style.color   = color;

        document.getElementById('hero-ghost').textContent = project.client || '';
        document.getElementById('hero-cover-num').textContent = num;

        const coverInner = document.getElementById('hero-cover-inner');
        if (project.cover_image) {
          coverInner.style.background = '#0A0A0A';
          const img = document.createElement('img');
          img.src = project.cover_image;
          img.alt = project.title;
          img.className = 'absolute inset-0 w-full h-full object-cover';
          coverInner.appendChild(img);
        } else {
          coverInner.style.background = color;
        }

        // Description (supports HTML from Quill)
        document.getElementById('project-description').innerHTML = project.description || '';

        if (project.content) {
          document.getElementById('project-content').innerHTML = project.content;
          document.getElementById('project-content-wrap').classList.remove('hidden');
        }

        // Metrics
        const mgrid = document.getElementById('metrics-grid');
        const mcColors = ['#FF2D2D','#2255FF','#FF7A00','#00AA50'];
        metrics.forEach((m, i) => {
          const mc = document.createElement('div');
          mc.className = 'metric-card';
          mc.style.setProperty('--mc', mcColors[i % mcColors.length]);
          mc.innerHTML = `
            <span class="mc-val font-brutal text-[#FFE500] leading-none transition-colors duration-300" style="font-size: clamp(2rem,3.5vw,3rem);">${m.val}</span>
            <span class="mc-label font-body text-[9px] font-bold uppercase tracking-[0.3em] text-[#FFE500] opacity-40 transition-colors duration-300">${m.label}</span>`;
          mgrid.appendChild(mc);
        });

        // Scope tags
        const scopeWrap = document.getElementById('scope-tags');
        scope.forEach(tag => {
          const el = document.createElement('span');
          el.className = 'font-body text-[10px] font-bold uppercase tracking-[0.2em] text-[#0A0A0A] border-2 border-[#0A0A0A] px-3 py-1';
          el.textContent = tag;
          scopeWrap.appendChild(el);
        });

        // Embed code — supports multiple iframes (split by newline)
        if (project.embed_code) {
          const embedWrap = document.getElementById('embed-wrap');
          if (embedWrap) {
            const embeds = project.embed_code.trim().split(/\n+/).filter(Boolean);
            embeds.forEach(code => {
              const div = document.createElement('div');
              div.innerHTML = code;
              div.querySelectorAll('iframe').forEach(f => {
                f.style.width = '100%';
                if (!f.style.height && !f.getAttribute('height')) f.style.height = '480px';
              });
              embedWrap.appendChild(div);
            });
            embedWrap.classList.remove('hidden');
          }
        }

        // Image gallery
        buildGallery(project.images || [], color, num);

        // Next project
        buildNextProject(all, project.slug, color);

        // Reveal page
        const wrap = document.getElementById('project-wrap');
        gsap.to(wrap, { opacity: 1, duration: 0.6, ease: 'power2.out' });

        // Scroll animations
        gsap.from('#project-hero .font-brutal', {
          y: 40, opacity: 0, duration: 0.8, ease: 'power3.out', delay: 0.1,
        });
        gsap.from('#project-description', {
          y: 30, opacity: 0, duration: 0.75, ease: 'power3.out',
          scrollTrigger: { trigger: '#project-description', start: 'top 82%', once: true }
        });
        gsap.from('.metric-card', {
          y: 40, opacity: 0, stagger: 0.08, duration: 0.6, ease: 'power3.out',
          scrollTrigger: { trigger: '#metrics-grid', start: 'top 85%', once: true }
        });
        gsap.from('.img-gallery-item', {
          y: 50, opacity: 0, stagger: 0.08, duration: 0.7, ease: 'power3.out',
          scrollTrigger: { trigger: '#gallery-section', start: 'top 80%', once: true }
        });
      });
    }


    // ── Build image gallery ───────────────────────────────
    function buildGallery(images, color, num) {
      const gallery = document.getElementById('img-gallery');

      if (images && images.length) {
        document.getElementById('img-count').textContent = String(images.length).padStart(2, '0');
        images.forEach((img, i) => {
          const item = document.createElement('div');
          item.className = 'img-gallery-item' + (i === 0 ? ' wide' : '');
          const el = document.createElement('img');
          el.src = img.image_url;
          el.alt = img.alt_text || '';
          item.appendChild(el);
          gallery.appendChild(item);
        });
        return;
      }

      // Placeholder blocks when no images exist
      const placeholders = [
        { wide: true,  label: 'Hero Shot' },
        { wide: false, label: 'Detail 01' },
        { wide: false, label: 'Detail 02' },
        { wide: false, label: 'Detail 03' },
        { wide: false, label: 'Detail 04' },
      ];

      document.getElementById('img-count').textContent = String(placeholders.length).padStart(2, '0');

      const shades = [color, '#222', '#1a1a1a', '#333', '#0f0f0f'];

      placeholders.forEach((p, i) => {
        const item = document.createElement('div');
        item.className = 'img-gallery-item' + (p.wide ? ' wide' : '');
        item.style.background = shades[i % shades.length];
        item.innerHTML = `
          <div class="absolute inset-0 flex flex-col items-center justify-center gap-3 select-none pointer-events-none">
            <span style="font-family:'Bebas Neue',sans-serif; color:rgba(255,229,0,0.06); font-size: clamp(5rem, 12vw, 14rem); line-height:1;">${num}</span>
            <span style="font-family:'Space Grotesk',sans-serif; font-size:0.6rem; font-weight:700; text-transform:uppercase; letter-spacing:0.35em; color:rgba(255,229,0,0.18);">${p.label}</span>
          </div>`;
        gallery.appendChild(item);
      });
    }


    // ── Build next project ────────────────────────────────
    function buildNextProject(all, currentSlug, currentColor) {
      const idx  = all.findIndex(p => p.slug === currentSlug);
      const next = all[(idx + 1) % all.length];
      if (!next || next.slug === currentSlug) return;

      const nextColor = CAT_COLORS[next.category?.slug] || CAT_COLORS.default;
      const nextNum   = String(next.id).padStart(2, '0');

      document.getElementById('next-project-link').href = '/work/' + next.slug;
      document.getElementById('next-project-bg').style.background = nextColor;
      document.getElementById('next-project-num').textContent  = nextNum;
      document.getElementById('next-category').textContent = next.category?.name || '';
      document.getElementById('next-title').textContent    = next.title;
      document.getElementById('next-client').textContent   = next.client;

      document.getElementById('next-section').classList.remove('hidden');
    }

  })();
  </script>

<script>
fetch("/api/settings").then(r=>r.json()).then(cfg=>{const wa=(cfg.contact||{}).whatsapp;if(wa){const u="https://wa.me/"+wa.replace(/\D/g,"");const el=document.getElementById("navbar-wa-link");if(el)el.href=u;}}).catch(()=>{});
</script>
</body>
</html>
