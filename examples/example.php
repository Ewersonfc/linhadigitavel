<?php

require 'vendor/autoload.php';

use Ewersonfc\Linhadigitavel\LinhaDigitavel;
use Ewersonfc\Linhadigitavel\Constants\TypeConstant;
try {
    $class = new LinhaDigitavel([
        'type' => TypeConstant::ELIMINATION,
        'apiKey' => 'xxxxxxx'
    ]);
    $data = $class->convertArchive("http://teste-portal.e-htl.com.br/uploads/boleto/B6TXBh_somentecompleto.pdf");

    echo '<pre>';
    print_r($data);
    echo '</pre>';
} catch(\Exception $e) {
    echo $e->getMessage();
}
