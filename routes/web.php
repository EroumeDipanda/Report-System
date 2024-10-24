<?php

use App\Models\Classe;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\MarkController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\Admin\ClasseController;
use App\Http\Controllers\Admin\PdfController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Backend\PropertyController;
use App\Http\Controllers\Backend\PermissionController;


//Redirect user on Login directly
Route::redirect( uri: '/' , destination: 'login');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Routes to switch between languages
Route::get('lang/{locale}', [LanguageController::class, 'switchLanguage'])->name('lang.switch');


Route::middleware('auth')->group(function () {
    // Routes for classes
    Route::get('/classes', [ClasseController::class, 'index'])->name('classes.index');
    Route::get('/create/classes', [ClasseController::class, 'create'])->name('classes.create');
    Route::post('/store/classes', [ClasseController::class, 'store'])->name('classes.store');
    Route::get('/edit/{id}/classes', [ClasseController::class, 'edit'])->name('classes.edit');
    Route::post('/update/{id}/classes', [ClasseController::class, 'update'])->name('classes.update');
    Route::delete('/delete/{id}/classes', [ClasseController::class, 'destroy'])->name('classes.delete');
    Route::get('/students/{id}/classes', [ClasseController::class, 'viewStudents'])->name('class.students');

    // MANAGE CLASSE SUBJECTS
    Route::get('/subjects/{id}/classes', [ClasseController::class, 'viewSubjects'])->name('class.subjects');
    Route::get('/create/subjects/{id}/classes', [SubjectController::class, 'create'])->name('subjects.create');
    Route::post('/store/subjects/{id}/classes', [SubjectController::class, 'store'])->name('subjects.store');
    Route::get('/edit/subjects/{id}/classes', [SubjectController::class, 'edit'])->name('subjects.edit');
    Route::post('/update/subjects/{id}/classes', [SubjectController::class, 'update'])->name('subjects.update');
    Route::delete('/delete/subjects/{id}/subjects', [SubjectController::class, 'destroy'])->name('subjects.delete');

    // Assign Classe subject
    Route::get('/classe_subject/classes', [ClasseController::class, 'classe_subject'])->name('classe.subject');
    Route::post('/store/classe_subject/classes', [ClasseController::class, 'store_classe_subject'])->name('classe.subject.store');


    // Routes for subjects
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');

    // Routes for Students
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/create/students', [StudentController::class, 'create'])->name('students.create');
    Route::post('/store/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/edit/{id}/students', [StudentController::class, 'edit'])->name('students.edit');
    Route::post('/update/{id}/students', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/delete/{id}/students', [StudentController::class, 'destroy'])->name('students.delete');
    Route::get('download/{classId}/students', [StudentController::class, 'downloadPDF'])->name('students.download');
    Route::get('/download-id/{classId}/students', [StudentController::class, 'students_id'])->name('students.id');


    // Routes for Marks
    Route::get('/marks', [MarkController::class, 'index'])->name('marks.index');
    Route::get('/create/marks', [MarkController::class, 'create'])->name('marks.create');
    Route::post('/store/marks', [MarkController::class, 'store'])->name('marks.store');
    Route::get('/view/{classe_id}/{subject_id}/{sequence}/marks', [MarkController::class, 'view'])->name('marks.view');
    Route::get('/edit/{id}/marks', [MarkController::class, 'edit'])->name('marks.edit');
    Route::post('/update/{id}/marks', [MarkController::class, 'update'])->name('marks.update');
    Route::post('/delete/{classe_id}/{subject_id}/{sequence}/marks', [MarkController::class, 'destroy'])->name('marks.delete');
    Route::get('/import/marks', [MarkController::class, 'import'])->name('marks.import');
    Route::post('/store/import/marks', [MarkController::class, 'store_import'])->name('marks.import.store');
    Route::get('/export/marks', [MarkController::class, 'export'])->name('marks.export');
    Route::get('/marks/download', [MarkController::class, 'downloadMarksPdf'])->name('marks.download');
    Route::get('/download-master-sheet', [MarkController::class, 'downloadMasterSheet'])->name('master.sheet.download');


    // Routes for repport cards
    Route::get('/generate/reports', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/generate/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/download/{id}/reports', [ReportController::class, 'download'])->name('reports.download');

    // Route to show the form for creating marks
    // Route::get('marks/create', [MarkController::class, 'create'])->name('marks.create');

    // Route to get subjects for a specific class
    Route::get('classes/{id}/subjects', [MarkController::class, 'getSubjects'])->name('classes.subjects');

    // Route to get students for a specific class
    Route::get('classes/{id}/students', [MarkController::class, 'getStudents'])->name('classes.students');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


//Protected routes for Admins
Route::middleware('auth','admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'admin_dashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'admin_logout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'admin_profile'])->name('admin.profile');
    Route::post('/admin/profile', [AdminController::class, 'profile_store'])->name('admin.profile.store');
    Route::get('/admin/password/change', [AdminController::class, 'change_password'])->name('admin.change.password');
    Route::post('/admin/password/change', [AdminController::class, 'update_password'])->name('admin.update.password');

    //Routes for properties types
    Route::get('/admin/property/all', [PropertyController::class, 'index'])->name('all.property');
    Route::get('/admin/property/add', [PropertyController::class, 'create'])->name('add.property');
    Route::post('/admin/property/add', [PropertyController::class, 'store'])->name('store.property');
    Route::get('/admin/property/edit/{id}', [PropertyController::class, 'edit'])->name('edit.property');
    Route::post('/admin/property/update/{id}', [PropertyController::class, 'update'])->name('update.property');
    Route::get('/admin/property/delete/{id}', [PropertyController::class, 'destroy'])->name('destroy.property');

    //Routes for Managing Admin Users
    Route::get('/admin/all', [AdminController::class, 'all_admin'])->name('all.admin');
    Route::get('/admin/add', [AdminController::class, 'create_admin'])->name('add.admin');
    Route::post('/admin/add', [AdminController::class, 'store_admin'])->name('store.admin');
    Route::get('/admin/edit/{id}', [AdminController::class, 'edit_admin'])->name('edit.admin');
    Route::post('/admin/update/{id}', [AdminController::class, 'update_admin'])->name('update.admin');
    Route::get('/admin/delete/{id}', [AdminController::class, 'destroy_admin'])->name('destroy.admin');

    //Routes for Permissions
    Route::get('/admin/permissions/all', [PermissionController::class, 'index'])->name('all.permission');
    Route::get('/admin/permissions/add', [PermissionController::class, 'create'])->name('add.permission');
    Route::post('/admin/permissions/add', [PermissionController::class, 'store'])->name('store.permission');
    Route::get('/admin/permissions/edit/{id}', [PermissionController::class, 'edit'])->name('edit.permission');
    Route::post('/admin/permissions/update/{id}', [PermissionController::class, 'update'])->name('update.permission');
    Route::get('/admin/permissions/delete/{id}', [PermissionController::class, 'destroy'])->name('destroy.permission');

    //Import and Export of permissions
    Route::get('/admin/permissions/import', [PermissionController::class, 'import_permission'])->name('import.permission');
    Route::post('/admin/permissions/upload', [PermissionController::class, 'upload_permission'])->name('upload.permission');
    Route::get('/admin/permissions/export', [PermissionController::class, 'export_permission'])->name('export.permission');

    //Routes for Roles
    Route::get('/admin/roles/all', [RoleController::class, 'index'])->name('all.role');
    Route::get('/admin/roles/add', [RoleController::class, 'create'])->name('add.role');
    Route::post('/admin/roles/add', [RoleController::class, 'store'])->name('store.role');
    Route::get('/admin/roles/edit/{id}', [RoleController::class, 'edit'])->name('edit.role');
    Route::post('/admin/roles/update/{id}', [RoleController::class, 'update'])->name('update.role');
    Route::get('/admin/roles/delete/{id}', [RoleController::class, 'destroy'])->name('destroy.role');

    //Routes for Roles in Permission
    Route::get('/admin/all/role-permission', [RoleController::class, 'all_role_permission'])->name('all.role.permission');
    Route::get('/admin/add/role-permission', [RoleController::class, 'add_role_permission'])->name('add.role.permission');
    Route::post('/admin/add/role-permission', [RoleController::class, 'store_role_permission'])->name('store.role.permission');
    Route::get('/admin/edit/role-permission/{id}', [RoleController::class, 'edit_role_permission'])->name('edit.role.permission');
    Route::post('/admin/update/role-permission/{id}', [RoleController::class, 'update_role_permission'])->name('update.role.permission');
    Route::get('/admin/delete/role-permission/{id}', [RoleController::class, 'delete_role_permission'])->name('delete.role.permission');

});
