@extends('layouts.app')

@section('title', 'Seav.ai - The Candidate-First Job Marketplace')

@section('content')

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="container nav-content">
            <a href="{{ route('home') }}" class="logo">
                <i data-lucide="compass"></i>
                <span>Seav.ai</span>
            </a>
            <ul class="nav-links">
                <li><a href="#how-it-works" class="nav-item">How it Works</a></li>
                <li><a href="#features" class="nav-item">Features</a></li>
                <li><a href="#" class="nav-item">Reverse Board</a></li>
                <li><a href="#" class="nav-item">Smart Match</a></li>
            </ul>
            <div class="nav-auth">
                <a href="{{ route('demo.login') }}" class="nav-item">Sign In</a>
                <a href="{{ route('demo.login') }}" class="btn btn-primary">Try Candidate Demo</a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <header class="hero">
        <div class="hero-bg-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
        </div>
        <div class="container hero-grid">
            <div class="hero-content">
                <div class="hero-tag">
                    <i data-lucide="sparkles" size="14"></i>
                    <span>Exclusively for Digital &amp; Tech Talent</span>
                </div>
                <h1 class="hero-title">
                    The Job Search that <br>
                    <span class="text-gradient">Actually Works</span><br>
                    for You.
                </h1>
                <p class="hero-description">
                    We've flipped the script. Seav.ai indexes the "truth layer" of employer career pages in Australia, delivering high-quality roles directly to you—no paid ads, no noise.
                </p>
                <div class="hero-cta">
                    <a href="{{ route('demo.login') }}" class="btn btn-primary">Get Early Access</a>
                </div>
            </div>
            <div class="hero-image-container">
                <div class="hero-image-wrapper">
                    <img src="{{ asset('assets/hero.png') }}" alt="Seav.ai Platform Mockup" id="hero-img">
                </div>
                <div class="floating-card card-1 glass">
                    <div style="display:flex;gap:12px;align-items:center;">
                        <i data-lucide="check-circle" style="color:#10b981;"></i>
                        <div>
                            <p style="font-weight:700;font-size:14px;">98% Match</p>
                            <p style="font-size:12px;color:var(--text-muted);">Senior Product Designer</p>
                        </div>
                    </div>
                </div>
                <div class="floating-card card-2 glass">
                    <div style="display:flex;gap:12px;align-items:center;">
                        <i data-lucide="zap" style="color:#f59e0b;"></i>
                        <div>
                            <p style="font-weight:700;font-size:14px;">Instant Applied</p>
                            <p style="font-size:12px;color:var(--text-muted);">No repetitive forms</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Stats Bar -->
    <div class="stats-bar">
        <div class="container stats-grid">
            <div class="stat-item"><h2 class="text-gradient">24k+</h2><p>Live Roles</p></div>
            <div class="stat-item"><h2 class="text-gradient">352</h2><p>AU Companies</p></div>
            <div class="stat-item"><h2 class="text-gradient">100%</h2><p>No Paid Ads</p></div>
            <div class="stat-item"><h2 class="text-gradient">$0</h2><p>Free for Candidates</p></div>
        </div>
    </div>

    <!-- Features -->
    <section class="section" id="features">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Why Seav.ai</span>
                <h2 class="section-title">A New Category of Career Discovery</h2>
                <p>We built the tools candidates actually need to navigate the modern job market with confidence.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i data-lucide="layers"></i></div>
                    <h3>The Truth Layer</h3>
                    <p>We bypass Job Boards. We index roles directly from company career sites (ATS) so you see the real, active openings before they're buried by ads.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i data-lucide="target"></i></div>
                    <h3>Smart Match "Push"</h3>
                    <p>Don't browse endlessly. Tell us your ideal culture, WFH rules, and compensation. We'll push the exact matches to your inbox weekly.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i data-lucide="file-text"></i></div>
                    <h3>AI Resume Pulse</h3>
                    <p>Get instant feedback on how your experience aligns with specific roles. We help you highlight what actually matters to hiring managers.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How it Works -->
    <section class="section bg-light-blue" id="how-it-works" style="border-radius:var(--radius-lg);margin:0 24px;">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Workflow</span>
                <h2 class="section-title">Three Steps to Your Next Role</h2>
            </div>
            <div class="features-grid">
                <div style="text-align:center;">
                    <div style="font-size:40px;font-weight:800;color:var(--primary-hover);margin-bottom:20px;opacity:0.3;">01</div>
                    <h4 style="margin-bottom:12px;font-size:20px;">Upload &amp; Optimize</h4>
                    <p style="color:var(--text-muted);">Sync your LinkedIn or upload your CV. Our AI structures your profile for deep matching.</p>
                </div>
                <div style="text-align:center;">
                    <div style="font-size:40px;font-weight:800;color:var(--primary-hover);margin-bottom:20px;opacity:0.3;">02</div>
                    <h4 style="margin-bottom:12px;font-size:20px;">Set Your Filters</h4>
                    <p style="color:var(--text-muted);">Define your non-negotiables: Salary, Hybrid rules, Tech stack, and Company size.</p>
                </div>
                <div style="text-align:center;">
                    <div style="font-size:40px;font-weight:800;color:var(--primary-hover);margin-bottom:20px;opacity:0.3;">03</div>
                    <h4 style="margin-bottom:12px;font-size:20px;">Get Matched</h4>
                    <p style="color:var(--text-muted);">Receive curated "Pulse Checks" for roles that actually match your career goals.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="section" id="testimonials">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Success Stories</span>
                <h2 class="section-title">Loved by Candidates</h2>
            </div>
            <div class="features-grid">
                <div class="feature-card glass">
                    <div style="display:flex;gap:12px;align-items:center;margin-bottom:20px;">
                        <div style="width:48px;height:48px;border-radius:50%;background:var(--primary-light);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--primary);">JS</div>
                        <div><p style="font-weight:700;">James S.</p><p style="font-size:12px;color:var(--text-muted);">Senior Dev @ Canva</p></div>
                    </div>
                    <p style="font-style:italic;">"Seav.ai found me a role that wasn't even listed on the major job boards yet. The Reverse Board is a game changer for tech roles."</p>
                </div>
                <div class="feature-card glass">
                    <div style="display:flex;gap:12px;align-items:center;margin-bottom:20px;">
                        <div style="width:48px;height:48px;border-radius:50%;background:var(--primary-light);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--primary);">MK</div>
                        <div><p style="font-weight:700;">Michelle K.</p><p style="font-size:12px;color:var(--text-muted);">Marketing Lead</p></div>
                    </div>
                    <p style="font-style:italic;">"I love that I can set my WFH rules and only see roles that respect them. No more wasting time on 'flexible' roles that aren't."</p>
                </div>
                <div class="feature-card glass">
                    <div style="display:flex;gap:12px;align-items:center;margin-bottom:20px;">
                        <div style="width:48px;height:48px;border-radius:50%;background:var(--primary-light);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--primary);">AW</div>
                        <div><p style="font-weight:700;">Alex W.</p><p style="font-size:12px;color:var(--text-muted);">Product Manager</p></div>
                    </div>
                    <p style="font-style:italic;">"The AI Resume Pulse helped me tweak my CV for specific companies I was targeting. I got three interviews in two weeks."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="section" id="faq">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Knowledge Base</span>
                <h2 class="section-title">Common Questions</h2>
            </div>
            <div style="max-width:800px;margin:0 auto;">
                <details style="margin-bottom:16px;border-bottom:1px solid var(--border-light);padding-bottom:16px;">
                    <summary style="font-weight:600;cursor:pointer;">How is Seav.ai different from Seek or LinkedIn?</summary>
                    <p style="margin-top:12px;color:var(--text-muted);">Most job boards charge employers to post. We index company career pages directly. This means we show roles that aren't advertised elsewhere, and we never prioritize "paid" placements above real matches.</p>
                </details>
                <details style="margin-bottom:16px;border-bottom:1px solid var(--border-light);padding-bottom:16px;">
                    <summary style="font-weight:600;cursor:pointer;">Is Seav.ai really free for candidates?</summary>
                    <p style="margin-top:12px;color:var(--text-muted);">Yes. Our core platform for candidates to search and be matched with roles is 100% free. We are committed to remaining candidate-first.</p>
                </details>
                <details style="margin-bottom:16px;border-bottom:1px solid var(--border-light);padding-bottom:16px;">
                    <summary style="font-weight:600;cursor:pointer;">What industries do you specialize in?</summary>
                    <p style="margin-top:12px;color:var(--text-muted);">Currently, we specialize in Digital Marketing, Tech (Engineering, Product, Data), and AI roles across Australia.</p>
                </details>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="section">
        <div class="container" style="text-align:center;">
            <div class="glass" style="padding:80px;border-radius:var(--radius-lg);border:2px solid var(--primary-light);">
                <h2 style="font-size:48px;margin-bottom:24px;">Ready to own your career?</h2>
                <p style="font-size:18px;color:var(--text-muted);max-width:600px;margin:0 auto 40px;">
                    Join thousands of Australian candidates who are discovering roles the smarter way. Seav.ai is currently in private beta.
                </p>
                <div style="display:flex;gap:16px;justify-content:center;">
                    <a href="{{ route('demo.login') }}" class="btn btn-primary" style="padding:16px 40px;font-size:18px;">Get Early Access</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="{{ route('home') }}" class="logo footer-logo">
                        <i data-lucide="compass"></i>
                        <span>Seav.ai</span>
                    </a>
                    <p class="footer-desc">The only job marketplace aligned with candidates, not employer ad spend. Built for the future of work in Australia.</p>
                    <div class="social-links">
                        <a href="#" class="social-icon"><i data-lucide="twitter"></i></a>
                        <a href="#" class="social-icon"><i data-lucide="linkedin"></i></a>
                        <a href="#" class="social-icon"><i data-lucide="github"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Platform</h4>
                    <ul class="footer-links">
                        <li><a href="#">Candidate Portal</a></li>
                        <li><a href="#">Reverse Board</a></li>
                        <li><a href="#">Smart Matching</a></li>
                        <li><a href="#">AI Resume Check</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Resources</h4>
                    <ul class="footer-links">
                        <li><a href="#">AU Salary Guide</a></li>
                        <li><a href="#">Tech Market Report</a></li>
                        <li><a href="#">Interview Prep</a></li>
                        <li><a href="#">Community</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Company</h4>
                    <ul class="footer-links">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Seav.ai. All rights reserved.</p>
                <p>Built with ♥ for Australians</p>
            </div>
        </div>
    </footer>

@endsection
