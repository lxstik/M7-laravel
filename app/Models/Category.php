<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function index()
    {
        return Category::with('cards')->get(); // opcional
    }




    protected $fillable = ['name'];

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

}
