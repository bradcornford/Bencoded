<?php namespace Cornford\Bencoded;

use Cornford\Bencoded\Contracts\DecodableInterface;
use Cornford\Bencoded\Exceptions\InvalidBencodedDelimiterException;

class Decoder implements DecodableInterface
{
    const TYPE_END = 0;
    const TYPE_DICTIONARY = 1;
    const TYPE_INTEGER = 2;
    const TYPE_LIST = 3;
    const TYPE_STRING = 4;

    const DELIMITER_END = 'e';
    const DELIMITER_DICTIONARY = 'd';
    const DELIMITER_INTEGER = 'i';
    const DELIMITER_LIST = 'l';
    const DELIMITER_STRING = '[0-9]';

    const SEPARATOR = ':';

    /**
     * Content.
     *
     * @var string
     */
    private $content;

    /**
     * Current pointer position.
     *
     * @var integer
     */
    private $pointer = 0;

    /**
     * BDecode content.
     *
     * @param string $content
     *
     * @throws InvalidBencodedDelimiterException
     *
     * @return string
     */
    public function decode($content)
    {
        $this->content = $content;
        $this->pointer = 0;

        return $this->process();
    }

    /**
     * Process from the current position.
     *
     * @throws InvalidBencodedDelimiterException
     *
     * @return mixed
     */
    private function process()
    {
        switch ($this->getCurrentType()) {
            case self::TYPE_DICTIONARY:
                return self::decodeDictionary();
            case self::TYPE_INTEGER:
                return $this->decodeInteger();
            case self::TYPE_LIST:
                return $this->decodeList();
            case self::TYPE_STRING:
                return $this->decodeString();
            default:
                return null;
        }
    }

    /**
     * Get type of the value at the current pointer.
     *
     * @throws InvalidBencodedDelimiterException
     *
     * @return int
     */
    private function getCurrentType()
    {
        $current = substr($this->content, $this->pointer, 1);

        $map = array(
            self::TYPE_END  => self::DELIMITER_END,
            self::TYPE_DICTIONARY => self::DELIMITER_DICTIONARY,
            self::TYPE_INTEGER  => self::DELIMITER_INTEGER,
            self::TYPE_LIST => self::DELIMITER_LIST,
            self::TYPE_STRING  => self::DELIMITER_STRING,
        );

        foreach ($map as $type => $pattern) {
            if (preg_match('/^' . $pattern . '$/', $current)) {
                return $type;
            }
        }

        throw new InvalidBencodedDelimiterException('Invalid type delimiter encountered: "' . $current . '"');
    }

    /**
     * Decode string.
     *
     * @return string
     */
    private function decodeString()
    {
        $separatorPosition = strpos($this->content, self::SEPARATOR, $this->pointer);
        $length = (int) substr($this->content, $this->pointer, $separatorPosition -  $this->pointer);
        $value = substr($this->content, $separatorPosition + 1, $length);

        $this->pointer = $separatorPosition + $length + 1;

        return $value;
    }

    /**
     * Decode integer.
     *
     * @return int|float
     */
    private function decodeInteger()
    {
        $this->pointer++;

        $endPosition = strpos($this->content, self::DELIMITER_END, $this->pointer);
        $value = substr($this->content, $this->pointer, $endPosition - $this->pointer);

        if (strstr($value, '.')) {
            $value = (float) $value;
        } else {
            $value = (int) $value;
        }

        $this->pointer = $endPosition + 1;

        return $value;
    }

    /**
     * BDecode dictionary.
     *
     * @throws InvalidBencodedDelimiterException
     *
     * @return array
     */
    private function decodeDictionary()
    {
        $output = [];

        $this->pointer++;

        do {
            $key = $this->decodeString();
            $output[$key] = $this->process();
        } while ($this->getCurrentType() !== self::TYPE_END);

        $this->pointer++;

        return $output;
    }

    /**
     * Decode list.
     *
     * @throws InvalidBencodedDelimiterException
     *
     * @return array
     */
    private function decodeList()
    {
        $output = [];

        $this->pointer++;

        do {
            $output[] = $this->process();
        } while ($this->getCurrentType() !== self::TYPE_END);

        $this->pointer++;

        return $output;
    }
}
