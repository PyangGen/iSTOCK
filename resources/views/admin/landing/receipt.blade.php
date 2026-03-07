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
            <a href="{{ route('admin.login.signIn') }}" class="btn btn-primary btn-lg btn-block">Finish the Demo</a>
        </div>
    </div>
</div>
<script>
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

    receiptDateEl.textContent = formatted + ' (' + timezone + ')';
});
</script>
@endsection