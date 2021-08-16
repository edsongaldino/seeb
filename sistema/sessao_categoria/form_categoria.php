
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Nome da categoria</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="nome_categoria" class="form-control" value="<?php echo $categoria["nome_categoria"];?>" required="required">
                                                <span class="help-block">Nome da categoria (Não usar aspas)</span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
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