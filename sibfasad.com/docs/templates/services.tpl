{include 'header.tpl'}

<style>
.bx-wrapper .bx-controls-direction {
    width: 940px;
    margin: 0 auto;
    position: relative;
}
</style>
<nav class="inner tabs">
    <a href="#design">Проектирование</a>
    <a href="#production">Производство</a>
    <a href="#mount">Монтаж</a>
    <a href="#manage">Управление проектами</a>
</nav>
<article class="inner tabs-content">
    {foreach $services as $name => $data}
    <div rel="#{$name}" class="tab-content {$name}">
        <div class="slide-head">
            <div class="slide-head-content">
                <span>{$data.title}</span>
            </div>
        </div>
        <ul class="bxslider">
            {if isset($data.slide1) && $data.slide1 != ''}
            <li>
                <img src="/upload/slides/{$data.slide1}" />
            </li>
            {/if}
            {if isset($data.slide2) && $data.slide2 != ''}
            <li>
                <img src="/upload/slides/{$data.slide2}" />
            </li>
            {/if}
            {if isset($data.slide3) && $data.slide3 != ''}
            <li>
                <img src="/upload/slides/{$data.slide3}" />
            </li>
            {/if}
        </ul>
        <div class="inner" style="font-size: 14px">
            {$data.text}
        </div>
    </div>
    {/foreach}
</article>

{include 'footer.tpl'}
