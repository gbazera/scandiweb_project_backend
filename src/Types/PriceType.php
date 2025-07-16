<?php

namespace App\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class PriceType extends ObjectType{

    public function __construct(){

        $config = [
            'name' => 'Price',
            'description' => 'A price in the store',
            'fields' => [
                'id' => Type::nonNull(Type::int()),
                'product_id' => Type::nonNull(Type::string()),
                'currency' => [
                    'type' => Types::currency(),
                    'resolve' => fn($price) => $price
                ],
                'amount' => Type::nonNull(Type::float()),
            ],
        ];

        parent::__construct($config);
    }
}