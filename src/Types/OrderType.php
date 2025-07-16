<?php

namespace App\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class OrderType extends ObjectType{

    public function __construct(){

        $config = [
            'name' => 'Order',
            'description' => 'An order in the store',
            'fields' => [
                'success' => [
                    'type' => Type::nonNull(Type::boolean()),
                    'description' => 'whether the order was successfully created.',
                ],
                'message' => [
                    'type' => Type::string(),
                    'description' => 'a confirmation message for the order.',
                ]
            ],
        ];

        parent::__construct($config);
    }
}