import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import { lenguaje } from "../lenguaje";
import Datatable from "datatables.net-bs5";

const formulario = document.getElementById('formularioAsistencia'); 
const btnBuscar = document.getElementById('btnBuscar');

const buscar = async () => {
    let grado_id = formulario.grado_id.value; 
    let seccion_id = formulario.seccion_id.value; 
    let asistencia_fecha = formulario.asistencia_fecha.value;    

    const url = `/examen_escuela/API/pdfasistencias/buscar?grado_id=${grado_id}&seccion_id=${seccion_id}&asistencia_fecha=${asistencia_fecha}`; 
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);

        if (respuesta.ok) {
            const blob = await respuesta.blob();

            if (blob) {
                const urlBlob = window.URL.createObjectURL(blob);

                window.open(urlBlob, '_blank');
            } else {
                console.error('No se pudo obtener el blob del PDF.');
            }
        } else {
            console.error('Error al generar el PDF.');
        }
    } catch (error) {
        console.error(error);
    }
};


if (formulario) {
    btnBuscar.addEventListener('click', buscar);
    
}
