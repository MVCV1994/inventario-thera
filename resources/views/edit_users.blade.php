<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuarios</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #1e3a8a;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: relative;
        }

        .btn-back {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 8px 15px;
            background-color: #3347b2;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #4967d0;
        }

        .content {
            padding: 20px;
            text-align: center;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #1e3a8a;
            color: white;
        }

        .input-field button {
            padding: 8px 12px;
            background-color: #1e3a8a;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }

        .input-field button:hover {
            background-color: #3347b2;
        }
    </style>
</head>

<body>
    <header>
        <h1>Editar Usuarios</h1>
        <form action="{{ route('dashboard') }}" method="GET" style="display: inline;">
            <button type="submit" class="btn-back">Atrás</button>
        </form>
    </header>
    <div class="content">
        <div class="form-container">
            <h2>Lista de Usuarios</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            <form method="POST" action="{{ route('update.user') }}" style="display: inline-block;">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <select name="role" required>
                                    <option value="superuser" {{ $user->role === 'superuser' ? 'selected' : '' }}>Superuser</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                </select>
                                <button type="submit">Actualizar</button>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('delete.user') }}" style="display: inline-block;">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>