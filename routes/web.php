<?php

use App\Http\Controllers\{
    Auth\AuthenticatedSessionController,
    Auth\ConfirmablePasswordController,
    Auth\EmailVerificationNotificationController,
    Auth\EmailVerificationPromptController,
    Auth\NewPasswordController,
    Auth\PasswordController,
    Auth\PasswordResetLinkController,
    Auth\RegisteredUserController,
    Auth\VerifyEmailController,
    ProfileController,
    UserController,
};

use App\Http\Middleware\{
    AdminMiddleware,
    EditUserMiddleware
};

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClusterController;


// Rota raiz redirecionando para o login
Route::get('/', function () {
    return redirect()->route('login');
});

/************************
 * Rotas de Autenticação *
 ************************/

// Registro
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);
});

// Login
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Recuperação de senha
Route::middleware('guest')->group(function () {
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

// Verificação de email
Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});

/******************************
 * Rotas da Aplicação Principal *
 ******************************/

Route::middleware(['auth'])->group(function () {
    // Dashboard principal
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard','dashboard')->name("dashboard");
    });

    Route::view('/about', 'about.index')->name('about');

    // Perfil do usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas de usuários
    Route::controller(UserController::class)->group(function () {
        Route::get('/User/me', 'editMe')->name("User.me");
        Route::get('/Users', 'index')->name("users_all")->middleware(AdminMiddleware::class);
        Route::get('/User/{User}/edit', 'edit')->name("User.edit")->middleware(EditUserMiddleware::class);
        Route::put('/User/{User}', 'update')->name("User.update")->middleware(EditUserMiddleware::class);
        Route::patch('/User/{User}/password', 'updatePassword')->name("User.updatePassword")->middleware(EditUserMiddleware::class);
        Route::resource('/User', UserController::class)->except(['index', 'edit', 'update'])->middleware(AdminMiddleware::class);
    });


       Route::controller(ClusterController::class)->group(function () {
        Route::resource('/Clusters',ClusterController::class);
        Route::get('/Clusters/selectCluster/{device}','selectCluster')->name('Clusters.selectCluster');
    });

    

});