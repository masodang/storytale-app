<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Journal — STORYTALE</title>

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

    /* CTA band */
    .cta-band {
      background: #0A0A0A;
      border-top: 4px solid #0A0A0A;
      border-bottom: 4px solid #0A0A0A;
    }

    /* Journal card */
    .journal-card {
      background: #0A0A0A;
      border: 2px solid #0A0A0A;
      cursor: pointer;
      transition: box-shadow 0.15s ease, transform 0.15s ease;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }
    .journal-card:hover {
      box-shadow: 8px 8px 0 #0A0A0A;
      transform: translate(-2px, -2px);
    }

    .journal-card-cover {
      width: 100%;
      aspect-ratio: 16/9;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative;
      flex-shrink: 0;
    }

    .journal-card-cover img {
      position: absolute; inset: 0;
      width: 100%; height: 100%;
      object-fit: cover;
    }

    .journal-card-body {
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      flex: 1;
    }

    .journal-cat-badge {
      display: inline-block;
      font-family: 'Space Grotesk', sans-serif;
      font-size: 0.55rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.3em;
      padding: 3px 10px;
      border: 1px solid;
    }

    .journal-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: clamp(1rem, 1.8vw, 1.4rem);
      letter-spacing: 0.04em;
      line-height: 1.15;
      color: #FFE500;
    }

    .journal-excerpt {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 0.75rem;
      color: rgba(255,229,0,0.45);
      line-height: 1.6;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .journal-date {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 0.6rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.25em;
      color: rgba(255,229,0,0.25);
      margin-top: auto;
      padding-top: 10px;
      border-top: 1px solid rgba(255,229,0,0.08);
    }

    /* ── FLIPBOOK MODAL ───────────────────── */
    #flipbook-modal {
      position: fixed; inset: 0;
      z-index: 20000;
      background: rgba(0,0,0,0.95);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
      opacity: 0;
      pointer-events: none;
    }
    #flipbook-modal.is-open { pointer-events: auto; }

    #flipbook-container {
      background: #0A0A0A;
      border: 2px solid rgba(255,229,0,0.2);
      width: 100%;
      max-width: 900px;
      max-height: 95vh;
      display: flex;
      flex-direction: column;
      overflow: hidden;
      transform: scale(0.95);
    }

    #flipbook-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 14px 20px;
      border-bottom: 1px solid rgba(255,229,0,0.1);
      flex-shrink: 0;
      gap: 12px;
      background: #111;
    }

    /* ── PDF Reader ──────────────────────── */
    #pdfbook-wrap {
      flex: 1;
      overflow: hidden;
      position: relative;
      min-height: 0;
      background: #1a1a1a;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    #pdfbook-stage {
      position: relative;
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    /* Book spread — two pages side by side on wide, single on mobile */
    #pdfbook-spread {
      display: flex;
      align-items: stretch;
      justify-content: center;
      gap: 2px;
      height: 100%;
      width: 100%;
      padding: 1rem;
    }

    .pdfbook-page-slot {
      flex: 1;
      max-width: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    .pdfbook-page-slot canvas {
      max-width: 100%;
      max-height: 100%;
      box-shadow: 0 8px 40px rgba(0,0,0,0.6);
      display: block;
    }

    /* Page flip animation */
    @keyframes flipRight {
      0%   { transform: rotateY(0deg);   opacity: 1; }
      50%  { transform: rotateY(-90deg); opacity: 0; }
      100% { transform: rotateY(0deg);   opacity: 1; }
    }
    @keyframes flipLeft {
      0%   { transform: rotateY(0deg);  opacity: 1; }
      50%  { transform: rotateY(90deg); opacity: 0; }
      100% { transform: rotateY(0deg);  opacity: 1; }
    }
    .flip-anim-right { animation: flipRight 0.4s ease-in-out; }
    .flip-anim-left  { animation: flipLeft  0.4s ease-in-out; }

    #pdfbook-loading {
      position: absolute; inset: 0;
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      gap: 16px; background: #1a1a1a;
    }
    #pdfbook-loading .spinner {
      width: 36px; height: 36px;
      border: 3px solid rgba(255,229,0,0.15);
      border-top-color: #FFE500;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    #pdfbook-controls {
      flex-shrink: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 16px;
      padding: 12px 20px;
      border-top: 1px solid rgba(255,229,0,0.1);
      background: #111;
    }

    .pdfbook-btn {
      width: 40px; height: 40px;
      border: 2px solid rgba(255,229,0,0.2);
      background: transparent;
      color: #FFE500;
      font-size: 1.1rem;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      transition: background .15s, border-color .15s;
    }
    .pdfbook-btn:hover:not(:disabled) { background: #FFE500; color: #0A0A0A; border-color: #FFE500; }
    .pdfbook-btn:disabled { opacity: 0.2; cursor: default; }

    #pdfbook-pageinfo {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 0.7rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.2em;
      color: rgba(255,229,0,0.5);
      min-width: 100px;
      text-align: center;
    }

    #flipbook-no-pdf {
      display: none;
      flex: 1;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      gap: 16px;
      padding: 4rem 2rem;
    }

    @media (max-width: 600px) {
      .pdfbook-page-slot { max-width: 100%; }
      .pdfbook-page-slot:last-child { display: none; }
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
      <span style="font-family:'Space Grotesk',sans-serif; color:#FFE500; font-size:0.6rem; opacity:0.3; letter-spacing:0.35em; text-transform:uppercase;">Journal</span>
    </div>

    <div class="pre-inner" style="flex:1; display:flex; flex-direction:column; justify-content:center; padding: 0 2.5rem;">
      <div style="font-family:'Space Grotesk',sans-serif; color:rgba(255,229,0,0.35); font-size:0.6rem; letter-spacing:0.5em; text-transform:uppercase; margin-bottom:0.75rem;">Loading</div>
      <div id="preloader-count">100</div>
      <div style="font-family:'Space Grotesk',sans-serif; color:rgba(255,229,0,0.2); font-size:0.65rem; letter-spacing:0.3em; text-transform:uppercase; margin-top:1.5rem;">Case Studies, Insights & Whitepapers</div>
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

    <!-- Decorative ghost text -->
    <div class="absolute right-6 lg:right-16 bottom-0 font-brutal text-[#0A0A0A] opacity-[0.04] leading-none select-none pointer-events-none"
      style="font-size: clamp(10rem, 28vw, 30rem); line-height: 0.8;">
      JOURNAL
    </div>

    <div id="hero-content" class="relative z-10 max-w-[1440px] mx-auto px-6 lg:px-12 py-16 lg:py-20" style="opacity:0;">

      <!-- Breadcrumb -->
      <div class="flex items-center gap-3 mb-6">
        <a href="/" class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-40 hover:opacity-70 no-underline transition-opacity">Home</a>
        <span class="font-body text-xs text-[#0A0A0A] opacity-30">/</span>
        <span class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A]">Journal</span>
      </div>

      <!-- Heading row -->
      <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 border-b-4 border-[#0A0A0A] pb-10">
        <div>
          <span class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-40">§ Knowledge & Insights</span>
          <h1 class="font-brutal text-[clamp(4rem,10vw,12rem)] uppercase text-[#0A0A0A] leading-none tracking-tight mt-1">
            Journal
          </h1>
        </div>

        <div class="lg:max-w-sm lg:pb-4">
          <p class="font-body text-base text-[#0A0A0A] opacity-60 leading-relaxed font-medium">
            Case studies, learning notes, insights and whitepapers from the STORYTALE team.
          </p>
        </div>
      </div>
    </div>
  </section>


  <!-- ═══════════════════════════════════
       JOURNAL GRID
  ═══════════════════════════════════ -->
  <section id="journal-section" class="bg-[#FFE500] border-b-4 border-[#0A0A0A] pt-12 pb-28">

    <!-- Filter + count row -->
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12 mb-8">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

        <!-- Filter buttons -->
        <div id="journal-filters" class="flex flex-wrap gap-2">
          <button class="filter-btn active" data-filter="all">All</button>
          <button class="filter-btn" data-filter="case-study">Case Study</button>
          <button class="filter-btn" data-filter="learning">Learning</button>
          <button class="filter-btn" data-filter="insight">Insight</button>
          <button class="filter-btn" data-filter="whitepaper">Whitepaper</button>
          <button class="filter-btn" data-filter="report">Report</button>
        </div>

        <!-- Count -->
        <div class="flex items-baseline gap-2">
          <span id="journal-count" class="font-brutal text-[#0A0A0A] text-5xl leading-none opacity-20">—</span>
          <span class="font-body text-[10px] font-bold uppercase tracking-widest text-[#0A0A0A] opacity-40">Articles</span>
        </div>
      </div>
    </div>

    <!-- Card grid -->
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
      <div id="journal-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div id="journal-loading" style="grid-column:1/-1; display:flex; align-items:center; justify-content:center; padding:5rem 0;">
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
              class="inline-block bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-sm uppercase tracking-widest px-8 py-4 border-2 border-[#FFE500] hover:translate-x-[3px] hover:translate-y-[3px] transition-all duration-150 no-underline"
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
       HIGHLIGHT OUR WORK
  ═══════════════════════════════════ -->
  <style>
    .wt { position:relative; display:block; overflow:hidden; text-decoration:none; aspect-ratio:4/3; border:2px solid rgba(255,229,0,0.12); }
    .wt-img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; transition:transform 0.55s cubic-bezier(.25,.46,.45,.94), filter 0.55s ease; filter:brightness(0.88); }
    .wt-placeholder { position:absolute; inset:0; background:#111; display:flex; align-items:center; justify-content:center; }
    .wt-overlay { position:absolute; inset:0; background:rgba(10,10,10,0); transition:background 0.4s ease; }
    .wt-content { position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:24px; text-align:center; opacity:0; transform:translateY(16px); transition:opacity 0.35s ease, transform 0.35s ease; }
    .wt-tag { font-family:'Space Grotesk',sans-serif; font-size:0.55rem; font-weight:700; text-transform:uppercase; letter-spacing:0.35em; color:#FFE500; opacity:0.6; margin-bottom:10px; }
    .wt-title { font-family:'Bebas Neue',sans-serif; font-size:clamp(1.4rem,2.5vw,2.2rem); color:#FFE500; letter-spacing:0.05em; line-height:1.1; }
    .wt-client { font-family:'Space Grotesk',sans-serif; font-size:0.58rem; font-weight:700; text-transform:uppercase; letter-spacing:0.25em; color:rgba(255,229,0,0.45); margin-top:8px; }
    .wt-cta { margin-top:16px; font-family:'Space Grotesk',sans-serif; font-size:0.6rem; font-weight:700; text-transform:uppercase; letter-spacing:0.25em; color:#0A0A0A; background:#FFE500; padding:6px 16px; }
    .wt-baseline { position:absolute; bottom:0; left:0; right:0; padding:14px 16px; background:linear-gradient(to top,rgba(10,10,10,0.9) 0%,transparent 100%); transition:opacity 0.3s ease; }
    .wt-baseline-title { font-family:'Bebas Neue',sans-serif; font-size:clamp(1rem,1.8vw,1.4rem); color:#FFE500; letter-spacing:0.04em; line-height:1.15; }

    .wt:hover .wt-img { transform:scale(1.07); filter:brightness(0.35); }
    .wt:hover .wt-overlay { background:rgba(10,10,10,0.65); }
    .wt:hover .wt-content { opacity:1; transform:translateY(0); }
    .wt:hover .wt-baseline { opacity:0; }
    .wt:hover { border-color:#FFE500; box-shadow:6px 6px 0 #FFE500; }
  </style>

  <section id="highlight-work" class="bg-[#0A0A0A] border-b-4 border-[#0A0A0A] py-20 lg:py-28">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">

      <!-- Header -->
      <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 border-b-4 border-[rgba(255,229,0,0.15)] pb-10 mb-12">
        <div>
          <span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-40">§ Selected Projects</span>
          <h2 class="font-brutal text-[clamp(3rem,7vw,8rem)] uppercase text-[#FFE500] leading-none tracking-tight mt-1">
            Our Work
          </h2>
        </div>
        <a href="/work" class="inline-block bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-sm uppercase tracking-widest px-6 py-3 border-2 border-[#FFE500] hover:translate-x-[2px] hover:translate-y-[2px] transition-all duration-150 no-underline self-end" style="box-shadow:4px 4px 0 rgba(255,229,0,0.2);">
          View All Work →
        </a>
      </div>

      <!-- 3 Thumbnails -->
      <div id="highlight-grid" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div style="grid-column:1/-1;display:flex;align-items:center;justify-content:center;padding:4rem 0;">
          <span class="font-brutal text-[#FFE500] text-3xl tracking-widest opacity-20">Loading...</span>
        </div>
      </div>

    </div>
  </section>


  <!-- ═══════════════════════════════════
       FOOTER
  ═══════════════════════════════════ -->
  @include('partials.footer')


  <!-- Modal removed — PDF opens in new tab on card click -->
  <div id="flipbook-modal" style="display:none;" aria-hidden="true">
    <div id="flipbook-container">
      <div id="flipbook-header">
        <div>
          <span id="flipbook-cat-badge"></span>
          <span id="flipbook-title"></span>
        </div>
        <button id="flipbook-close"
          class="flex-shrink-0 w-10 h-10 border-2 border-[rgba(255,229,0,0.3)] flex items-center justify-center text-[#FFE500] text-lg font-bold hover:bg-[#FFE500] hover:text-[#0A0A0A] transition-colors"
          aria-label="Close viewer">✕</button>
      </div>

      <!-- PDF Flipbook reader -->
      <div id="pdfbook-wrap" style="height: 68vh;">
        <div id="pdfbook-stage">
          <!-- Loading spinner -->
          <div id="pdfbook-loading">
            <div class="spinner"></div>
            <span class="font-body text-[10px] font-bold uppercase tracking-widest text-[#FFE500] opacity-30">Loading PDF…</span>
          </div>
          <!-- Book spread -->
          <div id="pdfbook-spread" style="display:none;">
            <div class="pdfbook-page-slot" id="slot-left">
              <canvas id="canvas-left"></canvas>
            </div>
            <div class="pdfbook-page-slot" id="slot-right">
              <canvas id="canvas-right"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- Page controls -->
      <div id="pdfbook-controls" style="display:none;">
        <button id="pdfbook-first" class="pdfbook-btn" title="First page">⟨⟨</button>
        <button id="pdfbook-prev"  class="pdfbook-btn" title="Previous spread">←</button>
        <span id="pdfbook-pageinfo">—</span>
        <button id="pdfbook-next"  class="pdfbook-btn" title="Next spread">→</button>
        <button id="pdfbook-last"  class="pdfbook-btn" title="Last page">⟩⟩</button>
      </div>

      <!-- No PDF placeholder -->
      <div id="flipbook-no-pdf">
        <div class="w-20 h-20 border-2 border-[rgba(255,229,0,0.15)] flex items-center justify-center">
          <span class="font-brutal text-[#FFE500] text-4xl opacity-30">PDF</span>
        </div>
        <p class="font-body text-sm text-[#FFE500] opacity-30 uppercase tracking-widest text-center">No PDF available for this entry.</p>
      </div>

    </div>

  </div>


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

      initJournal();
    }


    // ── Mobile nav ─────────────────────────────────────────
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

    burgerBtn.addEventListener('click', () =>
      mobileNav.classList.contains('open') ? closeMenu() : openMenu()
    );
    closeNav.addEventListener('click', closeMenu);
    navOverlay.addEventListener('click', closeMenu);


    // ── Journal data ───────────────────────────────────────
    const CAT_COLORS = {
      'case-study':  { bg: '#FF2D2D',  text: '#FFFFFF' },
      'learning':    { bg: '#2255FF',  text: '#FFFFFF' },
      'insight':     { bg: '#00AA50',  text: '#FFFFFF' },
      'whitepaper':  { bg: '#FF7A00',  text: '#FFFFFF' },
      'report':      { bg: '#9900DD',  text: '#FFFFFF' },
      'default':     { bg: '#0A0A0A',  text: '#FFE500'  },
    };

    const CAT_LABELS = {
      'case-study': 'Case Study',
      'learning':   'Learning',
      'insight':    'Insight',
      'whitepaper': 'Whitepaper',
      'report':     'Report',
    };

    const FALLBACK = [
      {
        id: 1,
        title: 'How We Grew Kopi Nusantara\'s ROAS by 3.4× in 90 Days',
        category_slug: 'case-study',
        excerpt: 'A deep-dive into the paid media strategy and creative testing methodology that transformed a regional coffee brand\'s digital performance.',
        date: '2025-03-10',
        cover_image: null,
        pdf_url: null,
      },
      {
        id: 2,
        title: 'The Brutalist Approach to Content Strategy',
        category_slug: 'learning',
        excerpt: 'Why we stopped obsessing over aesthetics and started obsessing over conversion — and what changed when we did.',
        date: '2025-02-14',
        cover_image: null,
        pdf_url: null,
      },
      {
        id: 3,
        title: 'Indonesia\'s Social Media Landscape 2025',
        category_slug: 'insight',
        excerpt: 'Platform-by-platform analysis of where Indonesian consumers are spending attention, and what that means for brand strategy this year.',
        date: '2025-01-20',
        cover_image: null,
        pdf_url: null,
      },
      {
        id: 4,
        title: 'The Complete Guide to Performance Creative',
        category_slug: 'whitepaper',
        excerpt: 'A 42-page framework covering ad creative testing, iteration cycles, and production workflows for brands spending IDR 500M+ per month.',
        date: '2024-12-05',
        cover_image: null,
        pdf_url: null,
      },
      {
        id: 5,
        title: 'Q4 2024 Digital Advertising Benchmark Report',
        category_slug: 'report',
        excerpt: 'Aggregated performance benchmarks across Meta, Google, and TikTok for Indonesian B2C brands — CPM, CTR, CVR, and ROAS by vertical.',
        date: '2025-01-08',
        cover_image: null,
        pdf_url: null,
      },
      {
        id: 6,
        title: 'Building an AI-Powered Content Engine Without Losing Your Voice',
        category_slug: 'learning',
        excerpt: 'How STORYTALE uses large language models, retrieval-augmented generation, and human editorial layers to scale content without sounding robotic.',
        date: '2025-04-02',
        cover_image: null,
        pdf_url: null,
      },
    ];

    let allArticles = [];


    // ── Build card ────────────────────────────────────────
    function buildCard(article) {
      const slug   = article.category_slug || 'default';
      const color  = CAT_COLORS[slug]  || CAT_COLORS.default;
      const label  = CAT_LABELS[slug]  || slug;
      const hasCover = article.cover_image && article.cover_image.trim();

      const card = document.createElement('div');
      card.className = 'journal-card';
      card.style.opacity = '0';
      card.style.transform = 'translateY(24px)';
      card.dataset.category = slug;
      card.setAttribute('role', 'button');
      card.setAttribute('tabindex', '0');

      const coverHtml = hasCover
        ? `<img src="${article.cover_image}" alt="${article.title}" loading="lazy" />`
        : `
          <div style="position:absolute;inset:0;background:${color.bg};"></div>
          <div style="position:absolute;inset:0;background-image:repeating-linear-gradient(-45deg,transparent,transparent 12px,rgba(0,0,0,0.06) 12px,rgba(0,0,0,0.06) 13px);pointer-events:none;"></div>
          <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none;">
            <span style="font-family:'Bebas Neue',sans-serif;font-size:clamp(3rem,6vw,6rem);color:rgba(0,0,0,0.12);letter-spacing:0.04em;">${label.toUpperCase()}</span>
          </div>
          <div style="position:absolute;top:12px;left:12px;width:16px;height:16px;border-top:2px solid rgba(0,0,0,0.15);border-left:2px solid rgba(0,0,0,0.15);pointer-events:none;"></div>
          <div style="position:absolute;top:12px;right:12px;width:16px;height:16px;border-top:2px solid rgba(0,0,0,0.15);border-right:2px solid rgba(0,0,0,0.15);pointer-events:none;"></div>
        `;

      const dateStr = article.date
        ? new Date(article.date).toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric' })
        : '';

      card.innerHTML = `
        <div class="journal-card-cover">${coverHtml}</div>
        <div class="journal-card-body">
          <span class="journal-cat-badge" style="color:${color.text};background:${color.bg};border-color:${color.bg};">${label}</span>
          <div class="journal-title">${article.title}</div>
          <p class="journal-excerpt">${article.excerpt || ''}</p>
          <div style="display:flex;align-items:center;justify-content:space-between;margin-top:auto;padding-top:12px;">
            <div class="journal-date">${dateStr}</div>
            ${article.pdf_url ? `<span style="font-family:'Space Grotesk',sans-serif;font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.2em;color:rgba(10,10,10,0.4);display:flex;align-items:center;gap:4px;">Read PDF ↗</span>` : ''}
          </div>
        </div>
      `;

      card.addEventListener('click', () => {
        if (article.pdf_url && article.pdf_url.trim()) {
          window.open(article.pdf_url, '_blank', 'noopener');
        }
      });
      card.addEventListener('keydown', e => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          if (article.pdf_url && article.pdf_url.trim()) window.open(article.pdf_url, '_blank', 'noopener');
        }
      });
      // Visual cue: show pointer only when PDF exists
      if (!article.pdf_url) card.style.cursor = 'default';

      return card;
    }


    // ── Render grid ───────────────────────────────────────
    function renderJournal(articles) {
      const grid = document.getElementById('journal-grid');
      grid.innerHTML = '';

      if (!articles.length) {
        grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:5rem 0; font-family:\'Bebas Neue\',sans-serif; color:#0A0A0A; opacity:0.25; font-size:2rem; letter-spacing:0.2em;">No articles found</div>';
        return;
      }

      articles.forEach(a => grid.appendChild(buildCard(a)));

      gsap.to('.journal-card', {
        opacity: 1,
        y: 0,
        duration: 0.5,
        stagger: 0.07,
        ease: 'power2.out',
        scrollTrigger: { trigger: '#journal-section', start: 'top 88%', once: true }
      });
    }

    function updateCount(n) {
      const el = document.getElementById('journal-count');
      if (el) el.textContent = String(n).padStart(2, '0');
    }

    function initJournal() {
      fetch('/api/journals')
        .then(r => { if (!r.ok) throw new Error(); return r.json(); })
        .then(data => { allArticles = data; updateCount(data.length); renderJournal(data); })
        .catch(() => { allArticles = FALLBACK; updateCount(FALLBACK.length); renderJournal(FALLBACK); });
    }

    document.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const f = btn.dataset.filter;
        const filtered = f === 'all' ? allArticles : allArticles.filter(a => a.category_slug === f);
        updateCount(filtered.length);
        renderJournal(filtered);
      });
    });


    // PDF opens in new tab — no modal needed


    // ── Highlight Our Work ────────────────────────────────
    function initHighlightWork() {
      fetch('/api/projects?featured=true')
        .then(r => { if (!r.ok) throw new Error(); return r.json(); })
        .then(data => renderHighlight(data.slice(0, 3)))
        .catch(() => {
          fetch('/api/projects')
            .then(r => r.json())
            .then(data => renderHighlight(data.slice(0, 3)))
            .catch(() => renderHighlight([]));
        });
    }

    function renderHighlight(projects) {
      const grid = document.getElementById('highlight-grid');
      if (!projects.length) {
        grid.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:4rem 0;font-family:\'Bebas Neue\',sans-serif;color:#FFE500;opacity:0.2;font-size:2rem;letter-spacing:0.2em;">No projects yet</div>';
        return;
      }

      grid.innerHTML = '';
      projects.forEach(p => {
        const card = document.createElement('a');
        card.href = '/work';
        card.className = 'wt';
        card.style.opacity = '0';
        card.style.transform = 'translateY(24px)';

        const hasCover = p.cover_image && p.cover_image.trim();
        const imgHtml = hasCover
          ? `<img src="${p.cover_image}" alt="${p.title}" loading="lazy" class="wt-img"/>`
          : `<div class="wt-placeholder"><span style="font-family:'Bebas Neue',sans-serif;font-size:clamp(2rem,4vw,4rem);color:rgba(255,229,0,0.06);">${(p.category_name||'Work').toUpperCase()}</span></div>`;

        card.innerHTML = `
          ${imgHtml}
          <div class="wt-overlay"></div>
          <div class="wt-content">
            ${p.category_name ? `<div class="wt-tag">${p.category_name}</div>` : ''}
            <div class="wt-title">${p.title}</div>
            ${p.client ? `<div class="wt-client">${p.client}</div>` : ''}
            <div class="wt-cta">View Project →</div>
          </div>
          <div class="wt-baseline">
            <div class="wt-baseline-title">${p.title}</div>
          </div>
        `;

        grid.appendChild(card);
      });

      gsap.to('#highlight-grid a', {
        opacity: 1, y: 0, duration: 0.5, stagger: 0.1, ease: 'power2.out',
        scrollTrigger: { trigger: '#highlight-work', start: 'top 85%', once: true }
      });
    }

    initHighlightWork();

  })();
  </script>

<script>
fetch("/api/settings").then(r=>r.json()).then(cfg=>{const wa=(cfg.contact||{}).whatsapp;if(wa){const u="https://wa.me/"+wa.replace(/\D/g,"");const el=document.getElementById("navbar-wa-link");if(el)el.href=u;}}).catch(()=>{});
</script>
</body>
</html>
