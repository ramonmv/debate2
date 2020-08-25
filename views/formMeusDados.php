<?php
$login = $_SESSION['login'];
$senha = $_SESSION['senha'];
$usuario = $dd->recuperarUsuario($login);
$idpagina = $_GET["idpagina"];

if ($_GET["idpagina"] == 5) {
    $titulo = "Para realizar a alteração, preencha seu novo e-mail e confirme ";
}
if ($_GET["idpagina"] == 6) {
    $titulo = "Para realizar a alteração, preencha sua nova senha e confirme ";
}
?>

<div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-plus"></i>
                    <span>Meus Dados</span>
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
                <h4 class="page-header"> <?php echo $titulo; ?>" </h4>

                <form class="form-horizontal" role="form" name="cadastro" id="defaultForm"  method="post" action="<?php echo "menu.php?idpagina=$idpagina&idAcao=1031"; ?>" >
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Primeiro Nome</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" placeholder="Digite apenas seu primeiro nome" data-toggle="tooltip" data-placement="bottom" title="Digite apenas seu primeiro nome" name="primeironome" value="<?php echo $usuario["primeironome"]; ?>">
                            </div>
                        </div>  
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Sobrenome</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" placeholder="Digite seu último sobrenome" data-toggle="tooltip" data-placement="bottom" title="Digite seu último sobrenome" name="sobrenome" value="<?php echo $usuario["sobrenome"]; ?>">
                            </div>
                        </div>  
                        <div class="form-group">
                            <label class="col-sm-2 control-label">E-mail (Atual)</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="emailatual" disabled value="<?php echo $usuario["email"]; ?>"/>
                            </div>                                              
                        </div>  
                        <?php
                        if ($_GET["idpagina"] == 5) {
                            ?>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">E-mail (Novo)</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control"  placeholder="Digite seu novo e-mail" name="email"title="Antes de confirmar a alteração verifique se está correto"  />
                                </div>                                              
                            </div>  
                            <?php
                        }
                        if ($_GET["idpagina"] == 6) {
                            ?>
                            <fieldset>
                                <!--                            <legend>Alteração de senha</legend>-->
                                <h4 class="page-header"> Alteração de senha </h4>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nova senha</label>
                                    <div class="col-sm-2">
                                        <input type="password" class="form-control" name="password" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Confirme a senha</label>
                                    <div class="col-sm-2">
                                        <input type="password" class="form-control" name="confirmPassword" />
                                    </div>
                                </div>
                            </fieldset>
                        <?php } ?>
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">
                                <button type="submit" class="btn btn-primary">Confirmar Alteração</button>
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