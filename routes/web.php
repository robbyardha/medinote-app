<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\GivePermissionController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicBlogController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SubMenuController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\Patient;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified', 'role_or_permission:developer|penulis'])->name('dashboard');

Route::get('/', [PublicBlogController::class, 'index'])->name('public.blog.index');
Route::post('/blog/{postId}/comment', [PublicBlogController::class, 'storeComment'])->name('public.blog.comment');
Route::post('/blog/{postId}/like', [PublicBlogController::class, 'storeLike'])->name('public.blog.like');
Route::get('/blog/{slug}', [PublicBlogController::class, 'show'])->name('public.blog.show');


Route::middleware('auth')->group(function () {


    // Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified', 'role_or_permission:developer|/dashboard']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified', 'role_or_permission:developer|/dashboard']);
    Route::match(["get", "post"], '/setting', [SettingController::class, 'index'])->middleware(['auth', 'verified', 'role_or_permission:developer|/setting']);


    Route::get('/access/role', [RoleController::class, 'index'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/role']);
    Route::get('/access/role/getDataAjax', [RoleController::class, 'getDataAjax'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/role']);
    Route::post('/access/role/create', [RoleController::class, 'create'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/role/create']);
    Route::get('/access/role/edit/{id}', [RoleController::class, 'edit'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/role/edit']);
    Route::post('/access/role/update/{id}', [RoleController::class, 'update'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/role/update']);
    Route::delete('/access/role/delete/{id}', [RoleController::class, 'delete'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/role/delete']);

    Route::get('/access/menu/select2', [MenuController::class, 'select2'])->name('menus.select2');
    Route::get('/access/menu/getDataAjax', [MenuController::class, 'getDataAjax'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/menu']);
    Route::get('/access/menu', [MenuController::class, 'index'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/menu']);
    Route::post('/access/menu/create', [MenuController::class, 'create'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/menu/create']);
    Route::get('/access/menu/edit/{id}', [MenuController::class, 'edit'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/menu/edit']);
    Route::post('/access/menu/update/{id}', [MenuController::class, 'update'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/menu/update']);
    Route::delete('/access/menu/delete/{id}', [MenuController::class, 'delete'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/menu/delete']);

    Route::get('/access/submenu/getDataAjax', [SubMenuController::class, 'getDataAjax'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/submenu']);
    Route::get('/access/submenu', [SubMenuController::class, 'index'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/submenu']);
    Route::post('/access/submenu/create', [SubMenuController::class, 'create'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/submenu/create']);
    Route::get('/access/submenu/edit/{id}', [SubMenuController::class, 'edit'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/submenu/edit']);
    Route::post('/access/submenu/update/{id}', [SubMenuController::class, 'update'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/submenu/update']);
    Route::delete('/access/submenu/delete/{id}', [SubMenuController::class, 'delete'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/submenu/delete']);

    Route::get('/access/permission/getDataAjax', [PermissionController::class, 'getDataAjax'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/submenu']);
    Route::get('/access/permission', [PermissionController::class, 'index'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/permission']);
    Route::post('/access/permission/create', [PermissionController::class, 'create'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/permission/create']);
    Route::get('/access/permission/edit/{id}', [PermissionController::class, 'edit'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/permission/edit']);
    Route::post('/access/permission/update/{id}', [PermissionController::class, 'update'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/permission/update']);
    Route::delete('/access/permission/delete/{id}', [PermissionController::class, 'delete'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/permission/delete']);

    Route::get('/access/give-permission/getDataAjax', [GivePermissionController::class, 'getDataAjax'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/give-permission']);
    Route::get('/access/give-permission', [GivePermissionController::class, 'index'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/give-permission']);
    Route::post('/access/give-permission/create', [GivePermissionController::class, 'create'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/give-permission/create']);
    Route::get('/access/give-permission/edit/{id}', [GivePermissionController::class, 'edit'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/give-permission/edit']);
    Route::post('/access/give-permission/update', [GivePermissionController::class, 'update'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/give-permission/update']);
    Route::post('/access/give-permission/delete', [GivePermissionController::class, 'delete'])->middleware(['auth', 'verified', 'role_or_permission:developer|/access/give-permission/delete']);

    //user (developer, dokter, apoteker, admin)
    Route::get('/master/user/select2', [UserController::class, 'select2Doctor'])->name('doctors.select2');
    Route::get('/master/user/getDataAjax', [UserController::class, 'getDataAjax'])->middleware(['auth', 'verified', 'role_or_permission:developer|/master/user']);
    Route::get('/master/user', [UserController::class, 'index'])->middleware(['auth', 'verified', 'role_or_permission:developer|/master/user']);
    Route::post('/master/user/create', [UserController::class, 'create'])->middleware(['auth', 'verified', 'role_or_permission:developer|/master/user/create']);
    Route::get('/master/user/edit/{id}', [UserController::class, 'edit'])->middleware(['auth', 'verified', 'role_or_permission:developer|/master/user/edit']);
    Route::post('/master/user/update/{id}', [UserController::class, 'update'])->middleware(['auth', 'verified', 'role_or_permission:developer|/master/user/update']);
    Route::post('/master/user/delete/{id}', [UserController::class, 'delete'])->middleware(['auth', 'verified', 'role_or_permission:developer|/master/user/delete']);


    // Pasien
    Route::get('/master/patient/select2', [PatientController::class, 'select2'])->name('patients.select2');
    Route::get('/master/patient/getDataAjax', [PatientController::class, 'getDataAjax'])->middleware(['auth', 'verified', 'role_or_permission:developer|/master/patient']);
    Route::get('/master/patient', [PatientController::class, 'index'])->middleware(['auth', 'verified', 'role_or_permission:developer|/master/patient']);
    Route::get('/master/patient/add', [PatientController::class, 'add'])->middleware(['auth', 'verified', 'role_or_permission:developer|/master/patient/add']);
    Route::match(["get", "post"], '/master/patient/create', [PatientController::class, 'create'])->middleware(['auth', 'verified', 'role_or_permission:developer|/master/patient/create']);
    Route::get('/master/patient/edit/{id}', [PatientController::class, 'edit'])->middleware(['auth', 'verified', 'role_or_permission:developer|/master/patient/edit']);
    Route::post('/master/patient/update/{id}', [PatientController::class, 'update'])->middleware(['auth', 'verified', 'role_or_permission:developer|/master/patient/update']);
    Route::post('/master/patient/delete/{id}', [PatientController::class, 'delete'])->middleware(['auth', 'verified', 'role_or_permission:developer|/master/patient/delete']);

    //pendaftaran pasien
    Route::get('/exam/registration-examination/getDataAjax', [AppointmentController::class, 'getDataAjax'])->middleware(['auth', 'verified', 'role_or_permission:developer|/exam/registration-examination']);
    Route::get('/exam/registration-examination', [AppointmentController::class, 'index'])->middleware(['auth', 'verified', 'role_or_permission:developer|/exam/registration-examination']);
    Route::match(["get", "post"], '/exam/registration-examination/create', [AppointmentController::class, 'create'])->middleware(['auth', 'verified', 'role_or_permission:developer|/exam/registration-examination/create']);
    Route::get('/exam/registration-examination/edit/{id}', [AppointmentController::class, 'edit'])->middleware(['auth', 'verified', 'role_or_permission:developer|/exam/registration-examination/edit']);
    Route::post('/exam/registration-examination/update/{id}', [AppointmentController::class, 'update'])->middleware(['auth', 'verified', 'role_or_permission:developer|/exam/registration-examination/update']);
    Route::post('/exam/registration-examination/delete/{id}', [AppointmentController::class, 'delete'])->middleware(['auth', 'verified', 'role_or_permission:developer|/exam/registration-examination/delete']);
    Route::post('/exam/registration-examination/call/{id}', [AppointmentController::class, 'call'])->middleware(['auth', 'verified', 'role_or_permission:developer|/exam/registration-examination/call']);

    //Examination
    Route::get('/exam/examination/getMedicineDetail/{id}', [ExaminationController::class, 'getMedicineDetail'])->name('get_medicine_detai');;
    Route::get('/exam/examination/getDataAjax', [ExaminationController::class, 'getDataAjax'])->middleware(['auth', 'verified', 'role_or_permission:developer|/exam/examination']);
    Route::get('/exam/examination', [ExaminationController::class, 'index'])->middleware(['auth', 'verified', 'role_or_permission:developer|/exam/examination']);
    Route::get('/exam/examination/select-patient/{id}', [ExaminationController::class, 'select_patient'])->middleware(['auth', 'verified', 'role_or_permission:developer|/exam/examination/select-patient']);
    Route::match(["get", "post"], '/exam/examination/create-examination', [ExaminationController::class, 'create'])->middleware(['auth', 'verified', 'role_or_permission:developer|/exam/examination/create']);


    Route::get('/exam/examination/edit/{id}', [ExaminationController::class, 'edit'])->middleware(['auth', 'verified', 'role_or_permission:developer|/exam/examination/edit']);
    Route::post('/exam/examination/update/{id}', [ExaminationController::class, 'update'])->middleware(['auth', 'verified', 'role_or_permission:developer|/exam/examination/update']);
    Route::post('/exam/examination/delete/{id}', [ExaminationController::class, 'delete'])->middleware(['auth', 'verified', 'role_or_permission:developer|/exam/examination/delete']);


    //Invoice
    Route::get('/invoice/payment/getDataAjax', [TransactionController::class, 'getDataAjax'])->middleware(['auth', 'verified', 'role_or_permission:developer|/invoice/payment']);
    Route::get('/invoice/payment', [TransactionController::class, 'index'])->middleware(['auth', 'verified', 'role_or_permission:developer|/invoice/payment']);
    Route::get('/invoice/payment/detail/{id}', [TransactionController::class, 'detail'])->middleware(['auth', 'verified', 'role_or_permission:developer|/invoice/payment/detail']);
    Route::post('/invoice/payment/save-payment', [TransactionController::class, 'save_payment'])->middleware(['auth', 'verified', 'role_or_permission:developer|/invoice/payment/save-payment']);
    Route::post('/invoice/payment/pick-medicine/{id}', [TransactionController::class, 'pick_medicine'])->middleware(['auth', 'verified', 'role_or_permission:developer|/invoice/payment/pick-medicine']);


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified', 'role_or_permission:developer|/dashboard']);


    Route::post('ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.upload');
});

require __DIR__ . '/auth.php';
