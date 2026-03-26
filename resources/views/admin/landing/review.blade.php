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
            <a href="{{ route('admin.payment', ['product' => $selectedProduct['id'], 'qty' => $qty]) }}"
               class="btn btn-primary btn-block btn-lg demo-earthquake review-guide-target-btn"
               id="reviewContinueBtn">
                Continue to Payment
            </a>
        </div>
    </div>
</div>

<div id="reviewGuideOverlay" class="review-guide-overlay">
    <div id="reviewGuideSpotlight" class="review-guide-spotlight"></div>

    <div id="reviewGuideCard" class="review-guide-card">
        <div class="review-guide-arrow"></div>
        <h3 id="reviewGuideTitle">Continue to payment!</h3>
        <p id="reviewGuideText">Tap this button to move to the payment step of the demo sale.</p>
        <button type="button" id="reviewGuideBtn" class="review-guide-btn">Got it</button>
    </div>
</div>

<script>
function shouldShowGuideOnce(key) {
    if (localStorage.getItem(key) === 'true') return false;
    localStorage.setItem(key, 'true');
    return true;
}

document.addEventListener('DOMContentLoaded', function () {
    if (!shouldShowGuideOnce('reviewGuideSeen')) return;

    initReviewGuide({
        target: '#reviewContinueBtn',
        dim: '.order-card',
        title: 'Continue to payment!',
        text: 'Tap this button to move to the payment step of the demo sale.'
    });
});

function initReviewGuide(config) {
    const overlay = document.getElementById('reviewGuideOverlay');
    const spotlight = document.getElementById('reviewGuideSpotlight');
    const guideCard = document.getElementById('reviewGuideCard');
    const guideBtn = document.getElementById('reviewGuideBtn');
    const guideTitle = document.getElementById('reviewGuideTitle');
    const guideText = document.getElementById('reviewGuideText');
    const target = document.querySelector(config.target);

    if (!overlay || !spotlight || !guideCard || !guideBtn || !guideTitle || !guideText || !target) return;

    const dimTargets = document.querySelectorAll(config.dim || '');
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

        let left = Math.max(16, Math.min(rect.left, window.innerWidth - cardWidth - 16));
        let top;

        guideCard.style.width = cardWidth + 'px';
        guideCard.style.left = left + 'px';

        if (isMobile) {
            top = rect.top - guideCard.offsetHeight - 16;

            if (top < 16) {
                top = rect.bottom + 16;
                guideCard.classList.remove('review-guide-card-above');
                guideCard.classList.add('review-guide-card-below');
            } else {
                guideCard.classList.remove('review-guide-card-below');
                guideCard.classList.add('review-guide-card-above');
            }
        } else {
            top = rect.bottom + 16;
            guideCard.classList.remove('review-guide-card-above');
            guideCard.classList.add('review-guide-card-below');
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
            if (count < 24) requestAnimationFrame(loop);
        }
        requestAnimationFrame(loop);
        setTimeout(positionGuide, 100);
        setTimeout(positionGuide, 220);
        setTimeout(positionGuide, 400);
        setTimeout(positionGuide, 700);
    }

    function showGuide() {
        document.body.classList.add('review-guide-open');

        dimTargets.forEach(el => {
            if (el !== target) el.classList.add('review-guide-dim');
        });

        target.classList.add('review-guide-focus-target');
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
        document.body.classList.remove('review-guide-open');

        dimTargets.forEach(el => el.classList.remove('review-guide-dim'));
        target.classList.remove('review-guide-focus-target');
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