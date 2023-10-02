<style>
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            border: 2px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
        }
        th {
            background-color: #f2f2f2;
        }
    
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <br>
    <h2>Hoja de Solvencia</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Alumno</th>   
                <th>Mes</th>             
                <th>Monto</th>
                <th>Solvente</th>
               
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pagos as $pago) : ?>
                <tr>
                    <td><?= $pago['pago_fecha'] ?></td>
                    <td><?= $pago['alumno_nombre'] ?></td>
                    <td><?= $pago['pago_mes'] ?></td>
                    <td><?= $pago['pago_monto'] ?></td>
                    <td><?= $pago['pago_solvencia'] ?></td>
                    
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>