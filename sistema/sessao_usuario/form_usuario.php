                                    <div class="row">

                                            <label class="col-sm-2 label-on-left">Nome do usuario</label>
                                            <div class="col-sm-7">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="nome_usuario" class="form-control" value="<?php echo $usuario["nome_usuario"];?>" required="required">
                                                    <span class="help-block">Nome do usuario (Não usar aspas)</span>
                                                </div>
                                            </div>

                                            <label class="col-sm-1 label-on-left">Telefone</label>
                                            <div class="col-sm-2">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="telefone_usuario" class="form-control" value="<?php echo $usuario["telefone_usuario"];?>" required="required">
                                                    <span class="help-block">Ex: C546</span>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <label class="col-sm-2 label-on-left">E-mail</label>
                                            <div class="col-sm-5">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="email_usuario" class="form-control" value="<?php echo $usuario["email_usuario"];?>" placeholder="">
                                                </div>
                                            </div>

                                            <label class="col-sm-1 label-on-left">Senha</label>
                                            <div class="col-sm-4">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="password" name="senha_usuario" class="form-control" value="" placeholder="">
                                                </div>
                                            </div>

                                        </div>

                                        