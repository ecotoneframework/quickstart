<?php


namespace App\Domain\Product;


class GetProductPriceQuery
{
    private int $productId;

    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }

    public function getProductId() : int
    {
        return $this->productId;
    }
}