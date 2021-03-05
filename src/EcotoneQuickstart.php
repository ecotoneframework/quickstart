<?php

namespace App;

use Ecotone\Messaging\Conversion\MediaType;
use Ecotone\Modelling\CommandBus;
use Ecotone\Modelling\QueryBus;

class EcotoneQuickstart
{
    private CommandBus $commandBus;
    private QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function run() : void
    {
        $this->commandBus->sendWithRouting(
            "product.register",
            ["productId" => 1, "cost" => 100],
            MediaType::APPLICATION_X_PHP_ARRAY
        );
        $this->commandBus->sendWithRouting(
            "product.register",
            ["productId" => 2, "cost" => 300]
        );

        $orderId = 990;
        $this->commandBus->sendWithRouting(
            "order.place",
            ["orderId" => $orderId, "productIds" => [1,2]]
        );

        echo $this->queryBus->sendWithRouting("order.getTotalPrice", ["orderId" => $orderId]);
    }
}