<?php

namespace App;

use App\Exceptions\ParametersException;

class ConsoleRequest
{
    private string $action;
    private string $userUuid;
    private array $commandArguments;

    public function __construct(array $arguments)
    {
        if (!isset($arguments[1]) || !in_array($arguments[1], $arguments)) {
            throw new ParametersException("First argument should be action");
        }

        $this->action = $arguments[1];

        if (!isset($arguments[2])) {
            throw new ParametersException('Second argument should be user UID');
        }

        $this->userUuid = $arguments[2];

        unset($arguments[0], $arguments[1], $arguments[2]);
        $restOfArguments = array_values($arguments);

        if (!$restOfArguments) {
            throw new ParametersException('Commands should have at least one argument');
        }

        $this->commandArguments = $restOfArguments;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getUserUuid(): string
    {
        return $this->userUuid;
    }

    public function getCommandArguments(): array
    {
        return $this->commandArguments;
    }
}