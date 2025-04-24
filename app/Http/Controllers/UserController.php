<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index(Request $request): View
{
    // Obter o número de itens por página (padrão: 10)
    $perPage = $request->input('perPage', 10);
    
    // Obter o termo de pesquisa
    $search = $request->input('search');
    
    // Iniciar a query
    $query = User::query();
    
    // Aplicar filtro de pesquisa se existir
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }
    
    // Ordenar por ID (opcional) e paginar
    $users = $query->orderBy('id')->paginate($perPage);
    
    // Retornar a view com os usuários paginados
    return view('users.index', [
        'users' => $users,
        'search' => $search,
        'perPage' => $perPage
    ]);
}

    public function create(): View
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'admin' => $request->has('admin') ? 1 : 0,
        ]);

        return redirect()->route('users_all')->with('success-msg', "User created successfully");
    }

    public function edit($id): View
    {
        $user = User::findOrFail($id);
        return view('users.edit', ['user' => $user]);
    }

    public function editMe(): View
    {
        return view('profile.edit', [
            'user' => auth()->user()
        ]);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validated();
        $validated['admin'] = $request->has('admin') ? 1 : 0;
        
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        
        $user->update($validated);
        
        return auth()->user()->admin == 1
            ? redirect()->route('users_all')->with('success-msg', "User updated successfully")
            : redirect()->route('profile.edit')->with('success-msg', "Profile updated");
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        
        User::findOrFail($id)->update([
            'password' => Hash::make($request->password)
        ]);
        
        return back()->with('success-msg', 'Password updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users_all')->with('success-msg', "User deleted successfully");
    }
}
