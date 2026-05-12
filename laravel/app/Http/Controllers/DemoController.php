<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    // Dummy candidate data shared across all demo views
    private function candidate(): array
    {
        return [
            'name'       => 'Sarah Chen',
            'email'      => 'sarah.chen@email.com',
            'title'      => 'Senior Digital Marketing Manager',
            'location'   => 'Sydney, NSW',
            'avatar'     => 'SC',
            'seniority'  => 'Senior',
            'remote'     => 'Hybrid',
            'salary_min' => 120000,
            'salary_max' => 150000,
            'completeness' => 72,
        ];
    }

    private function jobData(): array
    {
        return [
            ['id' => 1, 'title' => 'Senior Digital Marketing Manager', 'company' => 'Canva', 'location' => 'Sydney, NSW', 'remote_type' => 'hybrid', 'salary' => '$130k–$160k', 'posted' => '1 day ago', 'category' => 'digital-marketing', 'match' => 96, 'logo' => 'CA', 'logo_color' => '#7c3aed', 'tags' => ['SEO', 'Paid Media', 'Analytics'], 'employment' => 'Full-time'],
            ['id' => 2, 'title' => 'Head of Growth Marketing', 'company' => 'Afterpay', 'location' => 'Melbourne, VIC', 'remote_type' => 'remote', 'salary' => '$150k–$180k', 'posted' => '2 days ago', 'category' => 'digital-marketing', 'match' => 91, 'logo' => 'AP', 'logo_color' => '#0369a1', 'tags' => ['Growth', 'CRM', 'B2C'], 'employment' => 'Full-time'],
            ['id' => 3, 'title' => 'Marketing Director', 'company' => 'SafetyCulture', 'location' => 'Sydney, NSW', 'remote_type' => 'hybrid', 'salary' => '$170k–$200k', 'posted' => '3 days ago', 'category' => 'digital-marketing', 'match' => 88, 'logo' => 'SC', 'logo_color' => '#047857', 'tags' => ['B2B SaaS', 'Demand Gen', 'Brand'], 'employment' => 'Full-time'],
            ['id' => 4, 'title' => 'Performance Marketing Lead', 'company' => 'Zip Co', 'location' => 'Sydney, NSW', 'remote_type' => 'hybrid', 'salary' => '$120k–$145k', 'posted' => '4 days ago', 'category' => 'digital-marketing', 'match' => 84, 'logo' => 'ZP', 'logo_color' => '#b45309', 'tags' => ['Paid Social', 'Google Ads', 'Attribution'], 'employment' => 'Full-time'],
            ['id' => 5, 'title' => 'Digital Marketing Manager', 'company' => 'REA Group', 'location' => 'Melbourne, VIC', 'remote_type' => 'onsite', 'salary' => '$110k–$135k', 'posted' => '5 days ago', 'category' => 'digital-marketing', 'match' => 79, 'logo' => 'RE', 'logo_color' => '#dc2626', 'tags' => ['Content', 'SEO', 'Email'], 'employment' => 'Full-time'],
            ['id' => 6, 'title' => 'VP Marketing', 'company' => 'Atlassian', 'location' => 'Sydney, NSW', 'remote_type' => 'remote', 'salary' => '$220k–$260k', 'posted' => '1 day ago', 'category' => 'tech', 'match' => 71, 'logo' => 'AT', 'logo_color' => '#2563eb', 'tags' => ['B2B', 'PLG', 'Global'], 'employment' => 'Full-time'],
        ];
    }

    public function login()    { return view('demo.login'); }
    public function onboarding() { return view('demo.onboarding'); }
    public function dashboard()  { return view('demo.dashboard',  ['candidate' => $this->candidate(), 'jobs' => array_slice($this->jobData(), 0, 3)]); }
    public function resume()     { return view('demo.resume',     ['candidate' => $this->candidate()]); }
    public function jobs(Request $request)
    {
        $jobs   = $this->jobData();
        $filter = $request->get('filter', 'all');
        $search = $request->get('search', '');
        if ($search) {
            $jobs = array_filter($jobs, fn($j) => str_contains(strtolower($j['title'].$j['company']), strtolower($search)));
        }
        if ($filter === 'remote')  $jobs = array_filter($jobs, fn($j) => $j['remote_type'] === 'remote');
        if ($filter === 'hybrid')  $jobs = array_filter($jobs, fn($j) => $j['remote_type'] === 'hybrid');

        if ($request->header('HX-Request')) {
            return view('demo.partials.jobs-grid', compact('jobs', 'filter', 'search'));
        }
        return view('demo.jobs', compact('jobs', 'filter', 'search'));
    }
    public function jobShow($id)
    {
        $jobs = $this->jobData();
        $job  = collect($jobs)->firstWhere('id', (int) $id) ?? $jobs[0];
        return view('demo.job-show', compact('job', 'jobs'));
    }
    public function matches() { return view('demo.matches', ['jobs' => $this->jobData(), 'candidate' => $this->candidate()]); }
    public function chat(Request $request)
    {
        $message = strtolower($request->input('message', ''));
        $replies = [
            'resume'    => "Your resume looks strong! I'd suggest adding more quantified results to your Canva role — for example, mentioning the % growth in organic traffic you drove. Want me to rewrite that section?",
            'job'       => "Based on your profile, you're a 96% match for the Canva Senior Digital Marketing Manager role. Your SEO and paid media experience aligns perfectly. Shall I draft a cover letter?",
            'salary'    => "For a Senior Digital Marketing Manager in Sydney with your experience, the market range is $120k–$160k. You're well-positioned to negotiate toward the upper end given your 6+ years of experience.",
            'match'     => "Your top match this week is Canva (96%). They're looking for exactly your background in multi-channel digital marketing. The role is hybrid, Sydney-based, and within your salary range.",
            'linkedin'  => "I've analysed your LinkedIn profile. Your headline could be stronger — try: *Senior Digital Marketing Leader | Driving Growth Through Data-Driven Strategy | Ex-HubSpot, Atlassian*. Want me to rewrite your full About section?",
            'help'      => "I can help you with: improving your resume, finding the best job matches, salary guidance, writing a cover letter, or optimising your LinkedIn profile. What would you like to work on?",
        ];
        $reply = "I'm here to help with your job search! Ask me about your resume, job matches, salary benchmarks, or LinkedIn optimisation.";
        foreach ($replies as $keyword => $response) {
            if (str_contains($message, $keyword)) { $reply = $response; break; }
        }
        return view('demo.partials.chat-message', ['reply' => $reply, 'message' => $request->input('message')]);
    }
}
