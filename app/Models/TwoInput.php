<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwoInput extends Model
{
    use HasFactory;
    
    protected $guarded = [
        'id'
    ];

    // protected $fillable = [
    //     'volume_capaian',
    //     'uraian',
    //     'nomor_dokumen',
    //     'tanggal',
    //     'one_input_id',
    //     'file_dokumen'
    // ];

    public function OneInput()
    {
        return $this->belongsTo(OneInput::class, 'one_input_id');
    }
}
