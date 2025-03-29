console.log("Archivo index.js cargado correctamente");

window.onload = () => {
    console.log("JavaScript cargado correctamente"); // Depuración
    setTimeout(() => {
        const alerta = document.getElementById("alerta");
        if (alerta) {
            console.log("Eliminando alerta"); // Depuración
            alerta.remove();
        } else {
            console.log("No se encontró el elemento con ID 'alerta'"); // Depuración
        }
    }, 3000);
};

let btnEliminar = document.querySelector("#btnEliminar");
let lbl_nombre = document.querySelector("#lbl_nombre");
window.setInfo = (id, nombre) => {
    btnEliminar.setAttribute("data-id", id);
    lbl_nombre.innerHTML = `Eliminaras el video juego ${nombre}`;
};

btnEliminar.addEventListener("click", () => {
    let id= btnEliminar.getAttribute("data-id");
    let form = document.querySelector('#frm_'+id);
    form.submit();
});