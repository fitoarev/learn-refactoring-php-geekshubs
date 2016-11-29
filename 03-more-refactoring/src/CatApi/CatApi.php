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
        $cachedFile = new CachedFile();

        if ($cachedFile->isValid()) {
            return $cachedFile->retrieve();
        }

        return $this->retrieveRandomImage('xml', 'jpg');
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
        } catch (CatApiIsDownException $exception) {
            return 'http://cdn.my-cool-website.com/default.jpg';
        }
        return $randomImage->save($this->cacheFilePath);
    }
}
