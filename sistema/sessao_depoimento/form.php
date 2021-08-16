
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Nome</label>
                                        <div class="col-sm-5">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="titulo" class="form-control" value="<?php echo $depoimento["titulo"];?>" required="required">
                                                <span class="help-block">Nome (Não usar aspas)</span>
                                            </div>
                                        </div>

                                        <label class="col-sm-2 label-on-left">Qtde Estrelas</label>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <select class="form-control" name="estrelas" id="estrelas">
                                                    <option value="1" <?php if($depoimento["estrelas"] == '1'){echo "selected";}?>>1</option>
                                                    <option value="2" <?php if($depoimento["estrelas"] == '2'){echo "selected";}?>>2</option>
                                                    <option value="3" <?php if($depoimento["estrelas"] == '3'){echo "selected";}?>>3</option>
                                                    <option value="4" <?php if($depoimento["estrelas"] == '4'){echo "selected";}?>>4</option>
                                                    <option value="5" <?php if($depoimento["estrelas"] == '5'){echo "selected";}?>>5</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <label class="col-sm-2 label-on-left">Empresa</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="subtitulo" id="subtitulo" class="form-control" value="<?php echo $depoimento["subtitulo"];?>" required="required">
                                                <span class="help-block">Nome da empresa</span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <legend class="col-sm-2 label-on-left">Banner / Foto</legend>
                                        <div class="col-sm-4">
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                                <?php if($depoimento["arquivo"]):?>
                                                <img src="../../conteudos/depoimento/<?php echo $depoimento["arquivo"];?>" alt="...">
                                                <?php else:?>
                                                <img src="../../sistema/assets/img/image_placeholder.jpg" alt="...">
                                                <?php endif;?>
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                            <div>
                                                <span class="btn btn-rose btn-round btn-file">
                                                    <span class="fileinput-new">Select image</span>
                                                    <span class="fileinput-exists">Change</span>
                                                    <input type="file" name="arquivo" />
                                                </span>
                                                <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                            </div>
                                        </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                    <label class="col-sm-2 label-on-left">Depoimento Completo</label>
                                    <div class="col-sm-10">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <textarea name="depoimento" id="depoimento_completo" class="form-control depoimento" rows="15"><?php echo $depoimento["depoimento"];?></textarea>
                                            <span class="help-block">Inserir o depoimento completo</span>
                                        </div>
                                    </div>

                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Status</label>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <select class="form-control" name="status" id="status">
                                                    <option value="L" <?php if($depoimento["status"] == 'L'){echo "selected";}?>>Liberado</option>
                                                    <option value="B" <?php if($depoimento["status"] == 'B'){echo "selected";}?>>Bloqueado</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>