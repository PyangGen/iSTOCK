@extends('admin.sidebar')

@section('title', 'iStock | Dashboard')

@section('content')
@php
  // Demo numbers (replace with real DB values later)
  $stats = [
    ['title'=>'Total Products', 'value'=>'128', 'hint'=>'All items in your inventory', 'icon'=>'▦'],
    ['title'=>'Available Items', 'value'=>'94', 'hint'=>'In stock and ready', 'icon'=>'✅'],
    ['title'=>'Low Stock', 'value'=>'18', 'hint'=>'Needs restocking soon', 'icon'=>'⚠'],
    ['title'=>'Out of Stock', 'value'=>'16', 'hint'=>'No remaining stock', 'icon'=>'⛔'],
  ];

  // Demo recent movements
  $recent = [
    ['type'=>'Stock In',  'product'=>'Rice',     'qty'=>'+10', 'date'=>'2026-02-09', 'by'=>'Owner', 'status'=>'available'],
    ['type'=>'Stock Out', 'product'=>'Coffee',   'qty'=>'-3',  'date'=>'2026-02-09', 'by'=>'Staff', 'status'=>'low'],
    ['type'=>'Stock Out', 'product'=>'Sugar',    'qty'=>'-5',  'date'=>'2026-02-08', 'by'=>'Owner', 'status'=>'out'],
    ['type'=>'Stock In',  'product'=>'Soap',     'qty'=>'+20', 'date'=>'2026-02-08', 'by'=>'Staff', 'status'=>'available'],
  ];
@endphp

<div class="dash">

  <div class="dash-head">
    <div>
      <h1 class="dash-title">Dashboard</h1>
      <p class="dash-sub">Quick overview of inventory status and recent activity.</p>
    </div>

    <div class="dash-actions">
      <a class="btn" href="{{ route('admin.reports') }}">▤ View Reports</a>
      <a class="btn btn-primary" href="{{ route('admin.products') }}">＋ Manage Products</a>
    </div>
  </div>

  {{-- Stat cards --}}
  <div class="stats-grid">
    @foreach($stats as $s)
      <div class="stat-card">
        <div class="stat-ic">{{ $s['icon'] }}</div>
        <div class="stat-meta">
          <div class="stat-title">{{ $s['title'] }}</div>
          <div class="stat-value">{{ $s['value'] }}</div>
          <div class="stat-hint">{{ $s['hint'] }}</div>
        </div>
      </div>
    @endforeach
  </div>

  {{-- Recent Activity Table (same look style as your photo) --}}
  <div class="card">
    <div class="card-head">
      <div class="card-title">Recent Activity</div>

      <div class="toolbar">
        <div class="input">
          <span class="badge-ic">🔎</span>
          <input type="text" placeholder="Search activity" />
        </div>
        <a class="btn" href="{{ route('admin.stockin') }}">⬆ Stock In</a>
        <a class="btn" href="{{ route('admin.stockout') }}">⬇ Stock Out</a>
      </div>
    </div>

    <div class="table-wrap">
      <table class="table">
        <thead>
          <tr>
            <th style="width:44px;"><input type="checkbox"></th>
            <th>Type</th>
            <th>Product</th>
            <th style="width:140px;">Qty</th>
            <th style="width:170px;">Date</th>
            <th style="width:160px;">By</th>
            <th style="width:170px;">Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($recent as $r)
            <tr>
              <td><input type="checkbox"></td>

              <td><strong>{{ $r['type'] }}</strong></td>

              <td>
                <div class="row-item">
                  <div class="thumb">{{ strtoupper(substr($r['product'], 0, 1)) }}</div>
                  <div>
                    <strong>{{ $r['product'] }}</strong>
                    <span class="small">Inventory movement</span>
                  </div>
                </div>
              </td>

              <td><strong>{{ $r['qty'] }}</strong></td>
              <td>{{ $r['date'] }}</td>
              <td>{{ $r['by'] }}</td>

              <td>
                @if($r['status'] === 'available')
                  <span class="status available"><span class="dot"></span> Available</span>
                @elseif($r['status'] === 'low')
                  <span class="status low"><span class="dot"></span> Low Stock</span>
                @else
                  <span class="status out"><span class="dot"></span> Out of Stock</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="card-foot">
      <div class="pager">
        <a href="#">← Previous</a>
        <span style="padding:0 8px;">1 2</span>
        <a href="#">Next →</a>
      </div>
    </div>
  </div>

</div>
@endsection
