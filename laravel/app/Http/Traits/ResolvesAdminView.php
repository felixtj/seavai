<?php

namespace App\Http\Traits;

use Illuminate\Contracts\View\View;

/**
 * HTMX view resolution for admin pages.
 *
 * Convention:
 *   Full layout  →  resources/views/admin/{page}.blade.php
 *   HTMX partial →  resources/views/admin/partials/{page}-content.blade.php
 *
 * Usage in any AdminController method:
 *   return $this->adminPage('dashboard', $data);
 *   return $this->adminPage('jobs', $data);
 *
 * How it works:
 *   - Direct URL visit          → returns full layout view
 *   - HTMX sidebar nav          → HX-Target is "main-content" → returns content partial
 *   - HTMX in-page swap         → HX-Target is something else (e.g. "jobs-table")
 *                                  → caller handles it manually (return view('admin.partials.jobs-table', ...))
 */
trait ResolvesAdminView
{
    protected function adminPage(string $page, array $data = []): View
    {
        $isHtmx  = request()->header('HX-Request');
        $target  = request()->header('HX-Target');
        $isNavSwap = $isHtmx && $target === 'main-content';

        if ($isNavSwap) {
            return view("admin.partials.{$page}-content", $data);
        }

        return view("admin.{$page}", $data);
    }
}
