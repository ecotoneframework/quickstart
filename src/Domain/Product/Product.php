<?php

namespace App\Domain\Product;

use App\Infrastructure\AddUserId\AddUserId;
use App\Infrastructure\RequireAdministrator\RequireAdministrator;
use Ecotone\Modelling\Attribute\Aggregate;
use Ecotone\Modelling\Attribute\AggregateIdentifier;
use Ecotone\Modelling\Attribute\CommandHandler;
use Ecotone\Modelling\Attribute\QueryHandler;
use Ecotone\Modelling\WithAggregateEvents;

#[Aggregate]
#[AddUserId]
class Product
{
    use WithAggregateEvents;

    #[AggregateIdentifier]
    private int $productId;

    private Cost $cost;

    private int $userId;

    private function __construct(int $productId, Cost $cost, int $userId)
    {
        $this->productId = $productId;
        $this->cost = $cost;
        $this->userId = $userId;

        $this->recordThat(new ProductWasRegisteredEvent($productId));
    }

    #[CommandHandler("product.register")]
    #[RequireAdministrator]
    public static function register(RegisterProductCommand $command, array $metadata) : self
    {
        return new self($command->getProductId(), $command->getCost(), $metadata["userId"]);
    }

    #[CommandHandler("product.changePrice")]
    #[RequireAdministrator]
    public function changePrice(ChangePriceCommand $command) : void
    {
        $this->cost = $command->getCost();
    }

    #[QueryHandler("product.getCost")]
    public function getCost(GetProductPriceQuery $query) : Cost
    {
        return $this->cost;
    }
}