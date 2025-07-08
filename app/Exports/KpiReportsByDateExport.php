<?php

namespace App\Exports;

use App\Models\Voyage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class KpiReportsByDateExport implements FromView
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

        $reports = Voyage::with([
            'vessel',
            'unit',
            'waste',
            'remarks',
            'master_info',
        ])
            ->where('report_type', 'KPI')
            ->whereIn('vessel_id', $assignedVesselIds)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get();

        return view('exports.kpi-reports-by-date', compact('reports'));
    }
}
