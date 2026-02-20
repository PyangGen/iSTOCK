@php
$expiresAtRaw = session('admin_forgot_data.expires_at');
  $expiresAt = $expiresAtRaw
      ? (\Illuminate\Support\Carbon::parse($expiresAtRaw)->timestamp)
      : 0;
@endphp


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>OTP Code</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assets/css/admin/login/otp-sent.css') }}">
</head>
<body class="verify-email">

<main class="page">
<section class="shell">
<div class="card">

  <!-- LEFT IMAGE -->
  <aside class="left">
    <div class="brand">
      <div class="brand-text">
        <div class="brand-title">iSTOCK</div>
      </div>
    </div>

    <img
      class="hero"
      src="{{ asset('assets/images/admin/login-create/verify.jpg') }}"
      alt="Ice cream"
    />
  </aside>

  <!-- RIGHT CONTENT -->
  <section class="right">
    <div class="panel">

      <div class="icon-badge" aria-hidden="true">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
          <path d="M12 2l8 4v6c0 5.25-3.5 9.75-8 10-4.5-.25-8-4.75-8-10V6l8-4z"
                stroke="white" stroke-width="2" stroke-linejoin="round"/>
          <path d="M9 12l2 2 4-5"
                stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>

      <h1>Enter OTP Code</h1>

      <p class="subtitle">
        We sent code to 
        <strong>{{ session('admin_forgot_data.email') }}</strong>
      </p>

    {{-- Error message shown above OTP --}}
@error('code')
  <p class="error-text" id="serverCodeError">{{ $message }}</p>
@enderror

{{-- Client error container (JS will use this) --}}
<p class="error-text client" id="clientCodeError" style="display:none;"></p>

@if(session('success'))
  <p class="success-text">{{ session('success') }}</p>
@endif
<form action="{{ route('admin.login.verify-otp') }}"
      method="POST"
      class="form"
      id="verifyForm"
      data-expires-at="{{ $expiresAt }}">

        @csrf

        <input type="hidden" name="code" id="finalCode">

        <div class="otp">
          <input class="otp-box" inputmode="numeric" maxlength="1" />
          <input class="otp-box" inputmode="numeric" maxlength="1" />
          <input class="otp-box" inputmode="numeric" maxlength="1" />
          <input class="otp-box" inputmode="numeric" maxlength="1" />
          <input class="otp-box" inputmode="numeric" maxlength="1" />
          <input class="otp-box" inputmode="numeric" maxlength="1" />
        </div>

        <div class="meta">
          <div class="left-meta">
            <span>Didn’t receive code?</span>
            <a href="{{ route('admin.login.resend-otp') }}" class="link">Resend now</a>
          </div>
          <div class="timer" id="timer">5:00</div>
        </div>

        <button type="submit" class="btn" id="verifyBtn">Continue</button>
      </form>
    </div>
  </section>

</div>
</section>
</main>

<script>
(function () {
  const inputs = Array.from(document.querySelectorAll('.otp-box'));
  const finalCode = document.getElementById('finalCode');
  const form = document.getElementById('verifyForm');
  const btn = document.getElementById('verifyBtn');

  if (!inputs.length || !finalCode || !form || !btn) return;

  function updateCode() {
    finalCode.value = inputs.map(i => i.value).join('');
  }

  function setActiveState() {
    const filled = inputs.every(i => i.value.trim().length === 1);
    if (filled) btn.classList.add('is-active');
    else btn.classList.remove('is-active');
  }

  function clearClientError() {
    const err = form.querySelector('.error-text.client');
    if (err) err.remove();
    inputs.forEach(i => i.classList.remove('is-invalid'));
  }

  function showClientError(msg) {
    // mark all empty boxes invalid
    inputs.forEach(i => {
      if (i.value.trim().length === 0) i.classList.add('is-invalid');
      else i.classList.remove('is-invalid');
    });

    let p = form.querySelector('.error-text.client');
    if (!p) {
      p = document.createElement('p');
      p.className = 'error-text client';
      form.insertBefore(p, form.querySelector('.otp')); // show error above otp
    }
    p.textContent = msg;
  }

  // OTP auto move + cleanup
  inputs.forEach((input, i) => {
    input.addEventListener('input', () => {
      input.value = input.value.replace(/[^0-9]/g, '').slice(0, 1);

      if (input.value && inputs[i + 1]) inputs[i + 1].focus();

      updateCode();
      setActiveState();

      // if user starts typing again, clear client error
      if (input.value) input.classList.remove('is-invalid');
      const hasAny = inputs.some(x => x.value.trim().length > 0);
      if (hasAny) {
        const err = form.querySelector('.error-text.client');
        if (err) err.remove();
      }
    });

    input.addEventListener('keydown', (e) => {
      if (e.key === 'Backspace' && !input.value && inputs[i - 1]) {
        inputs[i - 1].focus();
      }
    });

    // paste support (6 digits)
    input.addEventListener('paste', (e) => {
      const text = (e.clipboardData || window.clipboardData).getData('text');
      const digits = (text || '').replace(/\D/g, '').slice(0, inputs.length);
      if (!digits) return;

      e.preventDefault();
      digits.split('').forEach((d, idx) => {
        if (inputs[idx]) inputs[idx].value = d;
      });

      inputs[Math.min(digits.length, inputs.length) - 1]?.focus();
      updateCode();
      setActiveState();
      clearClientError();
    });
  });

  // On submit: require all 6 digits
  form.addEventListener('submit', (e) => {
    updateCode();
    const filled = inputs.every(i => i.value.trim().length === 1);

    if (!filled) {
      e.preventDefault();
      showClientError('This field is required.');
    }
  });

  // initial state
  updateCode();
  setActiveState();


})();

(function () {
  const form = document.getElementById('verifyForm');
  const expiresAt = parseInt(form?.dataset?.expiresAt || '0', 10);

  const inputs = Array.from(document.querySelectorAll('.otp-box'));
  const finalCode = document.getElementById('finalCode');
  const btn = document.getElementById('verifyBtn');
  const timerDisplay = document.getElementById('timer');

  const clientErr = document.getElementById('clientCodeError');
  const serverErr = document.getElementById('serverCodeError');

  if (!form || !inputs.length || !finalCode || !btn || !timerDisplay) return;

  function updateCode() {
    finalCode.value = inputs.map(i => i.value).join('');
  }

  function setActiveState() {
    const filled = inputs.every(i => i.value.trim().length === 1);
    if (filled) btn.classList.add('is-active');
    else btn.classList.remove('is-active');
  }

  function showClientError(msg) {
    if (serverErr) serverErr.style.display = 'none';
    clientErr.textContent = msg;
    clientErr.style.display = 'block';

    inputs.forEach(i => {
      if (i.value.trim().length === 0) i.classList.add('is-invalid');
    });
  }

  function clearClientError() {
    clientErr.style.display = 'none';
    clientErr.textContent = '';
    inputs.forEach(i => i.classList.remove('is-invalid'));
  }

  function markExpiredUI() {
    btn.classList.remove('is-active');
    showClientError('Verification code is expired.');
  }

  // OTP behavior
  inputs.forEach((input, i) => {
    input.addEventListener('input', () => {
      input.value = input.value.replace(/[^0-9]/g, '').slice(0, 1);
      if (input.value && inputs[i + 1]) inputs[i + 1].focus();
      updateCode();
      setActiveState();

      // user typing clears client errors
      if (clientErr.style.display === 'block') clearClientError();
    });

    input.addEventListener('keydown', (e) => {
      if (e.key === 'Backspace' && !input.value && inputs[i - 1]) {
        inputs[i - 1].focus();
      }
    });

    input.addEventListener('paste', (e) => {
      const text = (e.clipboardData || window.clipboardData).getData('text');
      const digits = (text || '').replace(/\D/g, '').slice(0, inputs.length);
      if (!digits) return;

      e.preventDefault();
      digits.split('').forEach((d, idx) => {
        if (inputs[idx]) inputs[idx].value = d;
      });

      inputs[Math.min(digits.length, inputs.length) - 1]?.focus();
      updateCode();
      setActiveState();
      clearClientError();
    });
  });

  // Persistent timer: uses server expires_at
  function tick() {
    if (!expiresAt) return;

    const now = Math.floor(Date.now() / 1000);
    const remaining = expiresAt - now;

    if (remaining <= 0) {
      timerDisplay.textContent = "00:00";
      markExpiredUI();
      return;
    }

    const m = Math.floor(remaining / 60);
    const s = remaining % 60;
    timerDisplay.textContent =
      String(m).padStart(2, '0') + ":" + String(s).padStart(2, '0');

    requestAnimationFrame(() => {}); // no-op (keeps UI smooth)
    setTimeout(tick, 1000);
  }

  // On submit: block if expired OR incomplete
  form.addEventListener('submit', (e) => {
    updateCode();

    const now = Math.floor(Date.now() / 1000);
    if (expiresAt && now >= expiresAt) {
      e.preventDefault();
      markExpiredUI();
      return;
    }

    const filled = inputs.every(i => i.value.trim().length === 1);
    if (!filled) {
      e.preventDefault();
      showClientError('This field is required.');
    }
  });

  // initial
  updateCode();
  setActiveState();
  tick();
})();
</script>


</body>
</html>
