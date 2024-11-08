<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Nama tipe kategori
    ];

    /**
     * Define a relationship with the Categorie model.
     */
    public function categories()
    {
        return $this->hasMany(Categorie::class);
    }
}
