<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Services — STORYTALE</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=Bebas+Neue&display=swap" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config={theme:{extend:{fontFamily:{brutal:['Bebas Neue','sans-serif'],body:['Space Grotesk','sans-serif']},boxShadow:{brutal:'4px 4px 0px #0A0A0A','brutal-lg':'8px 8px 0px #0A0A0A'}}}}</script>
  <style>
    *{box-sizing:border-box;margin:0;padding:0;}
    body{background:#FFE500;color:#0A0A0A;font-family:'Space Grotesk',sans-serif;overflow:hidden;}
    body::before{content:'';position:fixed;inset:0;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");pointer-events:none;z-index:9999;}
    ::-webkit-scrollbar{width:8px}::-webkit-scrollbar-track{background:#FFE500}::-webkit-scrollbar-thumb{background:#0A0A0A}
    .burger-line{display:block;width:28px;height:3px;background:#0A0A0A;transition:all .25s ease;transform-origin:center}
    .burger-open .burger-line:nth-child(1){transform:translateY(9px) rotate(45deg)}.burger-open .burger-line:nth-child(2){opacity:0;transform:scaleX(0)}.burger-open .burger-line:nth-child(3){transform:translateY(-9px) rotate(-45deg)}
    @keyframes marquee{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}
    .marquee-track{animation:marquee 14s linear infinite}
    #mobile-nav{transform:translateX(100%);transition:transform .3s cubic-bezier(.77,0,.175,1)}
    #mobile-nav.open{transform:translateX(0)}
    .nav-link{position:relative;overflow:hidden}.nav-link::after{content:'';position:absolute;bottom:-2px;left:0;width:100%;height:3px;background:#0A0A0A;transform:scaleX(0);transform-origin:left;transition:transform .2s ease}.nav-link:hover::after,.nav-link.active::after{transform:scaleX(1)}
    #preloader{position:fixed;inset:0;z-index:10000;background:#0A0A0A;display:flex;flex-direction:column;overflow:hidden}
    #preloader::before{content:'';position:absolute;inset:0;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.06'/%3E%3C/svg%3E");pointer-events:none;z-index:0}
    .pre-inner{position:relative;z-index:1}
    #preloader-count{font-family:'Bebas Neue',sans-serif;color:#FFE500;font-size:clamp(8rem,24vw,24rem);line-height:.82;letter-spacing:-.02em}
    @keyframes scan{0%{top:0%;opacity:.6}100%{top:100%;opacity:0}}
    #preloader-scan{position:absolute;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,rgba(255,229,0,.3),transparent);animation:scan 1.8s linear infinite;z-index:2}
    .pre-bracket{position:absolute;width:40px;height:40px;border-color:rgba(255,229,0,.2);border-style:solid}
    .pre-bracket-tl{top:20px;left:20px;border-width:3px 0 0 3px}.pre-bracket-tr{top:20px;right:20px;border-width:3px 3px 0 0}.pre-bracket-bl{bottom:20px;left:20px;border-width:0 0 3px 3px}.pre-bracket-br{bottom:20px;right:20px;border-width:0 3px 3px 0}
    .service-card{position:relative;overflow:hidden;background:#0A0A0A;padding:2.5rem 2rem 2rem;border:2px solid #111;min-height:360px;display:flex;flex-direction:column;justify-content:space-between;cursor:pointer}
    .service-card::before{content:'';position:absolute;inset:0;background:var(--sc);transform:translateY(-101%);transition:transform .48s cubic-bezier(.77,0,.175,1);z-index:0}
    .service-card:hover::before{transform:translateY(0)}.service-card>*{position:relative;z-index:1}
    .sc-bar{width:40px;height:4px;background:var(--sc);margin-bottom:1.75rem;transition:width .3s ease,background .3s ease}.service-card:hover .sc-bar{width:64px;background:rgba(0,0,0,.25)}
    .sc-num{position:absolute;top:1.25rem;right:1.5rem;font-family:'Bebas Neue',sans-serif;font-size:clamp(5rem,8vw,9rem);line-height:1;color:rgba(255,229,0,.05);pointer-events:none;transition:color .3s ease}.service-card:hover .sc-num{color:rgba(0,0,0,.08)}
    .sc-name{font-family:'Bebas Neue',sans-serif;font-size:clamp(2.2rem,3.2vw,3.4rem);letter-spacing:.04em;line-height:.92;color:#FFE500;transition:color .3s ease}.service-card:hover .sc-name{color:#0A0A0A}
    .sc-desc{font-family:'Space Grotesk',sans-serif;font-size:.82rem;line-height:1.65;color:rgba(255,229,0,.45);margin-top:.75rem;transition:color .3s ease}.service-card:hover .sc-desc{color:rgba(0,0,0,.65)}
    .sc-list{list-style:none;margin-top:1.5rem;display:flex;flex-direction:column;gap:.45rem}
    .sc-list li{font-family:'Space Grotesk',sans-serif;font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.18em;color:rgba(255,229,0,.3);display:flex;align-items:center;gap:.6rem;transition:color .3s ease}
    .sc-list li::before{content:'';width:18px;height:2px;background:currentColor;flex-shrink:0}.service-card:hover .sc-list li{color:rgba(0,0,0,.45)}
    .sc-cta{margin-top:2rem;display:inline-flex;align-items:center;gap:.5rem;font-family:'Space Grotesk',sans-serif;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.2em;color:#FFE500;border:2px solid rgba(255,229,0,.2);padding:8px 18px;text-decoration:none;width:fit-content;transition:color .3s ease,border-color .3s ease}
    .service-card:hover .sc-cta{color:#0A0A0A;border-color:rgba(0,0,0,.3)}
  </style>
</head>
<body>
  <div id="preloader">
    <div id="preloader-scan"></div>
    <div class="pre-bracket pre-bracket-tl"></div><div class="pre-bracket pre-bracket-tr"></div>
    <div class="pre-bracket pre-bracket-bl"></div><div class="pre-bracket pre-bracket-br"></div>
    <div class="pre-inner" style="padding:2rem 2.5rem;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,229,0,.08);">
      <span style="font-family:'Bebas Neue',sans-serif;color:#FFE500;font-size:1.4rem;letter-spacing:.2em;">STORYTALE</span>
      <span style="font-family:'Space Grotesk',sans-serif;color:#FFE500;font-size:.6rem;opacity:.3;letter-spacing:.35em;text-transform:uppercase;">Services</span>
    </div>
    <div class="pre-inner" style="flex:1;display:flex;flex-direction:column;justify-content:center;padding:0 2.5rem;">
      <div style="font-family:'Space Grotesk',sans-serif;color:rgba(255,229,0,.35);font-size:.6rem;letter-spacing:.5em;text-transform:uppercase;margin-bottom:.75rem;">Loading</div>
      <div id="preloader-count">100</div>
      <div style="font-family:'Space Grotesk',sans-serif;color:rgba(255,229,0,.2);font-size:.65rem;letter-spacing:.3em;text-transform:uppercase;margin-top:1.5rem;">8 Disciplines. One Agency.</div>
    </div>
    <div class="pre-inner" style="padding:1.5rem 2.5rem 2rem;">
      <div style="height:2px;background:rgba(255,229,0,.1);position:relative;overflow:hidden;margin-bottom:.6rem;">
        <div id="preloader-bar" style="height:100%;width:0%;background:#FFE500;position:absolute;left:0;top:0;"></div>
      </div>
      <div style="display:flex;justify-content:space-between;align-items:center;">
        <span style="font-family:'Space Grotesk',sans-serif;color:#FFE500;font-size:.6rem;opacity:.25;letter-spacing:.35em;text-transform:uppercase;">Jakarta, ID</span>
        <span id="preloader-pct" style="font-family:'Space Grotesk',sans-serif;color:#FFE500;font-size:.6rem;opacity:.35;letter-spacing:.25em;font-weight:700;">0%</span>
      </div>
    </div>
  </div>

  <header id="site-header" class="fixed top-0 left-0 right-0 z-50 bg-[#FFE500] border-b-4 border-[#0A0A0A]">
    <div class="bg-[#0A0A0A] text-[#FFE500] overflow-hidden py-1"><div class="flex whitespace-nowrap"><div class="marquee-track flex gap-0 font-body text-xs font-bold tracking-widest uppercase"><span class="px-8">★ Stories That Sell</span><span class="px-8">★ Digital Marketing</span><span class="px-8">★ 8 Disciplines</span><span class="px-8">★ Content × Strategy</span><span class="px-8">★ Stories That Sell</span><span class="px-8">★ Digital Marketing</span><span class="px-8">★ 8 Disciplines</span><span class="px-8">★ Content × Strategy</span></div></div></div>
    <nav class="max-w-[1440px] mx-auto px-6 lg:px-12 flex items-center justify-between h-[72px]">
      <a href="/" class="flex items-center gap-2 no-underline"><div class="w-9 h-9 bg-[#0A0A0A] border-2 border-[#0A0A0A] flex items-center justify-center"><span class="text-[#FFE500] font-brutal text-xl leading-none">S</span></div><span class="font-brutal text-2xl tracking-widest text-[#0A0A0A] uppercase leading-none">STORYTALE</span></a>
      <ul class="hidden lg:flex items-center gap-8 list-none">
        <li><a href="/work" class="nav-link font-body font-bold text-sm uppercase tracking-widest text-[#0A0A0A] no-underline">Work</a></li>
        <li><a href="/studio" class="nav-link font-body font-bold text-sm uppercase tracking-widest text-[#0A0A0A] no-underline">Studio</a></li>
        <li><a href="/services" class="nav-link active font-body font-bold text-sm uppercase tracking-widest text-[#0A0A0A] no-underline">Services</a></li>
        <li><a href="/journal" class="nav-link font-body font-bold text-sm uppercase tracking-widest text-[#0A0A0A] no-underline">Journal</a></li>
      </ul>
      <div class="hidden lg:flex items-center gap-4">
        <a id="navbar-wa-link" href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="w-9 h-9 bg-[#25D366] border-2 border-[#0A0A0A] flex items-center justify-center text-white hover:translate-x-[2px] hover:translate-y-[2px] transition-all duration-150 shadow-brutal hover:shadow-none no-underline flex-shrink-0" title="Chat on WhatsApp"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg></a>
        <a href="/#contact" class="inline-block bg-[#0A0A0A] text-[#FFE500] font-body font-bold text-sm uppercase tracking-widest px-6 py-3 border-2 border-[#0A0A0A] shadow-brutal hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-150 no-underline">Let's Talk →</a>
      </div>
      <button id="burger-btn" class="lg:hidden flex flex-col gap-[6px] p-2 border-2 border-[#0A0A0A] bg-[#FFE500] hover:bg-[#0A0A0A] group transition-colors duration-150 focus:outline-none" aria-label="Toggle menu"><span class="burger-line group-hover:bg-[#FFE500]"></span><span class="burger-line group-hover:bg-[#FFE500]"></span><span class="burger-line group-hover:bg-[#FFE500]"></span></button>
    </nav>
    <div id="mobile-nav" class="fixed top-0 right-0 h-screen w-4/5 max-w-sm bg-[#0A0A0A] border-l-4 border-[#FFE500] z-50 flex flex-col p-10 pt-20">
      <button id="close-nav" class="absolute top-6 right-6 w-10 h-10 border-2 border-[#FFE500] flex items-center justify-center text-[#FFE500] text-xl font-bold hover:bg-[#FFE500] hover:text-[#0A0A0A] transition-colors">✕</button>
      <ul class="list-none flex flex-col gap-6 mt-4">
        <li><a href="/work" class="font-brutal text-[#FFE500] text-5xl tracking-widest uppercase opacity-90 hover:opacity-100 no-underline block">Work</a></li>
        <li><a href="/studio" class="font-brutal text-[#FFE500] text-5xl tracking-widest uppercase opacity-90 hover:opacity-100 no-underline block">Studio</a></li>
        <li><a href="/services" class="font-brutal text-[#FFE500] text-5xl tracking-widest uppercase opacity-100 no-underline block border-b-2 border-[#FFE500] pb-2">Services</a></li>
        <li><a href="/journal" class="font-brutal text-[#FFE500] text-5xl tracking-widest uppercase opacity-90 hover:opacity-100 no-underline block">Journal</a></li>
      </ul>
      <div class="mt-auto"><a href="/#contact" class="block text-center bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-sm uppercase tracking-widest px-6 py-4 border-2 border-[#FFE500] no-underline">Let's Talk →</a></div>
    </div>
    <div id="nav-overlay" class="fixed inset-0 bg-black/50 z-40 hidden opacity-0 transition-opacity duration-300"></div>
  </header>

  <!-- HERO -->
  <section id="page-hero" class="relative bg-[#FFE500] border-b-4 border-[#0A0A0A] overflow-hidden" style="padding-top:var(--header-h,100px);">
    <div class="absolute inset-0 pointer-events-none" style="background-image:repeating-linear-gradient(0deg,transparent,transparent 79px,rgba(10,10,10,.07) 79px,rgba(10,10,10,.07) 80px),repeating-linear-gradient(90deg,transparent,transparent 79px,rgba(10,10,10,.07) 79px,rgba(10,10,10,.07) 80px);"></div>
    <div class="absolute right-6 lg:right-16 bottom-0 font-brutal text-[#0A0A0A] opacity-[0.04] leading-none select-none pointer-events-none" style="font-size:clamp(10rem,28vw,30rem);line-height:.8;">SERVICES</div>
    <div id="hero-content" class="relative z-10 max-w-[1440px] mx-auto px-6 lg:px-12 py-16 lg:py-20" style="opacity:0;">
      <div class="flex items-center gap-3 mb-6"><a href="/" class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-40 hover:opacity-70 no-underline transition-opacity">Home</a><span class="text-[#0A0A0A] opacity-30 text-xs">/</span><span class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A]">Services</span></div>
      <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 border-b-4 border-[#0A0A0A] pb-10">
        <div>
          <span class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-40">§ What We Do</span>
          <h1 class="font-brutal text-[clamp(4rem,10vw,12rem)] uppercase text-[#0A0A0A] leading-none tracking-tight mt-1">Our<br/>Services</h1>
        </div>
        <div class="lg:max-w-sm lg:pb-4">
          <p class="font-body text-base text-[#0A0A0A] opacity-60 leading-relaxed font-medium">Eight disciplines designed to grow your brand — from performance ads and rich media to AI-powered apps and full websites.</p>
          <div class="flex gap-0 border-2 border-[#0A0A0A] shadow-brutal mt-6 w-fit">
            <div class="flex flex-col items-center justify-center px-6 py-4 border-r-2 border-[#0A0A0A]"><span class="font-brutal text-4xl text-[#0A0A0A] leading-none">8</span><span class="font-body text-[9px] font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50 mt-1">Disciplines</span></div>
            <div class="flex flex-col items-center justify-center px-6 py-4"><span class="font-brutal text-4xl text-[#0A0A0A] leading-none">87+</span><span class="font-body text-[9px] font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50 mt-1">Projects</span></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SERVICES GRID -->
  <section class="bg-[#FFE500] border-b-4 border-[#0A0A0A] pt-12 pb-28">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
      <div id="services-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-[3px]">
        <!-- filled by JS from API or fallback -->
      </div>
    </div>
  </section>

  <!-- WORK HIGHLIGHT -->
  <section class="bg-[#0A0A0A] border-b-4 border-[#FFE500] pt-20 pb-28 lg:pt-28">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">

      <div class="flex items-end justify-between border-b-4 border-[rgba(255,229,0,0.1)] pb-6 mb-10">
        <div>
          <span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-40">§ Our Work</span>
          <h2 class="font-brutal text-[clamp(3rem,7vw,8rem)] text-[#FFE500] leading-none tracking-tight uppercase mt-1">Selected<br/>Projects</h2>
        </div>
        <a href="/work" class="hidden lg:inline-block bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-xs uppercase tracking-widest px-5 py-3 border-2 border-[#FFE500] shadow-brutal hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-150 no-underline pb-3">View All Work →</a>
      </div>

      <div id="work-highlight-grid" class="grid grid-cols-1 md:grid-cols-3 gap-[3px]">
        <!-- filled by JS -->
        <div style="grid-column:1/-1;padding:3rem 0;text-align:center;">
          <span class="font-brutal text-[#FFE500] text-2xl tracking-widest opacity-20">Loading…</span>
        </div>
      </div>

      <div class="mt-8 lg:hidden">
        <a href="/work" class="block text-center bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-sm uppercase tracking-widest px-8 py-4 border-2 border-[#FFE500] no-underline">View All Work →</a>
      </div>

    </div>
  </section>


  <!-- CTA -->
  <section class="bg-[#0A0A0A] py-20 lg:py-28">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12 flex flex-col lg:flex-row lg:items-center justify-between gap-10">
      <div><span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-40">Ready to start?</span><h2 class="font-brutal text-[clamp(2.5rem,6vw,7rem)] text-[#FFE500] leading-none tracking-tight mt-2 uppercase">Let's Work<br/>Together.</h2></div>
      <div class="flex flex-wrap gap-4"><a href="/#contact" class="inline-block bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-sm uppercase tracking-widest px-8 py-4 border-2 border-[#FFE500] hover:bg-transparent hover:text-[#FFE500] transition-all duration-150 no-underline">Start a Project →</a><a href="/work" class="inline-block bg-transparent text-[#FFE500] font-body font-bold text-sm uppercase tracking-widest px-8 py-4 border-2 border-[rgba(255,229,0,0.3)] hover:border-[#FFE500] transition-all duration-150 no-underline">See Our Work →</a></div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="bg-[#FFE500] border-t-4 border-[#0A0A0A] py-8">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12 flex flex-col sm:flex-row items-center justify-between gap-4">
      <div class="flex items-center gap-2"><div class="w-7 h-7 bg-[#0A0A0A] flex items-center justify-center"><span class="font-brutal text-[#FFE500] text-base leading-none">S</span></div><span class="font-brutal text-lg tracking-widest text-[#0A0A0A] uppercase leading-none">STORYTALE</span></div>
      <span class="font-body text-[10px] font-bold uppercase tracking-widest text-[#0A0A0A] opacity-40">© 2026 Storytale. All rights reserved.</span>
      <div class="flex items-center gap-6"><a href="/work" class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50 hover:opacity-100 no-underline transition-opacity">Work</a><a href="/services" class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] no-underline">Services</a><a href="/#contact" class="font-body text-xs font-bold uppercase tracking-widest text-[#0A0A0A] opacity-50 hover:opacity-100 no-underline transition-opacity">Contact</a></div>
    </div>
  </footer>

  <script>
  (function(){
    const header=document.getElementById('site-header');
    function syncH(){document.documentElement.style.setProperty('--header-h',header.getBoundingClientRect().height+'px');}
    syncH();window.addEventListener('resize',syncH);

    const countEl=document.getElementById('preloader-count'),barEl=document.getElementById('preloader-bar'),pctEl=document.getElementById('preloader-pct'),preloader=document.getElementById('preloader'),counter={val:100};
    gsap.to(counter,{val:0,duration:1.8,ease:'power2.inOut',onUpdate(){const v=Math.round(counter.val);countEl.textContent=String(v).padStart(3,'0');barEl.style.width=(100-v)+'%';if(pctEl)pctEl.textContent=(100-v)+'%';},onComplete(){gsap.to(preloader,{yPercent:-105,duration:.9,ease:'expo.inOut',delay:.2,onStart(){gsap.to(barEl,{width:'100%',duration:.1});},onComplete(){preloader.style.display='none';document.body.style.overflow='auto';animateIn();}});}});

    function animateIn(){gsap.registerPlugin(ScrollTrigger);gsap.fromTo('#hero-content',{opacity:0,y:40},{opacity:1,y:0,duration:.8,ease:'power3.out'});loadServices();}

    const burger=document.getElementById('burger-btn'),mobileNav=document.getElementById('mobile-nav'),closeNav=document.getElementById('close-nav'),overlay=document.getElementById('nav-overlay');
    function openMenu(){mobileNav.classList.add('open');overlay.classList.remove('hidden');setTimeout(()=>overlay.classList.add('opacity-100'),10);burger.classList.add('burger-open');document.body.style.overflow='hidden';}
    function closeMenu(){mobileNav.classList.remove('open');overlay.classList.remove('opacity-100');setTimeout(()=>overlay.classList.add('hidden'),300);burger.classList.remove('burger-open');document.body.style.overflow='';}
    burger.addEventListener('click',()=>mobileNav.classList.contains('open')?closeMenu():openMenu());
    closeNav.addEventListener('click',closeMenu);overlay.addEventListener('click',closeMenu);

    const COLORS={'digital-ads':'#FF2D2D','rich-media':'#FF6B00','newsletter':'#9900DD','digital-strategy':'#2255FF','video-ads':'#E91E8C','website':'#00AA50','crm':'#0088CC','ai-apps':'#FFE500'};
    const FALLBACK=[
      {id:1,name:'Digital Ads',slug:'digital-ads',color:'#FF2D2D',description:'Performance campaigns across Search, Display, Social & Programmatic — built for ROAS.',scope_items:['Search & Display Ads','Meta & TikTok Ads','Programmatic Buying','Remarketing & Funnels']},
      {id:2,name:'Rich Media',slug:'rich-media',color:'#FF6B00',description:'Immersive HTML5 ad experiences that stop the scroll and outperform static banners.',scope_items:['Interactive HTML5 Banners','Dynamic Creative Units','Expandable & Video Ads','Landing Page Design']},
      {id:3,name:'Newsletter',slug:'newsletter',color:'#9900DD',description:'Nurture leads into loyal buyers with campaigns that feel personal and on-brand.',scope_items:['Campaign Design & Copy','Automation Flows','List Segmentation','A/B Testing']},
      {id:4,name:'Digital Strategy',slug:'digital-strategy',color:'#2255FF',description:'Data-driven roadmaps connecting audience insights, channels, and KPIs.',scope_items:['Market Research','Channel Planning','12-Month Calendar','KPI Framework']},
      {id:5,name:'Video Ads',slug:'video-ads',color:'#E91E8C',description:'Story-driven video productions for TikTok, Reels, and YouTube.',scope_items:['TikTok & Reels Scripts','YouTube Pre-roll','Motion Graphics','Full Production']},
      {id:6,name:'Website',slug:'website',color:'#00AA50',description:'High-converting web experiences designed from business goals up.',scope_items:['UI/UX Design','Web Development','CRO Strategy','SEO & Performance']},
      {id:7,name:'CRM',slug:'crm',color:'#0088CC',description:'Connect your data, automate your pipeline, and close more deals.',scope_items:['CRM Setup & Migration','Workflow Automation','Customer Segmentation','Dashboard']},
      {id:8,name:'AI Apps',slug:'ai-apps',color:'#FFE500',description:'Custom AI-powered tools that automate work and give you an unfair edge.',scope_items:['AI Chatbots','LLM Integrations','Automation Scripts','Data Pipelines']},
    ];

    function buildCard(s,i){
      const num=String(i+1).padStart(2,'0');
      const d=document.createElement('div');
      d.className='service-card';
      d.style.setProperty('--sc',s.color||'#FFE500');
      const items=(s.scope_items||[]).map(item=>`<li>${item}</li>`).join('');
      d.innerHTML=`<span class="sc-num">${num}</span><div><div class="sc-bar"></div><div class="sc-name">${s.name}</div><p class="sc-desc">${s.description||''}</p><ul class="sc-list">${items}</ul></div><a href="/#contact" class="sc-cta">Start a Project →</a>`;
      return d;
    }

    function loadServices(){
      const grid=document.getElementById('services-grid');
      fetch('/api/services').then(r=>r.json()).then(data=>{
        grid.innerHTML='';
        (data.length?data:FALLBACK).forEach((s,i)=>grid.appendChild(buildCard(s,i)));
        gsap.from('.service-card',{y:60,opacity:0,stagger:.07,duration:.7,ease:'power3.out',scrollTrigger:{trigger:'#services-grid',start:'top 85%',once:true}});
      }).catch(()=>{grid.innerHTML='';FALLBACK.forEach((s,i)=>grid.appendChild(buildCard(s,i)));});
    }

    // Work highlight — 3 featured projects
    function loadWorkHighlight(){
      const grid=document.getElementById('work-highlight-grid');
      fetch('/api/projects').then(r=>r.json()).then(projects=>{
        const featured=projects.filter(p=>p.is_featured).slice(0,3);
        const display=(featured.length>=3?featured:projects.slice(0,3));
        if(!display.length){grid.innerHTML='';return;}
        grid.innerHTML='';
        display.forEach(p=>{
          const cat=p.category||{};
          const color=cat.color||'#FFE500';
          const hasCover=p.cover_image&&p.cover_image.trim();
          const card=document.createElement('a');
          card.href='/work/'+p.slug;
          card.className='block border-2 border-[rgba(255,229,0,0.1)] overflow-hidden group no-underline';
          card.style.cssText='opacity:0;transform:translateY(24px);';
          card.innerHTML=`
            <div style="aspect-ratio:4/3;position:relative;overflow:hidden;background:${color}20;">
              ${hasCover
                ?`<img src="${p.cover_image}" alt="${p.title}" loading="lazy" style="width:100%;height:100%;object-fit:cover;transition:transform .5s ease;" class="group-hover:scale-105"/>`
                :`<div style="position:absolute;inset:0;background:${color};opacity:0.15;"></div>
                  <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                    <span style="font-family:'Bebas Neue',sans-serif;font-size:clamp(3rem,6vw,6rem);color:${color};opacity:0.3;letter-spacing:.04em;">${(cat.name||'WORK').toUpperCase()}</span>
                  </div>`}
              <div style="position:absolute;top:12px;left:12px;">
                <span style="font-family:'Space Grotesk',sans-serif;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.2em;color:${color};background:rgba(10,10,10,.7);padding:4px 10px;border:1px solid ${color}40;">${cat.name||''}</span>
              </div>
            </div>
            <div style="padding:1.5rem;">
              <div style="font-family:'Bebas Neue',sans-serif;font-size:clamp(1.4rem,2.5vw,2rem);color:#FFE500;letter-spacing:.04em;line-height:1.1;">${p.title}</div>
              <div style="font-family:'Space Grotesk',sans-serif;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.2em;color:rgba(255,229,0,.4);margin-top:.5rem;">${p.client||''} ${p.project_year?'· '+p.project_year:''}</div>
              <div style="margin-top:1rem;font-family:'Space Grotesk',sans-serif;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.2em;color:rgba(255,229,0,.5);display:flex;align-items:center;gap:6px;">View Case Study <span style="transition:transform .2s ease;" class="group-hover:translate-x-1">→</span></div>
            </div>`;
          grid.appendChild(card);
        });
        gsap.to('#work-highlight-grid a',{opacity:1,y:0,stagger:.1,duration:.6,ease:'power2.out',scrollTrigger:{trigger:'#work-highlight-grid',start:'top 85%',once:true}});
      }).catch(()=>{document.getElementById('work-highlight-grid').innerHTML='';});
    }

    loadWorkHighlight();
  })();
  </script>
</body>
</html>
