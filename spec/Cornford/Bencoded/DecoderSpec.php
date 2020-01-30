<?php namespace spec\Cornford\Bencoded;

use Cornford\Bencoded\Contracts\DecodableInterface;
use Cornford\Bencoded\Exceptions\InvalidBencodedDelimiterException;
use PhpSpec\ObjectBehavior;

class DecoderSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith();
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(DecodableInterface::class);
    }

    public function it_should_encode_a_string()
    {
        $input = '5:value';
        $this->decode($input)->shouldReturn('value');
    }

    public function it_should_encode_an_integer()
    {
        $input = 'i123e';
        $this->decode($input)->shouldReturn(123);
    }

    public function it_should_encode_a_double()
    {
        $input = 'i1.23e';
        $this->decode($input)->shouldReturn(1.23);
    }

    public function it_should_encode_an_numerically_keyed_array()
    {
        $input = 'l5:valuee';
        $this->decode($input)->shouldReturn(['value']);
    }

    public function it_should_encode_an_alphabetically_keyed_array()
    {
        $input = 'd3:key5:valuee';
        $this->decode($input)->shouldReturn(['key' => 'value']);
    }

    public function it_should_encode_an_object()
    {
        $input = 'd3:key5:valuee';
        $this->decode($input)->shouldReturn(['key' => 'value']);
    }

    public function it_should_throw_an_exception_with_a_null_input()
    {
        $input = null;
        $this->shouldThrow(InvalidBencodedDelimiterException::class)->during('decode', [$input]);
    }

    public function it_should_throw_an_exception_with_a_boolean_input()
    {
        $input = false;
        $this->shouldThrow(InvalidBencodedDelimiterException::class)->during('decode', [$input]);
    }
}
