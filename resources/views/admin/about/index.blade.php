@extends('admin.layout')
@section('title','About / Team')
@section('page-title','Studio & Team')
@section('page-sub','Manage team members shown on the Studio page')

@section('header-action')
<button onclick="document.getElementById('add-modal').classList.remove('hidden')" class="inline-flex items-center gap-2 bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-xs uppercase tracking-widest px-5 py-3 border-2 border-[#FFE500] hover:bg-transparent hover:text-[#FFE500] transition-all duration-150">
  <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Add Member
</button>
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
  @foreach($members as $m)
  <div class="border-2 border-[rgba(255,229,0,0.1)] p-5">
    @if($m->photo_url)
      <div class="w-16 h-16 border-2 border-[rgba(255,229,0,0.2)] overflow-hidden mb-4">
        <img src="{{ $m->photo_url }}" class="w-full h-full object-cover"/>
      </div>
    @else
      <div class="w-16 h-16 bg-[rgba(255,229,0,0.08)] border-2 border-[rgba(255,229,0,0.15)] flex items-center justify-center mb-4">
        <span class="font-brutal text-[#FFE500] text-2xl">{{ substr($m->name,0,1) }}</span>
      </div>
    @endif
    <div class="font-body text-sm font-bold text-[#FFE500] mb-0.5">{{ $m->name }}</div>
    <div class="font-body text-[10px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-3">{{ $m->role }}</div>
    @if($m->bio)<p class="font-body text-xs text-[#FFE500] opacity-40 leading-relaxed mb-4">{{ Str::limit($m->bio,80) }}</p>@endif
    <div class="flex gap-2 pt-3 border-t border-[rgba(255,229,0,0.08)]">
      <button onclick="editMember({{ $m->id }}, '{{ addslashes($m->name) }}', '{{ addslashes($m->role) }}', '{{ addslashes($m->bio ?? '') }}', '{{ $m->photo_url }}', '{{ $m->email }}', '{{ $m->instagram }}', '{{ $m->linkedin }}', {{ $m->sort_order }})"
        class="font-body text-[10px] font-bold uppercase tracking-widest text-[#FFE500] opacity-50 hover:opacity-100 border border-[rgba(255,229,0,0.15)] hover:border-[#FFE500] px-3 py-1.5 transition-opacity">Edit</button>
      <form method="POST" action="{{ route('admin.about.destroy', $m) }}" onsubmit="return confirm('Remove member?')">
        @csrf @method('DELETE')
        <button class="font-body text-[10px] font-bold uppercase tracking-widest text-[#FF2D2D] opacity-40 hover:opacity-100 border border-[rgba(255,45,45,0.2)] px-3 py-1.5 transition-opacity">Remove</button>
      </form>
    </div>
  </div>
  @endforeach
</div>

{{-- Add Modal --}}
<div id="add-modal" class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-6">
  <div class="bg-[#0A0A0A] border-2 border-[rgba(255,229,0,0.2)] w-full max-w-lg p-8 overflow-y-auto" style="max-height:90vh;">
    <div class="flex justify-between items-center mb-6">
      <h2 class="font-brutal text-[#FFE500] text-2xl tracking-wider" id="modal-title">Add Member</h2>
      <button onclick="closeModal()" class="text-[#FFE500] opacity-50 hover:opacity-100 text-2xl font-bold">✕</button>
    </div>
    <form id="member-form" method="POST" action="{{ route('admin.about.store') }}">
      @csrf
      <input type="hidden" name="_method" id="form-method" value="POST"/>
      <input type="hidden" name="_id" id="form-id"/>
      <div class="flex flex-col gap-4">
        <div><label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Name *</label>
          <input type="text" name="name" id="f-name" class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-4 py-2.5 focus:outline-none focus:border-[#FFE500] transition-colors" required/></div>
        <div><label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Role *</label>
          <input type="text" name="role" id="f-role" class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-4 py-2.5 focus:outline-none focus:border-[#FFE500] transition-colors" required/></div>
        <div><label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Bio</label>
          <textarea name="bio" id="f-bio" rows="3" class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-4 py-2.5 focus:outline-none focus:border-[#FFE500] transition-colors resize-none"></textarea></div>
        <div><label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Photo URL</label>
          <input type="text" name="photo_url" id="f-photo" class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-4 py-2.5 focus:outline-none focus:border-[#FFE500] transition-colors" placeholder="https://…"/></div>
        <div class="grid grid-cols-2 gap-3">
          <div><label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Email</label>
            <input type="email" name="email" id="f-email" class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-3 py-2.5 focus:outline-none focus:border-[#FFE500] transition-colors"/></div>
          <div><label class="block font-body text-[9px] font-bold uppercase tracking-widest text-[#FFE500] opacity-40 mb-2">Sort</label>
            <input type="number" name="sort_order" id="f-sort" value="0" min="0" class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.15)] text-[#FFE500] font-body text-sm px-3 py-2.5 focus:outline-none focus:border-[#FFE500] transition-colors"/></div>
        </div>
      </div>
      <button type="submit" class="w-full mt-6 bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-sm uppercase tracking-widest py-3 border-2 border-[#FFE500] hover:bg-transparent hover:text-[#FFE500] transition-all duration-150">Save Member</button>
    </form>
  </div>
</div>

<script>
function closeModal() { document.getElementById('add-modal').classList.add('hidden'); document.getElementById('member-form').reset(); document.getElementById('form-method').value='POST'; document.getElementById('member-form').action='{{ route("admin.about.store") }}'; document.getElementById('modal-title').textContent='Add Member'; }
function editMember(id,name,role,bio,photo,email,ig,li,sort) {
  document.getElementById('add-modal').classList.remove('hidden');
  document.getElementById('modal-title').textContent='Edit Member';
  document.getElementById('form-method').value='PUT';
  document.getElementById('member-form').action=`/admin/about/${id}`;
  document.getElementById('f-name').value=name; document.getElementById('f-role').value=role;
  document.getElementById('f-bio').value=bio; document.getElementById('f-photo').value=photo||'';
  document.getElementById('f-email').value=email||''; document.getElementById('f-sort').value=sort;
}
</script>
@endsection
