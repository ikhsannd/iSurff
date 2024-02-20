<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = ['user_id', 'id_kategori', 'kode_produk', 'nama_produk', 'merk', 'harga_beli', 'diskon', 'harga_jual', 'stok','desc','photo'];

    protected $appends = [
        'photo',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'produk_id');
    }
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'produk_id');
    }
    public function stok()
    {
        return $this->hasMany(Stok::class);
    }
    public function acc_penjualan()
    {
        return $this->hasMany(AccPenjualan::class);
    }
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
    public function getPhotoAttribute()
    {
        // Assuming 'photo' is the name of the attribute in your database
        // Adjust the path accordingly based on your database structure
        $photoPath = $this->attributes['photo'];

        // Assuming you store photos in the 'storage/app/public' directory
        return asset('storage/' . $photoPath);
    }
}
