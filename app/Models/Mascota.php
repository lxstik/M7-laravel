<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    use HasFactory;

    protected $table = 'mascotas';
    protected $fillable = [
        'nombre',
        'imagen',
        'tipo',
        'user_id'
    ];

    public function usuario(){
        return $this->belongsTo(User::class);
    }

}
