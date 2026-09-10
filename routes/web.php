<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\TpdkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
});

Route::middleware(['auth', 'check.status'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Template Demo Pages
    Route::get('/tables', function () {
        return view('pages.tables');
    })->name('tables');
    Route::get('/billing', function () {
        return view('pages.billing');
    })->name('billing');
    Route::get('/virtual-reality', function () {
        return view('pages.virtual-reality');
    })->name('virtual-reality');
    Route::get('/rtl', function () {
        return view('pages.rtl');
    })->name('rtl');
    Route::get('/notifications', function () {
        return view('pages.notifications');
    })->name('notifications');
    Route::get('/profile', function () {
        return view('pages.profile');
    })->name('profile');
    Route::get('/user-profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('user-profile');
    Route::post('/user-profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('user-profile');
    Route::post('/user-profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('user-profile.password');
    // Route::get('/user-management', function () {
    //     return view('pages.laravel-examples.user-management');
    // })->name('user-management');
    Route::get('/static-sign-in', function () {
        return view('pages.static-sign-in');
    })->name('static-sign-in');
    Route::get('/static-sign-up', function () {
        return view('pages.static-sign-up');
    })->name('static-sign-up');

    Route::prefix('setup/users')
        ->name('setup.users.')
        ->controller(UserController::class)
        ->group(function () {
            Route::get('/', 'index')->middleware('permission:setup.users.index')->name('index');
            Route::get('/{user}', 'show')->middleware('permission:setup.users.show')->name('show');
            Route::post('/', 'store')->middleware('permission:setup.users.store')->name('store');
            Route::match(['put', 'patch'], '/{user}', 'update')->middleware('permission:setup.users.update')->name('update');
            Route::delete('/{user}', 'destroy')->middleware('permission:setup.users.destroy')->name('destroy');
            Route::patch('/{user}/approve', 'approve')->name('approve')->middleware('permission:setup.users.update');
            Route::patch('/{user}/reject', 'reject')->name('reject')->middleware('permission:setup.users.update');
        });

    Route::prefix('setup/roles')
        ->name('setup.roles.')
        ->controller(RoleController::class)
        ->group(function () {
            Route::get('/', 'index')->middleware('permission:setup.roles.index')->name('index');
            Route::get('/{role}', 'show')->middleware('permission:setup.roles.show')->name('show');
            Route::post('/', 'store')->middleware('permission:setup.roles.store')->name('store');
            Route::match(['put', 'patch'], '/{role}', 'update')->middleware('permission:setup.roles.update')->name('update');
            Route::delete('/{role}', 'destroy')->middleware('permission:setup.roles.destroy')->name('destroy');
        });

    Route::prefix('setup/permissions')
        ->name('setup.permissions.')
        ->controller(PermissionController::class)
        ->group(function () {
            Route::get('/', 'index')->middleware('permission:setup.permissions.index')->name('index');
            Route::get('/{permission}', 'show')->middleware('permission:setup.permissions.show')->name('show');
            Route::post('/', 'store')->middleware('permission:setup.permissions.store')->name('store');
            Route::match(['put', 'patch'], '/{permission}', 'update')->middleware('permission:setup.permissions.update')->name('update');
            Route::delete('/{permission}', 'destroy')->middleware('permission:setup.permissions.destroy')->name('destroy');
        });

    // Halaman aksi presensi (semua user login boleh akses, bukan hanya yang punya permission attendances.index)
    Route::get('/presensi', [AttendanceController::class, 'checkPage'])->name('attendances.check-page');

    Route::post('/attendances/check-in', [AttendanceController::class, 'checkIn'])->name('attendances.check-in');
    Route::post('/attendances/check-out', [AttendanceController::class, 'checkOut'])->name('attendances.check-out');

    Route::prefix('attendances')
        ->name('attendances.')
        ->controller(AttendanceController::class)
        ->group(function () {
            Route::get('/', 'index')->middleware('permission:attendances.index')->name('index');
            Route::get('/export-excel', 'exportExcel')->middleware('permission:attendances.index')->name('export.excel');
            Route::get('/export-pdf', 'exportPdf')->middleware('permission:attendances.index')->name('export.pdf');
            Route::get('/{attendance}', 'show')->middleware('permission:attendances.show')->name('show');
            Route::post('/', 'store')->middleware('permission:attendances.store')->name('store');
            Route::match(['put', 'patch'], '/{attendance}', 'update')->middleware('permission:attendances.update')->name('update');
            Route::delete('/{attendance}', 'destroy')->middleware('permission:attendances.destroy')->name('destroy');
        });

    Route::prefix('leaves')
        ->name('leaves.')
        ->controller(LeaveController::class)
        ->group(function () {
            Route::get('/', 'index')->middleware('permission:leaves.index')->name('index');
            Route::get('/export-excel', 'exportExcel')->middleware('permission:leaves.index')->name('export.excel');
            Route::get('/export-pdf', 'exportPdf')->middleware('permission:leaves.index')->name('export.pdf');
            Route::get('/{leave}', 'show')->middleware('permission:leaves.show')->name('show');
            Route::post('/', 'store')->middleware('permission:leaves.store')->name('store');
            Route::match(['put', 'patch'], '/{leave}', 'update')->middleware('permission:leaves.update')->name('update');
            Route::match(['put', 'patch'], '/{leave}/status', 'updateStatus')->name('updateStatus');
            Route::delete('/{leave}', 'destroy')->middleware('permission:leaves.destroy')->name('destroy');
        });

    Route::prefix('logbooks')
        ->name('logbooks.')
        ->controller(LogbookController::class)
        ->group(function () {
            Route::get('/', 'index')->middleware('permission:logbooks.index')->name('index');
            Route::get('/export-excel', 'exportExcel')->middleware('permission:logbooks.index')->name('export.excel');
            Route::get('/export-pdf', 'exportPdf')->middleware('permission:logbooks.index')->name('export.pdf');
            Route::get('/{logbook}', 'show')->middleware('permission:logbooks.show')->name('show');
            Route::post('/', 'store')->middleware('permission:logbooks.store')->name('store');
            Route::match(['put', 'patch'], '/{logbook}', 'update')->middleware('permission:logbooks.update')->name('update');
            Route::match(['put', 'patch'], '/{logbook}/status', 'updateStatus')->middleware('permission:logbooks.manage_all')->name('updateStatus');
            Route::delete('/{logbook}', 'destroy')->middleware('permission:logbooks.destroy')->name('destroy');
        });

    Route::prefix('tpdks')
        ->name('tpdks.')
        ->controller(TpdkController::class)
        ->group(function () {
            Route::get('/', 'index')->middleware('permission:tpdks.index')->name('index');
            Route::get('/{tpdk}', 'show')->middleware('permission:tpdks.show')->name('show');
            Route::post('/', 'store')->middleware('permission:tpdks.store')->name('store');
            Route::match(['put', 'patch'], '/{tpdk}', 'update')->middleware('permission:tpdks.update')->name('update');
            Route::delete('/{tpdk}', 'destroy')->middleware('permission:tpdks.destroy')->name('destroy');
        });

    Route::prefix('workschedules')
        ->name('workschedules.')
        ->controller(\App\Http\Controllers\WorkScheduleController::class)
        ->group(function () {
            Route::get('/', 'index')->middleware('permission:work_schedules.index')->name('index');
            Route::post('/', 'store')->middleware('permission:work_schedules.store')->name('store');
            Route::match(['put', 'patch'], '/{workschedule}', 'update')->middleware('permission:work_schedules.update')->name('update');
            Route::delete('/{workschedule}', 'destroy')->middleware('permission:work_schedules.destroy')->name('destroy');
        });
});