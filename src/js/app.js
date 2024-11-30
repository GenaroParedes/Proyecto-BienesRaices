document.addEventListener('DOMContentLoaded', function() { //Funcion callback que se ejecuta cuando el contenido del DOM ha sido cargado.
    //DOMcontentLoaded es un evento que se dispara cuando el HTML, CSS y JavaScritp han cargado (pagina cargada).
    addEventListener();
});

function addEventListener() {
    const mobileMenu = document.querySelector('.mobile-menu');

    //Evento click en el icono del menu, cuando esto sucede llamamos la funcion navegacionReponsive
    mobileMenu.addEventListener('click', navegacionReponsive); 
}

function navegacionReponsive() {
    const navegacion = document.querySelector('.navegacion');

    /*if(navegacion.classList.contains('mostrar')){ //Esto me permite mostrar o no la navegacion al apretar el icono del menu
        navegacion.classList.remove('mostrar'); //Si la clase mostrar esta presente la eliminamos
    } else {
        navegacion.classList.add('mostrar'); //Si la clase mostrar no esta presente la agregamos
    }*/

    //Otra forma de hacerlo (En una sola linea)
    navegacion.classList.toggle('mostrar'); //Si la clase mostrar esta presente la eliminamos, si no esta presente la agregamos
}