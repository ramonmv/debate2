
<div class="col-xs-22 col-sm-15">
    <div class="box">     
        <div class="box-header">            
            <div class="box-name">
                <i class="fa fa-table"></i>
                <?php echo "Meus Debates como Participante"; ?> 
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
            if (count($dd->gruposDebatesParticipantes) > 0) {
                ?>                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nomes dos Grupos de Debates</th>                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($dd->gruposDebatesParticipantes as $grupo) {
                            $link = array("idgrupo" => $grupo['idgrupo'], "idpagina" => 1, "grupo_titulo" => $grupo['titulo']);
                            $linkConvite = array("idgrupo" => $grupo['idgrupo'], "idpagina" => 2, "grupo_titulo" => $grupo['titulo']);
                            $linkLog = array("idgrupo" => $grupo['idgrupo'], "idpagina" => 3, "grupo_titulo" => $grupo['titulo']);
                            ?>
                            <tr>
                                <td><img src="img/iconDebate2.gif" style="width:10px;height:7px;vertical-align:middle;" border="0" /><?php echo $dd->imprime($grupo["titulo"], null, $link, $dd->paginaMenu, 1); ?></td>
                            </tr>
                            <?php
                        }
                        ?>                        

                    </tbody>
                </table>
                <br>
                <?php
            } else {
                echo "Não estou participando de nenhum debate como Argumentador ou Revisor.";
            }
            ?>
        </div>
    </div>
</div>