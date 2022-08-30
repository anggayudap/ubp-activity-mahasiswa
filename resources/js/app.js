require('./bootstrap');

"use strict";

window.successMessage = function (message, redirect) {
    Swal.fire({
        icon: 'success',
        text: message,
        customClass: {
            confirmButton: 'btn btn-success',
        },
    }).then(function() {
        if(redirect) {
            window.location = redirect;
        }
    });
}
window.errorMessage = function (message) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: message ? message : 'Something went wrong!',
    });
}
