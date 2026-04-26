<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{asset('asset/css/register.css')}}">

</head>
<body class="flex items-center justify-center min-h-screen px-4 py-8">

  <!-- Arc lines -->
  <div class="arc-bg">
    <svg viewBox="0 0 1280 900" preserveAspectRatio="xMidYMid slice" fill="none" xmlns="http://www.w3.org/2000/svg">
      <ellipse cx="640" cy="600" rx="460" ry="420" stroke="rgba(255,255,255,0.35)" stroke-width="1.2"/>
      <ellipse cx="640" cy="640" rx="580" ry="530" stroke="rgba(255,255,255,0.25)" stroke-width="1"/>
      <ellipse cx="640" cy="680" rx="700" ry="640" stroke="rgba(255,255,255,0.18)" stroke-width="0.8"/>
    </svg>
  </div>

  <!-- Clouds -->
  <div class="cloud cloud-1"></div>
  <div class="cloud cloud-2"></div>
  <div class="cloud cloud-3"></div>

  <!-- Branding -->
  <div class="absolute top-5 left-6 flex items-center gap-2 z-10">
    <div class="w-8 h-8 rounded-lg bg-white/80 backdrop-blur flex items-center justify-center shadow-sm border border-white/60">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
        <path d="M13 2L4 14h7l-1 8 9-12h-7l1-8z" fill="#1a1a1a" stroke="#1a1a1a" stroke-width="0.5" stroke-linejoin="round"/>
      </svg>
    </div>
    <span class="text-gray-800 font-semibold text-base tracking-tight">Duit Mu mas</span>
  </div>

  <!-- Card -->
  <div class="card-wrapper w-full max-w-md">
    <div class="card rounded-3xl p-8 pt-10">

      <!-- Icon -->
      <div class="flex justify-center mb-6">
        <div class="icon-box w-14 h-14 rounded-2xl flex items-center justify-center">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <line x1="19" y1="8" x2="19" y2="14"/>
            <line x1="22" y1="11" x2="16" y2="11"/>
          </svg>
        </div>
      </div>

      <!-- Heading -->
      <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-2 tracking-tight">Create your account</h1>
        <p class="text-gray-500 text-sm leading-relaxed">Make a new doc to bring your words, data,<br/>and teams together. For free</p>
      </div>

      <!-- Fields -->
      <div class="space-y-3">
        <form action="{{ route('register') }}" method="POST" class="space-y-3">
          @csrf
        <!-- Full Name -->
        <div class="input-field flex items-center gap-3 rounded-xl px-4 py-3">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
          </svg>
          <input type="text" name="name" placeholder="Full name" />
        </div>

        <!-- Email -->
        <div class="input-field flex items-center gap-3 rounded-xl px-4 py-3">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
            <rect x="2" y="4" width="20" height="16" rx="2"/>
            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
          </svg>
          <input type="email" name="email" placeholder="Email address" />
        </div>

        <!-- Password -->
        <div class="input-field flex items-center gap-3 rounded-xl px-4 py-3">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
            <rect x="3" y="11" width="18" height="11" rx="2"/>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
          <input type="password" id="password" name="password" placeholder="Password" />
          <button type="button" class="toggle-pwd shrink-0 ml-auto" onclick="togglePass('password', 'eye1Off', 'eye1On')">
            <svg id="eye1Off" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
              <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/>
              <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/>
              <line x1="2" y1="2" x2="22" y2="22"/>
            </svg>
            <svg id="eye1On" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="display:none">
              <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>

        <!-- Confirm Password -->
        <div class="input-field flex items-center gap-3 rounded-xl px-4 py-3">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
          </svg>
          <input type="password" id="confirmPassword" name="password_confirmation" placeholder="Confirm password" />
          <button type="button" class="toggle-pwd shrink-0 ml-auto" onclick="togglePass('confirmPassword', 'eye2Off', 'eye2On')">
            <svg id="eye2Off" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
              <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/>
              <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/>
              <line x1="2" y1="2" x2="22" y2="22"/>
            </svg>
            <svg id="eye2On" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="display:none">
              <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>

        <!-- CTA -->
        <button class="btn-primary w-full rounded-xl py-3.5 text-white font-semibold text-sm tracking-wide">
            Create Account
        </button>
        
    </form>
        
      </div>

      <!-- Divider -->
      <div class="flex items-center gap-3 my-5">
        <div class="flex-1 h-px bg-gray-200/70"></div>
        <span class="text-xs text-gray-400 font-medium">Or sign up with</span>
        <div class="flex-1 h-px bg-gray-200/70"></div>
      </div>

      <!-- Social — Google & Facebook only -->
      <div class="grid grid-cols-2 gap-3">
        <button class="social-btn rounded-xl py-3 flex items-center justify-center gap-2">
          <svg width="20" height="20" viewBox="0 0 24 24">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
          </svg>
          <span class="text-sm font-medium text-gray-600">Google</span>
        </button>

        <button class="social-btn rounded-xl py-3 flex items-center justify-center gap-2">
          <svg width="20" height="20" viewBox="0 0 24 24">
            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" fill="#1877F2"/>
          </svg>
          <span class="text-sm font-medium text-gray-600">Facebook</span>
        </button>
      </div>

      <!-- Sign in link -->
      <p class="text-center text-sm text-gray-400 mt-5">
        Already have an account?
        <a href="{{ route('login') }}" class="text-gray-800 font-semibold hover:underline ml-1">Sign in</a>
      </p>

    </div>
  </div>

  <script src="{{ asset('asset/js/register.js') }}"></script>

</body>
</html>