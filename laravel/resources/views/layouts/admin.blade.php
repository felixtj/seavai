<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seav.ai Admin')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/htmx.org@2.0.4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary: #0F172A; --primary-light: #F1F5F9;
            --accent: #2563EB; --accent-hover: #1D4ED8;
            --teal: #155E75; --teal-light: #ECFEFF;
            --bg-body: #F8FAFC; --bg-surface: #FFFFFF;
            --text-main: #0F172A; --text-muted: #64748B; --text-light: #94A3B8;
            --border: #E2E8F0;
            --success: #10B981; --success-bg: #D1FAE5;
            --warning: #F59E0B; --warning-bg: #FEF3C7;
            --danger: #EF4444; --danger-bg: #FEE2E2;
            --info: #3B82F6; --info-bg: #DBEAFE;
            --purple: #8B5CF6; --purple-bg: #EDE9FE;
            --sidebar-width: 240px; --header-height: 64px;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.08);
            --shadow-lg: 0 8px 32px rgba(0,0,0,0.12);
        }
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Inter',sans-serif; }
        body { background:var(--bg-body); color:var(--text-main); display:flex; min-height:100vh; overflow-x:hidden; }

        /* SIDEBAR */
        .sidebar { width:var(--sidebar-width); background:var(--bg-surface); border-right:1px solid var(--border); display:flex; flex-direction:column; position:fixed; height:100vh; z-index:50; overflow-y:auto; }
        .brand { height:var(--header-height); display:flex; align-items:center; padding:0 20px; border-bottom:1px solid var(--border); font-weight:700; font-size:1rem; color:var(--primary); gap:10px; flex-shrink:0; }
        .brand-dot { width:28px; height:28px; background:var(--teal); border-radius:7px; display:flex; align-items:center; justify-content:center; color:white; font-size:0.75rem; font-weight:800; }
        .nav-menu { padding:16px 12px; flex-grow:1; }
        .nav-label { font-size:0.68rem; text-transform:uppercase; letter-spacing:0.07em; color:var(--text-light); font-weight:600; margin:18px 0 6px 10px; }
        .nav-label:first-child { margin-top:0; }
        .nav-item { display:flex; align-items:center; padding:8px 10px; color:var(--text-muted); text-decoration:none; border-radius:7px; margin-bottom:1px; font-weight:500; font-size:0.875rem; cursor:pointer; gap:9px; transition:background .15s,color .15s; border:none; background:none; width:100%; text-align:left; }
        .nav-item i { font-size:0.95rem; width:16px; text-align:center; flex-shrink:0; }
        .nav-item:hover { background:var(--primary-light); color:var(--text-main); }
        .nav-item.active { background:#EFF6FF; color:var(--accent); font-weight:600; }
        .nav-badge { margin-left:auto; background:var(--danger); color:white; border-radius:9999px; font-size:0.65rem; font-weight:700; padding:1px 6px; min-width:18px; text-align:center; }
        .nav-badge.green { background:var(--success); }
        .nav-badge.gray  { background:#94A3B8; }
        .user-profile { padding:14px 16px; border-top:1px solid var(--border); display:flex; align-items:center; gap:10px; flex-shrink:0; }
        .avatar { width:32px; height:32px; background:var(--accent); color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:12px; flex-shrink:0; }
        .user-info b { display:block; font-size:0.8rem; }
        .user-info small { color:var(--text-muted); font-size:0.72rem; }

        /* MAIN */
        .main-wrapper { flex-grow:1; margin-left:var(--sidebar-width); display:flex; flex-direction:column; min-height:100vh; }
        .top-header { height:var(--header-height); background:var(--bg-surface); border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; padding:0 28px; position:sticky; top:0; z-index:40; gap:16px; }
        .header-title { font-size:1.05rem; font-weight:600; }
        .header-meta  { font-size:0.78rem; color:var(--text-muted); }
        .header-right { display:flex; align-items:center; gap:10px; }

        /* HTMX loading indicator */
        .htmx-indicator { display:none; }
        .htmx-request .htmx-indicator { display:inline-flex; }
        .htmx-request.htmx-indicator { display:inline-flex; }

        /* Content fade-in */
        #main-content > * { animation: fadeIn .18s ease; }
        @keyframes fadeIn { from{opacity:0;transform:translateY(3px)} to{opacity:1;transform:translateY(0)} }

        /* BUTTONS */
        .btn { display:inline-flex; align-items:center; justify-content:center; gap:7px; padding:8px 16px; font-size:0.8rem; font-weight:500; border-radius:6px; cursor:pointer; transition:all .15s; border:1px solid transparent; white-space:nowrap; }
        .btn-sm { padding:5px 10px; font-size:0.75rem; }
        .btn-primary   { background:var(--accent); color:white; border-color:var(--accent); }
        .btn-primary:hover { background:var(--accent-hover); border-color:var(--accent-hover); }
        .btn-teal      { background:var(--teal); color:white; }
        .btn-teal:hover { background:#0E4A5C; }
        .btn-secondary { background:var(--bg-surface); border-color:var(--border); color:var(--text-main); }
        .btn-secondary:hover { background:var(--bg-body); }
        .btn-ghost     { background:none; border-color:transparent; color:var(--text-muted); }
        .btn-ghost:hover { background:var(--primary-light); color:var(--text-main); }

        /* BADGES */
        .badge { display:inline-flex; align-items:center; gap:3px; padding:2px 8px; border-radius:9999px; font-size:0.68rem; font-weight:600; white-space:nowrap; }
        .badge-emerald { background:var(--success-bg); color:#065F46; }
        .badge-rose    { background:var(--danger-bg); color:#B91C1C; }
        .badge-amber   { background:var(--warning-bg); color:#92400E; }
        .badge-blue    { background:#DBEAFE; color:#1E40AF; }
        .badge-slate   { background:#F1F5F9; color:#475569; }
        .badge-teal    { background:var(--teal-light); color:var(--teal); }
        .badge-purple  { background:var(--purple-bg); color:#5B21B6; }

        /* CARDS */
        .card { background:white; border:1px solid var(--border); border-radius:12px; box-shadow:var(--shadow-sm); margin-bottom:20px; overflow:hidden; }
        .card-header { display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-bottom:1px solid var(--border); }
        .card-header h3 { font-size:0.875rem; font-weight:600; }
        .card-body { padding:16px 20px; }

        /* TABLES */
        .data-table { width:100%; border-collapse:collapse; }
        .data-table th { padding:10px 16px; background:#F8FAFC; font-size:0.7rem; font-weight:600; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.05em; border-bottom:2px solid var(--border); text-align:left; white-space:nowrap; }
        .data-table td { padding:12px 16px; font-size:0.82rem; border-bottom:1px solid var(--border); vertical-align:middle; }
        .data-table tbody tr:last-child td { border-bottom:none; }
        .data-table tbody tr:hover { background:#FAFBFD; cursor:pointer; }

        /* FILTER CHIPS */
        .filter-chip { padding:5px 12px; border:1px solid var(--border); border-radius:99px; font-size:0.78rem; font-weight:500; color:var(--text-muted); cursor:pointer; transition:all .15s; background:white; }
        .filter-chip.active, .filter-chip:hover { border-color:var(--accent); color:var(--accent); background:#EFF6FF; }
        .search-input { padding:6px 12px 6px 32px; border:1px solid var(--border); border-radius:6px; font-size:0.8rem; outline:none; background:var(--bg-body); width:220px; }
        .search-input:focus { border-color:var(--accent); background:white; }

        /* DRAWER */
        .drawer-overlay { position:fixed; inset:0; background:rgba(15,23,42,0.3); z-index:60; }
        .drawer { position:fixed; right:0; top:0; height:100vh; width:480px; background:white; border-left:1px solid var(--border); z-index:70; box-shadow:var(--shadow-lg); display:flex; flex-direction:column; }
        .drawer-header { padding:16px 20px; border-bottom:1px solid var(--border); display:flex; align-items:flex-start; gap:12px; flex-shrink:0; }
        .drawer-header-left { flex:1; min-width:0; }
        .drawer-header-left h2 { font-size:1rem; font-weight:700; margin-bottom:4px; }
        .dmeta { font-size:0.75rem; color:var(--text-muted); display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
        .drawer-close { background:none; border:none; font-size:1.1rem; color:var(--text-muted); cursor:pointer; padding:4px; border-radius:5px; flex-shrink:0; }
        .drawer-close:hover { background:var(--bg-body); color:var(--text-main); }
        .drawer-body { flex:1; overflow-y:auto; padding:20px; }
        .drawer-section { margin-bottom:20px; }
        .dsection-title { font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--text-muted); margin-bottom:10px; display:flex; align-items:center; gap:8px; }
        .dsection-title::after { content:''; flex:1; height:1px; background:var(--border); }
        .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
        .info-item label { display:block; font-size:0.68rem; font-weight:600; text-transform:uppercase; letter-spacing:0.05em; color:var(--text-light); margin-bottom:3px; }
        .info-item span { font-size:0.82rem; font-weight:500; }
        .drawer-footer { padding:14px 20px; border-top:1px solid var(--border); display:flex; gap:8px; flex-shrink:0; flex-wrap:wrap; }

        /* TOAST */
        #toast { position:fixed; bottom:24px; right:24px; background:#0F172A; color:white; padding:12px 18px; border-radius:8px; font-size:0.82rem; font-weight:500; box-shadow:var(--shadow-lg); z-index:999; max-width:320px; pointer-events:none; }

        /* STATS CARDS */
        .stat-card { background:white; border:1px solid var(--border); border-radius:12px; padding:16px 20px; }
        .stat-card .stat-label { font-size:0.72rem; font-weight:600; text-transform:uppercase; letter-spacing:0.05em; color:var(--text-muted); margin-bottom:6px; }
        .stat-card .stat-value { font-size:1.75rem; font-weight:700; line-height:1; }
        .stat-card .stat-sub { font-size:0.72rem; color:var(--text-muted); margin-top:4px; }

        /* FUNNEL */
        .funnel-wrap { display:flex; align-items:stretch; background:white; border:1px solid var(--border); border-radius:12px; overflow:hidden; }
        .funnel-step { flex:1; padding:16px; border-right:1px solid var(--border); text-align:center; }
        .funnel-step:last-child { border-right:none; }
        .funnel-step .fs-num { font-size:1.5rem; font-weight:700; }
        .funnel-step .fs-lbl { font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.05em; color:var(--text-muted); margin-top:3px; }
        .funnel-step .fs-bar { height:3px; border-radius:99px; margin-top:10px; }
        .funnel-arrow { display:flex; align-items:center; padding:0 4px; color:var(--text-light); align-self:center; }

        /* Page content padding */
        .page-content { padding:28px; }

        /* Pagination */
        .pagination-wrap { padding:14px 20px; border-top:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; font-size:0.78rem; color:var(--text-muted); }
        .pagination-links { display:flex; gap:4px; }
        .pagination-links a, .pagination-links span { padding:5px 10px; border:1px solid var(--border); border-radius:5px; font-size:0.78rem; color:var(--text-muted); text-decoration:none; }
        .pagination-links .active-page { background:var(--accent); border-color:var(--accent); color:white; }
    </style>
</head>
<body x-data="adminApp()" @keydown.escape="closeDrawer()">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-dot">S</div>
            Seav.ai
        </div>
        <div class="nav-menu">
            <div class="nav-label">Platform</div>
            <button class="nav-item"
                    :class="{ active: currentPage === 'dashboard' }"
                    hx-get="{{ route('admin.dashboard') }}"
                    hx-target="#main-content"
                    hx-push-url="true"
                    hx-indicator="#nav-spinner"
                    @click="currentPage = 'dashboard'; pageTitle = 'Dashboard'; pageMeta = 'Platform overview'">
                <i class="fa-solid fa-chart-pie"></i> Dashboard
            </button>
            <button class="nav-item"
                    :class="{ active: currentPage === 'jobs' }"
                    hx-get="{{ route('admin.jobs') }}"
                    hx-target="#main-content"
                    hx-push-url="true"
                    hx-indicator="#nav-spinner"
                    @click="currentPage = 'jobs'; pageTitle = 'Job Listings'; pageMeta = 'Manage all indexed jobs'">
                <i class="fa-solid fa-briefcase"></i> Job Listings
                <span class="nav-badge green" id="sidebar-job-count">{{ \App\Models\JobListing::where('status','active')->count() }}</span>
            </button>

            <div class="nav-label">Coming Soon</div>
            <button class="nav-item" @click="toast('Candidates module — coming soon!')">
                <i class="fa-solid fa-users"></i> Candidates
            </button>
            <button class="nav-item" @click="toast('Match Engine — coming soon!')">
                <i class="fa-solid fa-bolt"></i> Smart Matching
            </button>
            <button class="nav-item" @click="toast('Resume Services — coming soon!')">
                <i class="fa-solid fa-file-lines"></i> Resume Services
            </button>
        </div>
        <div class="user-profile">
            <div class="avatar">AD</div>
            <div class="user-info"><b>Admin</b><small>seav.ai</small></div>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main-wrapper">
        <!-- TOP HEADER -->
        <header class="top-header">
            <div>
                <div class="header-title" x-text="pageTitle">@yield('page-title', 'Dashboard')</div>
                <div class="header-meta" x-text="pageMeta">@yield('page-meta', 'Platform overview')</div>
            </div>
            <div class="header-right">
                <span id="nav-spinner" class="htmx-indicator" style="font-size:0.78rem; color:var(--text-muted); display:none;">
                    <i class="fa-solid fa-circle-notch fa-spin"></i> Loading…
                </span>
                <a href="{{ route('home') }}" class="btn btn-secondary btn-sm" target="_blank">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> View Site
                </a>
            </div>
        </header>

        <!-- PAGE CONTENT — HTMX swaps here -->
        <div id="main-content">
            @yield('content')
        </div>
    </div>

    <!-- DRAWER SHELL — Alpine controls show/hide, HTMX loads content -->
    <div x-show="drawerOpen" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="drawer-overlay" @click="closeDrawer()" style="display:none;"></div>

    <div x-show="drawerOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
         class="drawer" style="display:none;">
        <div id="drawer-body" class="drawer-body">
            <div style="display:flex;align-items:center;justify-content:center;height:100%;color:var(--text-muted);">
                <i class="fa-solid fa-circle-notch fa-spin" style="margin-right:8px;"></i> Loading…
            </div>
        </div>
    </div>

    <!-- TOAST -->
    <div id="toast" x-show="toastVisible" x-text="toastMessage"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         style="display:none;"></div>

    <script>
        function adminApp() {
            return {
                currentPage: '{{ request()->segment(2) ?? "dashboard" }}',
                pageTitle: '{{ $pageTitle ?? "Dashboard" }}',
                pageMeta: '{{ $pageMeta ?? "Platform overview" }}',
                drawerOpen: false,
                toastVisible: false,
                toastMessage: '',
                toastTimer: null,

                openDrawer() {
                    this.drawerOpen = true;
                },
                closeDrawer() {
                    this.drawerOpen = false;
                },
                toast(msg) {
                    this.toastMessage = msg;
                    this.toastVisible = true;
                    clearTimeout(this.toastTimer);
                    this.toastTimer = setTimeout(() => { this.toastVisible = false; }, 3000);
                }
            }
        }

        // After HTMX swaps main content, sync Alpine page state
        document.body.addEventListener('htmx:afterSwap', function(e) {
            if (e.detail.target.id === 'main-content') {
                const page = e.detail.requestConfig.path.split('/')[2] || 'dashboard';
                const app = Alpine.$data(document.body);
                if (app) {
                    app.currentPage = page;
                }
            }
            // If drawer body was swapped, open it
            if (e.detail.target.id === 'drawer-body') {
                const app = Alpine.$data(document.body);
                if (app) app.openDrawer();
            }
        });

        // CSRF for PATCH requests
        document.body.addEventListener('htmx:configRequest', function(e) {
            e.detail.headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
        });
    </script>
</body>
</html>
