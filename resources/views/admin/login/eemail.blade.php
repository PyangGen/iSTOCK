<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Forgot Password</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assets/css/admin/login/eemail.css') }}">
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
            src="{{ asset('assets/images/admin/login-create/forgot password.jpg') }}"
            alt="istock"
          />
        </aside>

        <!-- RIGHT FORM -->
        <section class="right">
          <div class="form-wrap">
            <h1>Forgot Password</h1>
             <p class="subtitle">
        Enter your email address and we will send you a link to reset your password. Please check your inbox after submitting.
  
      </p>

<form action="{{ route('admin.login.send-otp') }}" method="POST" class="form" id="forgotForm">
  @csrf

  <div class="field">
    <label class="label" for="email">Email Address</label>
    <input
      id="email"
      type="email"
      name="email"
      value="{{ old('email') }}"
      class="input @error('email') is-invalid @enderror"
      placeholder="Email address*"
      autocomplete="email"
    />
    @error('email')
      <p class="error-text">{{ $message }}</p>
    @enderror
  </div>

  <button type="submit" class="btn" id="continueBtn">Continue</button>
</form>


          </div>
        </section>

      </div>
    </section>
  </main>
  <script>
(function () {
  const emailEl = document.getElementById('email');
  const btn = document.getElementById('continueBtn');

  if (!emailEl || !btn) return;

  function toggleBtn() {
    const hasValue = emailEl.value.trim().length > 0;
    if (hasValue) btn.classList.add('is-active');
    else btn.classList.remove('is-active');
  }

  // initial (handles old('email'))
  toggleBtn();

  // live update
  emailEl.addEventListener('input', toggleBtn);
})();
</script>

</body>
</html>
