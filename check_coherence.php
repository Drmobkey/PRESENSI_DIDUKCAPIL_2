<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$classesToCheck = [
    App\Http\Controllers\AttendanceController::class,
    App\Services\AttendanceService::class,
    App\Models\Attendance::class,
    App\Http\Requests\Attendance\StoreCheckInRequest::class,
    App\Http\Requests\Attendance\StoreCheckOutRequest::class,
    
    App\Http\Controllers\LeaveController::class,
    App\Services\LeaveService::class,
    App\Models\Leave::class,
    App\Http\Requests\Leave\StoreLeaveRequest::class,
    App\Http\Requests\Leave\UpdateLeaveRequest::class,
    
    App\Http\Controllers\LogbookController::class,
    App\Services\LogbookService::class,
    App\Models\Logbook::class,
    App\Http\Requests\Logbook\StoreLogbookRequest::class,
    App\Http\Requests\Logbook\UpdateLogbookRequest::class,
    
    App\Http\Controllers\TpdkController::class,
    App\Services\TpdkService::class,
    App\Models\Tpdk::class,
    App\Http\Requests\Tpdk\StoreTpdkRequest::class,
    App\Http\Requests\Tpdk\UpdateTpdkRequest::class,
];

$errors = [];
$successCount = 0;

foreach ($classesToCheck as $class) {
    if (class_exists($class)) {
        $successCount++;
    } else {
        $errors[] = "Class does not exist or failed to load: $class";
    }
}

if (empty($errors)) {
    echo "Success! $successCount classes successfully loaded without fatal errors.\n";
} else {
    echo "Errors found:\n";
    foreach ($errors as $error) {
        echo "- $error\n";
    }
}
