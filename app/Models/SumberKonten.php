<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SumberKonten extends Model
{
    use HasFactory;

    /**
     * Tabel database yang digunakan model ini
     */
    protected $table = 'sumber_konten';

    /**
     * Attribute yang bisa di-fill mass assignment
     */
    protected $fillable = [
        'nama',
    ];

    /**
     * Relationship: Satu SumberKonten bisa punya banyak Postingan
     */
    public function postingan()
    {
        return $this->hasMany(Postingan::class, 'sumber_konten_id');
    }
}