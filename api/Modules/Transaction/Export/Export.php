<?php

namespace Modules\Transaction\Export;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Export implements FromView
{
    private $transactions;

    public function __construct($data)
    {
        $this->transactions = $data;
    }

    public function view(): View
    {
        return view('transaction::index', ['transactions' => $this->transactions]);
    }
}
