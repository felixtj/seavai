<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seav.ai')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/htmx.org@2.0.4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --blue: #2563EB; --blue-hover: #1D4ED8; --blue-light: #EFF6FF;
            --green: #10B981; --green-light: #D1FAE5;
            --amber: #F59E0B; --amber-light: #FEF3C7;
            --red: #EF4444; --red-light: #FEE2E2;
            --purple: #7C3AED; --purple-light: #EDE9FE;
            --slate: #64748B; --border: #E2E8F0;
            --bg: #F8FAFC; --surface: #FFFFFF;
            --text: #0F172A; --muted: #64748B; --light: #94A3B8;
            --sidebar-width: 240px; --header-height: 60px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.07);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.10);
            --shadow-lg: 0 8px 32px rgba(0,0,0,0.14);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        h1,h2,h3,h4 { font-family: 'Outfit', sans-serif; }
        body { background: var(--bg); color: var(--text); display: flex; min-height: 100vh; overflow-x: hidden; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-width); background: var(--surface);
            border-right: 1px solid var(--border); display: flex; flex-direction: column;
            position: fixed; height: 100vh; z-index: 50; overflow-y: auto;
        }
        .brand {
            height: var(--header-height); display: flex; align-items: center;
            padding: 0 20px; border-bottom: 1px solid var(--border);
            font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 1rem;
            color: var(--text); gap: 10px; flex-shrink: 0; text-decoration: none;
        }
        .brand-dot {
            width: 28px; height: 28px; background: var(--blue); border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 0.75rem; font-weight: 800;
        }

        .nav-menu { padding: 16px 12px; flex: 1; }
        .nav-section-label {
            font-size: 0.68rem; text-transform: uppercase; letter-spacing: .07em;
            color: var(--light); font-weight: 600; margin: 18px 0 6px 10px;
        }
        .nav-section-label:first-child { margin-top: 0; }
        .nav-item {
            display: flex; align-items: center; gap: 9px; padding: 8px 10px;
            border-radius: 7px; margin-bottom: 2px; font-size: 0.875rem; font-weight: 500;
            color: var(--muted); text-decoration: none; cursor: pointer;
            transition: background .15s, color .15s;
        }
        .nav-item i { font-size: 0.9rem; width: 16px; text-align: center; flex-shrink: 0; }
        .nav-item:hover { background: #F1F5F9; color: var(--text); }
        .nav-item.active { background: var(--blue-light); color: var(--blue); font-weight: 600; }
        .nav-badge {
            margin-left: auto; background: var(--blue); color: white;
            border-radius: 999px; font-size: 0.62rem; font-weight: 700;
            padding: 1px 6px; min-width: 18px; text-align: center;
        }

        .sidebar-footer {
            padding: 14px 16px; border-top: 1px solid var(--border);
            display: flex; align-items: center; gap: 10px; flex-shrink: 0;
        }
        .avatar-circle {
            width: 32px; height: 32px; background: var(--blue); color: white;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 0.72rem; font-weight: 700; flex-shrink: 0;
        }
        .sidebar-user b   { display: block; font-size: 0.8rem; }
        .sidebar-user small { color: var(--muted); font-size: 0.7rem; }

        /* ── MAIN AREA ── */
        .main-wrapper { flex: 1; margin-left: var(--sidebar-width); display: flex; flex-direction: column; min-height: 100vh; }

        .top-header {
            height: var(--header-height); background: var(--surface);
            border-bottom: 1px solid var(--border); display: flex; align-items: center;
            justify-content: space-between; padding: 0 28px;
            position: sticky; top: 0; z-index: 40;
        }
        .header-left h2 { font-size: 1rem; font-weight: 700; margin-bottom: 1px; }
        .header-left p  { font-size: 0.72rem; color: var(--muted); }
        .header-right   { display: flex; align-items: center; gap: 10px; }

        .page-body { padding: 28px; }

        /* ── COMMON COMPONENTS ── */
        .page-header { margin-bottom: 24px; }
        .page-header h1 { font-size: 1.4rem; font-weight: 700; margin: 0 0 3px; }
        .page-header p  { color: var(--muted); font-size: 0.875rem; margin: 0; }

        .card { background: white; border: 1px solid var(--border); border-radius: 14px; box-shadow: var(--shadow-sm); }
        .card-pad { padding: 20px 24px; }

        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 999px; font-size: 0.7rem; font-weight: 600; }
        .badge-blue   { background: #DBEAFE; color: #1E40AF; }
        .badge-green  { background: var(--green-light); color: #065F46; }
        .badge-amber  { background: var(--amber-light); color: #92400E; }
        .badge-slate  { background: #F1F5F9; color: #475569; }
        .badge-purple { background: var(--purple-light); color: #5B21B6; }
        .badge-red    { background: var(--red-light); color: #B91C1C; }

        .btn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px; font-size: 0.82rem; font-weight: 600; border-radius: 8px; cursor: pointer; border: 1px solid transparent; transition: all .15s; text-decoration: none; }
        .btn-primary { background: var(--blue); color: white; border-color: var(--blue); }
        .btn-primary:hover { background: var(--blue-hover); }
        .btn-outline { background: white; border-color: var(--border); color: var(--text); }
        .btn-outline:hover { border-color: var(--blue); color: var(--blue); background: var(--blue-light); }
        .btn-ghost { background: none; border-color: transparent; color: var(--muted); }
        .btn-ghost:hover { background: #F1F5F9; color: var(--text); }
        .btn-sm { padding: 6px 12px; font-size: 0.75rem; }

        .progress-bar  { height: 6px; background: #E2E8F0; border-radius: 999px; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 999px; background: var(--blue); transition: width .4s ease; }

        .match-score { width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; flex-shrink: 0; }
        .match-score.high { background: var(--green-light); color: #065F46; border: 2px solid var(--green); }
        .match-score.med  { background: var(--blue-light);  color: #1E40AF; border: 2px solid var(--blue); }
        .match-score.low  { background: var(--amber-light); color: #92400E; border: 2px solid var(--amber); }

        /* HTMX fade */
        .htmx-swapping { opacity: 0; transition: opacity .15s; }
        .htmx-settling  { opacity: 1; transition: opacity .15s; }

        /* ── CHATBOT ── */
        .chat-fab     { position: fixed; bottom: 28px; right: 28px; z-index: 100; }
        .chat-fab-btn { width: 52px; height: 52px; border-radius: 50%; background: var(--blue); color: white; border: none; cursor: pointer; box-shadow: var(--shadow-lg); display: flex; align-items: center; justify-content: center; font-size: 1.15rem; transition: transform .2s, box-shadow .2s; }
        .chat-fab-btn:hover { transform: scale(1.07); box-shadow: 0 12px 40px rgba(37,99,235,.35); }
        .chat-window  { position: fixed; bottom: 90px; right: 28px; width: 360px; background: white; border-radius: 18px; box-shadow: var(--shadow-lg); border: 1px solid var(--border); z-index: 100; display: flex; flex-direction: column; overflow: hidden; max-height: 520px; }
        .chat-header  { background: var(--blue); color: white; padding: 14px 18px; display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
        .chat-header h4 { font-size: 0.9rem; font-weight: 700; margin: 0; }
        .chat-header p  { font-size: 0.72rem; opacity: .8; margin: 0; }
        .chat-header-dot { width: 8px; height: 8px; background: #4ade80; border-radius: 50%; flex-shrink: 0; }
        .chat-messages { flex: 1; overflow-y: auto; padding: 16px; display: flex; flex-direction: column; gap: 10px; }
        .chat-msg { max-width: 85%; }
        .chat-msg.bot .bubble { background: #F1F5F9; color: var(--text); border-radius: 4px 14px 14px 14px; }
        .chat-msg.user { align-self: flex-end; }
        .chat-msg.user .bubble { background: var(--blue); color: white; border-radius: 14px 4px 14px 14px; }
        .bubble { padding: 10px 14px; font-size: 0.82rem; line-height: 1.5; }
        .chat-input-wrap { padding: 12px; border-top: 1px solid var(--border); display: flex; gap: 8px; flex-shrink: 0; }
        .chat-input { flex: 1; border: 1px solid var(--border); border-radius: 8px; padding: 8px 12px; font-size: 0.82rem; outline: none; font-family: inherit; }
        .chat-input:focus { border-color: var(--blue); }
        .chat-send { background: var(--blue); color: white; border: none; border-radius: 8px; padding: 8px 12px; cursor: pointer; font-size: 0.85rem; }
        .chat-quick { padding: 0 12px 10px; display: flex; flex-wrap: wrap; gap: 6px; }
        .chat-quick-btn { border: 1px solid var(--border); border-radius: 999px; padding: 4px 12px; font-size: 0.72rem; background: white; cursor: pointer; color: var(--muted); transition: all .15s; }
        .chat-quick-btn:hover { border-color: var(--blue); color: var(--blue); background: var(--blue-light); }
    </style>
</head>
<body x-data="{ chatOpen: false, chatMessages: [{role:'bot', text:'Hi Sarah! 👋 I\'m your Seav.ai career assistant. I can help with your resume, job matches, salary advice, or LinkedIn optimisation. What would you like to work on?'}] }">

    <!-- ── SIDEBAR ── -->
    <aside class="sidebar">
        <a href="{{ route('demo.dashboard') }}" class="brand">
            <div class="brand-dot">S</div>
            Seav.ai
        </a>

        <nav class="nav-menu">
            <div class="nav-section-label">Career</div>
            <a href="{{ route('demo.dashboard') }}" class="nav-item {{ request()->is('demo/dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
            <a href="{{ route('demo.jobs') }}" class="nav-item {{ request()->is('demo/jobs*') ? 'active' : '' }}">
                <i class="fa-solid fa-briefcase"></i> Browse Jobs
            </a>
            <a href="{{ route('demo.matches') }}" class="nav-item {{ request()->is('demo/matches') ? 'active' : '' }}">
                <i class="fa-solid fa-bolt"></i> My Matches
                <span class="nav-badge">6</span>
            </a>
            <a href="{{ route('demo.resume') }}" class="nav-item {{ request()->is('demo/resume') ? 'active' : '' }}">
                <i class="fa-solid fa-file-lines"></i> My Resume
            </a>

            <div class="nav-section-label">Tools</div>
            <a href="#" class="nav-item" onclick="event.preventDefault(); alert('Coming soon — Application Tracker')">
                <i class="fa-solid fa-list-check"></i> Applications
                <span style="margin-left:auto;font-size:0.6rem;background:#F1F5F9;color:#94A3B8;padding:1px 6px;border-radius:4px;font-weight:700;">SOON</span>
            </a>
            <a href="#" class="nav-item" onclick="event.preventDefault(); alert('Coming soon — Interview Prep')">
                <i class="fa-solid fa-comments"></i> Interview Prep
                <span style="margin-left:auto;font-size:0.6rem;background:#F1F5F9;color:#94A3B8;padding:1px 6px;border-radius:4px;font-weight:700;">SOON</span>
            </a>
        </nav>

        <!-- Profile completeness nudge -->
        <div style="margin: 0 12px 12px; background: var(--blue-light); border-radius: 10px; padding: 12px 14px;">
            <div style="font-size: 0.72rem; font-weight: 700; color: #1E40AF; margin-bottom: 6px;">Profile Strength</div>
            <div class="progress-bar" style="margin-bottom: 6px;">
                <div class="progress-fill" style="width: 72%;"></div>
            </div>
            <div style="font-size: 0.68rem; color: #3B82F6; font-weight: 600;">72% · <a href="{{ route('demo.resume') }}" style="color: var(--blue); text-decoration: none;">Optimise resume +15%</a></div>
        </div>

        <div class="sidebar-footer">
            <div class="avatar-circle">SC</div>
            <div class="sidebar-user">
                <b>Sarah Chen</b>
                <small>sarah.chen@email.com</small>
            </div>
            <a href="{{ route('demo.login') }}" style="margin-left:auto;color:var(--light);font-size:0.85rem;" title="Sign out"><i class="fa-solid fa-right-from-bracket"></i></a>
        </div>
    </aside>

    <!-- ── MAIN ── -->
    <div class="main-wrapper">
        <!-- Top header -->
        <header class="top-header">
            <div class="header-left">
                <h2>@yield('page-title', 'Dashboard')</h2>
                <p>@yield('page-meta', '')</p>
            </div>
            <div class="header-right">
                <a href="{{ route('demo.resume') }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-wand-magic-sparkles"></i> Optimise Resume
                </a>
                <div x-data="{ open: false }" style="position: relative;">
                    <button class="btn btn-ghost btn-sm" @click="open = !open" style="gap: 6px; border: 1px solid var(--border);">
                        <div class="avatar-circle" style="width: 24px; height: 24px; font-size: 0.62rem;">SC</div>
                        Sarah
                        <i class="fa-solid fa-chevron-down" style="font-size: 0.65rem;"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition
                         style="position: absolute; right: 0; top: 40px; background: white; border: 1px solid var(--border); border-radius: 10px; min-width: 180px; box-shadow: var(--shadow-md); padding: 6px; z-index: 60;">
                        <div style="padding: 10px 12px; border-bottom: 1px solid var(--border); margin-bottom: 4px;">
                            <div style="font-weight: 600; font-size: 0.82rem;">Sarah Chen</div>
                            <div style="color: var(--muted); font-size: 0.72rem;">sarah.chen@email.com</div>
                        </div>
                        <a href="{{ route('demo.dashboard') }}" style="display: flex; align-items: center; gap: 8px; padding: 8px 12px; border-radius: 6px; font-size: 0.8rem; color: var(--text); text-decoration: none;" onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='none'">
                            <i class="fa-solid fa-user" style="width: 14px; color: var(--muted);"></i> Profile
                        </a>
                        <a href="{{ route('demo.login') }}" style="display: flex; align-items: center; gap: 8px; padding: 8px 12px; border-radius: 6px; font-size: 0.8rem; color: var(--red); text-decoration: none;" onmouseover="this.style.background='#FEE2E2'" onmouseout="this.style.background='none'">
                            <i class="fa-solid fa-right-from-bracket" style="width: 14px;"></i> Sign out
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page content -->
        <main class="page-body">
            @yield('content')
        </main>
    </div>

    <!-- ── FLOATING CHATBOT ── -->
    <div class="chat-fab">
        <div class="chat-window"
             x-show="chatOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 translate-y-4"
             style="display: none;">
            <div class="chat-header">
                <div>
                    <h4>Seav Assistant</h4>
                    <p>AI Career Coach · Always online</p>
                </div>
                <div class="chat-header-dot" style="margin-left: auto;"></div>
                <button @click="chatOpen = false" style="background: none; border: none; color: white; cursor: pointer; padding: 4px; margin-left: 8px; opacity: .7; font-size: 1rem;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="chat-messages" id="chat-messages">
                <template x-for="msg in chatMessages" :key="msg.text">
                    <div class="chat-msg" :class="msg.role">
                        <div class="bubble" x-text="msg.text"></div>
                    </div>
                </template>
                <div id="chat-typing" style="display: none;" class="chat-msg bot">
                    <div class="bubble" style="color: var(--muted);">
                        <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 0.7rem;"></i> Thinking…
                    </div>
                </div>
            </div>
            <div class="chat-quick">
                <button class="chat-quick-btn" @click="sendQuick('Help with my resume')">📄 Resume tips</button>
                <button class="chat-quick-btn" @click="sendQuick('Best job match')">⚡ Best match</button>
                <button class="chat-quick-btn" @click="sendQuick('Salary advice')">💰 Salary</button>
                <button class="chat-quick-btn" @click="sendQuick('LinkedIn profile')">🔗 LinkedIn</button>
            </div>
            <div class="chat-input-wrap">
                <input class="chat-input" id="chat-input" placeholder="Ask me anything…" @keydown.enter="sendMessage()">
                <button class="chat-send" @click="sendMessage()"><i class="fa-solid fa-paper-plane"></i></button>
            </div>
        </div>

        <button class="chat-fab-btn" @click="chatOpen = !chatOpen">
            <i class="fa-solid fa-comment-dots" x-show="!chatOpen"></i>
            <i class="fa-solid fa-xmark" x-show="chatOpen" style="display: none;"></i>
        </button>
    </div>

    <script>
        document.body.addEventListener('htmx:configRequest', e => {
            e.detail.headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
        });

        function sendMessage() {
            const input = document.getElementById('chat-input');
            const msg = input.value.trim();
            if (!msg) return;
            input.value = '';
            addMessage('user', msg);
            showTyping(true);
            fetch('{{ route('demo.chat') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: JSON.stringify({ message: msg })
            }).then(r => r.text()).then(html => {
                showTyping(false);
                const doc = new DOMParser().parseFromString(html, 'text/html');
                const reply = doc.querySelector('[data-reply]')?.dataset.reply;
                if (reply) addMessage('bot', reply);
                scrollChat();
            });
        }

        function sendQuick(msg) {
            document.getElementById('chat-input').value = msg;
            sendMessage();
        }

        function addMessage(role, text) {
            Alpine.$data(document.body).chatMessages.push({ role, text });
            scrollChat();
        }

        function showTyping(show) {
            document.getElementById('chat-typing').style.display = show ? 'block' : 'none';
        }

        function scrollChat() {
            setTimeout(() => {
                const el = document.getElementById('chat-messages');
                if (el) el.scrollTop = el.scrollHeight;
            }, 50);
        }
    </script>
</body>
</html>
