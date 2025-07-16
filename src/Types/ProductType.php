<?php

namespace App\Types;

use App\Models\Product;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ProductType extends ObjectType{

    public function __construct(){

        $config = [
            'name' => 'Product',
            'description' => 'A product in the store',
            'fields' => [
                'id' => [
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => fn(Product $product) => $product->id
                ],
                'name' => [
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => fn(Product $product) => $product->name
                ],
                'description' => [
                    'type' => Type::string(),
                    'resolve' => fn(Product $product) => $product->description
                ],
                'in_stock' => [
                    'type' => Type::nonNull(Type::boolean()),
                    'resolve' => fn(Product $product) => $product->in_stock
                ],
                'category_id' => [
                    'type' => Type::nonNull(Type::int()),
                    'resolve' => fn(Product $product) => $product->category_id
                ],
                'brand' => [
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => fn(Product $product) => $product->brand
                ],
                'attributes' => [
                    'type' => Type::listOf(Types::attribute()),
                    'resolve' => fn(Product $product) => $product->attributes
                ],
                'prices' => [
                    'type' => Type::listOf(Types::price()),
                    'resolve' => fn(Product $product) => $product->prices
                ],
                'gallery' => [
                    'type' => Type::listOf(Type::string()),
                    'resolve' => fn(Product $product) => $product->gallery
                ]
            ],
        ];

        parent::__construct($config);
    }
}