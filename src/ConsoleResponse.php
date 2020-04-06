<?php


namespace App;

class ConsoleResponse
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function __toString()
    {
        return $this->message;
    }
}