<?php
/**
 * Created by PhpStorm.
 * User: ewerson
 * Date: 10/07/18
 * Time: 15:29
 */
namespace Ewersonfc\Linhadigitavel;

use Ewersonfc\Linhadigitavel\Constants\TypeConstant;
use Ewersonfc\Linhadigitavel\Services\ServicePDFHTML;
use Ewersonfc\Linhadigitavel\Services\ServicePDFIMG;
use Spatie\PdfToText\Pdf;

/**
 * Class LinhaDigitavel
 * @package Ewersonfc\Linhadigitavel
 */
class LinhaDigitavel
{
    /**
     * @var ServicePDFHTML
     */
    private $servicePDFHTML;

    /**
     * @var ServicePDFIMG
     */
    private $servicePDFIMG;

    /**
     * @var array
     */
    private $selected;

    /**
     * @var array
     */
    private $config;

    /**
     * @var array
     */
    private $types;

    /**
     * LinhaDigitavel constructor.
     * @param array $config
     * @throws \Exception
     */
    function __construct(array $config)
    {
        $this->servicePDFHTML = new ServicePDFHTML;
        $this->servicePDFIMG = new ServicePDFIMG;
        $this->selected = [
            'html'=> [],
            'img' => []
        ];
        $this->config = $config;
        $this->types = [
            TypeConstant::PDF,
            TypeConstant::IMG,
            TypeConstant::ELIMINATION,
            TypeConstant::BOTH,
        ];
        if(!isset($config['type']) or !in_array($config['type'], $this->types))
            throw new \Exception("Tipo de seleção inválido.");

        if(!isset($config['apiKey']) && $config['type'] != TypeConstant::PDF)
            throw new \Exception("Para extrair dados de imagem, é necessario assinar o OCR: https://ocr.space/ ");

        if(!isset($config['production']))
            $this->config['production'] = false;

        if(!isset($config['tempFolder']))
            $this->config['tempFolder'] = null;
    }

    /**
     * @param $archivePath
     * @throws \Exception
     */
    private function requestPDFHTML($archivePath)
    {
         $data = $this->servicePDFHTML->readPdf($archivePath, $this->config['tempFolder']);

        if(!empty($data))
            $this->selected['html'] = $data;
    }

    /**
     * @param $archivePath
     */
    private function requestPDFIMG($archivePath, $apiKey, $env)
    {
        try
        {
            $data = $this->servicePDFIMG->readPDF($archivePath, $apiKey, $env, $this->config['tempFolder']);
            if(count($data) > 0 )
                $this->selected['img'] = $data;
        }
        catch (\Exception $e)
        {
            $this->selected['img'] = [];
        }
    }

    /**
     * @param $archivePath
     * @return array
     * @throws \Exception
     */
    public function convertArchive($archivePath)
    {
        try
        {
            switch ($this->config['type']) {
                case TypeConstant::PDF:
                    $this->requestPDFHTML($archivePath);
                    break;
                case TypeConstant::IMG:
                    $this->requestPDFIMG($archivePath, $this->config['apiKey'], $this->config['production']);
                    break;
                case TypeConstant::BOTH:
                    $this->requestPDFHTML($archivePath);
                    $this->requestPDFIMG($archivePath, $this->config['apiKey'], $this->config['production']);
                    break;
                case TypeConstant::ELIMINATION:
                default:
                    $this->requestPDFHTML($archivePath);
                    if(count($this->selected['html']) == 0)
                        $this->requestPDFIMG($archivePath, $this->config['apiKey'], $this->config['production']);
                    break;
            }

        }
        finally
        {

            return $this->selected;
        }
    }
}
