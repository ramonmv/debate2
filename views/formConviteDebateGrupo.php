<?php
$dd = new sistemaDebate();
$textoAutoComplete = $dd->formatarAutoCompleteUsuarioEmail();
$idpagina = $_GET["idpagina"];
$idgrupo = $_GET["idgrupo"];

$dd->recuperarGrupo($idgrupo);

?>

<div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-user-plus"></i>
                    <span>Convidar novos participantes</span>
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
                <h4 class="page-header"> <?php echo "Convite para participar do Debate: <em>" . $dd->grupo['titulo']; ?> </em></h4>

<!--                <p class="small">  Para convidar um usuário que já possui registro no sistema de debate de teses, precisa-se apenas do e-mail do participante </p>
                <p class="small">  Para convidar um usuário que <u><b>não</b></u> possui registro no sistema de debate de teses, precisa-se preencher todos os dados do particiante</p>-->

                <form class="form-horizontal" role="form" name="cadastro" id="defaultForm"  method="post" action="<?php echo "menu.php?idgrupo=$idgrupo&idpagina=$idpagina&idAcao=3"; ?>" >
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">E-mail</label>
                            <div class="col-sm-4">
                                <!--<input type="text" class="form-control" id="email" name="email"  />-->
                                <input type="text" class="form-control" id="mail" autofocus name="mail" title="Ao digitar o nome ou email de algum usuário já cadastrado no sistema , o sistema apresentará opções de escolha"/>
                            </div>
                        </div>                         
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Primeiro Nome</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" placeholder="First name" data-toggle="tooltip" data-placement="bottom" title="Digite apenas o primeiro nome do convidado" name="nome" id="nome">
                            </div>
                        </div>  
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Sobrenome</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" placeholder="Last name" data-toggle="tooltip" data-placement="bottom" title="Digite o sobrenome do convidado." name="sobrenome" id="sobrenome">
                            </div>
                        </div>           
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary btn-label-left" id="botao" name="botao">
                                    <span><i class="fa fa-clock-o"></i></span>
                                    Confirmar Convite
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
                    <span>Participantes do Debate <?php echo $dd->grupo['titulo']; ?> </span>
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
                            <th>N</th>
                            <th>Participante</th>
                            <th>E-mail</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $argumentadores = $dd->recuperarArgumentadoresPorGrupo($_GET["idgrupo"]);
                        $contador = 1;
                        foreach ($argumentadores as $participante) {
                            ?>                                                

                            <tr>
                                <td><?php echo $contador++; ?></td>
                                <td><?php echo $participante[nomecompleto]; ?></td>
                                <td><?php echo $participante[email]; ?></td>
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

    $("#mail").change(function () {
//          alert("a");
        var texto = this.value;
        analisarEmail(texto.trim());
        
      
    });

    $(document).ready(function () {

//        document.getElementById("mail").formValidation({
//            framework: 'bootstrap',
//            icon: {
//                valid: 'glyphicon glyphicon-ok',
//                invalid: 'glyphicon glyphicon-remove',
//                validating: 'glyphicon glyphicon-refresh'
//            },
//            fields: {
//                email: {
//                    validators: {
//                        emailAddress: {
//                            message: 'Tsss sss s s s ss s'
//                        }
//                    }
//                }
//            }
//        });


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
<script>
    function validaEmail(email)
    {
        er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;
        if (er.exec(email))
        {
            return true;
        }
        else {
            return false;
        }
    }
    ;
    function analisarEmail(parametro) {

//          alert("parametro");

        //document.getElementById("mail").reload();

//            document.getElementById("botao").disabled = false;
//             $("#submit").disable = false;
//             $("#botao").disable = false;
//             $("botao").disable = false;
//             $("submit").disable = false;
//          alert("teste");
        //remover o ifem do parametro, referente a o email selecionado
        var rex = /-/ig;
        parametro = parametro.replace(rex, "");
      
        var vetor = parametro.split(" ");

        if (vetor.length >= 3) {

            var tamanho = vetor.length;
            var nome = vetor.shift();
            var mail = vetor.pop();
            tamanho = vetor.length;
            var sobrenome = "";
            var cont;

            document.getElementById("nome").value = nome.trim();
            document.getElementById("mail").value = mail.trim();

//            var person = {fname: "John", lname: "Doe", age: 25};

            for (cont in vetor) {
                sobrenome += vetor[cont] + " ";
            }

            document.getElementById("sobrenome").value = sobrenome.trim();

        }


    }


    $(function () {
        var availableTags = [
<?php echo $textoAutoComplete; ?>
        ];
        $("#mail").autocomplete({
            source: availableTags
        });

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

//
//        $(function () {
//
//            $('#email').keyup(function () {
//
//
//                content = $('#email').val();
//               //  alert('Content has been changed');
//
//            });
//        });



        // Load Datatables and run plugin on tables 
        LoadDataTablesScripts(AllTables);
        // Add Drag-n-Drop feature
        WinMove();
    });
</script>
