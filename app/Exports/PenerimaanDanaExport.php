<?php

namespace App\Exports;

use App\Models\PenerimaanDana;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PenerimaanDanaExport implements FromView
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function view(): View
    {
        return view('penerimaan-dana.excel')->with('data', $this->data);
    }
}
