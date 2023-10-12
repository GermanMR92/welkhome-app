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
                        confirmButtonText: 'OK234',
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

    // Funcion para guardar un registro
    restauranteForm.addEventListener('submit', function (e) {
        e.preventDefault()

        // Obtenemos los datos del formulario
        // const formData = new FormData(restauranteForm);
        // const serializedData = [];
        // formData.forEach((value, key) => {
        //     serializedData.push({ name: key, value: value });
        // });

        const formData = new FormData(restauranteForm);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

        options.method = 'POST';
        // options.body = {nombre: 'german', telefono:'23232323'}; // Usar esta linea para provocar error y ver porque no sale el mensaje en el alert
        options.body = JSON.stringify(data);

        const id = document.getElementById('restauranteId').value;
        let url = `/restaurante/store`;
        url = id != "" ? `${url}/${id}` : url;

        fetch(url, options)
            .then(async response => {
                const isJson = response.headers.get('content-type')?.includes('application/json');
                const data = isJson && await response.json();

                // En caso de error lanzamos el catch
                if (!response.ok) {
                    const error = (data) || response.status;
                    return Promise.reject(error);
                }

                Swal.fire({
                    title: data.title,
                    text: data.message,
                    confirmButtonText: 'OK',
                    icon: 'success'
                }).then(() => {
                    location.href = "/";
                });

            })
            .catch(error => {
                Swal.fire({
                    title: error.title,
                    text: error.message,
                    icon: 'error'
                })
            });

    })
});

function showError(data) {
    console.log(data);
    let title = data.title ? data.title : "Error";
    let error = data.error ? data.error : "Ha ocurrido un error inesperado";
    Swal.fire({
        title: title,
        text: error,
        icon: 'error'
    })
}