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
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<table class="styled-table">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Cantidad</th>
            <th>Producto</th>
            <th>Cliente</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ventas as $venta) : ?>
            <tr>
                <td><?= $venta->fecha ?></td>
                <td><?= $venta->cantidad ?></td>
                <td><?= $venta->producto ?></td>
                <td><?= $venta->cliente ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>