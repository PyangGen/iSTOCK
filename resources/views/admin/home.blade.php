<link rel="stylesheet" href="{{ asset('assets/css/admin/home.css') }}">

@php
  $currentRoute = Route::currentRouteName();
@endphp

<!-- Bottom Navigation -->
<div class="bottom-nav">
  <a href="{{ route('admin.home.today') }}"
     class="nav-btn {{ str_contains($currentRoute, 'today') ? 'active' : '' }}">
    <span class="material-symbols-outlined">calendar_today</span>
    <span class="nav-label">Today</span>
  </a>

  <a href="{{ route('admin.home.reports') }}"
     class="nav-btn {{ str_contains($currentRoute, 'reports') ? 'active' : '' }}">
    <span class="material-symbols-outlined">bar_chart</span>
    <span class="nav-label">Reports</span>
  </a>

  <a href="#"
     class="nav-btn">
    <span class="material-symbols-outlined">point_of_sale</span>
    <span class="nav-label">Counter</span>
  </a>

  <a href="{{ route('admin.products.index') }}"
     class="nav-btn {{ str_contains($currentRoute, 'products') ? 'active' : '' }}">
    <span class="material-symbols-outlined">inventory_2</span>
    <span class="nav-label">Items</span>
  </a>

  <a href="#"
     class="nav-btn">
    <span class="material-symbols-outlined">more_horiz</span>
    <span class="nav-label">More</span>
  </a>
</div>