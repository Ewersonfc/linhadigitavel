<?php
/**
 * Created by PhpStorm.
 * User: ewerson
 * Date: 10/07/18
 * Time: 15:41
 */

namespace Ewersonfc\Linhadigitavel\Services;

use Ewersonfc\Linhadigitavel\Helpers\Helper;
use \Smalot\PdfParser\Parser;
use Spatie\PdfToText\Pdf;

/**
 * Class ServicePDFHTML
 * @package Ewersonfc\Linhadigitavel\Services
 */
class ServicePDFHTML extends Parser
{
    /**
     * @var array
     */
    private $matchesPerPage = [];

    /**
     * @param $archivePath
     * @return array
     * @throws \Exception
     */
    private function loadDataPDF($archivePath)
    {
        try {
            $temp = tempnam(sys_get_temp_dir(), 'TMP_FILE_IN_');
            $file = file_get_contents($archivePath);
            file_put_contents($temp, $file);
            $pages = [Pdf::getText($temp)];
        } catch (\Exception $e) {
            return [];
        }


        if(!is_array($pages))
            return [];

        foreach($pages as $page) {
            $match = false;
            $string = $this->prepairString($page);
            if($string)
                $match = $this->getNumberLine($string);

            if($match)
                $this->matchesPerPage[] = $match;
        }

        return $this->matchesPerPage;
    }

    /**
     * @param $string
     * @return bool|mixed
     */
    private function getNumberLine($string)
    {
        $match = Helper::extract($string);
        if(count($match) == 0)
            return false;

        return $match;
    }

    /**
     * @param $textPage
     * @return bool|null|string|string[]
     */
    private function prepairString($textPage)
    {
        $data = Helper::prepair($textPage);
        if(!$data)
            return false;

        return $data;
    }

    /**
     * @param $archivePath
     * @return array
     * @throws \Exception
     */
    final public function readPdf($archivePath)
    {
        return $this->loadDataPDF($archivePath);
    }
}