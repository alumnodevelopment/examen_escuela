import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import { lenguaje } from "../lenguaje";
import Datatable from "datatables.net-bs5";

const formulario = document.getElementById('formularioPago'); 
const btnGuardar = document.getElementById('btnGuardar');
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnCancelar = document.getElementById('btnCancelar');
const divTabla = document.getElementById('tablaPagos'); 

btnModificar.disabled = true;
btnModificar.parentElement.style.display = 'none';
btnCancelar.disabled = true;
btnCancelar.parentElement.style.display = 'none';
btnBuscar.disabled = true;
btnBuscar.parentElement.style.display = 'none';

let contador = 1;
const datatable = new Datatable('#tablaPagos', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contador++
        },
        {
            title: 'ALUMNO', 
            data: 'alumno_nombre' 
        },
        {
            title: 'FECHA', 
            data: 'pago_fecha' 
        },
        {
            title: 'MES', 
            data: 'pago_mes' 
        },
        {
            title: 'MONTO', 
            data: 'pago_monto'
        },
        {
            title: 'SOLVENCIA', 
            data: 'pago_solvencia'
        },
        {
            title: 'MODIFICAR',
            data: 'pago_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning" data-id='${data}' data-alumno='${row["pago_alumno_id"]}'
            data-fecha='${row["pago_fecha"]}' data-mes='${row["pago_mes"]}' data-monto='${row["pago_monto"]}' data-solvencia='${row["pago_solvencia"]}'>Modificar</button>`
        },
        {
            title: 'ELIMINAR',
            data: 'pago_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}' >Eliminar</button>`
        },
    ]
});

const buscar = async () => {
    let alumno_id = formulario.pago_alumno_id.value; 
    let pago_fecha = formulario.pago_fecha.value; 
    console.log('test: "' + alumno_id + '"'+ pago_fecha );

    const url = `/examen_escuela/API/pagos/buscar?alumno_id=${alumno_id}&pago_fecha=${pago_fecha}`; 
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);

        datatable.clear().draw();
        if (data) {
            contador = 1;
            datatable.rows.add(data).draw();
        } else {
            Toast.fire({
                title: 'No se encontraron registros',
                icon: 'info'
            });
        }

    } catch (error) {
        console.log(error);
    }
};

const guardar = async (evento) => {
    evento.preventDefault();

    if (!validarFormulario(formulario, ['pago_id'])) { 
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        });
        return;
    }

    const body = new FormData(formulario)
    body.delete('pago_id')
    const url = '/examen_escuela/API/pagos/guardar'; 

    const config = {
        method: 'POST',
        body
    };

    const respuesta = await fetch(url, config);
    const data = await respuesta.text();
    
    try {
        const jsonData = JSON.parse(data);
    
        const { codigo, mensaje, detalle } = jsonData;
        let icon = 'info';
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success';
                buscar();
                break;

            case 0:
                icon = 'error';
                console.log(detalle);
                break;

            default:
                break;
        }

        Toast.fire({
            icon,
            text: mensaje
        });

    } catch (error) {
        console.log(error);
    }
};

const eliminar = async (e) => {
    const button = e.target;
    const id = button.dataset.id;

    if (await confirmacion('warning', '¿Desea eliminar este registro?')) {
        const body = new FormData();
        body.append('pago_id', id);
        const url = '/examen_escuela/API/pagos/eliminar';
        const config = {
            method: 'POST',
            body
        };

        try {
            const respuesta = await fetch(url, config);
            const data = await respuesta.json();

            const { codigo, mensaje, detalle } = data;
            let icon = 'info';
            switch (codigo) {
                case 1:
                    icon = 'success';
                    buscar();
                    break;

                case 0:
                    icon = 'error';
                    console.log(detalle);
                    break;

                default:
                    break;
            }
            Toast.fire({
                icon,
                text: mensaje
            });
        } catch (error) {
            console.log(error);
        }
    }
};

const cancelarAccion = () => {
    btnGuardar.disabled = false;
    btnGuardar.parentElement.style.display = '';
    btnBuscar.disabled = false;
    btnBuscar.parentElement.style.display = '';
    btnModificar.disabled = true;
    btnModificar.parentElement.style.display = 'none';
    btnCancelar.disabled = true;
    btnCancelar.parentElement.style.display = 'none';
    divTabla.style.display = '';
};

const traeDatos = (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const alumno = button.dataset.alumno;
    const fecha = button.dataset.fecha;
    const mes = button.dataset.mes;
    const monto = button.dataset.monto;
    const solvencia = button.dataset.solvencia;

    const dataset = {
        id,
        alumno,
        fecha,
        mes,
        monto,
        solvencia
    };

    colocarDatos(dataset);
    const body = new FormData(formulario);
    body.append('pago_id', id);
    body.append('pago_alumno_id', alumno);
    body.append('pago_fecha', fecha);
    body.append('pago_mes', mes);
    body.append('pago_monto', monto);
    body.append('pago_solvencia', solvencia);
};

const colocarDatos = (dataset) => {
    formulario.pago_alumno_id.value = dataset.alumno;
    formulario.pago_fecha.value = dataset.fecha;
    formulario.pago_mes.value = dataset.mes;
    formulario.pago_monto.value = dataset.monto;
    formulario.pago_solvencia.value = dataset.solvencia;
    formulario.pago_id.value = dataset.id;

    btnGuardar.disabled = true;
    btnGuardar.parentElement.style.display = 'none';
    btnBuscar.disabled = true;
    btnBuscar.parentElement.style.display = 'none';

    btnModificar.disabled = false;
    btnModificar.parentElement.style.display = '';
    btnCancelar.disabled = false;
    btnCancelar.parentElement.style.display = '';
};

const modificar = async () => {
    if (!validarFormulario(formulario)) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        });
        return;
    }
    const body = new FormData(formulario);

    const url = '/examen_escuela/API/pagos/modificar';

    const config = {
        method: 'POST',
        body
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        const { codigo, mensaje, detalle } = data;
        let icon = 'info';
        switch (codigo) {
            case 1:
                formulario.reset();
                Toast.fire({
                    icon: 'success',
                    text: mensaje
                });
                buscar();
                cancelarAccion();
                break;

            case 0:
                Toast.fire({
                    icon: 'error',
                    text: mensaje
                });
                console.log(detalle);
                break;

            default:
                break;
        }

        Toast.fire({
            icon,
            text: mensaje
        });

    } catch (error) {
        console.log(error);
    }
};

if (formulario) {
    buscar();
    formulario.addEventListener('submit', guardar);
    btnBuscar.addEventListener('click', buscar);
    btnCancelar.addEventListener('click', cancelarAccion);
    btnModificar.addEventListener('click', modificar);
    datatable.on('click', '.btn-warning', traeDatos);
    datatable.on('click', '.btn-danger', eliminar);
}