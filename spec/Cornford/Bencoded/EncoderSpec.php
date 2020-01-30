<?php namespace spec\Cornford\Bencoded;

use Cornford\Bencoded\Contracts\EncodableInterface;
use Cornford\Bencoded\Exceptions\InvalidEncodeInputException;
use PhpSpec\ObjectBehavior;
use stdClass;

class EncoderSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith();
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Cornford\Bencoded\Contracts\EncodableInterface');
    }

    public function it_should_encode_a_string()
    {
        $input = 'value';
        $this->encode($input)->shouldReturn('5:value');
    }

    public function it_should_encode_an_integer()
    {
        $input = 123;
        $this->encode($input)->shouldReturn('i123e');
    }

    public function it_should_encode_a_double()
    {
        $input = 1.23;
        $this->encode($input)->shouldReturn('i1.23e');
    }

    public function it_should_encode_an_numerically_keyed_array()
    {
        $input = ['value'];
        $this->encode($input)->shouldReturn('l5:valuee');
    }

    public function it_should_encode_an_alphabetically_keyed_array()
    {
        $input = ['key' => 'value'];
        $this->encode($input)->shouldReturn('d3:key5:valuee');
    }

    public function it_should_encode_an_object()
    {
        $input = new stdClass();
        $input->key = 'value';
        $this->encode($input)->shouldReturn('d3:key5:valuee');
    }

    public function it_should_encode_an_object_numerically_keyed_with_a_toarray_method()
    {
        $input = new NumericallyKeyedObject();
        $this->encode($input)->shouldReturn('l5:valuee');
    }

    public function it_should_encode_an_object_alphabetically_keyed_with_a_toarray_method()
    {
        $input = new AlphabeticallyKeyedObject();
        $this->encode($input)->shouldReturn('d3:key5:valuee');
    }

    public function it_should_throw_an_exception_with_a_null_input()
    {
        $input = null;
        $this->shouldThrow('Cornford\Bencoded\Exceptions\InvalidEncodeInputException')->during('encode', [$input]);
    }

    public function it_should_throw_an_exception_with_a_boolean_input()
    {
        $input = false;
        $this->shouldThrow('Cornford\Bencoded\Exceptions\InvalidEncodeInputException')->during('encode', [$input]);
    }
}

class NumericallyKeyedObject {
    public function toArray()
    {
        return [
            'value'
        ];
    }
}

class AlphabeticallyKeyedObject {
    public function toArray()
    {
        return [
            'key' => 'value'
        ];
    }
}