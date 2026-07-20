<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute; // Ditambahkan untuk penulisan mutator modern

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
        'tagar',
    ];

    /**
     * Attribute yang di-cast ke tipe data tertentu
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * BUG FIX 1: Mutator untuk otomatis mengubah hashtag menjadi lowercase
     * Mencegah pecahnya filter dashboard akibat perbedaan kapitalisasi data input (misal: #Flyover vs #flyover).
     */
    /**
     * Compatibility accessors for the form field named `hashtag`.
     * Underlying database column is `tagar` (existing migration).
     */
    public function getHashtagAttribute()
    {
        return $this->attributes['tagar'] ?? null;
    }

    public function setHashtagAttribute($value)
    {
        $this->attributes['tagar'] = is_null($value) ? null : strtolower(trim($value));
    }

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