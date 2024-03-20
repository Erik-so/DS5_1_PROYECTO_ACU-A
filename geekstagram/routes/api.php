<?php

use App\Http\Controllers\Api\HashtagController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PublicationController;
use App\Http\Controllers\Api\SponsorController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PublicationsCommentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Rutas 

Route::get('/hashtags', [HashtagController::class, 'list']);
Route::get('/hashtags/search/{searched}', [HashtagController::class, 'search']);
Route::get('/hashtags/{id}', [HashtagController::class, 'item']);
Route::post('/hashtags/create', [HashtagController::class, 'create']);
Route::post('/hashtags/update', [HashtagController::class, 'update']);

Route::get('/publications', [PublicationController::class, 'list']);
Route::get('/publications/search/', [PublicationController::class, 'search_all']);
Route::get('/publications/search-one-p/{id}', [PublicationController::class, 'search_one_p']);
Route::get('/publications/search-one/{searched}', [PublicationController::class, 'search_one']);
Route::get('/publications/search-pub-comment/{id}', [PublicationController::class, 'search_pub_comment']);
Route::get('/publications/search-comment/{publicationId}', [PublicationController::class, 'getCommentsForPublication']);
Route::get('/publications/search-pub-profile/{userId}', [PublicationController::class, 'search_pub_profile']);
Route::get('/publications/{id}', [PublicationController::class, 'item']);
Route::post('/publications/create/', [PublicationController::class, 'create']);
Route::post('/publications/update', [PublicationController::class, 'update']);
Route::post('/publications/sum-like/{id}', [PublicationController::class, 'sum_like']);
Route::post('/publications/sum-saved/{id}', [PublicationController::class, 'sum_saved']);
Route::post('/publications/delete/{id}', [PublicationController::class, 'deletePublication']);

Route::get('/comments', [CommentController::class, 'list']);
Route::get('/comments/{id}', [CommentController::class, 'item']);
Route::post('/comments/create/', [CommentController::class, 'create']);
Route::post('/comments/update', [CommentController::class, 'update']);

Route::get('/sponsors', [SponsorController::class, 'list']);
Route::get('/sponsors/{id}', [SponsorController::class, 'item']);
Route::post('/sponsors/create', [SponsorController::class, 'create']);
Route::post('/sponsors/update', [SponsorController::class, 'update']);

Route::get('/users', [UserController::class, 'list']);
Route::get('/users/{id}', [UserController::class, 'item']);
Route::post('/users/create/', [UserController::class, 'create']);
Route::post('/users/update', [UserController::class, 'update']);
Route::post('/users/upload-image/', [UserController::class, 'updateImage']);

Route::post('/login',[AuthController::class, 'login']);
Route::post('/logout',[AuthController::class, 'logout']);
Route::post('/register',[AuthController::class, 'register']);

Route::post('/publications_comments/create/', [PublicationsCommentsController::class, 'create']);
