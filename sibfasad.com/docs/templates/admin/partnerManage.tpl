{include file="header.tpl"}
<!-- {$partner.show_interview} -->

<h1>{$header}</h1>

<div class="row">
    <form class="form-horizontal" enctype="multipart/form-data" role="form" method="post">
        <div class="form-group">
            <label class="col-sm-2 control-label">Наименование</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" value="{$partner.name}" placeholder="Наименование компании партнера">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Загрузить логотип</label>
            <div class="col-sm-10">
                <input type="file" name="logo">
                {if isset($partner.logo) and $partner.logo != ''}
                    <img style="max-height: 150px; margin: 5px" src="/upload/partnerPhotos/{$partner.logo}">
                {/if}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Загрузить фотографию</label>
            <div class="col-sm-10">
                <input type="file" name="photo">
                {if isset($partner.photo) and $partner.photo != ''}
                    <img style="max-height: 150px; margin: 5px;" src="/upload/partnerPhotos/{$partner.photo}">
                {/if}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Комментарий к фотографии</label>
            <div class="col-sm-10">
                <input type="text" name="photoLabel" class="form-control" value="{$partner.photoLabel}" placeholder="Имя, должность, компания">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Комментарий слева</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="comment" rows="3" placeholder="Короткий комментарий">{$partner.comment}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Сайт партнера</label>
            <div class="col-sm-10">
                <input type="text" name="url" class="form-control" value="{$partner.url}" placeholder="Сайт компании партнера - например, google.com">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Краткое описание</label>
            <div class="col-sm-10">
                <input type="text" name="brief_info" class="form-control" value="{$object.brief_info}" placeholder="Наименование объекта">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Интервью</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="description" rows="3" placeholder="Текст о партнере">{$partner.description}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Отображать интервью на главной</label>
            <div class="col-sm-10">
                <input type="checkbox" name="show_interview" class="form-control" {if $partner.show_interview != false}checked{/if} />
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