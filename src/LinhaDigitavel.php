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

/**
 * Class LinhaDigitavel
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
     * LinhaDigitavel constructor.
     * @param array $config
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
    }

    /**
     * @param $archivePath
     * @throws \Exception
     */
    private function requestPDFHTML($archivePath)
    {
        $data = $this->servicePDFHTML->readPdf($archivePath);
        if(count($data) > 0 )
            $this->selected['html'] = $data;
    }

    /**
     * @param $archivePath
     */
    private function requestPDFIMG($archivePath)
    {
        $data = $this->servicePDFIMG->readPDF($archivePath);
        if(count($data) > 0 )
            $this->selected['img'] = $data;
    }

    /**
     * @param $archivePath
     * @return array
     * @throws \Exception
     */
    public function convertArchive($archivePath)
    {
        switch ($this->config['type']) {
            case TypeConstant::PDF:
                $this->requestPDFHTML($archivePath);
                break;
            case TypeConstant::IMG:
                $this->requestPDFIMG($archivePath);
                break;
            case TypeConstant::BOTH:
                $this->requestPDFHTML($archivePath);
                $this->requestPDFIMG($archivePath);
                break;
            case TypeConstant::ELIMINATION:
            default:
                $this->requestPDFHTML($archivePath);
                if(count($this->selected['html']) == 0)
                    $this->requestPDFIMG($archivePath);
                break;
        }
        return $this->selected;
    }
}
