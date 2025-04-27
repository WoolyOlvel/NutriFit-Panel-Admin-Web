<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header bg-info-subtle p-3">
                <h5 class="modal-title" id="lblTitulo"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form class="tablelist-form" method="POST" id="Paciente_form" enctype="multipart/form-data" autocomplete="off">
                <div class="modal-body">
                    <input type="hidden" id="Paciente_ID" name="Paciente_ID"/>
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <div class="position-relative d-inline-block">
                                    <div class="position-absolute bottom-0 end-0">
                                        <label for="company-logo-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Select Image">
                                            <div class="avatar-xs cursor-pointer">
                                                <div class="avatar-title bg-light border rounded-circle text-muted">
                                                    <i class="ri-image-fill"></i>
                                                </div>
                                            </div>
                                        </label>
                                        <input class="form-control d-none" value="" name="foto" id="company-logo-input" type="file" accept="image/png, image/jpeg">
                                    </div>
                                    <div class="avatar-lg p-1">
                                        <div class="avatar-title bg-light rounded-circle">
                                            <img src="../../assets/images/users/user-dummy-img.jpg" id="companylogo-img" class="avatar-md rounded-circle object-fit-cover" />
                                        </div>
                                    </div>
                                </div>
                                <h5 class="fs-13 mt-3">Foto Del Paciente</h5>
                            </div>
                            <div>
                                <label for="companyname-field" class="form-label">Nombre Del Paciente</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingrese El Nombre Del Paciente" required />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <label for="owner-field" class="form-label">Apellidos Del Paciente</label>
                                <input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Ingrese Los Apellidos" required />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <label for="industry_type-field" class="form-label">Genero</label>
                                <select class="form-select" id="genero" name="genero">
                                    <option value="" disabled selected>Seleccione Un Genero</option>
                                    <option value="Femenino">Femenino</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Otros">Otros</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div>
                                <label for="star_value-field" class="form-label">Correo Electronico</label>
                                <input type="text" id="email" name="email" class="form-control" placeholder="Ingrese Un Correo" required />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div>
                                <label for="location-field" class="form-label">Telefono</label>
                                <input type="number" id="telefono" name="telefono" class="form-control" placeholder="Ingrese Un Numero Telefonico" required />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div>
                                <label for="employee-field" class="form-label">Nombre Usuario</label>
                                <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Ingrese Un Usuario" required />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div>
                                <label for="boardName" class="form-label"><strong>Rol</strong></label>
                                <select class="form-control form-select" name="rol_id" id="rol_id">
                                    <option value="2" selected>Paciente</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div>
                                <label for="website-field" class="form-label">Enfermedad</label>
                                <input class="form-control" id="taginput-choices" name="taginput-choices" data-choices data-choices-text-unique-true type="text" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="ticket-status" class="form-label">Status</label><!--ticket-status haz que se referencia a  name="status" y id="status"-->
                            <select class="form-control" data-plugin="choices" name="ticket-status" id="ticket-status">
                                <option value="" disabled selected>Seleccione Un Status</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <label for="website-field" class="form-label">Estado</label>
                                <input type="text" id="localidad" name="localidad" class="form-control" placeholder="Ingrese El Estado Del Paciente(Localidad)" required />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <label for="contact_email-field" class="form-label">Ciudad</label>
                                <input type="text" id="ciudad" name="ciudad" class="form-control" placeholder="Ingrese La Ciudad Del Paciente" required />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <label for="since-field" class="form-label">Edad</label>
                                <input type="number" id="edad" name="edad" class="form-control" placeholder="Ingrese Edad Del Paciente" required />
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Fecha Nacimiento</label>
                                <input type="text" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" data-provider="flatpickr" data-date-format="d M, Y">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" id="add-btn">Actualizar Paciente</button>
                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>