<div class="modal fade" id="modalCategoria" tabindex="-1" aria-labelledby="createboardModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-info-subtle">
                <h5 class="modal-title" id="lblTitulo"></h5>
                <button type="button" class="btn-close" id="addBoardBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="Categoria_form">
                <div class="modal-body">
                    <input type="hidden" name="Categoria_ID" id="Categoria_ID" />

                    <div class="row">
                        <div class="col-lg-12">
                            <label for="boardName" class="form-label"><strong>Nombre De La Composición Corporal</strong></label>
                            <input type="text" class="form-control" name="Categoria_Nombre" id="Categoria_Nombre" placeholder="Ingresar Nombre Composición Corporal" required/>
                        </div>
                        <div class="mt-4">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="reset" class="btn btn-light" data-bs-dismiss="modal"><strong>Cerrar</strong></button>
                                <button type="submit" name="action" value="add" class="btn btn-success"><strong>Guardar Composición Corporal</strong></button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<!--end add board modal-->