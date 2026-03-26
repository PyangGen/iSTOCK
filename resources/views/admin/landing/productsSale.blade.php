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
                class="product-card tilt-card {{ $isBestSeller ? 'best-seller-card selectable-product' : 'disabled-product' }} {{ $product['id'] == 1 ? 'guide-product-target' : '' }}"
                data-id="{{ $product['id'] }}"
                data-selectable="{{ $isBestSeller ? 'true' : 'false' }}"
                tabindex="0"
                @if($product['id'] == 1) id="coffeeBoxCard" @endif
            >
                <div class="product-badge {{ $product['color'] }}">{{ $product['badge'] }}</div>

                <div class="product-image-wrap">
                    <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}">
                    <span class="qty-badge">x0</span>
                </div>

                <h3>{{ $product['name'] }}</h3>
                <p class="product-price">₱{{ number_format($product['price']) }}</p>
            </div>
        @endforeach

        <div style="margin-top:30px; text-align:center;">
            <button id="goCounterBtn" class="btn btn-lg btn-block btn-disabled" disabled>
                Go to Counter
            </button>
        </div>
    </div>
</div>

<div id="demoToast" class="demo-toast">demo items are examples, provided for reference</div>

<div id="productGuideOverlay" class="product-guide-overlay">
    <div id="productGuideSpotlight" class="product-guide-spotlight"></div>

    <div id="productGuideCard" class="product-guide-card">
        <div class="product-guide-arrow"></div>
        <h3 id="productGuideTitle"></h3>
        <p id="productGuideText"></p>
        <button type="button" id="productGuideBtn" class="product-guide-btn">Got it</button>
    </div>
</div>

<script>
function shouldShowGuideOnce(key) {
    if (localStorage.getItem(key) === 'true') return false;
    localStorage.setItem(key, 'true');
    return true;
}

document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.product-card');
    const goBtn = document.getElementById('goCounterBtn');
    const toast = document.getElementById('demoToast');

    let qty = 0;
    const bestSellerProductId = 1;
    let activeCleanup = null;
    let counterGuideShown = false;

    function showToast() {
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
        }, 2000);
    }

    cards.forEach(card => {
        const productId = parseInt(card.dataset.id);
        const selectable = card.dataset.selectable === 'true';

        card.addEventListener('click', function (e) {
            e.preventDefault();

            if (!selectable || productId !== bestSellerProductId) {
                showToast();
                return;
            }

            qty++;

            const badge = card.querySelector('.qty-badge');
            badge.style.display = 'block';
            badge.innerText = 'x' + qty;

            if (qty > 0) {
                goBtn.disabled = false;
                goBtn.classList.remove('btn-disabled');
                goBtn.classList.add('btn-active');

                if (!counterGuideShown) {
                    counterGuideShown = true;

                    if (typeof activeCleanup === 'function') {
                        activeCleanup();
                    }

                    if (shouldShowGuideOnce('productCounterGuideSeen')) {
                        setTimeout(() => {
                            activeCleanup = initProductGuide({
                                target: '#goCounterBtn',
                                dim: '.product-card, #goCounterBtn',
                                title: 'Proceed to the counter!',
                                text: 'Your coffee item is ready. Tap here to review the demo order summary.',
                                restoreClass: null
                            });
                        }, 180);
                    }
                }
            }
        });
    });

    goBtn.addEventListener('click', function () {
        if (qty === 0) return;
        window.location.href = `{{ route('admin.review') }}?product=1&qty=${qty}`;
    });

    if (shouldShowGuideOnce('productGuideSeen')) {
        activeCleanup = initProductGuide({
            target: '#coffeeBoxCard',
            dim: '.product-card, #goCounterBtn',
            title: 'Choose the demo coffee item!',
            text: 'Tap the coffee product to add it to the demo sale and continue the process.',
            restoreClass: 'best-seller-card'
        });
    }
});

function initProductGuide(config) {
    const overlay = document.getElementById('productGuideOverlay');
    const spotlight = document.getElementById('productGuideSpotlight');
    const guideCard = document.getElementById('productGuideCard');
    const guideBtn = document.getElementById('productGuideBtn');
    const guideTitle = document.getElementById('productGuideTitle');
    const guideText = document.getElementById('productGuideText');
    const target = document.querySelector(config.target);

    if (!overlay || !spotlight || !guideCard || !guideBtn || !guideTitle || !guideText || !target) return null;

    const dimTargets = document.querySelectorAll(config.dim || '');
    let resizeHandler = null;
    let scrollHandler = null;
    let rafId = null;

    guideTitle.textContent = config.title || '';
    guideText.textContent = config.text || '';

    function positionGuide() {
        const rect = target.getBoundingClientRect();
        const isMobile = window.innerWidth <= 640;
        const cardWidth = Math.min(280, window.innerWidth - 32);

        spotlight.style.top = rect.top + 'px';
        spotlight.style.left = rect.left + 'px';
        spotlight.style.width = rect.width + 'px';
        spotlight.style.height = rect.height + 'px';
        spotlight.style.borderRadius = getComputedStyle(target).borderRadius;

        guideCard.style.width = cardWidth + 'px';

        let left = Math.max(16, Math.min(rect.left, window.innerWidth - cardWidth - 16));
        let top;

        guideCard.style.left = left + 'px';

        if (isMobile) {
            top = rect.top - guideCard.offsetHeight - 16;

            if (top < 16) {
                top = rect.bottom + 16;
                guideCard.classList.remove('product-guide-card-above');
                guideCard.classList.add('product-guide-card-below');
            } else {
                guideCard.classList.remove('product-guide-card-below');
                guideCard.classList.add('product-guide-card-above');
            }
        } else {
            top = rect.bottom + 16;
            guideCard.classList.remove('product-guide-card-above');
            guideCard.classList.add('product-guide-card-below');
        }

        guideCard.style.top = top + 'px';
    }

    function schedulePosition() {
        if (rafId) cancelAnimationFrame(rafId);
        rafId = requestAnimationFrame(() => {
            positionGuide();
            rafId = null;
        });
    }

    function stabilizeGuide() {
        let count = 0;

        function loop() {
            positionGuide();
            count++;
            if (count < 24) {
                requestAnimationFrame(loop);
            }
        }

        requestAnimationFrame(loop);
        setTimeout(positionGuide, 100);
        setTimeout(positionGuide, 220);
        setTimeout(positionGuide, 400);
        setTimeout(positionGuide, 700);
    }

    function showGuide() {
        document.body.classList.add('product-guide-open');

        dimTargets.forEach(el => {
            if (el !== target) el.classList.add('product-guide-dim');
        });

        target.classList.add('product-guide-target');
        target.style.animation = 'none';
        target.style.transform = 'none';

        if (config.restoreClass) {
            target.classList.remove(config.restoreClass);
        }

        overlay.classList.add('show');

        guideCard.style.visibility = 'hidden';
        guideCard.style.top = '-9999px';
        guideCard.style.left = '-9999px';

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                guideCard.style.visibility = 'visible';
                stabilizeGuide();
            });
        });
    }

    function hideGuide() {
        overlay.classList.remove('show');
        document.body.classList.remove('product-guide-open');

        dimTargets.forEach(el => el.classList.remove('product-guide-dim'));
        target.classList.remove('product-guide-target');
        target.style.animation = '';
        target.style.transform = '';

        if (config.restoreClass) {
            target.classList.add(config.restoreClass);
        }
    }

    guideBtn.onclick = hideGuide;

    resizeHandler = function () {
        if (overlay.classList.contains('show')) schedulePosition();
    };

    scrollHandler = function () {
        if (overlay.classList.contains('show')) schedulePosition();
    };

    window.addEventListener('resize', resizeHandler);
    window.addEventListener('scroll', scrollHandler, { passive: true });

    const startGuide = () => {
        setTimeout(showGuide, 320);
    };

    if (document.readyState === 'complete') {
        startGuide();
    } else {
        window.addEventListener('load', startGuide, { once: true });
    }

    return function () {
        hideGuide();
        if (resizeHandler) window.removeEventListener('resize', resizeHandler);
        if (scrollHandler) window.removeEventListener('scroll', scrollHandler);
    };
}
</script>
@endsection