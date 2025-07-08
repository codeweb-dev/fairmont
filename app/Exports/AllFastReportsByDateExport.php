<?php

namespace App\Exports;

use App\Models\Voyage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class AllFastReportsByDateExport implements FromView
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        $assignedVesselIds = Auth::user()->vessels()->pluck('vessels.id');

        $reports = Voyage::with(['vessel', 'unit', 'robs'])
            ->where('report_type', 'All Fast')
            ->whereIn('vessel_id', $assignedVesselIds)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get();

        return view('exports.all-fast-reports-by-date', compact('reports'));
    }
}
