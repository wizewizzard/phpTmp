{include 'header.tpl'}
<style>
.bx-wrapper .bx-controls-direction {
    width: 940px;
    margin: 0 auto;
    position: relative;
}
.tab-content.employees {
    font-size: 0;
    padding-top: 20px;
}
    .tab-content.employees ul li > a {
        display: inline-block;
        position: relative;
        width: 469px;
        vertical-align: top;
        min-height: 300px;
        text-decoration: none;
        color: #000;
        border: 1px solid transparent;
    }
        .tab-content.employees ul li > a:hover {
            border: 1px solid #51a15c;
        }
        .tab-content.employees > div .hexagon {
            float: left;
            margin-right: 15px;
        }
        .tab-content.employees > div > .employee-info {
            background: #fff;
        }
    .employee-info {
        font-size: 14px;
        margin: 10px 10px 10px 40px;
        padding: 20px;
    }
.bx-wrapper .bx-prev,
.bx-wrapper .bx-next {
    background-image: url('/images/controls-green.png');
}
.bx-wrapper .bx-next {
    background-position: -24px;
}
div.bx-controls.bx-has-pager.bx-has-controls-direction {
    top:0;
    position: absolute;
}
.bx-wrapper .bx-controls-direction a {
    width: 24px;
    height: 24px;
    top: -10px;
}
.certificates-row {
    margin-top: 10px;
    padding-bottom: 10px;
}
    .certificates-row a {
        margin-right: 20px;
        display: inline-block;
    }
        .certificates-row a > img {
            width: 300px;
            height: 425px;
        }
        .certificates-row a:last-child {
            margin-right: 0;
        }
</style>
<nav class="inner tabs">
    <a href="#general">{t}Общая информация{/t}</a>
    <a href="#employees">{t}Сотрудники{/t}</a>
    <!-- <a href="#">Дипломы</a> -->
    <a href="#certificates" >{t}Дипломы{/t}</a>
</nav>
<article class="inner tabs-content">
    <div rel="#general" class="tab-content general">
        <img src="/images/about/company.jpg" style="width: 940px;" />
        <div class="inner table">
            <p style="font-size: 14px; padding: 40px 20px; -webkit-column-count: 2; -moz-column-count: 2; column-count: 2;">
                {t}Группа компаний "Сибирские фасады" создана в 2000 году и объединяет предприятия в Новосибирске, Новокузнецке, Тюмени и Барнауле. Компания сотрудничает с ведущими производителями и поставщиками фасадных и витражных конструкций и имеет собственное производство. Это дает "Сибирским фасадам" возможность качественно выполнять услуги по проектированию, изготовлению, комплектации и монтажу фасадных и витражных конструкций в различных регионах России.{/t}
            </p>
        </div>
    </div>
    <div rel="#employees" class="tab-content employees">
        <ul class="bxslider">
            <li>
                {assign var=count value=0}
                {foreach $employees as $id => $data}
                    {assign var=count value=$count+1}
                    <a href="/about/employee/{$id}">
                        <div class="hexagon" style="background-{if $data.photo != ''}image: url('/upload/employeesPhotos/{$data.photo}'){else}color: #8dc63f{/if};">
                            <div class="hexTop"></div>
                            <div class="hexBottom"></div>
                        </div>
                        <div class="employee-info">
                            <h3>{$data.name}</h3>
                            {$data.description|truncate:600}
                        </div>
                    </a>
                    {if $count == 6}
                        {assign var=count value=0}
                        </li>
                        <li>
                    {/if}
                {/foreach}
            </li>
        </ul>
    </div>
    <div rel="#certificates" class="tab-content certificates">
        <ul class="bxslider">
            <li>
                <div class="certificates-row">
                    {assign var=count value=0}
                    {assign var=countRow value=0}
                    {foreach $certificates as $id => $data}
                        {assign var=count value=$count+1}
                        {assign var=countRow value=$countRow+1}
                            <a href="/upload/certificates/{$data.photo}" rel="prettyPhoto"><img src="/upload/certificates/thumbs/{$data.photo}" /></a>
                        {if $count == 9}
                            {assign var=count value=0}
                            {assign var=countRow value=0}
                                </div>
                            </li>
                            <li>
                                <div class="certificates-row">
                        {elseif $countRow == 3}
                            {assign var=countRow value=0}
                            </div>
                            <div class="certificates-row">
                        {/if}
                    {/foreach}
                </div>
            </li>
        </ul>
    </div>
</article>

<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
    $("a[rel^='prettyPhoto']").prettyPhoto({
        theme:              'facebook',
        deeplinking:        false,
        social_tools:       null
        });
});
</script>


{include 'footer.tpl'}
