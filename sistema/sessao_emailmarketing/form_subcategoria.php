                                    <?php
                                    //consulta categorias
                                    $sql_consulta_categorias = "SELECT codigo_categoria, nome_categoria FROM categoria WHERE status = 'L' ORDER BY nome_categoria ASC";
                                    $result = $pdo->query( $sql_consulta_categorias );
                                    $categorias = $result->fetchAll( PDO::FETCH_ASSOC );
                                    ?>
                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Nome da Subcategoria</label>
                                        <div class="col-sm-10">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="nome_subcategoria" class="form-control" value="<?php echo $subcategoria["nome_subcategoria"];?>" required="required">
                                                <span class="help-block">Nome da Subcategoria (Não usar aspas)</span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Categoria</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <select class="form-control" name="codigo_categoria" id="">
                                                    <?php foreach($categorias as $categoria): ?>
                                                        <option value="<?php echo $categoria["codigo_categoria"];?>" <?php if($subcategoria["codigo_categoria"] == $categoria["codigo_categoria"]){echo "selected";}?>><?php echo $categoria["nome_categoria"];?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <label class="col-sm-2 label-on-left">Status</label>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <select class="form-control" name="status" id="">
                                                    <option value="L" <?php if($subcategoria["status"] == 'L'){echo "selected";}?>>Liberado</option>
                                                    <option value="B" <?php if($subcategoria["status"] == 'B'){echo "selected";}?>>Bloqueado</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>