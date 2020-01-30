<?php namespace Cornford\Bencoded\Contracts;

interface BencodedInterface
{
    /**
     * BDecode content.
     *
     * @param string $content
     *
     * @return mixed
     */
    public function decode($content);

    /**
     * BEncode content.
     *
     * @param mixed $content
     *
     * @return string
     */
    public function encode($content);
}
