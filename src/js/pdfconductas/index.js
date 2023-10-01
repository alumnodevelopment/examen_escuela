import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import { lenguaje } from "../lenguaje";
import Datatable from "datatables.net-bs5";

const formulario = document.getElementById('formularioConducta'); 
const btnBuscar = document.getElementById('btnBuscar');
const divTabla = document.getElementById('tablaConducta'); 



    btnBuscar.disabled = true;
    btnBuscar.parentElement.style.display = 'none';


let contador = 1;
const datatable = new Datatable('#tablaConducta', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contador++
        },
        {
            title: 'ALUMNO', 
            data: 'alumno_nombre' 
        },
        {
            title: 'FECHA', 
            data: 'conducta_fecha' 
        },
        {
            title: 'DESCRIPCIÓN', 
            data: 'conducta_descripcion'
        },
    ]
});

const buscar = async () => {
    let alumno_id = formulario.alumno_id.value; 
    let conducta_fecha = formulario.conducta_fecha.value; 
    console.log('test: "' + alumno_id + '"'+ conducta_fecha );

    const url = `/examen_escuela/API/pdfconductas/buscar?alumno_id=${alumno_id}&conducta_fecha=${conducta_fecha}`; 
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);

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



const traeDatos = (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const alumno = button.dataset.alumno;
    const fecha = button.dataset.fecha;
    const descripcion = button.dataset.descripcion;


    const dataset = {
        id,
        alumno,
        fecha,
        descripcion
    };

    colocarDatos(dataset);
    const body = new FormData(formulario);
    body.append('conducta_id', id);
    body.append('alumno_nombre', alumno);
    body.append('conducta_fecha', fecha);
    body.append('conducta_descripcion', descripcion);
};

const colocarDatos = (dataset) => {
    formulario.alumno_id.value = dataset.alumno;
    formulario.conducta_fecha.value = dataset.fecha;
    formulario.conducta_descripcion.value = dataset.descripcion;
    formulario.conducta_id.value = dataset.id;

    btnBuscar.disabled = true;
    btnBuscar.parentElement.style.display = 'none';

};


if (formulario) {
    buscar();
    btnBuscar.addEventListener('click', buscar);
    datatable.on('click', '.btn-warning', traeDatos);
}