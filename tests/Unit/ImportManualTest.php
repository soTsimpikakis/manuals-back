<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use Tests\TestCase;

class ImportManualTest extends TestCase
{
    /** @test */
    public function a_pdf_can_be_imported() {
        $file = Storage::get('public/Traffic Jam.pdf');
        ini_set('memory_limit', '2G');

        $ml = ini_get('memory_limit');

        // dd($ml);

        $parser = new Parser();

        $pdf = $parser->parseFile(storage_path('app/public/Traffic Jam.pdf'));

        $text = $pdf->getText();
        $details = $pdf->getDetails();

        dd($text, $details);

        // Διαδικασία:(.|\n)+?Θ

        $this->assertTrue(true);
    }
}
