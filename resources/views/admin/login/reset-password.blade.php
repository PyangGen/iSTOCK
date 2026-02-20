<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reset Password</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assets/css/admin/login/reset-password.css') }}">
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
            src="{{ asset('assets/images/admin/login-create/reset-pass.jpg') }}"
            alt="istock"
          />
        </aside>

        <!-- RIGHT FORM -->
        <section class="right">
          <div class="form-wrap">
            <h1>Reset Password</h1>

<form action="{{ route('admin.login.update-password') }}" method="POST" class="form" id="resetForm">
  @csrf

  <!-- EMAIL (readonly) -->
  <div class="field">
    <label class="label" for="email">Email Address</label>
    <input
      id="email"
      type="email"
      name="email"
      value="{{ $email ?? old('email') }}"
      readonly
      class="input"
    />
  </div>

  <!-- NEW PASSWORD -->
  <div class="field">
    <label class="label" for="password">New Password</label>
    <input
      id="password"
      type="password"
      name="password"
      class="input @error('password') is-invalid @enderror"
      placeholder="Enter New Password*"
      autocomplete="new-password"
    />
    @error('password')
      <p class="error-text">{{ $message }}</p>
    @enderror
  </div>

  <!-- CONFIRM PASSWORD -->
  <div class="field">
    <label class="label" for="password_confirmation">Confirm Password</label>
    <input
      id="password_confirmation"
      type="password"
      name="password_confirmation"
      class="input"
      placeholder="Confirm New Password*"
      autocomplete="new-password"
    />
  </div>

  <button type="submit" class="btn" id="resetBtn">Reset Password</button>
</form>


          </div>
        </section>

      </div>
    </section>
  </main>
<script>
(function () {
  const form = document.getElementById('resetForm');
  const btn  = document.getElementById('resetBtn');
  const passEl  = document.getElementById('password');
  const confirmEl = document.getElementById('password_confirmation');

  if (!form || !btn || !passEl || !confirmEl) return;

  const inputs = [passEl, confirmEl];

  function setButtonState() {
    // button active only if both password fields are non-empty
    const ready = passEl.value.trim().length > 0 && confirmEl.value.trim().length > 0;
    if (ready) btn.classList.add('is-active');
    else btn.classList.remove('is-active');
  }

  // clear client-side error if typing
  function clearClientError(inputEl) {
    inputEl.classList.remove('is-invalid');
    const err = inputEl.parentElement.querySelector('.error-text.client');
    if (err) err.remove();
  }

  function showClientError(inputEl, msg) {
    inputEl.classList.add('is-invalid');

    const existing = inputEl.parentElement.querySelector('.error-text.client');
    if (existing) existing.textContent = msg;
    else {
      const p = document.createElement('p');
      p.className = 'error-text client';
      p.textContent = msg;
      inputEl.parentElement.appendChild(p);
    }
  }

  // check button state on input
  inputs.forEach(el => {
    el.addEventListener('input', () => {
      setButtonState();
      if (el.value.trim().length > 0) clearClientError(el);
    });
  });

  // form validation on submit
  form.addEventListener('submit', (e) => {
    let hasEmpty = false;

    if (passEl.value.trim().length === 0) {
      hasEmpty = true;
      showClientError(passEl, 'This field is required.');
    }

    if (confirmEl.value.trim().length === 0) {
      hasEmpty = true;
      showClientError(confirmEl, 'This field is required.');
    }

    if (passEl.value.trim() !== '' && confirmEl.value.trim() !== '' &&
        passEl.value !== confirmEl.value) {
      hasEmpty = true;
      showClientError(confirmEl, 'Passwords do not match.');
    }

    if (hasEmpty) e.preventDefault();
  });

  // initial state (in case old values exist)
  setButtonState();
})();
</script>

</body>
</html>
