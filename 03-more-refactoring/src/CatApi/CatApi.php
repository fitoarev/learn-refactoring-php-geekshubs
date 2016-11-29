<?php

namespace CatApi;

use CatApi\Exceptions\CacheIsInvalidException;
use CatApi\Exceptions\CatApiIsDownException;

class CatApi
{
    /**
     * @return string
     */
    public function getRandomImage()
    {
        try{
            return $this->retrieveCachedFile();
        } catch(CacheIsInvalidException $exception) {
            return $this->retrieveRandomImage('xml', 'jpg');
        }
    }

    /**
     * @return string
     * @throws \CatApi\Exceptions\CacheIsInvalidException
     */
    private function retrieveCachedFile()
    {
        $cachedFile = new CachedFile();

        if ($cachedFile->isValid()) {
            return $cachedFile->retrieve();
        } else {
            throw new CacheIsInvalidException();
        }
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

        return $randomImage->save();
    }
}
