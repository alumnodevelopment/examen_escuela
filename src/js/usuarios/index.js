import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";

const formulario = document.getElementById('formularioUsuarios');
const btnGuardar = document.getElementById('btnGuardar');

const guardar = async (evento) => {
    evento.preventDefault();
    if (!validarFormulario(formulario, ['usuario_id'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los campos'
        })
        return
    }

    const body = new FormData(formulario)
    body.delete('usuario_id')
    const url = '/examen_escuela/API/usuarios/guardar';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

        console.log(data);

        const { codigo, mensaje, detalle } = data;
        let icon = 'info'
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success'
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

formulario.addEventListener('submit', guardar);
