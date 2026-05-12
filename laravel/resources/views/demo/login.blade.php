<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — Seav.ai</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #F8FAFC; margin: 0; }
        h1,h2 { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex">

    <!-- Left panel — branding -->
    <div style="width:45%;background:linear-gradient(145deg,#1e40af 0%,#2563eb 50%,#3b82f6 100%);padding:60px;display:flex;flex-direction:column;justify-content:space-between;color:white;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:60px;">
                <div style="width:32px;height:32px;background:rgba(255,255,255,0.2);border-radius:8px;display:flex;align-items:center;justify-content:center;font-family:'Outfit',sans-serif;font-weight:800;font-size:0.9rem;">S</div>
                <span style="font-family:'Outfit',sans-serif;font-weight:800;font-size:1.2rem;">Seav.ai</span>
            </div>
            <h1 style="font-size:2.2rem;font-weight:800;line-height:1.2;margin-bottom:20px;">Your next role<br>is already waiting.</h1>
            <p style="opacity:.85;font-size:1rem;line-height:1.6;max-width:340px;">Seav.ai matches Australian digital & tech talent with real opportunities from company career pages — no ads, no noise.</p>
        </div>

    </div>

    <!-- Right panel — form -->
    <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:60px 40px;">
        <div style="width:100%;max-width:400px;">
            <h2 style="font-size:1.75rem;font-weight:800;margin-bottom:6px;">Welcome back</h2>
            <p style="color:#64748B;margin-bottom:32px;font-size:0.9rem;">Sign in to your Seav.ai account</p>

            <!-- Google button -->
            <a href="{{ route('demo.dashboard') }}" style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:12px;border:1.5px solid #E2E8F0;border-radius:10px;font-weight:600;font-size:0.875rem;color:#0F172A;text-decoration:none;background:white;transition:all .15s;margin-bottom:20px;" onmouseover="this.style.borderColor='#2563EB';this.style.background='#EFF6FF'" onmouseout="this.style.borderColor='#E2E8F0';this.style.background='white'">
                <svg width="18" height="18" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
                Continue with Google
            </a>

            <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
                <div style="flex:1;height:1px;background:#E2E8F0;"></div>
                <span style="color:#94A3B8;font-size:0.78rem;">or sign in with email</span>
                <div style="flex:1;height:1px;background:#E2E8F0;"></div>
            </div>

            <!-- Email form (demo — just redirects) -->
            <div style="display:flex;flex-direction:column;gap:14px;margin-bottom:20px;">
                <div>
                    <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:6px;">Email address</label>
                    <input type="email" value="sarah.chen@email.com" style="width:100%;padding:10px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:0.875rem;outline:none;font-family:inherit;" onfocus="this.style.borderColor='#2563EB'" onblur="this.style.borderColor='#E2E8F0'">
                </div>
                <div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                        <label style="font-size:0.78rem;font-weight:600;color:#374151;">Password</label>
                        <a href="#" style="font-size:0.78rem;color:#2563EB;text-decoration:none;">Forgot password?</a>
                    </div>
                    <input type="password" value="••••••••" style="width:100%;padding:10px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:0.875rem;outline:none;font-family:inherit;" onfocus="this.style.borderColor='#2563EB'" onblur="this.style.borderColor='#E2E8F0'">
                </div>
            </div>

            <a href="{{ route('demo.dashboard') }}" style="display:block;width:100%;padding:12px;background:#2563EB;color:white;text-align:center;border-radius:10px;font-weight:600;font-size:0.875rem;text-decoration:none;transition:background .15s;" onmouseover="this.style.background='#1D4ED8'" onmouseout="this.style.background='#2563EB'">
                Sign In
            </a>

            <p style="text-align:center;margin-top:24px;font-size:0.82rem;color:#64748B;">
                Don't have an account? <a href="{{ route('demo.onboarding') }}" style="color:#2563EB;font-weight:600;text-decoration:none;">Sign up free</a>
            </p>
        </div>
    </div>

</body>
</html>
