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
            title: 'GRADO',
            data: 'grado_id'
        },
     
        {
            title: 'GRADO NOMBRE',
            data: 'grado_nombre'
        },   
        {
            title: 'Seccion',
            data: 'seccion_id'
        },
        {
            title: 'Seccion Nombre',
            data: 'seccion_nombre'
        },   
        {
            title: 'Alumno Nombre',
            data: 'alumno_id'
        },
        {
            title: 'Alumno',
            data: 'alumno_nombre'

        }, 
     
       {
           title: 'FECHA',
           data: 'asistencia_fecha'
       },
       {
        title: 'ASISTENCIA PRESENTE',
        data: 'asistencia_asistio',
        render: function(data, type, row) {
            if (type === 'display') {
                // Renderizar un select en la vista
                return '<select class="form-control" onchange="updateAsistencia(this.value, ' + row.id + ')">' +
                    '<option value="1"' + (data === '1' ? ' selected' : '') + '>Presente</option>' +
                    '<option value="0"' + (data === '0' ? ' selected' : '') + '>Ausente</option>' +
                    '</select>';
            }
            return data;
        }
    },
        {
            title: 'MODIFICAR',
            data: 'asistencia_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning" data-id='${data}' data-grado='${row["grado_id"]}' data-seccion='${row["seccion_id"]}' data-alumno='${row["alumno_id"]}' data-fecha='${row["asistencia_fecha"]}'>Modificar</button>`
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

// Después de cargar la página, obtener los datos de los alumnos y llenar el select
document.addEventListener("DOMContentLoaded", async () => {
    const gradoSelect = document.getElementById("grado_id");

    try {
        const respuesta = await fetch('/examen_escuela/API/asistencia/buscarGrado');
        const grados = await respuesta.json();
        console.log(grados);
        // return;
        grados.forEach(grado => {
            const option = document.createElement("option");
            option.value = grado.grado_id;
            option.textContent = grado.grado_nombre;
            gradoSelect.appendChild(option);
        });
    } catch (error) {
        console.error('Error al obtener datos:', error);
    }
});

document.addEventListener("DOMContentLoaded", async () => {
    const seccionSelect = document.getElementById("seccion_id");

    try {
        const respuesta = await fetch('/examen_escuela/API/asistencia/buscarSeccion');
        const secciones = await respuesta.json();
        console.log(secciones);


        secciones.forEach(seccion => {
            const option = document.createElement("option");
            option.value = seccion.seccion_id;
            option.textContent = seccion.seccion_nombre;
            seccionSelect.appendChild(option);
        });
    } catch (error) {
        console.error('Error al obtener datos:', error);
    }
});

const buscarGradosSecciones = async () => {
    console.log("Evento de búsqueda activado");
    const grado_id = formulario.grado_id.value;
    const seccion_id = formulario.seccion_id.value;

    console.log("Grado ID:", grado_id); // Verificar el valor de grado_id
    console.log("Sección ID:", seccion_id);


    const url = `/examen_escuela/API/asistencia/buscarGradosSecciones?grado_id=${grado_id}&seccion_id=${seccion_id}`;
    try {
        const respuesta = await fetch(url);
        const data = await respuesta.json();

        console.log("Datos recibidos del servidor:", data);

        // const datosFiltrados = data.filter(item => {
        //     return item.grado_nombre === grado_id && item.seccion_nombre === seccion_id;
        // });
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
    const grado_id = button.dataset.grado_id;
    const grado_nombre = button.dataset.grado_nombre;
    const seccion_id = button.dataset.seccion_id;
    const seccion_nombre = button.dataset.seccion_nombre;
    const alumno_id = button.dataset.alumno_id;
    const alumno_nombre = button.dataset.alumno_nombre;
    const asistencia_fecha = button.dataset.asistencia_fecha;

    const dataset = {
        id,
        grado_id,
        grado_nombre,
        seccion_id,
        seccion_nombre,
        alumno_id,
        alumno_nombre,
        asistencia_fecha
    };
    colocarDatos(dataset);
};
const colocarDatos = (dataset) => {
    formulario.grado_id.value = dataset.grado;
    formulario.grado_nombre.value = dataset.grado_nombre;
    formulario.seccion_id.value = dataset.seccion_id;
    formulario.seccion_nombre.value = dataset.seccion_nombre;
    formulario.alumno_id.value = dataset.alumno_id;
    formulario.alumno_nombre.value = dataset.alumno_nombre;
    formulario.asistencia_fecha.value = dataset.asistencia_fecha;
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
btnBuscar.addEventListener('click', buscarGradosSecciones);
btnCancelar.addEventListener('click', cancelarAccion);
datatable.on('click', '.btn-warning', traeDatos);
datatable.on('click', '.btn-danger', eliminar);
