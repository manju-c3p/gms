<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf
{
    public function createPDF_old($html, $filename = '', $download = true)
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

	 public function createPDF($html, $filename = '', $download = true)
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream($filename, [
            'Attachment' => $download ? 1 : 0
        ]);
    }

}
