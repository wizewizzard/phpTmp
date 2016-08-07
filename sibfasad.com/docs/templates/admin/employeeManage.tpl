{include file="header.tpl"}

<h1>{$header}</h1>

<div class="row">
    <form class="form-horizontal" enctype="multipart/form-data" role="form" method="post">
        <div class="form-group">
            <label class="col-sm-2 control-label">Имя</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" value="{$employee.name}" placeholder="Имя сотрудника">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Загрузить фотографию</label>
            <div class="col-sm-10">
                <input type="file" name="photo">
                {if isset($employee.photo) and $employee.photo != ''}
                    <img style="max-height: 150px; margin: 5px;" src="/upload/employeesPhotos/{$employee.photo}">
                {/if}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Описание</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="description" rows="3" placeholder="Текст о партнере">{$employee.description}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Активен</label>
            <div class="col-sm-10">
                <input type="checkbox" name="enabled" class="form-control" {if $employee.enabled != false}checked{/if} />
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
/*
* Add margin and price row
*/
$(function() {
    /*
    * Add new rows if need
    */
    $('.btn[data-action="add"]').on('click', function() {
        // Prepare variables
        var
            $button  = $(this),
            $handler = $button.closest('[data-handler]'),
            $newRow  = $button.closest('[data-row]').clone(),
            $rowButton = $('[data-action]', $newRow);

        // Change add button to remove button
        $rowButton.attr('data-action', 'remove').toggleClass('btn-success btn-danger');
        $('i.fa', $rowButton).toggleClass('fa-plus fa-minus');

        // Append row
        $newRow.appendTo($handler);

        // Prevent default action
        return false;
    });

    /*
    * Extend "remove" buttons
    */
    $(document).on('click', '.btn[data-action="remove"]', function() {
        // Prepare variables
        var
            $row = $(this).closest('[data-row]');

        // Remove row
        $row.fadeOut('fast', function() {
            $row.remove();
        });

        // Prevent default action
        return false;
    });
});
</script>

{include file="footer.tpl"}