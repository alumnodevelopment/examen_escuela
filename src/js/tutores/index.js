import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion} from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje  } from "../lenguaje";


const formulario = document.querySelector('form');
const btnGuardar = document.getElementById('btnGuardar');
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnCancelar = document.getElementById('btnCancelar');

btnModificar.disabled = true;
btnModificar.parentElement.style.display = 'none';
btnCancelar.disabled = true;
btnCancelar.parentElement.style.display = 'none';

let contador = 1;
const datatable = new Datatable('#tablaAsistencia', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contador++
        },
        {
            title: 'GRADO',
            data: 'grado_id'
        },
        {
            title: 'Seccion',
            data: 'seccion_id'
        },
        {
            title: 'Alumno',
            data: 'alumno_id'
        },
        {
            title: 'FECHA',
            data: 'asistencia_fecha'
        },
        {
            title: 'MODIFICAR',
            data: 'asistencia_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning" data-id='${data}' data-grado='${row["grado_id"]}' data-seccion='${row["seccion_id"]}' data-alumno='${row["alumno_id"]}' data-fecha='${row["asistencia_fecha"]}'>Modificar</button>`
        },
        {
            title: 'ELIMINAR',
            data: 'asistencia_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}'>Eliminar</button>`
        }
    ]
});



const buscar = async () => {
    const grado_id = formulario.grado_id.value;
    const seccion_id = formulario.seccion_id.value;

    const url = `/examen_escuela/API/asistencia/buscar?grado_id=${grado_id}&seccion_id=${seccion_id}`;
    try {
        const respuesta = await fetch(url);
        const data = await respuesta.json();
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
        console.error(error);
    }
};

const guardar = async (evento) => {
    evento.preventDefault();
    if (!validarFormulario(formulario)) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        });
        return;
    }
    const body = new FormData(formulario);
    const url = '/examen_escuela/API/asistencia/guardar';
    try {
        const respuesta = await fetch(url, {
            method: 'POST',
            body
        });
        const data = await respuesta.json();
        const { codigo, mensaje } = data;
        let icon = 'info';
        if (codigo === 1) {
            formulario.reset();
            icon = 'success';
            buscar();
        } else {
            icon = 'error';
        }
        Toast.fire({
            icon,
            text: mensaje
        });
    } catch (error) {
        console.error(error);
    }
};


const modificar = async (evento) => {
    evento.preventDefault();
    if (!validarFormulario(formulario)) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los campos'
        });
        return;
    }
    const body = new FormData(formulario);
    const url = '/examen_escuela/API/asistencia/modificar';
    try {
        const respuesta = await fetch(url, {
            method: 'POST',
            body
        });
        const data = await respuesta.json();
        const { codigo, mensaje } = data;
        let icon = 'info';
        if (codigo === 1) {
            formulario.reset();
            icon = 'success';
            buscar();
            cancelarAccion();
        } else {
            icon = 'error';
        }
        Toast.fire({
            icon,
            text: mensaje
        });
    } catch (error) {
        console.error(error);
    }
};

const eliminar = async (e) => {
    const button = e.target;
    const id = button.dataset.id;
    if (await confirmacion('warning', '¿Desea eliminar este registro?')) {
        const body = new FormData();
        body.append('tutor_id', id);
        const url = '/examen_escuela/API/asistencia/eliminar';
        try {
            const respuesta = await fetch(url, {
                method: 'POST',
                body
            });
            const data = await respuesta.json();
            const { codigo, mensaje } = data;
            let icon = 'info';
            if (codigo === 1) {
                icon = 'success';
                buscar();
            } else {
                icon = 'error';
            }
            Toast.fire({
                icon,
                text: mensaje
            });
        } catch (error) {
            console.error(error);
        }
    }
};

const traeDatos = (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const grado = button.dataset.grado;
    const seccion = button.dataset.seccion;
    const alumno = button.dataset.alumno;
    const fecha = button.dataset.fecha;

    const dataset = {
        id,
        grado,
        seccion,
        alumno,
        fecha
    };
    colocarDatos(dataset);
};
const colocarDatos = (dataset) => {
    formulario.grado_id.value = dataset.grado;
    formulario.seccion_id.value = dataset.seccion;
    formulario.alumno_id.value = dataset.alumno;
    formulario.asistencia_fecha.value = dataset.fecha;
    formulario.asistencia_id.value = dataset.id;

    btnGuardar.disabled = true;
    btnGuardar.parentElement.style.display = 'none';
    btnBuscar.disabled = true;
    btnBuscar.parentElement.style.display = 'none';
    btnModificar.disabled = false;
    btnModificar.parentElement.style.display = '';
    btnCancelar.disabled = false;
    btnCancelar.parentElement.style.display = '';
};

const cancelarAccion = () => {
    formulario.reset();
    btnGuardar.disabled = false;
    btnGuardar.parentElement.style.display = '';
    btnBuscar.disabled = false;
    btnBuscar.parentElement.style.display = '';
    btnModificar.disabled = true;
    btnModificar.parentElement.style.display = 'none';
    btnCancelar.disabled = true;
    btnCancelar.parentElement.style.display = 'none';
};

formulario.addEventListener('submit', guardar);
btnBuscar.addEventListener('click', buscar);
btnCancelar.addEventListener('click', cancelarAccion);
datatable.on('click', '.btn-warning', traeDatos);
datatable.on('click', '.btn-danger', eliminar);
