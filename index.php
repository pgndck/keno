<?php

namespace Keno;

require __DIR__ . '/vendor/autoload.php';

use Keno\PlayingCardPrinter as Printer;


error_reporting(-1);
ini_set('display_errors', 'On');


$printer = new Printer(48);
$printer->print();