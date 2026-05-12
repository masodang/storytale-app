@extends('admin.layout')
@section('title','Site Settings')
@section('page-title','Site Settings')
@section('page-sub','Navbar · Tickers · Hero · Contact · Studio · Footer')

@push('styles')
<style>
.ss { border:2px solid rgba(255,229,0,0.1); margin-bottom:1.25rem; overflow:hidden; }
.ss-head { background:rgba(255,229,0,0.04); border-bottom:1px solid rgba(255,229,0,0.08); padding:12px 20px; display:flex; align-items:center; gap:10px; cursor:pointer; user-select:none; }
.ss-head:hover { background:rgba(255,229,0,0.07); }
.ss-body { padding:20px; display:none; }
.ss-body.open { display:block; }
.fl { font-family:'Space Grotesk',sans-serif; font-size:.58rem; font-weight:700; text-transform:uppercase; letter-spacing:.3em; color:#FFE500; opacity:.4; display:block; margin-bottom:6px; }
.fi { width:100%; background:transparent; border:2px solid rgba(255,229,0,0.15); color:#FFE500; font-family:'Space Grotesk',sans-serif; font-size:.875rem; padding:9px 13px; outline:none; transition:border-color .15s; }
.fi:focus { border-color:#FFE500; }
.ta { width:100%; background:#050505; border:2px solid rgba(255,229,0,0.15); color:rgba(255,229,0,.8); font-family:'Space Grotesk',sans-serif; font-size:.8rem; padding:9px 13px; outline:none; transition:border-color .15s; resize:vertical; min-height:90px; }
.ta:focus { border-color:#FFE500; }
.fg { margin-bottom:14px; }
.g2 { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.g3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; }
@media(max-width:640px){.g2,.g3{grid-template-columns:1fr;}}
.stat-row,.step-row { display:grid; gap:8px; border:1px solid rgba(255,229,0,0.08); padding:10px; margin-bottom:8px; }
.stat-row { grid-template-columns:100px 1fr; }
.step-row { grid-template-columns:60px 1fr 2fr; }
.chevron { margin-left:auto; transition:transform .2s; font-size:.7rem; color:rgba(255,229,0,.3); }
.ss-head.open .chevron { transform:rotate(180deg); }
</style>
@endpush

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}">
@csrf @method('PUT')

<div class="flex justify-between items-center mb-6">
  <p class="font-body text-xs text-[#FFE500] opacity-40">Click any section header to expand. Save when done.</p>
  <button type="submit" class="bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-sm uppercase tracking-widest px-8 py-3 border-2 border-[#FFE500] hover:bg-transparent hover:text-[#FFE500] transition-all duration-150">
    Save All Settings
  </button>
</div>

{{-- BRAND --}}
<div class="ss"><div class="ss-head open" onclick="tog(this)">
  <svg width="13" height="13" fill="none" stroke="#FFE500" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7H4a2 2 0 00-2 2v6a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/></svg>
  <span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-70">Brand</span>
  <span class="chevron">▼</span>
</div><div class="ss-body open">
  <div class="g2">
    <div class="fg"><label class="fl">Agency Name</label><input type="text" name="brand[name]" value="{{ $settings['brand']['name'] ?? 'STORYTALE' }}" class="fi"/></div>
    <div class="fg"><label class="fl">Tagline</label><input type="text" name="brand[tagline]" value="{{ $settings['brand']['tagline'] ?? 'Stories That Sell' }}" class="fi"/></div>
    <div class="fg"><label class="fl">Year Founded</label><input type="text" name="brand[year]" value="{{ $settings['brand']['year'] ?? '2017' }}" class="fi"/></div>
    <div class="fg"><label class="fl">Location</label><input type="text" name="brand[location]" value="{{ $settings['brand']['location'] ?? 'Jakarta, ID' }}" class="fi"/></div>
  </div>
</div></div>

{{-- NAVBAR --}}
<div class="ss"><div class="ss-head" onclick="tog(this)">
  <svg width="13" height="13" fill="none" stroke="#FFE500" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
  <span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-70">Navbar CTA</span>
  <span class="chevron">▼</span>
</div><div class="ss-body">
  <div class="g2">
    <div class="fg"><label class="fl">CTA Button Text</label><input type="text" name="navbar[cta_text]" value="{{ $settings['navbar']['cta_text'] ?? "Let's Talk →" }}" class="fi"/></div>
    <div class="fg"><label class="fl">CTA Button URL</label><input type="text" name="navbar[cta_url]" value="{{ $settings['navbar']['cta_url'] ?? '#contact' }}" class="fi"/></div>
  </div>
</div></div>

{{-- TICKER HEADER --}}
<div class="ss"><div class="ss-head" onclick="tog(this)">
  <svg width="13" height="13" fill="none" stroke="#FFE500" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
  <span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-70">Running Text 1 — Header Ticker (dark bar)</span>
  <span class="chevron">▼</span>
</div><div class="ss-body">
  <div class="fg"><label class="fl">Items — one per line (e.g. ★ Stories That Sell)</label>
    <textarea name="ticker_header[items_raw]" class="ta" rows="5">{{ implode("\n", $settings['ticker_header']['items'] ?? []) }}</textarea>
  </div>
</div></div>

{{-- TICKER HERO --}}
<div class="ss"><div class="ss-head" onclick="tog(this)">
  <svg width="13" height="13" fill="none" stroke="#FFE500" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
  <span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-70">Running Text 2 — Hero Bottom Strip</span>
  <span class="chevron">▼</span>
</div><div class="ss-body">
  <div class="fg"><label class="fl">Items — one per line (e.g. Social Media)</label>
    <textarea name="ticker_hero[items_raw]" class="ta" rows="5">{{ implode("\n", $settings['ticker_hero']['items'] ?? []) }}</textarea>
  </div>
</div></div>

{{-- TICKER CLIENTS --}}
<div class="ss"><div class="ss-head" onclick="tog(this)">
  <svg width="13" height="13" fill="none" stroke="#FFE500" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
  <span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-70">Running Text 3 — Clients Strip</span>
  <span class="chevron">▼</span>
</div><div class="ss-body">
  <div class="fg"><label class="fl">Client Names — one per line (e.g. NIKE)</label>
    <textarea name="ticker_clients[items_raw]" class="ta" rows="5">{{ implode("\n", $settings['ticker_clients']['items'] ?? []) }}</textarea>
  </div>
</div></div>

{{-- HERO BANNER --}}
<div class="ss"><div class="ss-head" onclick="tog(this)">
  <svg width="13" height="13" fill="none" stroke="#FFE500" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/></svg>
  <span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-70">Hero Banner</span>
  <span class="chevron">▼</span>
</div><div class="ss-body">
  <div class="g3">
    <div class="fg"><label class="fl">Headline Line 1</label><input type="text" name="hero[headline_1]" value="{{ $settings['hero']['headline_1'] ?? 'WE' }}" class="fi"/></div>
    <div class="fg"><label class="fl">Headline Line 2</label><input type="text" name="hero[headline_2]" value="{{ $settings['hero']['headline_2'] ?? 'TELL' }}" class="fi"/></div>
    <div class="fg"><label class="fl">Headline Line 3</label><input type="text" name="hero[headline_3]" value="{{ $settings['hero']['headline_3'] ?? 'YOUR STORY.' }}" class="fi"/></div>
  </div>
  <div class="fg"><label class="fl">Description</label><textarea name="hero[description]" class="ta" rows="3">{{ $settings['hero']['description'] ?? '' }}</textarea></div>
  <div class="g3">
    <div class="fg"><label class="fl">Stat Projects</label><input type="text" name="hero[stat_projects]" value="{{ $settings['hero']['stat_projects'] ?? '87' }}" class="fi"/></div>
    <div class="fg"><label class="fl">Stat Years</label><input type="text" name="hero[stat_years]" value="{{ $settings['hero']['stat_years'] ?? '6+' }}" class="fi"/></div>
    <div class="fg"><label class="fl">Stat Awards</label><input type="text" name="hero[stat_awards]" value="{{ $settings['hero']['stat_awards'] ?? '★4' }}" class="fi"/></div>
  </div>
</div></div>

{{-- CONTACT --}}
<div class="ss"><div class="ss-head" onclick="tog(this)">
  <svg width="13" height="13" fill="none" stroke="#FFE500" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.68A2 2 0 012.18 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 8.15a16 16 0 006.94 6.94l1.41-1.41a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
  <span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-70">Contact & Social Media</span>
  <span class="chevron">▼</span>
</div><div class="ss-body">
  <div class="g2">
    <div class="fg"><label class="fl">Email</label><input type="text" name="contact[email]" value="{{ $settings['contact']['email'] ?? '' }}" class="fi"/></div>
    <div class="fg"><label class="fl">Phone (display)</label><input type="text" name="contact[phone]" value="{{ $settings['contact']['phone'] ?? '' }}" class="fi"/></div>
    <div class="fg"><label class="fl">WhatsApp (digits only, e.g. 6281234567890)</label><input type="text" name="contact[whatsapp]" value="{{ $settings['contact']['whatsapp'] ?? '' }}" class="fi"/></div>
  </div>
  <div class="fg"><label class="fl">Address</label><textarea name="contact[address]" class="ta" rows="2">{{ $settings['contact']['address'] ?? '' }}</textarea></div>
  <p class="font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-30 mb-3 mt-2">Social Media Links</p>
  <div class="g3">
    <div class="fg"><label class="fl">Instagram URL</label><input type="text" name="contact[instagram_url]" value="{{ $settings['contact']['instagram_url'] ?? '' }}" class="fi" placeholder="https://instagram.com/…"/></div>
    <div class="fg"><label class="fl">TikTok URL</label><input type="text" name="contact[tiktok_url]" value="{{ $settings['contact']['tiktok_url'] ?? '' }}" class="fi" placeholder="https://tiktok.com/@…"/></div>
    <div class="fg"><label class="fl">LinkedIn URL</label><input type="text" name="contact[linkedin_url]" value="{{ $settings['contact']['linkedin_url'] ?? '' }}" class="fi" placeholder="https://linkedin.com/…"/></div>
  </div>
</div></div>

{{-- STUDIO PAGE --}}
<div class="ss"><div class="ss-head" onclick="tog(this)">
  <svg width="13" height="13" fill="none" stroke="#FFE500" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
  <span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-70">Studio Page — Full Content</span>
  <span class="chevron">▼</span>
</div><div class="ss-body">
  <div class="g2">
    <div class="fg"><label class="fl">Hero Heading</label><input type="text" name="studio[hero_heading]" value="{{ $settings['studio']['hero_heading'] ?? 'OUR STUDIO' }}" class="fi"/></div>
    <div class="fg"><label class="fl">Hero Sub</label><input type="text" name="studio[hero_sub]" value="{{ $settings['studio']['hero_sub'] ?? 'Jakarta, ID — Est. 2017' }}" class="fi"/></div>
  </div>
  <div class="fg"><label class="fl">Mission Quote (big text)</label><input type="text" name="studio[mission_quote]" value="{{ $settings['studio']['mission_quote'] ?? '' }}" class="fi"/></div>
  <div class="fg"><label class="fl">Mission Description</label><textarea name="studio[mission_desc]" class="ta" rows="3">{{ $settings['studio']['mission_desc'] ?? '' }}</textarea></div>
  <div class="fg"><label class="fl">Founded / About Text</label><textarea name="studio[founded_text]" class="ta" rows="2">{{ $settings['studio']['founded_text'] ?? '' }}</textarea></div>

  <p class="font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-30 mb-3 mt-4">Stats (4 boxes)</p>
  @php $stats = $settings['studio']['stats'] ?? [['val'=>'87','label'=>'Projects Delivered'],['val'=>'6+','label'=>'Years Active'],['val'=>'8','label'=>'Disciplines'],['val'=>'★4','label'=>'Industry Awards']]; @endphp
  @foreach($stats as $i => $stat)
  <div class="stat-row">
    <div><label class="fl">Value</label><input type="text" name="studio[stat_val][]" value="{{ $stat['val'] ?? '' }}" class="fi"/></div>
    <div><label class="fl">Label</label><input type="text" name="studio[stat_label][]" value="{{ $stat['label'] ?? '' }}" class="fi"/></div>
  </div>
  @endforeach

  <p class="font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-30 mb-3 mt-4">Process Steps (4 steps)</p>
  @php $steps = $settings['studio']['process'] ?? [['num'=>'01','title'=>'Discover','desc'=>'We dive deep into your brand...'],['num'=>'02','title'=>'Strategise','desc'=>'We build a data-backed plan...'],['num'=>'03','title'=>'Execute','desc'=>'We produce and deploy...'],['num'=>'04','title'=>'Measure','desc'=>'We track, report and optimise...']]; @endphp
  @foreach($steps as $i => $step)
  <div class="step-row">
    <div><label class="fl">Num</label><input type="text" name="studio[step_num][]" value="{{ $step['num'] ?? '0'.($i+1) }}" class="fi"/></div>
    <div><label class="fl">Title</label><input type="text" name="studio[step_title][]" value="{{ $step['title'] ?? '' }}" class="fi"/></div>
    <div><label class="fl">Description</label><input type="text" name="studio[step_desc][]" value="{{ $step['desc'] ?? '' }}" class="fi"/></div>
  </div>
  @endforeach
</div></div>

{{-- FOOTER --}}
<div class="ss"><div class="ss-head" onclick="tog(this)">
  <svg width="13" height="13" fill="none" stroke="#FFE500" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="21" x2="21" y2="21"/><line x1="3" y1="14" x2="21" y2="14"/></svg>
  <span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-70">Footer</span>
  <span class="chevron">▼</span>
</div><div class="ss-body">
  <div class="fg"><label class="fl">Footer Tagline</label><input type="text" name="footer[description]" value="{{ $settings['footer']['description'] ?? '' }}" class="fi"/></div>
  <div class="g3">
    <div class="fg"><label class="fl">Instagram Handle</label><input type="text" name="footer[instagram]" value="{{ $settings['footer']['instagram'] ?? '@storytale.id' }}" class="fi" placeholder="@storytale.id"/></div>
    <div class="fg"><label class="fl">TikTok Handle</label><input type="text" name="footer[tiktok]" value="{{ $settings['footer']['tiktok'] ?? '@storytale.id' }}" class="fi" placeholder="@storytale.id"/></div>
    <div class="fg"><label class="fl">LinkedIn Name</label><input type="text" name="footer[linkedin]" value="{{ $settings['footer']['linkedin'] ?? 'Storytale Agency' }}" class="fi" placeholder="Storytale Agency"/></div>
  </div>
</div></div>

<div class="flex justify-end mt-4">
  <button type="submit" class="bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-sm uppercase tracking-widest px-8 py-3 border-2 border-[#FFE500] hover:bg-transparent hover:text-[#FFE500] transition-all duration-150">Save All Settings</button>
</div>
</form>

<script>
function tog(h){h.classList.toggle('open');h.nextElementSibling.classList.toggle('open');}
</script>
@endsection
