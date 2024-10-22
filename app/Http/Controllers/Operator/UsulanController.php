<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Operator\DashboardController;
use Illuminate\Http\Request;

class UsulanController extends Controller
{
    protected $dashboard;

    public function __construct()
    {
        $this->dashboard = new DashboardController();
    }
    public function index()
    {
        $perguruanTinggi = $this->dashboard->getPt();
        $statusFiles = $this->dashboard->getDataFile();
        return view('operator.usulan-baru', compact('perguruanTinggi', 'statusFiles'));
    }
}
