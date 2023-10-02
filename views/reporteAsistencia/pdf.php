<style>
    .styled-table {
        border-collapse: collapse;
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
    }

    .styled-table th,
    .styled-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .styled-table th {
        background-color: #0074D9;
        color: #fff;
    }

    .styled-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    h1 {
        font-size: 24px;
        color: #333;
        text-align: center;
        margin-top: 20px;
    }


    footer {
        background-color: #333;
        color: #FFFFFF;
        text-align: center;
        padding: 10px;
        position: absolute;
        bottom: 0;
        width: 100%;
    }




    header {
        background-color: #0074D9;
        color: #FFFFFF;
        padding: 20px;
        text-align: center;
    }

    p {
        font-size: 18px;
        margin-top: 0;
    }
</style>

<table class="styled-table">
    <thead>
        <tr>
            <th>GRADO</th>
            <th>SECCION</th>
            <th>CANTIDAD_ALUMNOS</th>
            <th>PRESENTES</th>
            <th>AUSENTES</th>
            <th>FECHA</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($asistencias as $asistencia) : ?>
            <tr>                
                
                <td><?= $asistencia['grado_nombre'] ?></td>
                <td><?= $asistencia['seccion_nombre']?></td>
                <td><?= $asistencia['conteo']?></td>
                <td><?= $asistencia['presentes']?></td>
                <td><?= $asistencia['ausentes']?></td>
                <td><?= $asistencia['asistencia_fecha']?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


