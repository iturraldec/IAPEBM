// mensaje tipo Toast
// 'toast'
// 'mensaje'
// 'error'
function lib_ShowMensaje(mensaje,tipo = 'toast') {
  switch(tipo) {
     case 'toast':
        Swal.mixin({
           toast: true,
           position: 'top-end',
           showConfirmButton: false,
           timer: 3000,
           icon: 'success'
        }).fire(mensaje)
        break;
     case 'error':
        Swal.fire({
           icon: 'error',
           title: 'Atención',
           text: mensaje
         })
        break;
   case 'mensaje':
     Swal.fire({
           title: 'Atención',
           text: mensaje
        })
     break;
  }
}

// chequear que una cadena este vacia o no
function lib_isEmpty(cadena) {
 return (cadena == null || cadena.length == 0 || /^\s+$/.test(cadena));
}

// chequear la valides de una direccion de correo electronico
function lib_isEmail(email) {
 let emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

  return emailRegex.test(email);
}

// retorna un objeto Swal para confirmar/negar una accion
function lib_Confirmar(titulo) {
 return Swal.fire({
       icon: 'question',
       title: titulo,
       showCancelButton: true,
       confirmButtonText: 'Si',
       confirmButtonColor: '#FF0000',
       cancelButtonText: 'No',
     })
}

// objeto solo letras y espacio
function lib_characterMask()
{
   return {regex:"[A-Za-z\\s]+"};
}

// objeto solo numeros
function lib_digitMask()
{
   return {regex:"\\d+"};
}

// filtro para telefonos
function lib_phoneMask()
{
   return {regex:"[\\d\\s-]+"};
}