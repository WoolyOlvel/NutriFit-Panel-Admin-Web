<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="lblTitulo"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form class="tablelist-form" autocomplete="off" method="POST" id="NutriDesafios_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="NutriDesafios_ID" name="NutriDesafios_ID" />
                   
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <div class="position-relative d-inline-block">
                                    <div class="position-absolute bottom-0 end-0">
                                        <label for="foto" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Select Image">
                                            <div class="avatar-xs cursor-pointer">
                                                <div class="avatar-title bg-light border rounded-circle text-muted">
                                                    <i class="ri-image-fill"></i>
                                                </div>
                                            </div>
                                        </label>
                                        <input class="form-control d-none" value="" name="foto" id="foto" type="file" accept="image/png, image/jpeg">
                                    </div>
                                    <div class="avatar-lg p-1">
                                        <div class="avatar-title bg-light rounded-circle">
                                            <img src="../../img/def.jpg" id="lead-img" class="avatar-md rounded-circle object-fit-cover" />
                                        </div>
                                    </div>
                                </div>
                                <h5 class="fs-13 mt-3">Foto Del NutriDesafio (Opcional)</h5>
                            </div>
                            <div>
                                <label for="nombre" class="form-label">Nombre Del NutriDesafio</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre Del NutriDesafio" required />
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <div>
                                <label for="tipo" class="form-label">Tipo</label>
                                <input type="text" class="form-control" name="tipo" id="tipo" placeholder="Tipo NutriDesafios, Por Ejemplo: Memoramas, Sopa De Letras" required />
                            </div>
                        </div>
                      
                        <!--end col-->
                        <div class="col-lg-12">
                            <div>
                                <label for="url" class="form-label">Url Del NutriDesafio</label>
                                <input type="text" class="form-control" name="url" id="url" placeholder="Url Del NutriDesafio" required />
                            </div>
                        </div>
                    
                        <div class="col-lg-12">
                            <label for="ticket-status" class="form-label">Status</label>
                            <select class="form-control" data-plugin="choices" name="ticket-status" id="ticket-status">
                                <option value="" disabled selected>Seleccione Un Status</option>
                                <option value="1">Activo</option>
                                <option value="2">Próximamente</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" name="action" value="add" class="btn btn-success" id="add-btn">Añadir NutriDesafio</button>
                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>