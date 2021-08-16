
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Título da Página</label>
                                        <div class="col-sm-5">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="titulo" class="form-control" value="<?php echo $noticia["titulo"];?>" required="required" maxlength="100">
                                                <span class="help-block">Título (Não usar aspas)</span>
                                            </div>
                                        </div>
                                        <label class="col-sm-2 label-on-left">Status</label>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <select class="form-control" name="status" id="status">
                                                    <option value="L" <?php if($noticia["status"] == 'L'){echo "selected";}?>>Liberado</option>
                                                    <option value="B" <?php if($noticia["status"] == 'B'){echo "selected";}?>>Bloqueado</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <label class="col-sm-2 label-on-left">Resumo</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="resumo" id="resumo" class="form-control" value="<?php echo $noticia["resumo"];?>" maxlength="250" required="required">
                                                <span class="help-block">Inserir o resumo da matéria com no máximo 250 caracteres</span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <legend class="col-sm-2 label-on-left">Imagem Corpo / Matéria</legend>
                                        <div class="col-sm-4">
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                                <?php if($noticia["arquivo"]):?>
                                                <img src="../../conteudos/noticia/<?php echo $noticia["arquivo"];?>" alt="...">
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

                                    <label class="col-sm-2 label-on-left">Texto Completo</label>
                                    <div class="col-sm-10">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <textarea name="texto" id="texto" class="form-control texto" rows="15"><?php echo $noticia["texto"];?></textarea>
                                            <span class="help-block">Inserir o texto completo da página</span>
                                        </div>
                                    </div>

                                    </div>