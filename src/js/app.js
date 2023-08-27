document.addEventListener('DOMContentLoaded', function() {

    eventListeners();

    darkMode();
});

function darkMode() {

    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');

    // console.log(prefiereDarkMode.matches);

    if(prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }

    prefiereDarkMode.addEventListener('change', function() {
        if(prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    });

    const botonDarkMode = document.querySelector('.dark-mode-boton');
    botonDarkMode.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
    });
}

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);
}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');

    navegacion.classList.toggle('mostrar')
}

const botonEliminar = document.querySelectorAll('.eliminar');
 
botonEliminar.forEach(boton => {
    
    boton.addEventListener('click', function(e){
        // Prevengo ejecucion por defecto
        e.preventDefault();
        // Creo las constantes para la ID y para el mensaje
        const id = parseInt(e.target.id.substring(6));
        const mensaje = `¿Quieres eliminar la propiedad con la ID ${id}`
        
        // Condiciono el resultado de la ventana modal a la salida
        if (confirm(mensaje)) {
            document.getElementById(boton.form.attributes.id.value).submit();
        }
    });
 
});


