@extends('admin.sidebar')

@section('title', 'iStock | Stock Out')

@section('content')
@php
  $logs = [
    ['product'=>'Rice', 'qty'=>'-3', 'date'=>'2026-02-09', 'by'=>'Owner'],
    ['product'=>'Soap', 'qty'=>'-5', 'date'=>'2026-02-09', 'by'=>'Staff'],
    ['product'=>'Coffee', 'qty'=>'-2', 'date'=>'2026-02-08', 'by'=>'Owner'],
  ];
@endphp

<div class="card">
  <div class="card-head">
    <div class="card-title">Stock Out</div>

    <div class="toolbar">
      <div class="input">
        <span class="badge-ic">🔎</span>
        <input type="text" placeholder="Search stock-out logs" />
      </div>

      <button class="btn btn-primary" type="button">＋ Add Stock Out</button>
    </div>
  </div>

  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th style="width:44px;"><input type="checkbox"></th>
          <th>Product</th>
          <th style="width:160px;">Quantity</th>
          <th style="width:180px;">Date</th>
          <th style="width:180px;">Recorded By</th>
          <th style="width:220px;">Action</th>
        </tr>
      </thead>

      <tbody>
        @foreach($logs as $l)
          <tr>
            <td><input type="checkbox"></td>
            <td>
              <div class="row-item">
                <div class="thumb">{{ strtoupper(substr($l['product'], 0, 1)) }}</div>
                <div><strong>{{ $l['product'] }}</strong><span class="small">Release / sold entry</span></div>
              </div>
            </td>
            <td><strong>{{ $l['qty'] }}</strong></td>
            <td>{{ $l['date'] }}</td>
            <td>{{ $l['by'] }}</td>
            <td>
              <div class="actions">
                <button class="btn btn-edit" type="button">✎ Edit</button>
                <button class="btn btn-danger" type="button">🗑 Delete</button>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="card-foot">
    <div class="pager">
      <a href="#">← Previous</a>
      <span style="padding: 0 8px;">1 2 3</span>
      <a href="#">Next →</a>
    </div>
  </div>
</div>
@endsection
