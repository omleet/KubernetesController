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
    BridgeController,
    DeviceController,
    DhcpController,
    DnsController,
    InterfacesController,
    IpAddressController,
    ProfileController,
    SecurityProfileController,
    StaticRouteController,
    UserController,
    WirelessController
};

use App\Http\Middleware\{
    AdminMiddleware,
    DeviceControlMiddleware,
    EditUserMiddleware
};

use Illuminate\Support\Facades\Route;


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
    Route::get('/dashboard', [DeviceController::class, 'index'])->name('dashboard');
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

    // Rotas de dispositivos
    Route::controller(DeviceController::class)->group(function () {
        Route::resource('/Devices', DeviceController::class)->except(['index', 'create', 'store'])->middleware(DeviceControlMiddleware::class);
        Route::get('/{Device}/Overview', 'indexDevice')->name("Devices.index")->middleware(DeviceControlMiddleware::class);
        Route::get('/Device/create', 'create')->name("Devices.create");
        Route::post('/Device', 'store')->name("Devices.store");

        ///////////////////////////////////////////
        Route::get('/set-device-session/{device}', function($device) {
            session(['selectedDevice' => $device]);
            return response()->json(['success' => true]);
        })->name('set-device-session')->middleware(DeviceControlMiddleware::class);
    });

    // Rotas específicas de dispositivos
    Route::middleware(DeviceControlMiddleware::class)->group(function() {
        Route::resource('/{Device}/Interfaces', InterfacesController::class);

        // Bridges
        Route::controller(BridgeController::class)->group(function () {
            Route::resource('/{Device}/Bridges', BridgeController::class);
            Route::post('/{Device}/Bridges/NewCustom', 'storeCustom')->name("bridge_storeCustom");
            Route::put('/{Device}/Bridges/{id}/EditCustom', 'updateCustom')->name("bridge_updateCustom");
        });

        // Security Profiles
        Route::controller(SecurityProfileController::class)->group(function () {
            Route::resource('/{Device}/SecurityProfiles', SecurityProfileController::class);
            Route::post('/{Device}/SecurityProfiles/NewCustom', 'storeCustom')->name("sp_storeCustom");
            Route::put('/{Device}/SecurityProfiles/{id}/EditCustom', 'updateCustom')->name("sp_updateCustom");
        });

        // Wireless
        Route::controller(WirelessController::class)->group(function () {
            Route::resource('/{Device}/Wireless', WirelessController::class);
            Route::post('/{Device}/Wireless/NewCustom', 'storeCustom')->name("wireless_storeCustom");
            Route::put('/{Device}/Wireless/{id}/EditCustom', 'updateCustom')->name("wireless_updateCustom");
        });

        // IP Addresses
        Route::controller(IpAddressController::class)->group(function () {
            Route::resource('/{Device}/IPAddresses', IpAddressController::class);
            Route::post('/{Device}/IPAddresses/NewCustom', 'storeCustom')->name("address_storeCustom");
            Route::put('/{Device}/IPAddresses/{id}/EditCustom', 'updateCustom')->name("address_updateCustom");
        });

        // Static Routes
        Route::controller(StaticRouteController::class)->group(function () {
            Route::resource('/{Device}/StaticRoutes', StaticRouteController::class);
            Route::post('/{Device}/StaticRoutes/NewCustom', 'storeCustom')->name("sr_storeCustom");
            Route::put('/{Device}/StaticRoutes/{id}/EditCustom', 'updateCustom')->name("sr_updateCustom");
        });

        // DHCP
        Route::controller(DhcpController::class)->group(function () {
            // DHCP Servers
            Route::get('/{Device}/DHCPServers', 'servers')->name("dhcp_servers");
            Route::get('/{Device}/DHCPServers/New', 'createDhcpServer')->name("createDhcpServer");
            Route::get('/{Device}/DHCPServers/{DHCPServer}', 'showDhcpServer')->name("showDhcpServer");
            Route::post('/{Device}/DHCPServers/New', 'storeDhcpServer')->name("storeDhcpServer");
            Route::post('/{Device}/DHCPServers/NewCustom', 'storeServerCustom')->name("dhcp_storeServerCustom");
            Route::get('/{Device}/DHCPServers/edit/{DHCPServer}', 'editDhcpServer')->name("editDhcpServer");
            Route::put('/{Device}/DHCPServers/edit/{DHCPServer}', 'updateDhcpServer')->name("updateDhcpServer");
            Route::put('/{Device}/DHCPServers/{id}/EditCustom', 'updateServerCustom')->name("dhcp_updateServerCustom");
            Route::delete('/{Device}/DHCPServers/{DHCPServer}', 'destroyDhcpServer')->name("destroyDhcpServer");
            
            // DHCP Clients
            Route::get('/{Device}/DHCPClients', 'client')->name("dhcp_client");
            Route::get('/{Device}/DHCPClients/New', 'createDhcpClient')->name("createDhcpClient");
            Route::get('/{Device}/DHCPClients/{DHCPClient}', 'showDhcpClient')->name("showDhcpClient");
            Route::post('/{Device}/DHCPClients/New', 'storeDhcpClient')->name("storeDhcpClient");
            Route::post('/{Device}/DHCPClients/NewCustom', 'storeClientCustom')->name("dhcp_storeClientCustom");
            Route::get('/{Device}/DHCPClients/edit/{DHCPClient}', 'editDhcpClient')->name("editDhcpClient");
            Route::put('/{Device}/DHCPClients/edit/{DHCPClient}', 'updateDhcpClient')->name("updateDhcpClient");
            Route::put('/{Device}/DHCPClients/{id}/EditCustom', 'updateClientCustom')->name("dhcp_updateClientCustom");
            Route::delete('/{Device}/DHCPClients/{DHCPClient}', 'destroyDhcpClient')->name("destroyDhcpClient");
        });

        // DNS
        Route::controller(DnsController::class)->group(function () {
            // DNS Server
            Route::get('/{Device}/DNSServer', 'server')->name("dns_server");
            Route::get('/{Device}/DNSServer/edit', 'editDnsServer')->name("editDnsServer");
            Route::post('/{Device}/DNSServer/edit', 'storeDnsServer')->name("storeDnsServer");
            Route::post('/{Device}/DNSServer/EditCustom', 'storeServerCustom')->name("dns_storeServerCustom");
            
            // DNS Static Records
            Route::get('/{Device}/DNSStaticRecords', 'records')->name("dns_records");
            Route::get('/{Device}/DNSStaticRecords/New', 'createDnsRecord')->name("createDnsRecord");
            Route::get('/{Device}/DNSStaticRecords/{DNSStaticRecord}', 'showDnsRecord')->name("showDnsRecord");
            Route::post('/{Device}/DNSStaticRecords/New', 'storeDnsRecord')->name("storeDnsRecord");
            Route::post('/{Device}/DNSStaticRecords/NewCustom', 'storeRecordCustom')->name("dns_storeRecordCustom");
            Route::get('/{Device}/DNSStaticRecords/edit/{DNSStaticRecord}', 'editDnsRecord')->name("editDnsRecord");
            Route::put('/{Device}/DNSStaticRecords/edit/{DNSStaticRecord}', 'updateDnsRecord')->name("updateDnsRecord");
            Route::put('/{Device}/DNSStaticRecords/EditCustom/{id}', 'updateRecordCustom')->name("dns_updateRecordCustom");
            Route::delete('/{Device}/DNSStaticRecords/{DNSStaticRecord}', 'destroyDnsRecord')->name("destroyDnsRecord");
        });

    });
});