import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";


const formulario = document.querySelector('form')
const btnGuardar = document.getElementById('btnGuardar');
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnCancelar = document.getElementById('btnCancelar');

let contador = 1;
btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'

const datatable = new Datatable('#tablaSecciones', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contador++

        },
        {
            title: 'NOMBRE',
            data: 'seccion_nombre'
        },
        {
            title: 'MODIFICAR',
            data: 'seccion_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning" data-id='${data}' data-nombre='${row["seccion_nombre"]}'>Modificar</button>`},
        {
            title: 'ELIMINAR',
            data: 'seccion_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}' >Eliminar</button>`
        },

    ]
})

const buscar = async () => {
    let seccion_nombre = formulario.seccion_nombre.value;
    const url = `/examen_escuela/API/secciones/buscar?seccion_nombre=${seccion_nombre}`;
    const config = {
        method: 'GET'
    }
    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

        console.log(data);
        datatable.clear().draw()
        if (data) {
            contador = 1;
            datatable.rows.add(data).draw();
        } else {
            Toast.fire({
                title: 'No se encontraron registros',
                icon: 'info'
            })
        }

    } catch (error) {
        console.log(error);
    }
}

const traeDatos = (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const nombre = button.dataset.nombre;
    const dataset ={
        id,
        nombre
       
        };

    colocarDatos(dataset);

    const body = new FormData(formulario);
    body.append('seccion_id', id);
    body.append('seccion_nombre', nombre);
  

    };

const colocarDatos = (dataset) => {
    formulario.seccion_nombre.value = dataset.nombre
    formulario.seccion_id.value = dataset.id

    btnGuardar.disabled = true
    btnGuardar.parentElement.style.display = 'none'
    btnBuscar.disabled = true
    btnBuscar.parentElement.style.display = 'none'
    btnModificar.disabled = false
    btnModificar.parentElement.style.display = ''
    btnCancelar.disabled = false
    btnCancelar.parentElement.style.display = ''
}


const cancelarAccion = () => {
    btnGuardar.disabled = false
    btnGuardar.parentElement.style.display = ''
    btnBuscar.disabled = false
    btnBuscar.parentElement.style.display = ''
    btnModificar.disabled = true
    btnModificar.parentElement.style.display = 'none'
    btnCancelar.disabled = true
    btnCancelar.parentElement.style.display = 'none'
   
}
const eliminar = async (e) => {
    const button = e.target;
    const id = button.dataset.id
    // console.log(id)
    if (await confirmacion('warning', '¿Desea eliminar este registro?')) {
        const body = new FormData()
        body.append('seccion_id', id)
        const url = '/examen_escuela/API/secciones/eliminar';
        const config = {
            method: 'POST',
            body
        }
        try {
            const respuesta = await fetch(url, config)
            const data = await respuesta.json();
            console.log(data)
            const { codigo, mensaje, detalle } = data;

            let icon = 'info'
            switch (codigo) {
                case 1:
                    icon = 'success'
                    buscar();
                    break;

                case 0:
                    icon = 'error'
                    console.log(detalle)
                    break;

                default:
                    break;
            }

            Toast.fire({
                icon,
                text: mensaje
            })

        } catch (error) {
            console.log(error);
        }
    }
}

const modificar = async () => {
    if (!validarFormulario(formulario)) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los campos'
        });
        return;
    }

    const body = new FormData(formulario)
    const url = '/examen_escuela/API/secciones/modificar';
    const config = {
        method: 'POST',
        body
    }
    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

        const { codigo, mensaje, detalle } = data;
        let icon = 'info'
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success'
                buscar();
                cancelarAccion();
                break;
            case 0:
                icon = 'error'
                console.log(detalle)
                break;

            default:
                break;
        }

        Toast.fire({
            icon,
            text: mensaje
        })

    } catch (error) {
        console.log(error);
    }
}

const guardar = async (evento) => {
    evento.preventDefault();
    if (!validarFormulario(formulario, ['seccion_id'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        })
        return
    }
    const body = new FormData(formulario)
    body.delete('seccion_id')
    const url = '/examen_escuela/API/secciones/guardar';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

        console.log(data);
        // return

        const { codigo, mensaje, detalle } = data;
        let icon = 'info'
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success'
                buscar();
                break;

            case 0:
                icon = 'error'
                console.log(detalle)
                break;

            default:
                break;
        }

        Toast.fire({
            icon,
            text: mensaje
        })

    } catch (error) {
        console.log(error);
    }
}

buscar();

datatable.on('click', '.btn-warning', traeDatos )
datatable.on('click', '.btn-danger', eliminar)
formulario.addEventListener('submit', guardar)
btnBuscar.addEventListener('click', buscar)
btnCancelar.addEventListener('click', cancelarAccion)
btnModificar.addEventListener('click', modificar)




