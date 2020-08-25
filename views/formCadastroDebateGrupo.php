<?php

$login = $_SESSION['login'];
$senha = $_SESSION['senha'];


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
                <h4 class="page-header"> Preecha os dados para criar um novo Debate </h4>

                <form class="form-horizontal" role="form" name="cadastro" id="defaultForm"  method="post" action="<?php echo "menu.php?idpagina=4&idAcao=1021"; ?>" >
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Titulo</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" placeholder="Digite o Título do Debate" data-toggle="tooltip" data-placement="bottom" title="Título do Debate" name="titulo">
                            </div>
                        </div>  
                       <div class="form-group has-error has-feedback">
                            <label class="col-sm-2 control-label">Data Início</label>
                            <div class="col-sm-2">
                                <input type="text" id="input_date" class="form-control" placeholder="Data" name="dataini">
                                <span class="fa fa-calendar txt-danger form-control-feedback"></span>
                            </div>
                        </div>          
                       <div class="form-group has-error has-feedback">
                            <label class="col-sm-2 control-label">Data Fim</label>
                            <div class="col-sm-2">
                                <input type="text" id="input_date2" class="form-control" placeholder="Data" name="datafim">
                                <span class="fa fa-calendar txt-danger form-control-feedback"></span>
                            </div>
                        </div>    
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary btn-label-left">
                                    <span><i class="fa fa-plus-square"></i></span>
                                    Cadastrar Novo Debate
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
if ($erroCampoVazio) {
    echo $_SESSION['erroCampoVazio'];
}
?>


<script type="text/javascript">
// Run Select2 plugin on elements
function DemoSelect2(){
	$('#s2_with_tag').select2({placeholder: "Select OS"});
	$('#s2_country').select2();
}
// Run timepicker
function DemoTimePicker(){
	$('#input_time').timepicker({setDate: new Date()});
}
$(document).ready(function() {
	// Create Wysiwig editor for textare
	TinyMCEStart('#wysiwig_simple', null);
	TinyMCEStart('#wysiwig_full', 'extreme');
	// Add slider for change test input length
	FormLayoutExampleInputLength($( ".slider-style" ));
	// Initialize datepicker
        
        $('#input_date').datepicker({dateFormat: "dd/mm/yy"});
        $('#input_date2').datepicker({dateFormat: "dd/mm/yy"});
        
        
	$('#input_date').datepicker({setDate: new Date()});
        $('#input_date2').datepicker({setDate: new Date()});
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