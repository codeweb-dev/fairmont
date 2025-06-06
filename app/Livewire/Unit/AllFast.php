<?php

namespace App\Livewire\Unit;

use Livewire\Component;

class AllFast extends Component
{
    public array $robs = [];

    public function addRow()
    {
        $this->robs[] = [
            'hsfo' => '',
            'biofuel' => '',
            'vlsfo' => '',
            'lsmgo' => '',
        ];
    }

    public function removeRow($index)
    {
        unset($this->robs[$index]);
        $this->robs = array_values($this->robs);
    }

    public function mount()
    {
        $this->addRow();
    }

    public function render()
    {
        return view('livewire.unit.all-fast');
    }
}
