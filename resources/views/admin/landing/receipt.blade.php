@extends('admin.landing.layout')
@section('landing-content')
<div class="demo-card reveal">
    <div class="top-bar">
        <div>
            <p class="mini-label">Step 4 of 4</p>
            <h2>Here’s your Demo Receipt</h2>
        </div>
        <div class="stepper">
            <span class="done"></span>
            <span class="done"></span>
            <span class="done"></span>
            <span class="active"></span>
        </div>
    </div>

    <div class="receipt-layout">
        <div class="receipt-card receipt-animate">
            <div class="receipt-header">
                <h1>iSTOCK</h1>
                <p>A Web-Based Inventory Management System for Small Stores</p>
            </div>

            <div class="receipt-meta">
                <p>Invoice {{ $invoiceNumber }}</p>
                <p id="receipt-datetime">{{ $receiptDateTime }}</p>
            </div>

            <table class="receipt-table receipt-table-summary">
                <colgroup>
                    <col style="width: 34%;">
                    <col style="width: 16%;">
                    <col style="width: 16%;">
                    <col style="width: 34%;">
                </colgroup>
                <thead>
                    <tr>
                        <th>PMode</th>
                        <th class="col-center">I#</th>
                        <th class="col-center">U#</th>
                        <th class="col-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $payment }}</td>
                        <td class="col-center">1</td>
                        <td class="col-center">{{ $qty }}</td>
                        <td class="col-right">₱{{ number_format($grandTotal) }}</td>
                    </tr>
                </tbody>
            </table>

            <table class="receipt-table receipt-table-items">
                <colgroup>
                    <col style="width: 34%;">
                    <col style="width: 16%;">
                    <col style="width: 16%;">
                    <col style="width: 34%;">
                </colgroup>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th class="col-center">Price</th>
                        <th class="col-center">Qty</th>
                        <th class="col-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $selectedProduct['name'] }}</td>
                        <td class="col-center">₱{{ number_format($selectedProduct['price']) }}</td>
                        <td class="col-center">{{ $qty }}</td>
                        <td class="col-right">₱{{ number_format($lineTotal) }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="receipt-total">
                <div><span>Subtotal</span><strong>₱{{ number_format($subtotal) }}</strong></div>
                <div><span>Tax @ 15%</span><strong>₱{{ number_format($tax) }}</strong></div>
                <div><span>Discount</span><strong>-₱{{ number_format($discount) }}</strong></div>
                <div class="grand-total"><span>Grand Total</span><strong>₱{{ number_format($grandTotal) }}</strong></div>
            </div>
        </div>

        <div class="receipt-actions">
            <button class="btn btn-soft btn-lg" onclick="window.print()">Print</button>
            <button class="btn btn-soft btn-lg" onclick="alert('Demo share successful!')">Share</button>
            <a href="{{ route('admin.login.signIn') }}"
               class="btn btn-primary btn-lg btn-block demo-earthquake"
               id="receiptFinishDemoBtn">
                Finish the Demo
            </a>
        </div>
    </div>
</div>

<div id="receiptGuideOverlay" class="receipt-guide-overlay">
    <div id="receiptGuideSpotlight" class="receipt-guide-spotlight"></div>

    <div id="receiptGuideCard" class="receipt-guide-card">
        <div class="receipt-guide-arrow"></div>
        <h3 id="receiptGuideTitle">Finish the demo!</h3>
        <p id="receiptGuideText">Tap this button to complete the demo flow and return to the sign in page.</p>
        <button type="button" id="receiptGuideBtn" class="receipt-guide-btn">Got it</button>
    </div>
</div>

<script>
function shouldShowGuideOnce(key) {
    if (localStorage.getItem(key) === 'true') return false;
    localStorage.setItem(key, 'true');
    return true;
}

document.addEventListener('DOMContentLoaded', function () {
    const receiptDateEl = document.getElementById('receipt-datetime');
    if (!receiptDateEl) return;

    const rawDate = @json($receiptDateTime);
    const savedLang = localStorage.getItem('selectedLang') || 'en';

    const timezoneMap = {
        en: 'Asia/Manila',
        tl: 'Asia/Manila',
        fil: 'Asia/Manila',
        ja: 'Asia/Tokyo',
        ko: 'Asia/Seoul',
        zh: 'Asia/Shanghai',
        'zh-CN': 'Asia/Shanghai',
        'zh-TW': 'Asia/Taipei',
        fr: 'Europe/Paris',
        de: 'Europe/Berlin',
        es: 'Europe/Madrid',
        it: 'Europe/Rome',
        pt: 'Europe/Lisbon',
        ru: 'Europe/Moscow',
        ar: 'Asia/Riyadh',
        hi: 'Asia/Kolkata',
        th: 'Asia/Bangkok',
        vi: 'Asia/Ho_Chi_Minh',
        id: 'Asia/Jakarta',
        ms: 'Asia/Kuala_Lumpur',
    };

    const localeMap = {
        en: 'en-US',
        tl: 'fil-PH',
        fil: 'fil-PH',
        ja: 'ja-JP',
        ko: 'ko-KR',
        zh: 'zh-CN',
        'zh-CN': 'zh-CN',
        'zh-TW': 'zh-TW',
        fr: 'fr-FR',
        de: 'de-DE',
        es: 'es-ES',
        it: 'it-IT',
        pt: 'pt-PT',
        ru: 'ru-RU',
        ar: 'ar-SA',
        hi: 'hi-IN',
        th: 'th-TH',
        vi: 'vi-VN',
        id: 'id-ID',
        ms: 'ms-MY',
    };

    const timezone = timezoneMap[savedLang] || 'Asia/Manila';
    const locale = localeMap[savedLang] || 'en-US';

    const dateObj = new Date(rawDate);

    const formatted = new Intl.DateTimeFormat(locale, {
        year: 'numeric',
        month: 'short',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        hour12: true,
        timeZone: timezone
    }).format(dateObj);

    receiptDateEl.textContent = formatted;
});

document.addEventListener('DOMContentLoaded', function () {
    if (!shouldShowGuideOnce('receiptGuideSeen')) return;

    initReceiptGuide({
        target: '#receiptFinishDemoBtn',
        dim: '.receipt-card, .receipt-actions .btn-soft',
        title: 'Finish the demo!',
        text: 'Tap this button to complete the demo flow and return to the sign in page.'
    });
});

function initReceiptGuide(config) {
    const overlay = document.getElementById('receiptGuideOverlay');
    const spotlight = document.getElementById('receiptGuideSpotlight');
    const guideCard = document.getElementById('receiptGuideCard');
    const guideBtn = document.getElementById('receiptGuideBtn');
    const guideTitle = document.getElementById('receiptGuideTitle');
    const guideText = document.getElementById('receiptGuideText');
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
                guideCard.classList.remove('receipt-guide-card-above');
                guideCard.classList.add('receipt-guide-card-below');
            } else {
                guideCard.classList.remove('receipt-guide-card-below');
                guideCard.classList.add('receipt-guide-card-above');
            }
        } else {
            top = rect.top - guideCard.offsetHeight - 18;

            if (top < 16) {
                top = rect.bottom + 16;
                guideCard.classList.remove('receipt-guide-card-above');
                guideCard.classList.add('receipt-guide-card-below');
            } else {
                guideCard.classList.remove('receipt-guide-card-below');
                guideCard.classList.add('receipt-guide-card-above');
            }
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
        document.body.classList.add('receipt-guide-open');

        dimTargets.forEach(el => {
            if (el !== target) el.classList.add('receipt-guide-dim');
        });

        target.classList.add('receipt-guide-focus-target');
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
        document.body.classList.remove('receipt-guide-open');

        dimTargets.forEach(el => el.classList.remove('receipt-guide-dim'));
        target.classList.remove('receipt-guide-focus-target');
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