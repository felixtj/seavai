<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResolvesAdminView;
use App\Models\JobListing;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use ResolvesAdminView;

    public function dashboard()
    {
        $stats = [
            'total_jobs'  => JobListing::count(),
            'active_jobs' => JobListing::where('status', 'active')->count(),
            'draft_jobs'  => JobListing::where('status', 'draft')->count(),
            'remote_jobs' => JobListing::where('remote_type', 'remote')->where('status', 'active')->count(),
        ];
        $recentJobs = JobListing::latest('posted_at')->take(5)->get();

        return $this->adminPage('dashboard', compact('stats', 'recentJobs'));
    }

    public function stats()
    {
        $stats = [
            'total_jobs'  => JobListing::count(),
            'active_jobs' => JobListing::where('status', 'active')->count(),
            'draft_jobs'  => JobListing::where('status', 'draft')->count(),
            'remote_jobs' => JobListing::where('remote_type', 'remote')->where('status', 'active')->count(),
        ];

        return view('admin.partials.stats', compact('stats'));
    }

    public function jobs(Request $request)
    {
        $query = JobListing::query();

        if ($request->filled('filter') && $request->filter !== 'all') {
            $query->where('status', $request->filter);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $jobs   = $query->latest('posted_at')->paginate(12);
        $filter = $request->filter ?? 'all';
        $search = $request->search ?? '';

        // In-page swaps (filter chips, search, pagination) target #jobs-table specifically
        if ($request->header('HX-Target') === 'jobs-table') {
            return view('admin.partials.jobs-table', compact('jobs', 'filter', 'search'));
        }

        return $this->adminPage('jobs', compact('jobs', 'filter', 'search'));
    }

    public function jobDrawer(JobListing $job)
    {
        return view('admin.partials.job-drawer', compact('job'));
    }

    public function updateStatus(JobListing $job)
    {
        $statuses = ['active', 'draft', 'closed'];
        $next     = $statuses[(array_search($job->status, $statuses) + 1) % count($statuses)];

        $job->update(['status' => $next]);

        return view('admin.partials.status-badge', compact('job'));
    }
}
