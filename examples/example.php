<?php

require 'vendor/autoload.php';

use Ewersonfc\Linhadigitavel\LinhaDigitavel;
use Ewersonfc\Linhadigitavel\Constants\TypeConstant;
try {
    $class = new LinhaDigitavel([
        'type' => TypeConstant::ELIMINATION
    ]);
    $data = $class->convertArchive("/acchive/path");

    echo '<pre>';
    print_r($data);
    echo '</pre>';
} catch(\Exception $e) {
    echo $e->getMessage();
}
