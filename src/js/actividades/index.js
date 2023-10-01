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
const datatable = new Datatable('#tablaActividades', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contador++

        },
        {
            title : 'PROFESOR',
            data: 'profesor_nombre',
        },

        {
            title : 'GRADO',
            data: 'grado_nombre',
        },
        {
            title : 'SECCION',
            data: 'seccion_nombre',
        },
        {
            title : 'FECHA_INICIO',
            data: 'actividad_fecha_inicio',
        },
        {
            title : 'FECHA_FIN',
            data: 'actividad_fecha_fin',
        },
        {
            title : 'ACTIVIDAD_DESCRIPCION',
            data: 'actividad_descripcion',
        },

        {
            title : 'MODIFICAR',
            data: 'actividad_id',
            searchable : false,
            orderable : false,
            render : (data, type, row, meta) => `<button class="btn btn-warning" data-id='${data}' data-profesor='${row["actividad_profesor"]}' data-grado='${row["actividad_grado"]}'  data-seccion='${row["actividad_seccion"]}' data-fecha_inicio='${row["actividad_fecha_inicio"]}' data-fecha_fin='${row["actividad_fecha_fin"]}' data-actividad_descripcion='${row["actividad_descripcion"]}'  >Modificar</button>`
        },
        {
            title : 'ELIMINAR',
            data: 'actividad_id',
            searchable : false,
            orderable : false,
            render : (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}' >Eliminar</button>`
        },
       
    ]
})

const buscar = async () => {
    let actividad_profesor = formulario.actividad_profesor.value;
    let actividad_grado = formulario.actividad_grado.value;
    let actividad_seccion = formulario.actividad_seccion.value;
    let actividad_fecha_inicio = formulario.actividad_fecha_inicio.value;
    let actividad_fecha_fin = formulario.actividad_fecha_fin.value;
    let actividad_descripcion = formulario.actividad_descripcion.value;
   

    const url = `/examen_escuela/API/actividades/buscar?actividad_profesor=${actividad_profesor}&actividad_grado=${actividad_grado}&actividad_seccion=${actividad_seccion}&actividad_fecha_inicio=${actividad_fecha_inicio}&actividad_fecha_fin=${actividad_fecha_fin}&actividad_descripcion=${actividad_descripcion}`;
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
    if(!validarFormulario(formulario, ['actividad_id'])){
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        })
        return 
    }

    const body = new FormData(formulario)
    body.delete('actividad_id')
    const url = '/examen_escuela/API/actividades/guardar';
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
    const profesor = button.dataset.profesor;
    const grado = button.dataset.grado;
    const seccion = button.dataset.seccion;
    const fecha_inicio = button.dataset.fecha_inicio;
    const fecha_fin = button.dataset.fecha_fin;
    const actividad_descripcion = button.dataset.actividad_descripcion;
    
    
    const dataset = {
        id,
        profesor,
        grado,
        seccion,
        fecha_inicio,
        fecha_fin,
        actividad_descripcion
       
    };
    colocarDatos(dataset);
        const body = new FormData(formulario);
        body.append('actividad_id', id);
        body.append('actividad_grado', grado);   
        body.append('actividad_seccion', seccion);   
        body.append('actividad_profesor', profesor);  
        body.append('actividad_fecha_inicio', fecha_inicio);
        body.append('actividad_fecha_fin', fecha_fin);
        body.append('actividad_descripcion', actividad_descripcion);
};

const modificar = async () => {
    if(!validarFormulario(formulario)){
        alert('Debe llenar todos los campos');
        return 
    }

    const body = new FormData(formulario)
    const url = '/examen_escuela/API/actividades/modificar';
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
        body.append('actividad_id', id)
        const url = '/examen_escuela/API/actividades/eliminar';
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
    formulario.actividad_grado.value = dataset.grado;
    formulario.actividad_seccion.value = dataset.seccion;
    formulario.actividad_profesor.value = dataset.profesor;
    formulario.actividad_fecha_inicio.value = dataset.fecha_inicio;
    formulario.actividad_fecha_fin.value = dataset.fecha_fin;
    formulario.actividad_descripcion.value = dataset.actividad_descripcion;
    formulario.actividad_id.value = dataset.id;

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




