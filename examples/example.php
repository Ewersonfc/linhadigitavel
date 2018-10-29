<?php

require 'vendor/autoload.php';

use Ewersonfc\Linhadigitavel\LinhaDigitavel;
use Ewersonfc\Linhadigitavel\Constants\TypeConstant;
try {
    $class = new LinhaDigitavel([
        'type' => TypeConstant::ELIMINATION,
        'apiKey' => 'PDMXB4043888A',
        'production' => true
    ]);
    $data = $class->convertArchive("https://ehtl-financ1.s3.amazonaws.com/uploads/boleto/Vbt7Kw_BOLETO%20REF%20NF%2010130%20E-HTL.pdf");

    echo '<pre>';
    print_r($data);
    echo '</pre>';
} catch(\Exception $e) {
    echo $e->getMessage();
}
