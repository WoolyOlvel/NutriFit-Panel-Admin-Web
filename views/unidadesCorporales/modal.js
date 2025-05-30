const BASE_URL = "https://nutrifitplanner.site";

function init() {
  $("#MedidasCorporales_form").on("submit", function (e) {
    e.preventDefault(); // Agrega esto aquí también
    guardar_editar(e);
  });
}

function guardar_editar(e) {
  e.preventDefault();
  var formData = new FormData($("#MedidasCorporales_form")[0]);
  $.ajax({
    url: `${BASE_URL}/api/medidas_corporales/guardar_editar`,
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
      $("#buttons-datatables").DataTable().ajax.reload();
      Swal.fire({
        position: "center",
        icon: "success",
        title: "Cambios Exitosos",
        showConfirmButton: false,
        timer: 1500,
      });
      $("#modalCategoria").modal("hide");
    },
  });
}

$(document).ready(function () {
    /* TODO: Listar informacion en el datatable js */
    $("#buttons-datatables").DataTable({
      aProcessing: true,
      aServerSide: true,
      dom: "Bfrtip",
      buttons: ["copyHtml5", "excelHtml5", "csvHtml5"],
      ajax: {
        url: `${BASE_URL}/api/medidas_corporales/listar`,
        type: "GET",
        data: {},
        error: function (xhr, error, thrown) {
          console.log("Error en DataTables:", error);
          console.log("Detalles:", thrown);
          console.log("Respuesta:", xhr.responseText);
        },
      },
      columns: [
        { data: "nombre" },
        { data: "fecha_creacion" },
        {
          data: "MedidasCorporales_ID",
          render: function (data) {
            return `
              <button type="button" class="btn btn-sm" onclick="editar(${data})" title="Editar">
                <lord-icon
                  src="https://cdn.lordicon.com/cbtlerlm.json"
                  trigger="loop"
                  delay="1500"
                  state="in-dynamic"
                  colors="primary:#000000,secondary:#eeca66,tertiary:#ffffff,quaternary:#f9c9c0,quinary:#000000"
                  style="width:40px;height:40px">
                </lord-icon>
              </button>
            `;
          },
        },
        {
          data: "MedidasCorporales_ID",
          render: function (data) {
            return `
              <button type="button" class="btn btn-sm" onclick="eliminar(${data})" title="Eliminar">
                <lord-icon
                  src="https://cdn.lordicon.com/nhqwlgwt.json"
                  trigger="loop"
                  delay="2000"
                  stroke="bold"
                  colors="primary:#ffffff,secondary:#c71f16,tertiary:#000000,quaternary:#848484"
                  style="width:40px;height:40px">
                </lord-icon>
              </button>
            `;
          },
        },
      ],
  
      bDestroy: true,
      responsive: true,
      bInfo: true,
      iDisplayLength: 10,
      order: [[0, "desc"]],
      language: {
        sProcessing: "Procesando...",
        sLengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords:
          '<div class="noresult">' +
          '<div class="text-center">' +
          '<lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>' +
          '<h5 class="mt-2">Lo Sentimos! No Se Encontró La Medida Corporal</h5>' +
          '<p class="text-muted mb-0">Hemos buscado en todo el sistema y No se encuentra ninguna coincidencia para su búsqueda.</p>' +
          "</div>" +
          "</div>",
        sEmptyTable: "Ningún dato disponible en esta tabla",
        sInfo:
          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
        sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
        sInfoPostFix: "",
        sSearch: "Buscar:",
        sUrl: "",
        sInfoThousands: ",",
        sLoadingRecords: "Cargando...",
        oPaginate: {
          sFirst: "Primero",
          sLast: "Último",
          sNext: "Siguiente",
          sPrevious: "Anterior",
        },
        oAria: {
          sSortAscending:
            ": Activar para ordenar la columna de manera ascendente",
          sSortDescending:
            ": Activar para ordenar la columna de manera descendente",
        },
      },
    });
  });

function editar(MedidasCorporales_ID) {
    $.post(`${BASE_URL}/api/medidas_corporales/mostrar`, { MedidasCorporales_ID: MedidasCorporales_ID }, function (data) {
        $("#MedidasCorporales_ID").val(data.MedidasCorporales_ID);
        $("#nombre").val(data.nombre);
        $("#lblTitulo").text("Editar Medida Corporal");
        $("#modalCategoria").modal("show");
    });
}

function eliminar(MedidasCorporales_ID) {
    $("#removeNotificationModal").modal("show");
    $("#delete-notification").on("click");
    $("#delete-notification").on("click", function () {
        $("#removeNotificationModal").modal("hide");
        $.post(`${BASE_URL}/api/medidas_corporales/eliminar`, { MedidasCorporales_ID: MedidasCorporales_ID }, function (data) {
            Swal.fire({
                title: "¡Eliminado!",
                text: "Medida Corporal Eliminado exitosamente",
                icon: "success",
            });
            $("#buttons-datatables").DataTable().ajax.reload();
           
        });
    })
}

$(document).on("click", "#btnNuevo", function () {
    $("#MedidasCorporales_ID").val("");
    $("#nombre").val("");
    $("#lblTitulo").text("Agregar Nueva Medida Corporal");
    $('#MedidasCorporales_form')[0].reset(); // Limpiar el formulario
    $("#modalCategoria").modal("show");
})

init();