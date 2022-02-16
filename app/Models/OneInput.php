<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneInput extends Model
{
    use HasFactory;

    public function TwoInput()
    {
        $this->hasMany(TwoInput::class, 'one_input_id');
    }
}
