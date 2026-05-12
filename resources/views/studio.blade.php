<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Studio — STORYTALE</title>

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

    /* CTA section */
    .cta-band {
      background: #0A0A0A;
      border-top: 4px solid #0A0A0A;
      border-bottom: 4px solid #0A0A0A;
    }

    /* Team card avatar */
    .team-avatar {
      width: 72px; height: 72px;
      background: #FFE500;
      border: 3px solid #0A0A0A;
      display: flex; align-items: center; justify-content: center;
      font-family: 'Bebas Neue', sans-serif;
      font-size: 2.2rem;
      color: #0A0A0A;
      flex-shrink: 0;
    }

    /* Process timeline */
    .process-step {
      position: relative;
    }
    @media (min-width: 1024px) {
      .process-track {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0;
      }
      .process-step + .process-step::before {
        content: '';
        position: absolute;
        top: 40px;
        left: -50%;
        width: 50%;
        height: 2px;
        background: #0A0A0A;
        opacity: 0.2;
      }
    }
    @media (max-width: 1023px) {
      .process-track {
        display: flex;
        flex-direction: column;
        gap: 0;
      }
      .process-step + .process-step {
        border-top: 0;
      }
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
      <span style="font-family:'Space Grotesk',sans-serif; color:#FFE500; font-size:0.6rem; opacity:0.3; letter-spacing:0.35em; text-transform:uppercase;">Studio</span>
    </div>

    <div class="pre-inner" style="flex:1; display:flex; flex-direction:column; justify-content:center; padding: 0 2.5rem;">
      <div style="font-family:'Space Grotesk',sans-serif; color:rgba(255,229,0,0.35); font-size:0.6rem; letter-spacing:0.5em; text-transform:uppercase; margin-bottom:0.75rem;">Loading</div>
      <div id="preloader-count">100</div>
      <div style="font-family:'Space Grotesk',sans-serif; color:rgba(255,229,0,0.2); font-size:0.65rem; letter-spacing:0.3em; text-transform:uppercase; margin-top:1.5rem;">Meet The Team Behind The Stories</div>
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


  <!-- ═══════════════════════════════════
       HEADER
  ═══════════════════════════════════ -->
  <header id="site-header"
    class="fixed top-0 left-0 right-0 z-50 bg-[#FFE500] border-b-4 border-[#0A0A0A]">

    <!-- Ticker -->
    <div class="bg-[#0A0A0A] text-[#FFE500] overflow-hidden py-1">
      <div class="flex whitespace-nowrap">
        <div class="marquee-track flex gap-0 font-body text-xs font-bold tracking-widest uppercase">
          <span class="px-8">★ Stories That Sell</span>
          <span class="px-8">★ Digital Marketing</span>
          <span class="px-8">★ Portfolio 2026</span>
          <span class="px-8">★ Content × Strategy</span>
          <span class="px-8">★ Stories That Sell</span>
          <span class="px-8">★ Digital Marketing</span>
          <span class="px-8">★ Portfolio 2026</span>
          <span class="px-8">★ Content × Strategy</span>
          <span class="px-8">★ Stories That Sell</span>
          <span class="px-8">★ Digital Marketing</span>
          <span class="px-8">★ Portfolio 2026</span>
          <span class="px-8">★ Content × Strategy</span>
        </div>
      </div>
    </div>

    <!-- Nav row -->
    <nav class="max-w-[1440px] mx-auto px-6 lg:px-12 flex items-center justify-between h-[72px]">

      <!-- Logo -->
      <a href="/" class="flex items-center gap-2 no-underline">
        <div class="w-9 h-9 bg-[#0A0A0A] border-2 border-[#0A0A0A] flex items-center justify-center">
          <span class="text-[#FFE500] font-brutal text-xl leading-none">S</span>
        </div>
        <span class="font-brutal text-2xl tracking-widest text-[#0A0A0A] uppercase leading-none">
          STORYTALE
        </span>
      </a>

      <!-- Desktop links -->
      <ul class="hidden lg:flex items-center gap-8 list-none">
        <li><a href="/work"      class="nav-link font-body font-bold text-sm uppercase tracking-widest text-[#0A0A0A] no-underline">Work</a></li>
        <li><a href="/studio"    class="nav-link active font-body font-bold text-sm uppercase tracking-widest text-[#0A0A0A] no-underline">Studio</a></li>
        <li><a href="/#services" class="nav-link font-body font-bold text-sm uppercase tracking-widest text-[#0A0A0A] no-underline">Services</a></li>
        <li><a href="/journal"   class="nav-link font-body font-bold text-sm uppercase tracking-widest text-[#0A0A0A] no-underline">Journal</a></li>
      </ul>

      <!-- Desktop CTA -->
      <div class="hidden lg:flex items-center gap-4">
        <span class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50">EST. 2017</span>
        <a href="/#contact"
          class="inline-block bg-[#0A0A0A] text-[#FFE500] font-body font-bold text-sm uppercase tracking-widest px-6 py-3 border-2 border-[#0A0A0A] shadow-brutal hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-150 no-underline">
          Let's Talk →
        </a>
      </div>

      <!-- Burger -->
      <button id="burger-btn"
        class="lg:hidden flex flex-col gap-[6px] p-2 border-2 border-[#0A0A0A] bg-[#FFE500] hover:bg-[#0A0A0A] group transition-colors duration-150 focus:outline-none"
        aria-label="Toggle menu">
        <span class="burger-line group-hover:bg-[#FFE500]"></span>
        <span class="burger-line group-hover:bg-[#FFE500]"></span>
        <span class="burger-line group-hover:bg-[#FFE500]"></span>
      </button>
    </nav>

    <!-- Mobile drawer -->
    <div id="mobile-nav"
      class="fixed top-0 right-0 h-screen w-4/5 max-w-sm bg-[#0A0A0A] border-l-4 border-[#FFE500] z-50 flex flex-col p-10 pt-20">
      <button id="close-nav"
        class="absolute top-6 right-6 w-10 h-10 border-2 border-[#FFE500] flex items-center justify-center text-[#FFE500] text-xl font-bold hover:bg-[#FFE500] hover:text-[#0A0A0A] transition-colors">✕</button>
      <ul class="list-none flex flex-col gap-6 mt-4">
        <li><a href="/work"      class="font-brutal text-[#FFE500] text-5xl tracking-widest uppercase opacity-90 hover:opacity-100 no-underline block">Work</a></li>
        <li><a href="/studio"    class="font-brutal text-[#FFE500] text-5xl tracking-widest uppercase opacity-100 no-underline block border-b-2 border-[#FFE500] pb-2">Studio</a></li>
        <li><a href="/#services" class="font-brutal text-[#FFE500] text-5xl tracking-widest uppercase opacity-90 hover:opacity-100 no-underline block">Services</a></li>
        <li><a href="/journal"   class="font-brutal text-[#FFE500] text-5xl tracking-widest uppercase opacity-90 hover:opacity-100 no-underline block">Journal</a></li>
      </ul>
      <div class="mt-auto">
        <a href="/#contact"
          class="block text-center bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-sm uppercase tracking-widest px-6 py-4 border-2 border-[#FFE500] no-underline hover:opacity-90 transition-opacity">
          Let's Talk →
        </a>
        <p class="text-[#FFE500] font-body text-xs opacity-40 uppercase tracking-widest mt-6">hello@storytale.id</p>
      </div>
    </div>

    <div id="nav-overlay" class="fixed inset-0 bg-black/50 z-40 hidden opacity-0 transition-opacity duration-300"></div>
  </header>


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
      STUDIO
    </div>

    <div id="hero-content" class="relative z-10 max-w-[1440px] mx-auto px-6 lg:px-12 py-16 lg:py-20" style="opacity:0;">

      <!-- Breadcrumb -->
      <div class="flex items-center gap-3 mb-6">
        <a href="/" class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-40 hover:opacity-70 no-underline transition-opacity">Home</a>
        <span class="font-body text-xs text-[#0A0A0A] opacity-30">/</span>
        <span class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A]">Studio</span>
      </div>

      <!-- Heading row -->
      <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 border-b-4 border-[#0A0A0A] pb-10">
        <div>
          <span class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-40">§ Who We Are</span>
          <h1 id="studio-hero-heading" class="font-brutal text-[clamp(4rem,10vw,12rem)] uppercase text-[#0A0A0A] leading-none tracking-tight mt-1">
            Our<br/>Studio
          </h1>
          <p id="studio-hero-sub" class="font-body text-sm font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50 mt-3">
            Jakarta, ID — Est. 2017
          </p>
        </div>

        <div class="lg:max-w-sm lg:pb-4">
          <p id="studio-hero-desc" class="font-body text-base text-[#0A0A0A] opacity-60 leading-relaxed font-medium">
            We are a brutalist digital marketing agency obsessed with stories that move people and numbers. Based in Jakarta, built for brands that want to be remembered.
          </p>
        </div>
      </div>
    </div>
  </section>


  <!-- ═══════════════════════════════════
       MISSION SECTION
  ═══════════════════════════════════ -->
  <section id="mission-section" class="bg-[#0A0A0A] border-b-4 border-[#FFE500] py-20 lg:py-32">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">

      <div class="mission-block" style="opacity:0; transform:translateY(40px);">
        <div class="flex gap-0">
          <!-- Yellow accent bar -->
          <div class="w-1.5 bg-[#FFE500] flex-shrink-0 mr-8 lg:mr-16" style="min-height:100%;"></div>

          <div>
            <span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-6 block">Our Mission</span>
            <blockquote id="studio-mission-quote" class="font-brutal text-[#FFE500] leading-none tracking-tight"
              style="font-size: clamp(2.2rem, 5.5vw, 7rem);">
              "We don't make content.<br/>We build stories<br/>that sell."
            </blockquote>
            <p id="studio-mission-desc" class="font-body text-sm text-[#FFE500] opacity-40 mt-8 max-w-lg leading-relaxed">
              Since 2017, we've helped brands across Indonesia cut through the noise — with strategy-led creative that converts attention into action.
            </p>
          </div>
        </div>
      </div>

    </div>
  </section>


  <!-- ═══════════════════════════════════
       STATS ROW
  ═══════════════════════════════════ -->
  <section id="stats-section" class="bg-[#FFE500] border-b-4 border-[#0A0A0A]">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
      <div id="studio-stats-grid" class="grid grid-cols-2 lg:grid-cols-4 border-l-4 border-[#0A0A0A]">

        <div class="stat-item border-r-4 border-b-4 lg:border-b-0 border-[#0A0A0A] py-10 px-8 flex flex-col items-start gap-2" style="opacity:0; transform:translateY(30px);">
          <span class="font-brutal text-[#0A0A0A] leading-none" style="font-size: clamp(3.5rem,7vw,6rem);">87</span>
          <span class="font-body text-[10px] font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50">Projects</span>
        </div>

        <div class="stat-item border-r-4 border-b-4 lg:border-b-0 border-[#0A0A0A] py-10 px-8 flex flex-col items-start gap-2" style="opacity:0; transform:translateY(30px);">
          <span class="font-brutal text-[#0A0A0A] leading-none" style="font-size: clamp(3.5rem,7vw,6rem);">6+</span>
          <span class="font-body text-[10px] font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50">Years</span>
        </div>

        <div class="stat-item border-r-4 border-[#0A0A0A] py-10 px-8 flex flex-col items-start gap-2" style="opacity:0; transform:translateY(30px);">
          <span class="font-brutal text-[#0A0A0A] leading-none" style="font-size: clamp(3.5rem,7vw,6rem);">8</span>
          <span class="font-body text-[10px] font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50">Services</span>
        </div>

        <div class="stat-item border-r-4 border-[#0A0A0A] py-10 px-8 flex flex-col items-start gap-2" style="opacity:0; transform:translateY(30px);">
          <span class="font-brutal text-[#0A0A0A] leading-none" style="font-size: clamp(3.5rem,7vw,6rem);">★4</span>
          <span class="font-body text-[10px] font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50">Awards</span>
        </div>

      </div>
    </div>
  </section>


  <!-- ═══════════════════════════════════
       TEAM SECTION
  ═══════════════════════════════════ -->
  <section id="team-section" class="bg-[#FFE500] border-b-4 border-[#0A0A0A] py-20 lg:py-28">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">

      <!-- Section header -->
      <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 border-b-4 border-[#0A0A0A] pb-10 mb-12">
        <div>
          <span class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-40">§ The People</span>
          <h2 class="font-brutal text-[clamp(2.5rem,6vw,7rem)] text-[#0A0A0A] leading-none tracking-tight mt-1 uppercase">
            Our Team
          </h2>
        </div>
        <p class="font-body text-sm text-[#0A0A0A] opacity-50 max-w-xs leading-relaxed">
          A small but fierce crew of strategists, creatives, and technologists.
        </p>
      </div>

      <!-- Team grid -->
      <div id="team-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-0 border-2 border-[#0A0A0A]">
        <!-- Cards injected by JS -->
        <div id="team-loading" style="grid-column:1/-1; display:flex; align-items:center; justify-content:center; padding:5rem 0;">
          <span class="font-brutal text-[#0A0A0A] text-3xl tracking-widest opacity-20">Loading...</span>
        </div>
      </div>

    </div>
  </section>


  <!-- ═══════════════════════════════════
       PROCESS SECTION
  ═══════════════════════════════════ -->
  <section id="process-section" class="bg-[#0A0A0A] border-b-4 border-[#FFE500] py-20 lg:py-28">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">

      <!-- Section header -->
      <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 border-b-4 border-[#FFE500] border-opacity-20 pb-10 mb-16">
        <div>
          <span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-40">§ Our Approach</span>
          <h2 class="font-brutal text-[clamp(2.5rem,6vw,7rem)] text-[#FFE500] leading-none tracking-tight mt-1 uppercase">
            How We Work
          </h2>
        </div>
        <p class="font-body text-sm text-[#FFE500] opacity-40 max-w-xs leading-relaxed">
          Every project follows a disciplined process built for results — not just aesthetics.
        </p>
      </div>

      <!-- Timeline / steps — populated by JS from /api/settings -->
      <div class="process-track" id="process-track">

        <div class="process-step border-2 border-[#FFE500] border-opacity-10 p-8 lg:p-10 relative" style="opacity:0; transform:translateY(30px);">
          <div class="w-16 h-16 border-2 border-[#FFE500] flex items-center justify-center mb-6">
            <span class="font-brutal text-[#FFE500] text-3xl leading-none">01</span>
          </div>
          <h3 class="font-brutal text-[#FFE500] text-3xl lg:text-4xl tracking-widest uppercase leading-none mb-3">Discover</h3>
          <p class="font-body text-sm text-[#FFE500] opacity-40 leading-relaxed">
            We audit your brand, audience, and competitors. Deep listening before any strategy or creative is touched.
          </p>
          <div class="mt-6 pt-6 border-t border-[#FFE500] border-opacity-10">
            <span class="font-body text-[10px] font-bold uppercase tracking-widest text-[#FFE500] opacity-25">Brand Audit · Market Research · Audience Analysis</span>
          </div>
        </div>

        <div class="process-step border-2 border-t-0 lg:border-t-2 lg:border-l-0 border-[#FFE500] border-opacity-10 p-8 lg:p-10 relative" style="opacity:0; transform:translateY(30px);">
          <div class="w-16 h-16 border-2 border-[#FFE500] flex items-center justify-center mb-6">
            <span class="font-brutal text-[#FFE500] text-3xl leading-none">02</span>
          </div>
          <h3 class="font-brutal text-[#FFE500] text-3xl lg:text-4xl tracking-widest uppercase leading-none mb-3">Strategise</h3>
          <p class="font-body text-sm text-[#FFE500] opacity-40 leading-relaxed">
            We build a data-backed roadmap — channels, messaging, budget allocation, and content frameworks.
          </p>
          <div class="mt-6 pt-6 border-t border-[#FFE500] border-opacity-10">
            <span class="font-body text-[10px] font-bold uppercase tracking-widest text-[#FFE500] opacity-25">Channel Strategy · Messaging · KPI Setting</span>
          </div>
        </div>

        <div class="process-step border-2 border-t-0 lg:border-t-2 lg:border-l-0 border-[#FFE500] border-opacity-10 p-8 lg:p-10 relative" style="opacity:0; transform:translateY(30px);">
          <div class="w-16 h-16 border-2 border-[#FFE500] flex items-center justify-center mb-6">
            <span class="font-brutal text-[#FFE500] text-3xl leading-none">03</span>
          </div>
          <h3 class="font-brutal text-[#FFE500] text-3xl lg:text-4xl tracking-widest uppercase leading-none mb-3">Execute</h3>
          <p class="font-body text-sm text-[#FFE500] opacity-40 leading-relaxed">
            Creative production, campaign launch, and real-time optimisation — everything on brief, on budget.
          </p>
          <div class="mt-6 pt-6 border-t border-[#FFE500] border-opacity-10">
            <span class="font-body text-[10px] font-bold uppercase tracking-widest text-[#FFE500] opacity-25">Creative · Launch · Optimisation</span>
          </div>
        </div>

        <div class="process-step border-2 border-t-0 lg:border-t-2 lg:border-l-0 border-[#FFE500] border-opacity-10 p-8 lg:p-10 relative" style="opacity:0; transform:translateY(30px);">
          <div class="w-16 h-16 border-2 border-[#FFE500] flex items-center justify-center mb-6">
            <span class="font-brutal text-[#FFE500] text-3xl leading-none">04</span>
          </div>
          <h3 class="font-brutal text-[#FFE500] text-3xl lg:text-4xl tracking-widest uppercase leading-none mb-3">Measure</h3>
          <p class="font-body text-sm text-[#FFE500] opacity-40 leading-relaxed">
            We report what actually matters — ROAS, pipeline, retention — and iterate until the numbers move.
          </p>
          <div class="mt-6 pt-6 border-t border-[#FFE500] border-opacity-10">
            <span class="font-body text-[10px] font-bold uppercase tracking-widest text-[#FFE500] opacity-25">Analytics · Reporting · Iteration</span>
          </div>
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
            Let's Build<br/>Something<br/>Together.
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
            <a href="mailto:hello@storytale.id" data-contact-email
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
  <footer class="bg-[#FFE500] border-t-4 border-[#0A0A0A] py-8">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12 flex flex-col sm:flex-row items-center justify-between gap-4">
      <div class="flex items-center gap-2">
        <div class="w-7 h-7 bg-[#0A0A0A] flex items-center justify-center">
          <span class="text-[#FFE500] font-brutal text-base leading-none">S</span>
        </div>
        <span class="font-brutal text-lg tracking-widest text-[#0A0A0A] uppercase leading-none">STORYTALE</span>
      </div>
      <span class="font-body text-[10px] font-bold uppercase tracking-widest text-[#0A0A0A] opacity-40">
        © 2026 Storytale. All rights reserved. Jakarta, ID.
      </span>
      <div class="flex items-center gap-6">
        <a href="/"        class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50 hover:opacity-100 no-underline transition-opacity">Home</a>
        <a href="/work"    class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50 hover:opacity-100 no-underline transition-opacity">Work</a>
        <a href="/#contact" class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50 hover:opacity-100 no-underline transition-opacity">Contact</a>
      </div>
    </div>
  </footer>


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

      // Mission
      gsap.to('.mission-block', {
        opacity: 1,
        y: 0,
        duration: 0.9,
        ease: 'power3.out',
        scrollTrigger: { trigger: '#mission-section', start: 'top 80%', once: true }
      });

      // Stats
      gsap.to('.stat-item', {
        opacity: 1,
        y: 0,
        duration: 0.6,
        stagger: 0.1,
        ease: 'power2.out',
        scrollTrigger: { trigger: '#stats-section', start: 'top 85%', once: true }
      });

      // Process steps
      gsap.to('#process-track .process-step', {
        opacity: 1,
        y: 0,
        duration: 0.6,
        stagger: 0.12,
        ease: 'power2.out',
        scrollTrigger: { trigger: '#process-section', start: 'top 80%', once: true }
      });

      // Load team + studio settings
      loadTeam();
      loadStudioSettings();
    }


    // ── Studio settings from CMS ───────────────────────────
    function buildStatItem(stat, i) {
      const borders = [
        'border-r-4 border-b-4 lg:border-b-0',
        'border-r-4 border-b-4 lg:border-b-0',
        'border-r-4',
        'border-r-4',
      ];
      const b = borders[i] || 'border-r-4';
      const d = document.createElement('div');
      d.className = `stat-item ${b} border-[#0A0A0A] py-10 px-8 flex flex-col items-start gap-2`;
      d.style.cssText = 'opacity:0; transform:translateY(30px);';
      d.innerHTML = `
        <span class="font-brutal text-[#0A0A0A] leading-none" style="font-size: clamp(3.5rem,7vw,6rem);">${stat.val}</span>
        <span class="font-body text-[10px] font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50">${stat.label}</span>
      `;
      return d;
    }

    function buildProcessStep(step, i) {
      const borderClass = i === 0
        ? 'border-2 border-[#FFE500] border-opacity-10'
        : 'border-2 border-t-0 lg:border-t-2 lg:border-l-0 border-[#FFE500] border-opacity-10';
      const d = document.createElement('div');
      d.className = `process-step ${borderClass} p-8 lg:p-10 relative`;
      d.style.cssText = 'opacity:0; transform:translateY(30px);';
      d.innerHTML = `
        <div class="w-16 h-16 border-2 border-[#FFE500] flex items-center justify-center mb-6">
          <span class="font-brutal text-[#FFE500] text-3xl leading-none">${step.num}</span>
        </div>
        <h3 class="font-brutal text-[#FFE500] text-3xl lg:text-4xl tracking-widest uppercase leading-none mb-3">${step.title}</h3>
        <p class="font-body text-sm text-[#FFE500] opacity-40 leading-relaxed">${step.desc}</p>
      `;
      return d;
    }

    function loadStudioSettings() {
      fetch('/api/settings')
        .then(r => r.json())
        .then(cfg => {
          const s = cfg.studio || {};

          // Hero
          if (s.hero_heading) {
            const el = document.getElementById('studio-hero-heading');
            if (el) el.innerHTML = s.hero_heading.replace(/\s/g, '<br/>');
          }
          if (s.hero_sub) {
            const el = document.getElementById('studio-hero-sub');
            if (el) el.textContent = s.hero_sub;
          }
          if (s.mission_desc) {
            const el = document.getElementById('studio-hero-desc');
            if (el) el.textContent = s.mission_desc;
          }

          // Mission quote
          if (s.mission_quote) {
            const el = document.getElementById('studio-mission-quote');
            if (el) el.innerHTML = '"' + s.mission_quote.replace(/\n/g, '<br/>') + '"';
          }
          if (s.founded_text) {
            const el = document.getElementById('studio-mission-desc');
            if (el) el.textContent = s.founded_text;
          }

          // Stats
          if (s.stats && s.stats.length) {
            const grid = document.getElementById('studio-stats-grid');
            if (grid) {
              grid.innerHTML = '';
              s.stats.forEach((stat, i) => grid.appendChild(buildStatItem(stat, i)));
              // Re-trigger animation
              gsap.to('#studio-stats-grid .stat-item', {
                opacity: 1, y: 0, duration: 0.6, stagger: 0.1, ease: 'power2.out',
                scrollTrigger: { trigger: '#stats-section', start: 'top 85%', once: true }
              });
            }
          }

          // Process steps
          if (s.process && s.process.length) {
            const track = document.getElementById('process-track');
            if (track) {
              track.innerHTML = '';
              s.process.forEach((step, i) => track.appendChild(buildProcessStep(step, i)));
              gsap.to('#process-track .process-step', {
                opacity: 1, y: 0, duration: 0.6, stagger: 0.12, ease: 'power2.out',
                scrollTrigger: { trigger: '#process-section', start: 'top 80%', once: true }
              });
            }
          }

          // Contact email in CTA section
          if (cfg.contact && cfg.contact.email) {
            document.querySelectorAll('a[data-contact-email]').forEach(el => {
              el.href = 'mailto:' + cfg.contact.email;
              el.textContent = cfg.contact.email;
            });
          }
        })
        .catch(() => {});
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


    // ── Team ───────────────────────────────────────────────
    const TEAM_FALLBACK = [
      {
        name: 'Andi Pratama',
        role: 'Founder & Creative Director',
        bio: 'Leads the creative vision and overall strategy. 10+ years in digital marketing across FMCG, retail, and tech brands.',
      },
      {
        name: 'Sari Dewi',
        role: 'Head of Content Strategy',
        bio: 'Turns brand briefs into content ecosystems. Expert in editorial planning, copywriting, and multi-channel storytelling.',
      },
      {
        name: 'Rizky Maulana',
        role: 'Paid Media Specialist',
        bio: 'Manages performance campaigns on Meta, Google, and TikTok. Obsessed with ROAS, attribution, and audience architecture.',
      },
      {
        name: 'Nadia Kusuma',
        role: 'Social Media Manager',
        bio: 'Drives organic growth and community building. Skilled in social listening, trend-jacking, and creator partnerships.',
      },
    ];

    function getInitials(name) {
      return name.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase();
    }

    function buildTeamCard(member) {
      const initials = getInitials(member.name);
      const card = document.createElement('div');
      card.className = 'team-card border-r-2 border-b-2 border-[#0A0A0A] p-8 flex flex-col gap-5 bg-[#FFE500]';
      card.style.opacity = '0';
      card.style.transform = 'translateY(24px)';

      card.innerHTML = `
        <div class="flex items-start gap-5">
          <div class="team-avatar">${initials}</div>
          <div class="flex flex-col gap-1 pt-1">
            <span class="font-brutal text-[#0A0A0A] text-2xl leading-none tracking-wide uppercase">${member.name}</span>
            <span class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50">${member.role}</span>
          </div>
        </div>
        <p class="font-body text-sm text-[#0A0A0A] opacity-60 leading-relaxed border-t-2 border-[#0A0A0A] pt-5">${member.bio}</p>
      `;

      return card;
    }

    function renderTeam(members) {
      const grid = document.getElementById('team-grid');
      grid.innerHTML = '';

      members.forEach(m => grid.appendChild(buildTeamCard(m)));

      gsap.to('.team-card', {
        opacity: 1,
        y: 0,
        duration: 0.55,
        stagger: 0.1,
        ease: 'power2.out',
        scrollTrigger: { trigger: '#team-section', start: 'top 80%', once: true }
      });
    }

    function loadTeam() {
      fetch('/api/team')
        .then(r => { if (!r.ok) throw new Error(); return r.json(); })
        .then(data => renderTeam(data))
        .catch(() => renderTeam(TEAM_FALLBACK));
    }

  })();
  </script>

</body>
</html>
