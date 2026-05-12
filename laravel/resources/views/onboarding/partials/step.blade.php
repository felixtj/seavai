{{-- Returned by HTMX — swaps into #onboarding-body. Also used for initial render. --}}
{{-- Updates Alpine step var via response header trick using hx-on --}}

@if ($step === 1)
{{-- ── Step 1: Role focus ─────────────────────────────────────────────────── --}}
<div x-init="step = 1">
    <h2 class="text-xl font-bold text-slate-900 mb-1">What kind of roles are you looking for?</h2>
    <p class="text-slate-500 text-sm mb-6">We'll use this to filter your job matches.</p>

    <form hx-post="{{ route('onboarding.save', 1) }}"
          hx-target="#onboarding-body"
          hx-swap="innerHTML">
        @csrf
        <div class="grid gap-3 mb-6">
            @foreach ([
                'digital-marketing' => ['Digital Marketing', 'SEO, SEM, social, content, CRO'],
                'tech'              => ['Technology', 'Engineering, product, data, DevOps'],
                'ai-crypto'         => ['AI & Crypto', 'AI/ML, blockchain, web3, DeFi'],
            ] as $value => [$label, $desc])
            <label class="flex items-start gap-3 p-4 border rounded-xl cursor-pointer hover:border-blue-400 transition
                          {{ $profile->role_focus === $value ? 'border-blue-500 bg-blue-50' : 'border-slate-200' }}">
                <input type="radio" name="role_focus" value="{{ $value }}" class="mt-0.5 text-blue-600"
                       {{ $profile->role_focus === $value ? 'checked' : '' }}>
                <div>
                    <div class="font-medium text-slate-900 text-sm">{{ $label }}</div>
                    <div class="text-xs text-slate-500 mt-0.5">{{ $desc }}</div>
                </div>
            </label>
            @endforeach
        </div>
        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg px-4 py-3 text-sm transition">
            Continue →
        </button>
    </form>
</div>

@elseif ($step === 2)
{{-- ── Step 2: Work preferences ──────────────────────────────────────────── --}}
<div x-init="step = 2">
    <h2 class="text-xl font-bold text-slate-900 mb-1">Work preferences</h2>
    <p class="text-slate-500 text-sm mb-6">Tell us where and how you want to work.</p>

    <form hx-post="{{ route('onboarding.save', 2) }}"
          hx-target="#onboarding-body"
          hx-swap="innerHTML"
          class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">City or region</label>
            <input type="text" name="location" value="{{ $profile->location }}" placeholder="e.g. Sydney, Melbourne, Remote"
                   class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Work arrangement</label>
            <select name="remote_preference" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach(['remote' => 'Remote only', 'hybrid' => 'Hybrid', 'onsite' => 'On-site only', 'flexible' => 'Flexible'] as $val => $label)
                    <option value="{{ $val }}" {{ $profile->remote_preference === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Experience level</label>
            <select name="seniority" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach(['junior' => 'Junior (0–2 yrs)', 'mid' => 'Mid (3–5 yrs)', 'senior' => 'Senior (6–9 yrs)', 'lead' => 'Lead / Principal', 'any' => 'Open to any'] as $val => $label)
                    <option value="{{ $val }}" {{ $profile->seniority === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Min salary (AUD)</label>
                <input type="number" name="salary_min" value="{{ $profile->salary_min }}" placeholder="60000" min="0" step="5000"
                       class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Max salary (AUD)</label>
                <input type="number" name="salary_max" value="{{ $profile->salary_max }}" placeholder="120000" min="0" step="5000"
                       class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="button"
                    hx-get="{{ route('onboarding.back', 2) }}"
                    hx-target="#onboarding-body" hx-swap="innerHTML"
                    class="flex-1 border border-slate-200 text-slate-600 font-medium rounded-lg px-4 py-3 text-sm hover:bg-slate-50 transition">
                ← Back
            </button>
            <button type="submit"
                    class="flex-[2] bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg px-4 py-3 text-sm transition">
                Continue →
            </button>
        </div>
    </form>
</div>

@elseif ($step === 3)
{{-- ── Step 3: Resume / LinkedIn URL ────────────────────────────────────── --}}
<div x-init="step = 3">
    <h2 class="text-xl font-bold text-slate-900 mb-1">Add your LinkedIn profile</h2>
    <p class="text-slate-500 text-sm mb-6">We'll use this to pre-fill your profile. Resume upload comes next.</p>

    <form hx-post="{{ route('onboarding.save', 3) }}"
          hx-target="#onboarding-body"
          hx-swap="innerHTML"
          class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">LinkedIn URL <span class="text-slate-400 font-normal">(optional)</span></label>
            <input type="url" name="linkedin_url" value="{{ $profile->linkedin_url }}"
                   placeholder="https://linkedin.com/in/yourname"
                   class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="flex gap-3 pt-2">
            <button type="button"
                    hx-get="{{ route('onboarding.back', 3) }}"
                    hx-target="#onboarding-body" hx-swap="innerHTML"
                    class="flex-1 border border-slate-200 text-slate-600 font-medium rounded-lg px-4 py-3 text-sm hover:bg-slate-50 transition">
                ← Back
            </button>
            <button type="submit"
                    class="flex-[2] bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg px-4 py-3 text-sm transition">
                Continue →
            </button>
        </div>
        <p class="text-center text-xs text-slate-400">
            <button type="submit" class="underline hover:text-slate-600">Skip this step</button>
        </p>
    </form>
</div>

@elseif ($step === 4)
{{-- ── Step 4: Skills ────────────────────────────────────────────────────── --}}
<div x-init="step = 4"
     x-data="{
        skillInput: '',
        skills: {{ json_encode($profile->skills->pluck('skill')->toArray()) }},
        addSkill() {
            const s = this.skillInput.trim();
            if (s && !this.skills.includes(s) && this.skills.length < 20) {
                this.skills.push(s);
            }
            this.skillInput = '';
        },
        removeSkill(i) { this.skills.splice(i, 1); }
     }">
    <h2 class="text-xl font-bold text-slate-900 mb-1">Your top skills</h2>
    <p class="text-slate-500 text-sm mb-6">Add up to 20 skills. Press Enter or comma to add.</p>

    <form hx-post="{{ route('onboarding.save', 4) }}"
          hx-target="#onboarding-body"
          hx-swap="innerHTML"
          class="space-y-4">
        @csrf
        {{-- Hidden field carries comma-separated skills --}}
        <input type="hidden" name="skills" :value="skills.join(',')">

        {{-- Tag display --}}
        <div class="min-h-[60px] border border-slate-200 rounded-lg p-2 flex flex-wrap gap-2">
            <template x-for="(skill, i) in skills" :key="i">
                <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full">
                    <span x-text="skill"></span>
                    <button type="button" @click="removeSkill(i)" class="text-blue-400 hover:text-blue-700 leading-none">×</button>
                </span>
            </template>
            <input type="text" x-model="skillInput" placeholder="Type a skill…"
                   @keydown.enter.prevent="addSkill()"
                   @keydown.comma.prevent="addSkill()"
                   class="flex-1 min-w-[120px] text-sm outline-none px-1 py-0.5 text-slate-900 placeholder-slate-400">
        </div>
        <p class="text-xs text-slate-400" x-text="skills.length + ' / 20 skills added'"></p>

        <div class="flex gap-3 pt-2">
            <button type="button"
                    hx-get="{{ route('onboarding.back', 4) }}"
                    hx-target="#onboarding-body" hx-swap="innerHTML"
                    class="flex-1 border border-slate-200 text-slate-600 font-medium rounded-lg px-4 py-3 text-sm hover:bg-slate-50 transition">
                ← Back
            </button>
            <button type="submit"
                    class="flex-[2] bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg px-4 py-3 text-sm transition">
                Continue →
            </button>
        </div>
    </form>
</div>

@elseif ($step === 5)
{{-- ── Step 5: Email preferences ─────────────────────────────────────────── --}}
<div x-init="step = 5">
    <h2 class="text-xl font-bold text-slate-900 mb-1">Stay in the loop</h2>
    <p class="text-slate-500 text-sm mb-6">Choose how we contact you about new job matches.</p>

    <form hx-post="{{ route('onboarding.save', 5) }}"
          hx-target="#onboarding-body"
          hx-swap="innerHTML"
          class="space-y-4">
        @csrf
        <label class="flex items-start gap-3 p-4 border border-slate-200 rounded-xl cursor-pointer hover:border-blue-400 transition">
            <input type="checkbox" name="marketing_opt_in" value="1"
                   {{ Auth::user()->marketing_opt_in ? 'checked' : '' }}
                   class="mt-0.5 rounded text-blue-600">
            <div>
                <div class="font-medium text-slate-900 text-sm">Weekly job match digest</div>
                <div class="text-xs text-slate-500 mt-0.5">Get your top 5 matched jobs every Monday. Unsubscribe anytime.</div>
            </div>
        </label>

        <div class="flex gap-3 pt-2">
            <button type="button"
                    hx-get="{{ route('onboarding.back', 5) }}"
                    hx-target="#onboarding-body" hx-swap="innerHTML"
                    class="flex-1 border border-slate-200 text-slate-600 font-medium rounded-lg px-4 py-3 text-sm hover:bg-slate-50 transition">
                ← Back
            </button>
            <button type="submit"
                    class="flex-[2] bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg px-4 py-3 text-sm transition">
                Finish setup →
            </button>
        </div>
    </form>
</div>
@endif
