import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import { lenguaje } from "../lenguaje";
import Datatable from "datatables.net-bs5";

const formulario = document.getElementById('formularioAlumnos');
const btnGuardar = document.getElementById('btnGuardar');
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnCancelar = document.getElementById('btnCancelar');
const divTabla = document.getElementById('tablaAlumnos'); 

if (btnGuardar) {
    btnModificar.disabled = true;
    btnModificar.parentElement.style.display = 'none';
    btnCancelar.disabled = true;
    btnCancelar.parentElement.style.display = 'none';
    btnBuscar.disabled = true;
    btnBuscar.parentElement.style.display = 'none';
}

let contador = 1;
const datatable = new Datatable('#tablaAlumnos', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contador++
        },
        {
            title: 'NOMBRE',
            data: 'alumno_nombre'
        },
        {
            title: 'EDAD',
            data: 'alumno_edad'
        },
        {
            title: 'SEXO',
            data: 'alumno_sexo'
        },
        {
            title: 'NACIMIENTO',
            data: 'alumno_fecha_nacimiento'
        },
        {
            title: 'MODIFICAR',
            data: 'alumno_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning" data-id='${data}' data-nombre='${row["alumno_nombre"]}'
            data-edad='${row["alumno_edad"]}' data-sexo='${row["alumno_sexo"]}' data-nacimiento='${row["alumno_fecha_nacimiento"]}'>Modificar</button>`
        },
        {
            title: 'ELIMINAR',
            data: 'alumno_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}' >Eliminar</button>`
        },
    ]
});

const buscar = async () => {
    let alumno_nombre = formulario.alumno_nombre.value;

    console.log('test: "' + alumno_nombre + '"');

    const url = `/examen_escuela/API/alumnos/buscar?alumno_nombre=${alumno_nombre}`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
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
        console.log(error);
    }
};

const guardar = async (evento) => {
    evento.preventDefault();

    if (!validarFormulario(formulario, ['alumno_id'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        });
        return;
    }

    const body = new FormData(formulario)
    body.delete('alumno_id')
    const url = '/examen_escuela/API/alumnos/guardar';

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
        body.append('alumno_id', id);
        const url = '/examen_escuela/API/alumnos/eliminar';
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
    const nombre = button.dataset.nombre;
    const edad = button.dataset.edad;
    const sexo = button.dataset.sexo;
    const nacimiento = button.dataset.nacimiento;

    const dataset = {
        id,
        nombre,
        edad,
        sexo,
        nacimiento
    };

    colocarDatos(dataset);
    const body = new FormData(formulario);
    body.append('alumno_id', id);
    body.append('alumno_nombre', nombre);
    body.append('alumno_edad', edad);
    body.append('alumno_sexo', sexo);
    body.append('alumno_fecha_nacimiento', nacimiento);
};

const colocarDatos = (dataset) => {
    formulario.alumno_nombre.value = dataset.nombre;
    formulario.alumno_edad.value = dataset.edad;
    formulario.alumno_sexo.value = dataset.sexo;
    formulario.alumno_fecha_nacimiento.value = dataset.nacimiento;
    formulario.alumno_id.value = dataset.id;

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

    const url = '/examen_escuela/API/alumnos/modificar';

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
