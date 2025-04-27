<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="lblTitulo"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form class="tablelist-form" autocomplete="off" method="POST" id="Paciente_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="Paciente_ID" name="Paciente_ID" />
                   
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <div class="position-relative d-inline-block">
                                    <div class="position-absolute bottom-0 end-0">
                                        <label for="lead-image-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Select Image">
                                            <div class="avatar-xs cursor-pointer">
                                                <div class="avatar-title bg-light border rounded-circle text-muted">
                                                    <i class="ri-image-fill"></i>
                                                </div>
                                            </div>
                                        </label><!--Haz que lead-image-input se haga referencia a name="foto" y id="foto" para que lo pueda recibirla bd-->
                                        <input class="form-control d-none" value="" name="foto" id="lead-image-input" type="file" accept="image/png, image/jpeg">
                                    </div>
                                    <div class="avatar-lg p-1">
                                        <div class="avatar-title bg-light rounded-circle">
                                            <img src="../../assets/images/users/user-dummy-img.jpg" id="lead-img" class="avatar-md rounded-circle object-fit-cover" />
                                        </div>
                                    </div>
                                </div>
                                <h5 class="fs-13 mt-3">Foto Del Paciente (Opcional)</h5>
                            </div>
                            <div>
                                <label for="leadname-field" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre Del Paciente" required />
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <div>
                                <label for="company_name-field" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Apellidos Del Paciente" required />
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="ticket-status" class="form-label">Genero</label>
                            <select class="form-control" data-plugin="choices" name="genero" id="genero">
                                <option value="" disabled selected>Seleccione Un Genero</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Otros">Otros</option>

                            </select>
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                            <div>
                                <label for="leads_score-field" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Correo Del Paciente" required />
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                            <div>
                                <label for="phone-field" class="form-label">Telefono</label>
                                <input type="number" class="form-control" name="telefono" id="telefono" maxlength="10" placeholder="Telefono Del Paciente" required />
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div>
                                <label for="company_name-field" class="form-label">Usuario</label>
                                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario Del Paciente" required />
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <div>
                                <label for="boardName" class="form-label"><strong>Rol</strong></label>
                                <select class="form-control form-select" name="rol_id" id="rol_id">
                                    <option value="2" selected>Paciente</option>
                                </select>

                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-12">
                            <div>
                                <label for="website-field" class="form-label">Enfermedad</label>
                                <input class="form-control" id="taginput-choices" name="taginput-choices"  data-choices data-choices-text-unique-true type="text" />
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <label for="ticket-status" class="form-label">Status</label><!--ticket-status haz que se referencia a  name="status" y id="status"-->
                            <select class="form-control" data-plugin="choices" name="ticket-status" id="ticket-status">
                                <option value="" disabled selected>Seleccione Un Status</option>
                                <option value="1">Activo</option>
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
                        <button type="submit" name="action" value="add" class="btn btn-success" id="add-btn">Añadir Paciente</button>
                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>