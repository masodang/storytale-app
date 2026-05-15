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
    
    
    
    
    
    
    @keyframes marquee{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}
    
    
    
    .nav-link:hover::after,
    
    
    
    
    @keyframes scan{0%{top:0%;opacity:.6}100%{top:100%;opacity:0}}
    
    
    
    
    
    .service-card>
    
    
    
    
    
    
    
    
    

    
    
    
    
    
    
    
    
    
    
    
    
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

  @include('partials.header')

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
  @include('partials.footer')

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
          card.className='wt';
          card.style.cssText='aspect-ratio:4/3;opacity:0;transform:translateY(24px);';
          const imgHtml=hasCover
            ?`<img src="${p.cover_image}" alt="${p.title}" loading="lazy" class="wt-img"/>`
            :`<div class="wt-placeholder"><span style="font-family:'Bebas Neue',sans-serif;font-size:clamp(2rem,4vw,4rem);color:rgba(255,229,0,0.06);">${(cat.name||'WORK').toUpperCase()}</span></div>`;
          card.innerHTML=`
            ${imgHtml}
            <div class="wt-overlay"></div>
            <div class="wt-content">
              ${cat.name?`<div class="wt-tag">${cat.name}</div>`:''}
              <div class="wt-title">${p.title}</div>
              ${p.client?`<div class="wt-client">${p.client}</div>`:''}
              <div class="wt-cta">View Project →</div>
            </div>
            <div class="wt-baseline">
              <div class="wt-baseline-title">${p.title}</div>
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
