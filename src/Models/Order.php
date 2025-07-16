<?php

namespace App\Models;

use mysqli;

class Order{

    public static function create(array $items, float $total, mysqli $db): bool{

        $db->begin_transaction();

        try{

            $stmt = $db->prepare("INSERT INTO orders(total) VALUES(?)");
            $stmt->bind_param("d", $total);
            $stmt->execute();

            $order_id = $db->insert_id;

            $item_stmt = $db->prepare("
                INSERT INTO order_items(order_id, product_id, quantity, price, attributes) VALUES(?, ?, ?, ?, ?)
            ");

            foreach($items as $item){

                $product_id = $item['product_id'];
                $quantity = $item['quantity'];
                $price = $item['price'];
                $attributes = json_encode($item['attributes']);

                $item_stmt->bind_param("isids", $order_id, $product_id, $quantity, $price, $attributes);
                $item_stmt->execute();
            }

            $db->commit();
            return true;

        } catch(\Exception $e){

            $db->rollback();
            error_log("[!] order creation failed: " . $e->getMessage());
            return false;
        }
    }
}