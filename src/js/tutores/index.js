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
            title: 'Situación',
            data: 'tutor_situacion'
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