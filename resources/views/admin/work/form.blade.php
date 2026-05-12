@extends('admin.layout')

@section('title', $project ? 'Edit Project' : 'New Project')
@section('page-title', $project ? 'Edit Project' : 'New Project')
@section('page-sub', $project ? $project->title : 'Fill in all fields below')

@section('header-action')
  <a href="{{ route('admin.work.index') }}"
    class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-40 hover:opacity-100 no-underline transition-opacity flex items-center gap-2">
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
    Back
  </a>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.quilljs.com/1.3.7/quill.snow.css"/>
<style>
  /* ── Quill dark theme — no double borders ─────────── */
  /* Wrapper strips Quill's own outer border; we use section card border */
  .ql-wrap { display: flex; flex-direction: column; }
  .ql-wrap .ql-toolbar.ql-snow {
    background: #0f0f0f;
    border: none !important;
    border-bottom: 1px solid rgba(255,229,0,0.1) !important;
    padding: 8px 10px;
    flex-shrink: 0;
    border-radius: 0;
  }
  .ql-wrap .ql-container.ql-snow {
    border: none !important;
    background: #080808;
    flex: 1;
  }
  .ql-wrap.ql-short .ql-editor { min-height: 120px; }
  .ql-wrap.ql-long  .ql-editor { min-height: 260px; }
  /* Outer card border does the framing */
  .editor-card {
    border: 2px solid rgba(255,229,0,0.15);
    overflow: hidden;
  }
  .editor-card:focus-within { border-color: rgba(255,229,0,0.4); }
  .ql-editor { color: #FFE500; font-family: 'Space Grotesk', sans-serif; font-size: 0.875rem; line-height: 1.65; }
  .ql-editor.ql-blank::before { color: rgba(255,229,0,0.2); font-style: normal; }
  .ql-toolbar .ql-stroke { stroke: rgba(255,229,0,0.5); }
  .ql-toolbar .ql-fill  { fill:   rgba(255,229,0,0.5); }
  .ql-toolbar button:hover .ql-stroke,
  .ql-toolbar button.ql-active .ql-stroke { stroke: #FFE500; }
  .ql-toolbar button:hover .ql-fill,
  .ql-toolbar button.ql-active .ql-fill   { fill: #FFE500; }
  .ql-toolbar .ql-picker-label { color: rgba(255,229,0,0.5); }
  .ql-toolbar .ql-picker-label:hover,
  .ql-toolbar .ql-picker-label.ql-active  { color: #FFE500; }
  .ql-toolbar .ql-picker-options {
    background: #111; border: 1px solid rgba(255,229,0,0.2);
  }
  .ql-toolbar .ql-picker-item { color: rgba(255,229,0,0.7); }
  .ql-toolbar .ql-picker-item:hover { color: #FFE500; }

  /* Drop zones */
  .drop-zone {
    border: 2px dashed rgba(255,229,0,0.2);
    transition: border-color 0.15s ease, background 0.15s ease;
    cursor: pointer;
  }
  .drop-zone.drag-over,
  .drop-zone:hover { border-color: #FFE500; background: rgba(255,229,0,0.03); }

  /* Gallery grid */
  .gallery-thumb {
    position: relative; aspect-ratio: 4/3; overflow: hidden;
    border: 2px solid rgba(255,229,0,0.12);
    background: #111;
  }
  .gallery-thumb img { width:100%; height:100%; object-fit:cover; }
  .gallery-thumb .remove-btn {
    position: absolute; top: 6px; right: 6px;
    width: 24px; height: 24px;
    background: rgba(255,45,45,0.85);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 14px; line-height: 1;
    color: #fff; border: none; outline: none;
    opacity: 0.75; transition: opacity 0.15s ease;
  }
  .gallery-thumb .remove-btn:hover { opacity: 1; background: #FF2D2D; }

  /* Tag input */
  .tag-pill {
    display: inline-flex; align-items: center; gap: 4px;
    background: rgba(255,229,0,0.1); border: 1px solid rgba(255,229,0,0.25);
    color: #FFE500; font-size: 0.6rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.15em;
    padding: 3px 10px; cursor: default;
  }
  .tag-pill button { background: none; border: none; color: #FFE500; cursor: pointer; opacity: 0.5; padding: 0; line-height: 1; }
  .tag-pill button:hover { opacity: 1; }

  /* Metric row */
  .metric-row {
    display: grid; grid-template-columns: 1fr 1.5fr 32px;
    gap: 8px; align-items: center;
  }

  /* Upload progress */
  .upload-progress {
    position: absolute; inset: 0; background: rgba(10,10,10,0.7);
    display: flex; align-items: center; justify-content: center;
  }
</style>
@endpush

@section('content')
@php
  $action = $project ? route('admin.work.update', $project) : route('admin.work.store');
  $method = $project ? 'PUT' : 'POST';
@endphp

<form method="POST" action="{{ $action }}" id="project-form" enctype="multipart/form-data">
  @csrf @method($method)
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <div class="grid grid-cols-1 xl:grid-cols-[1fr_340px] gap-6">

    {{-- ═══════════════ LEFT COLUMN ═══════════════ --}}
    <div class="flex flex-col gap-5">

      {{-- ── Cover Image ── --}}
      <div class="border-2 border-[rgba(255,229,0,0.1)] p-5">
        <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-3">Cover Image</label>

        <div id="cover-drop" class="drop-zone relative" style="min-height:200px;">
          {{-- Preview --}}
          <div id="cover-preview" class="{{ $project?->cover_image ? '' : 'hidden' }} relative">
            <img id="cover-img" src="{{ $project?->cover_image }}" class="w-full object-cover" style="max-height:300px;"/>
            <div id="cover-uploading" class="upload-progress hidden">
              <svg class="animate-spin w-6 h-6 text-[#FFE500]" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
            </div>
          </div>
          {{-- Prompt --}}
          <div id="cover-prompt" class="{{ $project?->cover_image ? 'hidden' : '' }} flex flex-col items-center justify-center gap-3 py-12">
            <svg width="36" height="36" fill="none" stroke="rgba(255,229,0,0.3)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            <p class="font-body text-xs text-[#FFE500] opacity-30 uppercase tracking-widest">Drag & drop or click to upload</p>
            <p class="font-body text-[10px] text-[#FFE500] opacity-20">JPG, PNG, WEBP — max 10 MB</p>
          </div>
          <input type="file" id="cover-file" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"/>
        </div>

        @if($project?->cover_image)
          <button type="button" onclick="removeCover()" class="mt-2 font-body text-[10px] font-bold uppercase tracking-widest text-[#FF2D2D] opacity-50 hover:opacity-100 transition-opacity">
            Remove cover
          </button>
        @endif
        <input type="hidden" name="cover_image" id="cover-image-val" value="{{ old('cover_image', $project?->cover_image) }}"/>
      </div>

      {{-- ── Title + Slug ── --}}
      <div class="border-2 border-[rgba(255,229,0,0.1)] p-5 flex flex-col gap-4">
        <div>
          <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Title <span class="text-[#FF2D2D]">*</span></label>
          <input type="text" name="title" id="title" value="{{ old('title', $project?->title) }}"
            class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-brutal text-2xl tracking-wide px-4 py-3 focus:outline-none focus:border-[#FFE500] placeholder-[rgba(255,229,0,0.15)] transition-colors"
            placeholder="Project Title" required/>
          @error('title') <p class="mt-1 font-body text-[10px] text-[#FF2D2D]">{{ $message }}</p> @enderror
        </div>
        <div>
          <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Slug <span class="text-[#FF2D2D]">*</span></label>
          <div class="flex items-center border-2 border-[rgba(255,229,0,0.15)] focus-within:border-[#FFE500] transition-colors">
            <span class="font-body text-xs text-[#FFE500] opacity-20 px-3 whitespace-nowrap">/work/</span>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $project?->slug) }}"
              class="flex-1 bg-transparent text-[#FFE500] font-body text-sm px-2 py-2.5 focus:outline-none placeholder-[rgba(255,229,0,0.15)]"
              placeholder="url-slug" required/>
          </div>
          @error('slug') <p class="mt-1 font-body text-[10px] text-[#FF2D2D]">{{ $message }}</p> @enderror
        </div>
      </div>

      {{-- ── Description (Quill short) ── --}}
      <div>
        <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">
          Description <span class="text-[#FF2D2D]">*</span>
          <span class="ml-2 opacity-50">— overview shown at top of detail page</span>
        </label>
        <div class="editor-card">
          <div class="ql-wrap ql-short">
            <div id="desc-editor"></div>
          </div>
        </div>
        <input type="hidden" name="description" id="desc-input"/>
        @error('description') <p class="mt-1 font-body text-[10px] text-[#FF2D2D]">{{ $message }}</p> @enderror
      </div>

      {{-- ── Full Content (Quill long) ── --}}
      <div>
        <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">
          Full Content
          <span class="ml-2 opacity-50">— case study body, supports images & formatting</span>
        </label>
        <div class="editor-card">
          <div class="ql-wrap ql-long">
            <div id="content-editor"></div>
          </div>
        </div>
        <input type="hidden" name="content" id="content-input"/>
        @error('content') <p class="mt-1 font-body text-[10px] text-[#FF2D2D]">{{ $message }}</p> @enderror
      </div>

      {{-- ── Embed Code (multi) ── --}}
      <div class="border-2 border-[rgba(255,229,0,0.1)] p-5">
        <div class="flex items-center justify-between mb-1">
          <label class="font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40">Embed Code</label>
          <button type="button" onclick="addEmbed()" class="font-body text-[10px] font-bold uppercase tracking-widest text-[#FFE500] opacity-50 hover:opacity-100 transition-opacity flex items-center gap-1">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Add
          </button>
        </div>
        <p class="font-body text-[10px] text-[#FFE500] opacity-25 mb-4">Paste iframes — YouTube, Vimeo, Google Maps, etc. Multiple embeds supported.</p>
        <div id="embed-list" class="flex flex-col gap-3">
          {{-- seed existing embed_code as first item if it exists --}}
          @if(old('embed_code', $project?->embed_code))
            @php $existingEmbeds = json_decode(old('embed_items_json','[]'),true) ?: [old('embed_code',$project?->embed_code)] @endphp
            @foreach($existingEmbeds as $emb)
              <div class="embed-row flex gap-2">
                <textarea name="embed_items[]" rows="3"
                  class="flex-1 bg-[#050505] border-2 border-[rgba(255,229,0,0.15)] text-[rgba(255,229,0,0.7)] font-mono text-xs px-3 py-2 focus:outline-none focus:border-[#FFE500] transition-colors resize-y"
                  placeholder='<iframe …>'><?= htmlspecialchars($emb) ?></textarea>
                <button type="button" onclick="this.closest('.embed-row').remove()" class="w-8 flex-shrink-0 border-2 border-[rgba(255,45,45,0.3)] text-[#FF2D2D] opacity-50 hover:opacity-100 transition-opacity self-start p-1">✕</button>
              </div>
            @endforeach
          @endif
        </div>
        {{-- always show at least one empty textarea if no existing embeds --}}
        @if(!old('embed_code', $project?->embed_code))
          <div class="embed-row flex gap-2">
            <textarea name="embed_items[]" rows="3"
              class="flex-1 bg-[#050505] border-2 border-[rgba(255,229,0,0.15)] text-[rgba(255,229,0,0.7)] font-mono text-xs px-3 py-2 focus:outline-none focus:border-[#FFE500] transition-colors resize-y"
              placeholder='<iframe src="https://www.youtube.com/embed/..." allowfullscreen></iframe>'></textarea>
            <button type="button" onclick="this.closest('.embed-row').remove()" class="w-8 flex-shrink-0 border-2 border-[rgba(255,45,45,0.3)] text-[#FF2D2D] opacity-50 hover:opacity-100 transition-opacity self-start p-1">✕</button>
          </div>
        @endif
      </div>

      {{-- ── Gallery Images ── --}}
      <div class="border-2 border-[rgba(255,229,0,0.1)] p-5">
        <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-3">Project Gallery</label>

        {{-- Existing images --}}
        @if($project && $project->images->count())
          <div id="existing-gallery" class="grid grid-cols-3 gap-3 mb-4">
            @foreach($project->images as $img)
              <div class="gallery-thumb" data-id="{{ $img->id }}">
                <img src="{{ $img->image_url }}" alt="{{ $img->alt_text }}"/>
                <button type="button" class="remove-btn" onclick="removeExistingImage({{ $img->id }}, this)">✕</button>
              </div>
            @endforeach
          </div>
        @endif

        {{-- New images preview --}}
        <div id="new-gallery" class="grid grid-cols-3 gap-3 mb-4 hidden"></div>

        {{-- Drop zone --}}
        <div id="gallery-drop" class="drop-zone relative p-8 text-center">
          <div class="flex flex-col items-center gap-2 pointer-events-none">
            <svg width="28" height="28" fill="none" stroke="rgba(255,229,0,0.3)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            <p class="font-body text-xs text-[#FFE500] opacity-30 uppercase tracking-widest">Drag images here or click to browse</p>
            <p class="font-body text-[10px] text-[#FFE500] opacity-20">Multiple files supported</p>
          </div>
          <input type="file" id="gallery-files" accept="image/*" multiple class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"/>
        </div>

        <input type="hidden" name="new_image_urls" id="new-image-urls" value="[]"/>
        <input type="hidden" name="delete_image_ids" id="delete-image-ids" value=""/>
      </div>

      {{-- ── Custom Metrics ── --}}
      <div class="border-2 border-[rgba(255,229,0,0.1)] p-5">
        <div class="flex items-center justify-between mb-1">
          <label class="font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40">Custom Metrics</label>
          <button type="button" onclick="addMetric()" class="font-body text-[10px] font-bold uppercase tracking-widest text-[#FFE500] opacity-50 hover:opacity-100 transition-opacity flex items-center gap-1">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Add
          </button>
        </div>
        <p class="font-body text-[10px] text-[#FFE500] opacity-25 mb-4">Leave empty to use auto-generated metrics from the category.</p>
        <div id="metrics-list" class="flex flex-col gap-2">
          @php $metrics = old('metrics_val') ? collect(old('metrics_val'))->zip(old('metrics_label', []))->all() : ($project?->custom_metrics ?? []) @endphp
          @foreach($metrics as $m)
            @php $val = is_array($m) && isset($m['val']) ? $m['val'] : (is_array($m) ? ($m[0] ?? '') : ''); $lbl = is_array($m) && isset($m['label']) ? $m['label'] : (is_array($m) ? ($m[1] ?? '') : ''); @endphp
            <div class="metric-row">
              <input type="text" name="metrics_val[]" value="{{ $val }}"
                class="bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-brutal text-xl px-3 py-2 focus:outline-none focus:border-[#FFE500] placeholder-[rgba(255,229,0,0.15)] transition-colors"
                placeholder="4.2×"/>
              <input type="text" name="metrics_label[]" value="{{ $lbl }}"
                class="bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-xs px-3 py-2 focus:outline-none focus:border-[#FFE500] placeholder-[rgba(255,229,0,0.15)] transition-colors"
                placeholder="ROAS"/>
              <button type="button" onclick="this.closest('.metric-row').remove()"
                class="w-8 h-8 flex items-center justify-center border-2 border-[rgba(255,45,45,0.3)] text-[#FF2D2D] opacity-50 hover:opacity-100 transition-opacity">✕</button>
            </div>
          @endforeach
        </div>
      </div>

      {{-- ── Scope Tags ── --}}
      <div class="border-2 border-[rgba(255,229,0,0.1)] p-5">
        <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-1">Scope / Deliverables</label>
        <p class="font-body text-[10px] text-[#FFE500] opacity-25 mb-3">Leave empty to use auto-generated scope from the category. Press Enter or comma to add a tag.</p>
        <div id="tags-wrap" class="flex flex-wrap gap-2 mb-3 min-h-[32px]"></div>
        <input type="text" id="tag-input"
          class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-4 py-2.5 focus:outline-none focus:border-[#FFE500] placeholder-[rgba(255,229,0,0.2)] transition-colors"
          placeholder="e.g. Search Ads, Meta Ads…"/>
        <input type="hidden" name="custom_scope_json" id="scope-json" value="{{ json_encode($project?->custom_scope ?? []) }}"/>
      </div>

    </div>{{-- end left --}}


    {{-- ═══════════════ RIGHT COLUMN ═══════════════ --}}
    <div class="flex flex-col gap-5">

      {{-- Publish --}}
      <div class="border-2 border-[rgba(255,229,0,0.1)] p-5 sticky top-4">
        <p class="font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-4">Publish</p>

        <div class="mb-4">
          <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Status</label>
          <select name="status" class="w-full bg-[#0A0A0A] border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-4 py-2.5 focus:outline-none focus:border-[#FFE500] transition-colors">
            <option value="draft"     {{ old('status', $project?->status ?? 'draft') === 'draft'     ? 'selected' : '' }}>Draft</option>
            <option value="published" {{ old('status', $project?->status) === 'published' ? 'selected' : '' }}>Published</option>
          </select>
        </div>

        <label class="flex items-center gap-3 cursor-pointer group mb-5">
          <input type="hidden" name="is_featured" value="0"/>
          <input type="checkbox" name="is_featured" value="1" id="is_featured"
            {{ old('is_featured', $project?->is_featured) ? 'checked' : '' }} class="peer sr-only"/>
          <div class="w-10 h-5 bg-[rgba(255,229,0,0.1)] border-2 border-[rgba(255,229,0,0.2)] relative peer-checked:bg-[#FFE500] peer-checked:border-[#FFE500] transition-all flex-shrink-0">
            <div class="absolute top-0.5 left-0.5 w-3 h-3 bg-[rgba(255,229,0,0.4)] peer-checked:bg-[#0A0A0A] transition-all duration-200" id="toggle-knob"></div>
          </div>
          <span class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-60 group-hover:opacity-100 transition-opacity">Featured</span>
        </label>

        <button type="submit"
          class="w-full bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-sm uppercase tracking-widest py-3.5 border-2 border-[#FFE500] hover:bg-transparent hover:text-[#FFE500] transition-all duration-150 mb-2">
          {{ $project ? 'Save Changes' : 'Create Project' }}
        </button>
        <a href="{{ route('admin.work.index') }}"
          class="block text-center border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] opacity-40 hover:opacity-100 font-body text-xs font-bold uppercase tracking-widest py-3 no-underline transition-opacity">
          Cancel
        </a>
      </div>

      {{-- Meta --}}
      <div class="border-2 border-[rgba(255,229,0,0.1)] p-5 flex flex-col gap-4">
        <p class="font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40">Project Info</p>

        <div>
          <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Client <span class="text-[#FF2D2D]">*</span></label>
          <input type="text" name="client" value="{{ old('client', $project?->client) }}"
            class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-4 py-2.5 focus:outline-none focus:border-[#FFE500] placeholder-[rgba(255,229,0,0.15)] transition-colors"
            placeholder="Client name" required/>
          @error('client') <p class="mt-1 font-body text-[10px] text-[#FF2D2D]">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Category <span class="text-[#FF2D2D]">*</span></label>
          <select name="category_id" class="w-full bg-[#0A0A0A] border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-4 py-2.5 focus:outline-none focus:border-[#FFE500] transition-colors" required>
            <option value="">Select…</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ old('category_id', $project?->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
          </select>
          @error('category_id') <p class="mt-1 font-body text-[10px] text-[#FF2D2D]">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Year <span class="text-[#FF2D2D]">*</span></label>
            <input type="number" name="project_year" value="{{ old('project_year', $project?->project_year ?? date('Y')) }}"
              min="2000" max="2100"
              class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-3 py-2.5 focus:outline-none focus:border-[#FFE500] transition-colors" required/>
          </div>
          <div>
            <label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Sort</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $project?->sort_order ?? 0) }}"
              min="0"
              class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-3 py-2.5 focus:outline-none focus:border-[#FFE500] transition-colors"/>
          </div>
        </div>
      </div>

      @if($project)
        <div class="border-2 border-[rgba(255,229,0,0.08)] p-4 flex items-center justify-between">
          <span class="font-body text-[10px] text-[#FFE500] opacity-30 uppercase tracking-widest">Preview</span>
          <a href="/work/{{ $project->slug }}" target="_blank"
            class="font-body text-xs font-bold uppercase tracking-widest text-[#FFE500] opacity-50 hover:opacity-100 no-underline transition-opacity">Open ↗</a>
        </div>
      @endif

    </div>{{-- end right --}}
  </div>

</form>

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.7/quill.js"></script>
<script>
const CSRF = document.querySelector('meta[name=csrf-token]').content;

const UPLOAD_URL = '{{ route("admin.upload") }}';
const IMG_DEL_URL = '/admin/images/';

// ── Upload helper ──────────────────────────────────────
async function uploadFile(file) {
  const fd = new FormData();
  fd.append('file', file);
  try {
    const r = await fetch(UPLOAD_URL, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
      body: fd,
    });
    const ct = r.headers.get('content-type') || '';
    if (!ct.includes('application/json')) {
      if (r.status === 401 || r.status === 419) {
        alert('Your session expired. The page will reload so you can log in again.');
        location.reload(); return null;
      }
      throw new Error('Server returned an unexpected response (status ' + r.status + ').');
    }
    const data = await r.json();
    if (!r.ok) throw new Error(data.errors?.file?.[0] || data.message || 'Upload failed.');
    return data.url || null;
  } catch(e) {
    alert('Upload error: ' + e.message);
    return null;
  }
}

// ── Image AJAX delete ──────────────────────────────────
async function ajaxDeleteImage(id) {
  try {
    const r = await fetch(IMG_DEL_URL + id, {
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
    });
    if (r.status === 401 || r.status === 419) { location.reload(); return false; }
    return r.ok;
  } catch(e) { return false; }
}

// ── Quill toolbar config ───────────────────────────────
const TOOLBAR = [
  [{ header: [2, 3, 4, false] }],
  ['bold', 'italic', 'underline', 'strike'],
  [{ list: 'ordered' }, { list: 'bullet' }],
  ['blockquote', 'code-block'],
  ['link', 'image'],
  [{ color: [] }],
  ['clean'],
];

function makeQuill(id, placeholder, withImageUpload) {
  const q = new Quill('#' + id, {
    theme: 'snow',
    placeholder,
    modules: { toolbar: TOOLBAR },
  });

  if (withImageUpload) {
    q.getModule('toolbar').addHandler('image', function() {
      const inp = document.createElement('input');
      inp.type = 'file'; inp.accept = 'image/*'; inp.click();
      inp.onchange = async () => {
        const file = inp.files[0];
        if (!file) return;
        const url = await uploadFile(file);
        if (url) {
          const range = q.getSelection(true);
          q.insertEmbed(range.index, 'image', url);
          q.setSelection(range.index + 1);
        }
      };
    });
  }
  return q;
}

// ── Init editors (mount directly into ql-wrap divs) ───
const descEditor    = makeQuill('desc-editor', 'Short project overview…', false);
const contentEditor = makeQuill('content-editor', 'Full case study content — add images, headers, lists…', true);

// Populate existing values
@if(old('description', $project?->description))
  descEditor.root.innerHTML = {!! json_encode(old('description', $project?->description)) !!};
@endif
@if(old('content', $project?->content))
  contentEditor.root.innerHTML = {!! json_encode(old('content', $project?->content)) !!};
@endif

// Sync to hidden inputs on submit
document.getElementById('project-form').addEventListener('submit', () => {
  document.getElementById('desc-input').value    = descEditor.root.innerHTML;
  document.getElementById('content-input').value = contentEditor.root.innerHTML;
});

// ── Cover image ───────────────────────────────────────
const coverFile    = document.getElementById('cover-file');
const coverDrop    = document.getElementById('cover-drop');
const coverPreview = document.getElementById('cover-preview');
const coverPrompt  = document.getElementById('cover-prompt');
const coverImg     = document.getElementById('cover-img');
const coverVal     = document.getElementById('cover-image-val');
const coverSpin    = document.getElementById('cover-uploading');

async function handleCoverFile(file) {
  coverSpin.classList.remove('hidden');
  const url = await uploadFile(file);
  coverSpin.classList.add('hidden');
  if (!url) return;
  coverVal.value = url;
  coverImg.src   = url;
  coverPreview.classList.remove('hidden');
  coverPrompt.classList.add('hidden');
}

coverFile.addEventListener('change', () => { if (coverFile.files[0]) handleCoverFile(coverFile.files[0]); });

coverDrop.addEventListener('dragover', (e) => { e.preventDefault(); coverDrop.classList.add('drag-over'); });
coverDrop.addEventListener('dragleave', () => coverDrop.classList.remove('drag-over'));
coverDrop.addEventListener('drop', (e) => {
  e.preventDefault(); coverDrop.classList.remove('drag-over');
  const file = e.dataTransfer.files[0];
  if (file && file.type.startsWith('image/')) handleCoverFile(file);
});

function removeCover() {
  coverVal.value = '';
  coverImg.src   = '';
  coverPreview.classList.add('hidden');
  coverPrompt.classList.remove('hidden');
}

// ── Gallery images ────────────────────────────────────
const galleryDrop  = document.getElementById('gallery-drop');
const galleryFiles = document.getElementById('gallery-files');
const newGallery   = document.getElementById('new-gallery');
const newUrlsInput = document.getElementById('new-image-urls');
const delIdsInput  = document.getElementById('delete-image-ids');

let newImageUrls = [];
let deleteIds    = [];

function updateHiddenInputs() {
  newUrlsInput.value = JSON.stringify(newImageUrls);
  delIdsInput.value  = deleteIds.join(',');
}

async function addGalleryFile(file) {
  if (!file.type.startsWith('image/')) return;

  // Temp placeholder
  const thumb = document.createElement('div');
  thumb.className = 'gallery-thumb flex items-center justify-center bg-[#111]';
  thumb.innerHTML = '<svg class="animate-spin w-5 h-5 text-[rgba(255,229,0,0.3)]" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>';
  newGallery.appendChild(thumb);
  newGallery.classList.remove('hidden');

  const url = await uploadFile(file);
  if (!url) { thumb.remove(); return; }

  const idx = newImageUrls.length;
  newImageUrls.push(url);
  updateHiddenInputs();

  thumb.innerHTML = `
    <img src="${url}" style="width:100%;height:100%;object-fit:cover;"/>
    <button type="button" class="remove-btn" onclick="removeNewImage(${idx}, this)">✕</button>`;
}

function removeNewImage(idx, btn) {
  newImageUrls.splice(idx, 1);
  btn.closest('.gallery-thumb').remove();
  updateHiddenInputs();
  if (!newImageUrls.length) newGallery.classList.add('hidden');
}

async function removeExistingImage(id, btn) {
  const thumb = btn.closest('.gallery-thumb');
  thumb.style.opacity = '0.4';
  btn.disabled = true;
  const ok = await ajaxDeleteImage(id);
  if (ok) {
    thumb.remove();
  } else {
    thumb.style.opacity = '1';
    btn.disabled = false;
    alert('Could not delete image. Please try again.');
  }
}

galleryFiles.addEventListener('change', async () => {
  for (const f of galleryFiles.files) await addGalleryFile(f);
  galleryFiles.value = '';
});

galleryDrop.addEventListener('dragover', (e) => { e.preventDefault(); galleryDrop.classList.add('drag-over'); });
galleryDrop.addEventListener('dragleave', () => galleryDrop.classList.remove('drag-over'));
galleryDrop.addEventListener('drop', async (e) => {
  e.preventDefault(); galleryDrop.classList.remove('drag-over');
  for (const f of e.dataTransfer.files) await addGalleryFile(f);
});

// ── Multi-embed ───────────────────────────────────────
function addEmbed() {
  const row = document.createElement('div');
  row.className = 'embed-row flex gap-2';
  row.innerHTML = `
    <textarea name="embed_items[]" rows="3"
      class="flex-1 bg-[#050505] border-2 border-[rgba(255,229,0,0.15)] text-[rgba(255,229,0,0.7)] font-mono text-xs px-3 py-2 focus:outline-none focus:border-[#FFE500] transition-colors resize-y"
      placeholder='<iframe src="https://www.youtube.com/embed/..." allowfullscreen></iframe>'></textarea>
    <button type="button" onclick="this.closest('.embed-row').remove()"
      class="w-8 flex-shrink-0 border-2 border-[rgba(255,45,45,0.3)] text-[#FF2D2D] opacity-50 hover:opacity-100 transition-opacity self-start p-1">✕</button>`;
  document.getElementById('embed-list').appendChild(row);
}

// ── Metrics ───────────────────────────────────────────
function addMetric() {
  const row = document.createElement('div');
  row.className = 'metric-row';
  row.innerHTML = `
    <input type="text" name="metrics_val[]"
      class="bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-brutal text-xl px-3 py-2 focus:outline-none focus:border-[#FFE500] placeholder-[rgba(255,229,0,0.15)] transition-colors"
      placeholder="4.2×"/>
    <input type="text" name="metrics_label[]"
      class="bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-xs px-3 py-2 focus:outline-none focus:border-[#FFE500] placeholder-[rgba(255,229,0,0.15)] transition-colors"
      placeholder="ROAS"/>
    <button type="button" onclick="this.closest('.metric-row').remove()"
      class="w-8 h-8 flex items-center justify-center border-2 border-[rgba(255,45,45,0.3)] text-[#FF2D2D] opacity-50 hover:opacity-100 transition-opacity">✕</button>`;
  document.getElementById('metrics-list').appendChild(row);
}

// ── Scope tags ────────────────────────────────────────
let tags = JSON.parse(document.getElementById('scope-json').value || '[]');

function renderTags() {
  const wrap = document.getElementById('tags-wrap');
  wrap.innerHTML = '';
  tags.forEach((tag, i) => {
    const pill = document.createElement('span');
    pill.className = 'tag-pill';
    pill.innerHTML = `${tag} <button type="button" onclick="removeTag(${i})">✕</button>`;
    wrap.appendChild(pill);
  });
  document.getElementById('scope-json').value = JSON.stringify(tags);
}

function removeTag(i) { tags.splice(i, 1); renderTags(); }

document.getElementById('tag-input').addEventListener('keydown', (e) => {
  if (e.key === 'Enter' || e.key === ',') {
    e.preventDefault();
    const val = e.target.value.replace(/,/g, '').trim();
    if (val && !tags.includes(val)) { tags.push(val); renderTags(); }
    e.target.value = '';
  }
});

renderTags();

// ── Slug auto-gen (create only) ───────────────────────
@if(!$project)
  let slugEdited = false;
  document.getElementById('slug').addEventListener('input', () => slugEdited = true);
  document.getElementById('title').addEventListener('input', (e) => {
    if (slugEdited) return;
    document.getElementById('slug').value = e.target.value
      .toLowerCase().replace(/[^\w\s-]/g,'').replace(/[\s_]+/g,'-').replace(/^-+|-+$/g,'');
  });
@endif

// ── Featured toggle knob fix ──────────────────────────
document.getElementById('is_featured').addEventListener('change', (e) => {
  const knob = document.getElementById('toggle-knob');
  if (e.target.checked) {
    knob.style.transform = 'translateX(20px)';
    knob.style.background = '#0A0A0A';
  } else {
    knob.style.transform = '';
    knob.style.background = '';
  }
});
</script>

@endsection
