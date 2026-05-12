@extends('admin.layout')

@section('title', 'Work')
@section('page-title', 'Work')
@section('page-sub', 'All projects — ' . $projects->count() . ' total')

@section('header-action')
  <a href="{{ route('admin.work.create') }}"
    class="inline-flex items-center gap-2 bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-xs uppercase tracking-widest px-5 py-3 border-2 border-[#FFE500] hover:bg-transparent hover:text-[#FFE500] transition-all duration-150 no-underline"
    style="box-shadow:3px 3px 0 rgba(255,229,0,0.2);">
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    New Project
  </a>
@endsection

@section('content')

{{-- Filters --}}
<form method="GET" class="flex flex-wrap gap-3 mb-6">
  <input
    type="text" name="search" value="{{ request('search') }}"
    placeholder="Search title or client…"
    class="bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-xs px-4 py-2 focus:outline-none focus:border-[#FFE500] placeholder-[rgba(255,229,0,0.2)] w-64"
  />
  <select name="category"
    class="bg-[#0A0A0A] border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-xs px-4 py-2 focus:outline-none focus:border-[#FFE500]">
    <option value="">All Categories</option>
    @foreach($categories as $cat)
      <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
        {{ $cat->name }}
      </option>
    @endforeach
  </select>
  <button type="submit"
    class="bg-transparent border-2 border-[rgba(255,229,0,0.2)] text-[#FFE500] font-body text-xs font-bold uppercase tracking-widest px-4 py-2 hover:border-[#FFE500] transition-colors">
    Filter
  </button>
  @if(request('search') || request('category'))
    <a href="{{ route('admin.work.index') }}"
      class="border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] opacity-40 hover:opacity-100 font-body text-xs font-bold uppercase tracking-widest px-4 py-2 no-underline transition-opacity">
      Clear
    </a>
  @endif
</form>

{{-- Table --}}
<div class="border-2 border-[rgba(255,229,0,0.1)] overflow-hidden">

  {{-- Header --}}
  <div class="grid bg-[rgba(255,229,0,0.04)] border-b border-[rgba(255,229,0,0.1)]"
    style="grid-template-columns: 2fr 1fr 80px 90px 80px 110px;">
    @foreach(['Project', 'Category', 'Year', 'Status', 'Featured', 'Actions'] as $h)
      <div class="px-4 py-3 font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40">{{ $h }}</div>
    @endforeach
  </div>

  {{-- Rows --}}
  @forelse($projects as $project)
    <div class="grid border-b border-[rgba(255,229,0,0.06)] hover:bg-[rgba(255,229,0,0.02)] transition-colors group"
      style="grid-template-columns: 2fr 1fr 80px 90px 80px 110px;">

      {{-- Title + client --}}
      <div class="px-4 py-4 flex flex-col justify-center gap-0.5 min-w-0">
        <span class="font-body text-sm font-bold text-[#FFE500] leading-tight truncate">{{ $project->title }}</span>
        <span class="font-body text-[10px] text-[#FFE500] opacity-30 uppercase tracking-widest">{{ $project->client }}</span>
      </div>

      {{-- Category --}}
      <div class="px-4 py-4 flex items-center">
        @if($project->category)
          <span class="badge" style="color:{{ $project->category->color ?? '#FFE500' }}; border-color:{{ $project->category->color ?? 'rgba(255,229,0,0.3)' }}80; background:{{ $project->category->color ?? '#FFE500' }}11;">
            {{ $project->category->name }}
          </span>
        @else
          <span class="font-body text-[10px] text-[#FFE500] opacity-20">—</span>
        @endif
      </div>

      {{-- Year --}}
      <div class="px-4 py-4 flex items-center">
        <span class="font-brutal text-[#FFE500] text-lg tracking-wider opacity-60">{{ $project->project_year }}</span>
      </div>

      {{-- Status toggle --}}
      <div class="px-4 py-4 flex items-center">
        <button
          onclick="toggleStatus({{ $project->id }}, this)"
          data-status="{{ $project->status }}"
          class="badge {{ $project->status === 'published' ? 'badge-published' : 'badge-draft' }} cursor-pointer hover:opacity-80 transition-opacity border-0"
          style="border:1px solid currentColor;">
          {{ $project->status }}
        </button>
      </div>

      {{-- Featured toggle --}}
      <div class="px-4 py-4 flex items-center">
        <button
          onclick="toggleFeatured({{ $project->id }}, this)"
          data-featured="{{ $project->is_featured ? '1' : '0' }}"
          class="w-8 h-8 border-2 flex items-center justify-center transition-all duration-150 {{ $project->is_featured ? 'border-[#FFE500] bg-[#FFE500] text-[#0A0A0A]' : 'border-[rgba(255,229,0,0.2)] text-[rgba(255,229,0,0.2)] hover:border-[#FFE500] hover:text-[#FFE500]' }}">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        </button>
      </div>

      {{-- Actions --}}
      <div class="px-4 py-4 flex items-center gap-2">
        <a href="{{ route('admin.work.edit', $project) }}"
          class="inline-flex items-center gap-1 font-body text-[10px] font-bold uppercase tracking-widest text-[#FFE500] opacity-50 hover:opacity-100 no-underline transition-opacity border border-[rgba(255,229,0,0.15)] hover:border-[#FFE500] px-3 py-1.5">
          Edit
        </a>
        <form method="POST" action="{{ route('admin.work.destroy', $project) }}"
          onsubmit="return confirm('Delete «{{ addslashes($project->title) }}»?')">
          @csrf @method('DELETE')
          <button type="submit"
            class="inline-flex items-center font-body text-[10px] font-bold uppercase tracking-widest text-[#FF2D2D] opacity-40 hover:opacity-100 transition-opacity border border-[rgba(255,45,45,0.2)] hover:border-[#FF2D2D] px-3 py-1.5">
            Del
          </button>
        </form>
      </div>

    </div>
  @empty
    <div class="px-6 py-16 text-center">
      <p class="font-brutal text-[#FFE500] text-4xl tracking-widest opacity-10">No Projects</p>
      <a href="{{ route('admin.work.create') }}" class="inline-block mt-4 font-body text-xs text-[#FFE500] opacity-40 hover:opacity-100 no-underline transition-opacity">
        Create your first project →
      </a>
    </div>
  @endforelse
</div>

<script>
  const csrfToken = '{{ csrf_token() }}';

  async function toggleStatus(id, btn) {
    const res  = await fetch(`/admin/work/${id}/toggle-status`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken } });
    const data = await res.json();
    btn.dataset.status  = data.status;
    btn.textContent     = data.status;
    btn.className = btn.className.replace(/badge-(published|draft)/, '');
    btn.classList.add(data.status === 'published' ? 'badge-published' : 'badge-draft');
  }

  async function toggleFeatured(id, btn) {
    const res  = await fetch(`/admin/work/${id}/toggle-featured`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken } });
    const data = await res.json();
    btn.dataset.featured = data.is_featured ? '1' : '0';
    if (data.is_featured) {
      btn.className = btn.className.replace('border-[rgba(255,229,0,0.2)] text-[rgba(255,229,0,0.2)] hover:border-[#FFE500] hover:text-[#FFE500]', 'border-[#FFE500] bg-[#FFE500] text-[#0A0A0A]');
    } else {
      btn.className = btn.className.replace('border-[#FFE500] bg-[#FFE500] text-[#0A0A0A]', 'border-[rgba(255,229,0,0.2)] text-[rgba(255,229,0,0.2)] hover:border-[#FFE500] hover:text-[#FFE500]');
    }
  }
</script>

@endsection
