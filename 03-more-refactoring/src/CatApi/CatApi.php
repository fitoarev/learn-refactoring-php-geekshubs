<?php

namespace CatApi;

class CatApi
{
    private $cacheFilePath = __DIR__ . '/../../cache/random';

    public function getRandomImage()
    {
        if ($this->isInCache()) {
            return file_get_contents($this->cacheFilePath);
        }

        return $this->retrieveRandomImage();
    }

    private function isInCache()
    {
        return !$this->isNotInCache();
    }

    /**
     * @return bool
     */
    private function isNotInCache()
    {
        return !file_exists($this->cacheFilePath)
            || (time() - filemtime($this->cacheFilePath)) > 3;
    }

    /**
     * @return string
     */
    private function retrieveRandomImage()
    {
        $responseXml = @file_get_contents(
            'http://thecatapi.com/api/images/get?format=xml&type=jpg'
        );

        if (!$responseXml) {
            // the cat API is down or something
            return 'http://cdn.my-cool-website.com/default.jpg';
        }

        $responseElement = new \SimpleXMLElement($responseXml);

        $imageUrl = (string) $responseElement->data->images[0]->image->url;

        file_put_contents($this->cacheFilePath, $imageUrl);

        return $imageUrl;
    }
}
