@extends('admin.layout')
@section('title','Journal')
@section('page-title','Journal')
@section('page-sub','All journal items — ' . $journals->count() . ' total')

@section('header-action')
<a href="{{ route('admin.journal.create') }}" class="inline-flex items-center gap-2 bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-xs uppercase tracking-widest px-5 py-3 border-2 border-[#FFE500] hover:bg-transparent hover:text-[#FFE500] transition-all duration-150 no-underline" style="box-shadow:3px 3px 0 rgba(255,229,0,0.2);">
  <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> New Item
</a>
@endsection

@section('content')
<div class="border-2 border-[rgba(255,229,0,0.1)] overflow-hidden">
  <div class="grid bg-[rgba(255,229,0,0.04)] border-b border-[rgba(255,229,0,0.1)]" style="grid-template-columns:2fr 120px 100px 90px 120px;">
    @foreach(['Title','Category','Date','Status','Actions'] as $h)
      <div class="px-4 py-3 font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40">{{$h}}</div>
    @endforeach
  </div>
  @forelse($journals as $j)
  <div class="grid border-b border-[rgba(255,229,0,0.06)] hover:bg-[rgba(255,229,0,0.02)] transition-colors" style="grid-template-columns:2fr 120px 100px 90px 120px;">
    <div class="px-4 py-4 flex flex-col gap-0.5 min-w-0">
      <span class="font-body text-sm font-bold text-[#FFE500] truncate">{{ $j->title }}</span>
      @if($j->excerpt)<span class="font-body text-[10px] text-[#FFE500] opacity-25 truncate">{{ Str::limit($j->excerpt,60) }}</span>@endif
    </div>
    <div class="px-4 py-4 flex items-center">
      <span class="font-body text-[10px] font-bold uppercase tracking-widest text-[#FFE500] border border-[rgba(255,229,0,0.2)] px-2 py-1">{{ $j->category }}</span>
    </div>
    <div class="px-4 py-4 flex items-center">
      <span class="font-body text-[10px] text-[#FFE500] opacity-40">{{ $j->published_at?->format('d M Y') ?? '—' }}</span>
    </div>
    <div class="px-4 py-4 flex items-center">
      <span class="badge {{ $j->status === 'published' ? 'badge-published' : 'badge-draft' }}">{{ $j->status }}</span>
    </div>
    <div class="px-4 py-4 flex items-center gap-2">
      <a href="{{ route('admin.journal.edit', $j) }}" class="font-body text-[10px] font-bold uppercase tracking-widest text-[#FFE500] opacity-50 hover:opacity-100 no-underline border border-[rgba(255,229,0,0.15)] hover:border-[#FFE500] px-3 py-1.5 transition-opacity">Edit</a>
      <form method="POST" action="{{ route('admin.journal.destroy', $j) }}" onsubmit="return confirm('Delete?')">
        @csrf @method('DELETE')
        <button class="font-body text-[10px] font-bold uppercase tracking-widest text-[#FF2D2D] opacity-40 hover:opacity-100 border border-[rgba(255,45,45,0.2)] hover:border-[#FF2D2D] px-3 py-1.5 transition-opacity">Del</button>
      </form>
    </div>
  </div>
  @empty
  <div class="px-6 py-16 text-center">
    <p class="font-brutal text-[#FFE500] text-4xl tracking-widest opacity-10">No Items</p>
    <a href="{{ route('admin.journal.create') }}" class="inline-block mt-4 font-body text-xs text-[#FFE500] opacity-40 hover:opacity-100 no-underline transition-opacity">Create first →</a>
  </div>
  @endforelse
</div>
@endsection
