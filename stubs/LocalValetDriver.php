<?php

class LocalValetDriver extends LaravelValetDriver
{
    public function serves($sitePath, $siteName, $uri): bool
    {
        if (str_contains($uri, 'node_modules')) {
            return true;
        }

        return parent::serves($sitePath, $siteName, $uri);
    }

    public function isStaticFile($sitePath, $siteName, $uri): bool|string
    {
        $ret = parent::isStaticFile($sitePath, $siteName, $uri);

        if (file_exists($path = $sitePath.$uri)) {
            return $path;
        }

        return $ret;
    }
}
