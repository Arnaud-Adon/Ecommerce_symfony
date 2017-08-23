<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ecommerce\EcommerceBundle\Services;

use Spipu\Html2Pdf\Html2Pdf;

/**
 * Description of Html2Pdf
 *
 * @author Arnaud
 */
class FacturationPDF {
    private $pdf;
    
    public function create($orientation = null, $format = null, $lang = null, $unicode = null, $encoding = null, $margin = null){
        $this->pdf = new Html2Pdf(
                $orientation ? $orientation : $this->orientation,
                $format ? $format : $this->format,
                $lang ? $lang : $this->lang,
                $unicode ? $unicode : $this->unicode,
                $encoding ? $encoding : $this->encoding,
                $margin ? $margin :$this->margin
                );
    }
    
    public function generatePdf($template, $name){
        $this->pdf->writeHTML($template);
        return $this->pdf->Output($name.'.pdf');
    }
}
