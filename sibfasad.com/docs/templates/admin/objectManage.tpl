{include file="header.tpl"}
<style>
    .pdfFileContainer{
        display:inline-block;
        width: 180px;
        margin-right: 10px;
    }
    .pdfFileContainer > * {
        display: inline-block;
    }
    .pdfFileContainer .documentTitle{
        text-align: center;
        display: block;
        font-weight: bold;
    }
    .pdfFileContainer .btn{
        width: 80px;
    }
    .pdfFileContainer .btn:nth-child(1){
        float:left;
        margin-left: 5px;
    }
    .pdfFileContainer .btn:nth-child(2){
        float:right;
        margin-right: 15px;
    }
</style>
<h1>{$header}</h1>

<div class="row">
    <form class="form-horizontal" enctype="multipart/form-data" role="form" method="post" id="js-upload-form">
        <div class="form-group">
            <label class="col-sm-2 control-label">Название</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" value="{$object.name}" placeholder="Наименование объекта">
            </div>
            <input type="hidden" name="id" value="{if isset($id)}{$id}{/if}">
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Описание</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="description" rows="3" placeholder="Допуски продукта">{$object.description}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Участники</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="participiants" rows="3" placeholder="Допуски продукта">{$object.participiants}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Партнеры</label>
            <div class="col-sm-10">
                <select multiple name="partners[]">
                    {foreach $allPartners as $key => $partner}
                        {if in_array($key, $selectedPartners)}
                            <option selected value={$key}>{$partner}</option>
                        {else}
                            <option value={$key}>{$partner}</option>
                        {/if}
                    {/foreach}
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Технологии</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="technologies" rows="3" placeholder="Допуски продукта">{$object.technologies}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Категория</label>
            <div class="col-sm-10">
                <select class="form-control" name="category">
                     <option value="0"{if $object.category == 0} selected="selected"{/if}>- Нет -</option>
                     <option value="1"{if $object.category == 1} selected="selected"{/if}>Жилые дома</option>
                     <option value="2"{if $object.category == 2} selected="selected"{/if}>Торговые центры</option>
                     <option value="3"{if $object.category == 3} selected="selected"{/if}>Административные здания</option>
                </select>
            </div>
        </div>
        {if $object.photos != ''}
        <div class="form-group">
            <label class="col-sm-2 control-label">Фотографии</label>
            <div class="col-sm-10">
                {foreach $object.photos as $photo}
                    <img style="cursor: pointer; margin: 5px; border: 2px solid #ccc;" height="150" src="/upload/objectPhotos/{$photo}" class="photo" data-delete='{$photo}'>
                {/foreach}
            </div>
        </div>
        {/if}
        <!-- @todo ajax photos add -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Загрузка фотографий</label>
            <div class="col-sm-10">
                <input id="multiple_upload" type="file" name="photos[]" multiple>
            </div>
        </div>
        {if $object.pdf_files != ''}
            <div class="form-group">
                <label class="col-sm-2 control-label">PDF файлы</label>
                <div class="col-sm-10">
                    {foreach $object.pdf_files as $pdf_file}
                        <div class="pdfFileContainer"><div class="documentTitle">{$pdf_file}</div><a href="/file/load/{$pdf_file}" class="btn btn-primary" title="Скачать" target="_self">Скачать</a><span  class="pdf_file btn btn-danger" data-delete='{$pdf_file}'>Удалить</span></div>
                    {/foreach}
                </div>
            </div>
        {/if}
        <div class="form-group">
            <label class="col-sm-2 control-label">Загрузка PDF файлов</label>
            <div class="col-sm-10">
                <input id="multiple_pdf_upload" accept=".pdf" type="file" name="pdf_files[]" multiple>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Отображать объект на главной</label>
            <div class="col-sm-10">
                <input type="checkbox" name="show_object" class="form-control" {if $object.show_object != false}checked{/if} />
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

    $('.photo').click(function() {
        var
            $photo = $(this),
            $del = $photo.attr('data-delete'),
            $id  = $('input:hidden[name=id]').val();

        bootbox.dialog({
            message: 'Вы уверены, что хотите удалить фотографию?',
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
                            url: "/admin/objects/ajax",
                            data: { photo: $del, id: $id },
                            success: function(response) {
                                $photo.fadeOut();
                            }
                        });

                        return true;
                    }
                }
            }
        });
    });

    $('.pdf_file').click(function() {
        var
                $pdf_file = $(this),
                $del = $pdf_file.attr('data-delete'),
                $id  = $('input:hidden[name=id]').val();

        bootbox.dialog({
            message: 'Вы уверены, что хотите удалить документ?',
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
                            url: "/admin/objects/pdfajax",
                            data: { pdf_file: $del, id: $id },
                            success: function(response) {
                                $pdf_file.parent('.pdfFileContainer').fadeOut();
                            }
                        });

                        return true;
                    }
                }
            }
        });
    });
    
    var _URL = window.URL || window.webkitURL;

    $("#multiple_upload").change(function(e) {
        
        var image, file;

        if ((file = this.files[0])) {
            $.each( this.files, function( key, value) {
                console.log(value);
                image = new Image();
                console.log(image);
                image.onload = function() {
                    alert("The image width is " +image.width + " and image height is " + image.height);
                };
            
                image.src = _URL.createObjectURL(file);
            });

        }

    });

    $("#multiple_pdf_upload").change(function(e) {

        var pdf, file;

        if ((file = this.files[0])) {
            $.each( this.files, function( key, value) {
                console.log(value);
                pdf = new PDF();
                console.log(pdf);
                pdf.onload = function() {
                   // alert("The image width is " +image.width + " and image height is " + image.height);
                };

                pdf.src = _URL.createObjectURL(file);
            });

        }

    });
 });
</script>
{include file="footer.tpl"}