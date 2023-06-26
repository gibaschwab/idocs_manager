<?php
// working
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentEditController;

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

// Neste exemplo, estamos usando uma função anônima na rota / que verifica se o usuário está autenticado. 
// Se estiver autenticado, ele cria uma instância do HomeController e chama o método index(). Caso contrário, 
// redireciona para a rota de login. Dessa forma, você pode manter a lógica do HomeController e a rota terá o mesmo comportamento.
Route::get('/', function () {
    if (auth()->check()) {
        return app()->make(HomeController::class)->index();
    } else {
        return redirect()->route('login');
    }
})->name('home');


// Essa rota define a URL "/" para chamar o método showLoginForm do controlador LoginController.
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
// Route::get('/', 'LoginController@showLoginForm');

// Isso define a rota /register para chamar o método showRegistrationForm do RegisterController.
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/upload', [DocumentController::class, 'create'])->name('upload.create');
Route::post('/upload', [DocumentController::class, 'store'])->name('upload.store');

Route::get('/create', [HomeController::class, 'createDocument'])->name('document.create');

Route::get('/edit-document', [HomeController::class, 'editDocument'])->name('document.edit');
Route::get('/documents/{id}/edit', [DocumentEditController::class, 'edit'])->name('document.edit');
// Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
Route::put('/documents/{id}', [DocumentController::class, 'update'])->name('documents.update');
Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
Route::get('/documents/create', [DocumentController::class, 'create'])->name('document.create');

Route::get('/documents/create', [NewDocumentController::class, 'create'])->name('newdocument.create');
Route::post('/documents', [NewDocumentController::class, 'store'])->name('newdocument.store');

// Route::get('/', function () {
//     return view('welcome');
// });

// Testar conexão com o banco de dados
Route::get('/test-db-connection', function () {
    try {
        DB::connection()->getPdo();
        return "Conexão com o banco de dados estabelecida com sucesso!";
    } catch (\Exception $e) {
        return "Não foi possível conectar ao banco de dados: " . $e->getMessage();
    }
});

Route::get('/test-documents', function () {
    $documents = \App\Models\Document::all();
    dd($documents);
});
