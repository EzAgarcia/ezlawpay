<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."/third_party/dompdf/autoload.inc.php";
use Dompdf\Dompdf;
use Dompdf\Options;

class Pdfgenerator {

  public function generate($html, $filename='', $stream=TRUE, $paper = 'A4', $orientation = "portrait")
  {
    $options = new Options();
    $options->set('isRemoteEnabled', TRUE);
    $dompdf = new Dompdf($options);
    $contxt = stream_context_create([ 
        'ssl' => [ 
            'verify_peer' => FALSE, 
            'verify_peer_name' => FALSE,
            'allow_self_signed'=> TRUE
        ] 
    ]);
    $dompdf->setHttpContext($contxt);
    $dompdf->loadHtml($html);
    $dompdf->setPaper($paper, $orientation);
    $dompdf->render();

    if ($stream) {
          $dompdf->stream($filename.".pdf", array("Attachment" => 0));
        }
    else 
        {
          return $dompdf->output();
        }
  }
}
?>