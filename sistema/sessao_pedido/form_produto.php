                                    <?php
                                    //consulta categorias
                                    $sql_consulta_categorias = "SELECT codigo_categoria, nome_categoria FROM categoria WHERE status = 'L'";
                                    $result = $pdo->query( $sql_consulta_categorias );
                                    $categorias = $result->fetchAll( PDO::FETCH_ASSOC );

                                    //consulta subcategorias
                                    $sql_consulta_subcategorias = "SELECT codigo_subcategoria, nome_subcategoria FROM subcategoria WHERE status = 'L'";
                                    $result = $pdo->query( $sql_consulta_subcategorias );
                                    $subcategorias = $result->fetchAll( PDO::FETCH_ASSOC );
                                    ?>
                                    <div class="row">
                                            <label class="col-sm-2 label-on-left">Referência</label>
                                            <div class="col-sm-1">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="referencia_produto" class="form-control" value="<?php echo $produto["referencia_produto"];?>" required="required">
                                                    <span class="help-block">Ex: C546</span>
                                                </div>
                                            </div>

                                            <label class="col-sm-1 label-on-left">Nome do Produto</label>
                                            <div class="col-sm-8">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="nome_produto" class="form-control" value="<?php echo $produto["nome_produto"];?>" required="required">
                                                    <span class="help-block">Nome do produto (Não usar aspas)</span>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <label class="col-sm-2 label-on-left">Valor</label>
                                            <div class="col-sm-1">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="valor_produto" class="form-control" value="<?php echo $produto["valor_produto"];?>" placeholder="R$">
                                                </div>
                                            </div>

                                            <label class="col-sm-1 label-on-left">Estoque</label>
                                            <div class="col-sm-1">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="number" name="estoque_produto" class="form-control" value="<?php echo $produto["estoque_produto"];?>" placeholder="">
                                                </div>
                                            </div>

                                            <label class="col-sm-1 label-on-left">Destaque</label>
                                            <div class="col-sm-1">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select class="form-control" name="destaque_produto" id="">
                                                        <option value="S" <?php if($produto["destaque_produto"] == 'S'){echo "selected";}?>>Sim</option>
                                                        <option value="N" <?php if($produto["destaque_produto"] == 'N'){echo "selected";}?>>Não</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <label class="col-sm-2 label-on-left">Descrição resumida</label>
                                            <div class="col-sm-10">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" class="form-control" name="resumo_produto" maxLength="100" required="required" value="<?php echo $produto["resumo_produto"];?>">
                                                    <span class="help-block">Digite uma descrição resumida do produto</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <label class="col-sm-2 label-on-left">Descrição completa</label>
                                            <div class="col-sm-10">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <textarea class="form-control" name="descricao_produto" id="" cols="150" placeholder="Digite aqui a descrição completa do produto" rows="5"><?php echo $produto["descricao_produto"];?></textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <label class="col-sm-2 label-on-left">Categorias (Linhas)</label>
                                            <div class="col-sm-10 checkbox-radios">
                                                <?php foreach($categorias as $categoria): ?>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="categoria_produto[]" id="categoria_produto[]" value="<?php echo $categoria["codigo_categoria"];?>" <?php if($form == "editar"){ if (in_array($categoria["codigo_categoria"], $produto_categoria)) { echo "checked";}}?>> <?php echo $categoria["nome_categoria"];?>
                                                    </label>
                                                </div>
                                                <?php endforeach; ?>
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 label-on-left">Subcategorias</label>
                                            <div class="col-sm-10">
                                                <?php foreach($subcategorias as $subcategoria): ?>
                                                <div class="checkbox checkbox-inline">
                                                    <label>
                                                        <input type="checkbox" name="subcategoria_produto[]" id="subcategoria_produto[]" value="<?php echo $subcategoria["codigo_subcategoria"];?>" <?php if($form == "editar"){ if (in_array($subcategoria["codigo_subcategoria"], $produto_subcategoria)) { echo "checked";}}?>> <?php echo $subcategoria["nome_subcategoria"];?>
                                                    </label>
                                                </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                        <?php if($form == "adicionar"): ?>
                                        <div class="row">
                                            <label class="col-sm-2 label-on-left">Imagens</label>
                                            <br/>
                                            <div class="col-sm-10">
                                                

                                                <div class="form-group">
                                                    <input id="file-4" name="fotos_produto[]" type="file" class="file" multiple>
                                                </div>
                                            </div>

                                            

                                            <script>
   
                                                $("#file-4").fileinput({
                                                    uploadExtraData: {kvId: '10'}
                                                });
                                               
                                                
                                            
                                            </script>

                                        </div>
                                        <?php endif; ?>

                                        </div>