<?php

namespace Tests\Unit;

use Illuminate\Support\Str;
use App\Models\Manual;
use App\Services\ManualImportService;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use Tests\TestCase;

class ImportManualTest extends TestCase
{
    protected ManualImportService $importService;

    protected function setUp(): void {
        parent::setUp();

        $this->importService = new ManualImportService();
    }

    public function a_pdf_can_be_imported() {
        $file = Storage::get('public/Traffic Jam.pdf');
        ini_set('memory_limit', '2G');

        $ml = ini_get('memory_limit');

        // dd($ml);

        $parser = new Parser();

        $pdf = $parser->parseFile(storage_path('app/public/Traffic Jam.pdf'));

        $text = $pdf->getText();
        $details = $pdf->getDetails();


        // dd($text, $details);

        // α:(.*?\n*)+?Θ
        // Τίτλος: (.*) \n
        // Χρόνος: .*?(?<min>[0-9]+)-?(?<max>[0-9]*)['΄]*

        $durationRegexMatch = [];

        preg_match('/Χρόνος: .*?(?<min>[0-9]+)-?(?<max>[0-9]*)[\'΄]*/', $text, $$durationRegexMatch);

        // dd($$durationRegexMatch);

        $manual = new Manual([
            'title' => $details['Title'][0],
            'description' => $text,
            'min_duration' => (int)$$durationRegexMatch['min'],
            'max_duration' => Str::length($$durationRegexMatch['max']) > 0 ? (int)$$durationRegexMatch['max'] : (int)$$durationRegexMatch['min']
        ]);

        dd($manual);

        $this->assertTrue(true);
    }

    /** @test */
    public function can_import_a_pdf() {
        $path = storage_path('app/public/Traffic Jam.pdf');

        // dd($path);
        $this->importService->importFromPdf($path);

        $this->assertTrue(true);

    }
}
