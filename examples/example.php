<?php

require 'vendor/autoload.php';

use Ewersonfc\Linhadigitavel\LinhaDigitavel;
use Ewersonfc\Linhadigitavel\Constants\TypeConstant;
try {
    $class = new LinhaDigitavel([
        'type' => TypeConstant::BOTH,
        'apiKey' => 'xxx'
    ]);
    $data = $class->convertArchive("https://ehtl-financ1.s3.amazonaws.com/uploads/boleto/ZUNWgp_img001.pdf");

    echo '<pre>';
    print_r($data);
    echo '</pre>';
} catch(\Exception $e) {
    echo $e->getMessage();
}
