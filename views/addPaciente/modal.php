
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="createboardModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-info-subtle">
                <h5 class="modal-title" id="lblTitulo"></h5>
                <button type="button" class="btn-close" id="addBoardBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="Categoria_form">
                <div class="modal-body">
                    <input type="hidden" name="Usuario_ID" id="Usuario_ID" />

                    <div class="row">
                        <div class="col-lg-12">
                            <label for="boardName" class="form-label"><strong>Correo</strong></label>
                            <input type="text" class="form-control" name="Usuario_Correo" id="Usuario_Correo" placeholder="Ingresar Correo Electronico" required />
                        </div>

                        <div class="col-lg-12">
                            <label for="boardName" class="form-label"><strong>Nombre</strong></label>
                            <input type="text" class="form-control" name="Usuario_Nombre" id="Usuario_Nombre" placeholder="Ingresar Nombre Del Usuario" required />
                        </div>

                        <div class="col-lg-12">
                            <label for="boardName" class="form-label"><strong>Apellidos</strong></label>
                            <input type="text" class="form-control" name="Usuario_Apellido" id="Usuario_Apellido" placeholder="Ingresar Apellidos Del Usuario" required />
                        </div>

                        <div class="col-lg-12">
                            <label for="boardName" class="form-label"><strong>Usuario</strong></label>
                            <input type="text" class="form-control" name="Usuario_DNI" id="Usuario_DNI" placeholder="Ingresar DNI (Opcional)"/>
                        </div>

                        <div class="col-lg-12">
                            <label for="boardName" class="form-label"><strong>Teléfono</strong></label>
                            <input type="text" class="form-control" name="Usuario_Telefono" id="Usuario_Telefono" placeholder="Ingresar Número Teléfonico" required />
                        </div>

                        <div class="col-lg-12">
                            <label for="boardName" class="form-label"><strong>Contraseña</strong></label>
                            <input type="password" class="form-control" name="Usuario_Password" id="Usuario_Password" placeholder="Ingresar Contraseña" required />
                        </div>

                        <div class="col-lg-12">
                            <label for="boardName" class="form-label"><strong>Rol</strong></label>
                                <select type="text" class="form-control form-select" name="Rol_ID" id="Rol_ID" aria-label="Seleccionar Unidad">
                                    <option selected>Seleccionar</option>
                                </select>
                        </div>

                        <div class="row gy-2">

                            <div class="col-md-12">
                                <div>
                                    <label for="valueInput" class="form-label">Imagen</label>
                                    <input type="file" class="form-control" name="Usuario_IMG" id="Usuario_IMG"">
                            </div>
                        </div>

                    </div>

                    <br>
                        <div class=" row gy-2">
                                    <div class="col-md-12">
                                        <div class="text-center">
                                            <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                                <span id="Pre_Imagen"></span>

                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>



                            <div class="mt-4">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="reset" class="btn btn-light" data-bs-dismiss="modal"><strong>Cerrar</strong></button>
                                    <button type="submit" name="action" value="add" class="btn btn-success"><strong>Guardar Paciente</strong></button>
                                </div>
                            </div>
                        </div>

                    </div>
            </form>
        </div>
    </div>
</div>
<!--end add board modal-->