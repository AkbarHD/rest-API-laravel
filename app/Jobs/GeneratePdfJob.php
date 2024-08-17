<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class GeneratePdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $pdf = PDF::loadView('format');
        $pdf->setOption('page-size', 'A4');
        $pdf->setOption('margin-top', 0);
        $pdf->setOption('margin-right', 0);
        $pdf->setOption('margin-bottom', 0);
        $pdf->setOption('margin-left', 0);

        $filename = 'pramatek_' . Carbon::now()->format('Y-m-d_H-i-s') . '.pdf';
        Storage::put('public/pdfs/' . $filename, $pdf->output());

        // Kirim notifikasi ke pengguna bahwa PDF sudah siap
        // Anda bisa mengimplementasikan ini nanti
    }
}
