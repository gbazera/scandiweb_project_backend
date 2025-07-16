<?php

namespace App\Models;

class TextAttribute extends Attribute{

    public function getDisplayType(): string{
        
        return 'text';
    }
}