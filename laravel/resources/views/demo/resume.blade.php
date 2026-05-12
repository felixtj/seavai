@extends('layouts.candidate-app')
@section('title', 'My Resume — Seav.ai')
@section('page-title', 'My Resume')
@section('page-meta', 'View, optimise and download your resume')
@section('content')

<div x-data="{
    version: 'original',
    template: 'classic',
    templates: [
        { id: 'classic', name: 'Classic', note: 'Formal' },
        { id: 'modern', name: 'Modern', note: 'Polished' },
        { id: 'compact', name: 'Compact', note: 'ATS' },
    ],
    downloading: false,
    aiProcessing: false,
    aiDone: false,
    templateLabel() {
        for (const item of this.templates) {
            if (item.id === this.template) return item.name;
        }

        return 'Classic';
    },
    startAi() {
        this.aiProcessing = true;
        setTimeout(() => { this.aiProcessing = false; this.aiDone = true; this.version = 'ai'; }, 3000);
    }
}">

<div class="page-header">
    <h1>My Resume</h1>
    <p>View, optimise and download your resume</p>
</div>

<div style="display:grid;grid-template-columns:280px 1fr;gap:24px;align-items:start;">

    <!-- LEFT — Controls -->
    <div style="display:flex;flex-direction:column;gap:16px;position:sticky;top:80px;">

        <!-- Version toggle -->
        <div class="card card-pad">
            <div style="font-size:0.72rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px;">Version</div>
            <div style="display:flex;flex-direction:column;gap:6px;">
                <button @click="version='original'" :style="version==='original' ? 'background:#EFF6FF;border-color:#2563EB;color:#1E40AF;' : 'background:white;border-color:#E2E8F0;color:#64748B;'" style="padding:10px 14px;border:2px solid;border-radius:9px;font-size:0.82rem;font-weight:600;cursor:pointer;text-align:left;font-family:inherit;transition:all .15s;display:flex;align-items:center;gap:8px;">
                    <i class="fa-solid fa-file" style="width:14px;"></i> Original Upload
                </button>
                <button @click="version='ai'" :disabled="!aiDone" :style="version==='ai' && aiDone ? 'background:#EFF6FF;border-color:#2563EB;color:#1E40AF;' : aiDone ? 'background:white;border-color:#E2E8F0;color:#64748B;' : 'background:#F8FAFC;border-color:#E2E8F0;color:#CBD5E1;'" style="padding:10px 14px;border:2px solid;border-radius:9px;font-size:0.82rem;font-weight:600;cursor:pointer;text-align:left;font-family:inherit;transition:all .15s;display:flex;align-items:center;gap:8px;">
                    <i class="fa-solid fa-wand-magic-sparkles" style="width:14px;"></i>
                    AI Optimised
                    <span x-show="!aiDone" style="margin-left:auto;font-size:0.65rem;background:#FEF3C7;color:#92400E;padding:2px 6px;border-radius:4px;font-weight:700;">NEW</span>
                </button>
            </div>
        </div>

        <!-- AI Optimise CTA -->
        <div class="card card-pad" x-show="!aiDone && !aiProcessing">
            <div style="font-size:1.5rem;margin-bottom:8px;">✨</div>
            <div style="font-weight:700;font-size:0.875rem;margin-bottom:6px;">AI Resume Optimiser</div>
            <div style="font-size:0.75rem;color:#64748B;margin-bottom:14px;line-height:1.5;">Rewrites your resume with stronger bullets, better language, and ATS-optimised keywords for the Australian market.</div>
            <button @click="startAi()" class="btn btn-primary" style="width:100%;justify-content:center;font-size:0.8rem;">
                <i class="fa-solid fa-wand-magic-sparkles"></i> Optimise Now
            </button>
            <div style="text-align:center;margin-top:8px;font-size:0.7rem;color:#94A3B8;">~60 seconds · Free with Basic plan</div>
        </div>

        <!-- Processing state -->
        <div class="card card-pad" x-show="aiProcessing" style="text-align:center;">
            <div style="font-size:1.5rem;margin-bottom:10px;">⚙️</div>
            <div style="font-weight:700;font-size:0.875rem;margin-bottom:6px;">AI is working…</div>
            <div style="font-size:0.75rem;color:#64748B;margin-bottom:14px;">Analysing your experience and generating improvements</div>
            <div style="height:4px;background:#E2E8F0;border-radius:999px;overflow:hidden;">
                <div style="height:100%;background:#2563EB;border-radius:999px;animation:progress-anim 3s linear forwards;"></div>
            </div>
        </div>

        <!-- AI done — download panel -->
        <div class="card card-pad" x-show="aiDone">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <span style="font-size:1rem;">🎉</span>
                <div style="font-weight:700;font-size:0.875rem;color:#065F46;">Optimised!</div>
            </div>
            <div style="font-size:0.75rem;color:#64748B;margin-bottom:14px;">Your AI-improved resume is ready. Review the changes on the right.</div>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <button class="btn btn-primary btn-sm" style="justify-content:center;"><i class="fa-solid fa-download"></i> Download PDF</button>
                <button class="btn btn-outline btn-sm" style="justify-content:center;"><i class="fa-solid fa-file-word"></i> Download DOCX</button>
            </div>
        </div>

        <!-- CV templates -->
        <div class="card card-pad">
            <div style="font-size:0.72rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">CV Templates</div>
            <div style="font-size:0.75rem;color:#64748B;line-height:1.5;margin-bottom:12px;">Choose a layout and preview it instantly.</div>
            <div class="template-picker">
                <template x-for="item in templates" :key="item.id">
                    <button type="button" class="template-option" :class="{ 'active': template === item.id }" :aria-pressed="template === item.id" @click="template = item.id">
                        <span class="template-thumb" :class="'template-thumb-' + item.id">
                            <span></span><span></span><span></span>
                        </span>
                        <span>
                            <strong x-text="item.name"></strong>
                            <small x-text="item.note"></small>
                        </span>
                    </button>
                </template>
            </div>
        </div>

        <!-- AI Suggestions (shown when viewing AI version) -->
        <div class="card card-pad" x-show="version === 'ai' && aiDone">
            <div style="font-size:0.72rem;font-weight:700;color:#94A3B8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px;">AI Changes Made</div>
            <div style="display:flex;flex-direction:column;gap:8px;">
                @foreach(['Strengthened 6 bullet points','Added quantified results','Improved headline clarity','ATS keyword optimisation','Removed weak filler phrases'] as $change)
                <div style="display:flex;align-items:center;gap:8px;font-size:0.75rem;color:#065F46;">
                    <i class="fa-solid fa-circle-check" style="flex-shrink:0;"></i> {{ $change }}
                </div>
                @endforeach
            </div>
        </div>

        <!-- LinkedIn package -->
        <div class="card card-pad" style="background:linear-gradient(135deg,#F5F3FF,#EFF6FF);">
            <div style="font-size:0.72rem;font-weight:700;color:#5B21B6;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">Pro Feature</div>
            <div style="font-weight:700;font-size:0.875rem;margin-bottom:6px;">LinkedIn Package</div>
            <div style="font-size:0.75rem;color:#64748B;margin-bottom:12px;">Headline, About section, and role summary — all AI-optimised for your target roles.</div>
            <button class="btn btn-sm" style="background:#7C3AED;color:white;border:none;justify-content:center;width:100%;">Upgrade to Pro · $49</button>
        </div>

    </div>

    <!-- RIGHT — Document viewer -->
    <div>
        <!-- Toolbar -->
        <div style="background:white;border:1px solid #E2E8F0;border-radius:12px 12px 0 0;padding:10px 16px;display:flex;align-items:center;gap:10px;border-bottom:none;">
            <span style="font-size:0.75rem;color:#64748B;font-weight:500;">
                <i class="fa-solid fa-file-pdf" style="color:#EF4444;"></i>
                Sarah_Chen_Resume_2026<span x-show="version==='ai'">_AI_Optimised</span>_<span x-text="templateLabel()"></span>.pdf
            </span>
            <div style="margin-left:auto;display:flex;gap:6px;">
                <button class="btn btn-ghost btn-sm"><i class="fa-solid fa-magnifying-glass-minus"></i></button>
                <span style="font-size:0.75rem;color:#64748B;align-self:center;padding:0 4px;">100%</span>
                <button class="btn btn-ghost btn-sm"><i class="fa-solid fa-magnifying-glass-plus"></i></button>
                <div style="width:1px;background:#E2E8F0;margin:0 4px;"></div>
                <button class="btn btn-outline btn-sm"><i class="fa-solid fa-download"></i> Download</button>
            </div>
        </div>

        <!-- Paper document -->
        <div class="resume-stage">
            <div class="resume-paper" :class="'resume-template-' + template">

                <!-- AI badge -->
                <div x-show="version==='ai'" class="resume-ai-badge">✨ AI Optimised</div>

                <!-- Header -->
                <div class="resume-header">
                    <h1 class="resume-name">Sarah Chen</h1>
                    <div class="resume-title" x-show="version==='original'">
                        Digital Marketing Manager
                    </div>
                    <div class="resume-title" x-show="version==='ai'">
                        <strong>Senior Digital Marketing Leader</strong> | Data-Driven Growth & Multi-Channel Strategy
                    </div>
                    <div class="resume-contact">
                        Sydney, NSW · sarah.chen@email.com · 0412 345 678 · linkedin.com/in/sarahchen
                    </div>
                </div>

                <!-- Summary -->
                <div class="resume-section">
                    <h2 class="resume-section-title">Professional Summary</h2>
                    <p class="resume-text" x-show="version==='original'">
                        Experienced digital marketing professional with 7+ years in fast-growing tech companies. Strong background in SEO, paid media, and marketing analytics. Proven track record of driving growth through data-driven campaigns.
                    </p>
                    <p class="resume-text" x-show="version==='ai'">
                        Results-driven Digital Marketing Leader with 7+ years scaling growth at high-velocity tech companies across Australia and APAC. Specialising in full-funnel performance marketing, I've delivered <strong>$12M+ in attributed pipeline</strong> through data-driven SEO, paid media, and marketing automation strategies. Known for building and mentoring high-performing teams and turning complex analytics into actionable growth levers.
                    </p>
                </div>

                <!-- Experience -->
                <div class="resume-section">
                    <h2 class="resume-section-title">Experience</h2>

                    @foreach([
                        [
                            'title_orig' => 'Digital Marketing Manager',
                            'title_ai'   => 'Digital Marketing Manager',
                            'company'    => 'HubSpot Australia',
                            'period'     => 'Mar 2022 – Present',
                            'bullets_orig' => [
                                'Managed SEO and content strategy for the APAC region',
                                'Ran paid search and social campaigns with a $500k annual budget',
                                'Worked with sales team to improve lead quality',
                                'Reported on campaign performance weekly to leadership',
                            ],
                            'bullets_ai' => [
                                'Scaled APAC organic traffic by <strong>142%</strong> in 18 months through a comprehensive SEO overhaul, content refresh, and technical audit programme',
                                'Managed $500k paid media budget across Google, LinkedIn and Meta, achieving a <strong>3.2x blended ROAS</strong> and reducing CPA by 28% YoY',
                                'Partnered with Sales to redesign lead scoring model, improving MQL-to-SQL conversion rate from 18% to <strong>31%</strong>',
                                'Built executive reporting dashboard (Looker + GA4) enabling real-time performance visibility across 8 marketing channels',
                            ],
                        ],
                        [
                            'title_orig' => 'Senior Marketing Specialist',
                            'title_ai'   => 'Senior Performance Marketing Specialist',
                            'company'    => 'Atlassian',
                            'period'     => 'Jun 2019 – Feb 2022',
                            'bullets_orig' => [
                                'Ran email marketing campaigns for SMB and enterprise segments',
                                'Supported product launches with digital marketing campaigns',
                                'Managed marketing automation tools including Marketo',
                            ],
                            'bullets_ai' => [
                                'Executed 120+ email campaigns annually to SMB and enterprise segments, achieving average open rates of <strong>34%</strong> (industry avg: 21%)',
                                'Led digital go-to-market for 3 major product launches, contributing to <strong>$8M ARR</strong> in first-year revenue',
                                'Owned Marketo instance for 40k+ contact database — built 15 automated nurture sequences reducing manual effort by 60%',
                            ],
                        ],
                    ] as $role)
                    <div class="resume-role">
                        <div class="resume-role-head">
                            <strong class="resume-role-title" x-show="version==='original'">{{ $role['title_orig'] }}</strong>
                            <strong class="resume-role-title" x-show="version==='ai'">{{ $role['title_ai'] }}</strong>
                            <span class="resume-period">{{ $role['period'] }}</span>
                        </div>
                        <div class="resume-company">{{ $role['company'] }}</div>
                        <ul class="resume-list" x-show="version==='original'">
                            @foreach($role['bullets_orig'] as $b)
                            <li class="resume-list-item">{{ $b }}</li>
                            @endforeach
                        </ul>
                        <ul class="resume-list" x-show="version==='ai'">
                            @foreach($role['bullets_ai'] as $b)
                            <li class="resume-list-item">{!! $b !!}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>

                <!-- Skills -->
                <div class="resume-section">
                    <h2 class="resume-section-title">Skills</h2>
                    <div class="resume-skills">
                        <strong>Marketing:</strong> SEO/SEM, Paid Social, Email Marketing, Content Strategy, Marketing Automation, CRO<br>
                        <strong>Tools:</strong> Google Analytics 4, Marketo, HubSpot, Salesforce, Looker, Ahrefs, Semrush<br>
                        <strong>Technical:</strong> SQL (intermediate), HTML/CSS (basic), Python (basic)
                    </div>
                </div>

                <!-- Education -->
                <div class="resume-section">
                    <h2 class="resume-section-title">Education</h2>
                    <div class="resume-education">
                        <div>
                            <div class="resume-education-title">Bachelor of Commerce (Marketing)</div>
                            <div class="resume-company">University of Sydney</div>
                        </div>
                        <span class="resume-period">2015 – 2018</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
</div>

<style>
@keyframes progress-anim { from { width: 0% } to { width: 100% } }

.template-picker {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.template-option {
    align-items: center;
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    color: #334155;
    cursor: pointer;
    display: flex;
    gap: 10px;
    padding: 9px;
    text-align: left;
    transition: border-color .15s, box-shadow .15s, background .15s;
    width: 100%;
}

.template-option:hover,
.template-option.active {
    background: #F8FAFC;
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37,99,235,.08);
}

.template-option strong {
    display: block;
    font-size: 0.78rem;
    font-weight: 700;
    line-height: 1.2;
}

.template-option small {
    color: #64748B;
    display: block;
    font-size: 0.68rem;
    margin-top: 2px;
}

.template-thumb {
    background: #FFFFFF;
    border: 1px solid #CBD5E1;
    border-radius: 4px;
    display: grid;
    flex-shrink: 0;
    gap: 3px;
    height: 42px;
    padding: 7px;
    width: 34px;
}

.template-thumb span {
    background: #94A3B8;
    border-radius: 999px;
    display: block;
    height: 3px;
}

.template-thumb span:first-child {
    background: #0F172A;
    height: 4px;
    width: 80%;
}

.template-thumb-classic span { margin: 0 auto; width: 85%; }
.template-thumb-modern { border-left: 5px solid #0F766E; }
.template-thumb-modern span { width: 100%; }
.template-thumb-compact { gap: 2px; padding: 6px; }
.template-thumb-compact span { height: 2px; width: 100%; }

.resume-stage {
    background: #E2E8F0;
    border-radius: 0 0 12px 12px;
    min-height: 600px;
    overflow: auto;
    padding: 24px;
}

.resume-paper {
    background: #FFFFFF;
    border-radius: 3px;
    box-shadow: 0 4px 24px rgba(0,0,0,.15);
    color: #1F2937;
    margin: 0 auto;
    max-width: 700px;
    min-height: 900px;
    padding: 52px 60px;
    position: relative;
    transition: padding .18s, border-color .18s;
}

.resume-ai-badge {
    background: #EFF6FF;
    border: 1px solid #BFDBFE;
    border-radius: 6px;
    color: #1E40AF;
    font-family: 'Inter', sans-serif;
    font-size: 0.65rem;
    font-weight: 700;
    padding: 4px 10px;
    position: absolute;
    right: 16px;
    top: 16px;
}

.resume-header {
    border-bottom: 2px solid #0F172A;
    margin-bottom: 28px;
    padding-bottom: 20px;
    text-align: center;
}

.resume-name {
    font-family: Georgia, 'Times New Roman', serif;
    font-size: 1.8rem;
    font-weight: 700;
    letter-spacing: 0;
    margin: 0 0 4px;
}

.resume-title {
    color: #374151;
    font-size: 0.88rem;
    margin-bottom: 6px;
}

.resume-contact,
.resume-period,
.resume-company,
.resume-section-title {
    font-family: 'Inter', sans-serif;
}

.resume-contact {
    color: #64748B;
    font-size: 0.78rem;
}

.resume-section {
    margin-bottom: 22px;
}

.resume-section:last-child {
    margin-bottom: 0;
}

.resume-section-title {
    color: #374151;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0;
    margin-bottom: 10px;
    text-transform: uppercase;
}

.resume-text {
    color: #374151;
    font-size: 0.85rem;
    line-height: 1.65;
    margin: 0;
}

.resume-role {
    margin-bottom: 18px;
}

.resume-role:last-child {
    margin-bottom: 0;
}

.resume-role-head,
.resume-education {
    align-items: baseline;
    display: flex;
    justify-content: space-between;
    margin-bottom: 3px;
    gap: 16px;
}

.resume-role-title,
.resume-education-title {
    font-size: 0.875rem;
    font-weight: 700;
}

.resume-period {
    color: #64748B;
    flex-shrink: 0;
    font-size: 0.75rem;
}

.resume-company {
    color: #64748B;
    font-size: 0.78rem;
    font-style: italic;
    margin-bottom: 7px;
}

.resume-list {
    margin: 0;
    padding-left: 16px;
}

.resume-list-item {
    color: #374151;
    font-size: 0.82rem;
    line-height: 1.6;
    margin-bottom: 3px;
}

.resume-skills {
    color: #374151;
    font-size: 0.82rem;
    line-height: 1.8;
}

.resume-template-classic {
    font-family: 'Times New Roman', serif;
}

.resume-template-modern {
    border-top: 8px solid #0F766E;
    font-family: 'Inter', sans-serif;
    padding: 48px 58px;
}

.resume-template-modern .resume-header {
    border-bottom: 1px solid #99F6E4;
    text-align: left;
}

.resume-template-modern .resume-name {
    color: #0F172A;
    font-family: 'Outfit', sans-serif;
    font-size: 2rem;
}

.resume-template-modern .resume-title {
    color: #0F766E;
    font-weight: 700;
}

.resume-template-modern .resume-section-title {
    border-left: 4px solid #0F766E;
    color: #0F766E;
    padding-left: 8px;
}

.resume-template-modern .resume-role-title,
.resume-template-modern .resume-education-title {
    color: #111827;
}

.resume-template-modern .resume-list-item::marker {
    color: #0F766E;
}

.resume-template-compact {
    font-family: 'Inter', sans-serif;
    padding: 38px 46px;
}

.resume-template-compact .resume-header {
    border-bottom: 3px double #0F172A;
    margin-bottom: 18px;
    padding-bottom: 14px;
    text-align: left;
}

.resume-template-compact .resume-name {
    font-family: 'Outfit', sans-serif;
    font-size: 1.62rem;
}

.resume-template-compact .resume-section {
    margin-bottom: 15px;
}

.resume-template-compact .resume-section-title {
    border-bottom: 1px solid #CBD5E1;
    color: #111827;
    margin-bottom: 7px;
    padding-bottom: 4px;
}

.resume-template-compact .resume-role {
    margin-bottom: 12px;
}

.resume-template-compact .resume-text,
.resume-template-compact .resume-list-item {
    font-size: 0.78rem;
    line-height: 1.48;
}

.resume-template-compact .resume-skills {
    font-size: 0.78rem;
    line-height: 1.55;
}

.resume-template-compact .resume-company {
    margin-bottom: 5px;
}
</style>

@endsection
