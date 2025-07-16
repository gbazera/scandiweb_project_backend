<?php

namespace App\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CurrencyType extends ObjectType{

    public function __construct(){

        $config = [
            'name' => 'Currency',
            'description' => 'A currency in the store',
            'fields' => [
                'id' => Type::nonNull(Type::int()),
                'label' => Type::nonNull(Type::string()),
                'symbol' => Type::nonNull(Type::string()),
            ],
        ];

        parent::__construct($config);
    }
}