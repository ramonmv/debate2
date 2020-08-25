<div class="container-fluid expanded-panel">
    <div class="row">
        <div id="logo" class="col-xs-12 col-sm-2">
            <a href="index.php">Debate de teses</a>
        </div>
        <div id="top-panel" class="col-xs-12 col-sm-10">
            <div class="row">
                <div class="col-xs-8 col-sm-4">
                    <a href="#" class="show-sidebar">
                        <i class="fa fa-bars"></i>
                    </a>
                    <div id="search">
                        <!-- <input type="text" placeholder="search"/> -->
                        <!-- <i class="fa fa-search"></i> -->
                      <a href="https://www.researchgate.net/publication/266867149_Debate_de_Teses_-_Uma_Arquitetura_Pedagogica" target="_blank" style="font-size: x-small;"> Sistema baseado na Arquitetura Pedagógica Debate de Teses</a>
                    </div>
                </div>
<?php                
                if($_SESSION["logon"]){
                       $dd->recuperarUsuarios($_SESSION["login"],$_SESSION["senha"]);
 
?>
                
                <div class="col-xs-4 col-sm-8 top-panel-right">
                    <ul class="nav navbar-nav pull-right panel-menu">
<!--                        <li class="hidden-xs">
                            <a href="index.html" class="modal-link">
                                <i class="fa fa-bell"></i>
                                <span class="badge">0</span>
                            </a>
                        </li>
                        <li class="hidden-xs">
                            <a class="ajax-link" href="ajax/calendar.html">
                                <i class="fa fa-calendar"></i>
                                <span class="badge">7</span>
                            </a>
                        </li>
                        <li class="hidden-xs">
                            <a href="ajax/page_messages.html" class="ajax-link">
                                <i class="fa fa-envelope"></i>
                                <span class="badge">2</span>
                            </a>
                        </li>-->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle account" data-toggle="dropdown">
                                <div class="avatar">
                                    <img src="img/userTopo.png" class="img-rounded" alt="avatar" />
                                </div>
                                <i class="fa fa-angle-down pull-right"></i>
                                <div class="user-mini pull-right">
                                    <span class="welcome">Bem Vindo,</span>
                                    <span> <?php echo $dd->usuarios[0]["primeironome"];  ?></span>
                                </div>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-user"></i>
                                        <span>Meus Dados</span>
                                    </a>
                                </li>
<!--                                <li>
                                    <a href="ajax/page_messages.html" class="ajax-link">
                                        <i class="fa fa-envelope"></i>
                                        <span>Messages</span>
                                    </a>
                                </li>-->
<!--                                <li>
                                    <a href="ajax/gallery_simple.html" class="ajax-link">
                                        <i class="fa fa-picture-o"></i>
                                        <span>Albums</span>
                                    </a>
                                </li>-->
                                <li>
                                    <a href="menu.php" class="ajax-link">
                                        <i class="fa fa-tasks"></i>
                                        <span>Debates</span>
                                    </a>
                                </li>
<!--                                <li>
                                    <a href="#">
                                        <i class="fa fa-cog"></i>
                                        <span>Settings</span>
                                    </a>
                                </li>-->
                                <li>
                                    <a href="index.php?idAcao=1022">
                                        <i class="fa fa-power-off"></i>
                                        <span>Sair</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
<?php
                }
     
?>
            </div>
        </div>
    </div>
</div>