<?php

namespace App\Http\Controllers;

use App\Exports\ExportBook;
use App\Models\Books;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

    public function export_excel()
    {
        return Excel::download(new ExportBook, 'books.xlsx');
    }
}
