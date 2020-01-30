<?php namespace Cornford\Bencoded;

use Cornford\Bencoded\Contracts\EncodableInterface;
use Cornford\Bencoded\Exceptions\InvalidEncodeInputException;

class Encoder implements EncodableInterface
{
    const TYPE_ARRAY = 0;
    const TYPE_OBJECT = 1;
    const TYPE_INTEGER = 2;
    const TYPE_DOUBLE = 3;
    const TYPE_STRING = 4;

    const DELIMITER_END  = 'e';
    const DELIMITER_DICTIONARY = 'd';
    const DELIMITER_INTEGER  = 'i';
    const DELIMITER_LIST = 'l';

    const HEX_NULL = "\x00";

    const SEPARATOR = ':';

    /**
     * Content.
     *
     * @var mixed
     */
    private $content;

    /**
     * Encode content.
     *
     * @param mixed $content
     *
     * @throws InvalidEncodeInputException
     *
     * @return string
     */
    public function encode($content)
    {
        $this->content = $content;

        return $this->process();
    }

    /**
     * Process from the current position.
     *
     * @throws InvalidEncodeInputException
     *
     * @return string
     */
    private function process()
    {
        switch ($this->getCurrentType()) {
            case self::TYPE_STRING:
                return $this->encodeString();
            case self::TYPE_INTEGER:
            case self::TYPE_DOUBLE:
                return $this->encodeInteger();
            case self::TYPE_ARRAY:
                return $this->encodeArray();
            case self::TYPE_OBJECT:
                return $this->encodeObject();
            default:
                return self::HEX_NULL;
        }
    }

    /**
     * Get type of the value at the current pointer.
     *
     * @throws InvalidEncodeInputException
     *
     * @return integer
     */
    private function getCurrentType()
    {
        switch (gettype($this->content)) {
            case 'string':
                return self::TYPE_STRING;
            case 'integer':
                return self::TYPE_INTEGER;
            case 'double':
                return self::TYPE_DOUBLE;
            case 'array':
                return self::TYPE_ARRAY;
            case 'object':
                return self::TYPE_OBJECT;
            default:
                break;
        }

        throw new InvalidEncodeInputException('Invalid type input encountered: "' . $this->content . '"');
    }

    /**
     * Encode string.
     *
     * @return string
     */
    private function encodeString()
    {
        return (strlen($this->content) . self::SEPARATOR . $this->content);
    }

    /**
     * Encode integer.
     *
     * @return string
     */
    private function encodeInteger()
    {
        return (self::DELIMITER_INTEGER . $this->content . self::DELIMITER_END);
    }

    /**
     * Encode array.
     *
     * @throws InvalidEncodeInputException
     *
     * @return string
     */
    private function encodeArray()
    {
        $return = '';

        if ($this->isList($this->content)) {
            $return = $this->encodeList();
        } elseif ($this->isDictionary($this->content)) {
            $return = $this->encodeDictionary();
        }

        return $return . self::DELIMITER_END;
    }

    /**
     * Encode list.
     *
     * @throws InvalidEncodeInputException
     *
     * @return string
     */
    private function encodeList()
    {
        $return = self::DELIMITER_LIST;

        foreach ((array) $this->content as $value) {
            $return .= $this->encode($value);
        }

        return $return;
    }

    /**
     * Encode dictionary.
     *
     * @throws InvalidEncodeInputException
     *
     * @return string
     */
    private function encodeDictionary()
    {
        $content = (array) $this->content;

        ksort($content, SORT_STRING);
        $return = self::DELIMITER_DICTIONARY;

        foreach ($content as $key => $value) {
            if (strval($key)[0] == self::HEX_NULL) {
                continue;
            }

            $return .= $this->encode(strval($key)) . $this->encode($value);
        }

        return $return;
    }

    /**
     * Is list?
     *
     * @param array $array
     *
     * @return bool
     */
    private function isList(array $array)
    {
        foreach (array_keys($array) as $key) {
            if (!is_int($key)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Is dictionary?
     *
     * @param array $array
     *
     * @return bool
     */
    private function isDictionary(array $array)
    {
        foreach (array_keys($array) as $key) {
            if (!is_string($key)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Encode object.
     *
     * @throws InvalidEncodeInputException
     *
     * @return string
     */
    private function encodeObject()
    {
        if (method_exists($this->content, 'toArray')) {
            $this->content = $this->content->toArray();
        } else {
            $this->content = (array) $this->content;
        }

        return $this->encodeArray();
    }
}
