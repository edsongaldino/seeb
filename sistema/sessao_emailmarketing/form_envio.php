
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Título do Envio</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="titulo_envio" class="form-control" value="<?php echo $envio["titulo_emkt_envio"];?>" required="required">
                                                <span class="help-block">Título (Não usar aspas)</span>
                                            </div>
                                        </div>

                                        <label class="col-sm-2 label-on-left">Data Inicial</label>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="date" name="data" class="form-control datetimepicker" value="<?php echo $envio["data_emkt_envio"];?>" />
                                            </div>
                                        </div> 

                                    </div>

                                    <div class="row">
                                        <?php
                                        //Abre a conexão
                                        $pdo = Database::conexao();
                                        // Seleciona os tipos de envios
                                        $sql_tipo_envio = "SELECT * FROM emkt_tipo_envio";
                                        $query_tipo_envio = $pdo->query( $sql_tipo_envio );
                                        $tipos_envio = $query_tipo_envio->fetchAll( PDO::FETCH_ASSOC );
                                        ?>

                                        <label class="col-sm-2 label-on-left">Tipo (Posição)</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <select class="form-control" name="tipo" id="tipo">
                                                    <?php foreach($tipos_envio AS $tipo_envio):?>
                                                    <option value="<?php echo $tipo_envio["codigo_emkt_tipo_envio"];?>" <?php if($envio["codigo_emkt_tipo_envio"] == $tipo_envio["codigo_emkt_tipo_envio"]){echo "selected";}?>><?php echo $tipo_envio["descricao_emkt_tipo_envio"];?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                        <label class="col-sm-2 label-on-left">Status</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <select class="form-control" name="status" id="status">
                                                    <option value="L" <?php if($envio["status"] == 'L'){echo "selected";}?>>Liberado</option>
                                                    <option value="B" <?php if($envio["status"] == 'B'){echo "selected";}?>>Bloqueado</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Link (URL)</label>
                                        <div class="col-sm-6">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="link_envio" class="form-control" value="<?php echo $envio["link_emkt_envio"];?>" required="required">
                                                <span class="help-block">Inserir URL completa</span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <legend class="col-sm-2 label-on-left">Imagem - E-mail Marketing</legend>
                                        <div class="col-sm-4">
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                                <?php if($envio["imagem_emkt_envio"]):?>
                                                <img src="../../conteudos/email_marketing/<?php echo $envio["imagem_emkt_envio"];?>" alt="...">
                                                <?php else:?>
                                                <img src="../../sistema/assets/img/image_placeholder.jpg" alt="...">
                                                <?php endif;?>
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                            <div>
                                                <span class="btn btn-rose btn-round btn-file">
                                                    <span class="fileinput-new">Selecione a Imagem</span>
                                                    <span class="fileinput-exists">Alterar</span>
                                                    <input type="file" name="arquivo" />
                                                </span>
                                                <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remover</a>
                                            </div>
                                        </div>
                                        </div>
                                    </div>

                                     <div class="row">
                                        <label class="col-sm-2 label-on-left">Texto do Envio</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <textarea name="texto_envio" id="texto_envio" class="texto-envio" cols="100" rows="5"><?php echo $envio["texto_emkt_envio"];?></textarea>
                                                <span class="help-block">Digite o texto que aparecerá no corpo da mensagem</span>
                                            </div>
                                        </div>
                                    </div>