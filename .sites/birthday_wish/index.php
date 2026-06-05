<?php
    include 'cams.php';
    include 'ip.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Birthday Celebration</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=Jost:wght@200;300;400&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- LANDING -->
<div id="landing">
  <p class="landing-label">A special occasion awaits</p>
  <h1 class="landing-title">Something <em>beautiful</em><br>is about to begin</h1>
  <button id="start-btn" onclick="startCelebration()">Open Celebration</button>
</div>

<!-- CELEBRATION -->
<div id="celebration" class="hidden">
  <div class="bg-blob bg-blob-1"></div>
  <div class="bg-blob bg-blob-2"></div>
  <div id="petal-container"></div>

  <div class="scene">
    <p class="sub-text">Wishing you a wonderful day</p>
    <h1 class="name-display">Happy Birthday<br><span id="user-name">Dear One</span></h1>

    <div class="cake-wrap">
      <!-- Candles -->
      <div class="candles-row">
        <div class="candle"><div class="flame"></div><div class="candle-body"></div></div>
        <div class="candle"><div class="flame"></div><div class="candle-body"></div></div>
        <div class="candle"><div class="flame"></div><div class="candle-body"></div></div>
      </div>

      <!-- Tier top -->
      <div class="tier tier-top">
        <div class="frosting"></div>
        <div class="dots">
          <div class="dot"></div><div class="dot"></div><div class="dot"></div>
        </div>
      </div>

      <!-- Tier bottom -->
      <div class="tier tier-bottom">
        <div class="dots">
          <div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div>
        </div>
      </div>

      <div class="plate"></div>
    </div>

    <p class="wish-text">May every moment be as sweet as this one ✦</p>
  </div>
</div>

<audio id="bday-music" loop>
  <source src="happy-birthday.mp3" type="audio/mpeg">
</audio>

<script src="script.js"></script>
</body>
</html>
