<?php

namespace App\Exports;

use App\Models\Voyage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class VoyageReportsByDateExport implements FromView
{
    protected $startDate;
    protected $endDate;
    protected $selectedVessel;

    public function __construct($startDate, $endDate, $selectedVessel = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->selectedVessel = $selectedVessel;
    }

    public function view(): View
    {
        $assignedVesselIds = Auth::user()->vessels()->pluck('vessels.id');

        $query = Voyage::with([
            'vessel',
            'unit',
            'remarks',
            'master_info',
            'robs',
            'received',
            'consumption',
            'engine',
            'off_hire',
            'location'
        ])
            ->where('report_type', 'Voyage Report')
            ->whereIn('vessel_id', $assignedVesselIds);

        if ($this->selectedVessel) {
            $query->where('vessel_id', $this->selectedVessel);
        }

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        } elseif ($this->startDate) {
            $query->where('created_at', '>=', $this->startDate);
        } elseif ($this->endDate) {
            $query->where('created_at', '<=', $this->endDate);
        }

        $reports = $query->get();

        return view('exports.voyage-reports-by-date', compact('reports'));
    }
}
