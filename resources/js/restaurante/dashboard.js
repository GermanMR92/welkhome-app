import Swal from 'sweetalert2';
const csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute("content");
const 

const options = {
    mode: "cors",
    headers: {
        'X-CSRF-TOKEN': csrfToken
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

                // Agregamos el metodo
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
});