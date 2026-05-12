<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Started — Seav.ai</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; }
        h1,h2,h3 { font-family: 'Outfit', sans-serif; }
        body { background: #F8FAFC; margin: 0; min-height: 100vh; display: flex; flex-direction: column; }
        .option-card { border: 2px solid #E2E8F0; border-radius: 14px; padding: 20px; cursor: pointer; transition: all .2s; background: white; text-align: center; }
        .option-card:hover { border-color: #2563EB; background: #EFF6FF; }
        .option-card.selected { border-color: #2563EB; background: #EFF6FF; }
        .option-card .icon { font-size: 2rem; margin-bottom: 10px; display: block; }
        .skill-tag { display: inline-flex; align-items: center; gap: 6px; background: #EFF6FF; color: #1E40AF; border: 1px solid #BFDBFE; border-radius: 999px; padding: 5px 12px; font-size: 0.78rem; font-weight: 600; }
        .skill-tag button { background: none; border: none; color: #1E40AF; cursor: pointer; font-size: 0.75rem; padding: 0; opacity: .7; }
        .upload-zone { border: 2px dashed #CBD5E1; border-radius: 14px; padding: 40px; text-align: center; cursor: pointer; transition: all .2s; background: white; }
        .upload-zone:hover, .upload-zone.drag { border-color: #2563EB; background: #EFF6FF; }
        input[type=range] { accent-color: #2563EB; }
    </style>
</head>
<body x-data="{
    step: 1,
    totalSteps: 5,
    focus: '',
    remote: '',
    seniority: '',
    salaryMin: 80,
    salaryMax: 150,
    location: 'Sydney, NSW',
    skills: ['Digital Marketing', 'SEO', 'Google Ads', 'Analytics'],
    newSkill: '',
    uploaded: false,
    notifications: true,
    addSkill() { if (this.newSkill.trim()) { this.skills.push(this.newSkill.trim()); this.newSkill = ''; } },
    removeSkill(i) { this.skills.splice(i, 1); },
    next() { if (this.step < this.totalSteps) this.step++; else window.location = '{{ route('demo.dashboard') }}'; },
    prev() { if (this.step > 1) this.step--; else window.location = '{{ route('demo.login') }}'; },
}">

    <!-- Top bar -->
    <div style="background:white;border-bottom:1px solid #E2E8F0;padding:16px 24px;display:flex;align-items:center;justify-content:space-between;">
        <div style="display:flex;align-items:center;gap:8px;">
            <div style="width:28px;height:28px;background:#2563EB;border-radius:7px;display:flex;align-items:center;justify-content:center;color:white;font-family:'Outfit',sans-serif;font-weight:800;font-size:0.8rem;">S</div>
            <span style="font-family:'Outfit',sans-serif;font-weight:800;font-size:1rem;color:#0F172A;">Seav.ai</span>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            <span style="font-size:0.78rem;color:#64748B;">Step <span x-text="step"></span> of <span x-text="totalSteps"></span></span>
            <a href="{{ route('demo.dashboard') }}" style="font-size:0.78rem;color:#94A3B8;text-decoration:none;">Skip for now</a>
        </div>
    </div>

    <!-- Progress bar -->
    <div style="height:3px;background:#E2E8F0;">
        <div style="height:100%;background:#2563EB;transition:width .4s ease;" :style="`width:${(step/totalSteps)*100}%`"></div>
    </div>

    <!-- Content -->
    <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:40px 24px;">
        <div style="width:100%;max-width:580px;">

            {{-- STEP 1: Role focus --}}
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <div style="text-align:center;margin-bottom:32px;">
                    <div style="font-size:2.5rem;margin-bottom:12px;">🎯</div>
                    <h2 style="font-size:1.6rem;font-weight:800;margin-bottom:8px;">What type of roles are you looking for?</h2>
                    <p style="color:#64748B;font-size:0.9rem;">We'll tailor your job matches and resume advice to your field.</p>
                </div>
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:32px;">
                    <div class="option-card" :class="focus==='marketing' && 'selected'" @click="focus='marketing'">
                        <span class="icon">📣</span>
                        <div style="font-weight:700;font-size:0.95rem;margin-bottom:4px;">Digital Marketing</div>
                        <div style="font-size:0.75rem;color:#64748B;">SEO, Paid, Content, Growth</div>
                    </div>
                    <div class="option-card" :class="focus==='tech' && 'selected'" @click="focus='tech'">
                        <span class="icon">💻</span>
                        <div style="font-weight:700;font-size:0.95rem;margin-bottom:4px;">Tech & Engineering</div>
                        <div style="font-size:0.75rem;color:#64748B;">Dev, Data, Product, Design</div>
                    </div>
                    <div class="option-card" :class="focus==='ai' && 'selected'" @click="focus='ai'">
                        <span class="icon">🤖</span>
                        <div style="font-weight:700;font-size:0.95rem;margin-bottom:4px;">AI & Crypto</div>
                        <div style="font-size:0.75rem;color:#64748B;">ML, Web3, DeFi, AI Products</div>
                    </div>
                </div>
            </div>

            {{-- STEP 2: Work preferences --}}
            <div x-show="step === 2" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <div style="text-align:center;margin-bottom:32px;">
                    <div style="font-size:2.5rem;margin-bottom:12px;">⚙️</div>
                    <h2 style="font-size:1.6rem;font-weight:800;margin-bottom:8px;">Set your work preferences</h2>
                    <p style="color:#64748B;font-size:0.9rem;">These are your hard filters — we'll only show roles that match.</p>
                </div>
                <div style="display:flex;flex-direction:column;gap:20px;background:white;border:1px solid #E2E8F0;border-radius:16px;padding:24px;margin-bottom:32px;">
                    <div>
                        <label style="display:block;font-size:0.78rem;font-weight:700;color:#374151;margin-bottom:8px;text-transform:uppercase;letter-spacing:.04em;">Location</label>
                        <input type="text" x-model="location" style="width:100%;padding:10px 14px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:0.875rem;font-family:inherit;outline:none;" placeholder="Sydney, NSW">
                    </div>
                    <div>
                        <label style="display:block;font-size:0.78rem;font-weight:700;color:#374151;margin-bottom:8px;text-transform:uppercase;letter-spacing:.04em;">Remote preference</label>
                        <div style="display:flex;gap:8px;">
                            @foreach(['Remote','Hybrid','Onsite','Flexible'] as $r)
                            <button @click="remote='{{ strtolower($r) }}'" :class="remote==='{{ strtolower($r) }}' ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-gray-200 text-gray-500'" style="flex:1;padding:8px;border:2px solid;border-radius:8px;font-size:0.8rem;font-weight:600;cursor:pointer;background:white;transition:all .15s;font-family:inherit;">{{ $r }}</button>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label style="display:block;font-size:0.78rem;font-weight:700;color:#374151;margin-bottom:8px;text-transform:uppercase;letter-spacing:.04em;">Seniority</label>
                        <div style="display:flex;gap:8px;">
                            @foreach(['Junior','Mid','Senior','Lead'] as $s)
                            <button @click="seniority='{{ strtolower($s) }}'" :class="seniority==='{{ strtolower($s) }}' ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-gray-200 text-gray-500'" style="flex:1;padding:8px;border:2px solid;border-radius:8px;font-size:0.8rem;font-weight:600;cursor:pointer;background:white;transition:all .15s;font-family:inherit;">{{ $s }}</button>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label style="display:block;font-size:0.78rem;font-weight:700;color:#374151;margin-bottom:8px;text-transform:uppercase;letter-spacing:.04em;">
                            Salary range: <span style="color:#2563EB;font-weight:700;">$<span x-text="salaryMin"></span>k – $<span x-text="salaryMax"></span>k AUD</span>
                        </label>
                        <div style="display:flex;gap:12px;align-items:center;">
                            <input type="range" x-model="salaryMin" min="50" max="200" step="5" style="flex:1;">
                            <input type="range" x-model="salaryMax" min="50" max="300" step="5" style="flex:1;">
                        </div>
                    </div>
                </div>
            </div>

            {{-- STEP 3: Upload resume --}}
            <div x-show="step === 3" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <div style="text-align:center;margin-bottom:32px;">
                    <div style="font-size:2.5rem;margin-bottom:12px;">📄</div>
                    <h2 style="font-size:1.6rem;font-weight:800;margin-bottom:8px;">Upload your resume</h2>
                    <p style="color:#64748B;font-size:0.9rem;">Our AI will parse it and build your profile automatically. Takes ~30 seconds.</p>
                </div>
                <div x-show="!uploaded">
                    <div class="upload-zone" @click="uploaded=true" @dragover.prevent @drop.prevent="uploaded=true" style="margin-bottom:16px;">
                        <div style="font-size:2.5rem;margin-bottom:12px;">☁️</div>
                        <div style="font-weight:600;font-size:0.95rem;margin-bottom:6px;">Drag & drop or click to upload</div>
                        <div style="font-size:0.8rem;color:#64748B;">PDF or DOCX · Max 10MB</div>
                    </div>
                    <div style="text-align:center;">
                        <button @click="step++" style="background:none;border:none;color:#64748B;font-size:0.82rem;cursor:pointer;text-decoration:underline;font-family:inherit;">Skip for now — I'll add it later</button>
                    </div>
                </div>
                <div x-show="uploaded" style="background:white;border:1px solid #E2E8F0;border-radius:14px;padding:20px;display:flex;align-items:center;gap:14px;margin-bottom:20px;">
                    <div style="width:44px;height:44px;background:#EFF6FF;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#2563EB;font-size:1.2rem;flex-shrink:0;">📄</div>
                    <div style="flex:1;">
                        <div style="font-weight:600;font-size:0.875rem;">Sarah_Chen_Resume_2026.pdf</div>
                        <div style="font-size:0.75rem;color:#64748B;margin-top:2px;">284 KB · Uploaded</div>
                        <div style="margin-top:8px;height:4px;background:#E2E8F0;border-radius:999px;overflow:hidden;">
                            <div style="height:100%;background:#10B981;width:100%;border-radius:999px;"></div>
                        </div>
                    </div>
                    <div style="color:#10B981;font-size:1.1rem;">✓</div>
                </div>
                <div x-show="uploaded" style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:10px;padding:14px 16px;font-size:0.82rem;color:#1E40AF;">
                    <strong>✨ AI parsing complete!</strong> We extracted 3 roles, 12 skills, and 2 education entries. You can review and edit these in the next step.
                </div>
            </div>

            {{-- STEP 4: Skills --}}
            <div x-show="step === 4" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <div style="text-align:center;margin-bottom:32px;">
                    <div style="font-size:2.5rem;margin-bottom:12px;">🧠</div>
                    <h2 style="font-size:1.6rem;font-weight:800;margin-bottom:8px;">Confirm your top skills</h2>
                    <p style="color:#64748B;font-size:0.9rem;">We extracted these from your resume. Add or remove as needed.</p>
                </div>
                <div style="background:white;border:1px solid #E2E8F0;border-radius:16px;padding:24px;margin-bottom:32px;">
                    <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:16px;">
                        <template x-for="(skill, i) in skills" :key="i">
                            <div class="skill-tag">
                                <span x-text="skill"></span>
                                <button @click="removeSkill(i)">✕</button>
                            </div>
                        </template>
                    </div>
                    <div style="display:flex;gap:8px;">
                        <input type="text" x-model="newSkill" placeholder="Add a skill…" @keydown.enter="addSkill()" style="flex:1;padding:8px 12px;border:1.5px solid #E2E8F0;border-radius:8px;font-size:0.82rem;outline:none;font-family:inherit;">
                        <button @click="addSkill()" style="padding:8px 16px;background:#2563EB;color:white;border:none;border-radius:8px;font-size:0.82rem;cursor:pointer;font-family:inherit;font-weight:600;">Add</button>
                    </div>
                    <div style="margin-top:14px;border-top:1px solid #F1F5F9;padding-top:14px;">
                        <div style="font-size:0.72rem;font-weight:600;color:#94A3B8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">Suggested skills</div>
                        <div style="display:flex;flex-wrap:wrap;gap:6px;">
                            @foreach(['HubSpot','Salesforce','Marketo','LinkedIn Ads','A/B Testing','CRO','Copywriting','Email Marketing'] as $s)
                            <button @click="skills.push('{{ $s }}')" style="border:1px dashed #CBD5E1;border-radius:999px;padding:4px 12px;font-size:0.72rem;background:none;cursor:pointer;color:#64748B;font-family:inherit;transition:all .15s;" onmouseover="this.style.borderColor='#2563EB';this.style.color='#2563EB'" onmouseout="this.style.borderColor='#CBD5E1';this.style.color='#64748B'">+ {{ $s }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- STEP 5: Notifications --}}
            <div x-show="step === 5" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <div style="text-align:center;margin-bottom:32px;">
                    <div style="font-size:2.5rem;margin-bottom:12px;">🎉</div>
                    <h2 style="font-size:1.6rem;font-weight:800;margin-bottom:8px;">You're almost in!</h2>
                    <p style="color:#64748B;font-size:0.9rem;">Just set your notification preferences and we'll take it from here.</p>
                </div>
                <div style="background:white;border:1px solid #E2E8F0;border-radius:16px;padding:24px;margin-bottom:32px;display:flex;flex-direction:column;gap:16px;">
                    @foreach([
                        ['Weekly Pulse Check email', 'Curated top matches every Monday morning', 'bolt'],
                        ['New role alerts', 'Instant alert when a high-match job is posted', 'bell'],
                        ['Resume tips', 'Personalised tips to improve your profile score', 'wand-magic-sparkles'],
                    ] as $n)
                    <div style="display:flex;align-items:center;justify-content:space-between;padding-bottom:16px;border-bottom:1px solid #F1F5F9;">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:38px;height:38px;border-radius:9px;background:#EFF6FF;color:#2563EB;display:flex;align-items:center;justify-content:center;font-size:0.9rem;flex-shrink:0;">
                                <i class="fa-solid fa-{{ $n[2] }}"></i>
                            </div>
                            <div>
                                <div style="font-weight:600;font-size:0.875rem;">{{ $n[0] }}</div>
                                <div style="font-size:0.75rem;color:#64748B;">{{ $n[1] }}</div>
                            </div>
                        </div>
                        <div x-data="{ on: true }" style="width:42px;height:24px;border-radius:999px;background:#2563EB;cursor:pointer;position:relative;transition:background .2s;flex-shrink:0;" :style="on ? 'background:#2563EB' : 'background:#E2E8F0'" @click="on=!on">
                            <div style="position:absolute;top:2px;width:20px;height:20px;border-radius:50%;background:white;transition:left .2s;" :style="on ? 'left:20px' : 'left:2px'"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div style="background:linear-gradient(135deg,#EFF6FF,#F5F3FF);border:1px solid #BFDBFE;border-radius:14px;padding:20px;text-align:center;margin-bottom:24px;">
                    <div style="font-size:1.5rem;margin-bottom:8px;">🚀</div>
                    <div style="font-weight:700;font-size:0.95rem;color:#1E40AF;margin-bottom:4px;">Your profile is ready!</div>
                    <div style="font-size:0.8rem;color:#3730A3;">We've already found <strong>6 roles</strong> that match your profile. Let's go!</div>
                </div>
            </div>

            <!-- Navigation buttons -->
            <div style="display:flex;justify-content:space-between;align-items:center;margin-top:8px;">
                <button @click="prev()" style="display:flex;align-items:center;gap:6px;background:none;border:1.5px solid #E2E8F0;border-radius:8px;padding:10px 18px;font-size:0.875rem;font-weight:600;cursor:pointer;color:#64748B;font-family:inherit;transition:all .15s;" onmouseover="this.style.borderColor='#2563EB';this.style.color='#2563EB'" onmouseout="this.style.borderColor='#E2E8F0';this.style.color='#64748B'">
                    ← Back
                </button>
                <div style="display:flex;gap:6px;">
                    <template x-for="i in totalSteps" :key="i">
                        <div style="width:8px;height:8px;border-radius:50%;transition:all .2s;" :style="i === step ? 'background:#2563EB;width:24px;border-radius:999px' : 'background:#E2E8F0'"></div>
                    </template>
                </div>
                <button @click="next()" style="display:flex;align-items:center;gap:6px;background:#2563EB;color:white;border:none;border-radius:8px;padding:10px 22px;font-size:0.875rem;font-weight:600;cursor:pointer;font-family:inherit;transition:background .15s;" onmouseover="this.style.background='#1D4ED8'" onmouseout="this.style.background='#2563EB'">
                    <span x-text="step === totalSteps ? 'Go to Dashboard →' : 'Continue →'"></span>
                </button>
            </div>

        </div>
    </div>
</body>
</html>
