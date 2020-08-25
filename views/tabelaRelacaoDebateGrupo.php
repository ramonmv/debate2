
<div class = "col-xs-22 col-sm-15">
    <div class = "box">
        <div class = "box-header">
            <div class = "box-name">
                <i class = "fa fa-table"></i>
                <span>Relação dos Grupos de Debates </span>
            </div>
            <div class = "box-icons">
                <a class = "collapse-link">
                    <i class = "fa fa-chevron-up"></i>
                </a>
                <a class = "expand-link">
                    <i class = "fa fa-expand"></i>
                </a>
                <a class = "close-link">
                    <i class = "fa fa-times"></i>
                </a>
            </div>
            <div class = "no-move"></div>
        </div>
        <div class = "box-content">
            <p></p>
            <table class = "table table-striped">
                <thead>
                    <tr>
                        <th>Grupo de Debates</th>
                        <th>Período</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($dd->grupos as $grupo) {

                        $link = array("idgrupo" => $grupo['idgrupo'], "idpagina" => 14);

                        if ($grupo["publico"] != 3) {
                            ?>

                            <tr>
                                <td><?php echo $dd->imprime($grupo["titulo"], null, $link, $dd->paginaLogin, 1); ?> </td>
                                <td><?php echo $dd->imprime(date('d/m/Y', strtotime($grupo["dataini"])), null, $link, $dd->paginaLogin, 0) . " à " . $dd->imprime(date('d/m/Y', strtotime($grupo["datafim"])), null, $link, $dd->paginaIndex, 0); ?></td>
                            </tr>


                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>