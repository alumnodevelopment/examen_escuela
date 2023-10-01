import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import { lenguaje } from "../lenguaje";
import Datatable from "datatables.net-bs5";

const formulario = document.getElementById('formularioConducta'); 
const btnGuardar = document.getElementById('btnGuardar');
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnCancelar = document.getElementById('btnCancelar');
const divTabla = document.getElementById('tablaConducta'); 


    btnModificar.disabled = true;
    btnModificar.parentElement.style.display = 'none';
    btnCancelar.disabled = true;
    btnCancelar.parentElement.style.display = 'none';
    btnBuscar.disabled = true;
    btnBuscar.parentElement.style.display = 'none';


let contador = 1;
const datatable = new Datatable('#tablaConducta', {
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
            data: 'conducta_fecha' 
        },
        {
            title: 'DESCRIPCIÓN', 
            data: 'conducta_descripcion'
        },
        {
            title: 'MODIFICAR',
            data: 'conducta_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning" data-id='${data}' data-alumno='${row["alumno_id"]}'
            data-fecha='${row["conducta_fecha"]}' data-descripcion='${row["conducta_descripcion"]}'>Modificar</button>`
        },
        {
            title: 'ELIMINAR',
            data: 'conducta_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}' >Eliminar</button>`
        },
    ]
});

const buscar = async () => {
    let alumno_id = formulario.alumno_id.value; 
    let conducta_fecha = formulario.conducta_fecha.value; 
    console.log('test: "' + alumno_id + '"'+ conducta_fecha );

    const url = `/examen_escuela/API/conductas/buscar?alumno_id=${alumno_id}&conducta_fecha=${conducta_fecha}`; 
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

    if (!validarFormulario(formulario, ['conducta_id'])) { 
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        });
        return;
    }

    const body = new FormData(formulario)
    body.delete('conducta_id')
    const url = '/examen_escuela/API/conductas/guardar'; 

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
        body.append('conducta_id', id);
        const url = '/examen_escuela/API/conductas/eliminar';
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
    const descripcion = button.dataset.descripcion;


    const dataset = {
        id,
        alumno,
        fecha,
        descripcion
    };

    colocarDatos(dataset);
    const body = new FormData(formulario);
    body.append('conducta_id', id);
    body.append('alumno_nombre', alumno);
    body.append('conducta_fecha', fecha);
    body.append('conducta_descripcion', descripcion);
};

const colocarDatos = (dataset) => {
    formulario.alumno_id.value = dataset.alumno;
    formulario.conducta_fecha.value = dataset.fecha;
    formulario.conducta_descripcion.value = dataset.descripcion;
    formulario.conducta_id.value = dataset.id;

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

    const url = '/examen_escuela/API/conductas/modificar';

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