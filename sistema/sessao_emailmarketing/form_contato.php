
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Nome</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="nome_emkt_contato" class="form-control" value="<?php echo $contato["nome_emkt_contato"];?>" required="required">
                                                <span class="help-block">Nome do contato (Não usar aspas)</span>
                                            </div>
                                        </div>

                                         <label class="col-sm-2 label-on-left">E-mail</label>
                                            <div class="col-sm-4">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="email" name="email_emkt_contato" class="form-control" value="<?php echo $contato["email_emkt_contato"];?>" required="required">
                                                    <span class="help-block">E-mail do contato (Não usar aspas)</span>
                                                </div>
                                            </div>

                                    </div>

                                    <div class="row">

                                        <label class="col-sm-2 label-on-left">Grupo</label>
                                        <div class="col-sm-4checkbox-radios">
                                            <?php foreach($grupos AS $grupo_select):?>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="grupo[]" id="grupo[]" value="<?php echo $grupo_select["codigo_emkt_grupo"];?>" <?php if($grupos_contato){if(in_array($grupo_select["codigo_emkt_grupo"], $grupos_contato)) { echo "checked";}}?>> <?php echo $grupo_select["titulo_emkt_grupo"];?>
                                                </label>
                                            </div>
                                            <?php endforeach; ?>
                                            
                                        </div>

                                        <label class="col-sm-2 label-on-left">Status</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <select class="form-control" name="status" id="">
                                                    <option value="L" <?php if($categoria["status"] == 'L'){echo "selected";}?>>Liberado</option>
                                                    <option value="B" <?php if($categoria["status"] == 'B'){echo "selected";}?>>Bloqueado</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>