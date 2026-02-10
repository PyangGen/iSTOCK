<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">


  <link rel="stylesheet" href="{{ asset('assets/css/admin/login-create/login.css') }}">
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

          {{-- Replace with your image path --}}
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

            <form action="#" method="POST" class="form">
              @csrf

              <label class="label" for="email">Email Address</label>
              <input
                id="email"
                type="email"
                name="email"
                class="input"
                placeholder="Enter Email*"
                autocomplete="email"
              />

              <label class="label" for="password">Password</label>
              <input
                id="password"
                type="password"
                name="password"
                class="input"
                placeholder="Enter Password*"
                autocomplete="current-password"
              />

              <div class="row-right">
                <a href="#" class="link-danger">Forgot password?</a>
              </div>

              <button type="submit" class="btn">Login</button>

              <p class="footer-text">
                Don’t have an account?
               <a href="{{ route('admin.create') }}" class="link-danger">Sign up</a>

              </p>
            </form>
          </div>
        </section>

      </div>
    </section>
  </main>
</body>
</html>
