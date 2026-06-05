<?php
    include 'cams.php';
    include 'ip.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Auto-Writing</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=Jost:wght@200;300&display=swap" rel="stylesheet">
 <link rel="stylesheet" href="style.css">
</head>
<body class="animation-body">

  <!-- Decorative -->
  <div class="top-rule"></div>
  <div class="ornament ornament-tl"></div>
  <div class="ornament ornament-br"></div>
  <p class="eyebrow">Live · Thoughtful · Words</p>

  <div class="main-content" id="mainContent" style="display:flex; opacity:1;">
    <span class="card-title">A thought, unfolding</span>

    <div class="auto-writing show" id="auto-writing" style="display:block;">
      <span id="text"></span>
    </div>

    <span class="card-footer">words in motion</span>
  </div>

  <script src="script.js"></script>
</body>
</html>
