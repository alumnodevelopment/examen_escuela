import { validarFormulario, Toast } from "../funciones";

const formLogin = document.querySelector('form')


const login = async e => {
    e.preventDefault();
   
    if(!validarFormulario(formLogin)){
        Toast.fire({
            icon: 'info',
            title: 'Debe llenar todos los campos'
        })
        return
    }

    try {
        const url = '/examen_escuela/API/login/ingresar'

        const body = new FormData(formLogin);
        for (var pair of body.entries()) {
            console.log(pair[0]+ ', ' + pair[1]); 
        }

        const config = {
            method: 'POST',
            body
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);
        
        const {codigo, mensaje, detalle} = data;
        let icon = 'info';
        if(codigo == 1){
            icon = 'success'
        }else if(codigo == 2){
            icon = 'warning'
        }else{
            icon = 'error'

        }
        
        Toast.fire({
            title : mensaje,
            icon
        }).then((e)=>{
            if(codigo == 1){
                location.href = '/examen_escuela/'
            }
        })

    } catch (error) {
        console.log(error);
    }

    
}

formLogin.addEventListener('submit', login );
