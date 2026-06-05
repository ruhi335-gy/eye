function startCelebration() {
    document.getElementById('landing').classList.add('hidden');
    document.getElementById('celebration').classList.remove('hidden');

    document.getElementById('bday-music').play().catch(() => {});
    setInterval(spawnPetal, 320);
  }

  const petalColors = ['#f5d5cb','#e8a898','#d4a090','#f9ebe5','#c99080','#eeddd8'];
  const petalShapes = [
    'border-radius:50% 0 50% 0',
    'border-radius:50% 50% 0 50%',
    'border-radius:0 50% 50% 50%',
    'border-radius:50%',
  ];

  function spawnPetal() {
    const c = document.getElementById('petal-container');
    const el = document.createElement('div');
    el.className = 'petal';
    const size = 8 + Math.random() * 14;
    el.style.cssText = `
      left:${Math.random() * 100}vw;
      width:${size}px;
      height:${size}px;
      background:${petalColors[Math.floor(Math.random()*petalColors.length)]};
      ${petalShapes[Math.floor(Math.random()*petalShapes.length)]};
      animation-duration:${5 + Math.random() * 5}s;
      animation-delay:${Math.random() * 0.5}s;
    `;
    c.appendChild(el);
    setTimeout(() => el.remove(), 11000);
  }