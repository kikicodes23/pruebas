<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Constancia de Notas</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            color: #333;
        }

        .header-container {
            width: 100%;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .logo {
            width: 80px;
            float: left;
            margin-right: 20px;
        }
        .header-text {
            overflow: hidden;
            text-align: center;
            padding-top: 10px;
        }
        .header-text h2 { margin: 0; font-size: 22px; text-transform: uppercase; }
        .header-text p { margin: 5px 0 0; font-size: 14px; font-weight: normal; }

        .student-info {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .student-info td {
            padding: 5px;
            vertical-align: top;
        }

        table.grades {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table.grades th, table.grades td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        table.grades th {
            background-color: #2b7fff;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        .text-center { text-align: center !important; }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 30px;
            font-size: 11px;
            text-align: center;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header-container">
        <img src="{{ public_path('images/uca.png') }}" class="logo" alt="Logo UCA">

        <div class="header-text">
            <h2>Constancia de Notas</h2>
            <p>Reporte Oficial de Calificaciones</p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <table class="student-info">
        <tr>
            <td width="15%"><strong>Estudiante:</strong></td>
            <td width="45%">{{ $student->name }} {{ $student->lastname }}</td>
            <td width="15%"><strong>Carnet:</strong></td>
            <td width="25%">{{ $student->carnet }}</td>
        </tr>
        <tr>
            <td><strong>Carrera:</strong></td>
            <td>{{ $student->career }}</td>
            <td><strong>Fecha:</strong></td>
            <td>{{ date('d/m/Y') }}</td>
        </tr>
    </table>

    <table class="grades">
        <thead>
            <tr>
                <th class="text-center">Ciclo</th>
                <th class="text-center">Código</th>
                <th>Materia</th>
                <th class="text-center">UV</th>
                <th class="text-center">Nota</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registers as $register)
            <tr>
                <td class="text-center">
                    Ciclo {{ str_pad($register->semester->semester_number, 2, '0', STR_PAD_LEFT) }}/{{ $register->semester->year }}
                </td>

                <td class="text-center">{{ $register->subject->code }}</td>
                <td>{{ $register->subject->name }}</td>
                <td class="text-center">{{ $register->subject->uv }}</td>
                <td class="text-center"><strong>{{ number_format($register->grade, 1) }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generado por el sistema académico UCA
    </div>

</body>
</html>
