<?php
/**
 * Created by PhpStorm.
 * User: ewerson
 * Date: 10/07/18
 * Time: 15:45
 */

namespace Ewersonfc\Linhadigitavel\Services;

use Ewersonfc\Linhadigitavel\Clients\ClientOCR;
use Ewersonfc\Linhadigitavel\Helpers\Helper;

/**
 * Class ServicePDFIMG
 * @package Ewersonfc\Linhadigitavel\Services
 */
class ServicePDFIMG
{

    /**
     * @var array
     */
    private $matchesPerPage = [];

    /**
     * @param $textPage
     * @param bool $firstAttempt
     * @return bool|null|string|string[]
     */
    private function prepairString($textPage, $firstAttempt = true)
    {
        $data = $firstAttempt ? Helper::prepair($textPage) : Helper::prepairIMG($textPage);

        if(!$data)
            return false;

        return $data;
    }

    /**
     * @param $data
     * @param bool $firstAttempt
     * @return bool|mixed
     */
    private function getNumberLine($data, $firstAttempt = true)
    {
        $match = $firstAttempt ? Helper::extract($data) : Helper::extractIMG($data);

        if(count($match) == 0)
            return false;

        return preg_replace('/[^0-9]/', "", $match);
    }

    /**
     * @param $archiveUrl
     * @param $apiKey
     * @return array
     */
    final public function readPDF($archiveUrl, $apiKey, $env, $tempFolder = null)
    {
        try
        {
            $client = new ClientOCR($archiveUrl, $apiKey, $env, $tempFolder);
            $results = $client->readImg();
            
            if(!empty($results)){
                foreach ($results->ParsedResults as $result) {
                    $result = (object) $result;
                    $match = [];
                    $data = false;
                    $dataAttempt = false;
                    if ($result->ParsedText)
                        $data = $this->prepairString($result->ParsedText);

                    if (count($data) > 0)
                        $match = $this->getNumberLine($data);

                    if((!$match && $result->ParsedText) || (count($match) == 0 && $result->ParsedText))
                        $dataAttempt = $this->prepairString($result->ParsedText, false);

                    if ($dataAttempt && count($dataAttempt) > 0)
                        $match = $this->getNumberLine($dataAttempt, false);

                    if($match)
                        $this->matchesPerPage[] = $match;
                }
            }
            return $this->matchesPerPage;
        }
        catch(Exception $e)
        {
            return $this->matchesPerPage;
        }
    }
}