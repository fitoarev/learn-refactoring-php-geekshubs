<?php

namespace CatApi;

class CatApi
{
    private $cacheFilePath = __DIR__ . '/../../cache/random';

    public function getRandomImage()
    {
        if (!$this->isNotInCache()) {
            return file_get_contents($this->cacheFilePath);
        } else {
            $responseXml = @file_get_contents(
                'http://thecatapi.com/api/images/get?format=xml&type=jpg'
            );
            if (!$responseXml) {
                // the cat API is down or something
                return 'http://cdn.my-cool-website.com/default.jpg';
            }

            $responseElement = new \SimpleXMLElement($responseXml);

            file_put_contents(
                $this->cacheFilePath,
                (string)$responseElement->data->images[0]->image->url
            );

            return (string)$responseElement->data->images[0]->image->url;
        }
    }

    /**
     * @return bool
     */
    private function isNotInCache()
    {
        return !file_exists($this->cacheFilePath)
            || (time() - filemtime($this->cacheFilePath)) > 3;
    }
}
