<?php

use App\Http\Controllers\Auth\LoginController;
use App\Models\Setting;
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

Route::get('/report-problem/{id}', [App\Http\Controllers\CustomerReportController::class, 'index'])->name('report-problem');
Route::get('/report-problem/{id}/{status}', [App\Http\Controllers\CustomerReportController::class, 'showMessage'])->name('show-message');
Route::post('/report-problem/{id}', [App\Http\Controllers\CustomerReportController::class, 'store'])->name('report-problem.send');
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('admin')->as('admin.')->middleware('auth') ->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/datatable', [App\Http\Controllers\Admin\DashboardController::class, 'datatable'])->name('dashboard.data');

    Route::post('update-profile/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('update-profile');
    Route::get('/admin/read-notif',function(){
        $idNotif = request()->id;
        $notif = auth()->user()->notifications()->where('id',$idNotif)->first()->markAsRead();
        $link = request()->link;
        if($link){
            return redirect()->to($link);
        }
        return response()->json(['success'=>true]);
    })->name('read-notif');

    Route::resource('items', App\Http\Controllers\Admin\ItemController::class);
    Route::get('/items/{id}/change-show', [App\Http\Controllers\Admin\ItemController::class, 'changeShow']);

    Route::resource('item-installeds', App\Http\Controllers\Admin\ItemInstalledController::class);
    Route::get('/item-installeds/{id}/change-show', [App\Http\Controllers\Admin\ItemInstalledController::class, 'changeShow']);
    Route::get('/item-installeds/{id}/pdf', [App\Http\Controllers\Admin\ItemInstalledController::class, 'downloadPdf'])->name('item-installeds.pdf');

    Route::get('notif-warning', [App\Http\Controllers\Admin\NotifController::class, 'notifMaintenance'])->name('notif-warning');



    Route::post('item-installeds/{id}/maintenance', [App\Http\Controllers\Admin\ItemInstalledController::class, 'storeMaintenance'])->name('item-installeds.maintenance.store');

    Route::resource('report-problems', App\Http\Controllers\Admin\ReportProblemController::class);
    Route::post('/report-problems/{id}/change', [App\Http\Controllers\Admin\ReportProblemController::class, 'change'])->name('report-problems.change');

    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::get('/users/{id}/change-show', [App\Http\Controllers\Admin\UserController::class, 'changeShow']);

    Route::resource('additional-types', App\Http\Controllers\Admin\AdditionalTypeController::class);
    Route::get('/additional-types/{id}/change-show', [App\Http\Controllers\Admin\AdditionalTypeController::class, 'changeShow']);

    Route::resource('messages', App\Http\Controllers\Admin\MessageController::class);
    Route::resource('additional-infos', App\Http\Controllers\Admin\AdditionalInfoController::class);
    Route::get('/additional-infos/{id}/change-show', [App\Http\Controllers\Admin\AdditionalInfoController::class, 'changeShow']);

    Route::resource('settings', App\Http\Controllers\Admin\SettingController::class);
    Route::resource('article-categories', App\Http\Controllers\Admin\ArticleCategoryController::class);
    Route::get('/article-categories/{id}/change-show', [App\Http\Controllers\Admin\ArticleCategoryController::class, 'changeShow']);
    Route::resource('articles', App\Http\Controllers\Admin\ArticleController::class);
    Route::get('/articles/{id}/change-show', [App\Http\Controllers\Admin\ArticleController::class, 'changeShow']);
    Route::prefix('test')->group(function () {
        Route::resource('questions', App\Http\Controllers\Admin\QuestionController::class);
        Route::get('/questions/{id}/change-show', [App\Http\Controllers\Admin\QuestionController::class, 'changeShow']);
        Route::resource('categories-question', App\Http\Controllers\Admin\CategoryQuestionController::class);
        Route::get('/categories-question/{id}/change-show', [App\Http\Controllers\Admin\CategoryQuestionController::class, 'changeShow']);
    });
    Route::post('user/detail/{id}', [App\Http\Controllers\Admin\UserController::class, 'updateDetail'])->name('admin.user.update');

    //setting
    Route::resource('category', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('word', App\Http\Controllers\Admin\WordController::class);
    Route::resource('category-word', App\Http\Controllers\Admin\CategoryWordController::class);
    Route::get('/api/word/search', [App\Http\Controllers\Admin\WordController::class, 'getWord']);
});

Route::get('/clear-cache',function(){
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');

    return "Cache is cleared";
});

Route::get('/stroage-link', function () {
    Artisan::call('storage:link');
    return "storage link created";
});

Route::get('/generate-sitemap',function(){
    Artisan::call('sitemap:generate');
    return "sitemap-generated";
});
