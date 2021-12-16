<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DiscountCuponController;
use App\Http\Controllers\Admin\GiftCuponController;
use App\Http\Controllers\Admin\IndicationController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\TreatmentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteImovelProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/admin', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin');
Route::post('/admin/do_login', [App\Http\Controllers\Admin\AuthController::class, 'do_login'])->name('admin.do_login');
Route::get('/admin/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');
Route::get('/admin/password', [App\Http\Controllers\Admin\AuthController::class, 'password'])->name('admin.password');

Route::group(['middleware' => 'auth'], function () {

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('index');
            Route::post('/orderNotification', [App\Http\Controllers\Admin\HomeController::class, 'orderNotification'])->name('orderNotification');
            Route::post('/messageNotification', [App\Http\Controllers\Admin\HomeController::class, 'messageNotification'])->name('messageNotification');
        });

        Route::resources([
            'users' => UserController::class,
            'banners' => BannerController::class,
            'posts' => PostController::class,
            'treatments' => TreatmentController::class,
            'categories' => CategoryController::class,
            'products' => ProductController::class,
            'sections' => SectionController::class,
            'indications' => IndicationController::class,
            'giftcupon' => GiftCuponController::class,
            'discountcupon' => DiscountCuponController::class,
        ]);

        // CUSTOMERS
        Route::prefix('customers')->name('customers.')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::get('/show/{customer}', [CustomerController::class, 'show'])->name('show');
            Route::get('/create', [CustomerController::class, 'create'])->name('create');
            Route::post('/store', [CustomerController::class, 'store'])->name('store');
            Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('edit');
            Route::put('/update/{customer}', [CustomerController::class, 'update'])->name('update');
            Route::post('/delete', [CustomerController::class, 'delete'])->name('delete');
            Route::get('/orderby', [CustomerController::class, 'orderby'])->name('orderby');
        });

        // ORDERS
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/show/{order}', [OrderController::class, 'show'])->name('show');
            Route::post('/delete', [OrderController::class, 'delete'])->name('delete');
            Route::get('/orderby', [OrderController::class, 'orderby'])->name('orderby');
        });

        // TREATMENT
        Route::prefix('treatments')->name('treatments.')->group(function () {
            Route::post('/delete', [TreatmentController::class, 'delete'])->name('delete');
        });

        // CATEGORY
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::post('/delete', [CategoryController::class, 'delete'])->name('delete');
        });

        // PRODUCT
        Route::prefix('products')->name('products.')->group(function () {
            Route::post('/delete', [ProductController::class, 'delete'])->name('delete');
            Route::post('/getCategory', [ProductController::class, 'getCategory'])->name('getCategory');
            Route::post('/uploadThumb', [ProductController::class, 'uploadThumb'])->name('uploadThumb');
            Route::get('/deleteThumb', [ProductController::class, 'deleteThumb'])->name('deleteThumb');
            Route::post('/uploadBanner', [ProductController::class, 'uploadBanner'])->name('uploadBanner');
            Route::get('/deleteBanner', [ProductController::class, 'deleteBanner'])->name('deleteBanner');
            Route::post('/insertIndication', [ProductController::class, 'insertIndication'])->name('insertIndication');
            Route::get('/deleteIndication/{id}', [ProductController::class, 'deleteIndication'])->name('deleteIndication');
            Route::post('/insertSection', [ProductController::class, 'insertSection'])->name('insertSection');
            Route::get('/deleteSection/{id}', [ProductController::class, 'deleteSection'])->name('deleteSection');
        });

        // SECTION
        Route::prefix('sections')->name('sections.')->group(function () {
            Route::post('/delete', [SectionController::class, 'delete'])->name('delete');
        });

        // INDICATION
        Route::prefix('indications')->name('indications.')->group(function () {
            Route::post('/delete', [IndicationController::class, 'delete'])->name('delete');
        });

        // GIFT CUPON
        Route::prefix('giftcupon')->name('giftcupon.')->group(function () {
            Route::post('/delete', [GiftCuponController::class, 'delete'])->name('delete');
        });

        // DISCOUNT CUPON
        Route::prefix('discountcupon')->name('discountcupon.')->group(function () {
            Route::post('/delete', [DiscountCuponController::class, 'delete'])->name('delete');
        });

        // BANNERS
        Route::prefix('banners')->name('banners.')->group(function () {
            Route::post('/delete', [BannerController::class, 'delete'])->name('delete');
        });

        // POSTS
        Route::prefix('posts')->name('posts.')->group(function () {
            Route::post('/delete', [PostController::class, 'delete'])->name('delete');
        });

        // USUÁRIOS
        Route::prefix('users')->name('users.')->group(function () {
            Route::post('/delete', [UserController::class, 'delete'])->name('delete');
        });

        // MESSAGES
        Route::prefix('messages')->name('messages.')->group(function () {
            Route::get('', [MessageController::class, 'index'])->name('index');
            Route::get('/{message}', [MessageController::class, 'show'])->name('show');
            Route::post('/delete', [MessageController::class, 'delete'])->name('delete');
        });

        // NEWSLETTER
        Route::prefix('newsletters')->name('newsletters.')->group(function () {
            Route::get('', [NewsletterController::class, 'index'])->name('index');
            Route::post('/delete', [NewsletterController::class, 'delete'])->name('delete');
        });
    });
});


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/insertNews', [App\Http\Controllers\HomeController::class, 'insertNews'])->name('home.insertNews');

Route::prefix('sobre-nos')->name('quemsomos.')->group(function () {
    Route::get('/', [App\Http\Controllers\QuemSomosController::class, 'index'])->name('index');
});

// TRATAMENTOS
Route::prefix('tratamentos')->name('tratamentos.')->group(function () {
    Route::get('/{treatment}', [App\Http\Controllers\TratamentoController::class, 'treatment'])->name('treatment');
    Route::get('/{treatment}/{category}', [App\Http\Controllers\TratamentoController::class, 'category'])->name('category');
    Route::get('/{treatment}/{category}/{product}', [App\Http\Controllers\TratamentoController::class, 'product'])->name('product');
    Route::get('/info', [App\Http\Controllers\TratamentoController::class, 'info'])->name('info');
    Route::post('/getPrice', [App\Http\Controllers\TratamentoController::class, 'getPrice'])->name('getPrice');
});

// BLOG
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [App\Http\Controllers\BlogController::class, 'index'])->name('index');
    Route::get('/{post}', [App\Http\Controllers\BlogController::class, 'posts'])->name('posts');
});

// CONTATO
Route::prefix('contato')->name('contato.')->group(function () {
    Route::get('/', [App\Http\Controllers\ContatoController::class, 'index'])->name('index');
    Route::get('/email', [App\Http\Controllers\ContatoController::class, 'email'])->name('email');
    Route::post('/enviaEmail', [App\Http\Controllers\ContatoController::class, 'enviaEmail'])->name('enviaEmail');
});

// CONTA
Route::prefix('account')->name('account.')->group(function () {
    Route::get('/login', [AccountController::class, 'login'])->name('login');
    Route::post('/doLogin', [AccountController::class, 'doLogin'])->name('doLogin');
    Route::get('/logout', [AccountController::class, 'logout'])->name('logout');
    Route::get('/create', [AccountController::class, 'create'])->name('create');
    Route::post('/createCustomer', [AccountController::class, 'createCustomer'])->name('createCustomer');
    Route::put('/updateCustomer/{customer}', [AccountController::class, 'updateCustomer'])->name('updateCustomer');
    Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
    Route::get('/register', [AccountController::class, 'register'])->name('register');
    Route::get('/address', [AccountController::class, 'address'])->name('address');
});

// CARRINHO
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/create', [CartController::class, 'create'])->name('create');
    Route::get('/delete/{id}', [CartController::class, 'deleteProduct'])->name('deleteProduct');
    Route::get('/increment/{id}', [CartController::class, 'incrementProduct'])->name('incrementProduct');
    Route::get('/decrement/{id}', [CartController::class, 'decrementProduct'])->name('decrementProduct');
    Route::post('/discountCupon', [CartController::class, 'discountCupon'])->name('discountCupon');
    Route::post('/giftCupon', [CartController::class, 'giftCupon'])->name('giftCupon');
});

// CHECKOUT
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::get('/auth', [CheckoutController::class, 'auth'])->name('auth');
    Route::get('/customer', [CheckoutController::class, 'customer'])->name('customer');
    Route::get('/address', [CheckoutController::class, 'address'])->name('address');
    Route::post('/doAuth', [CheckoutController::class, 'doAuth'])->name('doAuth');
    Route::post('/newCustomer', [CheckoutController::class, 'newCustomer'])->name('newCustomer');
    Route::post('/checkEmail', [CheckoutController::class, 'checkEmail'])->name('checkEmail');
    Route::post('/createCustomer', [CheckoutController::class, 'createCustomer'])->name('createCustomer');
    Route::post('/createAddress', [CheckoutController::class, 'createAddress'])->name('createAddress');
    Route::post('/consultaCep', [CheckoutController::class, 'consultaCep'])->name('consultaCep');
});

// PAGAMENTO
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('index');
    Route::get('/mercadopago', [PaymentController::class, 'mercadopago'])->name('mercadopago');
    Route::get('/mercadopago/otherpayments', [PaymentController::class, 'otherpayments'])->name('otherpayments');
    Route::post('/createOrder', [PaymentController::class, 'createOrder'])->name('createOrder');
    Route::get('/order/{code}', [PaymentController::class, 'order'])->name('order');
});

// NOTIFICAÇÂO
Route::prefix('notification')->name('notification.')->group(function () {
    Route::get('/', [NotificationController::class, 'notification'])->name('notification');
});
