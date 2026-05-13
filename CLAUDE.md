# seav.ai — Project Context for AI Sessions

## What this is
seav.ai is a **candidate-first job marketplace** for Australia focused on digital marketing, tech, and AI/crypto roles. Full product spec is in `prd.md`.

## Key documents
- `prd.md` — Full product spec and vision
- `BUILDPLAN.md` — Full phase-by-phase reference (Phases 1–4), DB schema, prompts, env vars
- `MVP.md` — **Start here.** Flat checklist of only what's needed to launch. Work top to bottom.
- `CLAUDE.md` — This file. App structure, patterns, current status, handoff notes.

## Stack
| Layer | Choice | Notes |
|---|---|---|
| Backend | Laravel 12 | Monolith-first |
| Templating | Blade | Server-rendered |
| Interactivity | HTMX 2 | Partial swaps, no full reloads |
| UI state | Alpine.js 3 | Drawer open/close, toasts, small state only |
| CSS | Tailwind (Play CDN) + custom | Admin uses inline vars + custom classes |
| Database | MySQL | DB: `seavai`, user: `root`, no password (local XAMPP) |
| Auth | Custom (no Breeze) + Socialite | Google OAuth first, LinkedIn later |
| AI | OpenAI Responses API via `openai-php/laravel` v0.19.1 | Swappable — see AI driver pattern below |
| PDF/DOCX | `smalot/pdfparser` + `phpoffice/phpword` | PHP only, no Python microservice |
| File storage | Local now → Wasabi (S3-compatible) later | Zero code change on migrate |
| Email | SMTP2Go via Laravel SMTP mailer | |
| Queue | Database queue driver | Redis not available on Hostinger shared hosting |
| JS build | None | No Vite/npm — all CDN |

**No SPA framework (React/Vue).** HTMX + Blade is the deliberate choice.

## Running the app
```bash
# NOTE: No laravel/public/ directory — public_html/ is the web root

# Option A — PHP built-in server:
cd laravel && php -S localhost:8080 -t ../public_html
# → http://localhost:8080

# Option B — XAMPP Apache (already running):
# → http://localhost/projects3/bigwavedigital/seavai/public_html/
# If you get tempnam() error run: php artisan view:clear && php artisan config:clear
# XAMPP Apache runs as a different user — storage/ needs chmod 777:
# chmod -R 777 laravel/storage laravel/bootstrap/cache
```

## Deploying to Hostinger
```bash
# From repo root — syncs laravel/ and public_html/ via FTP (incremental, skips .env)
bash deploy.sh
# Needs lftp: brew install lftp (one-time)
# Hostinger .env is managed manually — never overwritten by deploy.sh
```

## Database
```bash
# Local XAMPP MySQL — already set up
# DB: seavai | user: root | password: (empty)
# XAMPP mysql binary: /Applications/XAMPP/xamppfiles/bin/mysql

# Reset everything:
cd laravel && php artisan migrate:fresh --seed --force
```

---

## Current Status (as of 2026-05-13)

### Done
- [x] Demo app complete — admin dashboard, jobs table, drawer, HTMX patterns all working
- [x] All database migrations created and verified (29 tables, see schema below)
- [x] `.env` configured — XAMPP MySQL, OpenAI key set, AI provider vars added
- [x] `MVP.md` created — flat checklist for Phase 1 only
- [x] `BUILDPLAN.md` updated — full Phase 1–4 reference with compliance checklist
- [x] **Section 0 complete** — all packages installed (Socialite, OpenAI, pdfparser, phpword, dompdf, Stripe, Debugbar)
- [x] **Section 1 complete** — full auth system built (no Breeze): Google OAuth, email login/register, password reset, email verification, login_logs, privacy page, seav.ai branded views
- [x] **Deploy script** — `deploy.sh` at repo root uses `lftp` to FTP sync to Hostinger (run `bash deploy.sh` to deploy). Excluded from git (has FTP password). Needs `brew install lftp` once.
- [x] **Git repo** initialised at `seavai/` root, pushed to `github.com/felixtj/seavai` (private)
- [x] **Section 2 complete** — `CandidateProfile` + `CandidateSkill` models, `UserObserver` auto-creates profile on register, 5-step HTMX onboarding wizard, `EnsureOnboardingComplete` middleware redirects `/dashboard` to `/onboarding` until done
- [x] **Section 3 complete** — Resume upload & AI parsing fully integrated into onboarding Step 3:
  - `Resume` + `ResumeVersion` models
  - Swappable AI driver: `app/Services/AI/` — `AiProvider` interface, `OpenAiProvider` (OpenAI Responses API), `GrokProvider` (xAI HTTP), `AiProviderFactory` reads `AI_PROVIDER` env var
  - `ParseResumeJob` — PDF/DOCX text extraction → AI parse → save JSON, `tries=2`
  - `ResumeController` — store, status (HTMX poll), download (auth-gated stream), confirm
  - Onboarding Step 3: LinkedIn URL + Alpine drag-and-drop upload zone
  - Partials: `processing.blade.php` (spinner + 3s poll), `review.blade.php` (editable fields), `failed.blade.php`
  - On confirm: saves to `candidate_profiles` + `candidate_skills` (source=ai-extracted), returns Step 4 partial (skills pre-populated)

### Next task — MVP.md Section 4: AI Resume Writer
Pick up from here in the next session:
1. `GenerateResumeJob` — send confirmed profile JSON to AI (`rewriteResume()`), save to `resume_versions` (type=ai-draft)
2. HTMX polling every 3s until draft ready
3. Side-by-side review UI: original bullets vs AI-rewritten
4. Accept → save as `resume_version` (type=final) | Regenerate → dispatch new job | Edit manually (inline)
5. LinkedIn package: headline (220 chars) + About section (2000 chars) — same job, separate prompts
6. Cover letter generator (one prompt, per role focus)
7. PDF download via `barryvdh/laravel-dompdf`
8. DOCX download via `phpoffice/phpword`

### Auth — key files
- `app/Http/Controllers/Auth/` — 5 controllers (Social, Login, Register, PasswordReset, EmailVerification)
- `app/Models/LoginLog.php` — insert-only login event log (no updated_at)
- `resources/views/auth/` — 5 branded views (login, register, verify-email, forgot/reset-password)
- `resources/views/layouts/auth.blade.php` — centered card, Inter font, seav.ai blue

### AI driver — key files
- `app/Services/AI/AiProvider.php` — interface (`parseResume`, `rewriteResume`)
- `app/Services/AI/OpenAiProvider.php` — OpenAI Responses API (`OpenAI::responses()->create(...)`)
- `app/Services/AI/GrokProvider.php` — xAI via Laravel HTTP client
- `app/Services/AI/AiProviderFactory.php` — reads `env('AI_PROVIDER', 'openai')`
- Switch LLM: `AI_PROVIDER=grok` in `.env` | Change model: `OPENAI_MODEL=gpt-5.4-mini` or `GROK_MODEL=grok-3`

### Resume — key files
- `app/Models/Resume.php` + `app/Models/ResumeVersion.php`
- `app/Jobs/ParseResumeJob.php`
- `app/Http/Controllers/Candidate/ResumeController.php`
- `resources/views/candidate/resume/partials/` — processing, review, failed
- `resources/views/onboarding/partials/step.blade.php` — Step 3 has upload + LinkedIn UI

---

## Database — Complete Schema (29 tables)

### Phase 1 — MVP tables

**`users`**
`id, name, email (nullable), password (nullable), google_id, linkedin_id, avatar_url, marketing_opt_in, email_verified_at, remember_token, timestamps`

**`candidate_profiles`**
`id, user_id FK, role_focus (enum: digital-marketing/tech/ai-crypto), location, remote_preference (enum: remote/hybrid/onsite/flexible), seniority (enum: junior/mid/senior/lead/any), salary_min, salary_max, currency (AUD), linkedin_url, headline, bio, onboarding_step (0–5), onboarding_completed_at, profile_completeness (0–100), timestamps`

**`candidate_skills`**
`id, candidate_profile_id FK, skill, source (enum: manual/ai-extracted), timestamps`

**`resumes`**
`id, user_id FK, original_filename, stored_path, mime_type, file_size, status (enum: uploaded/parsing/parsed/failed), parsed_data (JSON), parse_error, is_primary (bool), timestamps`

**`resume_versions`**
`id, resume_id FK, version_type (enum: original/ai-draft/human-reviewed/final), content_json (JSON), generated_content (longtext), pdf_path, docx_path, created_by (enum: candidate/ai/coach), timestamps`

**`service_orders`**
`id, user_id FK, resume_id FK nullable, tier (enum: basic/pro/premium), status (enum: pending/paid/in-progress/complete/refunded), stripe_payment_intent_id, stripe_session_id, amount_cents, currency, notes, completed_at, timestamps`

**`coaching_sessions`**
`id, service_order_id FK, scheduled_at, duration_minutes, meeting_url, notes, status (enum: pending/confirmed/done/cancelled), timestamps`

**`login_logs`** ← security
`id, user_id FK nullable, email, event (enum: login_success/login_failed/logout/google_login/password_reset), ip_address, country, user_agent, device_type, created_at (immutable — no updated_at)`

**`notifications`** ← Laravel standard polymorphic
`id (uuid), type, notifiable_type, notifiable_id, data (JSON), read_at, timestamps`

**`job_applications`** ← tracks seav.ai jobs AND manually added external jobs
`id, user_id FK, job_listing_id FK nullable, company_name, job_title, job_url, status (enum: saved/applied/phone-screen/interview/offer/rejected/withdrawn), applied_at, notes, timestamps`

### Phase 2 — Matching tables

**`companies`**
`id, name, slug, domain, logo_url, description, ats_type (enum: greenhouse/lever/ashby/workable/smartrecruiters/generic), career_page_url, is_active, scraping_allowed, opt_out_requested_at, last_crawled_at, timestamps`

**`job_listings`** ← already existed, extended with:
`+ company_id FK, canonical_url, ats_job_id, content_hash, source_publish_date, last_seen_at, skills_extracted (JSON), seniority_extracted, benefits_extracted (JSON)`

**`job_skills`**
`id, job_listing_id FK, skill, is_required (bool), timestamps`

**`saved_jobs`**
`id, user_id FK, job_listing_id FK, notes, timestamps — unique(user_id, job_listing_id)`

**`subscriptions`**
`id, user_id FK, plan (enum: monthly/annual), status (enum: active/paused/cancelled/past_due), stripe_subscription_id, stripe_customer_id, current_period_start, current_period_end, cancelled_at, timestamps`

**`match_batches`**
`id, run_at, candidate_count, job_count, status (enum: running/complete/failed), timestamps`

**`match_recommendations`**
`id, match_batch_id FK, user_id FK, job_listing_id FK, score (decimal 0–1), score_breakdown (JSON), score_label_breakdown (JSON — human-readable "why"), status (enum: pending/sent/seen/saved/applied/dismissed), timestamps`

**`match_feedback`**
`id, match_recommendation_id FK, user_id FK, signal (enum: relevant/not-relevant/already-seen/wrong-location/wrong-remote/too-senior/too-junior), created_at (immutable)`

### Phase 3 — Public board tables

**`company_sources`**
`id, company_id FK, source_type, source_url, connector_class, is_active, last_run_at, last_success_at, failure_count, last_error, timestamps`

**`crawl_runs`**
`id, company_source_id FK, started_at, finished_at, jobs_found, jobs_new, jobs_updated, jobs_closed, freshness_latency_minutes, status (enum: running/success/failed), error_log, timestamps`

**`takedown_requests`**
`id, company_id FK nullable, job_listing_id FK nullable, requester_email, reason, status (enum: pending/actioned/rejected), actioned_at, timestamps`

---

## Project layout
```
seavai/
  prd.md                          ← Full product PRD
  MVP.md                          ← Active build checklist (Phase 1 only) ← READ THIS
  BUILDPLAN.md                    ← Full phase reference (Phases 1–4)
  CLAUDE.md                       ← This file
  prototype/                      ← Static HTML prototypes (design reference)
    index_candidate.html          ← Landing page design source
    style_candidate.css           ← Landing page CSS
  laravel/                        ← The Laravel application
    .env                          ← Local XAMPP config (DB: seavai, root, no password)
    database/migrations/          ← 25 migration files — all run, all verified
    app/Http/Controllers/
      WelcomeController.php
      Admin/AdminController.php
    app/Http/Traits/
      ResolvesAdminView.php       ← HTMX view resolution — read before touching admin pages
    resources/views/
      layouts/admin.blade.php     ← Admin shell (sidebar, HTMX, Alpine, drawer, toast)
      layouts/app.blade.php       ← Public layout
      welcome.blade.php           ← Landing page
      admin/                      ← Admin pages + partials (all working)
```

---

## The HTMX pattern — how it works

Every HTMX request includes `HX-Request: true`. The target element ID is in `HX-Target`.

| Request type | HX-Target | Returns |
|---|---|---|
| Direct URL visit | *(none)* | Full layout view |
| Sidebar nav click | `main-content` | Content partial (no layout wrapper) |
| In-page swap (filter/search/pagination) | specific id | Small partial |

### The `ResolvesAdminView` trait
`app/Http/Traits/ResolvesAdminView.php` — calling `$this->adminPage('dashboard', $data)` returns the right view for direct visit vs HTMX nav click automatically.

---

## Adding a new admin page — checklist

1. **Full layout view** — `resources/views/admin/{page}.blade.php`
2. **Content partial** — `resources/views/admin/partials/{page}-content.blade.php` (no `@extends`)
3. **Controller method** — `return $this->adminPage('page', compact('data'));`
4. **Route** — `Route::get('/admin/page', [AdminController::class, 'page'])->name('admin.page');`
5. **Sidebar nav** — button with `hx-get`, `hx-target="#main-content"`, `hx-push-url="true"`

---

## Key technical patterns

### Async AI job pattern
```php
// Controller — return "processing" state immediately
$resume->update(['status' => 'parsing']);
ParseResumeJob::dispatch($resume);
return view('resumes.partials.processing-state', compact('resume'));

// HTMX polls every 3s until done:
// <div hx-get="/resumes/{id}/status" hx-trigger="every 3s" hx-swap="outerHTML">
```

### File security pattern
```php
// Never expose storage path. Always stream through auth route:
Route::get('/resumes/{resume}/download', function (Resume $resume) {
    abort_if($resume->user_id !== auth()->id(), 403);
    return Storage::download($resume->stored_path, $resume->original_filename);
})->middleware('auth');
```

### Onboarding partial save pattern
```php
// Each step POSTs, returns next step as a partial
// hx-post="/onboarding/step/1" hx-target="#onboarding-body" hx-swap="innerHTML"
Route::post('/onboarding/step/{step}', [OnboardingController::class, 'save']);
```

### CSRF for PATCH/POST/DELETE (already in admin layout)
```js
document.body.addEventListener('htmx:configRequest', function(e) {
    e.detail.headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
});
```

---

## Admin layout internals (`layouts/admin.blade.php`)
- `#main-content` — HTMX swaps page content here on sidebar nav
- `#drawer-body` — HTMX loads record detail here on row click
- `.drawer` / `.drawer-overlay` — Alpine `x-show="drawerOpen"`
- `#toast` — Alpine `x-show="toastVisible"` + `x-text="toastMessage"`
- Alpine root: `adminApp()` on `<body>` — exposes `openDrawer()`, `closeDrawer()`, `toast('msg')`

---

## AI Prompt Specs

Prompts live as constants inside `OpenAiProvider` / `GrokProvider`. Both providers use the same prompt text — only the API call differs.

### Resume Parsing (`parseResume`)
```
instructions: You are a resume parser. Extract structured data. Return ONLY valid JSON with no markdown, no code fences:
{
  "contact": { "name", "email", "phone", "location", "linkedin_url" },
  "summary": "string or null",
  "work_history": [{ "company", "title", "start_date", "end_date", "is_current", "description" }],
  "education": [{ "institution", "degree", "field", "start_year", "end_year" }],
  "skills": ["string"],
  "certifications": ["string"],
  "languages": ["string"]
}
Dates: "YYYY-MM" or "YYYY". Null if unknown. Never hallucinate.
input: [resume plain text]
```

### Resume Rewriting (`rewriteResume`)
```
instructions: Expert resume writer for Australian job market. Rewrite work history bullets
with stronger action verbs and quantified results (never invented). Australian English.
Return ONLY the same JSON structure with updated "description" fields in work_history. No markdown, no code fences.
input: {confirmed_profile_json}
```

### OpenAI call pattern (Responses API)
```php
OpenAI::responses()->create([
    'model'        => env('OPENAI_MODEL', 'gpt-4o'),
    'instructions' => SYSTEM_PROMPT,
    'input'        => $userContent,
    'temperature'  => 0,
]);
// Extract text: $response->outputText
```

---

## CSS approach
- **Admin** — inline `<style>` block in `layouts/admin.blade.php` using CSS vars (`--accent`, `--border`, etc.) + Tailwind Play CDN
- **Public** — `public/css/style_candidate.css` (copied from prototype)
- No Vite/npm build pipeline — CDN only

## Static assets
```
public/
  css/style_candidate.css
  assets/candidate-hero.png
```
