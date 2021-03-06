{include file="header.tpl"}

<h1>{$header}</h1>

<div class="row">
    <form class="form-horizontal" enctype="multipart/form-data" role="form" method="post">
        <div class="form-group">
            <label class="col-sm-2 control-label">Имя пользователя</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" value="{$user.name}" placeholder="Имя пользователя">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Почта</label>
            <div class="col-sm-10">
                <input type="email" name="mail" class="form-control" value="{$user.mail}" placeholder="Почта пользователя">
            </div>
        </div>
        {if $id != 0}
            <div class="form-group">
                <label class="col-sm-2 control-label">Текущий пароль</label>
                <div class="col-sm-10">
                    <input type="password" name="current_pass" class="form-control" value="" placeholder="Текущий пароль">
                </div>
            </div>
        {/if}
        <div class="form-group">
            <label class="col-sm-2 control-label">Новый пароль</label>
            <div class="col-sm-10">
                <input type="password" name="new_pass" class="form-control" value="" placeholder="Новый пароль">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Новый пароль ещё раз</label>
            <div class="col-sm-10">
                <input type="password" name="new_pass_copy" class="form-control" value="" placeholder="Новый пароль ещё раз">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <input type="hidden" name="id" value="{$id}" />
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
$(function () {
    {literal}
    function validateEmail(email) { 
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    } 
    {/literal}

    $('button[type=submit]').click(function() {
        var
            user_name     = $('input[name=name]').val(),
            user_email    = $('input[name=mail]').val(),
            current_pass  = $('input[name=current_pass]').val(),
            new_pass      = $('input[name=new_pass]').val(),
            new_pass_copy = $('input[name=new_pass_copy]').val(),
            id            = $('input:hidden[name=id]').val(),
            error         = 0;


        // Check if user name is empty
        if (user_name.trim() == '') {
            bootbox.dialog({
                message: 'Имя пользователя не может быть пустым.',
                title: 'Ошибка',
                buttons: {
                    ok: {
                        label: 'Ок',
                        className: 'btn-default',
                        callback: function() {
                            
                            // Do nothing
                            return true;
                        }
                    }
                }
            });

            return false;
        }

        // Check user email if submited
        if (user_email != '' && validateEmail(user_email) == false) {
            bootbox.dialog({
                message: 'Почта указана неверно.',
                title: 'Ошибка',
                buttons: {
                    ok: {
                        label: 'Ок',
                        className: 'btn-default',
                        callback: function() {
                            
                            // Do nothing if passwords are not even
                            return true;
                        }
                    }
                }
            });

            return false;
        } 

        // Check new pass identity
        if (new_pass != new_pass_copy) {
            bootbox.dialog({
                message: 'Введенные пароли отличаются.',
                title: 'Ошибка',
                buttons: {
                    ok: {
                        label: 'Ок',
                        className: 'btn-default',
                        callback: function() {
                            
                            // Do nothing if passwords are not even
                            return true;
                        }
                    }
                }
            });

            return false;
        }

        //  Check new pass field if new user
        if (id == 0 && new_pass.trim() == '') {
            bootbox.dialog({
                message: 'Пароль не может быть пустым.',
                title: 'Ошибка',
                buttons: {
                    ok: {
                        label: 'Ок',
                        className: 'btn-default',
                        callback: function() {
                            
                            // Do nothing if passwords are not even
                            return true;
                        }
                    }
                }
            });

            return false;
        }

        // Check current pass if mode in edit mode
        if (id != 0) {
            $.ajax({
                type: "POST",
                url: "/admin/users/passcheck",
                data: { pass: current_pass, id: id },
                dataType: 'json',
                async: false,
                success: function(response) {
                    if (response.message == 'error') {
                        bootbox.dialog({
                            message: 'Текущий пароль указан неверно',
                            title: 'Ошибка',
                            buttons: {
                                ok: {
                                    label: 'Ок',
                                    className: 'btn-default',
                                    callback: function() {
                                        
                                        // Do nothing if passwords are not even
                                        return true;
                                    }
                                }
                            }
                        });
                        error = 1;
                    }
                },
                error: function(response) {
                    console.log(response);
                    error = 1;
                }
            });

            if (error == 1) {
                return false;
            }
        }
    });

 });
</script>

{include file="footer.tpl"}