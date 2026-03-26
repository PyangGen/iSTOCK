<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'iStock Admin')</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

  <link rel="stylesheet" href="{{ asset('assets/css/admin/sidebar.css') }}">
  @stack('styles')
</head>

<body>
  <div class="app">

    {{-- Sidebar --}}
    <aside class="sidebar" id="sidebar">
      <div class="brand">
        <img src="{{ asset('assets/images/admin/lg.png') }}" alt="Logo" class="brand-logo-img">
      </div>

      <nav class="nav">
        <div class="nav-section">Management</div>

        <a class="nav-item" href="#">
          <span class="material-symbols-outlined">support_agent</span>
          Help Chat
        </a>

        <a class="nav-item" href="#">
          <span class="material-symbols-outlined">inventory_2</span>
          Inventory Management
        </a>

        <a class="nav-item" href="#">
          <span class="material-symbols-outlined">receipt_long</span>
          Add Expense
        </a>

        <a class="nav-item" href="#">
          <span class="material-symbols-outlined">receipt</span>
          Receipts
        </a>

        <a class="nav-item" href="#">
          <span class="material-symbols-outlined">groups</span>
          Customers Management
        </a>

        <a class="nav-item" href="#">
          <span class="material-symbols-outlined">badge</span>
          Staff Management
        </a>

        <a class="nav-item" href="#">
          <span class="material-symbols-outlined">storefront</span>
          ShopFront <span class="badge">Coming soon</span>
        </a>

        <div class="nav-section">Others</div>

        <a class="nav-item" href="#">
          <span class="material-symbols-outlined">share</span>
          Refer App
        </a>

        <a class="nav-item" href="#">
          <span class="material-symbols-outlined">assignment_return</span>
          Returned Receipt
        </a>

        <a class="nav-item" href="#">
          <span class="material-symbols-outlined">feedback</span>
          Feedback
        </a>

        <a class="nav-item" href="#">
          <span class="material-symbols-outlined">web</span>
          Web Office <span class="badge">Coming soon</span>
        </a>

        <a class="nav-item" href="#">
          <span class="material-symbols-outlined">store</span>
          Buy Franchise <span class="badge">Coming soon</span>
        </a>

        <a class="nav-item" href="#">
          <span class="material-symbols-outlined">print</span>
          Buy Printer <span class="badge">Coming soon</span>
        </a>
      </nav>

      @php
        use Illuminate\Support\Str;

        $admin = auth()->guard('admin')->user();
        $business = \App\Models\BusinessInfo::where('admin_id', $admin->id)->first();
        $businesses = \App\Models\BusinessInfo::where('admin_id', $admin->id)->get();

        $businessName = $business->business_name ?? 'B';
        $firstLetter = strtoupper(substr($businessName, 0, 1));
      @endphp

      <div class="sidebar-footer" id="openProfileModal" style="cursor:pointer;">
        <div class="profile-box">
          @if($business && $business->image)
            <img 
              src="{{ Str::startsWith($business->image, 'http') ? $business->image : asset('storage/' . $business->image) }}" 
              class="profile-img"
            >
          @else
            <div class="profile-img placeholder">
              {{ $firstLetter }}
            </div>
          @endif

          <div class="profile-info">
            <div class="profile-name">{{ $business->business_name ?? 'No Business Yet' }}</div>
            <div class="profile-plan">Free Trial</div>
          </div>
        </div>

        <div class="profile-actions">
          <button class="btn-switch" id="openSwitchModal">Switch Business</button>
          <button class="btn-create">Create Business</button>
        </div>
      </div>
    </aside>

    {{-- Main --}}
    <div class="main">
      <main class="content">
        @yield('content')
      </main>

      <div class="overlay" id="overlay"></div>
    </div>
  </div>

  <div class="profile-modal" id="profileModal">
    <div class="profile-card">
      <div class="modal-section top">
        <div class="modal-row">
          @if($business && $business->image)
            <img 
              src="{{ Str::startsWith($business->image, 'http') ? $business->image : asset('storage/' . $business->image) }}" 
              class="modal-img"
            >
          @else
            <div class="modal-img placeholder">
              {{ $firstLetter }}
            </div>
          @endif

          <div class="modal-info">
            <div class="modal-title">{{ $business->business_name ?? 'No Business' }}</div>
            <div class="modal-sub">{{ $business->mobile_no ?? 'No Number' }}</div>
          </div>

          <button class="edit-btn">Edit Business</button>
        </div>
      </div>

      <hr>

      <div class="modal-section">
        <div class="modal-row">
          @if($admin->avatar)
            <img 
              src="{{ Str::startsWith($admin->avatar, 'http') ? $admin->avatar : asset('storage/' . $admin->avatar) }}" 
              class="modal-img"
            >
          @else
            <div class="modal-img placeholder">
              {{ strtoupper(substr($admin->first_name,0,1)) }}
            </div>
          @endif

          <div class="modal-info">
            <div class="modal-title">{{ $admin->first_name }} {{ $admin->last_name }}</div>
            <div class="modal-sub">{{ $admin->email }}</div>
          </div>

          <button class="edit-btn">Edit Profile</button>
        </div>
      </div>

      <hr>

      <div class="modal-links">
        <div class="modal-item">
          <span class="material-symbols-outlined">workspace_premium</span>
          Upgrade Plan
        </div>

        <div class="modal-item">
          <span class="material-symbols-outlined">language</span>
          Language - English
        </div>

        <div class="modal-item">
          <span class="material-symbols-outlined">scale</span>
          Weighing Machine <span class="badge">Coming soon</span>
        </div>
      </div>

      <hr>

      <div class="modal-links">
        <div class="modal-item">
          <span class="material-symbols-outlined">help</span>
          Help
        </div>

        <form action="{{ route('admin.logout') }}" method="POST" class="modal-item">
          @csrf
          <button type="submit" class="logout-btn">
            <span class="material-symbols-outlined">logout</span>
            Logout
          </button>
        </form>
      </div>
    </div>
  </div>

  <div class="switch-modal" id="switchModal">
    <div class="switch-card">
      <div class="switch-header">
        <h3>Your Businesses</h3>
        <button id="closeSwitchModal">&times;</button>
      </div>

      <button class="add-business-btn">
        + Add New Business
      </button>

      <div class="business-list">
        @foreach($businesses as $biz)
          <div class="business-item">
            @if($biz->image)
              <img 
                src="{{ Str::startsWith($biz->image, 'http') ? $biz->image : asset('storage/' . $biz->image) }}" 
                class="biz-img"
              >
            @else
              <div class="biz-img placeholder">
                <span class="material-symbols-outlined">store</span>
              </div>
            @endif

            <div class="biz-info">
              <div class="biz-name">{{ $biz->business_name }}</div>
              <div class="biz-owner">Owner</div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const openBtn = document.getElementById('openSidebar');

    function openSidebar() {
      sidebar.classList.add('open');
      overlay.classList.add('show');
      document.body.classList.add('no-scroll');
    }

    function closeSidebar() {
      sidebar.classList.remove('open');
      overlay.classList.remove('show');
      document.body.classList.remove('no-scroll');
    }

    openBtn?.addEventListener('click', openSidebar);
    overlay?.addEventListener('click', closeSidebar);

    const profileBtn = document.getElementById('openProfileModal');
    const profileModal = document.getElementById('profileModal');

    const switchBtn = document.getElementById('openSwitchModal');
    const switchModal = document.getElementById('switchModal');
    const closeSwitch = document.getElementById('closeSwitchModal');

    profileBtn.addEventListener('click', (e) => {
      if (e.target.closest('.btn-switch') || e.target.closest('.btn-create')) return;

      profileModal.style.display =
        profileModal.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', function(e) {
      if (!profileBtn.contains(e.target) && !profileModal.contains(e.target)) {
        profileModal.style.display = 'none';
      }
    });

    switchBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      switchModal.style.display = 'flex';
    });

    closeSwitch.addEventListener('click', () => {
      switchModal.style.display = 'none';
    });

    switchModal.addEventListener('click', (e) => {
      if (e.target === switchModal) {
        switchModal.style.display = 'none';
      }
    });
  </script>
</body>
</html>