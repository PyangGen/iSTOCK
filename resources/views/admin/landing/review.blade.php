@extends('admin.landing.layout')
@section('landing-content')
<div class="demo-card reveal">
    <div class="top-bar">
        <div>
            <p class="mini-label">Step 2 of 4</p>
            <h2>Review Demo Order</h2>
        </div>
        <div class="stepper">
            <span class="done"></span>
            <span class="active"></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div class="review-layout">
        <div class="order-card glow-card">
            <div class="selected-product">
                <img src="{{ asset($selectedProduct['image']) }}" alt="{{ $selectedProduct['name'] }}">
                <div>
                    <h3>{{ $selectedProduct['name'] }}</h3>
                    <p>{{ $qty }} x ₱{{ number_format($selectedProduct['price']) }}</p>
                </div>
                <strong>₱{{ number_format($lineTotal) }}</strong>
            </div>

            <div class="summary-box">
                <div><span>Subtotal</span><strong>₱{{ number_format($subtotal) }}</strong></div>
                <div><span>Tax @ 15%</span><strong>₱{{ number_format($tax) }}</strong></div>
                <div><span>Discount</span><strong class="text-danger">-₱{{ number_format($discount) }}</strong></div>
                <div class="grand-total"><span>Grand Total</span><strong>₱{{ number_format($grandTotal) }}</strong></div>
            </div>
        </div>

        <div class="side-note">
            <a href="{{ route('admin.payment', ['product' => $selectedProduct['id'], 'qty' => $qty]) }}" class="btn btn-primary btn-block btn-lg">
                Continue to Payment
            </a>
        </div>
    </div>
</div>
@endsection