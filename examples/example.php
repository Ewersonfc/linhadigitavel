<?php

require 'vendor/autoload.php';

use Ewersonfc\Linhadigitavel\LinhaDigitavel;
use Ewersonfc\Linhadigitavel\Constants\TypeConstant;
try {
    $class = new LinhaDigitavel([
        'type' => TypeConstant::ELIMINATION,
        'apiKey' => 'xx',
        'production' => true
    ]);
    $data = $class->convertArchive("https://ehtl-financ1.s3.amazonaws.com/uploads/boleto/tSo0gY_PROCESSO%209245.pdf");

    echo '<pre>';
    print_r($data);
    echo '</pre>';
} catch(\Exception $e) {
    echo $e->getMessage();
}
