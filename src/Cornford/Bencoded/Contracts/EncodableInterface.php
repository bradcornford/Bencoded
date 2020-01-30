<?php namespace Cornford\Bencoded\Contracts;

interface EncodableInterface
{
    /**
     * BEncode content.
     *
     * @param mixed $content
     *
     * @return string
     */
    public function encode($content);
}
