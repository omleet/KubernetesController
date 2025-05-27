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
    NodeController,
    NamespaceController,
    PodController,
    ServiceController,
    IngressController,
    DeploymentController,
    BackupController,
    CustomResourceController
};

use App\Http\Middleware\{
    AdminMiddleware,
    EditUserMiddleware,
    ResourceControlMiddleware
};

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClusterController;



// Rota raiz redirecionando para o login
Route::get('/', function () {
    return redirect()->route('Clusters.index');
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
    //Pagina Inicial
    Route::get('/Clusters', [ClusterController::class, 'index'])->name('Clusters.index');


    // Dashboard principal
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/Dashboard', 'index')->name("Dashboard");
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
        Route::resource('/Clusters', ClusterController::class);
        Route::get('/Clusters/selectCluster/{device}', 'selectCluster')->name('Clusters.selectCluster');
    });

    Route::controller(NodeController::class)->group(function () {
        Route::resource('/Nodes', NodeController::class)->only(['index', 'show']);
    });

    Route::controller(NamespaceController::class)->group(function () {
        Route::get('/Namespaces', 'index')->name("Namespaces.index");
        Route::get('/Namespaces/New', 'create')->name("Namespaces.create")->middleware(ResourceControlMiddleware::class);
        Route::get('/Namespaces/{namespace}', 'show')->name("Namespaces.show");
        Route::post('/Namespaces/Store', 'store')->name("Namespaces.store")->middleware(ResourceControlMiddleware::class);
        Route::delete('/Namespaces/{namespace}', 'destroy')->name("Namespaces.destroy")->middleware(ResourceControlMiddleware::class);
    });

    Route::controller(PodController::class)->group(function () {
        Route::get('/Pods', 'index')->name("Pods.index");
        Route::get('/Pods/New', 'create')->name("Pods.create")->middleware(ResourceControlMiddleware::class);
        Route::get('/Pods/{Namespace}/{Pod}', 'show')->name("Pods.show");
        Route::post('/Pods/Store', 'store')->name("Pods.store")->middleware(ResourceControlMiddleware::class);
        Route::delete('/Pods/{Namespace}/{Pod}', 'destroy')->name("Pods.destroy")->middleware(ResourceControlMiddleware::class);
    });

    Route::controller(DeploymentController::class)->group(function () {
        Route::get('/Deployments', 'index')->name("Deployments.index");
        Route::get('/Deployments/New', 'create')->name("Deployments.create")->middleware(ResourceControlMiddleware::class);
        Route::get('/Deployments/{Namespace}/{Deployment}', 'show')->name("Deployments.show");
        Route::post('/Deployments/Store', 'store')->name("Deployments.store")->middleware(ResourceControlMiddleware::class);
        Route::delete('/Deployments/{Namespace}/{Deployment}', 'destroy')->name("Deployments.destroy")->middleware(ResourceControlMiddleware::class);
    });

    Route::controller(ServiceController::class)->group(function () {
        Route::get('/Services', 'index')->name("Services.index");
        Route::get('/Services/New', 'create')->name("Services.create")->middleware(ResourceControlMiddleware::class);
        Route::get('/Services/{Namespace}/{Service}', 'show')->name("Services.show");
        Route::post('/Services/Store', 'store')->name("Services.store")->middleware(ResourceControlMiddleware::class);
        Route::delete('/Services/{Namespace}/{Service}', 'destroy')->name("Services.destroy")->middleware(ResourceControlMiddleware::class);
    });

    Route::controller(IngressController::class)->group(function () {
        Route::get('/Ingresses', 'index')->name("Ingresses.index");
        Route::get('/Ingresses/New', 'create')->name("Ingresses.create")->middleware(ResourceControlMiddleware::class);
        Route::get('/Ingresses/{Namespace}/{Ingress}', 'show')->name("Ingresses.show");
        Route::post('/Ingresses/Store', 'store')->name("Ingresses.store")->middleware(ResourceControlMiddleware::class);
        Route::delete('/Ingresses/{Namespace}/{Ingress}', 'destroy')->name("Ingresses.destroy")->middleware(ResourceControlMiddleware::class);
    });

    Route::controller(BackupController::class)->group(function () {
        Route::get('/Backups', 'index')->name("Backups.index")->middleware(ResourceControlMiddleware::class);
        Route::post('/Backups', 'store')->name("Backups.store")->middleware(ResourceControlMiddleware::class);
    });

    Route::controller(CustomResourceController::class)->group(function () {
        Route::get('/CustomResources', 'index')->name("CustomResources.index")->middleware(ResourceControlMiddleware::class);
        Route::post('/CustomResources', 'store')->name("CustomResources.store")->middleware(ResourceControlMiddleware::class);
    });

    Route::fallback(function () {
    return redirect()->route('Clusters.index');
});
});
