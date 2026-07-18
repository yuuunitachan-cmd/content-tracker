<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKonten extends Model
{
    use HasFactory;

    /**
     * Tabel database yang digunakan model ini
     */
    protected $table = 'jenis_konten';

    /**
     * Attribute yang bisa di-fill mass assignment
     */
    protected $fillable = [
        'nama',
    ];

    /**
     * Relationship: Satu JenisKonten bisa punya banyak Postingan
     */
    public function postingan()
    {
        return $this->hasMany(Postingan::class, 'jenis_konten_id');
    }
}