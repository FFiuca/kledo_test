<?php

use App\Http\Controllers\ApprovalExpenseController;
use App\Http\Controllers\ApprovalStageController;
use App\Http\Controllers\ApproverController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('/approver')->name('approver.')->group(function(){
    Route::post('/', [ApproverController::class, 'create'])->name('create');
});

Route::prefix('/approval-stages')->name('approval-stages.')->group(function(){
    Route::post('/', [ApprovalStageController::class, 'create'])->name('create');
    Route::put('/{id}', [ApprovalStageController::class, 'update'])->name('update');
});

Route::prefix('/expense')->name('expense.')->group(function(){
    Route::post('/', [ExpenseController::class, 'create'])->name('create');
    Route::get('/{id}', [ExpenseController::class, 'detail'])->name('detail');
    Route::patch('/{id}/approve', [ApprovalExpenseController::class, 'approve'])->name('approve');
});
