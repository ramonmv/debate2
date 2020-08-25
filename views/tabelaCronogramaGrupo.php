<div class="col-xs-22 col-sm-15">    
    <div class="box">
        <div class="box-header">           
            <div class="box-name">
                <i class="fa fa-table"></i>
                 <?php echo $dd->grupo['titulo']; ?> 
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
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Atividade</th>
                        <th>Prazo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Apresentação do Argumentador</td>
                        <td> <?php echo $dd->imprime(date('d/m/Y', strtotime($dd->conograma["apresentacao"])), null, $link, $dd->paginaLogin, 0) ?> </td>
                    </tr>
                    <tr>
                        <td>Disponiblização das Teses do Debate</td>
                        <td> <?php echo $dd->imprime(date('d/m/Y', strtotime($dd->conograma["tese"])), null, $link, $dd->paginaLogin, 0) ?> </td>
                    </tr>
                    <tr>
                        <td>Posicionamento Individual sobre as Teses (argumento)</td>
                        <td> <?php echo $dd->imprime(date('d/m/Y', strtotime($dd->conograma["argumento"])), null, $link, $dd->paginaLogin, 0) ?> </td>
                    </tr>
                    <tr>
                        <td>Posicionamento dos Revisores (revisão)</td>
                        <td> <?php echo $dd->imprime(date('d/m/Y', strtotime($dd->conograma["revisao"])), null, $link, $dd->paginaLogin, 0) ?> </td>
                    </tr>
                    <tr>
                        <td>Contra-Argumentação do Autor (réplica)</td>
                        <td> <?php echo $dd->imprime(date('d/m/Y', strtotime($dd->conograma["replica"])), null, $link, $dd->paginaLogin, 0) ?> </td>
                    </tr>
                    <tr>
                        <td>Posicionamento Final (conclusão)</td>
                        <td> <?php echo $dd->imprime(date('d/m/Y', strtotime($dd->conograma["posfinal"])), null, $link, $dd->paginaLogin, 0) ?> </td>
                    </tr>
                    <tr>
                        <td>Reflexão sobre a Atividade</td>
                        <td> <?php echo $dd->imprime(date('d/m/Y', strtotime($dd->conograma["reflexao"])), null, $link, $dd->paginaLogin, 0) ?> </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
