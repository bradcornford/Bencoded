<?php namespace Cornford\Bencoded\Contracts;

interface DecodableInterface
{
    /**
     * BDecode content.
     *
     * @param string $content
     *
     * @return mixed
     */
    public function decode($content);
}
