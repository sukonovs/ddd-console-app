<?php

namespace App;

use App\Exceptions\ParametersException;
use App\Service\AddShippingAddressService;
use App\Service\RemoveShippingAddressService;
use App\Service\UpdateShippingAddressService;

class App
{
    const ACTION__ADD = 'add';
    const ACTION__REMOVE = 'remove';
    const ACTION__UPDATE = 'update';

    private array $allowedActions = [
        self::ACTION__ADD,
        self::ACTION__REMOVE,
        self::ACTION__UPDATE,
    ];

    private AddShippingAddressService $addShippingAddressService;
    private RemoveShippingAddressService $removeShippingAddressService;
    private UpdateShippingAddressService $updateShippingAddressService;

    public function __construct(
        AddShippingAddressService $addShippingAddressService,
        RemoveShippingAddressService $removeShippingAddressService,
        UpdateShippingAddressService $updateShippingAddressService)
    {
        $this->addShippingAddressService = $addShippingAddressService;
        $this->removeShippingAddressService = $removeShippingAddressService;
        $this->updateShippingAddressService = $updateShippingAddressService;
    }

    public function run(ConsoleRequest $request): ConsoleResponse
    {
        //NOTE: Some service discovery here could be nice addition to this.
        switch ($request->getAction()) {
            case static::ACTION__ADD:
                $serviceRequest = new AddShippingAddressRequest($request->getCommandArguments());
                $this->addShippingAddressService->execute($request->getUserUuid(), $serviceRequest);

                return new ConsoleResponse('Shipping address has been added');
            case static::ACTION__UPDATE:
                $serviceRequest = new UpdateShippingAddressRequest($request->getCommandArguments());
                $this->updateShippingAddressService->execute($request->getUserUuid(), $serviceRequest);

                return new ConsoleResponse('Shipping address has been updated');
            case static::ACTION__REMOVE:
                $serviceRequest = new RemoveShippingAddressRequest($request->getCommandArguments());
                $this->removeShippingAddressService->execute($request->getUserUuid(), $serviceRequest);

                return new ConsoleResponse('Shipping address has been removed');
            default:
                throw new ParametersException(
                    sprintf("Invalid action. Allowed: %s", implode(', ', $this->allowedActions))
                );
        }
    }
}