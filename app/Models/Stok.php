<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stoks';

    protected $guarded = [];

    protected $fillable = ['user_id','produk_id', 'stok_masuk','tanggal','keterangan'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
