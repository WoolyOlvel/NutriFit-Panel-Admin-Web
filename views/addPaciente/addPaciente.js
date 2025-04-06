var Sucursal_ID = $('#Sucursal_IDx').val();

function init(){
    $("#Categoria_form").on("submit",function(e){
        guardar_editar(e);
    });
}

function guardar_editar(e){
    e.preventDefault();
    var formData = new FormData($("#Categoria_form")[0]);
    formData.append('Sucursal_ID', $('#Sucursal_IDx').val());
    $.ajax({
        url:"../../controllers/usuario.php?op=guardar_editar",
        type:"POST",
        data:formData,
        contentType:false,
        processData:false,
        success:function(data){
            $('#ticketTable').DataTable().ajax.reload();
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Cambios Exitosos",
                showConfirmButton: false,
                timer: 1500
            });
              $('#showModal').modal('hide')
        }
    });

}

$(document).ready(function(){

    $.post("../../controllers/rol.php?op=combo",{Sucursal_ID:Sucursal_ID},function(data){
        $("#Rol_ID").html(data);
    });

    /* TODO: Listar informacion en el datatable js */
    $('#ticketTable').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
        ],
        "ajax":{
            url:"../../controllers/usuario.php?op=listar",
            type:"post",
            data:{Sucursal_ID:Sucursal_ID}
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 10,
        "order": [[ 0, "desc" ]],
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    '<div class="noresult">' +
                                    '<div class="text-center">' +
                                        '<lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>' +
                                        '<h5 class="mt-2">Lo Sentimos! No Se Encontró El Usuario</h5>' +
                                        '<p class="text-muted mb-0">Hemos buscado en todo el sistema y No se encuentra ninguna coincidencia para su búsqueda.</p>' +
                                    '</div>' +
                                '</div>',
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
    });

});

function editar(Usuario_ID){
    $.post("../../controllers/usuario.php?op=mostrar",{Usuario_ID:Usuario_ID},function(data){
        data = JSON.parse(data);
        $('#Usuario_ID').val(data.Usuario_ID);
        $('#Usuario_Correo').val(data.Usuario_Correo);
        $('#Usuario_Nombre').val(data.Usuario_Nombre);
        $('#Usuario_Apellido').val(data.Usuario_Apellido);
        $('#Usuario_DNI').val(data.Usuario_DNI);
        $('#Usuario_Telefono').val(data.Usuario_Telefono);
        $('#Usuario_Password').val(data.Usuario_Password);
        $('#Rol_ID').val(data.Rol_ID).trigger('change');
        $('#Pre_Imagen').html(data.Usuario_IMG);

        
    });
    $('#lblTitulo').html('Editar Usuario');
    $('#showModal').modal('show');
}


function eliminar(Usuario_ID) {
    $('#removeNotificationModal').modal('show'); // Mostrar el modal de notificación de eliminación

    // Cuando se hace clic en "Sí, Eliminar Cliente" en el modal
    $('#delete-notification').on('click', function() {
        // Cierra el modal de notificación de eliminación
        $('#removeNotificationModal').modal('hide');
        
        // Muestra el SweetAlert de eliminación exitosa
        Swal.fire({
            title: "¡Eliminado!",
            text: "El Usuario Fue Eliminado Exitosamente",
            icon: "success"
        });
        $.post("../../controllers/usuario.php?op=eliminar",{Usuario_ID:Usuario_ID},function(data){
            
        });

        // Recarga los datos en el DataTable después de eliminar el cliente
        $('#ticketTable').DataTable().ajax.reload();
    });
}

/* function eliminar(Usuario_ID) {
    Swal.fire({
        title: "¿Está Seguro De Eliminar Este Usuario?",
        text: "No Podrá Recuperar El Usuario",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar!"
      }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
              title: "¡Eliminado!",
              text: "El Usuario Fue Eliminado Exitosamente",
              icon: "success"
            });
            if(result.value){
                $.post("../../controllers/usuario.php?op=eliminar",{Usuario_ID:Usuario_ID},function(data){
                    console.log(data);
                });
    
                $('#ticketTable').DataTable().ajax.reload();
    
              
            }
           
        }
 
      });
} */
  

$(document).on("click","#btnNuevo",function(){
    $('#Usuario_ID').val('');
    $('#Usuario_Nombre').val('');
    $('#lblTitulo').html('Agregar Nuevo Usuario');
    $('#Pre_Imagen').html('<img src="../../usuario/no-user.png" alt="noUsuario" class="rounded-circle avatar-xl img-thumbnail user-profile-image"/><input type = "hidden" name="hidden_Usuario_IMG" value="" />');
    $("#Categoria_form")[0].reset();
    $('#showModal').modal('show')
});

function filePreview(input){
    if(input.files && input.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
            
            $('#Pre_Imagen').html('<img  src='+e.target.result+' alt="noUSER" class="rounded-circle avatar-xl img-thumbnail user-profile-image"/> '+
            "<div class='avatar-xs p-0 rounded-circle profile-photo-edit'>"+
                "<input id='removeFoto'  class='profile-img-file-input'>"+
                    "<label for='removeFoto' class='profile-photo-edit avatar-xs'>"+
                        "<span class='avatar-title rounded-circle bg-light text-body'>"+
                            "<i class=' ri-delete-bin-fill'></i>"+
                         "</span>"+
                    "</label>"+
            "</div>"
            );
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(document).on("click","#removeFoto",function(){
    $('#Usuario_IMG').val('');
    $('#Pre_Imagen').html('<img src="../../usuario/no-user.png" alt="noUSER" class="rounded-circle avatar-xl img-thumbnail user-profile-image"/><input type = "hidden" name="hidden_Usuario_IMG" value=""');
});

$(document).on('change','#Usuario_IMG',function(){
    filePreview(this);
})

init();