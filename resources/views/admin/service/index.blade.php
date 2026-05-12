@extends('admin.layout')
@section('title','Services')
@section('page-title','Services')
@section('page-sub','Edit the 8 service offerings')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
  @foreach($services as $s)
  <div class="border-2 border-[rgba(255,229,0,0.1)] overflow-hidden">
    <div class="h-2" style="background:{{ $s->color }}"></div>
    <div class="p-5">
      <div class="flex items-center justify-between mb-3">
        <div class="font-brutal text-[#FFE500] text-xl tracking-wider">{{ $s->name }}</div>
        <span class="font-body text-[9px] font-bold uppercase tracking-widest {{ $s->is_active ? 'text-[#00AA50]' : 'text-[#FF2D2D] opacity-50' }} border border-current px-2 py-1">{{ $s->is_active ? 'Active' : 'Hidden' }}</span>
      </div>
      @if($s->description)<p class="font-body text-xs text-[#FFE500] opacity-40 leading-relaxed mb-3">{{ Str::limit($s->description,90) }}</p>@endif
      @if($s->scope_items)
      <div class="flex flex-wrap gap-1 mb-4">
        @foreach($s->scope_items as $item)
          <span class="font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] border border-[rgba(255,229,0,0.2)] px-2 py-0.5 opacity-50">{{ $item }}</span>
        @endforeach
      </div>
      @endif
      <a href="{{ route('admin.service.edit', $s) }}" class="font-body text-[10px] font-bold uppercase tracking-widest text-[#FFE500] opacity-50 hover:opacity-100 border border-[rgba(255,229,0,0.15)] hover:border-[#FFE500] px-4 py-2 no-underline transition-opacity inline-block">Edit →</a>
    </div>
  </div>
  @endforeach
</div>
@endsection
