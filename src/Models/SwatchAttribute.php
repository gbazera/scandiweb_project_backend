<?php

namespace App\Models;

class SwatchAttribute extends Attribute{

    public function getDisplayType(): string{
        
        return 'swatch';
    }
}