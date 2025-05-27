  <!-- Modal -->
  <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-labelledby="deleteRecordLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
              </div>
              <div class="modal-body p-5 text-center">
                  <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                  <div class="mt-4 text-center">
                      <h4 class="fs-semibold">¿Esta Seguro De Eliminar Este NutriDesafio?</h4>
                      <p class="text-muted fs-14 mb-4 pt-1">Se Perderá Toda Información Sobre El NutriDesafio.</p>
                      <div class="hstack gap-2 justify-content-center remove">
                          <button class="btn btn-link link-success fw-medium text-decoration-none" id="deleteRecord-close" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> No, No Eliminar!</button>
                          <button class="btn btn-danger" id="delete-record">Si, Eliminar NutriDesafio!!</button>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>