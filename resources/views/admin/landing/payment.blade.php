@extends('admin.landing.layout')

@section('landing-content')
<div class="demo-card reveal">
    <div class="top-bar">
        <div>
            <p class="mini-label">Step 3 of 4</p>
            <h2>Select Demo Payment Mode</h2>
        </div>
        <div class="stepper">
            <span class="done"></span>
            <span class="done"></span>
            <span class="active"></span>
            <span></span>
        </div>
    </div>

    <div class="payment-layout">
        <div class="payment-grid">
            @foreach($paymentMethods as $method)
                @php
                    $isCash = strtolower($method['name']) === 'cash';
                @endphp

                @if($isCash)
                    <a
                        href="{{ route('admin.receipt', ['product' => $selectedProduct['id'], 'payment' => $method['name'], 'qty' => $qty]) }}"
                        class="payment-card pop-card selectable-payment"
                        data-selectable="true"
                    >
                        <div class="payment-icon">{{ $method['icon'] }}</div>
                        <h3>{{ $method['name'] }}</h3>
                    </a>
                @else
                    <div
                        class="payment-card pop-card disabled-payment"
                        data-selectable="false"
                        tabindex="0"
                    >
                        <div class="payment-icon">{{ $method['icon'] }}</div>
                        <h3>{{ $method['name'] }}</h3>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="payment-summary">
            <h4>Demo Summary</h4>
            <div class="mini-row"><span>Item</span><strong>{{ $selectedProduct['name'] }}</strong></div>
            <div class="mini-row"><span>Qty</span><strong>{{ $qty }}</strong></div>
            <div class="mini-row"><span>Total</span><strong>₱{{ number_format($grandTotal) }}</strong></div>
        </div>
    </div>
</div>

<div id="demoToast" class="demo-toast">demo items are examples, provided for reference</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const disabledPayments = document.querySelectorAll('.disabled-payment');
        const toast = document.getElementById('demoToast');
        let toastTimer = null;

        function showToast() {
            clearTimeout(toastTimer);
            toast.classList.add('show');

            toastTimer = setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        disabledPayments.forEach(card => {
            card.addEventListener('click', function (e) {
                e.preventDefault();
                showToast();
            });

            card.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    showToast();
                }
            });
        });
    });
</script>
@endsection