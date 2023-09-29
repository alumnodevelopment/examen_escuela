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
const datatable = new Datatable('#tablaTutor', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contador++
        },
        {
            title: 'Nombre del Tutor',
            data: 'tutor_nombre'
        },
        {
            title: 'Teléfono',
            data: 'tutor_telefono'
        },
        {
            title: 'Parentezco',
            data: 'tutor_parentezco'
        },
        {
            title: 'ID del Alumno',
            data: 'alumno_id'
        },
        {
            title: 'MODIFICAR',
            data: 'tutor_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning" data-id='${data}' data-nombre='${row["tutor_nombre"]}' data-telefono='${row["tutor_telefono"]}' data-parentezco='${row["tutor_parentezco"]}' data-alumno='${row["alumno_id"]}' data-situacion='${row["tutor_situacion"]}'>Modificar</button>`
        },
        {
            title: 'ELIMINAR',
            data: 'tutor_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}'>Eliminar</button>`
        }
    ]
});



const buscar = async () => {
    const tutorNombre = formulario.tutor_nombre.value;
    const url = `/examen_escuela/API/tutores/buscar?tutor_nombre=${tutorNombre}`;
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
    const url = '/examen_escuela/API/tutores/guardar';
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

const traeDatos = (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const nombre = button.dataset.nombre;
    const telefono = button.dataset.telefono;
    const parentezco = button.dataset.parentezco;
    const alumno = button.dataset.alumno;
    const situacion = button.dataset.situacion;

    const dataset = {
        id,
        nombre,
        telefono,
        parentezco,
        alumno,
        situacion
    };
    colocarDatos(dataset);
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
    const url = '/examen_escuela/API/tutores/modificar';
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
        const url = '/examen_escuela/API/tutores/eliminar';
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

const colocarDatos = (dataset) => {
    formulario.tutor_nombre.value = dataset.nombre;
    formulario.tutor_telefono.value = dataset.telefono;
    formulario.tutor_parentezco.value = dataset.parentezco;
    formulario.alumno_id.value = dataset.alumno;
    formulario.tutor_situacion.value = dataset.situacion;
    formulario.tutor_id.value = dataset.id;

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
