<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();

$codigo_produto = protege(decodifica($_GET["codigo_produto"]));

if(decodifica($_POST["acao"]) == "adicionar-fotos"){
    
    $diretorio = "../../conteudos/produto/".$codigo_produto."/";        
    // Multiple file upload
    foreach($_FILES['fotos_produto']['name'] as $index=>$name){
        $filename = $name;
        if(!file_exists($diretorio.$filename)){
            move_uploaded_file($_FILES["fotos_produto"]["tmp_name"][$index],$diretorio . $filename);
            // Insere a foto do produto
            $subcategoria = $pdo->prepare("INSERT INTO foto_produto (codigo_produto, arquivo_foto, destaque_foto) VALUES (:codigo_produto, :arquivo_foto, :destaque_foto)");
            $subcategoria->execute(array(
            ':codigo_produto' => $codigo_produto,
            ':arquivo_foto' => $filename,
            ':destaque_foto' => 'N'
            ));

        }
    } 
    

    if($error_log){
        redireciona("/sistema/sessao_produto/fotos_produto.php?codigo_produto=".codifica($codigo_produto)."&me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na inclusão das fotos do produto!")); 
    }else{
        redireciona("/sistema/sessao_produto/fotos_produto.php?codigo_produto=".codifica($codigo_produto)."&me=".codifica(0,false)."&mm=".codifica("Fotos do produto foi adicionadas com sucesso!")); 
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <?php include_once("../sistema_mod_head.php");?>
</head>

<body>
    <div class="wrapper">
        <?php include_once("../sistema_mod_lateral.php");?>
        <div class="main-panel">
            <?php include_once("../sistema_mod_topo.php");?>
            <div class="content">
            
                <div class="container-fluid">
                    <div class="row">
                    
                        <div class="col-md-12">

                            <a href="sessao_produto/consultar.php">
                            <button class="btn btn-info">
                                        <span class="btn-label">
                                        <i class="material-icons">reply</i>
                                        </span>
                                        VOLTAR
                                    <div class="ripple-container"></div>
                            </button>
                            </a>

                            
                            <div class="card">
                                <form method="post" action="sessao_produto/adicionar_fotos.php?codigo_produto=<?php echo codifica($codigo_produto);?>" class="form-horizontal" multipart="" enctype="multipart/form-data">
                                    <div class="card-header card-header-text" data-background-color="rose">
                                        <h4 class="card-title">FOTOS DO PRODUTO</h4>
                                    </div>
                                    <div class="card-content">

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
                                    </div>
                                    <input type="hidden" name="acao" id="acao" value="<?php echo codifica("adicionar-fotos"); ?>">
                                    <button type="submit" class="btn btn-fill btn-rose salvar">Salvar Fotos</button>
                                    
                                </form>
                        </div>

                        </div>

                    </div>
                </div>
            </div>
            <footer class="footer">
                <?php include_once("../sistema_mod_footer.php");?>
            </footer>
        </div>
    </div>
    <?php include_once("../sistema_include_configuracoes.php"); ?>
</body>
<?php include_once("../sistema_include_js.php"); ?>
</html>