
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Título do Banner</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="titulo_banner" class="form-control" value="<?php echo $banner["titulo_banner"];?>" required="required">
                                                <span class="help-block">Título (Não usar aspas)</span>
                                            </div>
                                        </div>

                                        <label class="col-sm-1 label-on-left">Data Inicial</label>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="date" name="data_inicial" class="form-control datetimepicker" value="<?php echo $banner["data_inicial"];?>" />
                                            </div>
                                        </div>

                                        <label class="col-sm-1 label-on-left">Data Final</label>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="date" name="data_final" class="form-control datetimepicker" value="<?php echo $banner["data_final"];?>" />                                                
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <?php
                                        // Seleciona os tipos de banners
                                        $sql_tipo_banner = "SELECT * FROM tipo_banner";
                                        $query_tipo_banner = $pdo->query( $sql_tipo_banner );
                                        $tipos_banner = $query_tipo_banner->fetchAll( PDO::FETCH_ASSOC );
                                        ?>

                                        <label class="col-sm-2 label-on-left">Tipo (Posição)</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <select class="form-control" name="tipo" id="tipo">
                                                    <?php foreach($tipos_banner AS $tipo_banner):?>
                                                    <option value="<?php echo $tipo_banner["codigo_tipo_banner"];?>" <?php if($banner["codigo_tipo_banner"] == $tipo_banner["codigo_tipo_banner"]){echo "selected";}?>><?php echo $tipo_banner["descricao_tipo_banner"];?> (<?php echo $tipo_banner["tamanho_tipo_banner"];?>)</option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                        <label class="col-sm-2 label-on-left">Status</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <select class="form-control" name="status" id="status">
                                                    <option value="L" <?php if($banner["status"] == 'L'){echo "selected";}?>>Liberado</option>
                                                    <option value="B" <?php if($banner["status"] == 'B'){echo "selected";}?>>Bloqueado</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <label class="col-sm-2 label-on-left">Ordem (Posição)</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <select class="form-control" name="ordem_banner" id="ordem_banner">
                                                    <option value="1" <?php if($banner["ordem_banner"] == '1'){echo "selected";}?>>Posição 1</option>
                                                    <option value="2" <?php if($banner["ordem_banner"] == '2'){echo "selected";}?>>Posição 2</option>
                                                    <option value="3" <?php if($banner["ordem_banner"] == '3'){echo "selected";}?>>Posição 3</option>
                                                    <option value="4" <?php if($banner["ordem_banner"] == '4'){echo "selected";}?>>Posição 4</option>
                                                    <option value="5" <?php if($banner["ordem_banner"] == '5'){echo "selected";}?>>Posição 5</option>
                                                    <option value="6" <?php if($banner["ordem_banner"] == '6'){echo "selected";}?>>Posição 6</option>
                                                </select>
                                            </div>
                                        </div>

                                        <label class="col-sm-2 label-on-left">Link (URL)</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="link_banner" class="form-control" value="<?php echo $banner["link_banner"];?>" required="required">
                                                <span class="help-block">Inserir URL completa</span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <label class="col-sm-2 label-on-left">Descrição</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <textarea name="descricao_banner" id="descricao_banner" class="form-control descricao-banner" maxlength="250" rows="5"><?php echo $banner["descricao_banner"];?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <legend class="col-sm-2 label-on-left">Regular Image</legend>
                                        <div class="col-sm-4">
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                                <?php if($banner["arquivo"]):?>
                                                <img src="../../conteudos/banner/<?php echo $banner["arquivo"];?>" alt="...">
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