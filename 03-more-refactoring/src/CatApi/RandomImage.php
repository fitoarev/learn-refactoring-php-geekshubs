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
     * @param string $path
     * @return string
     */
    public function save($path)
    {
        $responseElement = new \SimpleXMLElement($this->response);

        $imageUrl = (string)$responseElement->data->images[0]->image->url;

        file_put_contents($path, $imageUrl);

        return $imageUrl;
    }
}