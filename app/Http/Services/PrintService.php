<?php

namespace App\Http\Services;

class PrintService
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function print($data)
    {
        $printer = $this->getPrinter();
        $printer->print($data);
    }
}