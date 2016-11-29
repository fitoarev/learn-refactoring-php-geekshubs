<?php

namespace CatApi;

use CatApi\Exceptions\CatApiIsDownException;

class RandomImage
{
    /** @var string */
    private $response;

    /**
     * RandomImage constructor.
     * @param string $format
     * @param string $type
     * @throws \CatApi\Exceptions\CatApiIsDownException
     */
    public function __construct($format, $type)
    {
        $this->response = @file_get_contents(
            "http://thecatapi.com/api/images/get?format={$format}&type={$type}"
        );

        if (!$this->response) {
            throw new CatApiIsDownException();
        }
    }

    /**
     * @return string
     */
    public function save()
    {
        $imageUrl = $this->obtainUrl(new \SimpleXMLElement($this->response));

        $cachedFile = new CachedFile();
        $cachedFile->persist($imageUrl);

        return $imageUrl;
    }

    /**
     * @param $responseElement
     * @return string
     */
    private function obtainUrl($responseElement)
    {
        return (string)$responseElement->data->images[0]->image->url;
    }
}