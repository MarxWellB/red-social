<?php

use App\Http\Controllers\ImagenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\OnlinestoreController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DenunciaController;

Route::get('/managment-personalizate', [AdminController::class,'managmentPersonalizate'])->name('admin.PersonalizateManagmente');
Route::post('/admin/update-promotion-hours', [AdminController::class, 'updatePromotionHours'])->name('admin.updatePromotionHours');


Route::get('/admin/limit-promos', [AdminController::class, 'limit'])->name('admin.limit');
Route::get('/accounts-profile/download', [AdminController::class, 'profileCache'])->name('admin.profileCache');
Route::post('/adminpromotions/create', [AdminController::class, 'promcreate'])->name('admin.promcreate');
Route::post('/admin/promotions/{id}/start', [AdminController::class, 'startPromotion'])->name('admin.startPromotion');
Route::post('/admin/promotions/{id}/pause', [AdminController::class, 'pausePromotion'])->name('admin.pausePromotion');
Route::post('/admin/promotions/{id}/end', [AdminController::class, 'endPromotion'])->name('admin.endPromotion');
Route::get('/managment-basic', [AdminController::class,'managmentBasic'])->name('admin.BasicManagment');
Route::delete('/posts/Deletecache', [AdminController::class, 'deleteCache'])->name('posts.deleteCache');
Route::delete('/admin/delete-cache', [Admincontroller::class, 'deleteLeastViewedCache'])->name('admin.deleteCache');

Route::get('/download', [ImagenController::class, 'descargar'])->name('descargar');
Route::get('/tags/{tag:name}',[TagController::class,'show'])->name('tag.show');//////////////////////////////////////////
Route::get('/promotionation', [AdminController::class, 'promotionar'])->name('admin.promotionarr');
Route::get('/edit', [PerfilController::class,'index'])->name('perfil.index');
Route::post('/edit', [PerfilController::class,'store'])->name('perfil.store');
Route::get('/models', [PerfilController::class,'showmodels'])->name('perfil.show');
Route::get('/models/filter/{filtro}', [PerfilController::class,'showmodelsf'])->name('perfil.showf');
Route::get('/promotions', [InformationController::class, 'prom'])->name('info.prom');
Route::post('/promotions/create', [InformationController::class, 'promcreate'])->name('info.promcreate');
Route::put('/promotions/{id}/send', [AdminController::class, 'promocionarA'])->name('admin.promocionarA');
Route::post('/promotions/createu', [InformationController::class, 'promcreateu'])->name('info.promcreateu');
Route::put('/promotions/req/{id}/send', [AdminController::class, 'promocionarR'])->name('admin.promocionarR');
Route::get('/terms-and-conditions', [InformationController::class, 'tyc'])->name('info.tyc');
Route::get('/privacy-policy', [InformationController::class, 'pol'])->name('info.pol');
Route::get('/questions', [InformationController::class, 'fqa'])->name('info.fq&a');
Route::get('/add-accounts', [InformationController::class, 'addac'])->name('info.addac');
Route::post('/add-accounts/add', [InformationController::class, 'addstore'])->name('info.addstore');
Route::get('/remove-accounts', [InformationController::class, 'remac'])->name('info.remac');
Route::post('/remove-accounts/del', [InformationController::class, 'remacdel'])->name('info.remacdel');
Route::get('/support', [InformationController::class, 'support'])->name('info.suport');
Route::post('/support/send', [InformationController::class, 'supportStore'])->name('info.suportStore');
Route::get('/support-request', [AdminController::class, 'supportReq'])->name('info.supportReq');
Route::put('/support-request/{id}/send', [AdminController::class, 'supportUpdate'])->name('info.suportUpdate');
Route::get('/adder-acount', [AdminController::class, 'adder'])->name('admin.adder');
Route::put('/adder-acount/{id}/send', [AdminController::class, 'adderStatus'])->name('admin.adderStatus');
Route::get('/remove-sol', [AdminController::class, 'remover'])->name('admin.remover');
Route::put('/remove-sol/{id}/send', [AdminController::class, 'removerStatus'])->name('admin.removerStatus');
Route::get('/promotion-sol', [AdminController::class, 'promotion'])->name('admin.promotion');
Route::put('/promotion-sol/{id}/send', [AdminController::class, 'promotionStatus'])->name('admin.promotionStatus');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|


Route::get('/', function () {
    return view('principal');
}); 
*/
Route::get('/discounts/create', [AdminController::class, 'createDes'])->name('descuentos.create');
Route::post('/discounts/create/store', [AdminController::class, 'storeDes'])->name('descuentos.store');

Route::get('/promos/index', [AdminController::class, 'indexProm'])->name('promos.index');
Route::post('/promos/index/store', [AdminController::class, 'storeProm'])->name('promos.store');
Route::get('/promos/acounts/create', [AdminController::class, 'acounts'])->name('promos.acounts');
Route::post('/promos/acounts/create/store', [AdminController::class, 'storeA'])->name('promos.storeA');

Route::get('/politics', [InformationController::class, 'politics'])->name('info.politics');

Route::get('/dashboard', [AdminController::class,'index'])->name('admin.dashboard');

Route::get('/dashboard/posts', [AdminController::class,'indexposts'])->name('admin.posts');
Route::get('/dashboard/acounts', [AdminController::class,'indexacounts'])->name('admin.acounts');
Route::get('/dashboard/tags', [AdminController::class,'indextags'])->name('admin.tags');
Route::put('/dashboard/posts/{post}/enable', [AdminController::class, 'enablePost'])->name('admin.posts.enable');
Route::get('/dashboard/posts/b/{post}', [AdminController::class, 'seePosts'])->name('admin.seeposts');
Route::put('/dashboard/users/{user}/enable', [AdminController::class, 'enableUser'])->name('admin.users.enable');
Route::get('/dashboard/users/{user:username}', [AdminController::class, 'seeUser'])->name('admin.seeuser');
Route::put('/dashboard/tags/{tag}/enable', [AdminController::class, 'enableTag'])->name('admin.tags.enable');
Route::put('/{post}/report', [DenunciaController::class, 'depost'])->name('denuncia.post'); 
Route::put('/u/{user:username}/report', [DenunciaController::class, 'deuser'])->name('denuncia.user');

Route::put('/tags/{tag:name}/report', [DenunciaController::class, 'detag'])->name('denuncia.tag');



Route::get('/u/{user:username}',[PostController::class,'index'])->name('posts.index');///////////////////////////////////////////
Route::get('/', [PostController::class,'principal'])->name('posts.principal');//////////////////////////////////////////////////////////
Route::post('/tagcreatesinaccesoaun15936', [TagController::class, 'store'])->name('tag.store');
Route::get('/taglistsinaccesoaun15936', [TagController::class, 'index'])->name('tag.index');
Route::put('/tagupdatesinaccesoaun15936/update', [TagController::class, 'update'])->name('tag.update');


Route::get('/tags',[TagController::class,'pagesTags'])->name('navbar.navtag');
Route::get('/tags/filter/{filtro}', [TagController::class, 'pagesf'])->name('navbar.navtagf');


Route::get('/registersinaccesoaun15936', [RegisterController::class,'index'])->name('register');
Route::post('/registersinaccesoaun15936', [RegisterController::class,'store']);

Route::get('/results', [SearchController::class,'buscar'])->name('search.buscar');
Route::get('/results/posts/{filtro}', [SearchController::class,'buscarPosts'])->name('search.buscarPosts');
Route::get('/results/tags/{filtro}', [SearchController::class,'buscarTags'])->name('search.buscarTags');
Route::get('/results/accounts/{filtro}', [SearchController::class,'buscarAccounts'])->name('search.buscarAccounts');
//routa de login
Route::get('/loginsinaccesoaun15936', [LoginController::class,'index'])->name('login');
Route::post('/loginsinaccesoaun15936', [LoginController::class,'store']);

//logout
Route::post('/logoutsinaccesoaun15936', [LogoutController::class, 'store'])->name('logout');

Route::get('/onlinestore',[OnlinestoreController::class,'index'])->name('store.index');
Route::post('/onlinestore',[OnlinestoreController::class,'store'])->name('store.store');
Route::put('/onlinestore/update',[OnlinestoreController::class,'update'])->name('store.update');

Route::get('/adstore',[OnlinestoreController::class,'indexStore'])->name('store.indexstore');
Route::post('/adstore',[OnlinestoreController::class,'storead'])->name('store.storead');
Route::post('/adstore/edit',[OnlinestoreController::class,'editLink'])->name('store.editLink');
Route::post('/adstore/delete',[OnlinestoreController::class,'destroy'])->name('store.deleteLink');
Route::get('/plataforms',[OnlinestoreController::class,'all'])->name('store.all');
Route::post('/Pages',[OnlinestoreController::class,'ShowAll'])->name('navbar.pages');


Route::get('/{onlineStore:nombre}',[OnlinestoreController::class,'show'])->name('store.show');
//muro
Route::get('/posts/createsinaccesoaun15936',[PostController::class,'create'])->name('posts.create');
Route::post('/posts',[PostController::class,'store'])->name('posts.store');
Route::get('/{user:username}/{post}',[PostController::class,'show'])->name('posts.show');/////////////////////////

Route::delete('/posts/{post}',[PostController::class, 'destroy'])->name('posts.destroy');

Route::delete('/content',[PostController::class, 'ShowAll'])->name('navbar.posts');

//subir imagenes
Route::post('/imagenes', [ImagenController::class,'store'])->name('imagenes.store');

Route::get('/dashboard', [AdminController::class, 'filtro'])->name('admin.filtro');


//rutas para el perfil

