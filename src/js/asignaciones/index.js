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


btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'

let contador = 1;
const datatable = new Datatable('#tablaAsignaciones', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contador++

        },
        {
            title : 'ALUMNO',
            data: 'asignacion_alumno'
        },
        {
            title : 'GRADO',
            data: 'asignacion_grado',
        },
        {
            title : 'SECCION',
            data: 'asignacion_seccion',
        },
        {
            title : 'PROFESOR',
            data: 'asignacion_profesor',
        },
        
        {
            title : 'MODIFICAR',
            data: 'asignacion_id',
            searchable : false,
            orderable : false,
            render : (data, type, row, meta) => `<button class="btn btn-warning" data-id='${data}' data-alumno='${row["asignacion_alumno"]}' data-grado='${row["asignacion_grado"]}'  data-seccion='${row["asignacion_seccion"]}'  data-profesor='${row["asignacion_profesor"]}' >Modificar</button>`
        },
        {
            title : 'ELIMINAR',
            data: 'asignacion_id',
            searchable : false,
            orderable : false,
            render : (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}' >Eliminar</button>`
        },
       
    ]
})

const buscar = async () => {
    let asignacion_alumno = formulario.asignacion_alumno.value;
    let asignacion_grado = formulario.asignacion_grado.value;
    let asignacion_seccion = formulario.asignacion_seccion.value;
    let asignacion_profesor = formulario.asignacion_profesor.value;

    const url = `/examen_escuela/API/asignaciones/buscar?asignacion_alumno=${asignacion_alumno}&asignacion_grado=${asignacion_grado}&asignacion_seccion=${asignacion_seccion}&asignacion_profesor=${asignacion_profesor}`;
    const config = {
        method : 'GET'
    }
    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

        console.log(data);
        datatable.clear().draw()
        if(data){
            contador = 1;
            datatable.rows.add(data).draw();
        }else{
            Toast.fire({
                title : 'No se encontraron registros',
                icon : 'info'
            })
        }
       
    } catch (error) {
        console.log(error);
    }
}

const guardar = async (evento) => {
    evento.preventDefault();
    if(!validarFormulario(formulario, ['asignacion_id'])){
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        })
        return 
    }

    const body = new FormData(formulario)
    body.delete('asignacion_id')
    const url = '/examen_escuela/API/asignaciones/guardar';
    const headers = new Headers();
    headers.append("X-Requested-With", "fetch");
    const config = {
        method : 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

       
        const {codigo, mensaje,detalle} = data;
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

const traeDatos = (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const alumno = button.dataset.alumno;
    const grado = button.dataset.grado;
    const seccion = button.dataset.seccion;
    const profesor = button.dataset.profesor;

    const dataset = {
        id,
        alumno,
        grado,
        seccion,
        profesor
    };
    colocarDatos(dataset);
        const body = new FormData(formulario);
        body.append('asignacion_id', id);
        body.append('asignacion_alumno', alumno);
        body.append('asignacion_grado', grado);   
        body.append('asignacion_seccion', seccion);   
        body.append('asignacion_profesor', profesor);   
};

const modificar = async () => {
    if(!validarFormulario(formulario)){
        alert('Debe llenar todos los campos');
        return 
    }

    const body = new FormData(formulario)
    const url = '/examen_escuela/API/asignaciones/modificar';
    const config = {
        method : 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();
        
        const {codigo, mensaje,detalle} = data;
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

const eliminar = async (e) => {
    const button = e.target;
    const id = button.dataset.id
    // console.log(id)
    if (await confirmacion('warning', '¿Desea eliminar este registro?')) {
        const body = new FormData()
        body.append('asignacion_id', id)
        const url = '/examen_escuela/API/asignaciones/eliminar';
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

const colocarDatos = (dataset) => {
    formulario.asignacion_alumno.value = dataset.alumno;
    formulario.asignacion_grado.value = dataset.grado;
    formulario.asignacion_seccion.value = dataset.seccion;
    formulario.asignacion_profesor.value = dataset.profesor;
    formulario.asignacion_id.value = dataset.id;

    btnGuardar.disabled = true
    btnGuardar.parentElement.style.display = 'none';
    btnBuscar.disabled = true
    btnBuscar.parentElement.style.display = 'none';
    btnModificar.disabled = false
    btnModificar.parentElement.style.display = '';
    btnCancelar.disabled = false
    btnCancelar.parentElement.style.display = '';
  
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

buscar();

formulario.addEventListener('submit', guardar)
btnBuscar.addEventListener('click', buscar)
btnCancelar.addEventListener('click', cancelarAccion)
btnModificar.addEventListener('click', modificar)
datatable.on('click','.btn-warning', traeDatos )
datatable.on('click','.btn-danger', eliminar )


btnModificar.addEventListener('click', modificar)
btnCancelar.addEventListener('click', cancelarAccion)




