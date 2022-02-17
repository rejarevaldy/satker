<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneInput extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function TwoInput()
    {
        return $this->hasMany(TwoInput::class, 'one_input_id');
    }
}
