(() => {
    'use strict'
  
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')
  
    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
  
        form.classList.add('was-validated')
      }, false)
    })
  })()




// function validaForm()
// {
//     var form = document.getElementById("registration");
//     window.alert("validazione");
//     if (checkDataNascita()) {window.alert("data non valida"); form.classList.add("was-validated");}
//     return checkDataNascita();
// }

// function checkDataNascita()
// {
//     var dataNascita = document.registration.inputBirthdate.value;
//     var dataCorrente = new Date();
//     if (dataNascita > dataCorrente) return false;
//     return true;
// }