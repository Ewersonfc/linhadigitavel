<?php
/**
 * Created by PhpStorm.
 * User: ewerson
 * Date: 11/07/18
 * Time: 12:32
 */

namespace Ewersonfc\Linhadigitavel\Clients;

use \GuzzleHttp\Client;
/**
 * Class ClientOCR
 * @package Ewersonfc\Linhadigitavel\Clients
 */
class ClientOCR extends Client
{

    const BASE_URI = 'https://api.ocr.space/parse/image';
    /**
     * @var string
     */
    private $archiveUrl;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * ClientOCR constructor.
     * @param $archiveUrl
     */
    function __construct($archiveUrl, $apiKey)
    {
        parent::__construct();

        $this->archiveUrl = $archiveUrl;
        $this->apiKey = $apiKey;
    }

    /**
     *
     */
    public function readImg()
    {
        $request = $this->post(self::BASE_URI, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'apikey' => $this->apiKey
            ],
            'form_params' => [
                'url' => $this->archiveUrl,
                'language' => 'por',
                'isOverlayRequired' => 'True',
                'isCreateSearchablePdf' => 'True'
            ]
        ]);

        $body = json_decode($request->getBody());

        if($body->ErrorMessage)
            throw \Exception($body->ErrorMessage);

        return $body;
    }
}