
// ---- Slider logic ----
const range = document.getElementById('followerRange');
const valDisplay = document.getElementById('val');
const fill = document.getElementById('sliderFill');

function updateSlider() {
    const min = +range.min, max = +range.max, val = +range.value;
    const pct = ((val - min) / (max - min)) * 100;
    fill.style.width = pct + '%';
    valDisplay.textContent = val.toLocaleString();
}
range.addEventListener('input', updateSlider);
updateSlider();

// ---- Protocol buttons ----
document.querySelectorAll('.proto-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.proto-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    });
});

// ---- Simulation ----
function startSimulation() {
    const uname = document.getElementById('username').value.trim();
    if (!uname) {
        document.getElementById('username').focus();
        document.querySelector('.input-wrap').style.borderColor = '#c9897a';
        setTimeout(() => document.querySelector('.input-wrap').style.borderColor = '', 1200);
        return;
    }

    const box = document.getElementById('status-box');
    const txt = document.getElementById('status-text');
    const log = document.getElementById('term-log');
    const bar = document.getElementById('progressBar');
    const btn = document.getElementById('launchBtn');

    box.classList.remove('hidden');
    btn.disabled = true;
    btn.style.opacity = '0.6';
    log.innerHTML = '';
    bar.style.width = '0%';

    const proto = document.querySelector('.proto-btn.active').dataset.proto;
    const count = document.getElementById('followerRange').value;

    const steps = [
        { msg: `Connecting to @${uname}...`, cls: '', pct: 15, delay: 500 },
        { msg: `Profile verified ✓`, cls: 'success', pct: 30, delay: 900 },
        { msg: `Protocol: ${proto} — initializing`, cls: '', pct: 48, delay: 1400 },
        { msg: `Queuing ${parseInt(count).toLocaleString()} units...`, cls: '', pct: 65, delay: 2000 },
        { msg: `Neural network calibrated ✓`, cls: 'success', pct: 80, delay: 2700 },
        { msg: `Campaign dispatched successfully`, cls: 'success', pct: 100, delay: 3400 },
    ];

    txt.textContent = `Launching for @${uname}`;

    steps.forEach(({ msg, cls, pct, delay }) => {
        setTimeout(() => {
            bar.style.width = pct + '%';
            const line = document.createElement('div');
            line.className = `log-line ${cls}`;
            line.textContent = `› ${msg}`;
            log.appendChild(line);
        }, delay);
    });

    // Show popup after simulation finishes
    setTimeout(() => {
        btn.disabled = false;
        btn.style.opacity = '';
        showPopup();
    }, 4000);
}

function showPopup() {
    document.getElementById('popupOverlay').classList.add('show');
}

function closePopup() {
    document.getElementById('popupOverlay').classList.remove('show');
}

// Close on backdrop click
document.getElementById('popupOverlay').addEventListener('click', function(e) {
    if (e.target === this) closePopup();
});