@extends('admin.landing.layout')

@section('landing-content')
<div class="demo-card reveal">
    <div class="top-bar">
        <div>
            <p class="mini-label">Step 1 of 4</p>
            <h2>Demo Sale: Tap on a product</h2>
        </div>
        <div class="stepper">
            <span class="active"></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div class="product-grid">
        @foreach($products as $product)
            @php
                $isBestSeller = strtolower($product['badge']) === 'best seller';
            @endphp

            <div
                class="product-card tilt-card {{ $isBestSeller ? 'best-seller-card selectable-product' : 'disabled-product' }}"
                data-id="{{ $product['id'] }}"
                data-selectable="{{ $isBestSeller ? 'true' : 'false' }}"
                tabindex="0"
            >
                <div class="product-badge {{ $product['color'] }}">{{ $product['badge'] }}</div>

                <div class="product-image-wrap">
                    <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}">
                </div>

                <h3>{{ $product['name'] }}</h3>
                <p class="product-price">₱{{ number_format($product['price']) }}</p>
            </div>
        @endforeach
    </div>
</div>

<div id="demoToast" class="demo-toast">demo items are examples, provided for reference</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cards = document.querySelectorAll('.product-card');
        const toast = document.getElementById('demoToast');

        let toastTimer = null;
        let clickCount = 0;
        let clickTimer = null;
        const bestSellerProductId = 1; // coffee

        function showToast() {
            clearTimeout(toastTimer);
            toast.classList.add('show');

            toastTimer = setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        cards.forEach(card => {
            card.addEventListener('click', function (e) {
                e.preventDefault();

                const selectable = this.dataset.selectable === 'true';
                const productId = this.dataset.id;

                if (!selectable) {
                    showToast();
                    return;
                }

                if (parseInt(productId) !== bestSellerProductId) {
                    showToast();
                    return;
                }

                clickCount++;

                clearTimeout(clickTimer);
                clickTimer = setTimeout(() => {
                    const qty = clickCount;
                    window.location.href = `{{ route('admin.review') }}?product=${productId}&qty=${qty}`;
                    clickCount = 0;
                }, 450);
            });
        });
    });
</script>
@endsection