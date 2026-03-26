

@extends('admin.landing.layout')

@section('landing-content')
<div class="demo-card intro-card reveal">
    <div class="intro-grid">
        <div class="intro-visual">
    <div class="hero-showcase">
        <div class="hero-orb orb-1"></div>
        <div class="hero-orb orb-2"></div>

        <div class="dashboard-card tilt-card">
            <div class="dashboard-top">
                <div>
                    <span class="dashboard-label">Live Inventory</span>
                    <h3>iSTOCK Overview</h3>
                </div>
                <div class="dashboard-status">Active</div>
            </div>

            <div class="dashboard-chart">
                <span class="bar bar-1"></span>
                <span class="bar bar-2"></span>
                <span class="bar bar-3"></span>
                <span class="bar bar-4"></span>
                <span class="bar bar-5"></span>
            </div>

            <div class="dashboard-metrics">
                <div class="metric-card pop-card">
                    <small>Sales</small>
                    <strong>₱12,480</strong>
                </div>
                <div class="metric-card pop-card">
                    <small>Orders</small>
                    <strong>128</strong>
                </div>
                <div class="metric-card pop-card">
                    <small>Stock Left</small>
                    <strong>342</strong>
                </div>
            </div>
        </div>

        <div class="floating-panel panel-receipt">
            <span class="panel-title">Receipt Ready</span>
            <strong>#INV-2026-018</strong>
            <p>Generated instantly</p>
        </div>

        <div class="floating-panel panel-stock">
            <span class="panel-title">Low Stock Alert</span>
            <strong>Milk Tea Pearls</strong>
            <p>Only 8 items left</p>
        </div>

        <div class="floating-badge">
            <span></span>
            Fast • Organized • Professional
        </div>
    </div>
</div>
        <div class="intro-content">
            <h2>Sales made simple in iSTOCK</h2>
            <p>
                Create a demo receipt in just a few clicks and show customers how your
                web-based inventory system makes daily selling faster, smoother, and more professional.
            </p>

            <div class="step-list">
                <div class="step-item">
                    <span>1</span>
                    <p>Choose a demo product</p>
                </div>
                <div class="step-item">
                    <span>2</span>
                    <p>Review order summary</p>
                </div>
                <div class="step-item">
                    <span>3</span>
                    <p>Select payment method</p>
                </div>
                <div class="step-item">
                    <span>4</span>
                    <p>Show the final receipt</p>
                </div>
            </div>

            <div class="intro-actions">
               <a href="{{ route('admin.products') }}" 
   class="btn btn-primary btn-lg pulse-btn demo-earthquake"
   id="demoSaleBtn">
    Make a Demo Sale
</a>
                <a href="{{ route('admin.create.signUp') }}" class="link-muted">Skip demo & create a business account</a>
            </div>
        </div>
    </div>
</div>

<div id="introGuideOverlay" class="intro-guide-overlay">
    <div id="introGuideSpotlight" class="intro-guide-spotlight"></div>

    <div id="introGuideCard" class="intro-guide-card">
        <div class="intro-guide-arrow"></div>
        <h3 id="introGuideTitle"></h3>
        <p id="introGuideText"></p>
        <button type="button" id="introGuideBtn" class="intro-guide-btn">Got it</button>
    </div>
</div>
<script>
    function shouldShowGuideOnce(key) {
    if (localStorage.getItem(key) === 'true') return false;
    localStorage.setItem(key, 'true');
    return true;
}
    document.addEventListener('DOMContentLoaded', () => {
    const tiltCards = document.querySelectorAll('.tilt-card');

    tiltCards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const rotateY = ((x / rect.width) - 0.5) * 10;
            const rotateX = ((y / rect.height) - 0.5) * -10;

            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-8px)`;
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = '';
        });
    });

    const popCards = document.querySelectorAll('.pop-card');
    popCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-8px) scale(1.03)';
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = '';
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {

    const demoBtn = document.getElementById("demoSaleBtn");

    demoBtn.addEventListener("click", function () {
        demoBtn.classList.remove("demo-earthquake");
    });

});
document.addEventListener('DOMContentLoaded', function () {
    if (!shouldShowGuideOnce('introGuideSeen')) return;

    initIntroGuide({
        target: '#demoSaleBtn',
        dim: '.intro-visual, .step-list, .step-item, .metric-card, .floating-panel, .floating-badge, .link-muted',
        title: 'Start your demo sale!',
        text: 'Tap this button to begin the guided sample sale process in iSTOCK.'
    });
});

function initIntroGuide(config) {
    const overlay = document.getElementById('introGuideOverlay');
    const spotlight = document.getElementById('introGuideSpotlight');
    const guideCard = document.getElementById('introGuideCard');
    const guideBtn = document.getElementById('introGuideBtn');
    const guideTitle = document.getElementById('introGuideTitle');
    const guideText = document.getElementById('introGuideText');
    const target = document.querySelector(config.target);

    if (!overlay || !spotlight || !guideCard || !guideBtn || !guideTitle || !guideText || !target) return;

    const dimTargets = document.querySelectorAll(config.dim || '');
    let rafId = null;

    guideTitle.textContent = config.title || '';
    guideText.textContent = config.text || '';

    function positionGuide() {
        const rect = target.getBoundingClientRect();
        const cardWidth = Math.min(280, window.innerWidth - 32);
        const isMobile = window.innerWidth <= 640;

        spotlight.style.top = rect.top + 'px';
        spotlight.style.left = rect.left + 'px';
        spotlight.style.width = rect.width + 'px';
        spotlight.style.height = rect.height + 'px';
        spotlight.style.borderRadius = getComputedStyle(target).borderRadius;

        guideCard.style.width = cardWidth + 'px';

        let left;
let top;

if (isMobile) {
    left = rect.left + (rect.width / 2) - (cardWidth / 2);
    left = Math.max(16, Math.min(left, window.innerWidth - cardWidth - 16));
    guideCard.style.left = left + 'px';

    top = rect.top - guideCard.offsetHeight - 16;

    if (top < 16) {
        top = rect.bottom + 16;
        guideCard.classList.remove('intro-guide-card-above');
        guideCard.classList.add('intro-guide-card-below');
    } else {
        guideCard.classList.remove('intro-guide-card-below');
        guideCard.classList.add('intro-guide-card-above');
    }
} else {
    left = rect.left - 14;
    left = Math.max(16, Math.min(left, window.innerWidth - cardWidth - 16));
    guideCard.style.left = left + 'px';

    top = rect.bottom + 26;
    guideCard.classList.remove('intro-guide-card-above');
    guideCard.classList.add('intro-guide-card-below');
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

            if (count < 20) {
                requestAnimationFrame(loop);
            }
        }

        requestAnimationFrame(loop);

        setTimeout(positionGuide, 100);
        setTimeout(positionGuide, 250);
        setTimeout(positionGuide, 400);
        setTimeout(positionGuide, 700);
    }

    function showGuide() {
        document.body.classList.add('intro-guide-open');

        dimTargets.forEach(el => {
            if (el !== target) el.classList.add('intro-guide-dim');
        });

        target.classList.add('intro-guide-target');
        target.classList.remove('demo-earthquake', 'pulse-btn');

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
        document.body.classList.remove('intro-guide-open');

        dimTargets.forEach(el => el.classList.remove('intro-guide-dim'));
        target.classList.remove('intro-guide-target');
        target.classList.add('demo-earthquake', 'pulse-btn');
    }

    guideBtn.addEventListener('click', hideGuide);

    window.addEventListener('resize', function () {
        if (overlay.classList.contains('show')) schedulePosition();
    });

    window.addEventListener('scroll', function () {
        if (overlay.classList.contains('show')) schedulePosition();
    }, { passive: true });

    window.addEventListener('load', function () {
        setTimeout(showGuide, 300);
    });
}
</script>
@endsection