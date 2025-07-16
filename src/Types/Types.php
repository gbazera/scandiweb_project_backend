<?php

namespace App\Types;

class Types{

    private static $product;
    private static $category;
    private static $attribute;
    private static $price;
    private static $currency;
    private static $order;

    public static function product(): ProductType{
        return self::$product ?: (self::$product = new ProductType());
    }

    public static function category(): CategoryType{
        return self::$category ?: (self::$category = new CategoryType());
    }

    public static function attribute(): AttributeType{
        return self::$attribute ?: (self::$attribute = new AttributeType());
    }

    public static function price(): PriceType{
        return self::$price ?: (self::$price = new PriceType());
    }

    public static function currency(): CurrencyType{
        return self::$currency ?: (self::$currency = new CurrencyType());
    }

    public static function order(): OrderType{
        return self::$order ?: (self::$order = new OrderType());
    }
}