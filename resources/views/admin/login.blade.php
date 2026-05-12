<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login — STORYTALE</title>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=Bebas+Neue&display=swap" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: { extend: {
        fontFamily: { brutal: ['Bebas Neue','sans-serif'], body: ['Space Grotesk','sans-serif'] },
        boxShadow: { brutal: '4px 4px 0px #FFE500' },
      }}
    }
  </script>
</head>
<body class="bg-[#0A0A0A] min-h-screen flex items-center justify-center font-body">

  <div class="w-full max-w-sm px-6">

    <!-- Logo -->
    <div class="flex items-center gap-3 mb-10">
      <div class="w-10 h-10 bg-[#FFE500] flex items-center justify-center border-2 border-[#FFE500]">
        <span class="font-brutal text-2xl text-[#0A0A0A] leading-none">S</span>
      </div>
      <div>
        <div class="font-brutal text-[#FFE500] text-2xl tracking-widest leading-none">STORYTALE</div>
        <div class="font-body text-[#FFE500] text-[10px] opacity-40 uppercase tracking-widest mt-0.5">Admin Panel</div>
      </div>
    </div>

    <!-- Card -->
    <div class="border-2 border-[rgba(255,229,0,0.15)] p-8">

      <h1 class="font-brutal text-[#FFE500] text-4xl tracking-wider mb-1">Sign In</h1>
      <p class="font-body text-[#FFE500] text-xs opacity-40 uppercase tracking-widest mb-8">Enter your admin password</p>

      @if($errors->any())
        <div class="border-2 border-[#FF2D2D] bg-[#FF2D2D]/10 px-4 py-3 mb-6">
          <p class="font-body text-[#FF2D2D] text-xs font-bold">{{ $errors->first() }}</p>
        </div>
      @endif

      <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <div class="mb-6">
          <label class="block font-body text-[10px] font-bold uppercase tracking-widest text-[#FFE500] opacity-50 mb-2">Password</label>
          <input
            type="password"
            name="password"
            autofocus
            class="w-full bg-transparent border-2 border-[rgba(255,229,0,0.2)] text-[#FFE500] font-body text-sm px-4 py-3 focus:outline-none focus:border-[#FFE500] transition-colors placeholder-[rgba(255,229,0,0.2)]"
            placeholder="••••••••"
          />
        </div>

        <button type="submit"
          class="w-full bg-[#FFE500] text-[#0A0A0A] font-body font-bold text-sm uppercase tracking-widest py-4 border-2 border-[#FFE500] shadow-brutal hover:translate-x-[3px] hover:translate-y-[3px] hover:shadow-none transition-all duration-150">
          Enter Dashboard →
        </button>
      </form>
    </div>

    <p class="font-body text-[10px] text-[#FFE500] opacity-20 uppercase tracking-widest text-center mt-6">
      © 2026 Storytale · Admin
    </p>
  </div>

</body>
</html>
