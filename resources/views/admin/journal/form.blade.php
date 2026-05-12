@extends('admin.layout')
@section('title', $journal ? 'Edit Journal' : 'New Journal')
@section('page-title', $journal ? 'Edit Journal' : 'New Journal')
@section('header-action')
<a href="{{ route('admin.journal.index') }}" class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-40 hover:opacity-100 no-underline flex items-center gap-2">
  <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Back
</a>
@endsection

@push('styles')
<style>
.drop-zone { border:2px dashed rgba(255,229,0,0.2); transition:border-color .15s,background .15s; cursor:pointer; }
.drop-zone:hover,.drop-zone.drag-over { border-color:#FFE500; background:rgba(255,229,0,0.03); }
</style>
@endpush

@section('content')
@php $action = $journal ? route('admin.journal.update',$journal) : route('admin.journal.store'); $method = $journal ? 'PUT' : 'POST'; @endphp
<form method="POST" action="{{ $action }}">
@csrf @method($method)
<div class="grid grid-cols-1 xl:grid-cols-[1fr_300px] gap-6">
  <div class="flex flex-col gap-5">

    {{-- Cover Image --}}
    <div class="border-2 border-[rgba(255,229,0,0.1)] p-5">
      <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-3">Cover Image</label>
      <div id="cover-drop" class="drop-zone relative" style="min-height:180px;">
        <div id="cover-preview" class="{{ $journal?->cover_image ? '' : 'hidden' }}">
          <img id="cover-img" src="{{ $journal?->cover_image }}" class="w-full object-cover" style="max-height:240px;"/>
        </div>
        <div id="cover-prompt" class="{{ $journal?->cover_image ? 'hidden' : '' }} flex flex-col items-center justify-center gap-3 py-10">
          <svg width="28" height="28" fill="none" stroke="rgba(255,229,0,0.3)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
          <p class="font-body text-xs text-[#FFE500] opacity-30 uppercase tracking-widest">Drag & drop or click</p>
        </div>
        <input type="file" id="cover-file" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"/>
      </div>
      <input type="hidden" name="cover_image" id="cover-val" value="{{ old('cover_image',$journal?->cover_image) }}"/>
    </div>

    {{-- Title --}}
    <div class="border-2 border-[rgba(255,229,0,0.1)] p-5">
      <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Title *</label>
      <input type="text" name="title" value="{{ old('title',$journal?->title) }}"
        class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-brutal text-2xl tracking-wide px-4 py-3 focus:outline-none focus:border-[#FFE500] placeholder-[rgba(255,229,0,0.15)] transition-colors"
        placeholder="Journal Title" required/>
    </div>

    {{-- Excerpt --}}
    <div class="border-2 border-[rgba(255,229,0,0.1)] p-5">
      <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Excerpt</label>
      <textarea name="excerpt" rows="4"
        class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-4 py-3 focus:outline-none focus:border-[#FFE500] placeholder-[rgba(255,229,0,0.15)] transition-colors resize-y"
        placeholder="Short description shown on journal cards…">{{ old('excerpt',$journal?->excerpt) }}</textarea>
    </div>

    {{-- PDF Upload --}}
    <div class="border-2 border-[rgba(255,229,0,0.1)] p-5">
      <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-1">PDF / Flipbook</label>
      <p class="font-body text-[10px] text-[#FFE500] opacity-25 mb-3">Upload a PDF or paste a direct URL. Used for the flipbook reader on the journal page.</p>
      {{-- Current PDF status --}}
      <div id="pdf-status" class="{{ $journal?->pdf_url ? '' : 'hidden' }} flex items-center gap-3 mb-3 p-3 border-2 border-[rgba(0,170,80,0.3)] bg-[rgba(0,170,80,0.06)]">
        <svg width="16" height="16" fill="none" stroke="#00AA50" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        <div class="flex-1 min-w-0">
          <div class="font-body text-[10px] font-bold uppercase tracking-widest text-[#00AA50] mb-0.5">PDF Uploaded</div>
          <span id="pdf-filename" class="font-body text-xs text-[#FFE500] opacity-50 truncate block">{{ $journal?->pdf_url ? basename($journal->pdf_url) : '' }}</span>
        </div>
        @if($journal?->pdf_url)
          <a href="{{ $journal->pdf_url }}" target="_blank" class="font-body text-[10px] font-bold uppercase tracking-widest text-[#FFE500] opacity-50 hover:opacity-100 no-underline flex-shrink-0">Open ↗</a>
        @endif
        <a id="pdf-open-link" href="{{ $journal?->pdf_url }}" target="_blank" class="hidden font-body text-[10px] font-bold uppercase tracking-widest text-[#FFE500] opacity-50 hover:opacity-100 no-underline flex-shrink-0">Open ↗</a>
      </div>

      {{-- Upload drop zone --}}
      <div id="pdf-drop" class="drop-zone relative p-6 text-center mb-3">
        <div id="pdf-drop-inner" class="flex flex-col items-center gap-2 pointer-events-none">
          <svg width="24" height="24" fill="none" stroke="rgba(255,229,0,0.3)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
          <p class="font-body text-[10px] text-[#FFE500] opacity-30 uppercase tracking-widest">Drag PDF here or click to browse</p>
          <p class="font-body text-[9px] text-[#FFE500] opacity-20">Max 50 MB · .pdf only</p>
        </div>
        {{-- Upload progress --}}
        <div id="pdf-uploading" class="hidden absolute inset-0 bg-[rgba(10,10,10,0.8)] flex items-center justify-center gap-3">
          <svg class="animate-spin w-5 h-5 text-[#FFE500]" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
          <span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500]">Uploading…</span>
        </div>
        <input type="file" id="pdf-file" accept=".pdf,application/pdf" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"/>
      </div>

      {{-- Manual URL input --}}
      <div>
        <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-30 mb-2">Or paste direct PDF URL</label>
        <input type="text" name="pdf_url" id="pdf-url-input" value="{{ old('pdf_url',$journal?->pdf_url) }}"
          class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-xs px-4 py-2.5 focus:outline-none focus:border-[#FFE500] placeholder-[rgba(255,229,0,0.2)] transition-colors"
          placeholder="https://…"/>
      </div>
    </div>

  </div>

  <div class="flex flex-col gap-5">
    {{-- Publish --}}
    <div class="border-2 border-[rgba(255,229,0,0.1)] p-5 sticky top-4">
      <p class="font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-4">Publish</p>
      <div class="mb-4">
        <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Status</label>
        <select name="status" class="w-full bg-[#0A0A0A] border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-4 py-2.5 focus:outline-none focus:border-[#FFE500] transition-colors">
          <option value="draft"     {{ old('status',$journal?->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
          <option value="published" {{ old('status',$journal?->status) === 'published' ? 'selected' : '' }}>Published</option>
        </select>
      </div>
      <div class="mb-4">
        <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Category *</label>
        <select name="category" class="w-full bg-[#0A0A0A] border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-4 py-2.5 focus:outline-none focus:border-[#FFE500] transition-colors" required>
          @foreach(['case-study'=>'Case Study','learning'=>'Learning','insight'=>'Insight','whitepaper'=>'Whitepaper','report'=>'Report'] as $val=>$label)
            <option value="{{ $val }}" {{ old('category',$journal?->category) === $val ? 'selected' : '' }}>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div class="mb-5">
        <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Publish Date</label>
        <input type="date" name="published_at" value="{{ old('published_at',$journal?->published_at?->format('Y-m-d')) }}"
          class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-4 py-2.5 focus:outline-none focus:border-[#FFE500] transition-colors"/>
      </div>
      <div class="mb-5">
        <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order',$journal?->sort_order ?? 0) }}" min="0"
          class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-4 py-2.5 focus:outline-none focus:border-[#FFE500] transition-colors"/>
      </div>
      <button type="submit" class="w-full bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-sm uppercase tracking-widest py-3.5 border-2 border-[#FFE500] hover:bg-transparent hover:text-[#FFE500] transition-all duration-150 mb-2">
        {{ $journal ? 'Save Changes' : 'Create Item' }}
      </button>
      <a href="{{ route('admin.journal.index') }}" class="block text-center border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] opacity-40 hover:opacity-100 font-body text-xs font-bold uppercase tracking-widest py-3 no-underline transition-opacity">Cancel</a>
    </div>
  </div>
</div>
</form>

<script>
const CSRF = '{{ csrf_token() }}';
const UPLOAD_URL = '{{ route("admin.upload") }}';

async function uploadFile(file) {
  const fd = new FormData(); fd.append('file', file);
  try {
    const r = await fetch(UPLOAD_URL, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
      body: fd,
    });
    const ct = r.headers.get('content-type') || '';
    if (!ct.includes('application/json')) {
      if (r.status === 401 || r.status === 419) {
        alert('Session expired. The page will reload.'); location.reload(); return null;
      }
      throw new Error('Unexpected server response (status ' + r.status + ').');
    }
    const data = await r.json();
    if (!r.ok) throw new Error(data.errors?.file?.[0] || data.message || 'Upload failed.');
    return data.url || null;
  } catch(e) { alert('Upload error: ' + e.message); return null; }
}

// Cover image
const cf = document.getElementById('cover-file');
cf.addEventListener('change', async () => {
  const url = await uploadFile(cf.files[0]);
  if (url) { document.getElementById('cover-val').value=url; document.getElementById('cover-img').src=url; document.getElementById('cover-preview').classList.remove('hidden'); document.getElementById('cover-prompt').classList.add('hidden'); }
});
['dragover','dragleave','drop'].forEach(ev => document.getElementById('cover-drop').addEventListener(ev, (e)=>{
  e.preventDefault();
  if(ev==='drop' && e.dataTransfer.files[0]) { cf.files = e.dataTransfer.files; cf.dispatchEvent(new Event('change')); }
  document.getElementById('cover-drop').classList.toggle('drag-over', ev==='dragover');
}));

// PDF upload with full feedback
const pf          = document.getElementById('pdf-file');
const pdfStatus   = document.getElementById('pdf-status');
const pdfFilename = document.getElementById('pdf-filename');
const pdfUploading= document.getElementById('pdf-uploading');
const pdfUrlInput = document.getElementById('pdf-url-input');
const pdfOpenLink = document.getElementById('pdf-open-link');

async function handlePdfUpload(file) {
  if (!file || file.type !== 'application/pdf') {
    alert('Please select a valid PDF file.'); return;
  }
  // Show spinner
  pdfUploading.classList.remove('hidden');
  document.getElementById('pdf-drop-inner').classList.add('invisible');
  pdfStatus.classList.add('hidden');

  try {
    const url = await uploadFile(file);
    if (url) {
      pdfUrlInput.value = url;
      pdfFilename.textContent = file.name;
      pdfOpenLink.href = url;
      pdfOpenLink.classList.remove('hidden');
      pdfStatus.classList.remove('hidden');
      document.getElementById('pdf-drop-inner').innerHTML = `
        <svg width="20" height="20" fill="none" stroke="#00AA50" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        <p class="font-body text-[10px] font-bold uppercase tracking-widest" style="color:#00AA50;">${file.name}</p>
        <p class="font-body text-[9px] opacity-40" style="color:#00AA50;">Click to replace</p>`;
      document.getElementById('pdf-drop-inner').classList.remove('invisible');
    } else {
      document.getElementById('pdf-drop-inner').classList.remove('invisible');
    }
  } catch(e) {
    alert('Upload error: ' + e.message);
    document.getElementById('pdf-drop-inner').classList.remove('invisible');
  } finally {
    pdfUploading.classList.add('hidden');
  }
}

pf.addEventListener('change', () => { if (pf.files[0]) handlePdfUpload(pf.files[0]); });
['dragover','dragleave','drop'].forEach(ev => document.getElementById('pdf-drop').addEventListener(ev, (e) => {
  e.preventDefault();
  if (ev === 'drop' && e.dataTransfer.files[0]) handlePdfUpload(e.dataTransfer.files[0]);
  document.getElementById('pdf-drop').classList.toggle('drag-over', ev === 'dragover');
}));

// Sync manual URL input → update status
pdfUrlInput.addEventListener('input', () => {
  if (pdfUrlInput.value.trim()) {
    pdfFilename.textContent = pdfUrlInput.value.trim();
    pdfStatus.classList.remove('hidden');
  } else {
    pdfStatus.classList.add('hidden');
  }
});
</script>
@endsection
