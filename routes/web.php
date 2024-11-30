<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// Ruta para la página principal (Bienvenida)//mensaje para ver si se actualizo github
Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('loginForm');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('registerForm');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Ruta para cerrar sesión
Route::post('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout(); // Desautentica al usuario
    \Illuminate\Support\Facades\Session::invalidate(); // Invalida todos los datos de la sesión
    \Illuminate\Support\Facades\Session::regenerateToken(); // Regenera el token CSRF

    return redirect('/')->with('success', 'Sesión cerrada correctamente.');
})->name('logout');

// Ruta principal para el dashboard (redirige según el rol)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Mostrar inventario
Route::get('/inventory', function () {
    $inventory = DB::table('inventory')->get();
    return view('inventory.index', compact('inventory'));
})->name('inventory.index');

// Agregar herramienta
Route::post('/inventory/store', function (Request $request) {
    if (!Auth::check() || !(Auth::user()->role === 'admin' || Auth::user()->role === 'superuser')) {
        return redirect()->route('inventory.index')->with('error', 'No tienes permiso para agregar herramientas.');
    }

    $request->validate([
        'type' => 'required|string|max:255',
        'part_number' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'quantity' => 'required|integer|min:0',
        'comment' => 'nullable|string|max:1000',
    ]);

    DB::table('inventory')->insert([
        'type' => $request->type,
        'part_number' => $request->part_number,
        'name' => $request->name,
        'quantity' => $request->quantity,
        'comment' => $request->comment,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('inventory.index')->with('success', 'Herramienta añadida con éxito.');
})->name('inventory.store');

// Eliminar herramienta
Route::post('/inventory/delete/{id}', function ($id) {
    if (!Auth::check() || !(Auth::user()->role === 'admin' || Auth::user()->role === 'superuser')) {
        return redirect()->route('inventory.index')->with('error', 'No tienes permiso para eliminar herramientas.');
    }

    DB::table('inventory')->where('id', $id)->delete();

    return redirect()->route('inventory.index')->with('success', 'Herramienta eliminada con éxito.');
})->name('inventory.delete');

// Eliminar todo el inventario
Route::post('/inventory/delete_all', function () {
    if (!Auth::check() || !(Auth::user()->role === 'admin' || Auth::user()->role === 'superuser')) {
        return redirect()->route('inventory.index')->with('error', 'No tienes permiso para eliminar todo el inventario.');
    }

    // Eliminar todos los registros del inventario
    DB::table('inventory')->truncate();

    return redirect()->route('inventory.index')->with('success', 'Todo el inventario ha sido eliminado.');
})->name('inventory.delete_all');

// Reducir cantidad de herramienta
Route::post('/inventory/reduce_quantity/{id}', function ($id, Request $request) {
    if (!Auth::check() || !(Auth::user()->role === 'admin' || Auth::user()->role === 'superuser')) {
        return redirect()->route('inventory.index')->with('error', 'No tienes permiso para reducir la cantidad de herramientas.');
    }

    // Obtener la herramienta del inventario
    $item = DB::table('inventory')->where('id', $id)->first();

    if (!$item) {
        return redirect()->route('inventory.index')->with('error', 'La herramienta no existe.');
    }

    // Obtener la cantidad a reducir del formulario
    $quantityToRemove = $request->input('quantity_to_remove');  // Aquí se obtiene correctamente el valor

    // Validar que la cantidad a reducir no sea mayor que la cantidad en inventario
    if ($quantityToRemove > $item->quantity) {
        return redirect()->route('inventory.index')->with('error', 'No puedes reducir más de lo que hay en inventario.');
    }

    // Reducir la cantidad
    DB::table('inventory')->where('id', $id)->update([
        'quantity' => $item->quantity - $quantityToRemove,
        'updated_at' => now(),
    ]);

    return redirect()->route('inventory.index')->with('success', 'Cantidad reducida correctamente.');
})->name('inventory.reduce_quantity');


//tabla de inventario.blade.php

Route::get('/inventario', function () {
    $searchName = request()->get('search_name');

    // Consulta directa a la base de datos
    $inventory = DB::table('inventory') // Asegúrate de que 'inventory' es el nombre correcto de tu tabla
        ->when($searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
        ->get();

    return view('inventory.inventario', compact('inventory'));
})->name('inventory.filter');


Route::get('/inventario', function () {
    $searchName = request()->get('search_name');

    // Consulta directa a la base de datos
    $inventory = DB::table('inventory') // Asegúrate de que 'inventory' es el nombre correcto de tu tabla
        ->when($searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
        ->get();

    return view('inventory.inventario', compact('inventory'));
})->name('inventory.inventario');

Route::get('/inventario/filter', function () {
    $searchName = request()->get('search_name');

    $inventory = DB::table('inventory')
        ->when($searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
        ->get();

    return view('inventory.inventario', compact('inventory'));
})->name('inventory.filter');



Route::post('/inventory/{id}/reduce', function ($id) {
    $inventory = DB::table('inventory')->where('id', $id)->first();
    $quantityToRemove = request('quantity_to_remove');

    if ($quantityToRemove > 0 && $inventory->quantity >= $quantityToRemove) {
        DB::table('inventory')
            ->where('id', $id)
            ->update(['quantity' => $inventory->quantity - $quantityToRemove]);

        return redirect()->back()->with('success', 'Cantidad reducida correctamente.');
    } else {
        return redirect()->back()->with('error', 'Cantidad inválida o insuficiente.');
    }
})->name('inventory.reduce_quantity');

Route::post('/inventory/{id}/increase', function ($id) {
    $inventory = DB::table('inventory')->where('id', $id)->first();
    $quantityToAdd = request('quantity_to_add');

    if ($quantityToAdd > 0) {
        DB::table('inventory')
            ->where('id', $id)
            ->update(['quantity' => $inventory->quantity + $quantityToAdd]);

        return redirect()->back()->with('success', 'Cantidad incrementada correctamente.');
    } else {
        return redirect()->back()->with('error', 'Cantidad inválida.');
    }
})->name('inventory.increase_quantity');


// modificar y eliminar usuario 
Route::get('/users/edit', [AuthController::class, 'showEditUsers'])->name('edit.users');
Route::post('/users/update', [AuthController::class, 'updateUser'])->name('update.user');
Route::post('/users/delete', [AuthController::class, 'deleteUser'])->name('delete.user');
