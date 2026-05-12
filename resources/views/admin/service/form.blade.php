@extends('admin.layout')
@section('title','Edit Service')
@section('page-title','Edit Service')
@section('page-sub', $service->name)
@section('header-action')
<a href="{{ route('admin.service.index') }}" class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-40 hover:opacity-100 no-underline flex items-center gap-2">
  <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Back
</a>
@endsection
@section('content')
<form method="POST" action="{{ route('admin.service.update', $service) }}">
  @csrf @method('PUT')
  <div class="grid grid-cols-1 xl:grid-cols-[1fr_300px] gap-6">
    <div class="flex flex-col gap-5">
      <div class="border-2 border-[rgba(255,229,0,0.1)] p-5">
        <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Service Name</label>
        <input type="text" name="name" value="{{ old('name',$service->name) }}" class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-brutal text-2xl tracking-wide px-4 py-3 focus:outline-none focus:border-[#FFE500] transition-colors" required/>
      </div>
      <div class="border-2 border-[rgba(255,229,0,0.1)] p-5">
        <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Description</label>
        <textarea name="description" rows="4" class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-4 py-3 focus:outline-none focus:border-[#FFE500] transition-colors resize-y">{{ old('description',$service->description) }}</textarea>
      </div>
      <div class="border-2 border-[rgba(255,229,0,0.1)] p-5">
        <div class="flex items-center justify-between mb-1">
          <label class="font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40">Scope Items</label>
          <button type="button" onclick="addTag()" class="font-body text-[10px] font-bold uppercase tracking-widest text-[#FFE500] opacity-50 hover:opacity-100 transition-opacity">+ Add</button>
        </div>
        <p class="font-body text-[10px] text-[#FFE500] opacity-25 mb-3">Press Enter or comma to add.</p>
        <div id="tags-wrap" class="flex flex-wrap gap-2 mb-3 min-h-[32px]"></div>
        <input type="text" id="tag-input" class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-4 py-2.5 focus:outline-none focus:border-[#FFE500] transition-colors" placeholder="e.g. Search Ads…"/>
        <input type="hidden" name="scope_json" id="scope-json" value="{{ json_encode($service->scope_items ?? []) }}"/>
      </div>
    </div>
    <div class="flex flex-col gap-5">
      <div class="border-2 border-[rgba(255,229,0,0.1)] p-5 sticky top-4">
        <div class="mb-4">
          <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Accent Color</label>
          <div class="flex items-center gap-3">
            <input type="color" name="color" value="{{ old('color',$service->color) }}" class="w-10 h-10 border-2 border-[rgba(255,229,0,0.2)] bg-transparent cursor-pointer"/>
            <input type="text" id="color-text" value="{{ old('color',$service->color) }}" class="flex-1 bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-3 py-2 focus:outline-none transition-colors"/>
          </div>
        </div>
        <div class="mb-4">
          <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Sort Order</label>
          <input type="number" name="sort_order" value="{{ old('sort_order',$service->sort_order) }}" min="0" class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-4 py-2.5 focus:outline-none focus:border-[#FFE500] transition-colors"/>
        </div>
        <label class="flex items-center gap-3 cursor-pointer mb-5">
          <input type="hidden" name="is_active" value="0"/>
          <input type="checkbox" name="is_active" value="1" {{ $service->is_active ? 'checked' : '' }} class="sr-only peer"/>
          <div class="w-10 h-5 bg-[rgba(255,229,0,0.1)] border-2 border-[rgba(255,229,0,0.2)] peer-checked:bg-[#FFE500] peer-checked:border-[#FFE500] transition-all relative">
            <div class="absolute top-0.5 left-0.5 w-3 h-3 bg-[rgba(255,229,0,0.4)] peer-checked:bg-[#0A0A0A] transition-all"></div>
          </div>
          <span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-60">Active</span>
        </label>
        <button type="submit" class="w-full bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-sm uppercase tracking-widest py-3 border-2 border-[#FFE500] hover:bg-transparent hover:text-[#FFE500] transition-all duration-150 mb-2">Save Service</button>
        <a href="{{ route('admin.service.index') }}" class="block text-center border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] opacity-40 hover:opacity-100 font-body text-xs font-bold uppercase tracking-widest py-2.5 no-underline transition-opacity">Cancel</a>
      </div>
    </div>
  </div>
</form>
<script>
let tags = JSON.parse(document.getElementById('scope-json').value || '[]');
const style = `.tag-pill{display:inline-flex;align-items:center;gap:4px;background:rgba(255,229,0,0.1);border:1px solid rgba(255,229,0,0.25);color:#FFE500;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.15em;padding:3px 10px;}.tag-pill button{background:none;border:none;color:#FFE500;cursor:pointer;opacity:.5;padding:0;line-height:1;}`;
document.head.insertAdjacentHTML('beforeend',`<style>${style}</style>`);
function renderTags(){const w=document.getElementById('tags-wrap');w.innerHTML='';tags.forEach((t,i)=>{const p=document.createElement('span');p.className='tag-pill';p.innerHTML=`${t} <button type="button" onclick="removeTag(${i})">✕</button>`;w.appendChild(p);});document.getElementById('scope-json').value=JSON.stringify(tags);}
function removeTag(i){tags.splice(i,1);renderTags();}
function addTag(){const v=document.getElementById('tag-input').value.trim();if(v&&!tags.includes(v)){tags.push(v);renderTags();document.getElementById('tag-input').value='';}}
document.getElementById('tag-input').addEventListener('keydown',e=>{if(e.key==='Enter'||e.key===','){e.preventDefault();addTag();}});
document.querySelector('[name=color]').addEventListener('input',e=>{document.getElementById('color-text').value=e.target.value;});
renderTags();
</script>
@endsection
