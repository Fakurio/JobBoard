<?php

use App\Http\Controllers\JobsBoardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobApplicationsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/", [JobsBoardController::class, "index"])->name("home");
Route::post("/", [JobsBoardController::class, "filter"])->name("filter");
Route::middleware(["auth", "verified"])->group(function () {
    Route::get("/addPost", [JobsBoardController::class, "create"])->name("addPost");
    Route::post("/addPost", [JobsBoardController::class, "store"])->name("addPost");
    Route::get("/editPost", [JobsBoardController::class, "show"])->name("editPost.show");
    Route::get("/editPost/{postID}", [JobsBoardController::class, "edit"])->name("editPost.edit");
    Route::patch("/updatePost", [JobsBoardController::class, "update"])->name("editPost.update");
    Route::delete("/deletePost", [JobsBoardController::class, "destroy"])->name("deletePost");

    Route::get("/applications", [JobApplicationsController::class, "showApplications"])->name("applications");
    Route::post("/applications", [JobApplicationsController::class, "store"])->name("applications.apply");
    Route::get("/applicants", [JobApplicationsController::class, "showApplicants"])->name("applicants");
    Route::post("/applicants/{newStatus}/{id}", [JobApplicationsController::class, "update"])->name("applicants.update");
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';