<?php

namespace App\Models;

use mysqli;

abstract class Attribute{

    protected int $id;
    protected string $name;
    protected string $type;
    protected array $items = [];

    public function __construct(array $data, mysqli $db){
        
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->type = $data['type'];

        $this->fetchItems($db);
    }

    private function fetchItems(mysqli $db): void{

        $stmt = $db->prepare("SELECT id, value, display_value FROM attribute_items WHERE attribute_id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();

        $this->items = $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function create(array $data, mysqli $db): Attribute{

        if($data['type'] === 'swatch'){
            return new SwatchAttribute($data, $db);
        }

        return new TextAttribute($data, $db);
    }

    public abstract function getDisplayType(): string;

    public function getId(): int{

        return $this->id;
    }

    public function getName(): string{

        return $this->name;
    }

    public function getType(): string{

        return $this->type;
    }

    public function getItems(): array{

        return $this->items;
    }
}