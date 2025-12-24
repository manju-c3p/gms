<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class Dompdf_lib
{
    public function load()
    {
        require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

        $options = new Options();
        $options->set('isRemoteEnabled', true); // enable images

        return new Dompdf($options);
    }
}
