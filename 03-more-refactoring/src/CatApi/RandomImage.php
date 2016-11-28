<?php

namespace CatApi;

use CatApi\Exceptions\CatApiIsDownException;

class RandomImage
{
    private $response;

    /**
     * RandomImage constructor.
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

    public function save($path)
    {
        $responseElement = new \SimpleXMLElement($this->response);

        $imageUrl = (string)$responseElement->data->images[0]->image->url;

        file_put_contents($path, $imageUrl);

        return $imageUrl;
    }
}