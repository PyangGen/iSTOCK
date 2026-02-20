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

  <link rel="stylesheet" href="{{ asset('assets/css/admin/create/signUp.css') }}">
</head>
<body>
  <main class="page">
    <section class="shell">
      <div class="card">

        <!-- LEFT IMAGE -->
        <aside class="left">
          <div class="brand">
            {{-- <img src="{{ asset('assets/images/admin/login-create/logo.png') }}" class="brand-logo" alt="iSTOCK" /> --}}
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

           <form action="{{ route('admin.create.store') }}" method="POST" class="form" id="createForm">
  @csrf

  <div class="grid-2">
    <div class="field">
      <label class="label" for="first_name">First Name</label>
      <input
        id="first_name"
        type="text"
        name="first_name"
        value="{{ old('first_name') }}"
        class="input @error('first_name') is-invalid @enderror"
        placeholder="First name*"
      />
      @error('first_name')
        <p class="error-text">{{ $message }}</p>
      @enderror
    </div>

    <div class="field">
      <label class="label" for="last_name">Last Name</label>
      <input
        id="last_name"
        type="text"
        name="last_name"
        value="{{ old('last_name') }}"
        class="input @error('last_name') is-invalid @enderror"
        placeholder="Last name*"
      />
      @error('last_name')
        <p class="error-text">{{ $message }}</p>
      @enderror
    </div>
  </div>

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

  <div class="field">
    <label class="label" for="password">Create Password</label>
    <input
      id="password"
      type="password"
      name="password"
      class="input @error('password') is-invalid @enderror"
      placeholder="Create password*"
      autocomplete="new-password"
    />
    @error('password')
      <p class="error-text">{{ $message }}</p>
    @enderror
  </div>

  <div class="field">
    <label class="label" for="password_confirmation">Re-enter Password</label>
    <input
      id="password_confirmation"
      type="password"
      name="password_confirmation"
      class="input @error('password_confirmation') is-invalid @enderror"
      placeholder="Re-enter password*"
      autocomplete="new-password"
    />
    @error('password_confirmation')
      <p class="error-text">{{ $message }}</p>
    @enderror
  </div>

  <!-- ✅ Button with default disabled -->
 <button type="submit" class="btn" id="createBtn">Create Account</button>


  <p class="footer-text">
    Already have an account?
    <a href="{{ route('admin.login.signIn') }}" class="link-danger">Sign in</a>
  </p>
</form>

          </div>
        </section>

      </div>
    </section>
  </main>

 @if (session('success'))
  <div class="modal-backdrop" id="successModal" aria-hidden="false">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">

      <div class="modal-head">
        <div class="modal-icon">✓</div>
        <h2 id="modalTitle" class="modal-title">Success</h2>
      </div>

      <p class="modal-text">{{ session('success') }}</p>

      <div class="modal-actions">
        <a href="{{ route('admin.login.signIn') }}" class="modal-link">Go to Sign in</a>
        <button type="button" class="btn btn-primary" id="closeModalBtn">Okay</button>
      </div>
    </div>
  </div>

  <script>
    (function () {
      const modal = document.getElementById('successModal');
      const closeBtn = document.getElementById('closeModalBtn');

      function closeModal() {
        if (!modal) return;
        modal.classList.add('is-hidden');
        modal.setAttribute('aria-hidden', 'true');
      }

      closeBtn?.addEventListener('click', closeModal);

      modal?.addEventListener('click', function (e) {
        if (e.target === modal) closeModal();
      });

      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeModal();
      });
    })();
  </script>
@endif

<script>
(function () {
  const form = document.getElementById('createForm');
  const btn  = document.getElementById('createBtn');

  if (!form || !btn) return;

  const fields = [
    { id: 'first_name', name: 'first_name' },
    { id: 'last_name', name: 'last_name' },
    { id: 'email', name: 'email' },
    { id: 'password', name: 'password' },
    { id: 'password_confirmation', name: 'password_confirmation' },
  ];

  const inputs = fields
    .map(f => ({ ...f, el: document.getElementById(f.id) }))
    .filter(f => f.el);

  function setActiveState() {
    const allFilled = inputs.every(f => f.el.value.trim().length > 0);
    if (allFilled) btn.classList.add('is-active');
    else btn.classList.remove('is-active');
  }

  function clearClientError(inputEl) {
    inputEl.classList.remove('is-invalid');
    const err = inputEl.parentElement.querySelector('.error-text.client');
    if (err) err.remove();
  }

  function showClientError(inputEl, msg) {
    inputEl.classList.add('is-invalid');

    // if server error exists, don't duplicate
    const existing = inputEl.parentElement.querySelector('.error-text.client');
    if (existing) existing.textContent = msg;
    else {
      const p = document.createElement('p');
      p.className = 'error-text client';
      p.textContent = msg;
      inputEl.parentElement.appendChild(p);
    }
  }

  // update button state while typing + remove client error as user types
  inputs.forEach(f => {
    f.el.addEventListener('input', () => {
      setActiveState();
      if (f.el.value.trim().length > 0) clearClientError(f.el);
    });
  });

  // on submit, show required errors if empty (and stop submit)
  form.addEventListener('submit', (e) => {
    let hasEmpty = false;

    inputs.forEach(f => {
      if (f.el.value.trim().length === 0) {
        hasEmpty = true;
        showClientError(f.el, 'This field is required.');
      }
    });

    // stop submit if empty so user sees errors immediately
    if (hasEmpty) e.preventDefault();
  });

  // initial state for old() values
  setActiveState();
})();
</script>


</body>
</html>
