@extends('admin.sidebar')

@section('title', 'iStock | Products')

@section('content')
@php
  $items = [
    ['name'=>'Rice', 'desc'=>'Staple Item', 'price'=>'₱1,500', 'status'=>'available'],
    ['name'=>'Coffee', 'desc'=>'Beverage', 'price'=>'₱1,300', 'status'=>'out'],
    ['name'=>'Soap', 'desc'=>'Hygiene', 'price'=>'₱150', 'status'=>'low'],
    ['name'=>'Canned Goods', 'desc'=>'Food', 'price'=>'₱250', 'status'=>'available'],
    ['name'=>'Sugar', 'desc'=>'Baking', 'price'=>'₱110', 'status'=>'out'],
  ];
@endphp

<div class="card">
  <div class="card-head">
    <div class="card-title">Product list</div>

    <div class="toolbar">
      <div class="input">
        <span class="badge-ic">🔎</span>
        <input type="text" placeholder="Search by product" />
      </div>

      <button class="btn" type="button">⎚ Filter</button>
      <button class="btn btn-primary" type="button">＋ Add Products</button>
    </div>
  </div>

  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th style="width:44px;"><input type="checkbox"></th>
          <th>Products</th>
          <th style="width:160px;">Price</th>
          <th style="width:160px;">Status</th>
          <th style="width:220px;">Action</th>
        </tr>
      </thead>

      <tbody>
        @foreach($items as $i)
          <tr>
            <td><input type="checkbox"></td>

            <td>
              <div class="row-item">
                <div class="thumb">{{ strtoupper(substr($i['name'], 0, 1)) }}</div>
                <div>
                  <strong>{{ $i['name'] }}</strong>
                  <span class="small">{{ $i['desc'] }}</span>
                </div>
              </div>
            </td>

            <td><strong>{{ $i['price'] }}</strong></td>

            <td>
              @if($i['status'] === 'available')
                <span class="status available"><span class="dot"></span> Available</span>
              @elseif($i['status'] === 'low')
                <span class="status low"><span class="dot"></span> Low Stock</span>
              @else
                <span class="status out"><span class="dot"></span> Out of Stock</span>
              @endif
            </td>

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
      <span style="padding: 0 8px;">1 2 3 4</span>
      <a href="#">Next →</a>
    </div>
  </div>
</div>
@endsection
