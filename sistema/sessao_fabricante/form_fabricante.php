
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Nome do Fabricante</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="nome_fabricante" class="form-control" value="<?php echo $fabricante["nome_fabricante"];?>" required="required">
                                                <span class="help-block">Nome do fabricante (Não usar aspas)</span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Status</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <select class="form-control" name="status" id="">
                                                    <option value="L" <?php if($fabricante["status"] == 'L'){echo "selected";}?>>Liberado</option>
                                                    <option value="B" <?php if($fabricante["status"] == 'B'){echo "selected";}?>>Bloqueado</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>