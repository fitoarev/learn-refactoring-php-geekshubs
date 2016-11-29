<?php

namespace CatApi;

class CachedFile
{
    const CACHE_FILE_PATH = __DIR__ . '/../../cache/random';
    const SECONDS_IN_CACHE = 3;
    /**
     * @return bool
     */
    public function isInCache()
    {
        return file_exists(self::CACHE_FILE_PATH)
            && ($this->numberSecondOfTheFileCached() <= self::SECONDS_IN_CACHE);
    }

    /**
     * @return int
     */
    private function numberSecondOfTheFileCached()
    {
        return time() - filemtime(self::CACHE_FILE_PATH);
    }
}