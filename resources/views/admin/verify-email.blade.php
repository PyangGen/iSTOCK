<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Verification</title>

  <!-- Inter (same as login/register) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assets/css/admin/login-create/verify-email.css') }}">
</head>
<body class="verify-email">

  <main class="page">
    <section class="shell">
      <div class="card">

        <!-- LEFT IMAGE -->
        <aside class="left">
          <div class="brand">
            {{-- Use logo.png if you want --}}
            {{-- <img src="{{ asset('assets/images/admin/logo.png') }}" class="brand-logo" alt="H&R Ice Cream" /> --}}

            <div class="brand-text">
              <div class="brand-title">H&amp;R</div>
              <div class="brand-sub">ICE CREAM</div>
            </div>
          </div>

          <img
            class="hero"
            src="{{ asset('assets/images/admin/login-create/verify-email.jpg') }}"
            alt="Ice cream"
          />
        </aside>

        <!-- RIGHT CONTENT -->
        <section class="right">
          <div class="panel">
            <div class="icon-badge" aria-hidden="true">
              <!-- shield icon (inline svg) -->
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                <path d="M12 2l8 4v6c0 5.25-3.5 9.75-8 10-4.5-.25-8-4.75-8-10V6l8-4z"
                      stroke="white" stroke-width="2" stroke-linejoin="round"/>
                <path d="M9 12l2 2 4-5"
                      stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>

            <h1>Verification</h1>
            <p class="subtitle">
              Enter the code sent to <strong>example@gmail.com</strong>
            </p>

            <form action="#" method="POST" class="form">
              @csrf

              <div class="otp">
                <input class="otp-box" inputmode="numeric" maxlength="1" name="d1" />
                <input class="otp-box" inputmode="numeric" maxlength="1" name="d2" />
                <input class="otp-box" inputmode="numeric" maxlength="1" name="d3" />
                <input class="otp-box" inputmode="numeric" maxlength="1" name="d4" />
              </div>

              <div class="meta">
                <div class="left-meta">
                  <span>Didn’t receive code?</span>
                  <a href="#" class="link">Resend now</a>
                </div>
                <div class="timer">5:00</div>
              </div>

              <button type="submit" class="btn">Verify</button>
            </form>
          </div>
        </section>

      </div>
    </section>
  </main>

  <!-- Optional: small OTP auto-jump -->
  <script>
    const inputs = Array.from(document.querySelectorAll('.otp-box'));
    inputs.forEach((input, i) => {
      input.addEventListener('input', () => {
        input.value = input.value.replace(/[^0-9]/g, '');
        if (input.value && inputs[i + 1]) inputs[i + 1].focus();
      });
      input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !input.value && inputs[i - 1]) inputs[i - 1].focus();
      });
    });
  </script>
</body>
</html>
