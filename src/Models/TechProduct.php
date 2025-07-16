<?php

namespace App\Models;

class TechProduct extends Product{

    protected function fetchAttributes(): void{

        $stmt = $this->db->prepare("
            SELECT 
                attr.id,
                attr.name,
                attr.type
            FROM attributes attr
            JOIN product_attributes pa ON attr.id = pa.attribute_id
            WHERE pa.product_id = ? AND attr.name IN('Capacity', 'Color', 'With USB 3 ports', 'Touch ID in keyboard')
        ");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        $attributesFromDB = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach($attributesFromDB as $attributeData){
            $this->attributes[] = Attribute::create($attributeData, $this->db);
        }
    }
}