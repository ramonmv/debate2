<?php
$login = $_SESSION['login'];
$senha = $_SESSION['senha'];
$idgrupo = $_GET["idgrupo"];

$dd = new sistemaDebate();
$datas = $dd->recuperarCronogramaPorGrupo($idgrupo,TRUE);

//print_r($_POST);
?>
<div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-plus"></i>
                    <span>Novo Debate</span>
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
                <h4 class="page-header"> Faça a edição dos períodos (data início e fim) de postagem para cada fase abaixo: </h4>

                <form class="form-horizontal" role="form" name="cadastro" id="defaultForm"  method="post" action="<?php echo "menu.php?idpagina=13&idAcao=2008&idgrupo=$idgrupo"; ?>" >
                    <fieldset>        
                        <div class="form-group has-error has-feedback">
                            <label class="col-sm-2 control-label">Argumentação</label>
                            <div class="col-sm-2">
                                <input type="text" id="input_date3" class="form-control" placeholder="Data Início" name="argumentoini" value="<?php  echo $datas["argumentoini"];  ?>">
                                <span class="fa fa-calendar txt-danger form-control-feedback"></span>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" id="input_date4" class="form-control" placeholder="Data Fim" name="argumento" value="<?php  echo $datas["argumento"];  ?>">
                                <span class="fa fa-calendar txt-danger form-control-feedback"></span>
                            </div>
                        </div> 
                        <div class="form-group has-error has-feedback">
                            <label class="col-sm-2 control-label">Revisão</label>
                            <div class="col-sm-2">
                                <input type="text" id="input_date5" class="form-control" placeholder="Data Início" name="revisaoini" value="<?php  echo $datas["revisaoini"];  ?>">
                                <span class="fa fa-calendar txt-danger form-control-feedback"></span>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" id="input_date6" class="form-control" placeholder="Data Fim" name="revisao" value="<?php  echo $datas["revisao"];  ?>">
                                <span class="fa fa-calendar txt-danger form-control-feedback"></span>
                            </div>
                        </div>   
                        <div class="form-group has-error has-feedback">
                            <label class="col-sm-2 control-label">Réplica</label>
                            <div class="col-sm-2">
                                <input type="text" id="input_date7" class="form-control" placeholder="Data Início" name="replicaini" value="<?php  echo $datas["replicaini"];  ?>">
                                <span class="fa fa-calendar txt-danger form-control-feedback"></span>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" id="input_date8" class="form-control" placeholder="Data Fim" name="replica" value="<?php  echo $datas["replica"];  ?>">
                                <span class="fa fa-calendar txt-danger form-control-feedback"></span>
                            </div>
                        </div>   
                        <div class="form-group has-error has-feedback">
                            <label class="col-sm-2 control-label">Pos. Final</label>
                            <div class="col-sm-2">
                                <input type="text" id="input_date9" class="form-control" placeholder="Data Início" name="posfinalini" value="<?php  echo $datas["posfinalini"];  ?>">
                                <span class="fa fa-calendar txt-danger form-control-feedback"></span>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" id="input_date10" class="form-control" placeholder="Data Fim" name="posfinal" value="<?php  echo $datas["posfinal"];  ?>">
                                <span class="fa fa-calendar txt-danger form-control-feedback"></span>
                            </div>
                        </div>    
                        <div class="form-group has-error has-feedback">
                            <label class="col-sm-2 control-label">Reflexão</label>
                            <div class="col-sm-2">
                                <input type="text" id="input_date11" class="form-control" placeholder="Data Fim" name="reflexao" value="<?php  echo $datas["reflexao"];  ?>">
                                <span class="fa fa-calendar txt-danger form-control-feedback"></span>
                            </div>
                        </div>                            
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary btn-label-left">
                                    <span><i class="fa fa-plus-square"></i></span>
                                    Confirmar Cronograma
                                </button>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
//if ($erroCampoVazio) {
//    echo $_SESSION['erroCampoVazio'];
//}
?>


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
        
        // $('#input_date1').datepicker({dateFormat: "dd/mm/yy"});
        $('#input_date2').datepicker({dateFormat: "dd/mm/yy"});
        $('#input_date3').datepicker({dateFormat: "dd/mm/yy"});
        $('#input_date4').datepicker({dateFormat: "dd/mm/yy"});
        $('#input_date5').datepicker({dateFormat: "dd/mm/yy"});
        $('#input_date6').datepicker({dateFormat: "dd/mm/yy"});
        $('#input_date7').datepicker({dateFormat: "dd/mm/yy"});
        $('#input_date8').datepicker({dateFormat: "dd/mm/yy"});
        $('#input_date9').datepicker({dateFormat: "dd/mm/yy"});
        $('#input_date10').datepicker({dateFormat: "dd/mm/yy"});
        $('#input_date11').datepicker({dateFormat: "dd/mm/yy"});     

        // Initialize datepicker
        // $('#input_date1').datepicker({setDate: new Date()});
        $('#input_date2').datepicker({setDate: new Date()});
        $('#input_date3').datepicker({setDate: new Date()});
        $('#input_date4').datepicker({setDate: new Date()});
        $('#input_date5').datepicker({setDate: new Date()});
        $('#input_date6').datepicker({setDate: new Date()});
        $('#input_date7').datepicker({setDate: new Date()});
        $('#input_date8').datepicker({setDate: new Date()});
        $('#input_date9').datepicker({setDate: new Date()});
        $('#input_date10').datepicker({setDate: new Date()});
        $('#input_date11').datepicker({setDate: new Date()});

               
        
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