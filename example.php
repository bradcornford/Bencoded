<?php

require_once __DIR__ . "/vendor/autoload.php";

use Cornford\Bencoded\Bencoded;

$bencoded = new Bencoded();

$result = $bencoded->encode('foo bar');

var_dump($result);

$result = $bencoded->encode(123);

var_dump($result);

$result = $bencoded->encode(1.23);

var_dump($result);

$result = $bencoded->encode([1, 2, 3]);

var_dump($result);

$result = $bencoded->encode(['a' => 1, 'b' => 2, 'c' => 3]);

var_dump($result);

$class = new stdClass();
$class->a = 1;
$class->b = 2;
$class->c = 3;

$result = $bencoded->encode($class);

var_dump($result);
