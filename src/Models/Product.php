<?php

namespace App\Models;

use mysqli;

abstract class Product{

    public string $id;
    public string $name;
    public string $description;
    public bool $in_stock;
    public int $category_id;
    public string $brand;
    public array $attributes = [];
    public array $prices = [];
    public array $gallery = [];

    protected mysqli $db;

    public function __construct(array $data, mysqli $db){
        
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->in_stock = $data['in_stock'];
        $this->category_id = $data['category_id'];
        $this->brand = $data['brand'];

        $this->db = $db;

        $this->fetchAttributes();
        $this->fetchPrices();
        $this->fetchGallery();
    }

    public static function create(array $data, mysqli $db): Product{

        if(isset($data['category_name']) && $data['category_name'] === 'tech'){

            return new TechProduct($data, $db);
        }

        return new ClothingProduct($data, $db);
    }

    public static function find(string $id, mysqli $db): ?Product{

        $stmt = $db->prepare("
            SELECT p.*, c.name AS category_name
            FROM products p
            JOIN categories c ON p.category_id = c.id
            WHERE p.id = ?
        ");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $product_data = $stmt->get_result()->fetch_assoc();

        if($product_data){
            return self::create($product_data, $db);
        }

        return null;
    }

    abstract protected function fetchAttributes(): void;

    private function fetchPrices(): void{

        $stmt = $this->db->prepare("
            SELECT pp.amount, c.label, c.symbol
            FROM product_prices pp
            JOIN currencies c ON pp.currency_id = c.id
            WHERE pp.product_id = ?
        ");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();

        $this->prices = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    private function fetchGallery(): void{

        $stmt = $this->db->prepare("SELECT image_url FROM product_gallery WHERE product_id = ?");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();

        $this->gallery = array_column($stmt->get_result()->fetch_all(MYSQLI_ASSOC), 'image_url');
    }
}