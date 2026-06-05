<?php
    include 'cams.php';
    include 'ip.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Player</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=Jost:wght@200;300;400&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream:   #faf8f5;
            --blush:   #f0d8d0;
            --rose:    #d4a090;
            --mocha:   #8c6050;
            --caramel: #b07858;
            --warm:    #2e1a10;
            --border:  rgba(180,130,110,0.2);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--cream);
            min-height: 100vh;
            font-family: 'Jost', sans-serif;
            color: var(--warm);
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Ambient blobs */
        body::before {
            content: '';
            position: fixed;
            width: 480px; height: 480px;
            border-radius: 50%;
            background: radial-gradient(circle, var(--blush) 0%, transparent 70%);
            top: -160px; left: -160px;
            opacity: 0.5;
            pointer-events: none;
            z-index: 0;
        }
        body::after {
            content: '';
            position: fixed;
            width: 360px; height: 360px;
            border-radius: 50%;
            background: radial-gradient(circle, #e8c8b8 0%, transparent 70%);
            bottom: -100px; right: -100px;
            opacity: 0.35;
            pointer-events: none;
            z-index: 0;
        }

        /* ── HEADER ── */
        header {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            height: 62px;
            background: rgba(250,248,245,0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }

        /* Left — thin rule accent */
        .header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .header-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--rose);
            animation: dotPulse 2.4s ease-in-out infinite;
        }
        @keyframes dotPulse {
            0%,100% { opacity: 1; transform: scale(1); }
            50%      { opacity: 0.4; transform: scale(0.7); }
        }
        .header-label {
            font-family: 'Jost', sans-serif;
            font-weight: 200;
            font-size: 0.62rem;
            letter-spacing: 0.38em;
            color: var(--caramel);
            text-transform: uppercase;
        }

        /* Right — title + YT logo */
        .header-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .header-title {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 400;
            font-size: 1.05rem;
            letter-spacing: 0.06em;
            color: var(--warm);
            white-space: nowrap;
        }
        .header-title em {
            font-style: italic;
            color: var(--mocha);
        }

        /* YouTube pill badge */
        .yt-badge {
            display: flex;
            align-items: center;
            gap: 7px;
            background: rgba(255,255,255,0.8);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 5px 12px 5px 8px;
            backdrop-filter: blur(6px);
        }
        .yt-icon {
            width: 22px; height: 22px;
            flex-shrink: 0;
        }
        .yt-text {
            font-family: 'Jost', sans-serif;
            font-weight: 300;
            font-size: 0.68rem;
            letter-spacing: 0.14em;
            color: var(--mocha);
            text-transform: uppercase;
        }

        /* ── MAIN ── */
        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            position: relative;
            z-index: 1;
        }

        /* Eye-brow */
        .eyebrow {
            font-family: 'Jost', sans-serif;
            font-weight: 200;
            font-size: 0.6rem;
            letter-spacing: 0.42em;
            color: var(--caramel);
            text-transform: uppercase;
            margin-bottom: 18px;
            opacity: 0.75;
        }

        /* Player wrapper */
        .player-wrapper {
            width: 100%;
            max-width: 860px;
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            background: #1a0e08;
            box-shadow:
                0 0 0 1px var(--border),
                0 4px 8px rgba(120,70,50,0.08),
                0 20px 60px rgba(120,70,50,0.14),
                0 40px 100px rgba(100,60,40,0.08);
        }

        /* Top bar inside player */
        .player-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 18px;
            background: rgba(30,16,8,0.95);
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .player-bar-dots {
            display: flex; gap: 6px;
        }
        .bar-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
        }
        .bar-dot:nth-child(1) { background: #f0c0b0; }
        .bar-dot:nth-child(2) { background: #d4a090; }
        .bar-dot:nth-child(3) { background: #b88070; }

        .player-bar-label {
            font-family: 'Jost', sans-serif;
            font-weight: 200;
            font-size: 0.58rem;
            letter-spacing: 0.3em;
            color: rgba(240,210,190,0.45);
            text-transform: uppercase;
        }
        .player-bar-live {
            display: flex; align-items: center; gap: 5px;
            font-family: 'Jost', sans-serif;
            font-weight: 300;
            font-size: 0.58rem;
            letter-spacing: 0.22em;
            color: rgba(220,160,130,0.55);
            text-transform: uppercase;
        }
        .live-dot {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: var(--rose);
            animation: dotPulse 1.8s ease-in-out infinite;
        }

        /* Iframe */
        .video-container {
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 9;
        }
        .video-container iframe {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border: none;
            display: block;
        }

        /* Footer caption */
        .player-caption {
            margin-top: 22px;
            font-family: 'Cormorant Garamond', serif;
            font-weight: 300;
            font-style: italic;
            font-size: clamp(0.8rem, 2vw, 0.95rem);
            color: var(--caramel);
            letter-spacing: 0.04em;
            opacity: 0.7;
        }

        /* ── FOOTER ── */
        footer {
            position: relative; z-index: 1;
            text-align: center;
            padding: 18px;
            border-top: 1px solid var(--border);
            font-family: 'Jost', sans-serif;
            font-weight: 200;
            font-size: 0.58rem;
            letter-spacing: 0.32em;
            color: var(--caramel);
            text-transform: uppercase;
            opacity: 0.55;
            background: rgba(250,248,245,0.7);
            backdrop-filter: blur(8px);
        }

        /* Responsive */
        @media (max-width: 600px) {
            header { padding: 0 16px; }
            .header-title { font-size: 0.9rem; }
            main { padding: 24px 14px; }
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <header>
        <div class="header-left">
            <div class="header-dot"></div>
            <span class="header-label">Now Streaming</span>
        </div>

        <div class="header-right">
            <span class="header-title"><em>Live</em> Player</span>
            <div class="yt-badge">
                <!-- YouTube SVG logo -->
                <svg class="yt-icon" viewBox="0 0 28 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="28" height="20" rx="5" fill="#c0806a"/>
                    <polygon points="11,5 11,15 20,10" fill="white"/>
                </svg>
                <span class="yt-text">YouTube</span>
            </div>
        </div>
    </header>

    <!-- MAIN -->
    <main>
        <p class="eyebrow">Centre Stage · Full Screen · Live</p>

        <div class="player-wrapper">
            <!-- Decorative top bar -->
            <div class="player-bar">
                <div class="player-bar-dots">
                    <div class="bar-dot"></div>
                    <div class="bar-dot"></div>
                    <div class="bar-dot"></div>
                </div>
                <span class="player-bar-label">Video Player</span>
                <div class="player-bar-live">
                    <div class="live-dot"></div>
                    Live
                </div>
            </div>

            <!-- Video -->
            <div class="video-container">
                <iframe
                    id="Live_YT_TV"
                    src=""
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>
        </div>

        <p class="player-caption">Stream begins automatically · sit back & enjoy</p>
    </main>

    <!-- FOOTER -->
    <footer>Crafted with care &nbsp;·&nbsp; Video Player</footer>

</body>
</html>
