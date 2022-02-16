<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwoInput extends Model
{
    use HasFactory;

    public function OneInput()
    {
        return $this->belongsTo(OneInput::class, 'one_input_id');
    }
}
