<div class="sidebar" data-active-color="rose" data-background-color="black" data-image="assets/img/sidebar-1.jpg">

            <div class="logo">
                <a href="/sistema" class="simple-text">
                    PAINEL
                </a>
            </div>
            <div class="logo logo-mini">
                <a href="/sistema" class="simple-text">
                    PK
                </a>
            </div>
            <div class="sidebar-wrapper">
                <div class="user">
                    <div class="photo">
                        <img src="assets/img/faces/avatar.jpg" />
                    </div>
                    <div class="info">
                        <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                            <?php echo $_SESSION["nome_usuario"];?>
                            <b class="caret"></b>
                        </a>
                        <div class="collapse" id="collapseExample">
                            <ul class="nav">
                                <li>
                                    <a href="sessao_usuario/editar.php?codigo_usuario=<?php echo codifica($_SESSION["codigo_usuario"]);?>">Meu perfil</a>
                                </li>
                                <li>
                                    <a href="sessao_usuario/editar.php?codigo_usuario=<?php echo codifica($_SESSION["codigo_usuario"]);?>">Editar perfil</a>
                                </li>
                                <li>
                                    <a href="logout.php">Sair</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="nav">
                <li>
                    <a href="inicio.php">
                        <i class="material-icons">dashboard</i>
                        <p>Início</p>
                    </a>
                </li>

                <li>
                <a href="sessao_usuario/consultar.php">
                <i class="material-icons">account_circle</i>
                    <p>Usuários</p>
                </a>
                    
                </li>
<!--
                <li>
                    <a data-toggle="collapse" href="#tablesExamples">
                        <i class="material-icons">view_headline</i>
                        <p>Fabricantes/Categorias
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="tablesExamples">
                        <ul class="nav">
                            <li>
                                <a href="sessao_fabricante/consultar.php">Fabricantes</a>
                            </li>
                            <li>
                                <a href="sessao_categoria/consultar.php">Categorias</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="sessao_produto/consultar.php">
                    <i class="material-icons">assignment</i>
                        <p>Produtos</p>
                    </a>
                </li>
                

                <li>
                    <a href="sessao_cliente/consultar.php">
                    <i class="material-icons">perm_identity</i>
                        <p>Clientes</p>
                    </a>
                </li>-->
                
                <li>
                    <a href="sessao_depoimento/consultar.php">
                    <i class="material-icons">stars</i>
                        <p>Depoimentos</p>
                    </a>
                </li>
                

                <li>
                    <a href="sessao_banner/consultar.php">
                    <i class="material-icons">work</i>
                        <p>Banners</p>
                    </a>
                </li>

                <li>
                    <a href="sessao_texto/consultar.php">
                    <i class="material-icons">receipt</i>
                        <p>Textos</p>
                    </a>
                </li>
                <!--
                <li>
                    <a href="sessao_escola/consultar.php">
                    <i class="material-icons">school</i>
                        <p>Listas escolares</p>
                    </a>
                </li>
                -->
                <li>
                    <a href="sessao_noticia/consultar.php">
                    <i class="material-icons">chat</i>
                        <p>Blog</p>
                    </a>
                </li>

                 <li>
                    <a href="sessao_emailmarketing/consultar.php">
                    <i class="material-icons">send</i>
                        <p>E-mail Marketing</p>
                    </a>
                </li>
                
                </ul>
            </div>
        </div>