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
          <div class="brand">
            <div class="brand-title">iSTOCK</div>
          </div>

          <img
            class="hero"
            src="{{ asset('assets/images/admin/login-create/login.jpg') }}"
            alt="istock"
          />
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
</script>

</body>
</html>
