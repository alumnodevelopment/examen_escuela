import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

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
const datatable = new Datatable('#tablaProfesor', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contador++
        },
        {
            title: 'Nombre del Profesor',
            data: 'profesor_nombre'
        },
        {
            title: 'Teléfono',
            data: 'profesor_telefono'
        },
        {
            title: 'MODIFICAR',
            data: 'profesor_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning" data-id='${data}' data-nombre='${row["profesor_nombre"]}' data-telefono='${row["profesor_telefono"]}'>Modificar</button>`
        },
        {
            title: 'ELIMINAR',
            data: 'profesor_id',
            searchable: false,
            orderable: false,
            render: (data) => `<button class="btn btn-danger" data-id='${data}'>Eliminar</button>`
        }
    ]
});

const buscar = async () => {
    const profesorNombre = formulario.profesor_nombre.value;
    const url = `/examen_escuela/API/profesores/buscar?profesor_nombre=${profesorNombre}`;
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

const traeDatos = (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const nombre = button.dataset.nombre;
    const telefono = button.dataset.telefono;

    const dataset = {
        id,
        nombre,
        telefono
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
    const url = '/examen_escuela/API/profesores/modificar';
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
        body.append('profesor_id', id);
        const url = '/examen_escuela/API/profesores/eliminar';
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
    formulario.profesor_nombre.value = dataset.nombre;
    formulario.profesor_telefono.value = dataset.telefono;
    formulario.profesor_id.value = dataset.id;

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
