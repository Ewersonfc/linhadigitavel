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

    const BASE_URI_FREE = 'https://api.ocr.space/parse/image';

    const BASE_URI_PRO = 'https://apipro2.ocr.space/parse/image';
    /**
     * @var string
     */
    private $archiveUrl;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $baseUri;

    /**
     * ClientOCR constructor.
     * @param $archiveUrl
     */
    function __construct($archiveUrl, $apiKey, $env)
    {
        parent::__construct();

        $this->archiveUrl = $archiveUrl;
        $this->apiKey = $apiKey;
        $this->baseUri = $env == true? self::BASE_URI_PRO : self::BASE_URI_FREE;
    }

    /**
     *
     */
    public function readImg()
    {
        $request = $this->post($this->baseUri, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'apikey' => $this->apiKey
            ],
            'form_params' => [
                'url' => $this->archiveUrl,
                'language' => 'por',
                'scale' => 'True'
            ]
        ]);

        $body = json_decode($request->getBody());

        if(isset($body->ErrorMessage))
            throw new \Exception($body->ErrorMessage[0]);

        return $body;
    }
}
