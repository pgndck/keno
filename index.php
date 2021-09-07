<?php

namespace Keno;

require __DIR__ . '/vendor/autoload.php';

use Keno\PlayingCardPrinter as Printer;

$printer = new Printer(48);
$printer->print();