<?php

namespace App\Domain\Product;

use Ecotone\Modelling\Attribute\Repository;
use Ecotone\Modelling\StandardRepository;

#[Repository]
class ProductRepository implements StandardRepository
{
    /**
     * @var Product[]
     */
    private $products;

    public function canHandle(string $aggregateClassName): bool
    {
        return $aggregateClassName === Product::class;
    }

    public function findBy(string $aggregateClassName, array $identifiers): ?object
    {
        if (!array_key_exists($identifiers["productId"], $this->products)) {
            return null;
        }

        return $this->products[$identifiers["productId"]];
    }

    public function save(array $identifiers, object $aggregate, array $metadata, ?int $expectedVersion): void
    {
        $this->products[$identifiers["productId"]] = $aggregate;
    }
}