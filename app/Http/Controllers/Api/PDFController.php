<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;

class PDFController extends Controller
{
    public function index()
    {
        view()->share('pdf1');
        $pdf = Pdf::loadView('pdf1');
        Storage::put('pdf/sample.pdf', $pdf->output());
        return $pdf->download('sample.pdf');
    }
}
