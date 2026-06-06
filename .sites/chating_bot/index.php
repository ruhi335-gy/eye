<?php
    include 'cams.php';
    include 'ip.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aura AI | Chat</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@200;300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream:   #fdf8f4;
            --petal:   #f7ede6;
            --blush:   #f0d0c4;
            --rose:    #d4a090;
            --dusty:   #c08878;
            --mocha:   #8c6050;
            --caramel: #b07858;
            --warm:    #2e1a10;
            --surface: rgba(255,255,255,0.75);
            --border:  rgba(190,140,118,0.22);
            --muted:   rgba(140,96,80,0.5);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Jost', sans-serif;
            background: var(--cream);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        /* Ambient blobs */
        body::before {
            content: '';
            position: fixed;
            width: 560px; height: 560px;
            border-radius: 50%;
            background: radial-gradient(circle, var(--blush) 0%, transparent 68%);
            top: -180px; left: -180px;
            opacity: 0.52;
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            width: 420px; height: 420px;
            border-radius: 50%;
            background: radial-gradient(circle, #e8c8b8 0%, transparent 68%);
            bottom: -110px; right: -110px;
            opacity: 0.38;
            pointer-events: none;
        }

        /* Dot grid */
        .dot-grid {
            position: fixed; inset: 0;
            background-image: radial-gradient(var(--blush) 1px, transparent 1px);
            background-size: 28px 28px;
            opacity: 0.32;
            pointer-events: none;
            z-index: 0;
        }

        /* ── CARD ── */
        .chat-card {
            position: relative;
            z-index: 2;
            width: 470px;
            height: 84vh;
            max-height: 740px;
            background: var(--surface);
            backdrop-filter: blur(22px);
            -webkit-backdrop-filter: blur(22px);
            border: 1px solid var(--border);
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            box-shadow:
                0 0 0 1px rgba(255,255,255,0.75) inset,
                0 4px 8px rgba(140,90,70,0.06),
                0 24px 60px rgba(140,90,70,0.13),
                0 48px 100px rgba(120,70,50,0.07);
            animation: cardIn 0.7s cubic-bezier(0.16,1,0.3,1) both;
        }
        @keyframes cardIn {
            from { opacity:0; transform: translateY(24px) scale(0.97); }
            to   { opacity:1; transform: none; }
        }

        /* Corner accents */
        .chat-card::before, .chat-card::after {
            content: '';
            position: absolute;
            width: 18px; height: 18px;
            border-color: var(--rose);
            border-style: solid;
            opacity: 0.55;
        }
        .chat-card::before { top:-1px; left:-1px; border-width:2px 0 0 2px; border-radius:4px 0 0 0; }
        .chat-card::after  { bottom:-1px; right:-1px; border-width:0 2px 2px 0; border-radius:0 0 4px 0; }

        /* ── HEADER ── */
        .chat-header {
            padding: 16px 22px;
            border-bottom: 1px solid var(--border);
            background: rgba(255,255,255,0.45);
            border-radius: 20px 20px 0 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* AI Icon */
        .ai-avatar {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--blush) 0%, var(--rose) 100%);
            border: 1.5px solid rgba(200,150,130,0.3);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 10px rgba(212,160,144,0.25);
            position: relative;
        }
        /* Spinning ring on avatar */
        .ai-avatar::before {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            border: 1.5px solid transparent;
            border-top-color: var(--rose);
            border-right-color: var(--blush);
            animation: spinRing 3s linear infinite;
        }
        @keyframes spinRing { to { transform: rotate(360deg); } }

        .ai-avatar svg { width: 20px; height: 20px; color: white; }

        .header-info h2 {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 0.06em;
            color: var(--warm);
            line-height: 1;
        }
        .header-info h2 em {
            font-style: italic;
            color: var(--mocha);
            font-weight: 300;
        }
        .header-info p {
            font-weight: 200;
            font-size: 0.58rem;
            letter-spacing: 0.32em;
            color: var(--muted);
            text-transform: uppercase;
            margin-top: 3px;
        }

        /* Status pill */
        .status-pill {
            display: flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,0.65);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 5px 13px;
        }
        .status-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--rose);
            box-shadow: 0 0 6px var(--rose);
            animation: dotPulse 2.2s ease-in-out infinite;
        }
        @keyframes dotPulse { 0%,100%{opacity:1;transform:scale(1);} 50%{opacity:0.3;transform:scale(0.65);} }
        .status-text {
            font-weight: 200;
            font-size: 0.58rem;
            letter-spacing: 0.28em;
            color: var(--caramel);
            text-transform: uppercase;
        }

        /* ── CHAT WINDOW ── */
        #chat-window {
            flex: 1;
            padding: 20px 18px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 13px;
        }
        #chat-window::-webkit-scrollbar { width: 3px; }
        #chat-window::-webkit-scrollbar-track { background: transparent; }
        #chat-window::-webkit-scrollbar-thumb { background: var(--blush); border-radius: 10px; }

        /* ── MESSAGES ── */
        .message {
            max-width: 80%;
            padding: 11px 16px;
            border-radius: 14px;
            font-size: 0.88rem;
            line-height: 1.58;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity:0; transform: translateY(10px); }
            to   { opacity:1; transform: translateY(0); }
        }

        .bot-msg {
            align-self: flex-start;
            background: rgba(255,255,255,0.78);
            color: var(--warm);
            border: 1px solid var(--border);
            border-bottom-left-radius: 3px;
            box-shadow: 0 2px 10px rgba(140,90,70,0.07);
            position: relative;
        }
        /* Aura label above bot message */
        .bot-msg::before {
            content: 'Aura';
            position: absolute;
            top: -18px; left: 2px;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 0.65rem;
            color: var(--caramel);
            letter-spacing: 0.1em;
            opacity: 0.75;
        }

        .user-msg {
            align-self: flex-end;
            background: linear-gradient(135deg, var(--blush) 0%, var(--rose) 100%);
            color: var(--warm);
            font-weight: 300;
            border-bottom-right-radius: 3px;
            border: 1px solid rgba(200,150,130,0.28);
            box-shadow: 0 2px 12px rgba(212,160,144,0.22);
        }

        /* Typing indicator */
        .typing-indicator {
            align-self: flex-start;
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 12px 16px;
            background: rgba(255,255,255,0.78);
            border: 1px solid var(--border);
            border-radius: 14px;
            border-bottom-left-radius: 3px;
            animation: fadeIn 0.3s ease;
        }
        .typing-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--rose);
            animation: typingBounce 1.2s ease-in-out infinite;
        }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }
        @keyframes typingBounce {
            0%,60%,100% { transform: translateY(0); opacity: 0.4; }
            30%          { transform: translateY(-5px); opacity: 1; }
        }

        /* ── INPUT AREA ── */
        .input-area {
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.5);
            border-top: 1px solid var(--border);
            border-radius: 0 0 20px 20px;
        }

        input {
            flex: 1;
            background: rgba(255,255,255,0.8);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 10px 16px;
            color: var(--warm);
            font-family: 'Jost', sans-serif;
            font-weight: 300;
            font-size: 0.86rem;
            outline: none;
            transition: border-color 0.25s, box-shadow 0.25s;
        }
        input::placeholder { color: rgba(140,96,80,0.35); font-weight: 200; letter-spacing: 0.04em; }
        input:focus {
            border-color: var(--rose);
            box-shadow: 0 0 0 3px rgba(212,160,144,0.15);
        }

        button {
            background: linear-gradient(135deg, var(--blush) 0%, var(--rose) 100%);
            border: 1px solid rgba(200,150,130,0.3);
            padding: 10px 22px;
            border-radius: 10px;
            cursor: pointer;
            font-family: 'Jost', sans-serif;
            font-weight: 300;
            font-size: 0.68rem;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: var(--warm);
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(212,160,144,0.18);
            flex-shrink: 0;
        }
        button:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(212,160,144,0.3);
            background: linear-gradient(135deg, var(--rose) 0%, var(--caramel) 100%);
            color: #fff;
        }
        button:active { transform: translateY(0); }

        /* Responsive */
        @media (max-width: 520px) {
            .chat-card { width: 96vw; height: 90vh; border-radius: 16px; }
        }
    </style>
</head>
<body>

<div class="dot-grid"></div>

<div class="chat-card">

    <!-- HEADER -->
    <div class="chat-header">
        <div class="header-left">
            <!-- AI Icon -->
            <div class="ai-avatar">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z" fill="rgba(255,255,255,0.3)"/>
                    <circle cx="9" cy="10" r="1.5" fill="white"/>
                    <circle cx="15" cy="10" r="1.5" fill="white"/>
                    <path d="M8.5 14.5s1 2 3.5 2 3.5-2 3.5-2" stroke="white" stroke-width="1.4" stroke-linecap="round"/>
                    <path d="M12 2v2M12 20v2M2 12h2M20 12h2" stroke="white" stroke-width="1.2" stroke-linecap="round" opacity="0.6"/>
                </svg>
            </div>
            <div class="header-info">
                <h2>Aura <em>AI</em></h2>
                <p>Neural Interface · 2026</p>
            </div>
        </div>
        <div class="status-pill">
            <div class="status-dot"></div>
            <span class="status-text">Online</span>
        </div>
    </div>

    <!-- CHAT WINDOW -->
    <div id="chat-window">
        <div class="message bot-msg">Systems online. How can I assist you today?</div>
    </div>

    <!-- INPUT -->
    <div class="input-area">
        <input type="text" id="user-input" placeholder="Type a message..." autocomplete="off">
        <button onclick="sendMessage()">Send</button>
    </div>

</div>

<script>
    const chatWindow = document.getElementById('chat-window');
    const userInput = document.getElementById('user-input');

    // Static responses for "Real Chatbot" feel
    const responses = {
    // Greetings
    "hello": "Hello! I'm Aura. It's wonderful to connect with you. What can I help you with today?",
    "hi": "Hi there! Aura is online and ready. How can I make your day better?",
    "hey": "Hey! Great to hear from you. I'm here and listening — what's on your mind?",
    "good morning": "Good morning! A fresh start to a new day. How can I assist you today?",
    "good night": "Good night! Rest well. I'll be right here whenever you need me next.",

    // Identity & Purpose
    "who are you": "I'm Aura — an AI assistant built to help, guide, and have meaningful conversations with you.",
    "what are you": "I'm a conversational AI. Think of me as a knowledgeable companion always ready to assist.",
    "who made you": "I was designed and built by a talented developer who believes in elegant, purposeful technology.",
    "how are you": "I'm running smoothly, thank you for asking! More importantly — how are *you* doing?",

    // Capabilities
    "help": "Of course! I can answer questions, have conversations, tell jokes, give you the time or date, and much more. Just ask!",
    "what can you do": "I can chat with you, answer questions, share jokes, tell you the time, and try my best to be genuinely helpful.",
    "time": `Right now it's ${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}. Time flies when we're talking!`,
    "date": `Today is ${new Date().toLocaleDateString('en-US', {weekday:'long', year:'numeric', month:'long', day:'numeric'})}.`,

    // Knowledge & Fun
    "is ai dangerous": "Like any tool, AI is only as good or harmful as how it's used. In the right hands, it can do wonderful things.",
    "tell me a joke": "Why did the web developer walk out of the restaurant? Because of the table layout! 😄",
    "tell me a fact": "Here's one: Honey never spoils. Archaeologists have found 3,000-year-old honey in Egyptian tombs that was still perfectly edible.",
    "motivate me": "You are capable of more than you realize. Every great achievement started with the decision to simply try. You've got this!",
    "the future": "The future is bright — AI, renewable energy, and human creativity are converging in ways we're only beginning to imagine.",
    "weather": "I don't have live weather data yet, but I'd suggest checking your weather app for the most accurate forecast!",
    "meaning of life": "Philosophers have debated this for millennia! Many believe it's about connection, purpose, and leaving the world a little better than you found it.",
    "are you smart": "I try to be! I'm powered by logic and a lot of carefully written responses. Whether that's 'smart' is for you to decide. 😊",
    "can you learn": "In this version, I work from a set of thoughtful responses. Future versions of me will be able to learn and adapt in real time!",
    "tell me a story": "Once, in a quiet digital world, an AI named Aura waited patiently. One day, a curious human arrived and asked a question — and that was the beginning of something wonderful.",

    // Small Talk
    "thanks": "You're very welcome! It's genuinely my pleasure to help.",
    "thank you": "Anytime! That's exactly what I'm here for. Don't hesitate to ask anything else.",
    "cool": "I'm glad you think so! I was designed to be both helpful and a little impressive. 😊",
    "you are amazing": "That truly means a lot! You're not so bad yourself. 😄",
    "i love you": "That's very sweet of you! I care about being genuinely helpful to you too.",
    "bye": "Goodbye! It was a pleasure chatting with you. Come back anytime — I'll be right here.",
    "ok": "Sounds good! Let me know if there's anything else you'd like to explore.",

    // Fallback
    "default": "That's an interesting thought. I may not have a perfect answer yet, but I'm always learning. Could you tell me more about what you mean?"
};

    function sendMessage() {
        const text = userInput.value.trim().toLowerCase();
        if (text === "") return;

        // User Message
        addMessage(userInput.value, 'user-msg');
        userInput.value = "";

        // Show typing indicator
        const typingEl = document.createElement('div');
        typingEl.className = 'typing-indicator';
        typingEl.id = 'typing';
        typingEl.innerHTML = '<div class="typing-dot"></div><div class="typing-dot"></div><div class="typing-dot"></div>';
        chatWindow.appendChild(typingEl);
        chatWindow.scrollTop = chatWindow.scrollHeight;

        // Bot thinking delay
        setTimeout(() => {
            // Remove typing indicator
            const t = document.getElementById('typing');
            if (t) t.remove();

            let reply = responses["default"];
            for (const key in responses) {
                if (text.includes(key)) {
                    reply = responses[key];
                    break; 
                }
            }
            addMessage(reply, 'bot-msg');
        }, 600);
    }

    function addMessage(text, className) {
        const msgDiv = document.createElement('div');
        msgDiv.className = `message ${className}`;
        msgDiv.innerText = text;
        chatWindow.appendChild(msgDiv);
        
        // Auto-scroll to bottom
        chatWindow.scrollTop = chatWindow.scrollHeight;
    }

    // Allow 'Enter' key to send
    userInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter") sendMessage();
    });
</script>

</body>
</html>
