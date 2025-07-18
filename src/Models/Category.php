<?php

namespace App\Models;

use mysqli;

use App\Models\Product;

class Category{

    //fetch all categories
    public static function fetchAll(mysqli $db): array{

        $result = $db->query("SELECT name FROM categories");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //fetch a single category by its name
    public static function find(string $name, mysqli $db): ?array{

        $stmt = $db->prepare("SELECT * FROM categories WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $category = $result->fetch_assoc();

        if($category){

            $rawProduct = [];

            if($name === 'all'){
                $productStmt = $db->prepare("
                    SELECT p.*, c.name AS category_name
                    FROM products p
                    JOIN categories c ON p.category_id = c.id
                ");
            }else{
                $productStmt = $db->prepare("
                    SELECT p.*, c.name AS category_name
                    FROM products p
                    JOIN categories c ON p.category_id = c.id
                    WHERE p.category_id = ?
                ");
                $productStmt->bind_param("i", $category['id']);
            }

            $productStmt->execute();
            $rawProducts = $productStmt->get_result()->fetch_all(MYSQLI_ASSOC);

            $category['products'] = [];

            foreach($rawProducts as $rawProduct){
                $category['products'][] = Product::create($rawProduct, $db);
            }
        }

        return $category;
    }
}