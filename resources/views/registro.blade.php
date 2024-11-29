<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
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
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 20px;
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
            max-width: 400px;
            margin: 0 auto;
        }

        .input-field {
            margin-bottom: 15px;
            width: 100%;
        }

        .input-field input,
        .input-field select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .input-field button {
            width: 100%;
            padding: 12px;
            background-color: #1e3a8a;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .input-field button:hover {
            background-color: #3347b2;
        }
    </style>
</head>

<body>
    @if (Auth::check() && Auth::user()->role === 'superuser')
        <header>
            <h1>Registro de Usuario</h1>
        </header>
        <div class="content">
            <div class="form-container">
                <h2>Crea una cuenta</h2>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="input-field">
                        <input type="text" name="name" placeholder="Nombre de usuario" value="{{ old('name') }}" required>
                    </div>
                    <div class="input-field">
                        <input type="password" name="password" placeholder="Contraseña" required>
                    </div>
                    <div class="input-field">
                        <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
                    </div>
                    <div class="input-field">
                        <select name="role" required>
                            <option value="" disabled selected>Seleccione un tipo de usuario</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-field">
                        <button type="submit">Registrar</button>
                    </div>
                </form>
                <div class="input-field">
                    <button type="button" onclick="window.history.back()">Atrás</button>
                </div>
            </div>
        </div>
    @else
        <div class="error-message">
            <h2>No tienes permiso para acceder a esta página.</h2>
        </div>
    @endif
</body>

</html>
