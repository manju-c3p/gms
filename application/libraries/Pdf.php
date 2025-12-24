<?php
use Dompdf\Dompdf;

class Pdf
{
    public function createPDF($html, $filename = '', $download = true)
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // A4 portrait
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $dompdf->stream($filename, [
            'Attachment' => $download ? 1 : 0
        ]);
    }
}
