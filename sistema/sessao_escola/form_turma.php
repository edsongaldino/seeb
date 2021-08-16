
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Nome da turma</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="nome_turma" class="form-control" value="<?php echo $turma["nome_turma"];?>" required="required">
                                                <span class="help-block">Título (Não usar aspas)</span>
                                            </div>
                                        </div>

                                        <label class="col-sm-2 label-on-left">Escola</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <select class="form-control" name="escola" id="escola">
                                                    <?php foreach($escolas AS $escola):?>
                                                    <option value="<?php echo $escola["codigo_escola"];?>" <?php if($turma["codigo_escola"] == $escola["codigo_escola"]){echo "selected";}?>><?php echo $escola["titulo_escola"];?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                        <label class="col-sm-2 label-on-left">Nível</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <select class="form-control" name="nivel_turma" id="nivel_turma">
                                                    <option value="EI" <?php if($turma["nivel_turma"] == 'EI'){echo "selected";}?>>Educação Infantil</option>
                                                    <option value="EF" <?php if($turma["nivel_turma"] == 'EF'){echo "selected";}?>>Ensino Fundamental</option>
                                                    <option value="EM" <?php if($turma["nivel_turma"] == 'EM'){echo "selected";}?>>Ensino Médio</option>
                                                </select>
                                            </div>
                                        </div>

                                        <label class="col-sm-2 label-on-left">Status</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <select class="form-control" name="status" id="status">
                                                    <option value="L" <?php if($turma["status"] == 'L'){echo "selected";}?>>Liberado</option>
                                                    <option value="B" <?php if($turma["status"] == 'B'){echo "selected";}?>>Bloqueado</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div