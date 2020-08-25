<?php

class ApresentacaoSistema {

    public $apresentaConvite; //array

    function __construct() {
        
    }

    /*
     * 
     * $dados['nomeMediador']
     * $dados['tituloGrupo']
     * $dados['nomeCompleto']
     * $dados['ok_envio_email']
     * $dados['ok_cadastroMediador']
     * $dados['ok_cadastroUsuario']
     * $dados['ok_cadastroArgumentador']
     * $dados['ok_cadastroDebate']
     * $dados['usuarioPertenceGrupo']
     */

    function apresentaconvite($dados) {

        /*
          $msg_usuario_cadastrado = "Usu�rio Existente: {$dados['nomeCompleto']} registrado com e-mail: {email do usuario}";
          $msg_usuario_cadastrado_nogrupo = "Usu�rio J� pertence ao Grupo: {$dados['tituloGrupo']}";
          $msg_email_nao_enviado = "Erro no servidor: N�o foi possivel enviar um e-mail para o usu�rio informando a participa��o no debate.";

          $confirmacao_ok = "Convite realizsdo com sucesso";
          $confirmacao_nao_ok = "Aten��o: N�o foi poss�vel realizar o convite";

          $msg_usuario_cadastrado_ok = "Usu�rio: {$dados['nomeCompleto']} foi registrado com e-mail: {$dados['email']}";
          $msg_usuario_cad_argumentador = "Usu�rio registrado como argumentador com sucesso!";
          $msg_usuario_pagina_debate = "P�gina {$dados['nomeCompleto']} foi criado com sucesso!" ;
          $msg_usuario_pagina_debate = "Mediador {$dados['nomeMediador']} vinculado � P�gina {$dados['nomeCompleto']} com sucesso!" ;
          $msg_email_enviado_ok = "Foi enviado um e-mail para este usu�rio comunicando a sua participa��o neste Grupo de Debate" ;
         */
        ?>


        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-content">
                        <p class="page-header">Leia as informações abaixo</p>

                        <p><pre><?php
                        
                        isset($dados['ok_cadastroUsuario'])     AND print($dados["ok_cadastroUsuario"]."<br>");
                        isset($dados['usuarioPertenceGrupo'])   AND  print($dados["usuarioPertenceGrupo"]."<br>");
                        isset($dados['ok_cadastroDebate'])      AND  print($dados["ok_cadastroDebate"]."<br>");
                        isset($dados['ok_cadastroArgumentador'])AND  print($dados["ok_cadastroArgumentador"]."<br>");
                        isset($dados['ok_cadastroMediador'])    AND  print($dados["ok_cadastroMediador"]."<br>");
                        isset($dados['ok_envio_email'])         AND  print($dados["ok_envio_email"]."<br>");

                            ?></pre></p>

                    </div>
                </div>
            </div>
        </div>
        <?php
    }

}
?>

