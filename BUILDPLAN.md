# seav.ai — Build Plan

> Last updated: 2026-05-12
> Status: Demo app complete. Ready to build Phase 1.

---

## Strategic sequencing rationale

Three compounding loops drive build order: **(1) revenue → (2) data → (3) retention.**

The recommended sequence (from platform brief):
1. **Component 1 first** — AI Resume + LinkedIn Optimization generates revenue early, captures first-party candidate data, and builds the structured profile that matching needs.
2. **Component 3 next** — Weekly paid matching subscription ships before a full public job board, forcing the core technical problems (job normalisation + matching) to be solved with far less UI surface area.
3. **Component 2 last** — Public reverse job board becomes a distribution + trust layer once ingestion and scoring are stable.

---

## Confirmed Tech Decisions

| Concern | Choice | Notes |
|---|---|---|
| Framework | Laravel 11 | Monolith-first |
| Templating | Blade + HTMX + Alpine.js | No SPA framework |
| CSS | Tailwind Play CDN + custom vars | No Vite/npm build yet |
| Database | MySQL | DB: `seavai`, user: `root` |
| Auth | Laravel Breeze (Blade) + Socialite | Google OAuth first, LinkedIn later |
| AI | OpenAI API via `openai-php/laravel` | GPT-4o for parse + write |
| PDF parsing | `smalot/pdfparser` + `phpoffice/phpword` | PHP only, no Python |
| File storage | Local now → Wasabi later | S3-compatible, zero code change on migrate |
| Email | SMTP2Go via Laravel SMTP | Transactional + weekly match emails |
| Queues | Laravel Queues + Horizon + Redis | All AI jobs must be async |
| Hosting | Hostinger VPS | Needs Supervisor + Redis |

---

## Candidate Journey (Full Flow)

```
Land on seav.ai homepage
    ↓
Register (email+password OR Google)
    ↓
Email verification
    ↓
Onboarding Wizard (5 steps — HTMX partial save each step)
  Step 1: Role focus        → digital-marketing / tech / ai-crypto
  Step 2: Work preferences  → location, remote type, seniority, salary range
  Step 3: Upload resume     → PDF or DOCX (or skip, but nudged not to)
  Step 4: Top skills        → autocomplete tag input
  Step 5: Notifications     → weekly match email yes/no
    ↓
Candidate Dashboard
  ├── Profile completeness bar ("Add LinkedIn URL to reach 80%")
  ├── Resume section → Start Optimization CTA
  ├── Matched jobs teaser (placeholder in Phase 1)
  └── Application tracker
    ↓
Resume Optimization Flow (core Phase 1 revenue):
  Upload → AI parses → Candidate confirms extracted data
  → AI writes improved draft → Candidate reviews → Download
  → [Premium] Human coach review session (Tier 3: 1:1 with Kieran Hatorn)
    ↓
Checkout (Stripe one-off payment for Pro/Premium tier)
    ↓
── Phase 2 ──
    ↓
Jobs indexed from ATS sources (background ingestion)
    ↓
Weekly "Pulse Check" email → curated matches → candidate clicks/rates
    ↓
Feedback improves next week's matches
    ↓
Subscription billing (Smart Matching plan)
    ↓
── Phase 3 ──
    ↓
Public reverse job board (SEO, company pages, browsable)
```

---

## Where AI Helps

| Step | AI Role | Model | Sync or Async |
|---|---|---|---|
| Resume upload | Parse PDF/DOCX → structured JSON | GPT-4o | Async (queued) |
| Profile confirm | Candidate reviews extracted data | — | — |
| Resume rewrite | Generate improved bullets + summary | GPT-4o | Async (queued) |
| LinkedIn package | Headline + About + role summary | GPT-4o | Async (queued) |
| Cover letter | Draft cover letter per job | GPT-4o | Async (queued) |
| Job matching | Score jobs against profile (Phase 2) | Embeddings + rules | Async (batch) |
| Skill extraction | NER on job descriptions (Phase 4) | GPT-4o | Async (queued) |

**Rule:** AI never runs synchronously. User always sees a "Processing…" state while the queue works.
**Rule:** AI never generates from raw text alone. Human confirms structured input first, then AI writes.
**Rule:** Never market outcome guarantees (e.g. "increase interviews") — claims must be substantiable under Australian Consumer Law.

---

## Success Metrics by Component

> Define success as a chain: *value delivered → behaviour change → retention/revenue*

### Component 1 — AI Resume & LinkedIn Optimization
- **North star:** % of purchasers who report the output was used in a real application
- **Leading:** time-to-first-draft, edit acceptance rate, repeat purchase rate (Tier 1→2→3)
- **Guardrails:** refund rate, complaint rate, marketing claims that can't be substantiated

### Component 2 — Reverse Job Board
- **North star:** share of weekly active users who view ≥X jobs and save/apply to ≥1 job from seav.ai sources
- **Leading:** ingestion coverage (# target employers onboarded), freshness latency (median + p90), duplicate rate, broken-link rate
- **Guardrails:** takedown volume, crawl block rate, legal/support escalation rate

### Component 3 — Paid Weekly Smart Matching Subscription
- **North star:** interviews per active subscriber per month
- **Leading:** email open rate, click-to-save rate, match acceptance rate ("this is relevant"), time-to-first-application after subscribing
- **Guardrails:** churn in first 2–4 weeks, deliverability decline, mismatch disputes ("wasn't remote" / "wrong location")

**Meta-metric across all three:** candidate time saved per successful application.

---

## Database Tables by Phase

### Phase 1 tables (build now)

```
users
  id, name, email (nullable), password (nullable),
  google_id (nullable), linkedin_id (nullable), avatar_url (nullable),
  email_verified_at, remember_token, timestamps

candidate_profiles
  id, user_id (FK), role_focus (enum: digital-marketing/tech/ai-crypto),
  location, remote_preference (enum: remote/hybrid/onsite/flexible),
  seniority (enum: junior/mid/senior/lead/any),
  salary_min, salary_max, currency (default AUD),
  linkedin_url, headline, bio,
  onboarding_step (int 1-5), onboarding_completed_at,
  profile_completeness (int 0-100),
  timestamps

candidate_skills
  id, candidate_profile_id (FK), skill, source (manual/ai-extracted), timestamps

resumes
  id, user_id (FK), original_filename, stored_path, mime_type, file_size,
  status (enum: uploaded/parsing/parsed/failed),
  parsed_data (JSON — extracted structure from AI),
  parse_error (nullable text),
  is_primary (bool),
  timestamps

resume_versions
  id, resume_id (FK), version_type (enum: original/ai-draft/human-reviewed/final),
  content_json (structured resume data),
  generated_content (text — the actual AI-written text),
  pdf_path (nullable — generated PDF),
  docx_path (nullable — generated DOCX),
  created_by (enum: candidate/ai/coach),
  timestamps

service_orders
  id, user_id (FK), resume_id (FK nullable),
  tier (enum: basic/pro/premium),
  status (enum: pending/paid/in-progress/complete/refunded),
  stripe_payment_intent_id, stripe_session_id,
  amount_cents, currency,
  notes (text nullable),
  completed_at, timestamps

coaching_sessions
  id, service_order_id (FK), scheduled_at, duration_minutes,
  meeting_url (nullable), notes (text), status (enum: pending/confirmed/done/cancelled),
  timestamps

notifications
  (use Laravel's built-in notifications table)

privacy_consents
  id, user_id (FK), consent_type (enum: marketing/matching/data-sharing),
  granted (bool), ip_address, user_agent, timestamps
  — required for Australian Privacy Principles + ACMA spam compliance
```

### Phase 2 tables (job ingestion + matching)

```
companies
  id, name, slug, domain, logo_url, description,
  ats_type (enum: greenhouse/lever/ashby/workable/smartrecruiters/generic),
  career_page_url, is_active, last_crawled_at,
  scraping_allowed (bool — robots.txt / ToS check result),
  opt_out_requested_at (nullable), timestamps

job_listings (already exists — extend it)
  + company_id (FK to companies)
  + skills_extracted (JSON)
  + seniority_extracted (enum)
  + benefits_extracted (JSON)
  + content_hash (for dedupe)
  + ats_job_id (for dedupe)
  + canonical_url (source of truth URL)
  + source_publish_date (when employer posted — distinct from crawl date)
  + last_seen_at (last successful crawl that found this job)
  + culture_signals (JSON — candidate-rated attributes, Phase 2+)

job_skills
  id, job_listing_id (FK), skill, is_required (bool)

subscriptions
  id, user_id (FK), plan (enum: monthly/annual),
  status (enum: active/paused/cancelled),
  stripe_subscription_id, stripe_customer_id,
  current_period_start, current_period_end,
  cancelled_at, timestamps

match_batches
  id, run_at, candidate_count, job_count, status, timestamps

match_recommendations
  id, match_batch_id (FK), user_id (FK), job_listing_id (FK),
  score (decimal 0-1),
  score_breakdown (JSON — layer1/layer2/layer3/layer4 scores),
  score_label_breakdown (JSON — human-readable "why" per layer),
  status (enum: pending/sent/seen/saved/applied/dismissed),
  timestamps

match_feedback
  id, match_recommendation_id (FK), user_id (FK),
  signal (enum: relevant/not-relevant/already-seen/wrong-location/wrong-remote/too-senior/too-junior),
  created_at

saved_jobs
  id, user_id (FK), job_listing_id (FK), notes (nullable), timestamps

job_applications
  id, user_id (FK), job_listing_id (FK nullable),
  company_name, job_title (for manually tracked jobs),
  status (enum: applied/phone-screen/interview/offer/rejected/withdrawn),
  applied_at, notes (text), timestamps
```

### Phase 3 tables (public board + SEO)

```
company_sources
  id, company_id (FK), source_type, source_url, connector_class,
  is_active, last_run_at, last_success_at, failure_count,
  last_error (text nullable), timestamps

crawl_runs
  id, company_source_id (FK), started_at, finished_at,
  jobs_found, jobs_new, jobs_updated, jobs_closed,
  freshness_latency_minutes (median minutes from source_publish_date to crawl),
  status (enum: running/success/failed), error_log (text), timestamps

takedown_requests
  id, company_id (FK nullable), job_listing_id (FK nullable),
  requester_email, reason, status (enum: pending/actioned/rejected),
  actioned_at, timestamps
```

---

## Phase 1 — MVP Build Tasks

> **Goal:** Candidates can register, complete profile, upload resume, get AI optimization, pay for Pro/Premium.

### 1.0 Foundation & Compliance Setup

- [ ] Set up privacy policy page covering Australian Privacy Principles (APP) — data collected, how used, how stored
- [ ] Set up terms of service page
- [ ] Add `privacy_consents` table migration + model
- [ ] Record marketing consent at registration (checkbox + timestamp, not pre-ticked — ACMA requirement)
- [ ] Add `meta[name="csrf-token"]` to all layouts (already done in admin — verify public layout too)
- [ ] Configure `.env` with all required vars (see env section below)
- [ ] Install Redis + configure Laravel Horizon for queue management
- [ ] Install Laravel Debugbar (dev only)

### 1.1 Auth & Google OAuth

- [ ] `composer require laravel/breeze` → `php artisan breeze:install blade`
- [ ] `composer require laravel/socialite`
- [ ] Add `google_id`, `linkedin_id`, `avatar_url` columns to users migration
- [ ] Make `password` nullable in users migration (social login users have no password)
- [ ] Add Google credentials to `.env` (`GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`)
- [ ] Create `SocialAuthController` with `redirectToGoogle()` and `handleGoogleCallback()`
- [ ] Logic: find by `google_id` → find by email → create new user
- [ ] Add "Continue with Google" button to Breeze login + register views
- [ ] Restyle Breeze auth views to match seav.ai brand (blue, Inter font)
- [ ] Email verification middleware on protected routes
- [ ] Record `privacy_consents` row on registration (marketing = false by default)
- [ ] Test: register with email, register with Google, login both ways, forgot password

### 1.2 Candidate Profile & Onboarding

- [ ] Create `candidate_profiles` migration + model
- [ ] Create `candidate_skills` migration + model
- [ ] Auto-create empty `CandidateProfile` when user registers (observer or event)
- [ ] Build 5-step onboarding wizard:
  - Blade views: `onboarding/step-{1..5}.blade.php`
  - Each step: HTMX `hx-post` saves partial data → returns next step partial
  - Progress bar (Alpine tracks step number)
  - Back button navigates without data loss
- [ ] Redirect new users to `/onboarding` after register if not completed
- [ ] Allow skipping onboarding (but show banner on dashboard to complete it)
- [ ] `profile_completeness` calculated field — update on every profile save
- [ ] Step 5 (Notifications): weekly match email opt-in — save to `privacy_consents`, not just a profile flag

### 1.3 Resume Upload & Parsing

- [ ] `composer require smalot/pdfparser phpoffice/phpword`
- [ ] Create `resumes` + `resume_versions` migrations + models
- [ ] Build upload UI: drag-and-drop (Alpine) + fallback file input
- [ ] Store file: `Storage::disk('local')->put('resumes/'.$user->id.'/'.$filename, $file)`
- [ ] Secure download route (auth middleware, stream file — no direct URL)
- [ ] Dispatch `ParseResumeJob` after upload — updates `status` to `parsing`
- [ ] `ParseResumeJob`:
  - Extract text from PDF (`smalot/pdfparser`) or DOCX (`phpoffice/phpword`)
  - Send text to OpenAI with extraction prompt (see prompt spec below)
  - Store result in `resumes.parsed_data` as JSON
  - Update `status` to `parsed` (or `failed`)
  - Fire event → candidate sees "Your resume has been parsed!"
- [ ] HTMX polling on upload page: `hx-get="/resumes/{id}/status" hx-trigger="every 3s"` until parsed
- [ ] Show parsed data review form: work history, skills, education, contact details — all editable
- [ ] Save confirmed data to `candidate_profile` tables on submit
- [ ] Never expose storage path directly — always stream through authenticated route

### 1.4 AI Resume Writer

- [ ] `composer require openai-php/laravel`
- [ ] Add `OPENAI_API_KEY` to `.env`
- [ ] Dispatch `GenerateResumeJob` after candidate confirms parsed data
- [ ] `GenerateResumeJob`:
  - Takes confirmed structured profile data
  - Sends to OpenAI with rewriting prompt (see prompt spec below)
  - Stores result in `resume_versions` (type: `ai-draft`)
- [ ] Build AI draft review UI:
  - Show original vs AI version side-by-side
  - "Accept", "Regenerate", "Edit manually" actions
  - Save accepted version as new `resume_version` (type: `final`)
- [ ] LinkedIn package generation (same queue job, separate prompts):
  - Headline (220 chars max)
  - About section (2000 chars max)
  - Role-specific summary
- [ ] Cover letter generation (per-job, Phase 1 basic version)
- [ ] PDF export: `composer require barryvdh/laravel-dompdf`
- [ ] DOCX export: use `phpoffice/phpword` to generate
- [ ] Do NOT display output quality claims like "increase interview rate by X%" — no guaranteed outcome marketing

### 1.5 Service Tiers & Stripe Checkout

- [ ] `composer require stripe/stripe-php`
- [ ] Create `service_orders` migration + model
- [ ] Pricing page: Basic (free) / Pro ($49) / Premium ($149)
- [ ] Stripe Checkout Session for Pro + Premium (one-off payments)
- [ ] Webhook handler: `stripe/webhooks` route → update `service_orders.status` on payment success
- [ ] Basic tier: unlimited AI parses, 1 AI draft, download PDF
- [ ] Pro tier: unlimited revisions, LinkedIn package, cover letter, DOCX download
- [ ] Premium tier: everything + coaching session booking (1:1 with Kieran Hatorn)
- [ ] `coaching_sessions` table + basic scheduling UI (date/time picker + confirmation email)
- [ ] Invoice email on payment success

### 1.6 Candidate Dashboard

- [ ] `/dashboard` — main candidate home
- [ ] Profile completeness bar (HTMX lazy load the percentage)
- [ ] Resume card: current resume status + actions
- [ ] Matched jobs teaser: 3 placeholder cards ("Complete your profile to unlock matches")
- [ ] Application tracker: manually log applications with status
- [ ] Quick stats: resumes optimised, applications tracked, profile score

### 1.7 Settings & Account

- [ ] `/settings/profile` — edit name, location, preferences
- [ ] `/settings/security` — change password (hidden if Google-only user)
- [ ] `/settings/notifications` — email preferences (update `privacy_consents`)
- [ ] `/settings/billing` — view orders, download invoices
- [ ] Delete account flow (GDPR/APP — queues a data deletion job, confirms via email)

---

## Phase 2 — Job Ingestion + Smart Matching Subscription

> **Goal:** Index real jobs from ATS sources. Ship weekly paid matching subscription *before* the full public job board.

### 2.0 Scraping Policy & Legal Foundation

- [ ] Define and document scraping policy: robots.txt hierarchy, rate limits, politeness controls
- [ ] Prefer ATS-native JSON endpoints (Greenhouse, Lever, Ashby, Workable) — fall back to HTML scraping only
- [ ] Record `scraping_allowed` per company (robots.txt + ToS review result)
- [ ] Build takedown/opt-out workflow: company emails hello@seav.ai → admin action within 48h → job removed
- [ ] Store `takedown_requests` table (Phase 3 table — create now for operational use)
- [ ] Legal review: Australian screen scraping risk (contract/ToS framing, not copyright) — document stance

### 2.1 Job Ingestion Pipeline

- [ ] `companies` table + admin UI to manage sources
- [ ] Connector interface: `interface AtsConnector { public function fetch(): Collection; }`
- [ ] Build connectors (ATS-native JSON first, HTML scraper as fallback):
  - `GreenhouseConnector` (JSON API: `boards.greenhouse.io/{company}/jobs`)
  - `LeverConnector` (JSON API: `api.lever.co/v0/postings/{company}`)
  - `AshbyConnector`
  - `WorkableConnector`
  - `GenericStructuredDataConnector` (schema.org JobPosting)
  - `GenericHtmlScraperConnector` (fallback — lowest priority)
- [ ] `CrawlCompanyJob` — dispatched by scheduler daily per company
- [ ] Detect ATS type from company career URL before choosing connector
- [ ] Normalise to unified `job_listings` schema
- [ ] **Job identity system** (treat as first-class, not a backend detail):
  - Canonical URL per job (`canonical_url`)
  - ATS job ID for deduplication (`ats_job_id`)
  - Content hash to detect edits vs reposts (`content_hash`)
  - `source_publish_date` — when employer posted (separate from crawl timestamp)
  - `last_seen_at` — updated each crawl; missing = job likely closed
- [ ] Mark missing jobs as `closed` automatically after N missed crawls
- [ ] Incremental refresh with backoff and politeness controls (rate limiting per domain)
- [ ] `crawl_runs` logging including `freshness_latency_minutes` (measure median + p90)
- [ ] Admin connector health dashboard

### 2.2 Matching Engine (4-layer scoring)

- [ ] `subscriptions` table + Stripe recurring billing
- [ ] Matching job `RunMatchBatchJob` — weekly scheduler
- [ ] **Layer 1 — Hard constraints** (filter out): location radius, remote type, seniority band, salary floor
- [ ] **Layer 2 — Skills similarity**: taxonomy match + embedding similarity (candidate-controlled weighting)
- [ ] **Layer 3 — Preference signals**: industry, company size, tooling stack, learning budget
- [ ] **Layer 4 — Culture enrichment**: candidate-rated attributes collected over time (starts sparse; grows with feedback)
- [ ] Store `score_breakdown` JSON with per-layer scores AND `score_label_breakdown` (human-readable "why")
- [ ] "Why this matches you" — surface score_label_breakdown in UI (algorithm transparency)
- [ ] Candidate controls: ability to adjust weightings per layer
- [ ] Feedback actions: relevant / not-relevant / already-seen / wrong-location / wrong-remote / too-senior / too-junior
- [ ] Feedback feeds Layer 3 + Layer 4 weighting for next batch
- [ ] Label inferred signals vs declared facts in UI (e.g. "Remote eligibility: inferred from job text" vs "Declared by employer")

### 2.3 Weekly Pulse Check Email

- [ ] `PulseCheckMailable` — top N matches per subscriber
- [ ] Blade email template — clean, mobile-friendly, shows top 5–8 jobs
- [ ] "View all matches" → `/matches` in app
- [ ] One-click feedback links in email (no login needed for basic signals)
- [ ] **Unsubscribe link on every email** — functional within 5 working days (ACMA requirement)
- [ ] Check `privacy_consents` before sending — never email users without active consent
- [ ] Deliverability: send via SMTP2Go, track opens via webhook
- [ ] Track: open rate, click-to-save rate, match acceptance rate, time-to-first-application

---

## Phase 3 — Public Reverse Job Board

> **Goal:** SEO-indexed public job pages, company pages, category/location pages. Ingestion and scoring must be stable first.

### 3.0 Freshness Guarantee

- [ ] Define measurable freshness SLA: target median ingestion latency < 6 hours from source_publish_date
- [ ] Surface freshness timestamp on every job: "Fetched from company.com · Posted X hours ago · Checked Y mins ago"
- [ ] Alert when ingestion latency degrades past p90 threshold

### 3.1 Public Job Board

- [ ] `/jobs` — filterable job listing (public, no login)
- [ ] `/jobs/{slug}` — job detail page (server-rendered, SEO)
- [ ] `/companies/{slug}` — company page
- [ ] `/jobs/category/{category}` — category landing (SEO)
- [ ] `/jobs/location/{location}` — location landing (SEO)
- [ ] `/jobs/remote` — remote jobs landing (SEO)
- [ ] Sitemap generation (`spatie/laravel-sitemap`)
- [ ] JSON-LD structured data on job pages (schema.org JobPosting)
- [ ] "Report issue / outdated" button → `takedown_requests` table
- [ ] Always link to original employer apply URL — never intercept the application

### 3.2 Provenance & Trust UI

- [ ] Labels on every data field: `Declared by employer` / `Detected from posting` / `Inferred by Seav.ai`
- [ ] Source freshness indicator (posted_at + last crawled timestamp)
- [ ] Original apply URL (always link direct to employer)
- [ ] Company takedown/opt-out workflow (surfaced publicly: "Is this your company? Request removal")
- [ ] `scraping_allowed` visible in admin — never crawl a company that has opted out

---

## Phase 4 — Intelligence & Refinement

- [ ] Skill extraction improvement (NER on job descriptions)
- [ ] Recommendation tuning based on apply/interview outcome data
- [ ] A/B tests on match email subject lines
- [ ] Richer candidate dashboard analytics
- [ ] Inferred vs declared signal separation in match explanations
- [ ] Algorithm transparency disclosure page (OAIC APP guideline — automated decisions, deadline Dec 2026)
- [ ] Interview prep module (upsell)
- [ ] Culture signal accuracy improvement (candidate-rated vs employer-declared comparison)

---

## OpenAI Prompt Specs

### Resume Parsing Prompt

```
System:
You are a resume parser. Extract structured data from the resume text below.
Return ONLY valid JSON matching this schema exactly:
{
  "contact": { "name", "email", "phone", "location", "linkedin_url" },
  "summary": "string or null",
  "work_history": [{ "company", "title", "start_date", "end_date", "is_current", "description" }],
  "education": [{ "institution", "degree", "field", "start_year", "end_year" }],
  "skills": ["string"],
  "certifications": ["string"],
  "languages": ["string"]
}
Dates should be "YYYY-MM" format where possible, or "YYYY" if only year is known.
If a field cannot be determined, use null. Do not hallucinate or invent data.

User:
[resume plain text here]
```

### Resume Rewriting Prompt

```
System:
You are an expert resume writer for the Australian job market.
You will be given a candidate's confirmed work history and profile.
Rewrite their resume with stronger, more impactful bullet points.
Rules:
- Use action verbs (Led, Built, Grew, Reduced, Shipped, etc.)
- Include quantified results where the data supports it — never invent numbers
- Tailor language to the candidate's target role focus: {role_focus}
- Australian English spelling
- Do not add skills, companies, or roles that are not in the input data
- Return JSON with the same schema as the input, with updated "description" fields only

User:
{confirmed_profile_json}
```

---

## Key Technical Patterns

### HTMX Partial Pattern (already built, extend this)
- Sidebar nav → `HX-Target: main-content` → `$this->adminPage('page', $data)` trait handles routing
- In-page swaps → specific target IDs → controller handles manually
- See `app/Http/Traits/ResolvesAdminView.php`

### Async AI Job Pattern
```php
// Controller — immediately return "processing" state
$resume->update(['status' => 'parsing']);
ParseResumeJob::dispatch($resume);
return view('resumes.partials.processing-state', compact('resume'));

// HTMX polls status every 3s
// <div hx-get="/resumes/{id}/status" hx-trigger="every 3s" hx-swap="outerHTML">

// Job — does the work in background
class ParseResumeJob implements ShouldQueue {
    public function handle() {
        // extract text, call OpenAI, save result
        $this->resume->update(['status' => 'parsed', 'parsed_data' => $result]);
    }
}
```

### File Security Pattern
```php
// Never expose storage path directly
// Always stream through authenticated route
Route::get('/resumes/{resume}/download', function (Resume $resume) {
    abort_if($resume->user_id !== auth()->id(), 403);
    return Storage::download($resume->stored_path, $resume->original_filename);
})->middleware('auth');
```

### Onboarding Partial Save Pattern
```php
// Each wizard step POSTs to its own route
// Returns the NEXT step as a Blade partial
Route::post('/onboarding/step/{step}', [OnboardingController::class, 'save']);

// hx-post="/onboarding/step/1"
// hx-target="#onboarding-body"
// hx-swap="innerHTML"
```

### Job Identity / Dedupe Pattern
```php
// Prefer ATS job ID; fall back to content hash
$existing = JobListing::where('ats_job_id', $atsId)
    ->orWhere('content_hash', $hash)
    ->first();

if ($existing) {
    $existing->update(['last_seen_at' => now(), ...]);
} else {
    JobListing::create([...]);
}
```

---

## Compliance Checklist (Australian-specific)

| Requirement | Source | Phase | Status |
|---|---|---|---|
| Privacy policy covering APP | Australian Privacy Principles (OAIC) | Phase 1 | - [ ] |
| Consent recorded at registration (not pre-ticked) | APP + ACMA | Phase 1 | - [ ] |
| Unsubscribe on every marketing email, honoured ≤5 working days | ACMA Spam Act | Phase 2 | - [ ] |
| No misleading outcome claims (e.g. "guaranteed interviews") | Australian Consumer Law (ACCC) | Phase 1 | - [ ] |
| Notifiable Data Breach response plan | NDB Scheme (OAIC) | Phase 1 | - [ ] |
| Takedown workflow for companies (scraping ToS risk) | Screen scraping legal risk | Phase 2 | - [ ] |
| Algorithm transparency disclosure (automated decisions) | APP guideline update (Dec 2026) | Phase 4 | - [ ] |
| robots.txt / ToS check before crawling each domain | Legal + ethical | Phase 2 | - [ ] |

---

## Environment Variables Needed

```env
# App
APP_NAME="Seav.ai"
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_DATABASE=seavai
DB_USERNAME=root
DB_PASSWORD=

# Queue (switch from sync to redis before AI features)
QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379

# OpenAI
OPENAI_API_KEY=sk-...
OPENAI_ORGANIZATION=  # optional

# Google OAuth
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"

# Stripe
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...

# Email (SMTP2Go)
MAIL_MAILER=smtp
MAIL_HOST=mail.smtp2go.com
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@seav.ai
MAIL_FROM_NAME="Seav.ai"

# File Storage (local now)
FILESYSTEM_DISK=local

# File Storage (Wasabi — swap to this later, no code changes needed)
# FILESYSTEM_DISK=s3
# AWS_ACCESS_KEY_ID=
# AWS_SECRET_ACCESS_KEY=
# AWS_DEFAULT_REGION=ap-southeast-2
# AWS_BUCKET=seavai-resumes
# AWS_ENDPOINT=https://s3.ap-southeast-2.wasabisys.com
# AWS_USE_PATH_STYLE_ENDPOINT=true
```

---

## First Session — Start Here

```bash
cd /Applications/XAMPP/xamppfiles/htdocs/projects3/bigwavedigital/seavai/laravel

# 1. Install Breeze (auth scaffolding)
composer require laravel/breeze --dev
php artisan breeze:install blade

# 2. Install Socialite (Google OAuth)
composer require laravel/socialite

# 3. Install OpenAI
composer require openai-php/laravel

# 4. Install PDF/DOCX parsers
composer require smalot/pdfparser
composer require phpoffice/phpword

# 5. Install PDF generator
composer require barryvdh/laravel-dompdf

# 6. Run fresh migrations (Breeze adds new ones)
php artisan migrate:fresh --seed

# 7. Start server
php artisan serve --port=8080
```

Then build in this order:
1. `users` table update (nullable password, google_id, avatar_url) + `privacy_consents` table
2. Privacy policy + terms pages
3. Google OAuth flow (`SocialAuthController`)
4. Restyle Breeze auth views to match seav.ai brand
5. `candidate_profiles` + `candidate_skills` tables
6. Onboarding wizard (5 steps)

---

## Packages Summary

```bash
# Auth
composer require laravel/breeze --dev
composer require laravel/socialite

# AI
composer require openai-php/laravel

# File processing
composer require smalot/pdfparser
composer require phpoffice/phpword
composer require barryvdh/laravel-dompdf

# Payments
composer require stripe/stripe-php

# SEO (Phase 3)
composer require spatie/laravel-sitemap

# Dev tools
composer require barryvdh/laravel-debugbar --dev
```
