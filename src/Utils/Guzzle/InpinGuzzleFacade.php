<?php

namespace Inpin\Foundation\Utils\Guzzle;


class InpinGuzzleFacade
{
    private static $inpinGuzzle = null;

    /**
     * This method will check if $mockArray is filled then the Client will be created with a mockHandler attached to it
     *
     * @return InpinGuzzleAdapter|null
     */
    public static function getClient()
    {
        if (is_null(self::$inpinGuzzle)) {
            self::$inpinGuzzle = new InpinGuzzleAdapter();
        }

        return self::$inpinGuzzle;
    }
}