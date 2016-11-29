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

        if ($cachedFile->isInCache()) {
            return $this->retrieveCachedImage();
        }
        return $this->retrieveRandomImage('xml', 'jpg');
    }

    /**
     * @return string
     */
    private function retrieveCachedImage()
    {
        return file_get_contents($this->cacheFilePath);
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
