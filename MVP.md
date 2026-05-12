# seav.ai — MVP Checklist

> Goal: Candidate can register, upload resume, get AI-optimised output, and pay for it.
> Everything else comes later.

---

## How to use this file
- Work top to bottom — each section depends on the previous
- Tick boxes as you go: `- [x]`
- Don't skip ahead

---

## 0. Setup (do once)

- [x] `cd laravel && php -S localhost:8080 -t ../public_html` (note: no laravel/public dir — use public_html)
- [x] Confirm DB exists: DB `seavai` confirmed, 29 tables migrated
- [x] Install packages:
  ```bash
  composer require laravel/socialite          # ✓ installed
  composer require openai-php/laravel         # ✓ installed
  composer require smalot/pdfparser           # ✓ installed
  composer require phpoffice/phpword          # ✓ installed
  composer require barryvdh/laravel-dompdf    # ✓ installed
  composer require stripe/stripe-php          # ✓ installed
  composer require barryvdh/laravel-debugbar --dev  # ✓ installed
  ```
  Note: laravel/breeze NOT installed — auth views built manually (no Vite conflict)
- [x] `QUEUE_CONNECTION=database` kept (Redis not available on Hostinger shared hosting)
- [x] DB already migrated — all 29 tables verified
- [ ] Confirm `php artisan horizon` runs without errors (skip — no Redis on shared hosting; use database queue driver)

---

## 1. Auth

- [x] Add columns to users migration: `google_id`, `linkedin_id`, `avatar_url` (nullable), make `password` nullable — already done in previous session
- [x] Run `php artisan migrate` — all columns confirmed in DB
- [x] Create `SocialAuthController` — `redirectToGoogle()` + `handleGoogleCallback()`
  - Find by `google_id` → find by email → create new user
- [x] Add Google routes in `web.php`
- [x] Add "Continue with Google" button to login + register views (above email form)
- [x] Auth views built to seav.ai brand (blue #2563EB, Inter font, centered card layout)
- [x] Add privacy policy page at `/privacy`
- [x] Add marketing opt-in checkbox to register form (unchecked by default)
- [x] Email verification working — `MustVerifyEmail` on User model, `/email/verify` route, Google users pre-verified
- [ ] **TODO:** Add Google OAuth credentials to `.env` (`GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`)
- [ ] **TODO:** Test: email register → verify email → login, Google register → login
- [ ] **TODO:** Check login_logs table populated after login/register

---

## 2. Candidate Profile & Onboarding

- [x] Migration + model: `candidate_profiles` — `CandidateProfile` model with `recalculateCompleteness()`
- [x] Migration + model: `candidate_skills` — `CandidateSkill` model
- [x] Auto-create empty `CandidateProfile` on user register — `UserObserver` registered in `AppServiceProvider`
- [x] 5-step onboarding wizard at `/onboarding`:
  - [x] Step 1 — Role focus: `digital-marketing / tech / ai-crypto` (radio card UI)
  - [x] Step 2 — Work prefs: location, remote type, seniority, salary range
  - [x] Step 3 — LinkedIn URL (or skip)
  - [x] Step 4 — Top skills (Alpine tag input, comma/enter to add, up to 20)
  - [x] Step 5 — Weekly match email opt-in (checkbox)
  - [x] Each step: `hx-post` saves → returns next step partial → no full reload
  - [x] Alpine progress bar tracks current step
  - [x] Back button works without losing data
- [x] After register, redirect to `/onboarding` — `RegisterController` + `SocialAuthController` both redirect new users to `/onboarding`
- [x] If onboarding not complete, `/dashboard` redirects to `/onboarding` — `EnsureOnboardingComplete` middleware with alias `onboarded`
- [x] `profile_completeness` int (0–100) recalculated on every profile save via `recalculateCompleteness()`
- [ ] **TODO:** If onboarding skipped partway, show persistent banner on dashboard (implement in Section 6)

---

## 3. Resume Upload & AI Parsing

- [ ] Migration + model: `resumes`
- [ ] Migration + model: `resume_versions`
- [ ] Upload UI: drag-and-drop (Alpine) + file input fallback, accepts PDF + DOCX
- [ ] Store file to `storage/app/resumes/{user_id}/{filename}` (local disk)
- [ ] Secure download route: auth middleware + stream — never expose storage path directly
- [ ] On upload: set `status = parsing`, dispatch `ParseResumeJob`
- [ ] `ParseResumeJob`:
  - [ ] Extract text: PDF → `smalot/pdfparser`, DOCX → `phpoffice/phpword`
  - [ ] Send to OpenAI with parsing prompt (see BUILDPLAN.md for prompt)
  - [ ] Save JSON to `resumes.parsed_data`
  - [ ] Set `status = parsed` (or `failed` on error)
- [ ] HTMX polling every 3s on upload page until `status = parsed`
- [ ] Show parsed data review form (work history, skills, education, contact) — all fields editable
- [ ] On submit: save confirmed data to `candidate_profiles` + `candidate_skills`

---

## 4. AI Resume Writer

- [ ] On profile confirm: dispatch `GenerateResumeJob`
- [ ] `GenerateResumeJob`:
  - [ ] Send confirmed profile JSON to OpenAI with rewriting prompt (see BUILDPLAN.md)
  - [ ] Save result to `resume_versions` (`version_type = ai-draft`)
- [ ] HTMX polling every 3s until draft ready
- [ ] AI draft review UI:
  - [ ] Show original bullet points vs AI-rewritten side by side
  - [ ] "Accept" → save as `resume_version` (`type = final`)
  - [ ] "Regenerate" → dispatch new `GenerateResumeJob`
  - [ ] "Edit manually" → inline text editing before saving
- [ ] LinkedIn package (same job, separate prompts):
  - [ ] Headline (220 chars max)
  - [ ] About section (2000 chars max)
- [ ] Cover letter generator (basic — one prompt, per role focus)
- [ ] PDF download: generate via `barryvdh/laravel-dompdf`
- [ ] DOCX download: generate via `phpoffice/phpword`

---

## 5. Pricing & Stripe Checkout

- [ ] Migration + model: `service_orders`
- [ ] Pricing page at `/pricing`:
  - Basic (free): 1 AI parse, 1 draft, PDF download
  - Pro ($49): unlimited revisions, LinkedIn package, cover letter, DOCX download
  - Premium ($149): everything + coaching session booking
- [ ] Stripe Checkout Session for Pro + Premium
- [ ] Webhook route: update `service_orders.status` on `checkout.session.completed`
- [ ] Gate features by tier (middleware or policy check)
- [ ] Invoice/confirmation email on payment

---

## 6. Candidate Dashboard

- [ ] `/dashboard` — home after login
- [ ] Profile completeness bar (HTMX lazy-load the %)
- [ ] Resume card: file name, status badge, actions (view / optimize / download)
- [ ] Matched jobs teaser: 3 locked placeholder cards ("Complete your profile to unlock")
- [ ] Application tracker: add manually, update status (applied / interview / offer / rejected)
- [ ] Quick stats: resumes optimised, applications tracked

---

## 7. Settings

- [ ] `/settings/profile` — name, location, remote preference, salary range
- [ ] `/settings/security` — change password (hidden for Google-only accounts)
- [ ] `/settings/notifications` — weekly email on/off
- [ ] `/settings/billing` — past orders + download invoices
- [ ] Delete account — confirmation prompt + queue data deletion job

---

## MVP Done When...

- [ ] A new user can sign up with Google in under 60 seconds
- [ ] They can upload a resume and see AI-parsed data within 30 seconds of job completing
- [ ] They can accept the AI draft and download a PDF
- [ ] A Pro payment goes through Stripe and unlocks features
- [ ] The flow works on mobile (check each step on a phone)
