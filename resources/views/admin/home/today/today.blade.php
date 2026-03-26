@extends('admin.sidebar')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/home/today/today.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('title', 'iStock | Today')

@section('content')
@php
  use Illuminate\Support\Collection;

  $admin = auth()->guard('admin')->user();
  $view = request('tab', 'today');

  $transactions = [
    ['image' => null, 'receipt_no' => 'RCPT-1001', 'customer_name' => 'Juan Dela Cruz', 'payment_type' => 'GCash', 'items_qty' => '3 items', 'time_ago' => '5 minutes ago', 'price' => '₱450.00'],
    ['image' => null, 'receipt_no' => 'RCPT-1002', 'customer_name' => 'Maria Santos', 'payment_type' => 'Cash', 'items_qty' => '2 items', 'time_ago' => '12 minutes ago', 'price' => '₱180.00'],
    ['image' => null, 'receipt_no' => 'RCPT-1003', 'customer_name' => 'Paul Reyes', 'payment_type' => 'Card', 'items_qty' => '5 items', 'time_ago' => '25 minutes ago', 'price' => '₱920.00'],
    ['image' => null, 'receipt_no' => 'RCPT-1004', 'customer_name' => 'Anne Lopez', 'payment_type' => 'GCash', 'items_qty' => '1 item', 'time_ago' => '40 minutes ago', 'price' => '₱75.00'],
    ['image' => null, 'receipt_no' => 'RCPT-1005', 'customer_name' => 'Kevin Cruz', 'payment_type' => 'Cash', 'items_qty' => '4 items', 'time_ago' => '50 minutes ago', 'price' => '₱300.00'],
    ['image' => null, 'receipt_no' => 'RCPT-1006', 'customer_name' => 'Lara Gomez', 'payment_type' => 'GCash', 'items_qty' => '2 items', 'time_ago' => '1 hour ago', 'price' => '₱210.00'],
    ['image' => null, 'receipt_no' => 'RCPT-1007', 'customer_name' => 'Jules Tan', 'payment_type' => 'Card', 'items_qty' => '6 items', 'time_ago' => '1 hour ago', 'price' => '₱1,120.00'],
    ['image' => null, 'receipt_no' => 'RCPT-1008', 'customer_name' => 'Mia Flores', 'payment_type' => 'Cash', 'items_qty' => '1 item', 'time_ago' => '2 hours ago', 'price' => '₱95.00'],
    ['image' => null, 'receipt_no' => 'RCPT-1009', 'customer_name' => 'Nico Ramos', 'payment_type' => 'GCash', 'items_qty' => '3 items', 'time_ago' => '2 hours ago', 'price' => '₱410.00'],
    ['image' => null, 'receipt_no' => 'RCPT-1010', 'customer_name' => 'Ella Lim', 'payment_type' => 'Cash', 'items_qty' => '2 items', 'time_ago' => '3 hours ago', 'price' => '₱150.00'],
  ];

$oldReceipts = [
  ['image' => null, 'receipt_no' => 'OR-2041', 'customer_name' => 'Kevin Ramos', 'payment_type' => 'Cash', 'items_qty' => '3 items', 'date_time' => '19 Mar 2024, 8:45 AM', 'price' => '₱320.00'],
  ['image' => null, 'receipt_no' => 'OR-2042', 'customer_name' => 'Liza Torres', 'payment_type' => 'GCash', 'items_qty' => '2 items', 'date_time' => '20 Mar 2024, 1:10 PM', 'price' => '₱560.00'],
  ['image' => null, 'receipt_no' => 'OR-2043', 'customer_name' => 'Mark Santos', 'payment_type' => 'Card', 'items_qty' => '5 items', 'date_time' => '21 Mar 2024, 3:25 PM', 'price' => '₱210.00'],
  ['image' => null, 'receipt_no' => 'OR-2044', 'customer_name' => 'Grace Lim', 'payment_type' => 'Cash', 'items_qty' => '6 items', 'date_time' => '22 Mar 2024, 6:05 PM', 'price' => '₱890.00'],
  ['image' => null, 'receipt_no' => 'OR-2045', 'customer_name' => 'Carlo Reyes', 'payment_type' => 'GCash', 'items_qty' => '1 item', 'date_time' => '22 Mar 2024, 9:15 AM', 'price' => '₱125.00'],
  ['image' => null, 'receipt_no' => 'OR-2046', 'customer_name' => 'Joy Mendoza', 'payment_type' => 'Cash', 'items_qty' => '4 items', 'date_time' => '23 Mar 2024, 10:40 AM', 'price' => '₱470.00'],
  ['image' => null, 'receipt_no' => 'OR-2047', 'customer_name' => 'Sean Uy', 'payment_type' => 'Card', 'items_qty' => '3 items', 'date_time' => '23 Mar 2024, 12:20 PM', 'price' => '₱680.00'],
];

  $todayPerPage = 8;
$oldPerPage = 7;

$todayPage = max((int) request('today_page', 1), 1);
$oldPage = max((int) request('old_page', 1), 1);

$transactionsCollection = collect($transactions);
$oldReceiptsCollection = collect($oldReceipts);

$todayTotal = $transactionsCollection->count();
$oldTotal = $oldReceiptsCollection->count();

$todayPages = max((int) ceil($todayTotal / $todayPerPage), 1);
$oldPages = max((int) ceil($oldTotal / $oldPerPage), 1);

$todayPage = min($todayPage, $todayPages);
$oldPage = min($oldPage, $oldPages);

$paginatedTransactions = $transactionsCollection->forPage($todayPage, $todayPerPage);
$paginatedOldReceipts = $oldReceiptsCollection->forPage($oldPage, $oldPerPage);
@endphp

<header class="topbar">
  <button class="icon-btn show-mobile" id="openSidebar" aria-label="Open menu">☰</button>

  <div class="topbar-left">
    <div class="hello">
      <div class="hello-title">
        Hello, <strong>{{ $admin->first_name ?? 'Owner' }}</strong>
      </div>
      <div class="hello-sub">
        {{ $view === 'old' ? 'Browse old receipts history' : 'Today transactions overview' }}
      </div>
    </div>
  </div>

  <div class="topbar-right">
     <button class="icon-btn" aria-label="Notifications">
    <span class="material-symbols-outlined">notifications</span>
  </button>

    <div class="avatar">
      <span class="material-symbols-outlined">chat</span>
    </div>
  </div>
</header>

<div class="today-page">

  <div class="today-head">
    <div>
      <h1 class="today-title">{{ $view === 'old' ? 'Receipts' : 'Transaction' }}</h1>
      <p class="today-sub">
        {{ $view === 'old'
          ? 'Review previous receipts with date range and detailed records.'
          : 'View today’s transactions and older receipts in one place.' }}
      </p>
    </div>

    <div class="today-actions">
      <a href="{{ route('admin.home.today', ['tab' => 'today']) }}"
         class="pill-btn {{ $view === 'today' ? 'active' : '' }}">
        Today
      </a>

      <a href="{{ route('admin.home.today', ['tab' => 'old']) }}"
         class="pill-btn {{ $view === 'old' ? 'active' : '' }}">
        Old Receipts
      </a>

      <button type="button" class="icon-pill" aria-label="More options">
        <span class="material-symbols-outlined">more_horiz</span>
      </button>
    </div>
  </div>

  @if($view === 'old')
  <div class="receipt-range-grid">
  <div class="range-card">
    <label class="range-label">From</label>
    <input type="text" id="fromDate" class="range-input" placeholder="Select date">
  </div>

  <div class="range-card">
    <label class="range-label">To</label>
    <input type="text" id="toDate" class="range-input" placeholder="Select date">
  </div>
</div>

    <div class="card transaction-card">
      <div class="card-head transaction-toolbar">
        <div class="card-title">Old Receipt List</div>

        <div class="toolbar">
          <div class="input">
            <span class="badge-ic material-symbols-outlined">search</span>
            <input type="text" placeholder="Search receipt or customer">
          </div>
        </div>
      </div>

      <div class="table-wrap">
        <table class="table transaction-table">
          <thead>
            <tr>
              <th style="width: 100px;">Image</th>
              <th style="width: 150px;">Receipt No.</th>
              <th style="width: 190px;">Name of Customer</th>
              <th style="width: 150px;">Type of Payment</th>
              <th style="width: 130px;">Item</th>
              <th style="width: 180px;">Date/Time</th>
              <th style="width: 130px;">Price</th>
        
            </tr>
          </thead>
          <tbody>
           @forelse($paginatedOldReceipts as $r)
  <tr
    class="receipt-preview-row open-receipt-preview-row"
    data-receipt="{{ $r['receipt_no'] }}"
    data-customer="{{ $r['customer_name'] }}"
    data-payment="{{ $r['payment_type'] }}"
    data-price="{{ $r['price'] }}"
  >
    <td>
      <div class="customer-thumb">
        @if($r['image'])
          <img src="{{ $r['image'] }}" alt="{{ $r['customer_name'] }}">
        @else
          <span>{{ strtoupper(substr($r['customer_name'], 0, 1)) }}</span>
        @endif
      </div>
    </td>
    <td><span class="receipt-no">{{ $r['receipt_no'] }}</span></td>
    <td><div class="customer-name">{{ $r['customer_name'] }}</div></td>
    <td><span class="payment-badge">{{ $r['payment_type'] }}</span></td>
   <td>
  <span class="items-qty">{{ $r['items_qty'] ?? '-' }}</span>
</td>
    <td><span class="date-time-text">{{ $r['date_time'] }}</span></td>
    <td><strong class="price-text">{{ $r['price'] }}</strong></td>

  </tr>
@empty
              <tr>
                <td colspan="8">
                  <div class="empty-state">No old receipts found.</div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="card-foot card-foot-center">
  <div class="pager-wrap">
    <div class="pager-summary">
      Showing {{ (($oldPage - 1) * $oldPerPage) + 1 }}-{{ min($oldPage * $oldPerPage, $oldTotal) }} of {{ $oldTotal }}
    </div>

    <div class="pager">
      @if($oldPage > 1)
        <a href="{{ route('admin.home.today', ['tab' => 'old', 'old_page' => $oldPage - 1]) }}">← Previous</a>
      @else
        <span class="pager-disabled">← Previous</span>
      @endif

      @for($i = 1; $i <= $oldPages; $i++)
        <a href="{{ route('admin.home.today', ['tab' => 'old', 'old_page' => $i]) }}"
           class="{{ $i === $oldPage ? 'active' : '' }}">
          {{ $i }}
        </a>
      @endfor

      @if($oldPage < $oldPages)
        <a href="{{ route('admin.home.today', ['tab' => 'old', 'old_page' => $oldPage + 1]) }}">Next →</a>
      @else
        <span class="pager-disabled">Next →</span>
      @endif
    </div>
  </div>

  <div class="foot-action-right">
   <button type="button" class="filter-btn" id="openReceiptFilterModal">
  <span class="material-symbols-outlined">filter_alt</span>
  Filter: All
</button>
  </div>
</div>
  @else
    <div class="card transaction-card">
      <div class="card-head transaction-toolbar">
        <div class="card-title">Transaction List</div>

        <div class="toolbar">
          <div class="input">
            <span class="badge-ic material-symbols-outlined">search</span>
            <input type="text" placeholder="Search receipt or customer">
          </div>
        </div>
      </div>

      <div class="table-wrap">
        <table class="table transaction-table">
          <thead>
            <tr>
              <th style="width: 100px;">Image</th>
              <th style="width: 150px;">Receipt No.</th>
              <th style="width: 150px;">Name of Customer</th>
              <th style="width: 140px;">Type of Payment</th>
              <th style="width: 150px;">Items</th>
              <th style="width: 140px;">Time</th>
              <th style="width: 130px;">Price</th>
              <th style="width: 60px;">View</th>
            </tr>
          </thead>
          <tbody>
            @forelse($paginatedTransactions as $t)
  <tr
    class="transaction-row open-transaction-modal"
    data-receipt="{{ $t['receipt_no'] }}"
    data-customer="{{ $t['customer_name'] }}"
  >
    <td>
      <div class="customer-thumb">
        @if($t['image'])
          <img src="{{ $t['image'] }}" alt="{{ $t['customer_name'] }}">
        @else
          <span>{{ strtoupper(substr($t['customer_name'], 0, 1)) }}</span>
        @endif
      </div>
    </td>

    <td><span class="receipt-no">{{ $t['receipt_no'] }}</span></td>
    <td><div class="customer-name">{{ $t['customer_name'] }}</div></td>
    <td><span class="payment-badge">{{ $t['payment_type'] }}</span></td>
    <td><span class="items-qty">{{ $t['items_qty'] ?? '-' }}</span></td>
    <td><span class="time-ago">{{ $t['time_ago'] }}</span></td>
    <td><strong class="price-text">{{ $t['price'] }}</strong></td>
    <td>
  <button
    type="button"
    class="view-btn open-receipt-preview"
    aria-label="View receipt preview"
    data-receipt="{{ $t['receipt_no'] }}"
    data-customer="{{ $t['customer_name'] }}"
    data-payment="{{ $t['payment_type'] }}"
    data-price="{{ $t['price'] }}"
  >
    <span class="material-symbols-outlined">visibility</span>
  </button>
</td>
  </tr>
@empty
  <tr>
    <td colspan="8">
      <div class="empty-state">No transactions found for today.</div>
    </td>
  </tr>
@endforelse
          </tbody>
        </table>
      </div>

 <div class="card-foot card-foot-center">
  <div class="pager-wrap">
    <div class="pager-summary">
      Showing {{ (($todayPage - 1) * $todayPerPage) + 1 }}-{{ min($todayPage * $todayPerPage, $todayTotal) }} of {{ $todayTotal }}
    </div>

    <div class="pager">
      @if($todayPage > 1)
        <a href="{{ route('admin.home.today', ['tab' => 'today', 'today_page' => $todayPage - 1]) }}">← Previous</a>
      @else
        <span class="pager-disabled">← Previous</span>
      @endif

      @for($i = 1; $i <= $todayPages; $i++)
        <a href="{{ route('admin.home.today', ['tab' => 'today', 'today_page' => $i]) }}"
           class="{{ $i === $todayPage ? 'active' : '' }}">
          {{ $i }}
        </a>
      @endfor

      @if($todayPage < $todayPages)
        <a href="{{ route('admin.home.today', ['tab' => 'today', 'today_page' => $todayPage + 1]) }}">Next →</a>
      @else
        <span class="pager-disabled">Next →</span>
      @endif
    </div>
  </div>
</div>
    </div>
  @endif

</div>
<div class="transaction-modal" id="transactionModal">
  <div class="transaction-modal-card">
    <div class="transaction-modal-head">
      <h3>Transaction Details</h3>
      <button type="button" class="transaction-close-btn" id="closeTransactionModal">
        <span class="material-symbols-outlined">close</span>
      </button>
    </div>

    <div class="transaction-modal-body">
      <div class="transaction-info-grid">
        <div class="transaction-info-item">
          <span class="info-label">Receipt No.</span>
          <span class="info-value" id="modalReceiptNo">-</span>
        </div>

        <div class="transaction-info-item">
          <span class="info-label">Name of Customer</span>
          <span class="info-value" id="modalCustomerName">-</span>
        </div>
      </div>

      <div class="transaction-products-card">
        <div class="products-head">Product Details</div>

        <div class="products-list" id="modalProductsList"></div>

        <div class="products-total">
          <span>Total Item</span>
          <strong id="modalTotalItems">0</strong>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="receipt-filter-modal" id="receiptFilterModal">
  <div class="receipt-filter-card">
    <div class="receipt-filter-head">
      <h3>Select Category Filter</h3>
    </div>

    <div class="receipt-filter-list">
      <label class="receipt-filter-option">
        <input type="radio" name="receipt_filter" value="all" checked>
        <span class="filter-radio"></span>
        <span class="filter-text">All</span>
      </label>

      <label class="receipt-filter-option">
        <input type="radio" name="receipt_filter" value="cash">
        <span class="filter-radio"></span>
        <span class="filter-text">Cash</span>
      </label>

      <label class="receipt-filter-option">
        <input type="radio" name="receipt_filter" value="debit_card">
        <span class="filter-radio"></span>
        <span class="filter-text">Debit Card</span>
      </label>

      <label class="receipt-filter-option">
        <input type="radio" name="receipt_filter" value="credit_card">
        <span class="filter-radio"></span>
        <span class="filter-text">Credit Card</span>
      </label>

      <label class="receipt-filter-option">
        <input type="radio" name="receipt_filter" value="credit">
        <span class="filter-radio"></span>
        <span class="filter-text">Credit</span>
      </label>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  if (document.querySelector("#fromDate")) {
    flatpickr("#fromDate", {
      dateFormat: "Y-m-d",
      defaultDate: "today",
      maxDate: "today"
    });
  }

  if (document.querySelector("#toDate")) {
    flatpickr("#toDate", {
      dateFormat: "Y-m-d",
      defaultDate: "today",
      maxDate: "today"
    });
  }

  /* =========================
     TRANSACTION MODAL
  ========================= */
  const transactionModal = document.getElementById("transactionModal");
  const closeTransactionModal = document.getElementById("closeTransactionModal");
  const modalReceiptNo = document.getElementById("modalReceiptNo");
  const modalCustomerName = document.getElementById("modalCustomerName");
  const modalProductsList = document.getElementById("modalProductsList");
  const modalTotalItems = document.getElementById("modalTotalItems");

  const receiptDetails = {
    "RCPT-1001": [
      { name: "Coca Cola", qty: 3 },
      { name: "Piattos", qty: 2 },
      { name: "Mineral Water", qty: 1 }
    ],
    "RCPT-1002": [
      { name: "Lucky Me Pancit Canton", qty: 2 },
      { name: "Bread", qty: 1 }
    ],
    "RCPT-1003": [
      { name: "Shampoo", qty: 3 },
      { name: "Soap", qty: 2 },
      { name: "Toothpaste", qty: 1 }
    ],
    "RCPT-1004": [
      { name: "Coffee", qty: 1 }
    ],
    "RCPT-1005": [
      { name: "Milk", qty: 2 },
      { name: "Sugar", qty: 1 },
      { name: "Rice", qty: 1 }
    ],
    "RCPT-1006": [
      { name: "Sardines", qty: 2 }
    ],
    "RCPT-1007": [
      { name: "Detergent", qty: 3 },
      { name: "Fabric Conditioner", qty: 2 },
      { name: "Soap", qty: 1 }
    ],
    "RCPT-1008": [
      { name: "Biscuit", qty: 1 }
    ],
    "RCPT-1009": [
      { name: "Softdrink", qty: 2 },
      { name: "Chips", qty: 1 }
    ],
    "RCPT-1010": [
      { name: "Candle", qty: 1 },
      { name: "Match", qty: 1 }
    ]
  };

  function openTransactionModal(receiptNo, customerName) {
    if (!transactionModal) return;

    modalReceiptNo.textContent = receiptNo;
    modalCustomerName.textContent = customerName;

    const products = receiptDetails[receiptNo] || [];
    let total = 0;

    modalProductsList.innerHTML = "";

    products.forEach(product => {
      total += Number(product.qty);

      const row = document.createElement("div");
      row.className = "product-row";
      row.innerHTML = `
        <span class="product-name">${product.name}</span>
        <span class="product-qty">x${product.qty}</span>
      `;
      modalProductsList.appendChild(row);
    });

    modalTotalItems.textContent = total;
    transactionModal.classList.add("show");
    document.body.classList.add("no-scroll");
  }

  function closeTransactionDetailsModal() {
    if (!transactionModal) return;
    transactionModal.classList.remove("show");
    document.body.classList.remove("no-scroll");
  }

  document.querySelectorAll(".open-transaction-modal").forEach(row => {
    row.addEventListener("click", function () {
      openTransactionModal(this.dataset.receipt, this.dataset.customer);
    });
  });

  closeTransactionModal?.addEventListener("click", closeTransactionDetailsModal);

  transactionModal?.addEventListener("click", function (e) {
    if (e.target === transactionModal) {
      closeTransactionDetailsModal();
    }
  });
  
    /* =========================
     OLD RECEIPTS FILTER MODAL
  ========================= */
  const openReceiptFilterModal = document.getElementById("openReceiptFilterModal");
  const receiptFilterModal = document.getElementById("receiptFilterModal");

  function showReceiptFilterModal() {
    receiptFilterModal?.classList.add("show");
    document.body.classList.add("no-scroll");
  }

  function hideReceiptFilterModal() {
    receiptFilterModal?.classList.remove("show");
    document.body.classList.remove("no-scroll");
  }

  openReceiptFilterModal?.addEventListener("click", function (e) {
    e.stopPropagation();
    showReceiptFilterModal();
  });

  receiptFilterModal?.addEventListener("click", function (e) {
    if (e.target === receiptFilterModal) {
      hideReceiptFilterModal();
    }
  });

  document.querySelectorAll('input[name="receipt_filter"]').forEach(option => {
    option.addEventListener("change", function () {
      const filterLabel = this.closest(".receipt-filter-option")?.querySelector(".filter-text")?.textContent?.trim() || "All";
      if (openReceiptFilterModal) {
        openReceiptFilterModal.innerHTML = `
          <span class="material-symbols-outlined">filter_alt</span>
          Filter: ${filterLabel}
        `;
      }
      hideReceiptFilterModal();
    });
  });
  });

</script>
@include('admin.home')
@include('admin.home.today.receipt-preview')
@endsection