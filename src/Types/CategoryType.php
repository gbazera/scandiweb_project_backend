<?php

namespace App\Types;

use App\Types\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CategoryType extends ObjectType{

    public function __construct(){

        $config = [
            'name' => 'Category',
            'description' => 'A category in the store',
            'fields' => [
                'id' => Type::nonNull(Type::int()),
                'name' => Type::nonNull(Type::string()),
                'products' => [
                    'type' => Type::listOf(Types::product()),
                    'resolve' => static fn($category) => $category['products']
                ]
            ],
        ];

        parent::__construct($config);
    }
}