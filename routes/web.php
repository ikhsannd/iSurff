<?php

use App\Http\Controllers\{
    DashboardController,
    FrontController,
    KategoriController,
    KeranjangController,
    LaporanController,
    ProdukController,
    MemberController,
    PengeluaranController,
    PembelianController,
    PembelianDetailController,
    PenjualanController,
    PenjualanDetailController,
    RoleController,
    SettingController,
    SupplierController,
    UserController,
};
use App\Http\Controllers\AccPenjualanController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StokController;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/send-register', [RegisterController::class, 'store'])->name('send-register');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['middleware' => 'role_id:1'], function () {
        Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
        Route::resource('/kategori', KategoriController::class);

        Route::get('/kategori/show', [ProdukController::class, 'showKategori'])->name('kategori.show');
        Route::get('/produk/data', [ProdukController::class, 'data'])->name('produk.data');
        Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
        Route::post('/produk/delete-selected', [ProdukController::class, 'deleteSelected'])->name('produk.delete_selected');
        Route::post('/produk/cetak-barcode', [ProdukController::class, 'cetakBarcode'])->name('produk.cetak_barcode');
        Route::resource('/produk', ProdukController::class);

        Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
        Route::resource('/supplier', SupplierController::class);

        Route::get('/pengeluaran/data', [PengeluaranController::class, 'data'])->name('pengeluaran.data');
        Route::resource('/pengeluaran', PengeluaranController::class);

        Route::get('/pembelian/data', [PembelianController::class, 'data'])->name('pembelian.data');
        Route::get('/pembelian/{id}/create', [PembelianController::class, 'create'])->name('pembelian.create');
        Route::resource('/pembelian', PembelianController::class)
            ->except('create');

        Route::get('/pembelian_detail/{id}/data', [PembelianDetailController::class, 'data'])->name('pembelian_detail.data');
        Route::get('/pembelian_detail/loadform/{diskon}/{total}', [PembelianDetailController::class, 'loadForm'])->name('pembelian_detail.load_form');
        Route::resource('/pembelian_detail', PembelianDetailController::class)
            ->except('create', 'show', 'edit');

        Route::get('/penjualan/data', [PenjualanController::class, 'data'])->name('penjualan.data');
        Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
        Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
        Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');

        Route::get('/acc-penjualan', [AccPenjualanController::class, 'Index'])->name('accpenjualan');
        Route::get('/tambah-accpenjualan', [AccPenjualanController::class, 'Tambah'])->name('tambahaccpenjualan');
        Route::get('/edit-accpenjualan/{id}', [AccPenjualanController::class, 'Edit'])->name('edit-accpenjualan');
        Route::post('/update-accpenjualan/{id}', [AccPenjualanController::class, 'Update'])->name('update-accpenjualan');
        Route::DELETE('/delete-accpenjualan/{id}', [AccPenjualanController::class, 'Delete'])->name('delete-accpenjualan');
        Route::get('/role', [RoleController::class, 'index'])->name('role.index');
        Route::get('/role/baru', [RoleController::class, 'create'])->name('role.create');
        Route::post('/role/simpan', [RoleController::class, 'store'])->name('role.simpan');
        // Route::post('/role/update/{id}', [RoleController::class, 'update'])->name('role.update');
        Route::delete('/role/delete/{id}', [RoleController::class, 'destroy'])->name('role.delete');
        Route::resource('/role', RoleController::class);

        Route::get('/member/data', [MemberController::class, 'data'])->name('member.data');
        Route::post('/member/cetak-member', [MemberController::class, 'cetakMember'])->name('member.cetak_member');
        Route::resource('/member', MemberController::class);
        Route::get('/transaksi/baru', [PenjualanController::class, 'create'])->name('transaksi.baru');
        Route::post('/transaksi/simpan', [PenjualanController::class, 'store'])->name('transaksi.simpan');
        Route::get('/transaksi/selesai', [PenjualanController::class, 'selesai'])->name('transaksi.selesai');
        Route::get('/transaksi/nota-kecil', [PenjualanController::class, 'notaKecil'])->name('transaksi.nota_kecil');
        Route::get('/transaksi/nota-besar', [PenjualanController::class, 'notaBesar'])->name('transaksi.nota_besar');

        Route::get('/transaksi/{id}/data', [PenjualanDetailController::class, 'data'])->name('transaksi.data');
        Route::get('/transaksi/loadform/{diskon}/{total}/{diterima}', [PenjualanDetailController::class, 'loadForm'])->name('transaksi.load_form');
        Route::resource('/transaksi', PenjualanDetailController::class)
            ->except('create', 'show', 'edit');
    });

    Route::group(['middleware' => 'role_id:1'], function () {
        Route::resource('/stok', StokController::class);

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/data/{awal}/{akhir}', [LaporanController::class, 'data'])->name('laporan.data');
        Route::get('/laporan/pdf/{awal}/{akhir}', [LaporanController::class, 'exportPDF'])->name('laporan.export_pdf');

        Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
        Route::resource('/user', UserController::class);

        Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
        Route::get('/setting/first', [SettingController::class, 'show'])->name('setting.show');
        Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');
    });

    Route::group(['middleware' => 'role_id:1'], function () {
        Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
        Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');
    });
});

Route::group(['middleware' => 'role_id:1,2'], function () {
    Route::get('/front/cart', [FrontController::class, 'cart'])->name('front.cart');

    Route::get('/front/pesanan', [FrontController::class, 'pesanan'])->name('front.pesanan');
    
    Route::get('/produk/detail/{id}', [FrontController::class, 'detailcontent'])->name('produk.detail');
    Route::post('/send-accpenjualan/{id}', [AccPenjualanController::class, 'Send'])->name('send-accpenjualan');
    Route::post('/add-accpenjualan/{id}', [AccPenjualanController::class, 'add'])->name('add-accpenjualan');

    Route::get('/cart/add/{id}', [KeranjangController::class, 'addcart'])->name('cart.add');
    Route::post('/cart/update/{id}', [KeranjangController::class, 'updatecart'])->name('cart.update');
    Route::delete('/delete/{cartItem}', [KeranjangController::class, 'destroy'])->name('cart.destroy');

    Route::get('/profile', [FrontController::class, 'profile'])->name('index.profile');
    Route::get('/profile/orders', [FrontController::class, 'showorders'])->name('profile.orders');

    Route::put('/profile/update/{id}', [UserController::class, 'updateuser'])->name('profile.update');

    Route::get('/wishlist', [FrontController::class, 'wishlist'])->name('wishlist.index');
    Route::get('/wishlist/add/{id}', [FrontController::class, 'addwishlist'])->name('wishlist.add');
    Route::delete('delete/wishlist/{item}', [FrontController::class, 'deleteWishlist'])->name('wishlist.destroy');


    
    Route::get('/success/{id}', [FrontController::class, 'successPage'])->name('success.page');
    
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
});
Route::get('/', [FrontController::class, 'catalog'])->name('front.index');
Route::get('/catalogue', [FrontController::class, 'index'])->name('catalog.index');
