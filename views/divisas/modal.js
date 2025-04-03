
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
        url:"../../controllers/categoria.php?op=guardar_editar",
        type:"POST",
        data:formData,
        contentType:false,
        processData:false,
        success:function(data){
            $('#buttons-datatables').DataTable().ajax.reload();
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Cambios Exitosos",
                showConfirmButton: false,
                timer: 1500
            });
              $('#modalCategoria').modal('hide')
        }
    });

}

$(document).ready(function(){
    /* TODO: Listar informacion en el datatable js */
    $('#buttons-datatables').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
        ],
        "ajax":{
            url:"../../controllers/categoria.php?op=listar",
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
                                        '<h5 class="mt-2">Lo Sentimos! No Se Encontró La Categoría</h5>' +
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

function editar(Categoria_ID){
    $.post("../../controllers/categoria.php?op=mostrar",{Categoria_ID:Categoria_ID},function(data){
        data = JSON.parse(data);
        $('#Categoria_ID').val(data.Categoria_ID);
        $('#Categoria_Nombre').val(data.Categoria_Nombre);

       
    });
    $('#lblTitulo').html('Editar Categoria');
    $('#modalCategoria').modal('show');
}


function eliminar(Categoria_ID) {
    $('#removeNotificationModal').modal('show'); // Mostrar el modal de notificación de eliminación

    // Cuando se hace clic en "Sí, Eliminar Cliente" en el modal
    $('#delete-notification').on('click', function() {
        // Cierra el modal de notificación de eliminación
        $('#removeNotificationModal').modal('hide');
        
        // Muestra el SweetAlert de eliminación exitosa
        Swal.fire({
            title: "¡Eliminado!",
            text: "La Categoría Fue Eliminado Exitosamente",
            icon: "success"
        });
        $.post("../../controllers/categoria.php?op=eliminar",{Categoria_ID:Categoria_ID},function(data){
            console.log(data);
        });

        // Recarga los datos en el DataTable después de eliminar el cliente
        $('#buttons-datatables').DataTable().ajax.reload();
    });
}

/* function eliminar(Categoria_ID) {
    Swal.fire({
        title: "¿Está Seguro De Eliminar Esta Categoria?",
        text: "No Podrá Recuperar La Categoria",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar!"
      }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
              title: "¡Eliminado!",
              text: "La Categoria Fue Eliminada Exitosamente",
              icon: "success"
            });
            if(result.value){
                $.post("../../controllers/categoria.php?op=eliminar",{Categoria_ID:Categoria_ID},function(data){
                    console.log(data);
                });
    
                $('#buttons-datatables').DataTable().ajax.reload();
    
              
            }
           
        }
 
      });
} */
  

$(document).on("click","#btnNuevo",function(){
    $('#Categoria_ID').val('');
    $('#Categoria_Nombre').val('');
    $('#lblTitulo').html('Agregar Nueva Divisas');
    $("#Categoria_form")[0].reset();
    $('#modalCategoria').modal('show')
});

init();