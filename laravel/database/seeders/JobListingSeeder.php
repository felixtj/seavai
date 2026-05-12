<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JobListingSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = [
            ['title' => 'Senior Product Designer', 'company' => 'Canva', 'location' => 'Sydney, NSW', 'remote_type' => 'hybrid', 'status' => 'active', 'employment_type' => 'full-time', 'salary_min' => 130000, 'salary_max' => 160000, 'category' => 'digital-marketing', 'source_domain' => 'canva.com', 'posted_at' => Carbon::now()->subDays(1)],
            ['title' => 'Full Stack Engineer', 'company' => 'Atlassian', 'location' => 'Sydney, NSW', 'remote_type' => 'remote', 'status' => 'active', 'employment_type' => 'full-time', 'salary_min' => 150000, 'salary_max' => 200000, 'category' => 'tech', 'source_domain' => 'atlassian.com', 'posted_at' => Carbon::now()->subDays(2)],
            ['title' => 'AI/ML Engineer', 'company' => 'SafetyCulture', 'location' => 'Sydney, NSW', 'remote_type' => 'hybrid', 'status' => 'active', 'employment_type' => 'full-time', 'salary_min' => 160000, 'salary_max' => 220000, 'category' => 'ai-crypto', 'source_domain' => 'safetyculture.com', 'posted_at' => Carbon::now()->subDays(1)],
            ['title' => 'Digital Marketing Manager', 'company' => 'Afterpay', 'location' => 'Melbourne, VIC', 'remote_type' => 'hybrid', 'status' => 'active', 'employment_type' => 'full-time', 'salary_min' => 110000, 'salary_max' => 140000, 'category' => 'digital-marketing', 'source_domain' => 'afterpay.com', 'posted_at' => Carbon::now()->subDays(3)],
            ['title' => 'DevOps Engineer', 'company' => 'REA Group', 'location' => 'Melbourne, VIC', 'remote_type' => 'hybrid', 'status' => 'active', 'employment_type' => 'full-time', 'salary_min' => 140000, 'salary_max' => 175000, 'category' => 'tech', 'source_domain' => 'rea-group.com', 'posted_at' => Carbon::now()->subDays(4)],
            ['title' => 'Blockchain Developer', 'company' => 'Immutable', 'location' => 'Sydney, NSW', 'remote_type' => 'remote', 'status' => 'active', 'employment_type' => 'full-time', 'salary_min' => 180000, 'salary_max' => 240000, 'category' => 'ai-crypto', 'source_domain' => 'immutable.com', 'posted_at' => Carbon::now()->subDays(2)],
            ['title' => 'SEO Specialist', 'company' => 'SEEK', 'location' => 'Melbourne, VIC', 'remote_type' => 'onsite', 'status' => 'active', 'employment_type' => 'full-time', 'salary_min' => 85000, 'salary_max' => 110000, 'category' => 'digital-marketing', 'source_domain' => 'seek.com.au', 'posted_at' => Carbon::now()->subDays(5)],
            ['title' => 'Data Scientist', 'company' => 'Commonwealth Bank', 'location' => 'Sydney, NSW', 'remote_type' => 'hybrid', 'status' => 'active', 'employment_type' => 'full-time', 'salary_min' => 140000, 'salary_max' => 170000, 'category' => 'tech', 'source_domain' => 'commbank.com.au', 'posted_at' => Carbon::now()->subDays(3)],
            ['title' => 'Growth Marketing Lead', 'company' => 'Zip Co', 'location' => 'Sydney, NSW', 'remote_type' => 'hybrid', 'status' => 'draft', 'employment_type' => 'full-time', 'salary_min' => 120000, 'salary_max' => 150000, 'category' => 'digital-marketing', 'source_domain' => 'zip.co', 'posted_at' => Carbon::now()->subDays(6)],
            ['title' => 'Backend Engineer (Python)', 'company' => 'Envato', 'location' => 'Melbourne, VIC', 'remote_type' => 'remote', 'status' => 'active', 'employment_type' => 'full-time', 'salary_min' => 130000, 'salary_max' => 165000, 'category' => 'tech', 'source_domain' => 'envato.com', 'posted_at' => Carbon::now()->subDays(1)],
            ['title' => 'AI Product Manager', 'company' => 'Canva', 'location' => 'Sydney, NSW', 'remote_type' => 'hybrid', 'status' => 'active', 'employment_type' => 'full-time', 'salary_min' => 170000, 'salary_max' => 210000, 'category' => 'ai-crypto', 'source_domain' => 'canva.com', 'posted_at' => Carbon::now()->subDays(2)],
            ['title' => 'Performance Marketing Manager', 'company' => 'Kogan.com', 'location' => 'Melbourne, VIC', 'remote_type' => 'onsite', 'status' => 'closed', 'employment_type' => 'full-time', 'salary_min' => 100000, 'salary_max' => 130000, 'category' => 'digital-marketing', 'source_domain' => 'kogan.com', 'posted_at' => Carbon::now()->subDays(14)],
            ['title' => 'Frontend Engineer (React)', 'company' => 'Xero', 'location' => 'Melbourne, VIC', 'remote_type' => 'hybrid', 'status' => 'active', 'employment_type' => 'full-time', 'salary_min' => 130000, 'salary_max' => 160000, 'category' => 'tech', 'source_domain' => 'xero.com', 'posted_at' => Carbon::now()->subDays(3)],
            ['title' => 'DeFi Engineer', 'company' => 'Synthetix', 'location' => 'Remote', 'remote_type' => 'remote', 'status' => 'active', 'employment_type' => 'contract', 'salary_min' => 200000, 'salary_max' => 300000, 'category' => 'ai-crypto', 'source_domain' => 'synthetix.io', 'posted_at' => Carbon::now()->subDays(4)],
            ['title' => 'Social Media Manager', 'company' => 'Domain Group', 'location' => 'Sydney, NSW', 'remote_type' => 'hybrid', 'status' => 'active', 'employment_type' => 'full-time', 'salary_min' => 80000, 'salary_max' => 100000, 'category' => 'digital-marketing', 'source_domain' => 'domain.com.au', 'posted_at' => Carbon::now()->subDays(7)],
            ['title' => 'Cloud Infrastructure Engineer', 'company' => 'Atlassian', 'location' => 'Sydney, NSW', 'remote_type' => 'remote', 'status' => 'draft', 'employment_type' => 'full-time', 'salary_min' => 155000, 'salary_max' => 190000, 'category' => 'tech', 'source_domain' => 'atlassian.com', 'posted_at' => Carbon::now()->subDays(8)],
            ['title' => 'Machine Learning Researcher', 'company' => 'CSIRO', 'location' => 'Canberra, ACT', 'remote_type' => 'onsite', 'status' => 'active', 'employment_type' => 'full-time', 'salary_min' => 140000, 'salary_max' => 180000, 'category' => 'ai-crypto', 'source_domain' => 'csiro.au', 'posted_at' => Carbon::now()->subDays(5)],
            ['title' => 'Email Marketing Specialist', 'company' => 'Culture Amp', 'location' => 'Melbourne, VIC', 'remote_type' => 'hybrid', 'status' => 'active', 'employment_type' => 'full-time', 'salary_min' => 85000, 'salary_max' => 105000, 'category' => 'digital-marketing', 'source_domain' => 'cultureamp.com', 'posted_at' => Carbon::now()->subDays(2)],
            ['title' => 'Security Engineer', 'company' => 'Afterpay', 'location' => 'Melbourne, VIC', 'remote_type' => 'hybrid', 'status' => 'closed', 'employment_type' => 'full-time', 'salary_min' => 150000, 'salary_max' => 185000, 'category' => 'tech', 'source_domain' => 'afterpay.com', 'posted_at' => Carbon::now()->subDays(21)],
            ['title' => 'Web3 Product Lead', 'company' => 'Finder', 'location' => 'Sydney, NSW', 'remote_type' => 'hybrid', 'status' => 'active', 'employment_type' => 'full-time', 'salary_min' => 160000, 'salary_max' => 200000, 'category' => 'ai-crypto', 'source_domain' => 'finder.com.au', 'posted_at' => Carbon::now()->subDays(3)],
        ];

        $descriptions = [
            "We're looking for a talented professional to join our growing team. You'll work on challenging problems at scale, collaborate with world-class engineers and designers, and help shape the future of our platform. We offer competitive compensation, flexible working arrangements, and a supportive culture focused on learning and growth.",
        ];

        foreach ($jobs as $job) {
            DB::table('job_listings')->insert(array_merge($job, [
                'description' => $descriptions[0],
                'source_url' => 'https://' . $job['source_domain'] . '/careers',
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
