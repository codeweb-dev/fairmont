<?php

namespace App\Exports;

use App\Models\Voyage;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;

class AllFastReportsExport implements FromView
{
    protected $reportIds;

    public function __construct($reportIds = null)
    {
        $this->reportIds = $reportIds;
    }

    public function view(): View
    {
        $assignedVesselIds = Auth::user()->vessels()->pluck('vessels.id');

        $query = Voyage::with(['vessel', 'unit', 'robs'])
            ->where('report_type', 'All Fast')
            ->whereIn('vessel_id', $assignedVesselIds);

        // If specific report IDs are provided, filter by them
        if ($this->reportIds) {
            $query->whereIn('id', $this->reportIds);
        }

        $reports = $query->get();

        return view('exports.all-fast-reports', compact('reports'));
    }
}
