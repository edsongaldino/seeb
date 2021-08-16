<?php require_once("../sistema_mod_include.php");?>
<?php
   /**
   * função que devolve em formato JSON os dados do cliente
   */
  function retorna( $referencia, $db )
  {
    $sql = "SELECT * FROM produto WHERE produto.referencia_produto = '".$referencia."' LIMIT 1";

    $query = $db->query( $sql );

    $arr = Array();
    if( $query->num_rows )
    {
      while( $dados = $query->fetch_object() )
      {
        $arr['nome_produto'] = $dados->nome_produto;
        $arr['valor_produto'] = converte_valor_real($dados->valor_produto);
      }
    }
    else{
      $arr['nome_produto'] = "Produto não cadastrado";
    }

    return json_encode( $arr );
  }

/* só se for enviado o parâmetro, que devolve os dados */
if( isset($_GET['referencia']) )
{
  $db = new mysqli('realmat.com.br', 'realmat_site', 'VF]2mphdN!_z', 'realmat_site');
  echo retorna( filter ($_GET['referencia'] ), $db );
}

function filter( $var ){
  return $var;//a implementação desta, fica a cargo do leitor
}

?>