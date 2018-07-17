<?php

require 'vendor/autoload.php';

use Ewersonfc\Linhadigitavel\LinhaDigitavel;
use Ewersonfc\Linhadigitavel\Constants\TypeConstant;
try {
    $class = new LinhaDigitavel([
        'type' => TypeConstant::PDF,
        'apiKey' => 'xxx'
    ]);
    $data = $class->convertArchive("https://ehtl-financ1.s3.amazonaws.com/uploads/boleto/VSwoQL_BOL%20ANA.pdf");

    echo '<pre>';
    print_r($data);
    echo '</pre>';
} catch(\Exception $e) {
    echo $e->getMessage();
}
