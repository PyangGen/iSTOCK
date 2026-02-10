<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Create Admin Account</title>

  <!-- Inter (same as login) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assets/css/admin/login-create/create.css') }}">
</head>
<body>
  <main class="page">
    <section class="shell">
      <div class="card">

        <!-- LEFT IMAGE -->
        <aside class="left">
          <div class="brand">
            <!-- If you want logo image instead of text, uncomment below and remove the text -->
            {{-- <img src="{{ asset('assets/images/admin/login-create/logo.png') }}" class="brand-logo" alt="H&R Ice Cream" /> --}}

            <div class="brand-text">
              <div class="brand-title">iSTOCK</div>
         
            </div>
          </div>

          <img
            class="hero"
            src="{{ asset('assets/images/admin/login-create/create.jpg') }}"
            alt="Ice cream"
          />
        </aside>

        <!-- RIGHT FORM -->
        <section class="right">
          <div class="form-wrap">
            <h1>Create an admin account</h1>

            <form action="#" method="POST" class="form">
              @csrf

              <div class="grid-2">
                <div class="field">
                  <label class="label" for="first_name">First Name</label>
                  <input
                    id="first_name"
                    type="text"
                    name="first_name"
                    class="input"
                    placeholder="First name*"
                    autocomplete="given-name"
                  />
                </div>

                <div class="field">
                  <label class="label" for="last_name">Last Name</label>
                  <input
                    id="last_name"
                    type="text"
                    name="last_name"
                    class="input"
                    placeholder="Last name*"
                    autocomplete="family-name"
                  />
                </div>
              </div>

              <label class="label" for="email">Email Address</label>
              <input
                id="email"
                type="email"
                name="email"
                class="input"
                placeholder="Email address*"
                autocomplete="email"
              />

              <label class="label" for="password">Create Password</label>
              <input
                id="password"
                type="password"
                name="password"
                class="input"
                placeholder="Create password*"
                autocomplete="new-password"
              />

              <label class="label" for="password_confirmation">Re-enter Password</label>
              <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                class="input"
                placeholder="Re-enter password*"
                autocomplete="new-password"
              />

              <button type="submit" class="btn">Create Account</button>

              <p class="footer-text">
                Already have an account?
                <a href="{{ route('admin.login') }}" class="link-danger">Sign in</a>

              </p>
            </form>
          </div>
        </section>

      </div>
    </section>
  </main>
</body>
</html>
