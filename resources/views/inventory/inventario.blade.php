<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            font-size: 2em;
            margin-bottom: 20px;
        }

        /* Estilo para el formulario */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-size: 1.1em;
            color: #34495e;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .btn-primary {
            background-color: #2980b9;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #3498db;
        }

        /* Estilo para el botón de atrás */
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

        /* Estilo para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 1em;
        }

        table th {
            background-color: #2980b9;
            color: white;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        /* Estilo para el mensaje vacío */
        td[colspan="5"] {
            text-align: center;
            font-style: italic;
            color: #7f8c8d;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Inventario</h1>

        <!-- Formulario para filtrar por nombre -->
        <form action="{{ url()->current() }}" method="GET" style="margin-bottom: 20px;">
            <div class="form-group">
                <label for="search_name">Filtrar por nombre:</label>
                <input type="text" name="search_name" id="search_name" value="{{ request()->get('search_name') }}">
            </div>
            <button type="submit" class="btn-primary">Filtrar</button>
        </form>

        <!-- Botón de atrás -->
        <form action="{{ route('dashboard') }}" method="GET">
            <button type="submit" class="btn-back">Atrás</button>
        </form>

        <!-- Tabla de inventario -->
        <table>
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Número de Parte</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Comentario</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $searchName = request()->get('search_name');
                    $inventory = DB::table('inventory')
                        ->when($searchName, function ($query, $searchName) {
                            return $query->where('name', 'like', "%{$searchName}%");
                        })
                        ->get();
                @endphp

                @forelse ($inventory as $item)
                <tr>
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->part_number }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->comment ?? 'Ninguno' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No hay herramientas en el inventario.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>
