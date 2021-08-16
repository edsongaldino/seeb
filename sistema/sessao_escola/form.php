
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Nome da Escola</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="titulo_escola" class="form-control" value="<?php echo $escola["titulo_escola"];?>" required="required">
                                                <span class="help-block">Título (Não usar aspas)</span>
                                            </div>
                                        </div>

                                        <label class="col-sm-2 label-on-left">Status</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <select class="form-control" name="status" id="status">
                                                    <option value="L" <?php if($escola["status"] == 'L'){echo "selected";}?>>Liberado</option>
                                                    <option value="B" <?php if($escola["status"] == 'B'){echo "selected";}?>>Bloqueado</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <legend class="col-sm-2 label-on-left">Logo da Escola</legend>
                                        <div class="col-sm-4">
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                                <?php if($escola["arquivo"]):?>
                                                <img src="../../conteudos/escola/<?php echo $escola["arquivo"];?>" alt="...">
                                                <?php else:?>
                                                <img src="../../sistema/assets/img/image_placeholder.jpg" alt="...">
                                                <?php endif;?>
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                            <div>
                                                <span class="btn btn-rose btn-round btn-file">
                                                    <span class="fileinput-new">Selecione a imagem</span>
                                                    <span class="fileinput-exists">Alterar</span>
                                                    <input type="file" name="arquivo" />
                                                </span>
                                                <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remover</a>
                                            </div>
                                        </div>
                                        </div>
                                    </div>