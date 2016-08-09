<!DOCTYPE html>
<head>
<title>Сибирские фасады{if isset($pageTitle) === true} | {$pageTitle}{/if}</title>
<meta charset="utf-8">
<link type="text/css" rel="stylesheet" href="/css/bootstrap.min.css">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<script type="text/javascript" src="/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/bootbox.min.js"></script>
<script type="text/javascript" src="/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    language : 'ru',
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
         "table contextmenu directionality emoticons paste textcolor responsivefilemanager code fullscreen"
    ],
    toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
    toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code fullscreen",
    image_advtab: true ,
    indentation : '20px',
   
   external_filemanager_path:"/filemanager/",
   filemanager_title:"Responsive Filemanager" ,
   external_plugins: { "filemanager" : "/filemanager/plugin.min.js"}
 });
</script>
</head>
<body style="padding-top: 70px;">
<div class="container">
    {if $logged_in === true}
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="/admin/">Сибирские фасады</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <!-- <li class="{if isset($active) and $active == 'main'}active{/if}"><a href="/admin/main">Главная</a></li> -->
                        <li class="{if isset($active) and $active == 'objects'}active{/if}"><a href="/admin/objects">Объекты</a></li>
                        <li class="{if isset($active) and $active == 'partners'}active{/if}"><a href="/admin/partners">Партнеры</a></li>
                        <li class="{if isset($active) and $active == 'services'}active{/if}"><a href="/admin/services">Услуги</a></li>
                        <li class="{if isset($active) and $active == 'employees'}active{/if}"><a href="/admin/employees">Сотрудники</a></li>
                        <li class="{if isset($active) and $active == 'video'}active{/if}"><a href="/admin/video">Видео</a></li>
                        <li class="{if isset($active) and $active == 'certificates'}active{/if}"><a href="/admin/certificates">Дипломы</a></li>
                        <li class="{if isset($active) and $active == 'users'}active{/if}"><a href="/admin/users">Пользователи</a></li>
                        <li class="{if isset($active) and $active == 'config'}active{/if}"><a href="/admin/config">Прочие настройки</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="/admin/logout">Выйти</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
    {/if}
