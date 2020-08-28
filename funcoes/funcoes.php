<?php
/*
 * * * funções para interface
 *  
 */

//var_dump( func_get_arg());
function abilitaCronograma($iddebate, $dd, $link) {

    // die($dd->paginaMenu);

    if ($dd->recuperarStatusCronogramaGrupo($iddebate)) {
        if ($dd->perfilMediador) {
            echo $dd->imprime("Habilitar", null, array("idgrupo" => $_GET['idgrupo'], "idpagina" => 1, "idAcao" => 1000, "iddebate" => $iddebate), $dd->paginaMenu, 1);
        }
    } else {
        echo "----";

        if ($dd->perfilMediador) {
            echo "&nbsp;" . $dd->imprime("Criar/Editar", "cronogramaindividual", $link, $dd->paginaP4a, 1);
            echo $dd->imprime(" [desabilitar]", null, array("idgrupo" => $_GET['idgrupo'], "idpagina" => 1, "idAcao" => 1001, "iddebate" => $iddebate), $dd->paginaMenu, 1);
        }
    }
}

/*
 * Cria o link para alteração do atributo PUBLICO do grupo selecionado.
 * Utilizado na tabela Meus Debates na página menu
 */

function abilitaPublico($idpublico, $idgrupo, $dd) {

    if ($idpublico == 1) {
        echo $dd->imprime("Publico", null, array("idgrupo" => $idgrupo, "idpagina" => 0, "idAcao" => 1003), $dd->paginaMenu, 1);
    }
    if ($idpublico == 2) {
        echo $dd->imprime("Parcial", null, array("idgrupo" => $idgrupo, "idpagina" => 0, "idAcao" => 1004), $dd->paginaMenu, 1);
    }
    if ($idpublico == 3) {
        echo $dd->imprime("Privado", null, array("idgrupo" => $idgrupo, "idpagina" => 0, "idAcao" => 1005), $dd->paginaMenu, 1);
    }
}

/*
 * @param int
 * Cria o link para alteração do atributo blind do grupo selecionado.
 * Utilizado na tabela Meus Debates na página menu
 */

function abilitaBlind($blind, $idgrupo, $dd) {
    if ($blind == 1) {
        echo $dd->imprime("Sim", null, array("idgrupo" => $idgrupo, "idpagina" => 0, "idAcao" => 1006, "senha" => $_SESSION['senha'], "login" => $_SESSION['login']), $dd->paginaMenu, 1);
    }
    if ($blind == 2) {
        echo $dd->imprime("Não", null, array("idgrupo" => $idgrupo, "idpagina" => 0, "idAcao" => 1007, "senha" => $_SESSION['senha'], "login" => $_SESSION['login']), $dd->paginaMenu, 1);
    }
}

/**
 * Apresenta interface para criar cronograma individual e realizar update n a opcao de escolher entre cronograma grupo ou individual
 */
function abilitaDelegarRevisor($iddebate, $dd, $link) {

    if ($dd->perfilMediador) {
        echo $dd->imprime(" Delegar Revisor", "revisor", array("idgrupo" => $_GET['idgrupo'], "iddebate" => $iddebate, "ismediador" => 1), $dd->paginaP4a, 1);
    }
}

/**
 * Apresenta interface para criar cronograma individual e realizar update n a opcao de escolher entre cronograma grupo ou individual
 * @return String link
 */
function abilitaDelegarTodosRevisores($iddebate, $dd, $link) {

    if ($dd->perfilMediador) {
        // echo $dd->imprime(" (Delegar Todos)", "revisor", array("idgrupo" => $_GET['idgrupo'], "iddebate" => $iddebate,"ismediador" => 1), $dd->paginaP4a, 1);
        return $dd->imprime(" (Delegar Todos)", null, $link, $dd->paginaMenu, 1);
    }

    return "";
}

/*
 * FX TABELA DEBATE INDIV
 */

function apresentaTabelaMeusDebatesIndividuais($dd, $login, $senha) {
    
    include 'views/tabelaMeusDebatesIndividuais.php';
}

/*
 * FX TABELA DEBATE GRUPO
 */

function apresentaTabelaMeusDebatesGrupos($dd, $login, $senha) {

    include 'views/tabelaMeusDebatesGrupos.php';
}

function apresentaExclusaoDebateGrupo($dd, $login, $senha) {

    include 'views/apresentaExclusaoDebateGrupo.php';
}

function apresentaMeusDados($dd, $login, $senha) {

    include 'views/formMeusDados.php';
}

function apresentaExclusaoConfirmacao($dd, $login, $senha, $debateExclusaoConfirmacao) {

    include 'views/apresentaExclusaoConfirmacao.php';
}

/*
 * FX TABELA DEBATE GRUPO como mediador
 */

function apresentaTabelaMeusDebatesGruposComoParticipante($dd, $login, $senha) {
    //$dd->gruposDebatesParticipantes; Utilizado para listar os grupos 
    include 'views/tabelaMeusDebatesGruposComoParticipante.php';
}

/*
 * FX TABELA DEBATE COMPLETO como visitante
 */

function apresentaTabelaDebateCompleto($dd, $login, $senha) {
    //$dd->gruposDebatesParticipantes; Utilizado para listar os grupos 
    include 'views/debateCompleto.php';
}

function apresentaParceiros(){
    include 'views/parceiros.php';
}

/*
 * FX TABELA DEBATE GRUPO como participante
 */

function apresentaTabelaPrincipal($dd, $login, $senha) {

    include_once 'views/tabelaDebatePrincipal.php';
}

function apresentaTabelaCronogramaGrupo($dd) {

    include_once 'views/tabelaCronogramaGrupo.php';
}

function apresentaPaginaCadastroTese($dd) {

    include_once 'views/formCadastroTese.php';
}

function apresentaFormCadastroCronograma($dd) {

    include_once 'views/formCadastroCronograma.php';
}

/**
 * Apresenta interface para criar cronograma individual e realizar update n a opcao de escolher entre cronograma grupo ou individual
 * 
 * todo- Deve separar o código de apresentacao do salvar debate-grupo
 */
function apresentaPaginaConvite($dd) {
    $idpagina = 2; // com isso esta funcao será chamada , pois a pagina 2 corresponde ao form do convite
    $email = trim($_POST['mail']);
    $dadosInterface['nomeCompleto'] = trim($_POST['nome']) . " " . trim($_POST['sobrenome']); // caso o usuário já seja cadastrado o nomecompleto será atualizado para o nome já cadastrado
    $dadosInterface['email'] = trim($_POST['mail']);
    $dadosInterface['idgrupo'] = trim($_POST['idgrupo']);
    $dadosInterface['nomeMediador'] = trim($dd->usuarios[0]["primeironome"]) . " " . trim($dd->usuarios[0]["sobrenome"]);

    $idgrupo = $dd->grupo['idgrupo'];
    $dd->recuperarGrupo($idgrupo); //atualiza atributo grupo:Array
    $dadosInterface['tituloGrupo'] = $dd->grupo['titulo'];

    if ($_GET['idAcao'] == 3) {
//        echo "aaaacaaaaooo";
        if (filter_var(trim($_POST['mail']), FILTER_VALIDATE_EMAIL)) {

            if (isset($_POST['nome'])) { //post foi enviado
//                echo "bbbbbbbb";
                if ((is_null($_POST['nome'])) or ( trim($_POST['nome']) == '')) {
                    //$erroCampoVazio = "Erro: Todos os campos devem ser preenchidos!!";
                    $_SESSION["error"] = "Erro: Todos os campos devem ser preenchidos!!";

//                    echo "ccccccc";
                } elseif ((is_null($_POST['mail'])) or ( trim($_POST['mail']) == '')) {
                    //$erroCampoVazio = "Erro: Todos os campos devem ser preenchidos!!";
                    $_SESSION["error"] = "Erro: Todos os campos devem ser preenchidos!!";
//                    echo "sdddddddd";
                } elseif ((is_null($_POST['sobrenome'])) or ( trim($_POST['sobrenome']) == '')) {
                    //$erroCampoVazio = "Erro: Todos os campos devem ser preenchidos!!";
                    $_SESSION["error"] = "Erro: Todos os campos devem ser preenchidos!!";
//                    echo "eeeeeeeeeeeee";
                } else { // caso os dados de entrada estiverem preenchidos
//                    echo "ffffffffff";
                    //condicao para email ja registrado
                    if ($dd->verificarEmailExistente(trim($_POST['mail']))) {   //erro=true se e-mail for existente / ou seja usuario ja cadastrado
                        $usuario = $dd->recuperarUsuario($dadosInterface['email']);                          // recupera usuario por email
                        $dadosInterface['nomeCompleto'] = $usuario['nomeCompleto'];
                        $dadosInterface['ok_cadastroUsuario'] = "E-mail ({$dadosInterface['email']}) já cadastrado no sistema. E-mail pertecente ao Usuário: {$dadosInterface['nomeCompleto']}"; // "ja cadastrado"
                        $_SESSION["error"] = "fase1";
                        if ($dd->recuperarDebateIndividualGrupo(trim($_POST['mail']), $idgrupo) == false) {  // se for false é pq não existe debate desse usuario neste grupo , assim prosseguirá para criar
                            $iddebateCadastrado = $dd->cadastrarDebate($idgrupo, $usuario['idusuario'], 1); // cadastra debate indiv do user
                            $_SESSION["error"] = "fase2";
                            if ($iddebateCadastrado != false) {
                                $dadosInterface['ok_cadastroDebate'] = "Página {$dadosInterface['nomeCompleto']} foi criado com sucesso no Grupo: {$dadosInterface['tituloGrupo']}"; // efetuou o cadastro do debate
                                $_SESSION["error"] = "fase3";
                                if ($dd->cadastrarArgumentador($usuario['idusuario'], $iddebateCadastrado)) {
                                    $dadosInterface['ok_cadastroArgumentador'] = "Usuário registrado como argumentador com sucesso!"; // efetuou o cadastro do novo usuario
                                    $_SESSION["error"] = "fase4";

                                    if ($dd->cadastrarMediador($dd->idusuario, $iddebateCadastrado)) {
                                        $dadosInterface['ok_cadastroMediador'] = "Mediador {$dadosInterface['nomeMediador']} vinculado à Página {$dadosInterface['nomeCompleto']} com sucesso!"; // efetuou o cadastro do novo usuario
                                        $dadosInterface['permissaoEnviarConvite'] = true; // não é novo usuario! Todos os cadastros (debateindividual, arguumentador e mediador) inseridos com sucesso
                                        $_SESSION["error"] = "fase5";
                                    } else {
                                        $dadosInterface['ok_cadastroMediador'] = "Erro: Mediador {$dadosInterface['nomeMediador']} vinculado à Página {$dadosInterface['nomeCompleto']} com sucesso!";
                                        // efetuou o cadastro do debate
                                        $_SESSION["error"] = "faseA";
                                    }
                                } else {
                                    $dadosInterface['ok_cadastroArgumentador'] = "Erro: Usuário registrado como argumentador com sucesso!"; // efetuou o cadastro do debate
                                    $_SESSION["error"] = "faseB";
                                }
                            } else {
                                $dadosInterface['ok_cadastroDebate'] = "Erro: Página {$dadosInterface['nomeCompleto']} foi criado com sucesso!"; // efetuou o cadastro do novo usuario
                                $_SESSION["error"] = "faseC";
                            }
                        } else {
                            $dadosInterface['usuarioPertenceGrupo'] = "Usuário Já pertence ao Grupo: {$dadosInterface['tituloGrupo']}";
                            $_SESSION["error"] = "faseD";

                            //die("Não possível realizar a operação: erro: Di01:{$usuario['idusuario']} - informe ao suporte pelo e-mail: ramonwaia@gmail.com  "); // não consegue efetuar o cadastro do debate
                        }
                    }
                    //-------------------------------------------------------------------------------------------------------------------------
                    else { //caso seja novo usuario/login/email
                        if ((is_null($_POST['mail'])) or ( trim($_POST['mail']) == '')) {
                            //$erroCampoVazio = "Erro: e-mail não cadastrado no sistema, caso queira convidá-lo deve-se preencher todos os campos!!";
                            $_SESSION["error"] = "Erro: e-mail não cadastrado no sistema, caso queira convidá-lo deve-se preencher todos os campos!!";
                        } else {
                            //echo "zero..";
//------------------- EM CASO DE SER NOVO USUARIO - NOVO CADASTRO
                            //$emailValido = true;
                            $dadosInterface['permissaoEnviarConvite'] = false; // não enviará o email notificando o convite até que o processo de cadastro aconteça com sucesso

                            if ($dd->cadastrarUsuario(trim($_POST['nome']), trim($_POST['sobrenome']), trim($_POST['mail']), null, null)) {  //cadastra usuario
                                $dadosInterface['ok_cadastroUsuario'] = "Usuário: {$dadosInterface['nomeCompleto']} foi registrado com e-mail: {$dadosInterface['email']}"; // efetuou o cadastro do novo usuario
//                                 echo "um ";
                                $usuario = $dd->recuperarUsuario($_POST['mail']);
//                                echo "ummmmm ";
                                if ($dd->recuperarDebateIndividualGrupo($dadosInterface['email'], $dadosInterface['idgrupo']) == false) {  // se for false é pq não existe debate desse usuario neste grupo , assim prosseguirá para criar
                                    $iddebateCadastrado = $dd->cadastrarDebate($idgrupo, $usuario['idusuario']);
//                                    echo "dois ";
                                    if ($iddebateCadastrado != false) {
                                        $dadosInterface['ok_cadastroDebate'] = "Página {$dadosInterface['nomeCompleto']} foi criado com sucesso!"; // efetuou o cadastro do debate
//                                        echo "tres " ;    
                                        if ($dd->cadastrarArgumentador($usuario['idusuario'], $iddebateCadastrado)) {
                                            $dadosInterface['ok_cadastroArgumentador'] = "Usuário registrado como argumentador com sucesso!"; // efetuou o cadastro do novo usuario
//                                            echo "quatro ";
                                            if ($dd->cadastrarMediador($dd->idusuario, $iddebateCadastrado)) {
                                                $dadosInterface['ok_cadastroMediador'] = "Mediador {$dadosInterface['nomeMediador']} vinculado à Página {$dadosInterface['nomeCompleto']} com sucesso!"; // efetuou o cadastro do novo usuario
//                                                echo "cinco ";
                                                $dadosInterface['permissaoEnviarConvite'] = true; // é novo usuario e todos os cadastros (debateindividual, arguumentador e mediador) inseridos com sucesso
                                            } else {
                                                $dadosInterface['ok_cadastroMediador'] = "Erro: Mediador {$dadosInterface['nomeMediador']} vinculado à Página {$dadosInterface['nomeCompleto']} com sucesso!";
                                                // efetuou o cadastro do debate
                                                $_SESSION["error"] = "Erro: Mediador {$dadosInterface['nomeMediador']} vinculado à Página {$dadosInterface['nomeCompleto']} com sucesso!";
//                                                echo "seis ";
                                            }
                                        } else {
                                            $dadosInterface['ok_cadastroArgumentador'] = "Erro: Usuário registrado como argumentador com sucesso!"; // efetuou o cadastro do debate

                                            $_SESSION["error"] = "Erro: Usuário registrado como argumentador com sucesso!"; // efetuou o cadastro do debate
//                                             echo "sete ";
                                        }
                                    } else {
                                        $_SESSION["error"] = "Erro: Página {$dadosInterface['nomeCompleto']} foi criado com sucesso!"; // efetuou o cadastro do novo usuario
                                        $dadosInterface['ok_cadastroDebate'] = "Erro: Página {$dadosInterface['nomeCompleto']} foi criado com sucesso!"; // efetuou o cadastro do novo usuario
//                                        echo "oito ";
                                    }
                                } else {
                                    // não há como acontecer isso! ser novo usuario e ter debate individual registrado neste determinado grupo
//                                    echo " nove ";
                                    $_SESSION["error"] = "Não possível realizar a operação: erro: Di02:{$usuario['idusuario']} - informe ao suporte pelo e-mail: ramonwaia@gmail.com "; // efetuou o cadastro do debate
                                    die("Não possível realizar a operação: erro: Di02:{$usuario['idusuario']} - informe ao suporte pelo e-mail: ramonwaia@gmail.com  "); // não consegue efetuar o cadastro do debate
                                }
                            } else {
                                $dadosInterface['ok_cadastroUsuario'] = "Erro: Usuário {$dadosInterface['nomeCompleto']} foi registrado com e-mail: {$dadosInterface['email']}"; // efetuou o cadastro do novo usuario
                                $_SESSION["error"] = "Não possível realizar a operação: erro: Di02:{$usuario['idusuario']} - informe ao suporte pelo e-mail: ramonwaia@gmail.com ";
                                die("Não possível realizar a operação: (Erro: Ce01) - Informe ao suporte pelo e-mail: ramonwaia@gmail.com "); //e-mail não existe e não foi possivel cadastrarUsuario                                
                            }
                        }
                    }

                    if ($dadosInterface['permissaoEnviarConvite']) {
                        $textoCorpoEmail = $dadosInterface['nomeCompleto'] . ", você foi registrado no debate de teses pelo Grupo de Debate: " . $dadosInterface['tituloGrupo'] . "<br> <br>Utilize seu login (e-mail) e sua senha para acesso ao sistema. Se ainda não alterou sua senha, utilize sua senha provisória: 12345. <br><br>Para acessar o debate clique no link abaixo: <br>
                        http://lied.inf.ufes.br/debate2/ <br> <br> Qualquer dúvida entre em contato com o suporte do debate, através dos e-mails: credine@gmail.com e/ou ramonwaia@gmail.com <br><br>Atenciosamente,<br>Suporte Debate Teses";

                        $ee = new EnvioEmail($dadosInterface['email'], "Participação Debate de Teses - Confirmação", $textoCorpoEmail);
                        if ($ee->enviar()) {
                            $dadosInterface['ok_envio_email'] = "Foi enviado um e-mail para este usuário comunicando a sua participação neste Grupo de Debate";
                            $_SESSION["msg"] = "Convite realizado com Sucesso!";
                            $_SESSION["error"] = null;
                        } else {
                            $dadosInterface['ok_envio_email'] = "Erro no servidor: Não foi possivel enviar um e-mail para o usuário informando a participação no debate.";
                            $_SESSION["error"] = null;
                            $_SESSION["msg"] = "Convite realizado com Sucesso!";
                        }
                    } else {
                        $dadosInterface['ok_envio_email'] = "O Convite não foi realizado! Verifique os dados e repita o procedimento.";
                        $_SESSION["error"] = "Erro: O Convite não foi realizado! Verifique os dados e repita o procedimento.";
                    }

                    //acao: envio de email

                    $interface = new ApresentacaoSistema();
                    $interface->apresentaConvite($dadosInterface);
                }
            }
        } else {
            $_SESSION["error"] = "Erro: E-mail Inválido! - Verifique seus dados e tente novamente.";
            $_SESSION["msg"] = null;
            // header('location:' . $this->paginaMenu . "idpagina=" . $_GET['idpagina']. "&idgrupo=" . $_GET['idgrupo']);
        }
    }


    apresentaFormConvite();
}

// fim pagina convite , tabela convite
//-------------------------------

/**
 * Apresenta interface para criar cronograma individual e realizar update n a opcao de escolher entre cronograma grupo ou individual
 */
function apresentaFormConvite() {

    include 'views/formConviteDebateGrupo.php';
}

/**
 * Apresenta interface para criar cronograma individual e realizar update n a opcao de escolher entre cronograma grupo ou individual
 */
function apresentaAcessoNegadoGrupo() {

    include "views/mensagemAcessoNegadoGrupo.php";
}

/**
 * Apresenta interface para criar cronograma individual e realizar update n a opcao de escolher entre cronograma grupo ou individual
 */
function apresentaPaginaCadastroDebateGrupo() {

    include "views/formCadastroDebateGrupo.php";
}

// fim pagina convite , tabela convite



/*
 * FX TABELA PAGINA LOG 
 */

function apresentaPaginaLog($dd, $idgrupo, $idusuarioLog = null) {

    $colecaoLog = $dd->recuperarLogGrupoDebate($idgrupo, $idusuarioLog);
    $contador = 1;
    ?>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-name">
                        <i class="fa fa-sort-amount-desc"></i>
                        <span>Log do Debate : <?php echo $dd->grupo['titulo']; ?> </span>
                    </div>
                    <div class="box-icons">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="expand-link">
                            <i class="fa fa-expand"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                    <div class="no-move"></div>
                </div>
                <div class="box-content no-padding">
                    <table class="table table-bordered table-striped table-hover table-heading table-datatable" id="datatable-3">
                        <thead>
                            <tr>
                                <th>N&ordm;	</th>
                                <th>Hora</th>
                                <th>Participante</th>
                            </tr>
                        </thead>

                        <tbody>
    <?php
    
    
    foreach ($colecaoLog as $log) {
        $link = array("idgrupo" => $idgrupo, "idpagina" => 3, "idusuarioLog" => $log["idusuario"]);
        ?>                                                

                                <tr>
                                    <td><?php echo $contador++ ?></td>
                                    <td><?php echo $log["hora"] ?></td>
                                    <td><?php echo $dd->imprime($log["nomeCompleto"], null, $link, $dd->paginaMenu, 1) . " " . $dd->imprime($log["log"], null, $link, $dd->paginaMenu, 0); ?></td>

                                </tr>
                            <?php } ?>	
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        // Run Datables plugin and create 3 variants of settings
        function AllTables() {
            TestTable1();
            TestTable2();
            TestTable3();
            LoadSelect2Script(MakeSelect2);
        }
        function MakeSelect2() {
            $('select').select2();
            $('.dataTables_filter').each(function () {
                $(this).find('label input[type=text]').attr('placeholder', 'Digite para Filtrar');
            });
        }
        $(document).ready(function () {
            // Load Datatables and run plugin on tables 
            LoadDataTablesScripts(AllTables);
            // Add Drag-n-Drop feature
            WinMove();
        });
    </script>



    <?php
}


function recuperarSenha($email, $dd) {

$user = $dd->recuperarUsuario($email);

    if (is_array($user)) 
    {
        $textoCorpoEmail = $user['nomeCompleto'] . ", você solicitou a recuperação de senha no Sistema do Debate de Tese". 
         "<br> <br>Utilize seu login (e-mail) e sua senha para acesso ao sistema.  <br> Sua senha: ".$user['senha']."<br><br>Para acessar o debate acesso o endereço: 
        http://lied.inf.ufes.br/debate2/ <br> <br> Qualquer dúvida entre em contato com o suporte do debate, através dos e-mails: credine@gmail.com e/ou ramonwaia@gmail.com <br><br>Atenciosamente,<br>Suporte Debate Teses";

        $ee = new EnvioEmail($email, "Debate de Teses - Recuperaçao de Senha", $textoCorpoEmail);
        if ($ee->enviar()) 
        {
            
            $_SESSION["msg"] = "E-mail enviado com Sucesso para ".$email;
            $_SESSION["error"] = null;
        } 

        else 
        {

            $_SESSION["error"] = null;
            $_SESSION["msg"] = "Erro no servidor: Não foi possivel enviar um e-mail para o usuário para a recuperação de senha.";
        }
    } 

    else 
    {
        
        $_SESSION["error"] = "Erro: Não foi possivel localizar o usuário no sistema. Verifique os dados digitados!";
        $_SESSION["msg"] = "Erro no servidor: Não foi possivel enviar um e-mail para o usuário para a recuperação de senha.";
    }




}










/*
 * FX TABELA DEBATE GRUPO como participante
 */

function apresentaMenuAdmin($dd) {

    include_once 'views/apresentaMenuAdmin.php';
}

/*
 * FX TABELA DEBATE GRUPO como participante
 */

function apresentaTabelaRelacaoDebateGrupo($dd) {

    include_once 'views/tabelaRelacaoDebateGrupo.php';
}

function apresentaNotificacao() {

      // var_dump(!empty($_SESSION["error"]) );
      // var_dump(!isset($_SESSION["error"]) );
      // var_dump(!is_null($_SESSION["error"]) );
        
                //     print_r($_SESSION);
    

     // die("bummmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm");
    // $msg = $_SESSION["error"];
    // $type = "error";
    // scriptNotificacao($msg, $type);



    if ( (!empty($_SESSION["error"])) && (isset($_SESSION["error"])) && (!is_null($_SESSION["error"])) ) 
    {
            $msg = $_SESSION["error"];
            $type = "error";
            scriptNotificacao($msg, $type);
            // $_SESSION["error"] = null;
            // $_SESSION["msg"] = null;
    }

    else {
 // die("bummmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm");
        if ( (!empty($_SESSION["msg"])) && (isset($_SESSION["msg"])) && (!is_null($_SESSION["msg"])) ) 
        {
            $msg = $_SESSION["msg"];
            $type = "success";
 
            scriptNotificacao($msg, $type);
            // $_SESSION["error"] = null;
            // $_SESSION["msg"] = null;
        }
            // $_SESSION["error"] = null;
            // $_SESSION["msg"] = null;
    }
    // $_SESSION["error"] = null;
    // $_SESSION["msg"] = null;
    
    
    
}

function scriptNotificacao($msg, $type) {
    ?>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script> 
    <script type="text/javascript" src="js/noty/packaged/jquery.noty.packaged.min.js"></script>
    <script type="text/javascript">

        var n = noty({
            text: '<?php echo $msg; ?>',
            type: '<?php echo $type; ?>',
            timeout: 7000,
            //  theme: 'defaultTheme',
            closeWith: ['click'],
            layout: 'topCenter',
            animation: {
                open: {height: 'toggle'},
                close: {height: 'toggle'}, // jQuery animate function property object
                easing: 'swing', // easing
                speed: 500, // opening & closing animation speed                   
                layout: 'topCenter'
            }
        });


    </script>

    <?php
    
}

//
//function montarTabela(){
//    
//    
//}
?>
