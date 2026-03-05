@extends('layouts.app')

@section('title','Admin Login')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assets/css/admin/login/signIn.css') }}">
</head>

<body>
  <main class="page">
    <section class="shell">
      <div class="card">

        <!-- LEFT IMAGE -->
        <aside class="left">
         
       <div class="onboard" id="onboard">
  <!-- Slide 1 -->
  <div class="onboard-slide is-active">
    <img
      class="onboard-img"
      src="{{ asset('assets/images/admin/login-create/os.jpg') }}"
      alt="slide 1"
    />

    <div class="onboard-overlay">
      <h2 class="onboard-title">YOUR ONLINE STOREFRONT</h2>
      <p class="onboard-text">
        Start taking online orders. Get a fully loaded e-commerce site that can be shared with your customers.
      </p>

      <div class="onboard-dots" aria-label="Onboarding dots">
        <button type="button" class="dot is-active" aria-label="Go to slide 1" data-slide="0"></button>
        <button type="button" class="dot" aria-label="Go to slide 2" data-slide="1"></button>
        <button type="button" class="dot" aria-label="Go to slide 3" data-slide="2"></button>
      </div>
    </div>
  </div>

  <!-- Slide 2 -->
  <div class="onboard-slide">
    <img
      class="onboard-img"
      src="{{ asset('assets/images/admin/login-create/t.jpg') }}"
      alt="slide 2"
    />

    <div class="onboard-overlay">
      <h2 class="onboard-title">TRACK INVENTORY FAST</h2>
      <p class="onboard-text">
        Monitor stock-in and stock-out in real time, avoid shortages, and stay organized.
      </p>

      <div class="onboard-dots" aria-label="Onboarding dots">
        <button type="button" class="dot" aria-label="Go to slide 1" data-slide="0"></button>
        <button type="button" class="dot is-active" aria-label="Go to slide 2" data-slide="1"></button>
        <button type="button" class="dot" aria-label="Go to slide 3" data-slide="2"></button>
      </div>
    </div>
  </div>

  <!-- Slide 3 -->
  <div class="onboard-slide">
    <img
      class="onboard-img"
      src="{{ asset('assets/images/admin/login-create/sd.jpg') }}"
      alt="slide 3"
    />

    <div class="onboard-overlay">
      <h2 class="onboard-title">SMART REPORTS</h2>
      <p class="onboard-text">
        Generate clear summaries and make better decisions using simple, readable reports.
      </p>

      <div class="onboard-dots" aria-label="Onboarding dots">
        <button type="button" class="dot" aria-label="Go to slide 1" data-slide="0"></button>
        <button type="button" class="dot" aria-label="Go to slide 2" data-slide="1"></button>
        <button type="button" class="dot is-active" aria-label="Go to slide 3" data-slide="2"></button>
      </div>
    </div>
  </div>
</div>
        </aside>

        <!-- RIGHT FORM -->
        <section class="right">
          <div class="form-wrap">
            <h1>Login to your admin panel</h1>

           <form action="{{ route('admin.signIn.store') }}" method="POST" class="form" id="signInForm">
  @csrf

  <!-- EMAIL -->
  <div class="field">
    <label class="label" for="email">Email Address</label>
    <input
      id="email"
      type="email"
      name="email"
      value="{{ old('email') }}"
      class="input @error('email') is-invalid @enderror"
      placeholder="Enter Email*"
      autocomplete="email"
    />
    @error('email')
      <p class="error-text">{{ $message }}</p>
    @enderror
  </div>

  <!-- PASSWORD -->
  <div class="field">
    <label class="label" for="password">Password</label>
    <input
      id="password"
      type="password"
      name="password"
      class="input @error('password') is-invalid @enderror"
      placeholder="Enter Password*"
      autocomplete="current-password"
    />
    @error('password')
      <p class="error-text">{{ $message }}</p>
    @enderror
  </div>

  <div class="row-right">
    <a href="{{ route('admin.login.eemail') }}" class="link-danger">Forgot password?</a>
  </div>

 <button type="submit" class="btn" id="signInBtn">Login</button>
 <!-- Divider -->
<div class="auth-divider">
    <span>Or, Sign In with</span>
</div>

<!-- Google Login -->
<a href="{{ route('admin.google.redirect') }}" class="google-btn">
    <img src="https://developers.google.com/identity/images/g-logo.png">
    <span>Sign In with Google</span>
</a>

  <p class="footer-text">
    Don’t have an account?
    <a href="{{ route('admin.create.signUp') }}" class="link-danger">Sign up</a>
  </p>
</form>


          </div>
        </section>

      </div>
    </section>
  </main>
<script>
(function () {
  const form = document.getElementById('signInForm');
  const btn  = document.getElementById('signInBtn');
  const emailEl = document.getElementById('email');
  const passEl  = document.getElementById('password');

  if (!form || !btn || !emailEl || !passEl) return;

  const inputs = [emailEl, passEl];

  function setActiveState() {
    const ready = emailEl.value.trim().length > 0 && passEl.value.trim().length > 0;
    if (ready) btn.classList.add('is-active');
    else btn.classList.remove('is-active');
  }

  function clearClientError(inputEl) {
    inputEl.classList.remove('is-invalid');
    const err = inputEl.parentElement.querySelector('.error-text.client');
    if (err) err.remove();
  }

  function showClientError(inputEl, msg) {
    inputEl.classList.add('is-invalid');

    // don't duplicate server error blocks, only add client error if not existing
    const existing = inputEl.parentElement.querySelector('.error-text.client');
    if (existing) existing.textContent = msg;
    else {
      const p = document.createElement('p');
      p.className = 'error-text client';
      p.textContent = msg;
      inputEl.parentElement.appendChild(p);
    }
  }

  // update button color + remove client errors as user types
  inputs.forEach((el) => {
    el.addEventListener('input', () => {
      setActiveState();
      if (el.value.trim().length > 0) clearClientError(el);
    });
  });

  // on submit, show required errors (and stop submit)
  form.addEventListener('submit', (e) => {
    let hasEmpty = false;

    if (emailEl.value.trim().length === 0) {
      hasEmpty = true;
      showClientError(emailEl, 'This field is required.');
    }

    if (passEl.value.trim().length === 0) {
      hasEmpty = true;
      showClientError(passEl, 'This field is required.');
    }

    if (hasEmpty) e.preventDefault();
  });

  // initial state (handles old('email'))
  setActiveState();
})();
</script>
@if(session('success'))
<div class="modal-overlay" id="successModal">
  <div class="modal-box">
    <h2>Password Updated</h2>
    <p>{{ session('success') }}</p>
    <button id="closeModalBtn">OK</button>
  </div>
</div>
@endif
<script>
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('successModal');
  const btn = document.getElementById('closeModalBtn');

  if (modal && btn) {
    btn.addEventListener('click', function () {
      modal.style.display = 'none';
    });
  }
});

(function () {
  const root = document.getElementById('onboard');
  if (!root) return;

  const slides = Array.from(root.querySelectorAll('.onboard-slide'));
  let index = 0;
  let timer = null;

  function setActive(i) {
    index = (i + slides.length) % slides.length;

    slides.forEach((s, si) => {
      s.classList.toggle('is-active', si === index);

      // update dots inside each slide (kept per-slide so layout stays identical)
      const dots = Array.from(s.querySelectorAll('.dot'));
      dots.forEach((d) => d.classList.remove('is-active'));
      if (dots[index]) dots[index].classList.add('is-active');
    });
  }

  function start() {
    stop();
    timer = setInterval(() => setActive(index + 1), 3500);
  }

  function stop() {
    if (timer) clearInterval(timer);
    timer = null;
  }

  // dot clicks (event delegation)
  root.addEventListener('click', (e) => {
    const btn = e.target.closest('.dot');
    if (!btn) return;
    const to = Number(btn.dataset.slide);
    if (!Number.isNaN(to)) {
      setActive(to);
      start();
    }
  });

  // pause on hover (nice UX)
  root.addEventListener('mouseenter', stop);
  root.addEventListener('mouseleave', start);

  setActive(0);
  start();

  // swipe support
// swipe support
let startX = 0;
let endX = 0;

root.addEventListener('touchstart', (e) => {
  stop(); // pause autoplay while swiping
  startX = e.touches[0].clientX;
});

root.addEventListener('touchend', (e) => {
  endX = e.changedTouches[0].clientX;
  handleSwipe();
});

function handleSwipe() {
  const diff = startX - endX;

  if (Math.abs(diff) < 50) return;

  if (diff > 0) {
    setActive(index + 1); // swipe left
  } else {
    setActive(index - 1); // swipe right
  }

  start(); // restart autoplay
}
})();
</script>

</body>
</html>
@endsection