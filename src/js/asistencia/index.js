import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion} from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje  } from "../lenguaje";


const formulario = document.getElementById('formularioAsistencia');
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
            title: 'Nombre del Alumno',
            data: 'alumno_id'
        },   
        {
            title: 'Fecha de la asistencia',
            data: 'asistencia_fecha'
            
        },
        {
            title: 'Asistencia',
            data: 'asistencia_asistio'

        }, 
        {
            title: 'MODIFICAR',
            data: 'asistencia_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning" data-id='${data}' data-nombre='${row["alumno_id"]}'
            data-fecha='${row["asistencia_fecha"]}' data-asistio='${row["asistencia_asistio"]}'>Modificar</button>`
        },
        {
            title: 'ELIMINAR',
            data: 'asistencia_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}' >Eliminar</button>`
        },
    ]
});


// Después de cargar la página, obtener los datos de los alumnos y llenar el select
document.addEventListener("DOMContentLoaded", async () => {
    const alumnoSelect = document.getElementById("alumno_id");

    try {
        const respuesta = await fetch('/examen_escuela/API/asistencia/buscarAlumno');
        const alumnos = await respuesta.json();

        alumnos.forEach(alumno => {
            const option = document.createElement("option");
            option.value = alumno.alumno_id;
            option.textContent = alumno.alumno_nombre;
            alumnoSelect.appendChild(option);
        });
    } catch (error) {
        console.error(error);
    }
});




const guardar = async (evento) => {
    evento.preventDefault();

    // Obtener el valor seleccionado del campo de alumno_id
    const alumnoSelect = document.getElementById("alumno_id");
    const alumnoId = alumnoSelect.value;

    // Obtener otros valores del formulario
    const asistencia_fecha = document.getElementById("asistencia_fecha").value;
    const asistencia_asistio = document.getElementById("asistencia_asistio").value;


    if (alumnoSelect.value === "" || asistencia_fecha === "" || asistencia_asistio === "") {
        Toast.fire({
            icon: 'info',
            text: 'Por favor, llene todos los campos'
        });
        return;
    }
    const formData = new FormData();
    formData.append("asistencia_fecha", asistencia_fecha);
    formData.append("asistencia_asistio", asistencia_asistio);
    formData.append("alumno_id", alumnoId);

    
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



const buscar = async () => {
    const alumno_id = formulario.alumno_id.value;
    const asistencia_fecha = formulario.asistencia_fecha.value;

    const url = `/examen_escuela/API/asistencia/buscar?alumno_id=${alumno_id}&asistencia_fecha=${asistencia_fecha}`;
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
        body.append('asistencia_id', id);
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
    const alumno_id = button.dataset.alumno_id;
    const asistencia_fecha = button.dataset.asistencia_fecha;
    const asistencia_asistio = button.dataset.asistencia_asistio;


    const dataset = {
        id,
        alumno_id,
        asistencia_fecha,
        asistencia_asistio
    };
  
    colocarDatos(dataset);
};




const colocarDatos = (dataset) => {
    formulario.alumno_id.value = dataset.alumno_id;
    formulario.asistencia_fecha.value = dataset.asistencia_fecha;
    formulario.asistencia_asistio.value = dataset.asistencia_asistio;
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


// const buscarAlumnos = async () => {
  

//     const url = `/examen_escuela/API/asistencia/buscarAlumnos`;
//     try {
//         const respuesta = await fetch(url);
//         const data = await respuesta.json();
//         datatable.clear().draw();
//         if (data) {
//             contador = 1;
//             datatable.rows.add(data).draw();
//         } else {
//             Toast.fire({
//                 title: 'No se encontraron registros',
//                 icon: 'info'
//             });
//         }
//     } catch (error) {
//         console.error(error);
//     }
// };


//buscarAlumnos();
formulario.addEventListener('submit', guardar);
btnBuscar.addEventListener('click', buscar);
btnCancelar.addEventListener('click', cancelarAccion);
btnModificar.addEventListener('click', modificar);
datatable.on('click', '.btn-warning', traeDatos);
datatable.on('click', '.btn-danger', eliminar);
