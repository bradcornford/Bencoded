<?php namespace Cornford\Bencoded;

use Cornford\Bencoded\Contracts\BencodedInterface;

class Bencoded implements BencodedInterface
{
    /**
     * BDecode content.
     *
     * @param string $content
     *
     * @throws Exceptions\InvalidBencodedDelimiterException
     *
     * @return mixed
     */
    public function decode($content)
    {
        return (new Decoder())->decode($content);
    }

    /**
     * BEncode content.
     *
     * @param mixed $content
     *
     * @throws Exceptions\InvalidEncodeInputException
     *
     * @return string
     */
    public function encode($content)
    {
        return (new Encoder())->encode($content);
    }
}
