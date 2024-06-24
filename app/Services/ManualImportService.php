<?php

namespace App\Services;

use Smalot\PdfParser\Parser;

class ManualImportService {

    public function importFromPdf(string $pdfPath) {

        $pdfText = $this->extractTextFromPdf($pdfPath);

        dd($pdfText->getText());

    }


    protected function extractTextFromPdf(string $pdfPath)
    {
        // Use a PDF library to extract text
        // For example, you can use `spatie/pdf-to-text` package

        $parser = new Parser();
        $pdf = $parser->parseFile($pdfPath);


        return $pdf;
    }
}
