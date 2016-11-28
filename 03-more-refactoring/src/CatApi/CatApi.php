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

        return $this->retrieveRandomImage($format = 'xml', $type = 'jpg');
    }

    /**
     * @return bool
     */
    private function isInCache()
    {
        return file_exists($this->cacheFilePath)
            && (time() - filemtime($this->cacheFilePath)) <= 3;
    }

    /**
     * @param string $format
     * @param string $type
     * @return string
     */
    private function retrieveRandomImage($format, $type)
    {
        try {
            $randomImage = new RandomImage($format, $type);

            return $randomImage->save($this->cacheFilePath);
        } catch (CatApiIsDownException $exception) {
            return 'http://cdn.my-cool-website.com/default.jpg';
        }
    }
}
