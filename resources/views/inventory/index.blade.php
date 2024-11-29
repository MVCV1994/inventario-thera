<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <style>
        /* CSS embebido */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea,
        .form-group button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-group button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-warning {
            background-color: #ffc107;
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-back {
            background-color: #95a5a6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: #7f8c8d;
        }

        .action-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 5px;
        }

        .action-form label {
            margin-bottom: 5px;
            font-size: 14px;
        }

        .action-form input {
            width: 60%;
            padding: 5px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .action-form button {
            width: auto;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
        }

        .action-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="{{ route('dashboard') }}" method="GET">
            <button type="submit" class="btn-back">Atrás</button>
        </form>

        <h1>Inventario</h1>

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'superuser')
        <form action="{{ route('inventory.store') }}" method="POST" style="margin-bottom: 20px;">
            @csrf
            <div class="form-group">
                <label for="type">Tipo de Herramienta:</label>
                <input type="text" name="type" id="type" required>
            </div>
            <div class="form-group">
                <label for="part_number">Número de Parte:</label>
                <input type="text" name="part_number" id="part_number" required>
            </div>
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="quantity">Cantidad:</label>
                <input type="number" name="quantity" id="quantity" min="0" required>
            </div>
            <div class="form-group">
                <label for="comment">Comentario (opcional):</label>
                <textarea name="comment" id="comment"></textarea>
            </div>
            <button type="submit" class="btn-primary">Añadir Herramienta</button>
        </form>
        @endif

        @if ($inventory->count() > 0 && auth()->user()->role === 'superuser')
        <form action="{{ route('inventory.delete_all') }}" method="POST" style="margin-bottom: 20px;">
            @csrf
            <button type="submit" class="btn-danger">Eliminar Todo el Inventario</button>
        </form>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Número de Parte</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Comentario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($inventory as $item)
                <tr>
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->part_number }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->comment ?? 'Ninguno' }}</td>
                    <td>
                        <div class="action-container">
                            <form action="{{ route('inventory.reduce_quantity', $item->id) }}" method="POST" class="action-form">
                                @csrf
                                <label for="quantity_to_remove">Reducir Cantidad:</label>
                                <input type="number" name="quantity_to_remove" min="1" max="{{ $item->quantity }}" value="1" required>
                                <button type="submit" class="btn-warning" @if ($item->quantity <= 0) disabled @endif>Reducir Cantidad</button>
                            </form>

                            <form action="{{ route('inventory.increase_quantity', $item->id) }}" method="POST" class="action-form">
                                @csrf
                                <label for="quantity_to_add">Incrementar:</label>
                                <input type="number" name="quantity_to_add" min="1" value="1" required>
                                <button type="submit" class="btn-primary">Incrementar</button>
                            </form>

                            @if (auth()->user()->role === 'superuser')
                            <form action="{{ route('inventory.delete', $item->id) }}" method="POST" class="action-form">
                                @csrf
                                <button type="submit" class="btn-danger">Eliminar</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center;">No hay herramientas en el inventario.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>
