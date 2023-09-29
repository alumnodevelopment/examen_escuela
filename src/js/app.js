import '../scss/app.scss';

document.addEventListener('DOMContentLoaded', (e)=> {
    const dropdown = document.querySelector('.dropdown-menu');
    dropdown ? dropdown.style.margin = 0 : null;


    let items = document.querySelectorAll('.nav-link')
    items.forEach(item => {
        if(item.href == location.href){
            item.classList.add('active')
            if(item.classList.contains('dropdown-item')){
               item.parentElement.parentElement.previousElementSibling.classList.add('active')
            }
        }
    });


})



document.onreadystatechange = () => {
    switch (document.readyState) {
        case "loading":

            break;
        case "interactive": 
            document.getElementById('bar') ? document.getElementById('bar').style.width = '35%' : null;
            break;
            
        case "complete":
            document.getElementById('bar') ? document.getElementById('bar').style.width = '100%' : null;
            setTimeout(() => {
                document.getElementById('bar') ? document.getElementById('bar').parentElement.style.display = 'none' : null 
            }, 1000);   
            break;
    }
}
