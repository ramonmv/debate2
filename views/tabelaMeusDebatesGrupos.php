
<div class="col-xs-22 col-sm-15">
    <div class="box">     
        <div class="box-header">            
            <div class="box-name">
                <i class="fa fa-table"></i>
                <?php echo "Meus Debates como Mediador"; ?> 
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
        <div class="box-content">
            <p></p>

            <?php
            if (count($dd->grupos) > 0) {
                ?>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th> Debates</th>
                            <th> Novo Usuário</th>
                            <th> Teses</th>
                            <th> Cronograma</th>
                            <th> Log</th>
                            <th> Rev.  <i>Blind</i></th>
                            <th> Público</th>
                            <th> Excluir</th>                     
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($dd->grupos as $grupo) {
                            $link = array("idgrupo" => $grupo['idgrupo'], "idpagina" => 1, "grupo_titulo" => $grupo['titulo']);
                            $linkCrono = array("idgrupo" => $grupo['idgrupo'], "idpagina" => 13, "grupo_titulo" => $grupo['titulo']);
                            $linkTese = array("idgrupo" => $grupo['idgrupo'], "idpagina" => 7, "grupo_titulo" => $grupo['titulo']);
                            $linkConvite = array("idgrupo" => $grupo['idgrupo'], "idpagina" => 2, "grupo_titulo" => $grupo['titulo']);
                            $linkLog = array("idgrupo" => $grupo['idgrupo'], "idpagina" => 3, "grupo_titulo" => $grupo['titulo']);
                            $linkExclusao = array("idgrupo" => $grupo['idgrupo'], "idpagina" => 9);
                            ?>
                            <tr>
                                <td class="divCtrlinhaDesc1" style="border-right:none !important;"> <img src="img/iconDebate2.gif" style="width:10px;height:7px;vertical-align:middle;"  border="0" /> <?php echo $dd->imprime($grupo["titulo"], null, $link, $dd->paginaMenu, 1); ?></td>
                                <td class="divCtrlinha"><img  src="img/mail2.jpg"  border="0" align="absbottom" /><?php echo "&nbsp;" . $dd->imprime(" Convidar", null, $linkConvite, $dd->paginaMenu, 1); ?></td>
                                <td class="divCtrlinha"><img  src="img/page_16.png"  border="0" align="absbottom" /> <?php echo "" . $dd->imprime("Criar teses", null, $linkTese, $dd->paginaMenu, 1); ?> </td>
                                <td class="divCtrlinha"><img  src="img/calendar2.png"  border="0" align="absbottom" /> <?php echo "" . $dd->imprime("Editar", null, $linkCrono, $dd->paginaMenu, 1); ?> </td>
                                <td class="divCtrlinha"><img  src="img/log.jpg"  border="0" align="absbottom" /> <?php echo "" . $dd->imprime("Ver", null, $linkLog, $dd->paginaMenu, 1); ?> </td>
                                <td class="divCtrlinha"><img  src="img/update2.png"  style="width:13px;height:13px;" border="0" align="absbottom" /> <?php abilitaBlind($grupo['blind'], $grupo['idgrupo'], $dd); ?> </td>
                                <td class="divCtrlinha"><img  src="img/update2.png"  style="width:13px;height:13px;" border="0" align="absbottom" /> <?php abilitaPublico($grupo['publico'], $grupo['idgrupo'], $dd); ?> </td>
                                <td class="divCtrlinha"><img  src="img/iconDelete3.png"  style="width:13px;height:13px;"  border="0" align="absbottom" /> <?php echo "" . $dd->imprime("Excluir", null, $linkExclusao, $dd->paginaMenu, 1); ?> </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "<em>Não estou participando de nenhum debate como Mediador.</em> <br>";
            }
            ?>
        </div>
    </div>
</div>




