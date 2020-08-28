<?php

include_once('classconexao.php');

class sistemaDebate {

    //CONFIG http://www.pead.faced.ufrgs.br/sites/cms/debateteses/dt/
    public $paginaLogin; //= 'http://localhost/dt/index.php?'; //alterado poelo config
    public $paginaMenu; //= 'http://localhost/dt/menu.php?'; //alterado poelo config
    public $paginaPrincipal; // = 'http://localhost/dt/principal.php?'; //alterado poelo config
    public $paginaP4a; //= 'http://localhost/p4a/applications/dt/index.php?'; //alterado poelo config
    public $iddebate = null;
    public $idgrupo = null;
    public $usuarios = null;  //ARRAY()
    public $grupo = null;  //ARRAY() 1 elemtento corrente
    public $grupos = null;  //ARRAY()
    public $revisoes = null;  //ARRAY()
    public $replicas = null;  //ARRAY()
    public $debates = null;    //ARRAY()
    public $teses = null;      //ARRAY()
    public $argumentos = null; //ARRAY()
    public $posicionamentos = null; //ARRAY()
    public $conexao = null;
    public $perfilArgumentador = 0;
    public $perfilMediador = 0;
    public $perfilRevisor = 0;
    public $idrevisor = "idrevisor"; // se perfilrevisor = 1 , idrevisor ser� setado com o id correspondente pelo m�todo verificaPerfil
    public $idargumentador = "idargumentador"; // se perfilrevisor = 1 , idrevisor ser� setado com o id correspondente pelo m�todo verificaPerfil
    public $idmediador = "idmediador"; // se perfilrevisor = 1 , idrevisor ser� setado com o id correspondente pelo m�todo verificaPerfil
    public $idusuario = 0; // ser� atribuido pelo m�todo verificaPerfil
    public $conograma = null; // ser� atribuido pelo m�todo verificaPerfil
    public $paginaAtual = null; // setado no inicio de cada pagina

    function __construct() {
        $conexao = new Conexao();
        $this->conexao = $conexao->conectado();
        include('config.php');
    }

    /**
     * @todo acertar as acoes de erro idAcao
     * @param boolean $redirecionamento Valor booleano para informar se deseja o redirec para o index
     * @return boolean
     * 
     */
    function verificaLogon($redirecionamento = TRUE) {
 
        if (($_SESSION['logon'] == false) || (!isset($_SESSION['logon']))) {

            
 
            if ($redirecionamento) {
                //header('location:' . $this->paginaLogin . 'idm=652&erro=Usuário/senha inválido');           
                
 
                header('location:' . $this->paginaLogin);
            }

            return FALSE;
        } 

        else 
        {
            $this->login = $_SESSION['login'];
            $this->senha = $_SESSION['senha'];
            return TRUE;
        }
    }


  //VERSAO 2
 function efetuarLogin($login, $senha, $idpagina = null) {
    
        // $qtd_debates = $this->recuperarDebatesPorLogin($login, $senha); 999
        // echo "$qtd_debates";
         
        //$qtd_debates = $this->recuperarTodosDebatesPorLogin($login, $senha);
        if($this->verificarLogin($login, $senha)){

           
            $usuario = $this->recuperarUsuario($login); 


            $_SESSION['logon'] = true;
            $_SESSION['login'] = $login;
            $_SESSION['senha'] = $senha;
            $_SESSION['idusuario'] = $usuario["idusuario"];
            $_SESSION['primeironome'] = $usuario["primeironome"];
            $this->login = $login;
            $this->senha = $senha;

            $this->cadastrarLog("efetuou login.", $usuario['idusuario']);
            if (is_null($idpagina)) {
                $_SESSION["msg"] = null;
                $_SESSION["error"] = null;
                header('location:' . $this->paginaMenu);
            } else {
                $_SESSION["msg"] = null;
                $_SESSION["error"] = null;
                header('location:' . $this->paginaMenu . "idpagina=" . $idpagina);
            }
        } 

        else 
        {
            $_SESSION['logon'] = false;
            $_SESSION["msg"] = null;
//                $_SESSION["error"] = null;
            //header('location:' . $this->paginaLogin . 'idm=600&erro=Usuario/senha inválido');
            $_SESSION["error"] = "Login não realizado. <br>Verifique seus dados e tente novamente!!!!";
            header('location:' . $this->paginaLogin . 'idm=600&erro=Usuario/senha inválido');
        }
    }



    //VERSÃO 1
    function efetuarLogin_old($login, $senha, $idpagina = null) {
	
        // $qtd_debates = $this->recuperarDebatesPorLogin($login, $senha); 999
        // echo "$qtd_debates";
         
        //$qtd_debates = $this->recuperarTodosDebatesPorLogin($login, $senha);
        $usuario = $this->recuperarUsuario($login); 

        if ($qtd_debates > 0) {   
        // if ($usuario != false) {

            $_SESSION['logon'] = true;
            $_SESSION['login'] = $login;
            $_SESSION['senha'] = $senha;
            $_SESSION['idusuario'] = $usuario["idusuario"];
            $_SESSION['primeironome'] = $usuario["primeironome"];
            $this->login = $login;
            $this->senha = $senha;

            $this->cadastrarLog("efetuou login.", $usuario['idusuario']);
            if (is_null($idpagina)) {
                $_SESSION["msg"] = null;
                $_SESSION["error"] = null;
                header('location:' . $this->paginaMenu);
            } else {
                $_SESSION["msg"] = null;
                $_SESSION["error"] = null;
                header('location:' . $this->paginaMenu . "idpagina=" . $idpagina);
            }
        } else {

            $_SESSION['logon'] = false;
            $_SESSION["msg"] = null;
//                $_SESSION["error"] = null;
            //header('location:' . $this->paginaLogin . 'idm=600&erro=Usuario/senha inválido');
            $_SESSION["error"] = "Login não realizado. <br>Verifique seus dados e tente novamente!!!!";
            header('location:' . $this->paginaLogin . 'idm=600&erro=Usuario/senha inválido');
        }
    }

    function getNomePerfil() {

        //print_r($this);
        //die(" Moreeeu!! xxxx");

        if ($this->perfilMediador == 1)
            return "Mediador ";
        if ($this->perfilRevisor == 1)
            return "Revisor ";
        if ($this->perfilArgumentador == 1)
            return "Argumentador ";
        if ($this->perfilVisitante == 1)
            return "Visitante ";
    }

    /**
     * A uncao verifica se o email dpo usuario já esta cadastrado no database|
     * @param String $email
     * @return boolean
     */
    function verificarEmailExistente($email) {

        $email = trim($email);

        $sql = "select email
		from  usuario
		where email = '$email' ";

        $resultado = mysqli_query($this->conexao, $sql);
        if (mysqli_num_rows($resultado) > 0) {
            return true;
        } 
        else{
            return false;
        }
    }

    /**
     * A uncao verifica se o email dpo usuario já esta cadastrado no database|
     * @param String $email
     * @return boolean
     */
    function verificarPerfilAutor($idgrupo, $email, $senha) {

        $sql = "select *
		FROM  usuario u, grupo g
		where u.email = '$email' and u.senha = '$senha' and
		u.idusuario = g.idusuario and 
		g.idgrupo = $idgrupo";

        $resultado = mysqli_query($this->conexao, $sql);
        if (mysqli_num_rows($resultado) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function verificarPerfil($login, $password, $iddebate) {
        //VERIFICA ARGUMEMTADOR
        $sql = "select a.idargumentador, u.idusuario
		FROM  usuario u, argumentador a, debate d
		where u.login = '$login' and u.senha = '$password' and
		a.usuario_idusuario = u.idusuario and 
		a.debate_iddebate = d.iddebate and
		d.iddebate = $iddebate";

        // die("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa");

        $resultadoArgumentador = mysqli_query($this->conexao, $sql);
     
        // if (mysqli_num_rows($resultadoArgumentador) > 0) {
        //     $this->perfilArgumentador = 1;
        //     $this->idargumentador = mysql_result($resultadoArgumentador, 0, "idargumentador");
        //     $this->idusuario = mysql_result($resultadoArgumentador, 0, "idusuario");
        // }else {
        //        $this->perfilArgumentador = 0;
        // }

        if (mysqli_num_rows($resultadoArgumentador) > 0) 
        {
            $this->perfilArgumentador = 1;

            for ($cont = 0; $dados = mysqli_fetch_array($resultadoArgumentador); $cont++) 
            {
                $this->idargumentador = $dados["idargumentador"];
                $this->idusuario = $dados["idusuario"];
                break;
            }
        }
        else {
               $this->perfilArgumentador = 0;
        }



        //VERIFICA REVISOR
        $sql = "select r.idrevisor, u.idusuario
		FROM  usuario u, revisor r, debate d
		where u.login = '$login' and u.senha = '$password' and
		r.usuario_idusuario = u.idusuario and 
		r.debate_iddebate = d.iddebate and
		d.iddebate = $iddebate";

        $resultadoRevisor = mysqli_query($this->conexao, $sql);

        // if (mysqli_num_rows($resultadoRevisor) > 0) {
        //     $this->perfilRevisor = 1;
        //     $this->idrevisor = mysqli_result($resultadoRevisor, 0, "idrevisor");
        //     $this->idusuario = mysqli_result($resultadoRevisor, 0, "idusuario");
        // } else {
        //     $this->perfilRevisor = 0;
        // }

        if (mysqli_num_rows($resultadoRevisor) > 0) 
        {
            $this->perfilRevisor = 1;

            for ($cont = 0; $dados = mysqli_fetch_array($resultadoRevisor); $cont++) 
            {
                $this->idrevisor = $dados["idrevisor"];
                $this->idusuario = $dados["idusuario"];
                break;
            }
        }
        else {
               $this->perfilRevisor = 0;
        }






        //VERIFICA MEDIADOR
        $sql = "select m.idmediador, u.idusuario
		FROM  usuario u, mediador m, debate d
		where u.login = '$login' and u.senha = '$password' and
		m.usuario_idusuario = u.idusuario and 
		m.debate_iddebate = d.iddebate and
		d.iddebate = $iddebate";

        $resultadoMediador = mysqli_query($this->conexao, $sql);

        // if (mysqli_num_rows($resultadoMediador) > 0) {
        //     $this->perfilMediador = 1;
        //     $this->idmediador = mysqli_result($resultadoMediador, 0, "idmediador");
        //     $this->idusuario = mysqli_result($resultadoMediador, 0, "idusuario");
        // } else {
        //     $this->perfilMediador = 0;
        // }


        if (mysqli_num_rows($resultadoMediador) > 0) 
        {
            $this->perfilMediador = 1;

            for ($cont = 0; $dados = mysqli_fetch_array($resultadoMediador); $cont++) 
            {
                $this->idmediador = $dados["idmediador"];
                $this->idusuario = $dados["idusuario"];
                break;
            }
        }
        else {
               $this->perfilMediador = 0;
        }





    }

    /*
     * Recupera debate
     * return array [iddebate, email, idusuario, nomecompleto, idgrupo] se existir
     * return false senão existir 
     */

    function recuperarArgumentadorPorDebate($iddebate) {

        //busca na view
        $sql = "select idusuario
		FROM  participantes
		where 
                iddebate = $iddebate  ";

        $resultado = mysqli_query($this->conexao, $sql);
        $dados = mysqli_fetch_array($resultado);
        //echo var_dump($dados);
        return $dados;
    }

    /*
     * Recupera debate
     * return array [iddebate, email, idusuario, nomecompleto, idgrupo] se existir
     * return false senão existir 
     */

    function recuperarArgumentadoresPorGrupo($idgrupo) {

        //busca na view
        $sql = "select *
		FROM  participantes
		where 
                idgrupo = $idgrupo  ";

        $resultado = mysqli_query($this->conexao, $sql);

        if (mysqli_num_rows($resultado) > 0) {

            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $argumentador['iddebate'] = $dados["iddebate"];
                $argumentador['email'] = $dados["email"];
                $argumentador['idusuario'] = $dados["idusuario"];
                $argumentador['nomecompleto'] = $dados["nomecompleto"];
                $argumentador['idgrupo'] = $dados["idgrupo"];
                $colecaoArgumentadores[] = $argumentador;
            }
            return $colecaoArgumentadores;
        } else {
            // echo mysqli_errno($this->conexao) . ": " . mysqli_error($this->conexao) . "\n";
            return false;
        }
    }





    function recuperarUsuarios($login, $senha) {
        $sql = "select idusuario,primeironome, sobrenome,senha,login,email,grupo
		FROM  usuario 
		where login = '$login' and senha = '$senha' ";

        $resultado = mysqli_query($this->conexao, $sql);
        if (mysqli_num_rows($resultado) > 0) {
            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $usuario['idusuario'] = $dados["idusuario"];
                $usuario['primeironome'] = $dados["primeironome"];
                $usuario['sobrenome'] = $dados["sobrenome"];
                $usuario['email'] = $dados["email"];
                $usuario['grupo'] = $dados["grupo"];
                $usuario['senha'] = $dados["senha"];
                $usuario['login'] = $dados["login"];
                $this->usuarios[] = $usuario;
                $this->idusuario = $dados["idusuario"];
            }
        }
    }

    function recuperarTodosUsuarios() {
        $sql = "select idusuario,primeironome, sobrenome,senha,login,email,grupo
		FROM  usuario 		";

        $resultado = mysqli_query($this->conexao, $sql);
        if (mysqli_num_rows($resultado) > 0) {
            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $usuario['idusuario'] = $dados["idusuario"];
                $usuario['primeironome'] = $dados["primeironome"];
                $usuario['sobrenome'] = $dados["sobrenome"];
                $usuario['nomecompleto'] = $dados["primeironome"] . " " . $dados["sobrenome"];
                $usuario['label'] = trim($dados["primeironome"]) . " " . trim($dados["sobrenome"]) . " - " . trim($dados["email"]);
                $usuario['email'] = $dados["email"];
                $usuario['grupo'] = $dados["grupo"];
                $usuario['senha'] = $dados["senha"];
                $usuario['login'] = $dados["login"];
                $usuarios[] = $usuario;
            }
        }
        return $usuarios;
    }

    function recuperarUsuario($login, $idusuario = 0) {
        $sql = "select idusuario,primeironome, sobrenome,senha,login,email,grupo
		FROM  usuario
		where login = '$login' or idusuario = $idusuario";

        $resultado = mysqli_query($this->conexao, $sql);



        if (mysqli_num_rows($resultado) > 0) {
            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $usuario['idusuario'] = $dados["idusuario"];
                $usuario['primeironome'] = $dados["primeironome"];
                $usuario['sobrenome'] = $dados["sobrenome"];
                $usuario['email'] = $dados["email"];
                $usuario['grupo'] = $dados["grupo"];
                $usuario['senha'] = $dados["senha"];
                $usuario['login'] = $dados["login"];
                $usuario['nomeCompleto'] = $dados["primeironome"] . " " . $dados["sobrenome"];
            }
            return $usuario;
        }

        return false;
    }


    function verificarLogin($login, $senha) {
        $sql = "select idusuario,primeironome, sobrenome,senha,login,email,grupo
        FROM  usuario
        where login = '$login' and senha = '$senha'";

        $resultado = mysqli_query($this->conexao, $sql);

        if (mysqli_num_rows($resultado) > 0) {
            
            return true;
        }
        else{
            return false;
        }

        
    }



    function recuperarDebates($idgrupo) {
        $this->debates = null;
        $sql = "select d.iddebate,d.titulo, d.ativo, g.idgrupo, g.titulo as grupo_titulo
		FROM  debate d, grupo g
		where 
			  d.grupo_idgrupo = g.idgrupo and
			  g.idgrupo = $idgrupo";

        $resultado = mysqli_query($this->conexao, $sql);
        if (mysqli_num_rows($resultado) > 0) {
            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                if ($dados['ativo'] != 0) {
                    $debate['iddebate'] = $dados["iddebate"];
                    $debate['titulo'] = $dados["titulo"];
                    $debate['ativo'] = $dados["ativo"];
                    $debate['cronogramagrupo'] = $dados["cronogramagrupo"];
                    $debate['idgrupo'] = $dados["idgrupo"];
                    $this->debates[] = $debate;
                }
            }
        }
    }

    //recupera dados de um determinado debate. Retorna um array com os indices (campos)
    function recuperarDebateIndividual($iddebate) {
        $sql = "select *
		FROM  debate 
		where iddebate = $iddebate";

        $resultado = mysqli_query($this->conexao, $sql);
        if (mysqli_num_rows($resultado) > 0) {
            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $debate['iddebate'] = $dados["iddebate"];
                $debate['titulo'] = $dados["titulo"];
                $debate['ativo'] = $dados["ativo"];
                $debate['cronogramagrupo'] = $dados["cronogramagrupo"];
                $debate['idgrupo'] = $dados["grupo_idgrupo"];
            }
            return $debate;
        }
    }

    /*
     * Recupera debate
     * return array [iddebate, email, idusuario, nomecompleto, idgrupo] se existir
     * return false senão existir 
     */

    function recuperarDebateIndividualGrupo($email, $idgrupo) {

        //busca na view
        $sql = "select *
		FROM  participantes
		where email = '$email' and
                idgrupo = $idgrupo       ";

        $resultado = mysqli_query($this->conexao, $sql);
        if (mysqli_num_rows($resultado) > 0) {
            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $debate['iddebate'] = $dados["iddebate"];
                $debate['email'] = $dados["email"];
                $debate['idusuario'] = $dados["idusuaio"];
                $debate['nomecompleto'] = $dados["nomecompleto"];
            }
            return $debate;
        } else {
            return false;
        }
    }

    /**
     * Retorna true se for cronograma do grupo 
     * @param <type> $iddebate
     * @return boolen
     */
    function recuperarStatusCronogramaGrupo($iddebate) {

        $debate = $this->recuperarDebateIndividual($iddebate);
        return $debate['cronogramagrupo'];
    }

    function recuperarGrupos() {
        $this->grupos = null;
        $sql = "select idgrupo,titulo, ativo, dataini, datafim, publico, blind
		FROM  grupo 
		where ativo = 1";

        // die()

        $resultado = mysqli_query($this->conexao, $sql);
        if (mysqli_num_rows($resultado) > 0) {
            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $grupo['idgrupo'] = $dados["idgrupo"];
                $grupo['titulo'] = $dados["titulo"];
                $grupo['ativo'] = $dados["ativo"];
                $grupo['dataini'] = $dados["dataini"];
                $grupo['datafim'] = $dados["datafim"];
                $grupo['publico'] = $dados["publico"];
                $grupo['blind'] = $dados["blind"];
                $this->grupos[] = $grupo;
            }
        }
    }

    /**
     * Caso cronograma grupo seja verdadeiro o cronograma do grupo será utilizado caso contrário sera o individual
     * parametro 3 deve ser o atributo da tabela/coluna cronogramaGrupo de debate
     * Caso o parametro 3 seja null a funcao fará a consulta
     * @param <type> $iddebate
     * @param <type> $idgrupo
     * @param <type> $cronogramaEhGrupo
     */
    function recuperarCronograma($iddebate, $idgrupo, $cronogramaEhGrupo = null) {

        if (is_null(($cronogramaEhGrupo))) {
            $cronogramaEhGrupo = $this->recuperarStatusCronogramaGrupo($iddebate);
        }

        if ($cronogramaEhGrupo) {
            $this->recuperarCronogramaPorGrupo($idgrupo);
        } else {
            $this->recuperarCronogramaPorDebate($iddebate);
        }
    }

    /**
     * registra string no log
     * login, apresentacao, argumento, revisao, replica, conclusao final, reflexao
     * @param <type> $iddebate
     */
    function cadastrarLog($log, $idusuario = 'null', $idgrupo = 'null') {

        $sql = "insert into log (hora, log,idgrupo, idusuario)
                values ( now(), '$log',$idgrupo, $idusuario)";

        $resultado = mysqli_query($this->conexao, $sql);

//        var_dump($resultado);
//        die("aaaaaaaaaaaaaaaaaaaaaaa") ;

        return $resultado;
    }

    /**
     * $_POST['nome'],($_POST['sobrenome'],($_POST['email'],($_POST['senha'],($_POST['grupo']);
     * @param <type> $iddebate
     */
    function cadastrarUsuario($nome, $sobrenome, $email, $senha = "12345", $grupo = "nenhum") {

        $email = trim($email);
        $nome = trim($nome);
        $sobrenome = trim($sobrenome);
        $grupo = trim($grupo);
        $senha = "12345"; 

        $sql = "insert into usuario (primeironome, sobrenome, email,login,senha,grupo)
                values ('$nome', '$sobrenome', '$email','$email','12345','$grupo')";

        $resultado = mysqli_query($this->conexao, $sql);

        if (mysqli_affected_rows($this->conexao) > 0) 
        {
            return true;
        } 
        else 
        {
            return false;
        }

    }

    /**
     * $_POST['nome'],($_POST['sobrenome'],($_POST['email'],($_POST['senha'],($_POST['grupo']);
     * @param <type> $iddebate
     */
    function cadastrarTese($tese, $idebate, $idgrupo, $alias = "nenhum") {

        $tese = trim($tese);
        $alias = trim($alias);

        $sql = "insert into tese (tese, debate_iddebate, grupo_idgrupo,alias)
                values ('$tese', null, $idgrupo,'$alias')";

        $resultado = mysqli_query($this->conexao, $sql);

        //$id = mysqli_insert_id($this->conexao);
        //$this->atualizarUsuarioSeq($id);

        return $resultado;
    }

    function cadastrarCronograma($idgrupo, $teseini, $tese, $argumentoini, $argumento, $revisaoini, $revisao, $replicaini, $replica, $posfinalini, $posfinal, $reflexao) {

        $teseini = $this->formatarDataPraBD($teseini);
        $tese = $this->formatarDataPraBD($tese);
        $argumentoini = $this->formatarDataPraBD($argumentoini);
        $argumento = $this->formatarDataPraBD($argumento);
        $revisaoini = $this->formatarDataPraBD($revisaoini);
        $revisao = $this->formatarDataPraBD($revisao);
        $replicaini = $this->formatarDataPraBD($replicaini);
        $replica = $this->formatarDataPraBD($replica);
        $posfinalini = $this->formatarDataPraBD($posfinalini);
        $posfinal = $this->formatarDataPraBD($posfinal);
        $reflexao = $this->formatarDataPraBD($reflexao);

        $sql = "insert into conograma (grupo_idgrupo, teseini, tese, argumentoini, argumento,revisaoini,revisao,replicaini,replica,posfinalini,posfinal,reflexao, apresentacao)
                values ($idgrupo, '$teseini', '$tese', '$argumentoini', '$argumento','$revisaoini','$revisao','$replicaini','$replica','$posfinalini','$posfinal','$reflexao','$teseini')";

        $resultado = mysqli_query($this->conexao, $sql);

        //$id = mysqli_insert_id($this->conexao);
        //$this->atualizarUsuarioSeq($id);

        return $resultado;
    }

    /*
     * Formata String Date para ser compativel com o formatdo do bando ce dados aaaa/mm/dd
     * Aceita Os formatos: dd/mm/aaaa e aaaa/mm/dd
     * @param Date
     * @return String Date 
     */

    function formatarDataPraBD($data) {


           // var_dump($data);

           // print_r($data);
           
            // if (strcmp($data[2], '/') == 0) {
            // $data = ;
            $dataprev = str_replace('/', '-', $data);
            // die($dataprev);
            // $dataFormatada = $data->format('Y/m/d');
            $dataFormatada = date('Y/m/d', strtotime($dataprev));
           // }
           // else{
           //  return $data;
           // }
            // die($dataFormatada);    

           

       
        return $dataFormatada;
    }

    /**
     * $_POST['nome'],($_POST['sobrenome'],($_POST['email'],($_POST['senha'],($_POST['grupo']);
     * @param <type> $iddebate
     */
    function cadastrarGrupo($titulo, $dataini, $datafim, $idusuario) {

        $dataini = $this->formatarDataPraBD($dataini);
        $datafim = $this->formatarDataPraBD($datafim);

        $sql = "insert into grupo (titulo, dataini, datafim,ativo,idusuario,datacriacao)
                values ('$titulo', '$dataini', '$datafim',1, $idusuario, now())";

                // die (" ----- ")
                
        $resultado = mysqli_query($this->conexao, $sql);

        if (!$resultado) 
        {
            return false;
        } 

        else {

            $id = mysqli_insert_id($this->conexao);
            // $this->atualizarGrupoSeq($id);

            return $id;
        }
    }

    /**
     * cadastra debate e retorna o id do debate cadastrado
     * O idusuario é importante para recuperar o nome do user e asism registrar o debate com o nome do user
     * retorna false senão conseguir retornar o ultimo id auto-incremente da tabela debate
     * @param <type> $idgrupo
     * @param <type> $idusuario 
     * return boolean
     */
    function cadastrarDebate($idgrupo, $idusuario, $ativo = 1) {

        $user = $this->recuperarUsuario(null, $idusuario);
        $titulo = "Página " . $user['primeironome'] . " " . $user['sobrenome'];

        // die ($sql);

        $sql = "insert into debate ( titulo, ativo,cronogramagrupo,grupo_idgrupo)
                values ( '$titulo', $ativo,1,$idgrupo)";


        $resultado = mysqli_query($this->conexao, $sql); //nao uso resultado

        if (!$resultado) 
        {
            return false;
        } 
        
        else 
        {
            $id = mysqli_insert_id($this->conexao);
            //  $this->atualizarDebateSeq($id);

            return $id;
        }
    }

    function cadastrarArgumentador($idusuario, $iddebate) {

        $sql = "insert into argumentador (usuario_idusuario,debate_iddebate)
                values ($idusuario, $iddebate)";

        $resultado = mysqli_query($this->conexao, $sql); //nao uso resultado

        $id = mysqli_insert_id($this->conexao);

        //$this->atualizarArgumentadorSeq($id);

        return $resultado;
    }

    function cadastrarMediador($idusuario, $iddebate) {

        $sql = "insert into mediador (usuario_idusuario,debate_iddebate)
                values ($idusuario, $iddebate)";

        $resultado = mysqli_query($this->conexao, $sql); //nao uso resultado

        $id = mysqli_insert_id($this->conexao);

        //   $this->atualizarMediadorSeq($id);

        return $resultado;
    }

    /*
     * cadastra revisor 
     * se o usuario == 0 , será excluido o revisor do debate informado , segundo a ordem
     */

    function cadastrarRevisor($idusuario, $iddebate, $ordem) {

        if ($idusuario == 0) {
            $this->excluirRevisor($iddebate, $ordem);
            return true;
        } else {

            if ($this->recuperarRevisores($iddebate, $ordem) == FALSE) {  //faça caso não tenha nenhum revisor ja revisor cadastrado na ordem informado
                $sql = "insert into revisor (usuario_idusuario,debate_iddebate,ordem)
                values ($idusuario, $iddebate,$ordem)";

                $resultado = mysqli_query($this->conexao, $sql); //nao uso resultado
                $id = mysqli_insert_id($this->conexao);
                $this->atualizarrevisorSeq($id);

                return $resultado;
            } else {
                return $this->atualizarRevisor($idusuario, $iddebate, $ordem);
            }
        }
        return false;
    }

    function cadastrarPosicionamentoInicial($posicionamentoinicial, $idtese, $idargumentador) {

        $sql = "insert into argumento (argumento, posicionamentoinicial, tese_idtese, argumentador_idargumentador)
                values ('clique aqui para editar','$posicionamentoinicial',$idtese, $idargumentador)";

        $resultado = mysqli_query($this->conexao, $sql); //nao uso resultado

        $id = mysqli_insert_id($this->conexao);

        // $this->atualizarMediadorSeq($id);  nnnn

        return $resultado;
    }

    function cadastrarArgumento($argumento, $idtese, $idargumentador) {

        $sql = "insert into argumento (argumento, posicionamentoinicial, tese_idtese, argumentador_idargumentador)
                values ('$argumento','Clique aqui para editar',$idtese, $idargumentador)";

        $resultado = mysqli_query($this->conexao, $sql); //nao uso resultado

        $id = mysqli_insert_id($this->conexao);

        // $this->atualizarMediadorSeq($id);  nnnn

        return $resultado;
    }

    function cadastrarRevisao($revisao, $idrevisor, $idargumento) {

        $revisao = trim($revisao);

        $sql = "insert into revisao (revisao, revisor_idrevisor, argumento_idargumento)
                values ('$revisao',$idrevisor, $idargumento)";

        

        $resultado = mysqli_query($this->conexao, $sql); //nao uso resultado

        // $id = mysqli_insert_id($this->conexao);

        if (mysqli_affected_rows($this->conexao) > 0) {
           // die("CADASTROU!!");
           return true;
        } else {
             // die("FALHOU!!");
            return false;
        }

        // return $resultado;
    }

    function cadastrarReplica($replica, $idrevisao, $idargumentador) {

        $sql = "insert into replica (replica, revisao_idrevisao, argumentador_idargumentador)
                values ('$replica',$idrevisao, $idargumentador)";

        $resultado = mysqli_query($this->conexao, $sql); //nao uso resultado

        $id = mysqli_insert_id($this->conexao);

        // $this->atualizarMediadorSeq($id);  nnnn

        return $resultado;
    }

    function cadastrarPosicionamentoFinal($posicionamentoFinal, $idtese, $idargumentador) {

        $sql = "insert into posicionamento (posicionamentofinal, tese_idtese, argumentador_idargumentador)
                values ('$posicionamentoFinal',$idtese, $idargumentador)";

        $resultado = mysqli_query($this->conexao, $sql); //nao uso resultado

        $id = mysqli_insert_id($this->conexao);

        // $this->atualizarMediadorSeq($id);  nnnn

        return $resultado;
    }

    function cadastrarReflexao($reflexao, $idtese, $idargumentador) {

        $sql = "insert into reflexao (posicionamentofinal, tese_idtese, argumentador_idargumentador)
                values '('$reflexao',$idtese, $idargumentador)";

        $resultado = mysqli_query($this->conexao, $sql); //nao uso resultado

        $id = mysqli_insert_id($this->conexao);

        // $this->atualizarMediadorSeq($id);  nnnn

        return $resultado;
    }

    function cadastrarApresentacao($posicionamentoFinal, $idtese, $idargumentador) {

        $sql = "insert into apresentacao (posicionamentofinal, tese_idtese, argumentador_idargumentador)
                values ('$posicionamentoFinal',$idtese, $idargumentador)";

        $resultado = mysqli_query($this->conexao, $sql); //nao uso resultado

        $id = mysqli_insert_id($this->conexao);

        // $this->atualizarMediadorSeq($id);  nnnn

        return $resultado;
    }

    function atualizarRevisor($idusuario, $iddebate, $ordem) {

        $sql = "update revisor SET usuario_idusuario = $idusuario where debate_iddebate = $iddebate and ordem = $ordem ";
        return mysqli_query($this->conexao, $sql);
    }

    function atualizarPosicionamentoInicial($idargumento, $texto) {

        $sql = "update argumento SET posicionamentoinicial = '$texto' where idargumento = $idargumento";
        return mysqli_query($this->conexao, $sql);
    }

    function atualizarArgumento($idargumento, $texto) {

        $sql = "update argumento SET argumento = '$texto' where idargumento = $idargumento";
        return mysqli_query($this->conexao, $sql);
    }

    function atualizarRevisao($idrevisao, $texto) {

        $sql = "update revisao SET revisao = '$texto' where idrevisao = $idrevisao";
        return mysqli_query($this->conexao, $sql);
    }

    function atualizarReplica($idargumentador, $idrevisao, $texto) {

        $sql = "update replica SET replica = '$texto' where revisao_idrevisao = $idrevisao and argumentador_idargumentador = $idargumentador";
        return mysqli_query($this->conexao, $sql);
    }

    function atualizarPosicionamentoFinal($idtese, $idargumentador, $texto) {

        $sql = "update posicionamento SET posicionamentofinal = '$texto' where tese_idtese= $idtese and argumentador_idargumentador = $idargumentador";
        return mysqli_query($this->conexao, $sql);
    }

    function atualizarReflexao($idargumento, $texto) {

        $sql = "update reflexao SET reflexao = '$texto' where idargumento = $idreflexao ";
        return mysqli_query($this->conexao, $sql);
    }

    function atualizarApresentacao($idapresentacao, $texto) {

        $sql = "update apresentacao SET reflexao = '$texto' where idargumento = $idapresentacao ";
        return mysqli_query($this->conexao, $sql);
    }

    function atualizarCronograma($idgrupo, $teseini, $tese, $argumentoini, $argumento, $revisaoini, $revisao, $replicaini, $replica, $posfinalini, $posfinal, $reflexao) {



        $teseini = $this->formatarDataPraBD($teseini);
        $tese = $this->formatarDataPraBD($tese);
        $argumentoini = $this->formatarDataPraBD($argumentoini);
        $argumento = $this->formatarDataPraBD($argumento);
        $revisaoini = $this->formatarDataPraBD($revisaoini);
        $revisao = $this->formatarDataPraBD($revisao);
        $replicaini = $this->formatarDataPraBD($replicaini);
        $replica = $this->formatarDataPraBD($replica);
        $posfinalini = $this->formatarDataPraBD($posfinalini);
        $posfinal = $this->formatarDataPraBD($posfinal);
        $reflexao = $this->formatarDataPraBD($reflexao);


        $sql = "update conograma SET teseini = '$teseini', tese = '$tese' ,argumentoini = '$argumentoini', argumento = '$argumento' , revisaoini =  '$revisaoini', revisao = '$revisao' ,replicaini = '$replicaini', replica = '$replica' , posfinalini = '$posfinalini', posfinal = '$posfinal' ,reflexao = '$reflexao', apresentacao = '$argumentoini'  
                  WHERE grupo_idgrupo = $idgrupo ";

        return mysqli_query($this->conexao, $sql);
    }

    /**
     *
     * @param <type> $iddebate
     */
    function atualizarStatusCronogranaDebate($iddebate, $status) {

        $sql = "update debate SET cronogramagrupo = $status
                WHERE iddebate = " . $iddebate;

        mysqli_query($this->conexao, $sql);
    }

    function atualizarGrupoSeq($id) {

        $sql = "update grupo_idgrupo_seq SET id = $id";

        mysqli_query($this->conexao, $sql);
    }

    function atualizarUsuario($idusuario, $primeiroNome, $sobrenome, $email, $senha) {

        $sql = "update usuario SET primeiroNome = '$primeiroNome', sobrenome = '$sobrenome' ,email = '$email', login = '$email' , grupo= 'nenhum', senha = '$senha'  
                  WHERE idusuario = $idusuario ";
        if (mysqli_query($this->conexao, $sql)) {
            return TRUE;
        }
    }

    function atualizarRevisorSeq($id) {

        $sql = "update revisor_idrevisor_seq SET id = $id";
        mysqli_query($this->conexao, $sql);
    }

    function atualizarArgumentadorSeq($id) {

        $sql = "update argumentador_idargumentador_seq SET id = $id";

        mysqli_query($this->conexao, $sql);
    }

    function atualizarDebateSeq($id) {

        $sql = "update debate_iddebate_seq SET id = $id";

        mysqli_query($this->conexao, $sql);
    }

    function atualizarMediadorSeq($id) {

        $sql = "update mediador_idmediador_seq SET id = $id";
        mysqli_query($this->conexao, $sql);
    }

    /**
     *
     * @param <type> $publico
     */
    function atualizarGrupoPublico($publico, $idgrupo) {

        $sql = "update grupo SET publico = $publico
                WHERE idgrupo = " . $this->idgrupo;

        mysqli_query($this->conexao, $sql);
    }

    /**
     *
     * @param <type> $iddebate
     */
    function atualizarGrupoBlind($blind, $idgrupo) {

        $sql = "update grupo SET blind = $blind
                WHERE idgrupo = " . $this->idgrupo;

        mysqli_query($this->conexao, $sql);
    }

    /* @Version 1.0
     * 
     */

    function excluirDebateGrupo($idgrupo) {

        $sql = "delete from grupo where idgrupo = $idgrupo";
        $resultado = mysqli_query($this->conexao, $sql);

        if (mysqli_affected_rows($this->conexao) > 0) {

            // die("DELETOUUUUUUUUU!!");

            return true;
        } else {
            return false;
        }
    }

    /* @Version 1.0
     * 
     */

    function excluirRevisor($iddebate, $ordem) {

        $sql = "delete from revisor where debate_iddebate = $iddebate and ordem = $ordem";
        $resultado = mysqli_query($this->conexao, $sql);

        if (mysqli_affected_rows($this->conexao) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /* @Version 1.0
     * 
     */

    function excluirTese($idtese) {

        $sql = "delete from tese where idtese = $idtese";
        $resultado = mysqli_query($this->conexao, $sql);

        if (mysqli_affected_rows($this->conexao) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @param <type> $iddebate 
     */
    function recuperarCronogramaPorDebate($iddebate) {

        $sql = "select tese,argumento,revisao, replica, posfinal, teseini, argumentoini,revisaoini, replicaini,posfinalini,reflexao
		FROM  cronogramaindividual c, debate d
		where c.debate_iddebate = d.iddebate and
		c.debate_iddebate = $iddebate";

        $resultado = mysqli_query($this->conexao, $sql);
        if (mysqli_num_rows($resultado) > 0) {
            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $this->conograma['tese'] = $dados["tese"];
                $this->conograma['argumento'] = $dados["argumento"];
                $this->conograma['revisao'] = $dados["revisao"];
                $this->conograma['replica'] = $dados["replica"];
                $this->conograma['posfinal'] = $dados["posfinal"];
                $this->conograma['teseini'] = $dados["teseini"];
                $this->conograma['argumentoini'] = $dados["argumentoini"];
                $this->conograma['revisaoini'] = $dados["revisaoini"];
                $this->conograma['replicaini'] = $dados["replicaini"];
                $this->conograma['posfinalini'] = $dados["posfinalini"];
                $this->conograma['reflexao'] = $dados["reflexao"];
            }
        }
    }

    function recuperarCronogramaPorGrupo($idgrupo, $formato = FALSE) {

        $sql = "select idconograma as id, tese,argumento,revisao, replica, posfinal, teseini, argumentoini,revisaoini, replicaini,posfinalini,reflexao,apresentacao
		FROM  conograma c, grupo  g
		where c.grupo_idgrupo = g.idgrupo and
		c.grupo_idgrupo = $idgrupo";

        $resultado = mysqli_query($this->conexao, $sql);

        if (mysqli_num_rows($resultado) > 0) {
            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $this->conograma['id'] = $dados["id"];
                $this->conograma['tese'] = $dados["tese"];
                $this->conograma['argumento'] = $dados["argumento"];
                $this->conograma['revisao'] = $dados["revisao"];
                $this->conograma['replica'] = $dados["replica"];
                $this->conograma['posfinal'] = $dados["posfinal"];
                $this->conograma['teseini'] = $dados["teseini"];
                $this->conograma['argumentoini'] = $dados["argumentoini"];
                $this->conograma['revisaoini'] = $dados["revisaoini"];
                $this->conograma['replicaini'] = $dados["replicaini"];
                $this->conograma['posfinalini'] = $dados["posfinalini"];
                $this->conograma['reflexao'] = $dados["reflexao"];
                $this->conograma['apresentacao'] = $dados["apresentacao"];
            }

            if ($formato) {
                $this->conograma['teseini'] = date('d/m/Y', strtotime($this->conograma['teseini']));
                $this->conograma['tese'] = date('d/m/Y', strtotime($this->conograma['tese']));
                $this->conograma['argumentoini'] = date('d/m/Y', strtotime($this->conograma['argumentoini']));
                $this->conograma['argumento'] = date('d/m/Y', strtotime($this->conograma['argumento']));
                $this->conograma['revisaoini'] = date('d/m/Y', strtotime($this->conograma['revisaoini']));
                $this->conograma['revisao'] = date('d/m/Y', strtotime($this->conograma['revisao']));
                $this->conograma['replicaini'] = date('d/m/Y', strtotime($this->conograma['replicaini']));
                $this->conograma['replica'] = date('d/m/Y', strtotime($this->conograma['replica']));
                $this->conograma['posfinalini'] = date('d/m/Y', strtotime($this->conograma['posfinalini']));
                $this->conograma['posfinal'] = date('d/m/Y', strtotime($this->conograma['posfinal']));
                $this->conograma['reflexao'] = date('d/m/Y', strtotime($this->conograma['reflexao']));

                return $this->conograma;
            }


            return $resultado;
        }

        return FALSE;
    }

    function recuperarGrupo($idgrupo) {

        $this->grupo = null;

        $sql = "select idgrupo, titulo, ativo,dataini, datafim, publico, blind, idusuario,datacriacao
		FROM  grupo  g
		where idgrupo = $idgrupo";

        $resultado = mysqli_query($this->conexao, $sql);
        if (mysqli_num_rows($resultado) > 0) {
            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {

                $this->grupo['idgrupo'] = $dados["idgrupo"];
                $this->grupo['titulo'] = $dados["titulo"];
                $this->grupo['ativo'] = $dados["ativo"];
                $this->grupo['dataini'] = $dados["dataini"]; //reparação em 05/03/2015
                $this->grupo['datafim'] = $dados["datafim"];
                $this->grupo['dataini_br'] = date('d/m/Y', strtotime($dados['dataini']));
                $this->grupo['datafim_br'] = date('d/m/Y', strtotime($dados['datafim']));
                $this->grupo['publico'] = $dados["publico"];
                $this->grupo['blind'] = $dados["blind"];
                $this->grupo['datacriacao'] = $dados["datacriacao"];
                $this->grupo['datacriacao_br'] = date('d/m/Y', strtotime($dados['datacriacao']));
                $this->grupo['idusuario'] = $dados["idusuario"];
            }
        }
        return $this->grupo;
    }

    // recupera os que estao associados ao mediador
    function recuperarGruposPorLogin($login, $senha) {
        $this->grupos = null;
        $sql = "select g.idgrupo, g.titulo,g.ativo,g.dataini, g.datafim, g.publico, g.blind  from grupo g, mediador m , debate d, usuario u
				where
				m.debate_iddebate = d.iddebate and
				d.grupo_idgrupo = g.idgrupo and
				m.usuario_idusuario = u.idusuario and
				u.login = '$login' and u.senha = '$senha' 
				group by g.idgrupo";

        $resultado = mysqli_query($this->conexao, $sql);
        if (mysqli_num_rows($resultado) > 0) {
            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                if (( $dados["idgrupo"] != 1) and ( $dados['ativo'] != 0)) { //grupo 1 - grupo para vincular o novo usuario ao admin
                    $grupo['idgrupo'] = $dados["idgrupo"];
                    $grupo['titulo'] = $dados["titulo"];
                    $grupo['ativo'] = $dados["ativo"];
                    $grupo['dataini'] = $dados["dataini"];
                    $grupo['datafim'] = $dados["datafim"];
                    $grupo['publico'] = $dados["publico"];
                    $grupo['blind'] = $dados["blind"];
                    $this->grupos[] = $grupo;
                }
            }
        }
        return $this->grupos;
    }

    /*
     * recupera todos os debates onde o usuário é participante, nao são inclusos os debates que o usuario é mediador
     * @param: login, senha, vetor com todos debates ,  vetor debates mediador
     * @return: Vetor de Grupos
     */

    function recuperarGruposParticipantes($login, $senha) {

        $debatesMediador = null;
        $debates = null;
        $idgrupoMediador = null;
        $idgrupoParticipantes = null;
        $debatesParticipantes = null;

        $debatesMediador = $this->recuperarGruposPorLogin($login, $senha);
        $debates = $this->recuperarTodosDebatesPorLogin($login, $senha); //atualiza $this->debates

        foreach ($debates as $debate) {
            $idgrupoParticipantes[] = $debate["idgrupo"];
        }

        if (is_array($debatesMediador)) {
            foreach ($debatesMediador as $debate) {
                $idgrupoMediador[] = $debate["idgrupo"];
            }
        }

        if (is_array($idgrupoParticipantes)) {

            if (is_array($idgrupoMediador)) {

                //Cria um array sem os idgrupos repetidos presentes no array do mediador
                // objetivo é não possuir repetição entre grupos que seja participantee e mediador 
                foreach ($idgrupoParticipantes as $id) {
                    if (array_search($id, $idgrupoMediador) === false) {
                        $debatesParticipantes[] = $id;
                    } else {
                        //
                    }
                }
            } else {
                $debatesParticipantes = $idgrupoParticipantes;
            }
        }

        if (is_array($debatesParticipantes)) {
            // Retirar a redundancia de ids
            $debatesParticipantes = array_unique($debatesParticipantes);
        }

        if (is_array($debatesParticipantes)) {
            foreach ($debatesParticipantes as $idgrupo) {
                $debateGruposParticipantes[] = $this->recuperarGrupo($idgrupo);
            }
        }

        $this->gruposDebatesParticipantes = $debateGruposParticipantes;

        // print_r($debateGruposParticipantes);

        return $debateGruposParticipantes;
    }

// copiadooooooooooooooo
 function recuperarDebatesPorLogin2($login, $senha, $idgrupo = null) {

       $this->debates = null;
       
       // para incluir ou não a clausula de recueprar debates do grupo pertinente
       if( is_null($idgrupo))
       {
           $condicao = " ";
       }
       else
       {
           $condicao = " g.idgrupo = $idgrupo and ";
       }

       $sql = "
		(select d.iddebate,d.titulo, d.ativo, g.idgrupo
			FROM  debate d, usuario u  ,  revisor r , grupo g
			where 
			r.usuario_idusuario = u.idusuario  and
			r.debate_iddebate = d.iddebate and
			d.grupo_idgrupo = g.idgrupo and
                        $condicao
			u.login = '$login' and u.senha = '$senha')
			union
		(select d.iddebate,d.titulo, d.ativo, g.idgrupo
			FROM  debate d, usuario u, argumentador a,   grupo g
			where 
			a.usuario_idusuario = u.idusuario  and
			a.debate_iddebate = d.iddebate and
			d.grupo_idgrupo = g.idgrupo  and
                        $condicao
			u.login = '$login' and u.senha = '$senha')
			union
		(select d.iddebate,d.titulo, d.ativo, g.idgrupo
			FROM  debate d, usuario u, mediador m,  grupo g
			where 
			m.usuario_idusuario = u.idusuario  and
			m.debate_iddebate = d.iddebate and
			d.grupo_idgrupo = g.idgrupo  and 
                        $condicao
			u.login = '$login' and u.senha = '$senha')
		";

        $resultado = mysqli_query($this->conexao, $sql);

        if (mysqli_num_rows($resultado) > 0) {
		
		//print_r("simmmmmmmmmmmmmmmmmmmmmmmmsimmmmmmmmmmmmm");

            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                if (( $dados["idgrupo"] != 1) and ($dados['ativo'] != 0) ) //grupo 1 - grupo para vincular o novo usuario ao admin
                {
                    $debate['iddebate'] = $dados["iddebate"];
                    $debate['titulo'] = $dados["titulo"];
                    $debate['ativo'] = $dados["ativo"];
                    $debate['idgrupo'] = $dados["idgrupo"];
                    $this->debates[] = $debate;
                }
            }
        } else {
		// print_r("naooooooooooooooooooonaooooooooooooooo");
            return 0;
        }
        return mysqli_num_rows($resultado);
    }



    /* @Version 1.0
     * @deprecated
     * TODO: alterar as chamadas dos métodos recuperarDebatesPorLogin por recuperarTodosDebatesPorLogin. O motivo 
     */

    function recuperarDebatesPorLogin($login, $senha, $idgrupo = null) {

        $this->debates = null;

        // para incluir ou não a clausula de recueprar debates do grupo pertinente
        if (is_null($idgrupo)) {
            $condicao = " ";
        } else {
            $condicao = " g.idgrupo = $idgrupo and ";
        }

        $sql = "
		(select d.iddebate,d.titulo, d.ativo, g.idgrupo
			FROM  debate d, usuario u  ,  revisor r , grupo g
			where 
			r.usuario_idusuario = u.idusuario  and
			r.debate_iddebate = d.iddebate and
			d.grupo_idgrupo = g.idgrupo and
                        $condicao
			u.login = '$login' and u.senha = '$senha')
			union
		(select d.iddebate,d.titulo, d.ativo, g.idgrupo
			FROM  debate d, usuario u, argumentador a,   grupo g
			where 
			a.usuario_idusuario = u.idusuario  and
			a.debate_iddebate = d.iddebate and
			d.grupo_idgrupo = g.idgrupo  and
                        $condicao
			u.login = '$login' and u.senha = '$senha')
			union
		(select d.iddebate,d.titulo, d.ativo, g.idgrupo
			FROM  debate d, usuario u, mediador m,  grupo g
			where 
			m.usuario_idusuario = u.idusuario  and
			m.debate_iddebate = d.iddebate and
			d.grupo_idgrupo = g.idgrupo  and 
                        $condicao
			u.login = '$login' and u.senha = '$senha')
		";

        $resultado = mysqli_query($this->conexao, $sql);

	   //var_dump($resultado);
        if (mysqli_num_rows($resultado) > 0) {
	
            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) 
	        {
                if (( $dados["idgrupo"] != 1) and ( $dados['ativo'] != 0)) 
		        { 
		            //grupo 1 - grupo para vincular o novo usuario ao admin

                    $debate['iddebate'] = $dados["iddebate"];
                    $debate['titulo'] = trim($dados["titulo"]);
                    $debate['ativo'] = $dados["ativo"];
                    $debate['idgrupo'] = $dados["idgrupo"];
                    $debate['nada'] = "nada";
                    $this->debates[] = $debate;
                }
            }

        } 
	
    	else 
    	{
    		//print_r("mmmmmmmmmmmmMERDA: ".mysqli_num_rows($resultado));
                return 0;

        }
            

        return mysqli_num_rows($resultado);
    }

    /* @Version 1.0
     * retorna um vetor de Grupos
     * 
     */

    function recuperarDebatesPorGrupo($idgrupo = null) {

        // para incluir ou não a clausula de recuperar debates do grupo pertinente
        if (is_null($idgrupo)) {
            $condicao = " ";
        } else {
            $condicao = " g.idgrupo = $idgrupo and ";
        }

        $sql = "select d.iddebate, d.titulo, d.ativo
                    FROM  debate d
                    where d.grupo_idgrupo = $idgrupo";

        $resultado = mysqli_query($this->conexao, $sql);

        if (mysqli_num_rows($resultado) > 0) {

            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $debate['iddebate'] = $dados["iddebate"];
                $debate['titulo'] = trim($dados["titulo"]);
                $debate['ativo'] = $dados["ativo"];
                $debate['idgrupo'] = $dados["grupo_idgrupo"];

                $debates[] = $debate;
            }
        } else {
            return 0;
        }
        return $debates;
    }

    /* @Version 1.0
     * retorna um vetor de Grupos
     * 
     */

    function recuperarTodosDebatesPorLogin($login, $senha, $idgrupo = null) {

        $this->debates = null;

        // para incluir ou não a clausula de recueprar debates do grupo pertinente
        if (is_null($idgrupo)) {
            $condicao = " ";
        } else {
            $condicao = " g.idgrupo = $idgrupo and ";
        }

        $sql = "
		(select d.iddebate,d.titulo, d.ativo, g.idgrupo
			FROM  debate d, usuario u  ,  revisor r , grupo g
			where 
			r.usuario_idusuario = u.idusuario  and
			r.debate_iddebate = d.iddebate and
			d.grupo_idgrupo = g.idgrupo and
                        $condicao
			u.login = '$login' and u.senha = '$senha')
			union
		(select d.iddebate,d.titulo, d.ativo, g.idgrupo
			FROM  debate d, usuario u, argumentador a,   grupo g
			where 
			a.usuario_idusuario = u.idusuario  and
			a.debate_iddebate = d.iddebate and
			d.grupo_idgrupo = g.idgrupo  and
                        $condicao
			u.login = '$login' and u.senha = '$senha')
			union
		(select d.iddebate,d.titulo, d.ativo, g.idgrupo
			FROM  debate d, usuario u, mediador m,  grupo g
			where 
			m.usuario_idusuario = u.idusuario  and
			m.debate_iddebate = d.iddebate and
			d.grupo_idgrupo = g.idgrupo  and 
                        $condicao
			u.login = '$login' and u.senha = '$senha')
		";

        $resultado = mysqli_query($this->conexao, $sql);

        if (mysqli_num_rows($resultado) > 0) {

            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                if (( $dados["idgrupo"] != 1) and ( $dados['ativo'] != 0)) { //grupo 1 - grupo para vincular o novo usuario ao admin
                    $debate['iddebate'] = $dados["iddebate"];
                    $debate['titulo'] = $dados["titulo"];
                    $debate['ativo'] = $dados["ativo"];
                    $debate['idgrupo'] = $dados["idgrupo"];
                    $argumentador = $this->recuperarArgumentadorPorDebate($debate['iddebate']);

                    $debate['idargumentador'] = $argumentador["idusuario"];
                    $mediadores = $this->recuperarMediadores($debate['iddebate']);
                    $debate['idmediador'] = $mediadores[0]["idusuario"];
                    $this->debates[] = $debate;
                }
            }
        } else {
            return 0;
        }
        return $this->debates;
    }

    function recuperarRevisores($iddebate, $ordem = null) {

        $sql = "select u.primeironome, u.idusuario, u.sobrenome
					from usuario u, revisor r, debate d
					where 
					r.usuario_idusuario = u.idusuario  and
					r.debate_iddebate = d.iddebate and
					d.iddebate = $iddebate ";

        if ($ordem != null) {
            $sql .= "  and r.ordem = $ordem ";
        }

        $sql .= "  order by r.ordem"; //ordernar os revisores

        
        $resultado = mysqli_query($this->conexao, $sql);

        if (mysqli_num_rows($resultado) > 0) {
            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $tese['primeironome'] = $dados["primeironome"];
                $tese['sobrenome'] = $dados["sobrenome"];
                $tese['nomecompleto'] = $dados["primeironome"] . " " . $dados["sobrenome"];
                $tese['idusuario'] = $dados["idusuario"];
                $tese['ordem'] = $dados["ordem"];
                $teses[] = $tese;
            }
            return $teses;
        } else {
            return false;
        }
    }

    //recupera array
    //
    function recuperarArgumentadores($iddebate) {
        $sql = "select u.primeironome, u.idusuario, u.sobrenome
					from usuario u, argumentador a, debate d
					where 
					a.usuario_idusuario = u.idusuario  and
					a.debate_iddebate = d.iddebate and
					d.iddebate = $iddebate";

        $resultado = mysqli_query($this->conexao, $sql);

        if (mysqli_num_rows($resultado) > 0) {
            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $tese['primeironome'] = trim($dados["primeironome"]);
                $tese['sobrenome'] = trim($dados["sobrenome"]);
                $tese['idusuario'] = $dados["idusuario"];
                $teses[] = $tese;
            }
        }

        return $teses;
    }

    function recuperarMediadores($iddebate) {
        $sql = "select u.primeironome, u.idusuario, u.sobrenome
					from usuario u, mediador m, debate d
					where 
					m.usuario_idusuario = u.idusuario  and
					m.debate_iddebate = d.iddebate and
					d.iddebate = $iddebate";

        $resultado = mysqli_query($this->conexao, $sql);

        if (mysqli_num_rows($resultado) > 0) {
            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $tese['primeironome'] = trim($dados["primeironome"]);
                $tese['sobrenome'] = trim($dados["sobrenome"]);
                $tese['idusuario'] = $dados["idusuario"];
                $teses[] = $tese;
            }
        }
        return $teses;
    }

    function recuperarTeses($idgrupo) {
        $this->teses = null;

        $sql = "select t.idtese, t.tese, t.alias
		FROM  tese t, grupo g
		where t.grupo_idgrupo = g.idgrupo and 
		g.idgrupo = $idgrupo";

        $resultado = mysqli_query($this->conexao, $sql);
        if (mysqli_num_rows($resultado) > 0) {
            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $tese['idtese'] = $dados["idtese"];
                $tese['tese'] = $dados["tese"];
                $tese['alias'] = $dados["alias"];
                $this->teses[] = $tese;
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function recuperarArgumentos($idtese, $iddebate, $idargumento = null) {
        $this->argumentos = null;

        if (!is_null($idargumento)) {
            $condicao = " and idargumento = $idargumento ";
        } else {
            $condicao = " ";
        }

        $sql = "select a.argumento, a.idargumento, a.tese_idtese, a.posicionamentoinicial, arg.idargumentador
		FROM  argumento a, tese t, argumentador arg, debate d
		where a.tese_idtese = t.idtese and 
		a.argumentador_idargumentador = arg.idargumentador and
		arg.debate_iddebate = d.iddebate and
		t.idtese = $idtese and
		d.iddebate = $iddebate " . $condicao;



        $resultado = mysqli_query($this->conexao, $sql);
        if (mysqli_num_rows($resultado) > 0) {

            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $argumento['idargumento'] = $dados["idargumento"];
                $argumento['argumento'] = $dados["argumento"];
                $argumento['posicionamentoinicial'] = $dados["posicionamentoinicial"];
                $argumento['idargumentador'] = $dados["idargumentador"];
                $argumento['tese_idtese'] = $dados["tese_idtese"];
                $this->argumentos[] = $argumento;
            }

            return TRUE;
        } else {
            return FALSE;
        }
    }

    function recuperarPosicionamentos($idtese, $iddebate) {
        $this->posicionamentos = null;

        $sql = "select p.posicionamentofinal, p.argumentador_idargumentador, p.tese_idtese
		FROM  posicionamento p, tese t, argumentador arg, debate d
		where p.tese_idtese = t.idtese and 
		p.argumentador_idargumentador = arg.idargumentador and
		arg.debate_iddebate = d.iddebate and		
		t.idtese = $idtese and
		d.iddebate = $iddebate";

        $resultado = mysqli_query($this->conexao, $sql);
        if (mysqli_num_rows($resultado) > 0) {

            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $posicionamento['argumentador_idargumentador'] = $dados["argumentador_idargumentador"];
                $posicionamento['tese_idtese'] = $dados["tese_idtese"];
                $posicionamento['posicionamentofinal'] = $dados["posicionamentofinal"];
                $this->posicionamentos[] = $posicionamento;
            }

            return TRUE;
        } else {
            return FALSE;
        }
    }

    function recuperarRevisao($idrevisor, $idargummento) {
        $sql = "select revisao
		FROM  revisao 
		where 
		revisor_idrevisor = $idrevisor and 
                argumento_idargumento = $idargummento ";

        // die("MMMMMMMMMMMMMMMMMMMMMMMMM");
        // die($sql);


        $resultado = mysqli_query($this->conexao, $sql);
        if (mysqli_num_rows($resultado) > 0) {

           
            return true;
        } else {
            return false;
        }
    }

    function recuperarReflexao($iddebate) {
        $sql = "select r.reflexao
		FROM  reflexao r
		where 
		r.debate_iddebate = $iddebate ";

        $resultado = mysqli_query($this->conexao, $sql);
        if (mysqli_num_rows($resultado) > 0) {

            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $reflexao = $dados["reflexao"];
            }
        } else {
            return FALSE;
        }
        return $reflexao;
    }

    function recuperarApresentacao($iddebate) {
        $sql = "select a.apresentacao
		FROM  apresentacao a
		where
		a.debate_iddebate = $iddebate ";

        $resultado = mysqli_query($this->conexao, $sql);
        if (mysqli_num_rows($resultado) > 0) {

            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $apresentacao = $dados["apresentacao"];
            }
        }

        $apresentação = trim($apresentacao);

        if (($apresentacao == null) or ( $apresentacao == "")) {
            $apresentacao = "clique aqui para editar";
        }
        return $apresentacao;
    }

    function recuperarLogGrupoDebate($idgrupo, $idusuario = null) {

        if (is_null($idgrupo)) {
            $condicao1 = " ";
        } else {
            $condicao1 = " g.idgrupo = $idgrupo and ";
        }
        if (is_null($idusuario)) {
            $condicao2 = " ";
        } else {
            $condicao2 = " and l.idusuario = $idusuario  ";
        }

        $sql = "select l.hora, l.log, u.primeironome, u.sobrenome, l.idusuario
		FROM  log l, usuario u, argumentador a, debate d, grupo g
		where
                $condicao1 
                u.idusuario = a.usuario_idusuario and
                a.debate_iddebate = d.iddebate and
                d.grupo_idgrupo = g.idgrupo and
                u.idusuario = l.idusuario
                $condicao2
                order by hora desc";


        $resultado = mysqli_query($this->conexao, $sql);
        if (mysqli_num_rows($resultado) > 0) {

            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $log['hora'] = date('d/m/Y   H:i:s', strtotime($dados["hora"]));
                $log['log'] = $dados["log"];
                $log['nomeCompleto'] = $dados["primeironome"] . " " . $dados["sobrenome"];
                $log['logCompleto'] = $log['nomeCompleto'] . " " . $log['log'];
                $log['idusuario'] = $dados["idusuario"];
                $colecaoLog[] = $log;
            }
        }
        return $colecaoLog;
    }

    function recuperaRevisor($idrevisor) {

        $conexao = new Conexao();

        $sql = "select  u.primeironome, u.sobrenome, u.idusuario
                            FROM usuario u, revisor r
                     where
                            r.idrevisor = $idrevisor and
                            r.usuario_idusuario = u.idusuario";

        $resultado = mysqli_query($this->conexao, $sql);
        if (mysqli_num_rows($resultado) > 0) {
            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $user['primeironome'] = $dados["primeironome"];
                $user['sobrenome'] = $dados["sobrenome"];
                $user['idusuario'] = $dados["idusuario"];
            }
            return $user;
        }
    }

    function recuperaRevisoes($idargumento, $idrevisor = null) {
        $this->revisoes = null;

        $conexao = new Conexao();

        $sql = "select  rev.revisao, rev.idrevisao, rev.revisor_idrevisor, rev.argumento_idargumento
								FROM argumento a, revisao rev, revisor r
								where
								a.idargumento = $idargumento and
								rev.argumento_idargumento = a.idargumento and
								r.idrevisor = rev.revisor_idrevisor ";

        if ($this->perfilRevisor == 1) {
            $sql .= "and r.idrevisor = " . $this->idrevisor;
        }

      

        $resultado = mysqli_query($conexao->conectado(), $sql);


        if (mysqli_num_rows($resultado) > 0) {
            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $revisao['revisao'] = $dados["revisao"];
                $revisao['idargumento'] = $dados["argumento_idargumento"];
                $revisao['idrevisao'] = $dados["idrevisao"];
                $revisao['idrevisor'] = $dados["revisor_idrevisor"];
                $revisor = $this->recuperaRevisor($dados["revisor_idrevisor"]);

                $revisao['nomeCompleto'] = $revisor["primeironome"] . " " . $revisor["sobrenome"];

                $this->revisoes[] = $revisao;
            }

            // die("aaaaaaaaa");

            return $this->revisoes;
        } else {

            return false;
        }
    }

    /*
      recupera as replicas das revisoes
      Se o usuario for um revisor, somente ser� recuperado a replica da revisao pertecente a este revisor
     */

    function recuperaReplicas($idargumentador, $idrevisao) {
        //$this->replicas = null;

        $conexao = new Conexao();

        $sql = "select rep.replica
                    FROM replica rep, revisao r
                    where
                    rep.argumentador_idargumentador = $idargumentador and
                    rep.revisao_idrevisao = r.idrevisao and
                    rep.revisao_idrevisao =  $idrevisao";

        if ($this->perfilRevisor === 1) {
            $sql .= " and r.revisor_idrevisor = " . $this->idrevisor;
        }
        //echo "  ..<br>"	;
         $resultado = mysqli_query($conexao->conectado(), $sql);

        if (mysqli_num_rows($resultado) > 0) {

            for ($cont = 0; $dados = mysqli_fetch_array($resultado); $cont++) {
                $replica['replica'] = $dados["replica"];
                $this->replicas[] = $replica;
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function verificaPermissaoAcesso($idmask) {

        if ((strcmp($idmask, "debate") == 0) && ($this->perfilAdmin == 1)) {
            return 0;
        } elseif ((strcmp($idmask, "debate") == 0) && ($this->perfilMediador == 1)) {
            return 1;
        } elseif ((strcmp($idmask, "usuario") == 0) && ($this->perfilMediador == 1)) {
            return 1;
        } elseif ((strcmp($idmask, "usuario") == 0) && ($this->perfilRevisor == 1)) {
            return 1;
        } elseif ((strcmp($idmask, "usuario") == 0) && ($this->perfilArgumentador == 1)) {
            return 1;
        } elseif ((strcmp($idmask, "mediador") == 0) && ($this->perfilMediador == 1)) {
            return 1;
        } elseif ((strcmp($idmask, "argumentador") == 0) && ($this->perfilMediador == 1)) {
            return 1;
        } elseif ((strcmp($idmask, "revisor") == 0) && ($this->perfilMediador == 1)) {
            return 1;
        } elseif ((strcmp($idmask, "tese") == 0) && ($this->perfilMediador == 1) && ($this->verificaConogramaTese())) {
            return 1;
        } elseif ((strcmp($idmask, "revisao") == 0) && ($this->perfilRevisor == 1) && ($this->verificaConogramaRevisao())) {
            return 1;
        } elseif ((strcmp($idmask, "argumento") == 0) && ($this->perfilArgumentador == 1) && ($this->verificaConogramaArgumento())) {
            return 1;
        } elseif ((strcmp($idmask, "posicionamento") == 0) && ($this->perfilArgumentador == 1) && ($this->verificaConogramaPosfinal())) {
            return 1;
        } elseif ((strcmp($idmask, "replica") == 0) && ($this->perfilArgumentador == 1) && ($this->verificaConogramaReplica())) {
            return 1;
        } elseif ((strcmp($idmask, "reflexao") == 0) && ($this->perfilArgumentador == 1) && ($this->verificaConogramaReflexao())) {
            return 1;
        } elseif ((strcmp($idmask, "apresentacao") == 0) && ($this->perfilArgumentador == 1) && ($this->verificaConogramaApresentacao())) {
            return 1;
        } elseif (strcmp($idmask, "senha") == 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function verificaConogramaTese() {
        if ((date('ymd', strtotime($this->conograma['tese'])) >= date('ymd')) and ( date('ymd', strtotime($this->conograma['teseini'])) <= date('ymd'))) {
            return true;
        } else {
            return false;
        }
    }

    function verificaConogramaArgumento() {
        if ((date('ymd', strtotime($this->conograma['argumento'])) >= date('ymd')) and ( date('ymd', strtotime($this->conograma['argumentoini'])) <= date('ymd'))) {
            return true;
        } else {
            return false;
        }
    }

    function verificaConogramaRevisao() {
        if ((date('ymd', strtotime($this->conograma['revisao'])) >= date('ymd') ) and ( date('ymd', strtotime($this->conograma['revisaoini'])) <= date('ymd'))) {
            return true;
        } else {
            return false;
        }
    }

    function verificaConogramaReplica() {
        if ((date('ymd', strtotime($this->conograma['replica'])) >= date('ymd') ) and ( date('ymd', strtotime($this->conograma['replicaini'])) <= date('ymd'))) {
            return true;
        } else {
            return false;
        }
    }

    function verificaConogramaPosfinal() {
        if ((date('ymd', strtotime($this->conograma['posfinal'])) >= date('ymd') ) and ( date('ymd', strtotime($this->conograma['posfinalini'])) <= date('ymd'))) {
            return true;
        } else {
            return false;
        }
    }

    function verificaConogramaReflexao() {
        if (date('ymd', strtotime($this->conograma['reflexao'])) >= date('ymd')) {
            return true;
        } else {
            return false;
        }
    }

    function verificaConogramaApresentacao() {
        if (date('ymd', strtotime($this->conograma['apresentacao'])) >= date('ymd')) {
            return true;
        } else {
            return false;
        }
    }

    /*
      idmask:	1- argumento/ 2- posicionamentoinicial /3- revisao / 4- replica /5 - pos final/ 6- apresentacao / 7-reflexao
     */
// $dd->imprime(" [desabilitar]", null, array("idgrupo" => $_GET['idgrupo'], "idpagina" => 1, "idAcao" => 1001, "iddebate" => $iddebate), $dd->paginaMenu, 1);

    function imprime($texto, $idmask, $param, $link = null, $passelivre = 0, $textoNulo = null) {

        //if($link == null){ $link = $this->paginaP4a; } else {$link =   $this->paginaPrincipal ; }             
        // var de verificao para impedir de imprimir link de edição 2x na revisao 3 replica
        $revisaoMask = $param["revisaoMask"];

        $link .= "&idmask=$idmask&";

        $class = "";

        if (!is_null($idmask)) {
            $class = "class='chamaForm'";
        }

        foreach ($param as $key => $param) {
            if ($param == "") {
                $param = 0;
            }
            $link .= "$key=$param&";
        }

        $texto = trim($texto);

        if (($texto == null) or ( $texto == "")) {
            //cao nao tenha nada
            $texto = "clique aqui para editar";
            if ($textoNulo != null) { //passado por parametro
                $texto = $textoNulo;
            }
        }

        $link .= "paginaAnterior=" . $this->paginaAtual; //será pagina anterior quando o link for clicado
        $link .= "&";


        if (($this->perfilMediador != 1) && ($revisaoMask == TRUE) && ($this->perfilArgumentador != 1)) {
            //print_r($param);
            return "";
        }

        if ($passelivre) {
            return "<a href=\"$link\"> $texto </a>";
        }

        if ($this->verificaPermissaoAcesso($idmask)) {
            return "<a $class href=\"$link\"> $texto </a>";
        }

        return $texto;
        //
    }

//function imprime($texto, $idmask, $param, $link = null, $passelivre = 0, $textoNulo = null) {
//
//        //if($link == null){ $link = $this->paginaP4a; } else {$link =   $this->paginaPrincipal ; }
//
//        $link .= "idmask=$idmask&";
//
//        $class = "";
//
//        if (!is_null($idmask)) {
//            $class = "class='chamaForm'";
//        }
//
//
//        foreach ($param as $key => $param) {
//            if ($param == "") {
//                $param = 0;
//            }
//
//            $link .= "$key=$param&";
//        }
//
//        $texto = trim($texto);
//
//        if (($texto == null) or ( $texto == "")) {
//            //cao nao tenha nada
//            $texto = "clique aqui para editar";
//            if ($textoNulo != null) { //passado por parametro
//                $texto = $textoNulo;
//            }
//        }
//
//        $link .= "paginaAnterior=" . $this->paginaAtual; //será pagina anterior quando o link for clicado
//        $link .= "&";
//
//        if ($passelivre) {
//            return "<a href=\"$link\"> $texto </a>";
//        }
//
//        if ($this->verificaPermissaoAcesso($idmask)) {
//            return "<a $class href=\"$link\"> $texto </a>";
//        }
//
//        return $texto;
//        //
//    }



    function validaVar($param1) {

        if (empty($param1) || is_null($param1) || $param1 == " " || strlen($param1) < 3) {
            return 0;
        } else {
            return 1;
        }
    }

    // verificar nome, sobrenome e email se sao validos
    function validaFormRegistro() {

        if ($this->validaVar($_POST['nome']) && $this->validaVar($_POST['sobrenome']) && $this->validaVar($_POST['email'])) {
            return 1;
        } else {
            return 0;
        }
    }

    /*
     * 
     * 
     *  10 , 1000 , 1001 , 1002 (revisores)
     *  1003 , 1004 , 1005 (revisores)
     * 
     */

    function analisarAcao($idAcao) {

        $senha = $_POST['senha'];
        $nome = $_POST['nome'];
        $sobrenome = $_POST['sobrenome'];
        $email = $_POST['email'];

        $msg = "";
        $textoCorpoEmail = "";




        if ($idAcao == 10) {

            if ($this->validaFormRegistro()) {

                if (!$this->verificarEmailExistente(trim($_POST['email']))) {
                    
                    if ($this->registrarNovoUsuario($_POST['nome'], $_POST['sobrenome'], $_POST['email'], "autoinscrição")) {

                        $textoCorpoEmail = "$nome, <br><br>Bem Vindo ao Sistema Debate de Teses (<a href='lied.inf.ufes.br/debate2'>acesse</a>) <br>  
                                            Seu Cadastro no sistema debate de teses foi realizado com sucesso!<br>
                                            Agora você pode criar seus próprios debates, atuando como Mediador do debate. Faça o login no sistema, crie seu debate e convide seus argumentadores.<br><br>
                                            Seus dados cadastrais:<br>
                                            Nome: $nome $sobrenome<br>
                                            E-mail: $email<br>     
                                            Senha: 12345 (provisória)<br>
                                            <i>Faça a alteração da sua senha o quanto antes.</i> <br><br>
                                            att,<br>
                                            Administrador.";

                        $ee = new EnvioEmail($email, "Bem-vindo ao Sistema Debate de Teses", $textoCorpoEmail);
                        
                        if ($ee->enviar()) 
                        {

                            $_SESSION["msg"] = "Cadastro realizado com sucesso! A senha de acesso foi enviada para seu e-mail.";
                            $_SESSION["error"] = null;
                        } 

                        else 
                        {

                            $_SESSION["msg"] = null;
                            $_SESSION["error"] = "Erro inesperado (900): Identificamos problemas com o serviço de e-mail. O contato por e-mail com dados do convite não foi enviado<br>Faça contato com o administrador";
                        }

                    } 
                    else  // registrarNovoUsuario == false
                    {
                        $_SESSION["error"] = "Erro inesperado: 901"; // dados validados, email n cadastrado , erro inesperado    
                        $_SESSION["msg"] = null;
                        // header('location:' . $this->paginaLogin . '&erro=' . $msg);                    
                    }

                } 
                
                else //verificarEmailExistente == false
                {
                    $_SESSION["msg"] = null;
                    $_SESSION["error"] = "Seu registro não foi efetuado. <br>Este e-mail já foi cadastrado.";                    
                }

                
                // dentro/continua o IF (validaFormRegistro = true)
                // $_SESSION["registro"] = "Cadastro realizado com sucesso! A senha de acesso foi enviada para seu e-mail.";              

            }
            
            else // $this->validaFormRegistro() == false
            {

                $_SESSION["error"] = "Seu cadastro não foi efetuado!. Preencha corretamente os dados de registro";
                $_SESSION["msg"] = null;
                // header('location:' . $this->paginaLogin . '&erro=' . $msg);

            }


                // $_SESSION["error"] = null;
                // $_SESSION["error"] = null;
                header('location:' . $this->paginaLogin);



        }

        //POST do Form login do index.php, para efetuar atenticação login
        // versao anterior era realizada pelo verificaLogin.php
        if ($idAcao == 11) {
            $this->efetuarLogin($email, $senha);
        }


        /**
         * Atualiza a COLUNA cronogramagrupo da TABELA debate para 0, ou seja para que torna-se cronograma
         * individual
         */
        if ($idAcao == 1000) {
            $iddebate = $_GET["iddebate"];
            $this->atualizarStatusCronogranaDebate($iddebate, 0);
        }
        /**
         * Atualiza a COLUNA cronogramagrupo da TABELA debate para 1, ou seja para que
         * torna-se cronograma grupo
         */
        if ($idAcao == 1001) {
            $iddebate = $_GET["iddebate"];
            $this->atualizarStatusCronogranaDebate($iddebate, 1);
        }
        /**
         * Atualiza o revisor de uma pagina de debate
         * É realizado atraves do post
         * A variavel do post é criado quando chama lisbox da classe de debate
         * esta acao 1002 trata o revisor1 e revisor2
         */
        if ($idAcao == 1002) {
            $iddebate = $_GET["iddebate"];
            if (isset($_POST["revisor1"])) {
                $idrevisor = $_POST["revisor1"];
                if ($this->cadastrarRevisor($idrevisor, $iddebate, 1)) {
                    //sucesso
                }
            }
            if (isset($_POST["revisor2"])) {
                $idrevisor = $_POST["revisor2"];
                $this->cadastrarRevisor($idrevisor, $iddebate, 2);
            }
        }
        // atualiza para o indice 2 - corresponde a visibilidade parcial
        if ($idAcao == 1003) {
            $iddebate = $_GET["idgrupo"];
            $this->atualizarGrupoPublico(2, $idgrupo);
        }
        // atualiza para o indice 2 - corresponde a visibilidade parcial
        if ($idAcao == 1004) {
            $iddebate = $_GET["idgrupo"];
            $this->atualizarGrupoPublico(3, $idgrupo);
        }
        // atualiza para o indice 1 - corresponde a visibilidade publico
        if ($idAcao == 1005) {
            $iddebate = $_GET["idgrupo"];
            $this->atualizarGrupoPublico(1, $idgrupo);
        }
        // atualiza para o indice 1 - corresponde a visibilidade publico
        if ($idAcao == 1006) {
            $iddebate = $_GET["idgrupo"];
            $this->atualizarGrupoBlind(2, $idgrupo);
        }
        // atualiza para o indice 1 - corresponde a visibilidade publico
        if ($idAcao == 1007) {
            $iddebate = $_GET["idgrupo"];
            $this->atualizarGrupoBlind(1, $idgrupo);
        }

        // acao realizada pelo formCadastroDebateGrupo, 
        // idpagina 4
        if ($idAcao == 1021) {

            if (FALSE == $this->cadastrarDebateGrupo()) {

                $_SESSION["error"] = "Erro:#ND0B" . $idAcao;
                $_SESSION["msg"] = null;
            } else {

                $_SESSION["msg"] = "Atualização Realizada!";
                $_SESSION["error"] = null;
            }
        }
        // acao realizada pelo formCadastroDebateGrupo, 
        // Acao Sair
        // ocorre na página index
        if ($idAcao == 1022) {

            session_destroy();
            unset($_SESSION);
            $this->verificaLogon();
        }

        if ($idAcao == 1031) {

            $senha = $_SESSION["senha"];
            $email = $_SESSION["login"];
            $idusuario = $_SESSION["idusuario"];

            if ((isset($_POST["password"])) && (!empty($_POST["password"]))) {
                $senha = $_POST["password"];
            }

            if ((isset($_POST["email"])) && (!empty($_POST["email"]))) {
                $email = $_POST["email"];
            }

            if ((isset($_POST["email"])) || ($_POST["password"])) {
                if ($this->atualizarUsuario($idusuario, $_POST["primeironome"], $_POST["sobrenome"], $email, $senha)) {
                    $_SESSION["msg"] = "Informações Atualizadas!";
                    $_SESSION["error"] = null;
                    $this->efetuarLogin($email, $senha, $_GET["idpagina"]); //vai redirecionar para a mesma pagina que solicitou
                } else {
                    $_SESSION["error"] = "Erro:#CADUEM" . $idAcao;
                    $_SESSION["msg"] = null;
                }
            }
//            if (isset($_POST["senha"]) and (!empty(trim($_POST["senha"]))) ) {
//                if (FALSE == $this->atualizarUsuario($_GET["idusuario"], $_POST["primeironome"], $_POST["sobrenome"], $_POST["emailatual"],$_POST["senha"] )) {
//                    $_SESSION["error"] = "Erro:#CADUSE" . $idAcao;
//                    $_SESSION["msg"] = null;
//                } else {
//                    $_SESSION["msg"] = "Informações Atualizadas!";
//                    $_SESSION["error"] = null;
//                }
//            }
        }

        //     print_r($_SESSION);
        //     var_dump($_SESSION);
        // pagina principal || idpagina=8
        //Editar ou cadastrar pos inicial
        if ($idAcao == 2001) {

            if (FALSE == $this->recuperarArgumentos($_GET["idtese"], $_GET["iddebate"], $_GET["idargumento"])) {
                if (FALSE == $this->cadastrarPosicionamentoInicial($_POST["editor"], $_GET["idtese"], $_GET["idargumentador"])) {
                    $_SESSION["error"] = "Erro:#ND0A" . $idAcao;
                    $_SESSION["msg"] = null;
                } else {
                    $_SESSION["msg"] = "Registo Realizado!";
                    $_SESSION["error"] = null;
                }
            } else {
                if (FALSE == $this->atualizarPosicionamentoInicial($_GET["idargumento"], $_POST["editor"])) {
                    $_SESSION["error"] = "Erro:#ND0B" . $idAcao;
                    $_SESSION["msg"] = null;
                } else {
                    $_SESSION["msg"] = "Atualização Realizada!";
                    $_SESSION["error"] = null;
                }
            }
        }

        // pagina principal || idpagina=8
        //Editar ou cadastrar Argumento
        if ($idAcao == 2002) {
            //Ação de edição
            if (FALSE == $this->recuperarArgumentos($_GET["idtese"], $_GET["iddebate"], $_GET["idargumento"])) {
                if (FALSE == $this->cadastrarArgumento($_POST["editor"], $_GET["idtese"], $_GET["idargumentador"])) {
                    $_SESSION["error"] = "Erro:#ND0A" . $idAcao;
                    $_SESSION["msg"] = null;
                } else {
                    $_SESSION["msg"] = "Registo Realizado!";
                    $_SESSION["error"] = null;
                }
            } else {
                if (FALSE == $this->atualizarArgumento($_GET["idargumento"], $_POST["editor"])) {
                    $_SESSION["error"] = "Erro:#ND0B" . $idAcao;
                    $_SESSION["msg"] = null;
                } else {
                    $_SESSION["msg"] = "Atualização Realizada!";
                    $_SESSION["error"] = null;
                }
            }
        }

        // pagina principal || idpagina=8
        //Editar ou cadastrar revisao
        if ($idAcao == 2003) {
            //Ação de edição
            if (false == $this->recuperarRevisao($_GET["idrevisor"], $_GET["idargumento"])) {
                if (false == $this->cadastrarRevisao($_POST["editor"], $_GET["idrevisor"], $_GET["idargumento"])) {
                    $_SESSION["error"] = "Erro:#ND0A" . $idAcao;
                    $_SESSION["msg"] = null;
                } else {
                    $_SESSION["msg"] = "Registo Realizado!";
                    $_SESSION["error"] = null;
                }
            } else {
                if (false == $this->atualizarRevisao($_GET["idrevisao"], $_POST["editor"])) {
                    $_SESSION["error"] = "Erro:#ND0B" . $idAcao;
                    $_SESSION["msg"] = null;
                } else {
                    $_SESSION["msg"] = "Atualização Realizada!";
                    $_SESSION["error"] = null;
                }
            }
        }

        // pagina principal || idpagina=8
        //Editar ou cadastrar replica
        if ($idAcao == 2004) {
            //Ação de edição
            if (FALSE == $this->recuperaReplicas($_GET["idargumentador"], $_GET["idrevisao"])) {
                if (FALSE == $this->cadastrarReplica($_POST["editor"], $_GET["idrevisao"], $_GET["idargumentador"])) {
                    $_SESSION["error"] = "Erro:#ND0A" . $idAcao;
                    $_SESSION["msg"] = null;
                } else {
                    $_SESSION["msg"] = "Registo Realizado!";
                    $_SESSION["error"] = null;
                }
            } else {
                if (FALSE == $this->atualizarReplica($_GET["idargumentador"], $_GET["idrevisao"], $_POST["editor"])) {
                    $_SESSION["error"] = "Erro:#ND0B" . $idAcao;
                    $_SESSION["msg"] = null;
                } else {
                    $_SESSION["msg"] = "Atualização Realizada!";
                    $_SESSION["error"] = null;
                }
            }
        }

        // pagina principal || idpagina=8
        //Editar ou cadastrar replica
        if ($idAcao == 2005) {
            //Ação de edição
            if (FALSE == $this->recuperarPosicionamentos($_GET["idtese"], $_GET["iddebate"])) {
                if (FALSE == $this->cadastrarPosicionamentoFinal($_POST["editor"], $_GET["idtese"], $_GET["idargumentador"])) {
                    $_SESSION["error"] = "Erro:#ND0A" . $idAcao;
                }
            } else {
                if (FALSE == $this->atualizarPosicionamentoFinal($_GET["idtese"], $_GET["idargumentador"], $_POST["editor"])) {
                    $_SESSION["error"] = "Erro:#ND0B" . $idAcao;
                } else {
                    $_SESSION["msg"] = "Atualização Realizada!";
                }
            }
        }

        // pagina principal || idpagina=8
        //cadastrar tese
        if ($idAcao == 2006) {
            //Ação de edição
            if (FALSE == $this->cadastrarTese($_POST["tese"], NULL, $_GET["idgrupo"], $_POST["alias"])) {
                $_SESSION["error"] = "Erro:#ND0A" . $idAcao;
            } else {
                $_SESSION["msg"] = "Cadastro Realizado!";
            }
        }

        // pagina principal || idpagina=8
        //exclusao tese
        if ($idAcao == 2007) {
            //Ação de edição
            if (FALSE == $this->excluirTese($_GET["idtese"])) {
                $_SESSION["error"] = "Erro:#ND0A" . $idAcao;
            } else {
                $_SESSION["msg"] = "Exclusão Realizada!";
            }
        }

        // pagina principal || idpagina=8
        // edicao do cronograma
        // pagina principal || idpagina=8
        // Editar ou cadastrar cronograma
        if ($idAcao == 2008) {
            //Ação de edição
            if (FALSE == $this->recuperarCronogramaPorGrupo($_GET["idgrupo"])) {

                if (FALSE == $this->cadastrarCronograma($_GET["idgrupo"], $_POST["teseini"], $_POST["tese"], $_POST["argumentoini"], $_POST["argumento"], $_POST["revisaoini"], $_POST["revisao"], $_POST["replicaini"], $_POST["replica"], $_POST["posfinalini"], $_POST["posfinal"], $_POST["reflexao"])) {
                    $_SESSION["error"] = "Erro:#CADCRO" . $idAcao;
                    $_SESSION["msg"] = null;
                } else {
                    $_SESSION["msg"] = "Registo Realizado!";
                    $_SESSION["error"] = null;
                }
            } else {

                if (FALSE == $this->atualizarCronograma($_GET["idgrupo"], $_POST["teseini"], $_POST["tese"], $_POST["argumentoini"], $_POST["argumento"], $_POST["revisaoini"], $_POST["revisao"], $_POST["replicaini"], $_POST["replica"], $_POST["posfinalini"], $_POST["posfinal"], $_POST["reflexao"])) {
                    $_SESSION["error"] = "Erro:#ATCRO" . $idAcao;
                    $_SESSION["msg"] = null;
                } else {
                    $_SESSION["msg"] = "Registo Atualizado!";
                    $_SESSION["error"] = null;
                }
            }
        }
    }

    function cadastrarDebateGrupo() {

        $erro = false;
        $_SESSION['error'] = null;
        $_SESSION['MSG'] = null;
        $login = $_SESSION['login'];
        $senha = $_SESSION['senha'];
        $idpagina = 4; // com isso esta funcao será chamada , pois a pagina 4 corresponde ao form do cadastro de grupo de debate
        $link = array("idpagina" => $idpagina, "login" => $login);


        if (isset($_POST['titulo'])) { //post foi enviado
            if ((is_null($_POST['titulo'])) or ( (trim($_POST['titulo'])) == '')) {
                $_SESSION['error'] = "Erro: Todos os campos devem ser preenchidos!!";
            } elseif ((is_null($_POST['dataini'])) or ( (trim($_POST['dataini'])) == '')) {
                $_SESSION['error'] = "Erro: Todos os campos devem ser preenchidos!!";
            } elseif ((is_null($_POST['datafim'])) or ( (trim($_POST['datafim'])) == '')) {
                $_SESSION['error'] = "Erro: Todos os campos devem ser preenchidos!!";
            } else {
                $usuario = $this->recuperarUsuario($login);



                $idgrupoCadastrado = $this->cadastrarGrupo($_POST['titulo'], $_POST['dataini'], $_POST['datafim'], $usuario['idusuario']);
                // die("aa!!!!!:".$idgrupoCadastrado);
                $iddebateCadastrado = $this->cadastrarDebate($idgrupoCadastrado, $usuario['idusuario'], 0);
                
                if ($iddebateCadastrado != false) {
                    if (($this->cadastrarArgumentador($usuario['idusuario'], $iddebateCadastrado)) && ($this->cadastrarMediador($usuario['idusuario'], $iddebateCadastrado))) {
                        $_SESSION['msg'] = "Cadastro com Sucesso!";
                        $_SESSION['error'] = null;
                        return TRUE;
                    } else {
                        $_SESSION['error'] = "Não foi possíveel realizar o Cadastro, Erro CADDEB01.AR-ME ";
                        $_SESSION['MSG'] = null;
                        return FALSE;
                    }
                } else {
                    die("Erro CADDEB02: Contate com urgencia o adminstrador ,informando o codigo de erro , pelo contato: ramonwaia@gmail.com"); // não consegue encontrar debate
                    return FALSE;
                }
                //echo "Cadastro realizado Com Sucesso!";      
            }
        }
    }

    function registrarNovoUsuario($nome, $sobrenome, $email, $grupo) {

       if( $this->recuperarUsuario($email))
       {
            return false;
       }

       else
       {
            return $this->cadastrarUsuario($nome, $sobrenome, $email, "12345", $grupo );
       }

        // $iddebate = $this->cadastrarDebate(1, $user['idusuario'], 0); 9999

        // if ($this->cadastrarMediador($user['idusuario'], $iddebate)) {
        //     return true;
        // } else {
        //     return false;
        // }
    }

    function listBoxRevisor($idgrupo, $iddebate, $nomevar, $idpagina, $idacao) {

        $idusuario = 0;
        $nomecompleto = "indefinido";
        $revisores = FALSE;

        $colecao = $this->recuperarArgumentadoresPorGrupo($idgrupo);

        if (strcmp($nomevar, "revisor1") == 0) {
            $revisores = $this->recuperarRevisores($iddebate, 1);
        }
        if (strcmp($nomevar, "revisor2") == 0) {
            $revisores = $this->recuperarRevisores($iddebate, 2);
        }

        if ($revisores != FALSE) {
            $idrevisor = $revisores[0]["idusuario"];
            $nomecompleto = $revisores[0]["nomecompleto"];
        }


        echo "
        <form id='listboxRevisor' method='POST' action='menu.php?idpagina=$idpagina&idAcao=$idacao&iddebate=$iddebate&idgrupo=$idgrupo' >
            <select name='$nomevar' onchange='this.form.submit()'>";
        echo "<option value='$idrevisor'>$nomecompleto</option>";
        foreach ($colecao as $arg) {
            $idusuario = $arg["idusuario"];
            $nomecompleto = $arg["nomecompleto"];

            if ($idusuario != $idrevisor) {
                echo "<option value='$idusuario'>$nomecompleto</option>";
            }
        }
        if ($revisores != FALSE) {
            echo "<option value='0'> - REMOVER</option>";
        }
        echo "                
            </select>
        </form>
                
         ";
    }

//
//        function listBoxRevisor($idgrupo, $iddebate, $nomevar, $idpagina, $idacao) {
//
//        $idusuario = 0;
//        $nomecompleto = "indefinido";
//        $revisores = FALSE;
//
//        $colecao = $this->recuperarArgumentadoresPorGrupo($idgrupo);
//
//
//        if (strcmp($nomevar, "revisor1") == 0) {
//            $revisores = $this->recuperarRevisores($iddebate, 1);
//        }
//        if (strcmp($nomevar, "revisor2") == 0) {
//            $revisores = $this->recuperarRevisores($iddebate, 2);
//        }
//
//        if ($revisores != FALSE) {
//            $idrevisor = $revisores[0]["idusuario"];
//            $nomecompleto = $revisores[0]["nomecompleto"];
//        }
//
//
//        echo "
//        <form id='listboxRevisor' method='POST' action='menu.php?idpagina=$idpagina&idAcao=$idacao&iddebate=$iddebate&idgrupo=$idgrupo' >
//            <select name='$nomevar' onchange='this.form.submit()'>";
//        echo "<option value='$idrevisor'>$nomecompleto</option>";
//        foreach ($colecao as $arg) {
//            $idusuario = $arg["idusuario"];
//            $nomecompleto = $arg["nomecompleto"];
//
//            if ($idusuario != $idrevisor) {
//                echo "<option value='$idusuario'>$nomecompleto</option>";
//            }
//        }
//        if ($revisores != FALSE) {
//            echo "<option value='0'> - REMOVER</option>";
//        }
//        echo "                
//            </select>
//        </form>
//                
//         ";
//    }
    //(`idrevisao`, `revisao`, `revisor_idrevisor`, `argumento_idargumento`) VALUES
    function cad($idrevisao, $revisao, $revisor_idrevisor, $argumento_idargumento) {
        $conexao = new Conexao();
        $sql = "insert into revisao (idrevisao,revisao,revisor_idrevisor,argumento_idargumento)
                values ($idrevisao, $revisao,$revisor_idrevisor,$argumento_idargumento)";

        $resultado = mysqli_query( $conexao->conectado(), $sql); //nao uso resultado
        mysqli_errno($conexao->conectado()) . ": " . mysqli_error($conexao->conectado()) . "  ......<br>";
        return $resultado;
    }

    /*
     * A função é remover os debates que não são do grupo desejado, passado por parametro
     * retorar apenas os debateIndividuais do grupo desejado
     * @param1 array de Debates individuais
     * @param2 idgrupo 
     * @return array de Debates individuais
     */

    function filtrarDebatesParticipantesPorGrupo($colecaoDebates, $idgrupo) {

        $debates = null;
        foreach ($colecaoDebates as $debate) {

            if ($debate["idgrupo"] == $idgrupo) {
                $debates[] = $debate;
            }
        }

        return $debates;
    }

    /*
     * A função é formtar uma String com nome+sobrenome e email de todos usuarios
     * retorar apenas os debateIndividuais do grupo desejado
     *  "Ramon Maia - raamon@gmail.com",
      "Sabrnia Panceri [sabrina.panceri@gmail.com]",
      "Sabaio Silva Cordeiro sabrina.panceri@gmail.com",
      "BASIC",
      "C",
      "C++",
      "Clojure",
      "COBOL",
      "ColdFusion",
      "Erlang",
      "Fortran",
      "Groovy",
      "Haskell",
      "Java",
      "JavaScript",
      "Lisp",
      "Perl",
      "PHP",
      "Python",
      "Ruby",
      "Scala",
      "Scheme"
     * @return String formatada 
     */

    function formatarAutoCompleteUsuarioEmail() {

        $usuarios = $this->recuperarTodosUsuarios();

        $texto = "";

        foreach ($usuarios as $usuario) {
            $texto .= "\"" . $usuario["label"] . "\",";
        }

        // remobver a última virgula
        $texto2 = substr_replace($texto, "", -1);

        return trim($texto2);
    }

    /*
     * A função é remover os debates que não estão ativos , ou seja, excluir os debates ativo = 0;
     * 
     * @param1 array de Debates individuais
     * @param2 ativo
     * @return array de Debates individuais
     */

    function filtrarDebatesAtivos($colecaoDebates, $ativo = 0) {

        foreach ($colecaoDebates as $debate) {

            if ($debate["ativo"] == $ativo) {
                $debatesAtivos[] = $debate;
            }
        }

        return $debatesAtivos;
    }


    function removerPaginaMediador($colecaoDebates, $idusuario_mediador) {


        // print_r($colecaoDebates);
        // echo "<br>";
        // print_r($idusuario_mediador);
        // die(" aaaaa");


        foreach ($colecaoDebates as $debate) {

            if ($debate["idusuario"] != $idusuario_mediador) {
                $debatesAtivos[] = $debate;
            }
        }
        return $debatesAtivos;
    }



    /*
     * A função é remover os debates que não são do grupo desejado, passado por parametro
     * retorar apenas os debateIndividuais do grupo desejado
     * @param1 array de Debates individuais
     * @param2 idgrupo 
     * @return array de Debates individuais
     */

    function verificarMediadorColecaoDebate($login, $password, $colecaoDebates) {

        foreach ($colecaoDebates as $debate) {
            $this->verificarPerfil($login, $password, $debate["iddebate"]);
            if ($this->perfilMediador === 1) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /*
     * xxxA função é remover os debates que não são do grupo desejado, passado por parametro
     * xxxxretorar apenas os debateIndividuais do grupo desejado
     * @param1 array de Grupos como Mediador
     * @param2 array de Grupos como Participante
     * @param2 int idGrupo
     * @return boolean
     */

    function verificarPertenceColecaoGrupos($g1, $g2, $idgrupo) {

        if (is_array($g1)) {
            foreach ($g1 as $grupo) {
                if ($grupo["idgrupo"] == $idgrupo) {
                    return TRUE;
                }
            }
        }
        if (is_array($g2)) {
            foreach ($g2 as $grupo) {
                if ($grupo["idgrupo"] == $idgrupo) {
                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    function enviarEmailComDadosRecuperados($email) {

        $dados = $this->recuperarUsuario($email);

        $nome = $dados['nomeCompleto'];
        $email = $dados['email'];
        $senha = $dados['senha'];
        $textoCorpoEmail = "Prezado(a) $nome, <br>Este é um e-mail automático gerado pelo sistema Debate de Teses (<a href='$this->paginaLogin'>acesse</a>). <br>  
                                            A recuperação de senha foi realizada com sucesso!<br><br>
                                            <b>Seus dados cadastrais:</b><br>
                                            Nome: $nome <br>
                                            E-mail: $email<br>     
                                            Senha: $senha <br><br>
                                            
                                            Att,<br>
                                            Administrador.
                                            <hr>  
                                            <p style='font-size:10px'><i>Para mais informações, entre em contato com os responsáveis pelo Sistema
                                            Debate de Teses - Ramon R. M. Vieira Jr (ramonwaia@gmail.com - <a href='http://buscatextual.cnpq.br/buscatextual/visualizacv.do?metodo=apresentar&id=K4274841T6'>Currículo Lattes</a>) 
                                                ou Crediné Silva de Menezes (credine@gmail.com - <a href='http://buscatextual.cnpq.br/buscatextual/visualizacv.do?metodo=apresentar&id=K4789637U2'>Currículo Lattes</a>)  </i></p>";

        $ee = new EnvioEmail($email, "Recuperação de senha - Sistema Debate de Teses", $textoCorpoEmail);
        if ($ee->enviar()) {
            return TRUE;
            //e-mail enviado com sucesso
        } else {
            return FALSE;
            //$msg = "Erro inesperado: 900"; // e-mail enviado
        }
    }

}

/*
  $textoCorpoEmail = "Confirmado <br>  Ramon Maia  /n  Ramon Jr  \n Ramon Vieira";
  echo("ramon");
  //$ee = new EnvioEmail($dadosInterface['email'], "Participação Debate de Teses - Confirmação", $textoCorpoEmail);
  $ee = new EnvioEmail("rjuunior@yahoo.com.br", "Confirmação", $textoCorpoEmail);
  echo $ee->enviar();




  //pegar o nome do arquivo
  $arrStr = explode("/", $_SERVER['SCRIPT_NAME'] );
  $arrStr = array_reverse($arrStr );
  echo("Script is " . $arrStr[0]);


 */
?>
