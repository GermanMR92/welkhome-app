import Swal from 'sweetalert2';
const csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute("content");
const restauranteForm = document.querySelector('#restaurante-form');

const options = {
    mode: "cors",
    headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Content-Type': 'application/json'
    },
    cache: "default",
}

document.addEventListener('DOMContentLoaded', function () {

    // Eliminar un registro
    window.deleteRecord = (id) => {
        Swal.fire({
            title: '¿Estas segur@?',
            text: "Esta acción no se puede revertir",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    options.method = 'DELETE';
                    const response = await fetch(`/restaurante/destroy/${id}`, options)
                    const data = await response.json();

                    // Manejamos los errores
                    if (!response.ok) {
                        showError(data)
                        return;
                    }

                    // Se borra correctamente
                    Swal.fire({
                        title: data.title,
                        text: data.message,
                        confirmButtonText: 'OK',
                        icon: 'success'
                    }).then(() => {
                        document.getElementById(`table-row-${id}`).remove()
                    });

                } catch (error) {
                    showError(error)
                }
            }
        });
    }

    // Crear/Editar un registro
    restauranteForm.addEventListener('submit', async function (e) {
        e.preventDefault()

        // Obtenemos los datos del formulario
        const formData = new FormData(restauranteForm);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

        options.body = JSON.stringify(data);

        let url = `/restaurante/store`;
        const id = document.getElementById('restauranteId').value;
        if (id != "") { // Creando o Actualizando
            url = `${url}/${id}`;
            options.method ='PUT';
        } else {
            options.method = 'POST';
        }

        try {
            const response = await fetch(url, options)
            const data = await response.json();

            // Manejamos los errores
            if(!response.ok) {
                showError(data)
                return
            }

            // Operación realizada
            Swal.fire({
                title: data.title,
                text: data.message,
                confirmButtonText: 'OK',
                icon: 'success'
            }).then(() => {
                location.href = "/"; // Redirigir al listado de restaurantes
            });

        } catch (error) {
            showError(error)
        }
    })
});

function showError(data) {
    let title = data.title ? data.title : "Error";
    let errorMessages = data.error ? data.error : "Ha ocurrido un error inesperado";

    // En caso de venir multiples errores
    if (typeof data.error == 'object') {
        errorMessages = "";
        let errores = data.error;
        for (let campo in errores) {
            if (errores.hasOwnProperty(campo)) {
                errorMessages += `${errores[campo][0]}<br>`;
            }
        }
    }

    Swal.fire({
        title: title,
        html: errorMessages,
        icon: 'error'
    })
}