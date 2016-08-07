{include file="header.tpl"}

<h1>{$header}</h1>

<div class="row">
    <form class="form-horizontal" enctype="multipart/form-data" role="form" method="post">
        <div class="form-group">
            <label class="col-sm-2 control-label">Наименование</label>
            <div class="col-sm-10">
                <input type="text" name="title" class="form-control" value="{$service.title}" disabled>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Первый слайд</label>
            <div class="col-sm-10">
                <input type="file" name="slide1">
                {if isset($service.slide1) and $service.slide1 != ''}
                    <img style="max-height: 150px; margin: 5px; cursor: pointer;" src="/upload/slides/{$service.slide1}" class="slide" data-row="slide1" data-name="{$service.name}" data-delete="{$service.slide1}">
                {/if}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Второй слайд</label>
            <div class="col-sm-10">
                <input type="file" name="slide2">
                {if isset($service.slide2) and $service.slide2 != ''}
                    <img style="max-height: 150px; margin: 5px; cursor: pointer;" src="/upload/slides/{$service.slide2}" class="slide" data-row="slide2" data-name="{$service.name}" data-delete="{$service.slide2}">
                {/if}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Третий слайд</label>
            <div class="col-sm-10">
                <input type="file" name="slide3">
                {if isset($service.slide3) and $service.slide3 != ''}
                    <img style="max-height: 150px; margin: 5px; cursor: pointer;" src="/upload/slides/{$service.slide3}" class="slide" data-row="slide3" data-name="{$service.name}" data-delete="{$service.slide3}">
                {/if}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Текст услуги</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="text" rows="10" placeholder="Текст пункта меню">{$service.text}</textarea>
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
$(function () {

    $('.slide').click(function() {
        var
            $slide = $(this),
            $row = $slide.attr('data-row'),
            $name = $slide.attr('data-name'),
            $del = $slide.attr('data-delete');

        bootbox.dialog({
            message: 'Вы уверены, что хотите удалить слайд?',
            title: 'Подтверждение',
            buttons: {
                cancel: {
                    label: 'Отмена',
                    className: 'btn-default',
                    callback: function() {
                        // Don't do anything on cancel
                        return true;
                    }
                },
                ok: {
                    label: 'Удалить',
                    className: 'btn-danger',
                    callback: function() {
                        $.ajax({
                            type: "POST",
                            url: "/admin/services/ajax",
                            data: { row: $row, name: $name, del: $del },
                            success: function(response) {
                                $slide.fadeOut();
                            }
                        });

                        return true;
                    }
                }
            }
        });
    });
});
</script>

{include file="footer.tpl"}