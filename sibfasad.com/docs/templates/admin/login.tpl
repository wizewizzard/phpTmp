{include file="header.tpl"}

<div class="container jumbotron">
    {if $errors !== ''}
        <div class="row">
            <div class="col-xs-12 col-md-7 col-md-offset-2 alert alert-danger">
                {$errors}
            </div>
        </div>
    {/if}

    <form action="/admin/login" method="POST" class="form-horizontal">
        <div class="form-group">
            <label class="col-xs-12 col-md-2 col-md-offset-1 control-label" for="login">Логин</label>
            <div class="col-xs-12 col-md-6">
                <input type="text" class="form-control" name="login" id="login" placeholder="Введите логин">
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 col-md-2 col-md-offset-1 control-label" for="password">Пароль</label>
            <div class="col-xs-12 col-md-6">
                <input type="password" class="form-control" name="password" id="password" placeholder="Введите пароль">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <button type="submit" class="btn btn-block btn-primary">Войти</button>
            </div>
        </div>
    </form>
</div>

{include file="footer.tpl"}
