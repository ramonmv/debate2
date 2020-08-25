<?php

$dd = new sistemaDebate();

if (isset($_GET['idgrupo'])) {
    $idgrupo = $dd->idgrupo = $_GET['idgrupo'];    
    $g = $dd->recuperarGrupo(    $dd->idgrupo ); // atributo do tipo array da classe atualizado com os dados do Grupo corrente

}

if (isset($_GET['idpagina'])) {
    $idpagina = $_GET['idpagina'];
}

?>
<div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-user-plus"></i>
                    <span>Cadastrar Teses</span>
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
                <h4 class="page-header"> <?php echo "Cadastro de Teses do Grupo de Debate: " . $dd->grupo['titulo']; ?> </h4>

                <form class="form-horizontal" role="form" name="cadastro" id="defaultForm"  method="post" action="<?php echo "menu.php?idgrupo=$idgrupo&idpagina=$idpagina&idAcao=2006"; ?>" >
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Alias (opcional)</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" placeholder="Digite um identificador da tese" data-toggle="tooltip" data-placement="bottom" title="identificador da tese possui o objetivo de auxiliar o mediador recuperar informações associadas a esta tese. | Exemplo: TESE01" name="alias">
                            </div>
                        </div>  
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tese</label>
                            <div class="col-sm-4">
                                <textarea id="editor" style="width:100%" title="Edite sua tese aqui" name="tese">  </textarea>
                            </div>
                        </div>          
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary btn-label-left">
                                    <span><i class="fa fa-clock-o"></i></span>
                                    Cadastrar tese
                                </button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>

    </div>
</div>


<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-users"></i>
                    <span>Relação das Teses do debate: <?php echo $dd->grupo['titulo']; ?> </span>
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
                            <th>Alias</th>
                            <th>Texto da Tese</th>
                            <th>Ação de Exclusão</th>
                        </tr>
                    </thead>

                    <tbody>
<?php
$dd->recuperarTeses($idgrupo);
$teses = $dd->teses;
$link = array("idgrupo" => $idgrupo, "idpagina" => 7,"idAcao" => 2007 ); //ação 2007 de exclusão de tese
foreach ($teses as $tese) {
    $link["idtese"] = $tese["idtese"];
    ?>                                                
                            <tr>
                                <td><?php echo $tese["alias"]; ?></td>
                                <td><?php echo $tese["tese"]; ?></td>
                                <td><?php echo $dd->imprime("Excluir Tese", null, $link, $dd->paginaMenu, 1); ?></td>
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
    // Run Select2 plugin on elements
    function DemoSelect2() {
        $('#s2_with_tag').select2({placeholder: "Select OS"});
        $('#s2_country').select2();
    }
    // Run timepicker
    function DemoTimePicker() {
        $('#input_time').timepicker({setDate: new Date()});
    }
    $(document).ready(function () {
        

        // Create Wysiwig editor for textare
        TinyMCEStart('#wysiwig_simple', null);
        TinyMCEStart('#wysiwig_full', 'extreme');
        // Add slider for change test input length
        FormLayoutExampleInputLength($(".slider-style"));
        // Initialize datepicker
        $('#input_date').datepicker({setDate: new Date()});
        // Load Timepicker plugin
        LoadTimePickerScript(DemoTimePicker);
        // Add tooltip to form-controls
        $('.form-control').tooltip();
        LoadSelect2Script(DemoSelect2);
        // Load example of form validation
        LoadBootstrapValidatorScript(DemoFormValidator);
        // Add drag-n-drop feature to boxes
        WinMove();
    });

</script>

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
