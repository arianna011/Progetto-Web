(() => {
    'use strict'
  
    //Estrazione delle form su cui si vuole applicare la validazione
    const forms = document.querySelectorAll('.needs-validation')
  
    //Ciclo sulle form e blocco dell'invio dei dati in caso di errori
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
