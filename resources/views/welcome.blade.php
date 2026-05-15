<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>STORYTALE — Stories That Sell</title>

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

    /* Noise texture — above everything except preloader */
    body::before {
      content: '';
      position: fixed; inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
      pointer-events: none;
      z-index: 9999;
    }

    /* Scrollbar */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #FFE500; }
    ::-webkit-scrollbar-thumb { background: #0A0A0A; }

    /* Burger lines */
    .burger-line {
      display: block; width: 28px; height: 3px;
      background: #0A0A0A;
      transition: all 0.25s ease;
      transform-origin: center;
    }
    .burger-open .burger-line:nth-child(1) { transform: translateY(9px) rotate(45deg); }
    .burger-open .burger-line:nth-child(2) { opacity: 0; transform: scaleX(0); }
    .burger-open .burger-line:nth-child(3) { transform: translateY(-9px) rotate(-45deg); }

    /* Marquee */
    @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
    .marquee-track { animation: marquee 14s linear infinite; }

    /* Glitch on headline */
    @keyframes glitch {
      0%, 93%, 100% { clip-path: none; transform: none; }
      94% { clip-path: inset(20% 0 50% 0); transform: translateX(-4px); }
      95% { clip-path: inset(60% 0 10% 0); transform: translateX(4px); }
      96% { clip-path: inset(30% 0 40% 0); transform: translateX(-2px); }
    }
    .glitch { animation: glitch 6s infinite; }

    /* Mobile nav */
    #mobile-nav {
      transform: translateX(100%);
      transition: transform 0.3s cubic-bezier(0.77, 0, 0.175, 1);
    }
    #mobile-nav.open { transform: translateX(0); }

    /* Nav hover underline */
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

    /* ── PRELOADER ─────────────────────────── */
    #preloader {
      position: fixed; inset: 0;
      z-index: 10000;
      background: #0A0A0A;
      display: flex; flex-direction: column;
      overflow: hidden;
    }

    /* Preloader noise (separate because body::before is z-9999) */
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

    /* Horizontal scan line inside preloader */
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

    /* Scroll line animation */
    @keyframes scrollLine {
      0%   { transform: scaleY(0); transform-origin: top; opacity: 1; }
      50%  { transform: scaleY(1); transform-origin: top; opacity: 1; }
      51%  { transform: scaleY(1); transform-origin: bottom; opacity: 1; }
      100% { transform: scaleY(0); transform-origin: bottom; opacity: 0.3; }
    }
    .scroll-line { animation: scrollLine 1.8s ease-in-out infinite; }

    @keyframes scrollBounce {
      0%, 100% { transform: translateY(0); opacity: 0.5; }
      50%       { transform: translateY(4px); opacity: 1; }
    }
    .scroll-label { animation: scrollBounce 1.8s ease-in-out infinite; }

    /* Hero bottom marquee */
    @keyframes marqueeRev { 0% { transform: translateX(-50%); } 100% { transform: translateX(0); } }
    .marquee-rev { animation: marqueeRev 18s linear infinite; }

    /* Preloader decorative corner bracket */
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

    /* ── SERVICES ──────────────────────────── */
    .service-card {
      position: relative;
      overflow: hidden;
      background: #0A0A0A;
      padding: 2.5rem 2rem 2rem;
      border: 2px solid #111;
      min-height: 380px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      cursor: pointer;
    }
    /* color flood fills from top on hover */
    .service-card::before {
      content: '';
      position: absolute;
      inset: 0;
      background: var(--sc);
      transform: translateY(-101%);
      transition: transform 0.48s cubic-bezier(0.77, 0, 0.175, 1);
      z-index: 0;
    }
    .service-card:hover::before { transform: translateY(0); }
    .service-card > * { position: relative; z-index: 1; }

    .sc-bar {
      width: 40px; height: 4px;
      background: var(--sc);
      margin-bottom: 1.75rem;
      transition: width 0.3s ease, background 0.3s ease;
    }
    .service-card:hover .sc-bar { width: 64px; background: rgba(0,0,0,0.25); }

    .sc-num {
      position: absolute;
      top: 1.25rem; right: 1.5rem;
      font-family: 'Bebas Neue', sans-serif;
      font-size: clamp(5rem, 8vw, 9rem);
      line-height: 1;
      color: rgba(255,229,0,0.05);
      pointer-events: none;
      transition: color 0.3s ease;
    }
    .service-card:hover .sc-num { color: rgba(0,0,0,0.08); }

    .sc-name {
      font-family: 'Bebas Neue', sans-serif;
      font-size: clamp(2.2rem, 3.2vw, 3.4rem);
      letter-spacing: 0.04em;
      line-height: 0.92;
      color: #FFE500;
      transition: color 0.3s ease;
    }
    .service-card:hover .sc-name { color: #0A0A0A; }

    .sc-desc {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 0.82rem;
      line-height: 1.65;
      color: rgba(255,229,0,0.45);
      margin-top: 0.75rem;
      transition: color 0.3s ease;
    }
    .service-card:hover .sc-desc { color: rgba(0,0,0,0.65); }

    .sc-list {
      list-style: none;
      margin-top: 1.5rem;
      display: flex;
      flex-direction: column;
      gap: 0.45rem;
    }
    .sc-list li {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 0.65rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.18em;
      color: rgba(255,229,0,0.3);
      display: flex;
      align-items: center;
      gap: 0.6rem;
      transition: color 0.3s ease;
    }
    .sc-list li::before {
      content: '';
      width: 18px; height: 2px;
      background: currentColor;
      flex-shrink: 0;
    }
    .service-card:hover .sc-list li { color: rgba(0,0,0,0.45); }

    .sc-cta {
      margin-top: 2rem;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      font-family: 'Space Grotesk', sans-serif;
      font-size: 0.7rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.2em;
      color: #FFE500;
      border: 2px solid rgba(255,229,0,0.2);
      padding: 8px 18px;
      text-decoration: none;
      width: fit-content;
      transition: color 0.3s ease, border-color 0.3s ease, background 0.3s ease;
    }
    .service-card:hover .sc-cta {
      color: #0A0A0A;
      border-color: rgba(0,0,0,0.3);
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
  </style>
</head>
<body>

  <!-- ═══════════════════════════════════
       PRELOADER
  ═══════════════════════════════════ -->
  <div id="preloader">
    <!-- Scan line -->
    <div id="preloader-scan"></div>

    <!-- Corner brackets -->
    <div class="pre-bracket pre-bracket-tl"></div>
    <div class="pre-bracket pre-bracket-tr"></div>
    <div class="pre-bracket pre-bracket-bl"></div>
    <div class="pre-bracket pre-bracket-br"></div>

    <!-- Top bar -->
    <div class="pre-inner" style="padding: 2rem 2.5rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,229,0,0.08);">
      <span style="font-family:'Bebas Neue',sans-serif; color:#FFE500; font-size:1.4rem; letter-spacing:0.2em;">STORYTALE</span>
      <span style="font-family:'Space Grotesk',sans-serif; color:#FFE500; font-size:0.6rem; opacity:0.3; letter-spacing:0.35em; text-transform:uppercase;">Portfolio 2026</span>
    </div>

    <!-- Counter -->
    <div class="pre-inner" style="flex:1; display:flex; flex-direction:column; justify-content:center; padding: 0 2.5rem;">
      <div style="font-family:'Space Grotesk',sans-serif; color:rgba(255,229,0,0.35); font-size:0.6rem; letter-spacing:0.5em; text-transform:uppercase; margin-bottom:0.75rem;">Loading</div>
      <div id="preloader-count">100</div>
      <div style="font-family:'Space Grotesk',sans-serif; color:rgba(255,229,0,0.2); font-size:0.65rem; letter-spacing:0.3em; text-transform:uppercase; margin-top:1.5rem;">Stories That Sell — Digital Marketing</div>
    </div>

    <!-- Bottom bar -->
    <div class="pre-inner" style="padding: 1.5rem 2.5rem 2rem;">
      <!-- Progress track -->
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
       HERO BANNER
  ═══════════════════════════════════ -->
  <section id="hero"
    class="relative bg-[#FFE500] border-b-4 border-[#0A0A0A] flex flex-col overflow-hidden"
    style="height:100dvh; padding-top:var(--header-h, 100px);">

    <!-- Grid lines -->
    <div class="absolute inset-0 pointer-events-none"
      style="background-image:repeating-linear-gradient(0deg,transparent,transparent 79px,rgba(10,10,10,0.07) 79px,rgba(10,10,10,0.07) 80px),repeating-linear-gradient(90deg,transparent,transparent 79px,rgba(10,10,10,0.07) 79px,rgba(10,10,10,0.07) 80px);">
    </div>

    <!-- Corner index label -->
    <div class="absolute left-6 lg:left-12 font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-40 flex flex-col gap-1"
      style="top: calc(var(--header-h, 100px) + 20px);">
      <span>§ 001</span>
      <span>HERO</span>
    </div>

    <!-- ── Floating shapes (each has an ID for GSAP) ── -->
    <div id="shape-sq-lg"
      class="absolute right-8 lg:right-16 w-24 h-24 lg:w-40 lg:h-40 bg-[#0A0A0A] border-4 border-[#0A0A0A] shadow-brutal-xl opacity-90"
      style="top: calc(var(--header-h, 100px) + 40px); rotate: 12deg;">
    </div>

    <div id="shape-sq-sm"
      class="absolute right-16 lg:right-32 w-12 h-12 lg:w-20 lg:h-20 bg-[#FFE500] border-4 border-[#0A0A0A] shadow-brutal"
      style="top: calc(var(--header-h, 100px) + 110px); rotate: -6deg;">
    </div>

    <div id="shape-sq-bot"
      class="absolute bottom-32 right-4 lg:right-20 w-16 h-16 lg:w-28 lg:h-28 bg-[#0A0A0A] border-4 border-[#0A0A0A]"
      style="rotate: 3deg;">
    </div>

    <div id="shape-circle"
      class="absolute left-1/2 -translate-x-1/2 lg:left-auto lg:translate-x-0 lg:right-[380px] w-64 h-64 lg:w-96 lg:h-96 rounded-full border-4 border-[#0A0A0A] opacity-10"
      style="top: calc(var(--header-h, 100px) + 60px);">
    </div>

    <!-- ── Hero main content ── -->
    <div class="relative z-10 max-w-[1440px] mx-auto px-6 lg:px-12 pb-8 w-full flex-1 flex flex-col justify-between">

      <!-- Agency tag -->
      <div id="hero-tag" style="opacity:0;">
        <div class="inline-flex items-center gap-3 border-2 border-[#0A0A0A] bg-[#0A0A0A] px-4 py-2 mt-2 shadow-brutal">
          <span class="w-2 h-2 rounded-full bg-[#FFE500] animate-pulse"></span>
          <span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500]">Digital Marketing Agency</span>
        </div>
      </div>

      <!-- Headline -->
      <div id="hero-headline" style="opacity:0;">
        <h1 class="font-brutal text-[clamp(3rem,9vw,11rem)] leading-[0.88] uppercase text-[#0A0A0A] tracking-tight glitch">
          WE<br/>
          <span class="relative inline-block">
            TELL
            <span class="absolute bottom-4 left-0 right-0 h-4 lg:h-6 bg-[#0A0A0A] opacity-10 -z-10"></span>
          </span>
          <br/>
          <span style="-webkit-text-stroke: 4px #0A0A0A; color: transparent;">YOUR STORY.</span>
        </h1>
      </div>

      <!-- Sub row -->
      <div id="hero-sub" class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 border-t-2 border-[#0A0A0A] pt-6" style="opacity:0;">

        <!-- Description -->
        <div class="lg:max-w-md">
          <p class="font-body text-base lg:text-lg text-[#0A0A0A] leading-relaxed font-medium">
            We are a digital marketing agency that builds bold brand narratives — social media, content strategy, paid ads, and campaigns engineered to grow your audience and convert.
          </p>
          <div class="flex flex-wrap gap-3 mt-6">
            <a href="#work"
              class="inline-block bg-[#0A0A0A] text-[#FFE500] font-body font-bold text-sm uppercase tracking-widest px-8 py-4 border-2 border-[#0A0A0A] shadow-brutal-lg hover:translate-x-[3px] hover:translate-y-[3px] hover:shadow-none transition-all duration-150 no-underline">
              View Work
            </a>
            <a href="#about"
              class="inline-block bg-transparent text-[#0A0A0A] font-body font-bold text-sm uppercase tracking-widest px-8 py-4 border-2 border-[#0A0A0A] shadow-brutal hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-150 no-underline">
              Our Agency ↗
            </a>
          </div>
        </div>

        <!-- Stats -->
        <div class="flex gap-0 border-2 border-[#0A0A0A] shadow-brutal-lg">
          <div class="flex flex-col items-center justify-center px-8 py-6 border-r-2 border-[#0A0A0A]">
            <span class="font-brutal text-5xl lg:text-6xl text-[#0A0A0A] leading-none">87</span>
            <span class="font-body text-[10px] font-bold uppercase tracking-widest text-[#0A0A0A] opacity-60 mt-1">Projects</span>
          </div>
          <div class="flex flex-col items-center justify-center px-8 py-6 border-r-2 border-[#0A0A0A]">
            <span class="font-brutal text-5xl lg:text-6xl text-[#0A0A0A] leading-none">8+</span>
            <span class="font-body text-[10px] font-bold uppercase tracking-widest text-[#0A0A0A] opacity-60 mt-1">Years</span>
          </div>
          <div class="flex flex-col items-center justify-center px-8 py-6">
            <span class="font-brutal text-5xl lg:text-6xl text-[#0A0A0A] leading-none">★4</span>
            <span class="font-body text-[10px] font-bold uppercase tracking-widest text-[#0A0A0A] opacity-60 mt-1">Awards</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Scroll indicator -->
    <div id="hero-scroll" class="absolute bottom-6 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 z-10" style="opacity:0;">
      <span class="scroll-label font-body text-[10px] font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50">Scroll</span>
      <div class="scroll-line w-px h-10 bg-[#0A0A0A] opacity-60"></div>
    </div>

    <!-- Bottom running text strip -->
    <div class="absolute bottom-0 left-0 right-0 bg-[#FFE500] border-t-2 border-[#0A0A0A] overflow-hidden py-2 z-10">
      <div class="flex whitespace-nowrap">
        <div id="ticker-hero" class="marquee-rev flex items-center gap-0">
          <span class="font-body text-[10px] font-bold uppercase tracking-[0.35em] text-[#0A0A0A] opacity-40 px-10">Social Media</span>
          <span class="text-[#0A0A0A] opacity-20 px-2">—</span>
          <span class="font-body text-[10px] font-bold uppercase tracking-[0.35em] text-[#0A0A0A] opacity-40 px-10">Content Marketing</span>
          <span class="text-[#0A0A0A] opacity-20 px-2">—</span>
          <span class="font-body text-[10px] font-bold uppercase tracking-[0.35em] text-[#0A0A0A] opacity-40 px-10">Paid Ads</span>
          <span class="text-[#0A0A0A] opacity-20 px-2">—</span>
          <span class="font-body text-[10px] font-bold uppercase tracking-[0.35em] text-[#0A0A0A] opacity-40 px-10">SEO</span>
          <span class="text-[#0A0A0A] opacity-20 px-2">—</span>
          <span class="font-body text-[10px] font-bold uppercase tracking-[0.35em] text-[#0A0A0A] opacity-40 px-10">Email Marketing</span>
          <span class="text-[#0A0A0A] opacity-20 px-2">—</span>
          <span class="font-body text-[10px] font-bold uppercase tracking-[0.35em] text-[#0A0A0A] opacity-40 px-10">Branding</span>
          <span class="text-[#0A0A0A] opacity-20 px-2">—</span>
          <span class="font-body text-[10px] font-bold uppercase tracking-[0.35em] text-[#0A0A0A] opacity-40 px-10">Social Media</span>
          <span class="text-[#0A0A0A] opacity-20 px-2">—</span>
          <span class="font-body text-[10px] font-bold uppercase tracking-[0.35em] text-[#0A0A0A] opacity-40 px-10">Content Marketing</span>
          <span class="text-[#0A0A0A] opacity-20 px-2">—</span>
          <span class="font-body text-[10px] font-bold uppercase tracking-[0.35em] text-[#0A0A0A] opacity-40 px-10">Paid Ads</span>
          <span class="text-[#0A0A0A] opacity-20 px-2">—</span>
          <span class="font-body text-[10px] font-bold uppercase tracking-[0.35em] text-[#0A0A0A] opacity-40 px-10">SEO</span>
          <span class="text-[#0A0A0A] opacity-20 px-2">—</span>
          <span class="font-body text-[10px] font-bold uppercase tracking-[0.35em] text-[#0A0A0A] opacity-40 px-10">Email Marketing</span>
          <span class="text-[#0A0A0A] opacity-20 px-2">—</span>
          <span class="font-body text-[10px] font-bold uppercase tracking-[0.35em] text-[#0A0A0A] opacity-40 px-10">Branding</span>
          <span class="text-[#0A0A0A] opacity-20 px-2">—</span>
        </div>
      </div>
    </div>

    <!-- Vertical stripe — click to expand contact panel -->
    <div id="stripe-wrap" class="absolute right-0 hidden xl:flex items-start z-20" style="top: calc(var(--header-h, 100px) + 12px);">

      <!-- Expanded contact panel (hidden by default) -->
      <div id="stripe-panel"
        class="bg-[#0A0A0A] border-l-4 border-[#FFE500] flex flex-col overflow-y-auto overflow-x-hidden"
        style="width:0; opacity:0; pointer-events:none;">
        <div class="p-6 flex flex-col gap-5 w-[260px]">

          <!-- Header -->
          <div>
            <div class="font-brutal text-[#FFE500] text-xl tracking-widest leading-none">STORYTALE</div>
            <div class="font-body text-[#FFE500] text-[10px] uppercase tracking-[0.3em] opacity-40 mt-1">Digital Marketing Agency · Est. 2017</div>
          </div>

          <!-- Address -->
          <div>
            <div class="font-body text-[#FFE500] text-[9px] uppercase tracking-[0.3em] opacity-40 mb-1">Address</div>
            <div class="font-body text-[#FFE500] text-xs leading-relaxed opacity-80">
              Jl. Kemang Raya No. 12<br/>
              Jakarta Selatan, 12730<br/>
              Indonesia
            </div>
          </div>

          <!-- WhatsApp -->
          <div>
            <div class="font-body text-[#FFE500] text-[9px] uppercase tracking-[0.3em] opacity-40 mb-1">WhatsApp</div>
            <a href="{{ $waUrl }}"
              class="font-body text-[#FFE500] text-xs font-bold opacity-90 hover:opacity-100 no-underline transition-opacity flex items-center gap-2">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="#FFE500"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
              +62 812-3456-7890
            </a>
          </div>

          <!-- Email -->
          <div>
            <div class="font-body text-[#FFE500] text-[9px] uppercase tracking-[0.3em] opacity-40 mb-1">Email</div>
            <a href="mailto:hello@storytale.id"
              class="font-body text-[#FFE500] text-xs font-bold opacity-90 hover:opacity-100 no-underline transition-opacity">
              hello@storytale.id
            </a>
          </div>

          <!-- Social -->
          <div>
            <div class="font-body text-[#FFE500] text-[9px] uppercase tracking-[0.3em] opacity-40 mb-3">Follow Us</div>
            <div class="flex flex-col gap-3">

              <!-- Instagram -->
              <a href="#" class="flex items-center gap-3 no-underline group">
                <div class="w-8 h-8 border-2 border-[#FFE500] flex items-center justify-center flex-shrink-0 group-hover:bg-[#FFE500] transition-colors duration-150">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="text-[#FFE500] group-hover:text-[#0A0A0A] transition-colors duration-150"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                </div>
                <div>
                  <div class="font-body text-[#FFE500] text-xs font-bold leading-none">Instagram</div>
                  <div class="font-body text-[#FFE500] text-[10px] opacity-40 leading-none mt-0.5">@storytale.id</div>
                </div>
              </a>

              <!-- TikTok -->
              <a href="#" class="flex items-center gap-3 no-underline group">
                <div class="w-8 h-8 border-2 border-[#FFE500] flex items-center justify-center flex-shrink-0 group-hover:bg-[#FFE500] transition-colors duration-150">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="text-[#FFE500] group-hover:text-[#0A0A0A] transition-colors duration-150"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                </div>
                <div>
                  <div class="font-body text-[#FFE500] text-xs font-bold leading-none">TikTok</div>
                  <div class="font-body text-[#FFE500] text-[10px] opacity-40 leading-none mt-0.5">@storytale.id</div>
                </div>
              </a>

              <!-- LinkedIn -->
              <a href="#" class="flex items-center gap-3 no-underline group">
                <div class="w-8 h-8 border-2 border-[#FFE500] flex items-center justify-center flex-shrink-0 group-hover:bg-[#FFE500] transition-colors duration-150">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="text-[#FFE500] group-hover:text-[#0A0A0A] transition-colors duration-150"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                </div>
                <div>
                  <div class="font-body text-[#FFE500] text-xs font-bold leading-none">LinkedIn</div>
                  <div class="font-body text-[#FFE500] text-[10px] opacity-40 leading-none mt-0.5">Storytale Agency</div>
                </div>
              </a>

            </div>
          </div>

        </div>
      </div>

      <!-- Tab (always visible) -->
      <button id="stripe-tab"
        class="bg-[#0A0A0A] text-[#FFE500] font-body text-[10px] font-bold uppercase tracking-[0.3em] px-3 py-16 flex items-center justify-center cursor-pointer border-none outline-none hover:bg-[#1a1a1a] transition-colors duration-150"
        style="writing-mode:vertical-rl; transform:rotate(180deg);"
        aria-label="Toggle contact info">
        <span id="stripe-label">STORYTALE — EST. 2017 — JAKARTA, ID</span>
        <span id="stripe-arrow" class="ml-3" style="writing-mode:horizontal-tb; display:inline-block;">▼</span>
      </button>
    </div>

  </section>


  <!-- ═══════════════════════════════════
       CLIENTS STRIP
  ═══════════════════════════════════ -->
  <div class="bg-[#0A0A0A] border-b-4 border-[#0A0A0A] py-5 overflow-hidden">
    <div class="flex whitespace-nowrap">
      <div id="ticker-clients" class="marquee-track flex items-center gap-0">
        <span class="font-brutal text-[#FFE500] text-3xl tracking-widest px-10 opacity-80">NIKE</span>
        <span class="text-[#FFE500] opacity-30 text-2xl px-2">✦</span>
        <span class="font-brutal text-[#FFE500] text-3xl tracking-widest px-10 opacity-80">SPOTIFY</span>
        <span class="text-[#FFE500] opacity-30 text-2xl px-2">✦</span>
        <span class="font-brutal text-[#FFE500] text-3xl tracking-widest px-10 opacity-80">ADOBE</span>
        <span class="text-[#FFE500] opacity-30 text-2xl px-2">✦</span>
        <span class="font-brutal text-[#FFE500] text-3xl tracking-widest px-10 opacity-80">STRIPE</span>
        <span class="text-[#FFE500] opacity-30 text-2xl px-2">✦</span>
        <span class="font-brutal text-[#FFE500] text-3xl tracking-widest px-10 opacity-80">FIGMA</span>
        <span class="text-[#FFE500] opacity-30 text-2xl px-2">✦</span>
        <span class="font-brutal text-[#FFE500] text-3xl tracking-widest px-10 opacity-80">NOTION</span>
        <span class="text-[#FFE500] opacity-30 text-2xl px-2">✦</span>
        <span class="font-brutal text-[#FFE500] text-3xl tracking-widest px-10 opacity-80">NIKE</span>
        <span class="text-[#FFE500] opacity-30 text-2xl px-2">✦</span>
        <span class="font-brutal text-[#FFE500] text-3xl tracking-widest px-10 opacity-80">SPOTIFY</span>
        <span class="text-[#FFE500] opacity-30 text-2xl px-2">✦</span>
        <span class="font-brutal text-[#FFE500] text-3xl tracking-widest px-10 opacity-80">ADOBE</span>
        <span class="text-[#FFE500] opacity-30 text-2xl px-2">✦</span>
        <span class="font-brutal text-[#FFE500] text-3xl tracking-widest px-10 opacity-80">STRIPE</span>
        <span class="text-[#FFE500] opacity-30 text-2xl px-2">✦</span>
        <span class="font-brutal text-[#FFE500] text-3xl tracking-widest px-10 opacity-80">FIGMA</span>
        <span class="text-[#FFE500] opacity-30 text-2xl px-2">✦</span>
        <span class="font-brutal text-[#FFE500] text-3xl tracking-widest px-10 opacity-80">NOTION</span>
        <span class="text-[#FFE500] opacity-30 text-2xl px-2">✦</span>
      </div>
    </div>
  </div>


  <!-- ═══════════════════════════════════
       SECTION 2 — WORK GALLERY
  ═══════════════════════════════════ -->
  <section id="work" class="bg-[#FFE500] border-b-4 border-[#0A0A0A] pt-20 pb-28 lg:pt-28">

    <!-- Section header -->
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12 mb-10">
      <div class="flex items-end justify-between border-b-4 border-[#0A0A0A] pb-6">

        <div>
          <span class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-40">§ 002</span>
          <h2 class="font-brutal text-[clamp(3rem,7vw,8rem)] uppercase text-[#0A0A0A] leading-none tracking-tight">
            Our Work
          </h2>
        </div>

        <div class="hidden lg:flex flex-col items-end gap-2 pb-3">
          <a href="/work"
            class="inline-block bg-[#0A0A0A] text-[#FFE500] font-body font-bold text-xs uppercase tracking-widest px-5 py-3 border-2 border-[#0A0A0A] shadow-brutal hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-150 no-underline">
            View All Work →
          </a>
          <span class="font-body text-[10px] font-bold uppercase tracking-widest text-[#0A0A0A] opacity-30">
            <span id="gallery-count">—</span> Projects
          </span>
        </div>
      </div>
    </div>

    <!-- Masonry grid -->
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
      <div id="gallery-grid" class="masonry-grid">
        <!-- Loading state -->
        <div id="gallery-loading" style="grid-column:1/-1; display:flex; align-items:center; justify-content:center; padding:5rem 0;">
          <span class="font-brutal text-[#0A0A0A] text-3xl tracking-widest opacity-20">Loading...</span>
        </div>
      </div>
    </div>

  </section>


  <!-- ═══════════════════════════════════
       SECTION 3 — SERVICES
  ═══════════════════════════════════ -->
  <section id="services" class="bg-[#FFE500] border-b-4 border-[#0A0A0A] pt-20 pb-28 lg:pt-28">

    <!-- Section header -->
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12 mb-12">
      <div class="flex items-end justify-between border-b-4 border-[#0A0A0A] pb-6">
        <div>
          <span class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-40">§ 003</span>
          <h2 class="font-brutal text-[clamp(3rem,7vw,8rem)] uppercase text-[#0A0A0A] leading-none tracking-tight">
            Services
          </h2>
        </div>
        <div class="hidden lg:flex items-end gap-4 pb-3">
          <a href="/services"
            class="inline-block bg-[#0A0A0A] text-[#FFE500] font-body font-bold text-xs uppercase tracking-widest px-5 py-3 border-2 border-[#0A0A0A] shadow-brutal hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-150 no-underline">
            View All Services →
          </a>
          <span class="font-body text-xs text-[#0A0A0A] opacity-30 font-medium">8 disciplines</span>
        </div>
      </div>
    </div>

    <!-- Services highlight — loaded from /api/services (same data as /services page) -->
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
      <div id="services-highlight-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-[3px]">
        <!-- filled by JS -->
      </div>

      <!-- Mobile CTA -->
      <div class="mt-6 lg:hidden">
        <a href="/services" class="block text-center bg-[#0A0A0A] text-[#FFE500] font-body font-bold text-sm uppercase tracking-widest px-8 py-4 border-2 border-[#0A0A0A] no-underline">
          View All 8 Services →
        </a>
      </div>
    </div>

  </section>


  <!-- ═══════════════════════════════════
       SECTION 4 — STUDIO HIGHLIGHT
  ═══════════════════════════════════ -->
  <section id="studio-highlight" class="bg-[#0A0A0A] border-b-4 border-[#FFE500] pt-20 pb-28 lg:pt-28 overflow-hidden">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">

      <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-16">

        <!-- Left: text -->
        <div class="lg:max-w-xl">
          <span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-40">§ 004 — Our Studio</span>
          <h2 id="sh-mission-quote" class="font-brutal text-[clamp(3rem,7vw,8rem)] text-[#FFE500] leading-none tracking-tight uppercase mt-2">
            Stories<br/>That<br/>Sell.
          </h2>
          <p id="sh-mission-desc" class="font-body text-base text-[#FFE500] opacity-50 leading-relaxed font-medium mt-6 max-w-md">
            STORYTALE is a Jakarta-based digital marketing agency built on one belief: the right story, told in the right way, sells anything. We combine data-driven strategy with bold creative execution across 8 disciplines.
          </p>
          <a href="/studio"
            class="inline-block mt-8 bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-sm uppercase tracking-widest px-8 py-4 border-2 border-[#FFE500] shadow-[4px_4px_0px_rgba(255,229,0,0.25)] hover:translate-x-[3px] hover:translate-y-[3px] hover:shadow-none transition-all duration-150 no-underline">
            Meet the Studio →
          </a>
        </div>

        <!-- Right: stat boxes + team snippet -->
        <div class="flex flex-col gap-[3px] lg:min-w-[360px]">
          <div id="sh-stats-row1" class="flex gap-[3px]">
            <div class="flex-1 border-2 border-[rgba(255,229,0,0.15)] p-6 flex flex-col gap-1">
              <span class="font-brutal text-[#FFE500] text-5xl leading-none">87</span>
              <span class="font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40">Projects Delivered</span>
            </div>
            <div class="flex-1 border-2 border-[rgba(255,229,0,0.15)] p-6 flex flex-col gap-1">
              <span class="font-brutal text-[#FFE500] text-5xl leading-none">8+</span>
              <span class="font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40">Years Active</span>
            </div>
          </div>
          <div id="sh-stats-row2" class="flex gap-[3px]">
            <div class="flex-1 border-2 border-[rgba(255,229,0,0.15)] p-6 flex flex-col gap-1">
              <span class="font-brutal text-[#FFE500] text-5xl leading-none">8</span>
              <span class="font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40">Disciplines</span>
            </div>
            <div class="flex-1 border-2 border-[rgba(255,229,0,0.15)] p-6 flex flex-col gap-1">
              <span class="font-brutal text-[#FFE500] text-5xl leading-none">★4</span>
              <span class="font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40">Industry Awards</span>
            </div>
          </div>
          <!-- Team initials strip — populated by JS -->
          <div id="sh-team-strip" class="border-2 border-[rgba(255,229,0,0.15)] p-4 flex items-center gap-3">
            <div id="sh-team-avatars" class="flex -space-x-2">
              <div class="w-9 h-9 bg-[#FFE500] border-2 border-[#0A0A0A] flex items-center justify-center flex-shrink-0">
                <span class="font-brutal text-[#0A0A0A] text-lg leading-none">A</span>
              </div>
              <div class="w-9 h-9 bg-[#FFE500] border-2 border-[#0A0A0A] flex items-center justify-center flex-shrink-0">
                <span class="font-brutal text-[#0A0A0A] text-lg leading-none">S</span>
              </div>
              <div class="w-9 h-9 bg-[#FFE500] border-2 border-[#0A0A0A] flex items-center justify-center flex-shrink-0">
                <span class="font-brutal text-[#0A0A0A] text-lg leading-none">R</span>
              </div>
              <div class="w-9 h-9 bg-[#FFE500] border-2 border-[#0A0A0A] flex items-center justify-center flex-shrink-0">
                <span class="font-brutal text-[#0A0A0A] text-lg leading-none">N</span>
              </div>
            </div>
            <span id="sh-team-label" class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-50">4 specialists, one team</span>
          </div>
        </div>

      </div>
    </div>
  </section>


  <!-- ═══════════════════════════════════
       SECTION 5 — JOURNAL HIGHLIGHT
  ═══════════════════════════════════ -->
  <section id="journal-highlight" class="bg-[#FFE500] border-b-4 border-[#0A0A0A] pt-20 pb-28 lg:pt-28">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">

      <!-- Header -->
      <div class="flex items-end justify-between border-b-4 border-[#0A0A0A] pb-6 mb-10">
        <div>
          <span class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-40">§ 005</span>
          <h2 class="font-brutal text-[clamp(3rem,7vw,8rem)] uppercase text-[#0A0A0A] leading-none tracking-tight">Journal</h2>
        </div>
        <a href="/journal"
          class="hidden lg:inline-block bg-[#0A0A0A] text-[#FFE500] font-body font-bold text-xs uppercase tracking-widest px-5 py-3 border-2 border-[#0A0A0A] shadow-brutal hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-150 no-underline pb-6">
          All Issues →
        </a>
      </div>

      <!-- 3 journal cards -->
      <div id="journal-preview" class="grid grid-cols-1 md:grid-cols-3 gap-[3px]">
        <!-- filled by JS -->
        <div style="grid-column:1/-1;padding:3rem 0;text-align:center;">
          <span class="font-brutal text-[#0A0A0A] text-2xl tracking-widest opacity-20">Loading…</span>
        </div>
      </div>

      <div class="mt-8 lg:hidden">
        <a href="/journal" class="block text-center bg-[#0A0A0A] text-[#FFE500] font-body font-bold text-sm uppercase tracking-widest px-8 py-4 border-2 border-[#0A0A0A] no-underline">All Issues →</a>
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


    // ── Infinite shape animations ──────────────────────────
    function initShapeAnimations() {

      // Large black square — slow drift + rotation
      gsap.to('#shape-sq-lg', {
        y: -32, rotation: 20,
        duration: 3.6, ease: 'sine.inOut',
        repeat: -1, yoyo: true,
      });

      // Small yellow square — opposite phase
      gsap.to('#shape-sq-sm', {
        y: 22, x: -14, rotation: 3,
        duration: 2.8, ease: 'sine.inOut',
        repeat: -1, yoyo: true, delay: 0.9,
      });

      // Bottom-right black square — longer arc
      gsap.to('#shape-sq-bot', {
        y: -38, x: 12, rotation: -6,
        duration: 4.3, ease: 'sine.inOut',
        repeat: -1, yoyo: true, delay: 1.4,
      });

      // Outline circle — slow breathing drift
      gsap.to('#shape-circle', {
        x: 22, y: -28, scale: 1.06,
        duration: 5.5, ease: 'sine.inOut',
        repeat: -1, yoyo: true, delay: 0.5,
      });
    }


    // ── Hero entrance timeline ─────────────────────────────
    function animateHeroIn() {
      initShapeAnimations();

      const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

      tl.fromTo('#hero-tag',
        { opacity: 0, y: 24 },
        { opacity: 1, y: 0, duration: 0.65 }
      )
      .fromTo('#hero-headline',
        { opacity: 0, y: 60, skewY: 2 },
        { opacity: 1, y: 0, skewY: 0, duration: 0.9 },
        '-=0.25'
      )
      .fromTo('#hero-sub',
        { opacity: 0, y: 36 },
        { opacity: 1, y: 0, duration: 0.75 },
        '-=0.35'
      )
      .fromTo('#hero-scroll',
        { opacity: 0 },
        { opacity: 1, duration: 0.5 },
        '-=0.1'
      );
    }


    // ── Preloader ──────────────────────────────────────────
    const countEl   = document.getElementById('preloader-count');
    const barEl     = document.getElementById('preloader-bar');
    const pctEl     = document.getElementById('preloader-pct');
    const preloader = document.getElementById('preloader');
    const counter   = { val: 100 };

    gsap.to(counter, {
      val: 0,
      duration: 2.8,
      ease: 'power2.inOut',
      onUpdate() {
        const v = Math.round(counter.val);
        countEl.textContent = String(v).padStart(3, '0');
        barEl.style.width   = (100 - v) + '%';
        if (pctEl) pctEl.textContent = (100 - v) + '%';
      },
      onComplete() {
        // Hold at 000 briefly, then wipe up
        gsap.to(preloader, {
          yPercent: -105,
          duration: 1.05,
          ease: 'expo.inOut',
          delay: 0.28,
          onStart() {
            // Flash the progress bar to full yellow to signal exit
            gsap.to(barEl, { width: '100%', duration: 0.1 });
          },
          onComplete() {
            preloader.style.display = 'none';
            document.body.style.overflow = 'auto';
            animateHeroIn();
          }
        });
      }
    });


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
    gsap.registerPlugin(ScrollTrigger);

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

    const FALLBACK = [
      { id:1, title:'Kopi Nusantara — Search & Display Ads',   client:'Kopi Nusantara',  category_slug:'digital-ads',       category_name:'Digital Ads',       slug:'kopi-nusantara-digital-ads',  project_year:2024 },
      { id:2, title:'BeautyLab — HTML5 Rich Media Banners',    client:'BeautyLab',        category_slug:'rich-media',        category_name:'Rich Media',        slug:'beautylab-rich-media',        project_year:2024 },
      { id:3, title:'Lawson ID — Email Newsletter Campaign',   client:'Lawson Indonesia', category_slug:'newsletter',        category_name:'Newsletter',        slug:'lawson-id-newsletter',        project_year:2023 },
      { id:4, title:'EduPath — Annual Digital Strategy',       client:'EduPath',          category_slug:'digital-strategy',  category_name:'Digital Strategy',  slug:'edupath-digital-strategy',    project_year:2024 },
      { id:5, title:'Toko Sehat — TikTok & YouTube Video Ads', client:'Toko Sehat',       category_slug:'video-ads',         category_name:'Video Ads',         slug:'toko-sehat-video-ads',        project_year:2024 },
      { id:6, title:'Pondok Asri — Website Redesign',          client:'Pondok Asri',      category_slug:'website',           category_name:'Website',           slug:'pondok-asri-website',         project_year:2023 },
    ];

    const SIZE_PATTERN = ['tall', 'small', 'tall', 'small', 'small', 'tall'];

    let allProjects = [];

    function buildCard(project, index) {
      const size    = SIZE_PATTERN[index % SIZE_PATTERN.length];
      const bg      = CAT_COLORS[project.category_slug] || CAT_COLORS.default;
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
        <div class="card-img" style="background:${hasCover ? '#111' : bg};">
          ${hasCover
            ? `<img src="${project.cover_image}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" loading="lazy"/>`
            : `<div style="position:absolute;inset:0;pointer-events:none;background-image:${pat};${patSize ? `background-size:${patSize};` : ''}"></div>
          <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-55%) rotate(45deg);width:clamp(52px,6.5vw,90px);height:clamp(52px,6.5vw,90px);border:2px solid ${brkC};pointer-events:none;z-index:1;"></div>
          <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none;z-index:1;"><span style="font-family:'Bebas Neue',sans-serif;font-size:clamp(4.5rem,9vw,10rem);line-height:1;color:${dimC};letter-spacing:-0.02em;">${num}</span></div>
          <div style="position:absolute;bottom:18px;right:12px;pointer-events:none;z-index:1;font-family:'Space Grotesk',sans-serif;font-size:0.42rem;font-weight:700;text-transform:uppercase;letter-spacing:0.38em;color:${lblC};writing-mode:vertical-rl;transform:rotate(180deg);white-space:nowrap;">${cat}</div>`}
          <div style="position:absolute;top:14px;left:14px;width:18px;height:18px;border-top:2px solid ${brkC};border-left:2px solid ${brkC};pointer-events:none;z-index:2;"></div>
          <div style="position:absolute;top:14px;right:14px;width:18px;height:18px;border-top:2px solid ${brkC};border-right:2px solid ${brkC};pointer-events:none;z-index:2;"></div>
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
    }

    /* update project count */
    function updateCount(n) {
      const el = document.getElementById('gallery-count');
      if (el) el.textContent = String(n).padStart(2, '0');
    }

    /* load from PHP API, fallback to static data */
    fetch('/api/projects')
      .then(r => { if (!r.ok) throw new Error(); return r.json(); })
      .then(data => { allProjects = data; updateCount(data.length); renderGallery(data); })
      .catch(() => { allProjects = FALLBACK; updateCount(FALLBACK.length); renderGallery(FALLBACK); });

    /* "View All Work" link shows all projects on /work */


    // ── Services section animations ───────────────────────
    gsap.from('#services h2', {
      y: 60, opacity: 0, skewY: 1, duration: 0.9, ease: 'power3.out',
      scrollTrigger: { trigger: '#services', start: 'top 80%', once: true }
    });

    gsap.from('.service-card', {
      y: 80, opacity: 0,
      duration: 0.75, stagger: { each: 0.1, from: 'start' }, ease: 'power3.out',
      scrollTrigger: { trigger: '#services .grid', start: 'top 82%', once: true }
    });


    // ── Stripe contact panel ───────────────────────────────
    const stripeTab   = document.getElementById('stripe-tab');
    const stripePanel = document.getElementById('stripe-panel');
    const stripeArrow = document.getElementById('stripe-arrow');
    let stripeOpen    = false;

    stripeTab.addEventListener('click', () => {
      stripeOpen = !stripeOpen;

      if (stripeOpen) {
        // Expand panel
        stripePanel.style.pointerEvents = 'auto';
        gsap.timeline()
          .to(stripePanel, {
            width: 260,
            duration: 0.45,
            ease: 'expo.out',
          })
          .to(stripePanel, {
            opacity: 1,
            duration: 0.25,
            ease: 'power2.out',
          }, '-=0.2');
        gsap.to(stripeArrow, { rotationZ: 180, duration: 0.35, ease: 'power2.out' });
      } else {
        // Collapse panel
        gsap.timeline()
          .to(stripePanel, {
            opacity: 0,
            duration: 0.2,
            ease: 'power2.in',
          })
          .to(stripePanel, {
            width: 0,
            duration: 0.4,
            ease: 'expo.in',
            onComplete() { stripePanel.style.pointerEvents = 'none'; }
          }, '-=0.05');
        gsap.to(stripeArrow, { rotationZ: 0, duration: 0.35, ease: 'power2.out' });
      }
    });

    // ── Journal preview section ────────────────────────────
    const CAT_JOURNAL_COLORS = {
      'case-study': '#FF2D2D', 'learning': '#2255FF', 'insight': '#00AA50',
      'whitepaper': '#FF7A00', 'report': '#9900DD', 'default': '#333',
    };
    const CAT_JOURNAL_LABELS = {
      'case-study':'Case Study','learning':'Learning','insight':'Insight',
      'whitepaper':'Whitepaper','report':'Report',
    };
    const JOURNAL_FALLBACK = [
      { id:1, title:'How We Scaled Kopi Nusantara to 120K in 6 Months', category:'case-study', excerpt:'A deep-dive into the content system and creative framework that took a local brand from 8K to 120K followers.', published_at:'2025-03-01', slug:'kopi-nusantara-case-study' },
      { id:2, title:'The Anatomy of a High-Converting Meta Ad', category:'learning', excerpt:'We broke down 200 of our best-performing Meta ads to find the patterns behind a 4× ROAS campaign.', published_at:'2025-04-10', slug:'meta-ads-anatomy' },
      { id:3, title:'2025 Digital Marketing Trends in Southeast Asia', category:'insight', excerpt:'AI content, short-form video dominance, and the rise of micro-influencers — what brands in SEA need to know.', published_at:'2025-01-20', slug:'digital-trends-sea-2025' },
    ];

    function buildJournalCard(item) {
      const color = CAT_JOURNAL_COLORS[item.category] || CAT_JOURNAL_COLORS.default;
      const label = CAT_JOURNAL_LABELS[item.category] || item.category;
      const date  = item.published_at ? new Date(item.published_at).toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'numeric'}) : '';
      const card  = document.createElement('a');
      card.href = '/journal';
      card.className = 'group block border-2 border-[#0A0A0A] bg-[#FFE500] hover:bg-[#0A0A0A] transition-colors duration-200 no-underline';
      card.innerHTML = `
        <div style="height:180px;background:${color};position:relative;overflow:hidden;">
          ${item.cover_image ? `<img src="${item.cover_image}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;"/>` : `
          <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
            <span style="font-family:'Bebas Neue',sans-serif;font-size:clamp(5rem,10vw,9rem);color:rgba(0,0,0,0.1);line-height:1;">${String(item.id).padStart(2,'0')}</span>
          </div>`}
        </div>
        <div class="p-5">
          <span class="font-body text-[9px] font-bold uppercase tracking-[0.3em] border border-current inline-block px-2 py-0.5 mb-3 transition-colors duration-200" style="color:${color};">${label}</span>
          <h3 class="font-brutal text-[#0A0A0A] group-hover:text-[#FFE500] text-xl tracking-wide leading-tight mb-2 transition-colors duration-200">${item.title}</h3>
          <p class="font-body text-xs text-[#0A0A0A] group-hover:text-[#FFE500] opacity-50 leading-relaxed transition-colors duration-200" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">${item.excerpt||''}</p>
          <div class="flex items-center justify-between mt-4 pt-3 border-t border-[rgba(0,0,0,0.1)] group-hover:border-[rgba(255,229,0,0.15)]">
            <span class="font-body text-[9px] font-bold uppercase tracking-widest text-[#0A0A0A] group-hover:text-[#FFE500] opacity-40 transition-colors duration-200">${date}</span>
            <span class="font-body text-xs font-bold text-[#0A0A0A] group-hover:text-[#FFE500] opacity-50 transition-colors duration-200">Read →</span>
          </div>
        </div>`;
      return card;
    }

    gsap.registerPlugin(ScrollTrigger);
    fetch('/api/journals')
      .then(r => r.json())
      .then(data => {
        const preview = document.getElementById('journal-preview');
        if (!preview) return;
        preview.innerHTML = '';
        (data.slice(0,3).length ? data.slice(0,3) : JOURNAL_FALLBACK).forEach(item => preview.appendChild(buildJournalCard(item)));
        gsap.from('#journal-preview > *', { y:40, opacity:0, stagger:0.08, duration:0.6, ease:'power3.out', scrollTrigger:{ trigger:'#journal-highlight', start:'top 82%', once:true } });
      })
      .catch(() => {
        const preview = document.getElementById('journal-preview');
        if (!preview) return;
        preview.innerHTML = '';
        JOURNAL_FALLBACK.forEach(item => preview.appendChild(buildJournalCard(item)));
      });

    // ── Studio + footer section animations ────────────────
    gsap.from('#studio-highlight h2', { y:50, opacity:0, duration:0.8, ease:'power3.out', scrollTrigger:{ trigger:'#studio-highlight', start:'top 80%', once:true } });

    // ── Load CMS settings → update tickers + service highlight ────
    function buildTicker(el, items, template) {
      if (!el || !items || !items.length) return;
      const doubled = [...items, ...items, ...items, ...items];
      el.innerHTML = doubled.map(template).join('');
    }

    function buildServiceCard(s, i) {
      const num  = String(i + 1).padStart(2, '0');
      const color = s.color || '#FFE500';
      const items = (s.scope_items || []).slice(0, 3).map(li => `<li>${li}</li>`).join('');
      const d = document.createElement('div');
      d.className = 'service-card';
      d.style.setProperty('--sc', color);
      d.innerHTML = `<span class="sc-num">${num}</span><div><div class="sc-bar"></div><div class="sc-name">${s.name}</div><p class="sc-desc">${s.description || ''}</p><ul class="sc-list">${items}</ul></div><a href="/services" class="sc-cta">Explore →</a>`;
      return d;
    }

    fetch('/api/settings').then(r => r.json()).then(cfg => {
      // Header ticker
      buildTicker(
        document.getElementById('ticker-header'),
        cfg.ticker_header?.items,
        item => `<span class="px-8">${item}</span>`
      );
      // Hero bottom strip
      buildTicker(
        document.getElementById('ticker-hero'),
        cfg.ticker_hero?.items,
        item => `<span class="font-body text-[10px] font-bold uppercase tracking-[0.35em] text-[#0A0A0A] opacity-40 px-10">${item}</span><span class="text-[#0A0A0A] opacity-20 px-2">—</span>`
      );
      // Clients strip
      buildTicker(
        document.getElementById('ticker-clients'),
        cfg.ticker_clients?.items,
        item => `<span class="font-brutal text-[#FFE500] text-3xl tracking-widest px-10 opacity-80">${item}</span><span class="text-[#FFE500] opacity-30 text-2xl px-2">✦</span>`
      );

      // Studio highlight — sync with studio page content
      const st = cfg.studio || {};
      if (st.mission_quote) {
        const el = document.getElementById('sh-mission-quote');
        if (el) el.textContent = st.mission_quote;
      }
      if (st.mission_desc) {
        const el = document.getElementById('sh-mission-desc');
        if (el) el.textContent = st.mission_desc;
      }
      if (st.stats && st.stats.length >= 4) {
        const rows = [
          document.getElementById('sh-stats-row1'),
          document.getElementById('sh-stats-row2'),
        ];
        [[0,1],[2,3]].forEach(([a,b], ri) => {
          if (!rows[ri]) return;
          rows[ri].innerHTML = [st.stats[a], st.stats[b]].map(s => `
            <div class="flex-1 border-2 border-[rgba(255,229,0,0.15)] p-6 flex flex-col gap-1">
              <span class="font-brutal text-[#FFE500] text-5xl leading-none">${s.val}</span>
              <span class="font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40">${s.label}</span>
            </div>`).join('');
        });
      }

      // Team strip — load from /api/team
      fetch('/api/team').then(r => r.json()).then(team => {
        const avatars = document.getElementById('sh-team-avatars');
        const label   = document.getElementById('sh-team-label');
        if (avatars && team.length) {
          avatars.innerHTML = team.slice(0, 5).map(m => {
            const initials = m.name.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase();
            return `<div class="w-9 h-9 bg-[#FFE500] border-2 border-[#0A0A0A] flex items-center justify-center flex-shrink-0">
              <span class="font-brutal text-[#0A0A0A] text-lg leading-none">${initials}</span>
            </div>`;
          }).join('');
        }
        if (label && team.length) {
          label.textContent = team.length + ' specialist' + (team.length !== 1 ? 's' : '') + ', one team';
        }
      }).catch(() => {});

      // Footer contact info
      const c = cfg.contact || {};
      if (c.address || c.email || c.phone) {
        const line = document.getElementById('footer-contact-line');
        if (line) {
          const parts = [c.address, c.email, c.phone].filter(Boolean);
          line.textContent = parts.join(' · ');
        }
      }
      if (c.email) {
        const btn = document.getElementById('footer-email-btn');
        if (btn) btn.href = 'mailto:' + c.email;
      }
      if (c.whatsapp) {
        const waNum = c.whatsapp.replace(/\D/g, '');
        const waUrl = 'https://wa.me/' + waNum;
        const btn = document.getElementById('footer-wa-btn');
        if (btn) btn.href = waUrl;
        const navWa = document.getElementById('navbar-wa-link');
        if (navWa) navWa.href = waUrl;
      }
      if (c.instagram_url) {
        const el = document.getElementById('footer-instagram-link');
        if (el && c.instagram_url !== '#') el.href = c.instagram_url;
      }
      if (c.linkedin_url) {
        const el = document.getElementById('footer-linkedin-link');
        if (el && c.linkedin_url !== '#') el.href = c.linkedin_url;
      }

    }).catch(() => {});

    // Load services from API (same source as /services page)
    fetch('/api/services').then(r => r.json()).then(data => {
      const grid = document.getElementById('services-highlight-grid');
      if (!grid) return;
      grid.innerHTML = '';
      const preview = data.slice(0, 4);
      preview.forEach((s, i) => grid.appendChild(buildServiceCard(s, i)));
    }).catch(() => {
      // fallback: load 4 hardcoded if API fails
      const grid = document.getElementById('services-highlight-grid');
      if (!grid) return;
      const fallback = [
        {name:'Digital Ads',color:'#FF2D2D',description:'Performance campaigns for ROAS.',scope_items:['Search Ads','Meta Ads','Programmatic']},
        {name:'Video Ads',color:'#E91E8C',description:'Video for TikTok, Reels, YouTube.',scope_items:['TikTok Scripts','YouTube Pre-roll','Motion Graphics']},
        {name:'Website',color:'#00AA50',description:'High-converting web experiences.',scope_items:['UI/UX Design','Development','CRO']},
        {name:'AI Apps',color:'#FFE500',description:'Custom AI tools for your business.',scope_items:['AI Chatbots','LLM Integrations','Automation']},
      ];
      fallback.forEach((s, i) => grid.appendChild(buildServiceCard(s, i)));
    });

  })();
  </script>

</body>
</html>
