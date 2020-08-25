<form    method="post"  action="<?php echo $dd->paginaLogin . "formAcao=2&idAcao=10"; ?>" >
    <div class="box-content">
        <div class="text-center">
            <h3 class="page-header">Preencha os dados abaixo</h3>
        </div>
        <div class="form-group">
            <label class="control-label">Primeiro nome</label>
            <input type="text" class="form-control" name="nome" />
        </div>
        <div class="form-group">
            <label class="control-label">Sobrenome</label>
            <input type="text" class="form-control" name="sobrenome" />
        </div>
        <div class="form-group">
            <label class="control-label">E-mail</label>
            <input type="email" class="form-control" name="email" />
        </div>					
        <div class="text-center">
            <input id="submit" name="submit" type="submit" value="Confirmar Cadastro" class="btn btn-primary">
        </div>

    </div>
</form>