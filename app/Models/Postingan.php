<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postingan extends Model
{
    use HasFactory;

    /**
     * Tabel database yang digunakan model ini
     */
    protected $table = 'postingan';

    /**
     * Attribute yang bisa di-fill mass assignment (dibuat dari form)
     */
    protected $fillable = [
        'user_id',
        'link',
        'judul',
        'jenis_konten_id',
        'sumber_konten_id',
        'hashtag',
    ];

    /**
     * Attribute yang di-cast ke tipe data tertentu
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Postingan milik satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship: Postingan memiliki satu JenisKonten
     */
    public function jenisKonten()
    {
        return $this->belongsTo(JenisKonten::class, 'jenis_konten_id');
    }

    /**
     * Relationship: Postingan memiliki satu SumberKonten
     */
    public function sumberKonten()
    {
        return $this->belongsTo(SumberKonten::class, 'sumber_konten_id');
    }
}