<?php

namespace CatApi;

use CatApi\Exceptions\CatApiIsDownException;

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
        try {
            $randomImage = new RandomImage('xml', 'jpg');

            return $randomImage->save($this->cacheFilePath);
        } catch (CatApiIsDownException $exception) {
            return 'http://cdn.my-cool-website.com/default.jpg';
        }
    }
}
