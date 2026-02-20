<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'iStock Admin')</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assets/css/admin/sidebar.css') }}">
</head>

<body>
  <div class="app">

    {{-- Sidebar --}}
    <aside class="sidebar" id="sidebar">
      <div class="brand">
        <div class="brand-logo">i<span>Stock</span></div>
        <div class="brand-sub">Inventory System</div>
      </div>

      <nav class="nav">
        <div class="nav-section">Menu</div>

         <a class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
            href="{{ route('admin.dashboard') }}">
            <span class="nav-ic">⌂</span> Dashboard
        </a>


        <a class="nav-item {{ request()->routeIs('admin.products') ? 'active' : '' }}"
           href="{{ route('admin.products') }}">
          <span class="nav-ic">▦</span> Products
        </a>

        <a class="nav-item {{ request()->routeIs('admin.stockin') ? 'active' : '' }}"
           href="{{ route('admin.stockin') }}">
          <span class="nav-ic">⬆</span> Stock In
        </a>

        <a class="nav-item {{ request()->routeIs('admin.stockout') ? 'active' : '' }}"
           href="{{ route('admin.stockout') }}">
          <span class="nav-ic">⬇</span> Stock Out
        </a>

        <a class="nav-item {{ request()->routeIs('admin.reports') ? 'active' : '' }}"
           href="{{ route('admin.reports') }}">
          <span class="nav-ic">▤</span> Reports
        </a>

        <div class="nav-section">Settings</div>
        <a class="nav-item" href="#">
          <span class="nav-ic">⚙</span> Account
        </a>
       <form action="{{ route('admin.logout') }}" method="POST" class="nav-logout-form">
    @csrf
    <button type="submit" class="nav-item danger nav-btn">
        <span class="nav-ic">⎋</span> Logout
    </button>
</form>

      </nav>
    </aside>

    

    {{-- Main --}}
    <div class="main">

      {{-- Topbar --}}
      <header class="topbar">
        <button class="icon-btn show-mobile" id="openSidebar" aria-label="Open menu">☰</button>

        <div class="topbar-left">
          <div class="hello">
            <div class="hello-title">Hello, <strong>Owner</strong></div>
            <div class="hello-sub">Administrator</div>
          </div>
        </div>

        <div class="topbar-right">
          <button class="icon-btn" aria-label="Notifications">🔔</button>
          <div class="avatar">O</div>
        </div>
      </header>

      {{-- Content --}}
      <main class="content">
        @yield('content')
      </main>

      {{-- Overlay for mobile sidebar --}}
      <div class="overlay" id="overlay"></div>
    </div>
  </div>

  <script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const openBtn = document.getElementById('openSidebar');

    function openSidebar(){
      sidebar.classList.add('open');
      overlay.classList.add('show');
      document.body.classList.add('no-scroll');
    }
    function closeSidebar(){
      sidebar.classList.remove('open');
      overlay.classList.remove('show');
      document.body.classList.remove('no-scroll');
    }

    openBtn?.addEventListener('click', openSidebar);
    overlay?.addEventListener('click', closeSidebar);
  </script>
</body>
</html>
