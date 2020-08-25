<ul class="nav main-menu">
    <li>
        <a href="index.php" class="active">
            <i class="fa fa-list"></i>
            <span class="hidden-xs">Principal</span>
        </a>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle">
            <i class="fa fa-university"></i>
            <span class="hidden-xs">Meus Debates</span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="menu.php?idpagina=11">Como Mediador</a></li>
            <li><a href="menu.php?idpagina=12">Como Participante</a></li>
            <li><a href="menu.php">Todos os Debates</a></li>                                
            <li><a href="menu.php?idpagina=4"> + Criar Debate </a> </li>  
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle">
            <i class="fa fa-pencil-square-o"></i>
            <span class="hidden-xs">Meu Dados</span>
        </a>
        <ul class="dropdown-menu">
           <?php if($_SESSION["logon"]){ ?> <li><a href="menu.php?idpagina=5">Alterar Email</a></li>  <?php } ?>
           <?php if($_SESSION["logon"]){ ?> <li><a href="menu.php?idpagina=6">Alterar Senha</a></li> <?php } ?>
            <li><a href="registro.php?idRegistro=2">Recupere sua senha</a></li>
        </ul>
    </li>
    <li>
        <a href="index.php?idpagina=15">
            <i class="fa fa-calendar"></i>
            <span class="hidden-xs">Parceiros</span>
        </a>
    </li>
    <li>
        <a  href="index.php?idAcao=1022"> 
            <i class="fa fa-sign-out"></i>
            <span class="hidden-xs">Sair</span>
        </a>
    </li>    
    <li>
        <br><br><br><br>

        <!--<img src="img/ufrgs.png" class="logoimg" alt="UFRGS" />-->

    </li>
</ul>
