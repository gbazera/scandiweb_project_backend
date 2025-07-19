<?php

namespace App\Types;

use App\Models\Attribute;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class AttributeType extends ObjectType{

    public function __construct(){

        $config = [
            'name' => 'Attribute',
            'description' => 'An attribute in the store',
            'fields' => [
                'id' => [
                    'type' => Type::nonNull(Type::int()),
                    'resolve' => fn(Attribute $attr) => $attr->getId()
                ],
                'name' => [
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => fn(Attribute $attr) => $attr->getName()
                ],
                'type' => [
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => fn(Attribute $attr) => $attr->getType()
                ],
                'items' => [
                    'type' => Type::listOf(new AttributeItemType()),
                    'resolve' => fn(Attribute $attr) => $attr->getItems()
                ]
            ],
        ];

        parent::__construct($config);
    }
}