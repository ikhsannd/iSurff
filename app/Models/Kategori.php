<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $guarded = [];

    protected $fillable = ['user_id', 'nama_kategori'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function produk()
    {
        return $this->hasMany(Produk::class);
    }
}
