<?php

namespace App\Exports;

use App\Grievance;
use Maatwebsite\Excel\Concerns\FromCollection;



use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\Input;

class GrievancesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $itemDetailRepository;
    protected $grevs;
    public function __construct(Grievance $itemDetailRepository, $grevs)
    {
        
        $this->itemDetailRepository = $itemDetailRepository;
        $this->grevs= $grevs; 
    }
   

    public function collection()
    { dd($this->grevs);
        return $this->grevs;
    }
}
