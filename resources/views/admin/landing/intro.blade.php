

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
                <a href="{{ route('admin.products') }}" class="btn btn-primary btn-lg pulse-btn">
                    Make a Demo Sale
                </a>

                <a href="{{ route('admin.create.signUp') }}" class="link-muted">Skip demo & create a business account</a>
            </div>
        </div>
    </div>
</div>
<script>
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
</script>
@endsection