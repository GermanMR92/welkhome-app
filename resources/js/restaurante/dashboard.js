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

    // Funcion para eliminar un registro
    window.deleteRecord = function (id) {
        Swal.fire({
            title: '¿Estas segur@?',
            text: "Esta acción no se puede revertir",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                options.method = 'DELETE';

                fetch(`/restaurante/destroy/${id}`, options)
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
                        }).then(()=> {
                            document.getElementById(`table-row-${id}`).remove()
                        });

                    })
                    .catch(error => {
                        Swal.fire({
                            title: error.title,
                            text: error.message,
                            icon: 'error'
                        })
                    });
            }
        });
    }
    
    // Funcion para guardar un registro
    restauranteForm.addEventListener('submit', function(e) {
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
                }).then(()=> {
                    location.href ="/";
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