<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class BookController extends Controller
{
    public function index()
    {
        $books = Books::all();
        return view('book', [
            'books' => $books,
        ]);
    }

    public function exportPdf()
    {
        $books = Books::all();
        $pdf = Pdf::loadView('pdf.export-book', [
            'books' => $books
        ]);
        return $pdf->download('export-book-' . Carbon::now() . '.pdf');
    }
}
