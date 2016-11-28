<?php

namespace CatApi;

class CatApi
{
    /** @var string */
    private $cacheFilePath = __DIR__ . '/../../cache/random';

    /**
     * @return string
     */
    public function getRandomImage()
    {
        if ($this->isInCache()) {
            return file_get_contents($this->cacheFilePath);
        }

        return $this->retrieveRandomImage();
    }

    /**
     * @return bool
     */
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

        return $this->saveRandomImage($responseXml);
    }

    /**
     * @param $responseXml
     * @return string
     */
    private function saveRandomImage($responseXml)
    {
        $responseElement = new \SimpleXMLElement($responseXml);

        $imageUrl = (string)$responseElement->data->images[0]->image->url;

        file_put_contents($this->cacheFilePath, $imageUrl);

        return $imageUrl;
    }
}
