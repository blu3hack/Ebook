<?php

namespace App\Http\Controllers\Ebook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EbookPDFController extends Controller
{
    public function ebook($file_pdf) {
        return view('ebook.ebook', ['file_pdf' => $file_pdf]);
    }
}
