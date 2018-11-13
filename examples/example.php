<?php

require 'vendor/autoload.php';

use Ewersonfc\Linhadigitavel\LinhaDigitavel;
use Ewersonfc\Linhadigitavel\Constants\TypeConstant;
try {
    $class = new LinhaDigitavel([
        'type' => TypeConstant::ELIMINATION,
        'apiKey' => 'xx',
        'production' => false
    ]);
    $data = $class->convertArchive("");

    echo '<pre>';
    print_r($data);
    echo '</pre>';
} catch(\Exception $e) {
    echo $e->getMessage();
}
