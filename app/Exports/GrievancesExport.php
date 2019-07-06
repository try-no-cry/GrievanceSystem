<?php

namespace App\Exports;

use App\Grievance;
use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\Input;

class GrievancesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $itemDetailRepository;
    protected $grevs;
    protected $reports;
    public function __construct(Grievance $itemDetailRepository, $grevs,$reports)
    {
        
        $this->itemDetailRepository = $itemDetailRepository;
        $this->grevs= $grevs; 
        $this->reports=$reports;
    }
   


    public function view(): View
    {
        return view('admin.reportTable', [
            'grevs'=>$this->grevs,
            'report'=>$this->reports
        ]);
    }
}
