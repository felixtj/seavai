@extends('layouts.app')

@section('content')
<div style="max-width:720px;margin:80px auto;padding:0 24px;font-family:Inter,sans-serif;color:#0F172A;line-height:1.75">
    <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:8px;text-decoration:none;margin-bottom:40px">
        <div style="width:32px;height:32px;background:#2563EB;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:13px">S</div>
        <span style="font-size:18px;font-weight:700;color:#0F172A">seav<span style="color:#2563EB">.ai</span></span>
    </a>

    <h1 style="font-size:2rem;font-weight:700;margin-bottom:8px">Privacy Policy</h1>
    <p style="color:#64748B;font-size:0.875rem;margin-bottom:40px">Last updated: {{ date('F j, Y') }}</p>

    <h2 style="font-size:1.1rem;font-weight:600;margin-bottom:8px">What we collect</h2>
    <p style="margin-bottom:24px">We collect your name, email address, and optional profile information (resume, work preferences) that you provide when creating an account or using our services. If you sign in with Google, we receive your name, email, and profile photo from Google.</p>

    <h2 style="font-size:1.1rem;font-weight:600;margin-bottom:8px">How we use your data</h2>
    <p style="margin-bottom:24px">Your data is used solely to provide seav.ai services: matching you with relevant jobs, optimising your resume using AI, and sending relevant communications if you opt in. We do not sell your personal information to any third party.</p>

    <h2 style="font-size:1.1rem;font-weight:600;margin-bottom:8px">Third-party services</h2>
    <p style="margin-bottom:24px">We use Google OAuth for sign-in. We use OpenAI's API to process resume text — only resume content is sent, no other identifying information. Payments are processed by Stripe. None of these providers may use your data for their own purposes beyond the service they provide to us.</p>

    <h2 style="font-size:1.1rem;font-weight:600;margin-bottom:8px">Cookies and sessions</h2>
    <p style="margin-bottom:24px">We use a session cookie to keep you logged in. No advertising or tracking cookies are used.</p>

    <h2 style="font-size:1.1rem;font-weight:600;margin-bottom:8px">Data retention and deletion</h2>
    <p style="margin-bottom:24px">You may delete your account at any time from Settings → Delete Account. All personal data is permanently removed within 30 days of deletion.</p>

    <h2 style="font-size:1.1rem;font-weight:600;margin-bottom:8px">Contact</h2>
    <p>For privacy questions, email <a href="mailto:hello@seav.ai" style="color:#2563EB">hello@seav.ai</a>.</p>
</div>
@endsection
