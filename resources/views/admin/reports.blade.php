@extends('admin.sidebar')

@section('title', 'iStock | Reports')

@section('content')
@php
  $reports = [
    ['title'=>'Daily Inventory Summary', 'desc'=>'Overview of today’s stock movement', 'date'=>'2026-02-09'],
    ['title'=>'Weekly Inventory Summary', 'desc'=>'Weekly stock in/out and low stock review', 'date'=>'2026-02-03 to 2026-02-09'],
    ['title'=>'Monthly Inventory Summary', 'desc'=>'Monthly movement and stock status overview', 'date'=>'February 2026'],
  ];
@endphp

<div class="card">
  <div class="card-head">
    <div class="card-title">Reports</div>

    <div class="toolbar">
      <div class="input">
        <span class="badge-ic">🔎</span>
        <input type="text" placeholder="Search reports" />
      </div>

      <button class="btn" type="button">⎚ Filter</button>
      <button class="btn btn-primary" type="button">⬇ Export</button>
    </div>
  </div>

  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th style="width:44px;"><input type="checkbox"></th>
          <th>Report</th>
          <th style="width:260px;">Date Range</th>
          <th style="width:220px;">Action</th>
        </tr>
      </thead>

      <tbody>
        @foreach($reports as $r)
          <tr>
            <td><input type="checkbox"></td>
            <td>
              <div class="row-item">
                <div class="thumb">R</div>
                <div>
                  <strong>{{ $r['title'] }}</strong>
                  <span class="small">{{ $r['desc'] }}</span>
                </div>
              </div>
            </td>
            <td>{{ $r['date'] }}</td>
            <td>
              <div class="actions">
                <button class="btn btn-edit" type="button">👁 View</button>
                <button class="btn btn-primary" type="button">⬇ Download</button>
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
      <span style="padding: 0 8px;">1 2</span>
      <a href="#">Next →</a>
    </div>
  </div>
</div>
@endsection
