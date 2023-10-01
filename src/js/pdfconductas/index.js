import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import { lenguaje } from "../lenguaje";
import Datatable from "datatables.net-bs5";

const formulario = document.getElementById('formularioConducta'); 
const btnBuscar = document.getElementById('btnBuscar');
const divTabla = document.getElementById('tablaConducta'); 


let contador = 1;
const datatable = new Datatable('#tablaConducta', {

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

    const url = `/examen_escuela/API/pdfconductas/buscar?alumno_id=${alumno_id}&conducta_fecha=${conducta_fecha}`; 

    try {
        const respuesta = await fetch(url);
        const data = await respuesta.json();

        datatable.clear().draw();
        if (data && data.length > 0) {
            contador = 1;
            datatable.rows.add(data).draw();
            generarPDF(data);
            formulario.reset();
        } else {
            Toast.fire({
                title: 'No se encontraron registros',
                icon: 'info'
            });
        }
    } catch (error) {
        console.error('Error al obtener datos:', error);
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
};

const colocarDatos = (dataset) => {
    formulario.alumno_id.value = dataset.alumno;
    formulario.conducta_fecha.value = dataset.fecha;
    formulario.conducta_descripcion.value = dataset.descripcion;
    formulario.conducta_id.value = dataset.id;
};

const generarPDF = async (datos) => {
    const url = `/examen_escuela/ReporteConducta/generarPDF`;

    try {
        const respuesta = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(datos),
        });

        if (respuesta.ok) {
            const blob = await respuesta.blob();

            if (blob) {
                const urlBlob = window.URL.createObjectURL(blob);
                // Abre el PDF en una nueva ventana o pestaña
                window.open(urlBlob, '_blank');
            } else {
                console.error('No se pudo obtener el blob del PDF.');
            }
        } else {
            console.error('Error al generar el PDF.');
        }
    } catch (error) {
        console.error('Error al generar el PDF:', error);
    }
};

if (formulario) {
    btnBuscar.addEventListener('click', buscar);
    datatable.on('click', '.btn-warning', traeDatos);
}
