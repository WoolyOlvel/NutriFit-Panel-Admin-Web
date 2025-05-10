<div class="modal fade" id="event-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-info-subtle">
                <h5 class="modal-title" id="modal-title">Reservación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body p-4">
                <form class="needs-validation" name="event-form" id="form-event" method="POST" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="Reservacion_ID" id="Reservacion_ID" />
                    <div class="text-end">
                        <!-- Updated edit button with proper function call -->
                        <a href="#" class="btn btn-sm btn-soft-primary" id="edit-event-btn" data-id="edit-event" onclick="window.editEvent(this)" role="button">Ver Información</a>
                    </div>
                    <div class="event-details">
                        <div class="d-flex mb-2">
                            <div class="flex-grow-1 d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="mdi mdi-calendar-outline text-muted fs-16"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="d-block fw-semibold mb-0" id="event-start-date-tag">5</h6>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0 me-3">
                                <i class="ri-time-line text-muted fs-16"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="d-block fw-semibold mb-0"><span id="event-timepicker1-tag"></span></span></h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0 me-3">
                                <i class="mdi mdi-office-building-outline text-muted fs-16"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="d-block fw-semibold mb-0"> <span id="event-location-tag"></span></h6>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0 me-3">
                                <i class="ri-map-pin-line text-muted fs-16"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="d-block text-muted mb-0" id="event-description-tag"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row event-form" style="display: none;">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Paciente</label>
                                <input class="form-control" placeholder="Nombre Paciente" type="text" name="nombre_paciente" id="event-title" readonly required value="" />
                                <div class="invalid-feedback">Ingrese El Nombre Del Paciente</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Telefono</label>
                                <input class="form-control" placeholder="Telefono Del Paciente" type="text" name="telefono" id="telefono" readonly required value="" />
                                <div class="invalid-feedback">Ingrese El Telefono Del Paciente</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Genero</label>
                                <input class="form-control" placeholder="Genero Del Paciente" type="text" name="genero" id="genero" readonly required value="" />
                                <div class="invalid-feedback">Ingrese El Genero Del Paciente</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Usuario</label>
                                <input class="form-control" placeholder="Usuario Del Paciente" type="text" name="usuario" id="usuario" readonly required value="" />
                                <div class="invalid-feedback">Ingrese El Usuario Del Paciente</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Edad</label>
                                <input class="form-control" placeholder="Edad Del Paciente" type="text" name="edad" id="edad" readonly required value="" />
                                <div class="invalid-feedback">Ingrese La Edad Del Paciente</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label>Fecha Reservación</label>
                                <div class="input-group">
                                    <input type="text" id="event-start-date" class="form-control flatpickr-input" placeholder="Seleccionar Fecha Reservación" readonly disabled required>
                                    <span class="input-group-text"><i class="ri-calendar-event-line"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" id="event-time">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Horario Reservación</label>
                                        <div class="input-group">
                                            <input id="timepicker1" type="text" class="form-control flatpickr-input" placeholder="Selecciona El Horario De La Reservación" disabled readonly>
                                            <span class="input-group-text"><i class="ri-time-line"></i></span>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="event-location">Consultorio</label>
                                <div>
                                    <input type="text" class="form-control" name="event-location" id="event-location" placeholder="Nombre Del Consultorio" required value="">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="eventid" name="eventid" value="" />
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Dirección Del Consultorio</label>
                                <textarea class="form-control" id="event-description" placeholder="Dirección Del Consultorio" rows="5" spellcheck="false"></textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Motivo De La Consulta</label>
                                <textarea class="form-control" id="motivo-consulta" placeholder="Motivo De La Reservación" rows="5" spellcheck="false" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="precio-consulta">Precio De La Consulta</label>
                                <div>
                                    <input type="text" class="form-control" name="precio-consulta" id="precio-consulta" placeholder="Precio De La Consulta" required value="" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Proxima Consulta</label>
                                <div class="input-group">
                                    <input id="proxima-consulta" type="text" class="form-control flatpickr flatpickr-input" placeholder="Selecciona Fecha Próxima Consulta" readonly>
                                    <span class="input-group-text"><i class="ri-time-line"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Nutriologo</label>
                                <input class="form-control" placeholder="Nombre Del Nutriólogo" type="text" name="nombre_nutriologo" id="nombre_nutriologo" required value="" readonly />
                                <div class="invalid-feedback">Ingrese El Nombre Del Nutriólogo</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Estado De La Reservación</label>
                                <select class="form-select" name="estado_proximaConsulta" id="estado_proximaConsulta" required>
                                     <option value="bg-danger-subtle">Cancelado</option>
                                     <option value="bg-success-subtle">En Progreso</option>
                                     <option value="bg-primary-subtle">Proxima Consulta</option>
                                     <option value="bg-info-subtle">Realizado</option>
                                     <option value="bg-warning-subtle" selected>En Espera</option>
                                </select>
                                <div class="invalid-feedback">Seleccione Algun Estado De La Reservación</div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="current-status" value="4">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-soft-danger" id="btn-close-event">Cerrar</button>
                        <button type="submit" class="btn btn-success" id="btn-save-event" style="display: none;">Actualizar Reservacion</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>