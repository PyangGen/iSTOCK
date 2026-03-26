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
                        class="payment-card pop-card selectable-payment demo-earthquake"
                        id="cashPaymentCard"
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

<div id="paymentGuideOverlay" class="payment-guide-overlay">
    <div id="paymentGuideSpotlight" class="payment-guide-spotlight"></div>

    <div id="paymentGuideCard" class="payment-guide-card payment-step-guide-card">
        <div class="payment-guide-arrow payment-step-guide-arrow"></div>
        <h3 id="paymentGuideTitle">Choose your payment mode!</h3>
        <p id="paymentGuideText">Select the cash option to continue to the receipt step of the demo sale.</p>
        <button type="button" id="paymentGuideBtn" class="payment-step-guide-btn">Got it</button>
    </div>
</div>

<script>
function shouldShowGuideOnce(key) {
    if (localStorage.getItem(key) === 'true') return false;
    localStorage.setItem(key, 'true');
    return true;
}

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

    if (!shouldShowGuideOnce('paymentGuideSeen')) return;

    initPaymentStepGuide({
        target: '#cashPaymentCard',
        dim: '.payment-card, .payment-summary',
        title: 'Choose your payment mode!',
        text: 'Select the cash option to continue to the receipt step of the demo sale.'
    });
});

function initPaymentStepGuide(config) {
    const overlay = document.getElementById('paymentGuideOverlay');
    const spotlight = document.getElementById('paymentGuideSpotlight');
    const guideCard = document.getElementById('paymentGuideCard');
    const guideBtn = document.getElementById('paymentGuideBtn');
    const guideTitle = document.getElementById('paymentGuideTitle');
    const guideText = document.getElementById('paymentGuideText');
    const target = document.querySelector(config.target);

    if (!overlay || !spotlight || !guideCard || !guideBtn || !guideTitle || !guideText || !target) return;

    const dimTargets = document.querySelectorAll(config.dim || '');
    let rafId = null;

    guideTitle.textContent = config.title || '';
    guideText.textContent = config.text || '';

    function positionGuide() {
        const rect = target.getBoundingClientRect();
        const cardWidth = Math.min(280, window.innerWidth - 32);

        spotlight.style.top = rect.top + 'px';
        spotlight.style.left = rect.left + 'px';
        spotlight.style.width = rect.width + 'px';
        spotlight.style.height = rect.height + 'px';
        spotlight.style.borderRadius = getComputedStyle(target).borderRadius;

        let left = Math.max(16, Math.min(rect.left, window.innerWidth - cardWidth - 16));
        let top = rect.bottom + 16;

        guideCard.style.width = cardWidth + 'px';
        guideCard.style.left = left + 'px';
        guideCard.style.top = top + 'px';

        guideCard.classList.remove('payment-step-guide-card-above');
        guideCard.classList.add('payment-step-guide-card-below');
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
        document.body.classList.add('payment-step-guide-open');

        dimTargets.forEach(el => {
            if (el !== target) el.classList.add('payment-step-guide-dim');
        });

        target.classList.add('payment-step-guide-target');
        target.classList.remove('demo-earthquake');

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
        document.body.classList.remove('payment-step-guide-open');

        dimTargets.forEach(el => el.classList.remove('payment-step-guide-dim'));
        target.classList.remove('payment-step-guide-target');
        target.classList.add('demo-earthquake');
    }

    guideBtn.addEventListener('click', hideGuide);

    window.addEventListener('resize', function () {
        if (overlay.classList.contains('show')) schedulePosition();
    });

    window.addEventListener('scroll', function () {
        if (overlay.classList.contains('show')) schedulePosition();
    }, { passive: true });

    const startGuide = () => setTimeout(showGuide, 320);

    if (document.readyState === 'complete') {
        startGuide();
    } else {
        window.addEventListener('load', startGuide, { once: true });
    }
}
</script>
@endsection