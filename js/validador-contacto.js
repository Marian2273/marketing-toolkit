// JavaScript Validación
$('document').ready(function () {
                // Validación para campos de texto exclusivo, sin caracteres especiales ni
                // números
                var nameregex = /^[a-zA-Z ]+$/;
            
                $.validator.addMethod("validname", function (value, element) {
                        return this.optional(element) || nameregex.test(value);
                    });
            
                // Máscara para validación de Email
                var eregex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            
                $.validator.addMethod("validemail", function (value, element) {
                        return this.optional(element) || eregex.test(value);
                    });
            
            

$("#formulariocontacto").validate({
            
               rules: {
                nombre: {
                required: true,
                },
               email: {
                 required: true,
                 validemail: true
               },
               asunto: {
                required: true,
                },
                mensaje: {
                 required: true,
               },
                                  
                },
                messages: {
                nombre: {
                    required: "Este dato es obligatorio",
                },
                email: {
                required: "Por favor, ingrese una dirección de correo válida",
                validemail: "Introduzca correctamente su correo"
                },
               
                mensaje: {
                    required: "Este dato es obligatorio",
                                }
                                  
                                },
                                errorPlacement: function (error, element) {
                                    $(element)
                                        .closest('.form-group')
                                        .find('.help-block')
                                        .html(error.html());
                                },
                                highlight: function (element) {
                                    $(element)
                                        .closest('.form-group')
                                        .removeClass('has-success')
                                        .addClass('has-error');
                                },
                                unhighlight: function (element, errorClass, validClass) {
                                    $(element)
                                        .closest('.form-group')
                                        .removeClass('has-error')
                                        .addClass('has-success');
                                    $(element)
                                        .closest('.form-group')
                                        .find('.help-block')
                                        .html('');
                                },
                        
                               /* submitHandler: function (form) {
                                   /* var form = $('#formulario-contacto');
                                    form.action = "functions/ingreso-contrato.php";
                                    form.submit(); 
                                    
                        
                                }*/
                                submitHandler: function (form) {
                                                grecaptcha.ready(function () {
                                                    grecaptcha.execute('6LeLicwZAAAAAOWs-iFpzsME7M7LWaUzbZPc3xm2',{action: 'application_form'}).then(function(token){
                                    
                                                            // var formData = $(form).serialize();
                                                            let formData = {
                                                                email: $('#email').val(),
                                                                nombre: $('#nombre').val(),
                                                                asunto: $('#asunto').val(),
                                                                mensaje: $('#mensaje').val(),
                                                                token: token,
                                                                action: 'application_form'
                                                            };
                                                            $(form).ajaxSubmit({
                                    
                                                                type: 'POST',
                                                                url: 'functions/contacto.php',
                                                                data: formData,
                                                                success: function (html) {
                                                                    if (html == 'true') {
                                                                        Swal.fire({icon: 'success', 
                                                                        title: '<span style="font-size:16px;"> Su Mensaje fue enviado con éxito.<br> Muchas Gracias! </span>', 
                                                                        showConfirmButton: true, 
                                                                        confirmButtonColor: '#27ce4b', 
                                                                         }).then(function(){ 
                                                                        location.reload();
                                                                        });
                                                                       
                                                                       
                                                                    }  else {
                                                                        $("#add_err").html(html);
                                    
                                                                    }
                                                                },
                                                                beforeSend: function () {

                                                                    $("#add_err").html('<img src="img/loading-gif-800x600.gif" class="img-responsive loading-contacto" />');
                                    
                                                                }
                                    
                                                            });
                                    
                                                        });
                                                });
                                    
                                } // end submit handler
                        });






                     
});
$(function () {
    // Get the form.
    var form = $('#newsletter');
    // Get the messages div.
   
    // Set up an event listener for the contact form.
    $(form).submit(function (e) {
        // Stop the browser from submitting the form.
        e.preventDefault();
  
        // Serialize the form data.
        var formData = $(form).serialize();
  
        // Submit the form using AJAX.
        $.ajax({
            type: 'POST',
            url: $(form).attr('action'),
            data: formData,
            success: function (html) {
                if (html == 'true') {
                  $("#error_1").html(html);
              
  
                } else {
  
                    $("#error_1").addClass('animated fadeInDown');
                    $("#error_1").html(html);
                   // setInterval('location.reload()', 2000);
  
                }
            },
            beforeSend: function () {
  
                $("#error_1").addClass('animated fadeInDown');
                $("#error_1").html(" Procesando ...");
               
            }
        });
  
    });
  
  });
