<?php

namespace App\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class AttributeItemType extends ObjectType{

    function __construct(){
        
        $config = [
            'name' => 'AttributeItemType',
            'fields' => [
                'id' => Type::string(),
                'value' => Type::string(),
                'display_value' => Type::string(),
            ]
        ];
        parent::__construct($config);
    }
}