
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Nome do Grupo</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="titulo_emkt_grupo" class="form-control" value="<?php echo $grupo["titulo_emkt_grupo"];?>" required="required">
                                                <span class="help-block">Nome do grupo (Não usar aspas)</span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Status</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <select class="form-control" name="status_emkt_grupo" id="">
                                                    <option value="L" <?php if($grupo["status_emkt_grupo"] == 'L'){echo "selected";}?>>Liberado</option>
                                                    <option value="B" <?php if($grupo["status_emkt_grupo"] == 'B'){echo "selected";}?>>Bloqueado</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>