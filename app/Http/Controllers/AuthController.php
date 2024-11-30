<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Mostrar el formulario de login.
     */
    public function showLoginForm()
    {
        return view('login'); // Vista 'login' debe estar en resources/views/login.blade.php
    }

    /**
     * Procesar el login.
     */
    public function login(Request $request)
    {
        // Validación de los campos de login
        $request->validate([
            'name' => 'required', // Campo del nombre de usuario
            'password' => 'required|min:6',
        ]);

        // Intentar autenticar al usuario
        if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
            // Redirigir al dashboard principal
            return redirect()->route('dashboard');
        }

        // Si el login falla, redirigir al formulario con un error
        return back()->withErrors([
            'error' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    /**
     * Mostrar el formulario de registro.
     */
    public function showRegisterForm()
    {
        $roles = ['superuser', 'admin', 'user']; // Lista estática de roles
        return view('registro', compact('roles')); // Pasa los roles a la vista
    }

    /**
     * Procesar el registro.
     */
    public function register(Request $request)
    {
        // Validación de los datos de registro
        $request->validate([
            'name' => 'required|unique:users,name', // Nombre de usuario único
            'password' => 'required|min:6|confirmed', // Confirmación de contraseña
            'role' => 'required|in:superuser,admin,user', // Valida roles permitidos
        ]);

        // Crear un nuevo usuario
        User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password), // Encripta la contraseña
            'role' => $request->role, // Asigna el rol seleccionado
        ]);

        // Redirigir al login con un mensaje de éxito
        return redirect()->route('loginForm')->with('success', 'Usuario registrado exitosamente. Ahora puedes iniciar sesión.');
    }

    /**
     * Mostrar el formulario para editar usuarios.
     */
    public function showEditUsers()
    {
        if (Auth::check() && Auth::user()->role === 'superuser') {
            $users = User::all(); // Obtener todos los usuarios
            return view('edit_users', compact('users'));
        } else {
            return abort(403, 'No tienes permiso para acceder a esta página.');
        }
    }

    /**
     * Actualizar el rol de un usuario.
     */
    public function updateUser(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:superuser,admin,user',
        ]);

        // Buscar al usuario y actualizar su rol
        $user = User::find($request->user_id);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('edit.users')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar un usuario.
     */
    public function deleteUser(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Buscar al usuario y eliminarlo
        $user = User::find($request->user_id);
        $user->delete();

        return redirect()->route('edit.users')->with('success', 'Usuario eliminado correctamente.');
    }

    /**
     * Dashboard principal.
     */
    public function dashboard()
    {
        return redirect()->route('dashboard'); // Centraliza el manejo en DashboardController
    }
}
