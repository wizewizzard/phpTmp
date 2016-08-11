{include 'header.tpl'}
<style>
    .even .emptyHexagon{

    }
    .odd .emptyHexagon{

    }
    .hexagon{

    }
    .gray{
        background: #444;
    }
    .grassyGreen{
        background: rgb(60, 181, 114);
    }
    .lightGray{
        background: rgba(238, 238, 238, 1);
    }
    .lightGreen{
        background: rgb(121, 214, 91);
    }
    .white{
        background: rgb(255, 255, 255);
    }
    .textEye{
        position: absolute;
        left:57px;
        top: 95px;
        background: url('/images/eye.png');
        background-size: 100% 100%;
        z-index: 1024;
        width: 18px;
        height: 9px;
    }
    .textHexagon{
        word-wrap: break-word;
    }
    .textHexagon .hexBottom{
        opacity: 1.0;
    }
    .textHexagon .hexContent{
        padding-left:5px;
        padding-right:5px;
        font-size: 14px;
        opacity: 1.0;
        background: transparent;
    }
    .textHexagon .hexContent:before {
        border-top-width: 0;
        top: -38px;
        border-bottom-width: 0px;
        border-bottom-color: rgba(0, 0, 0, .4);
    }
    .textHexagon .hexContent:after {
        border-bottom-width: 0;
        bottom: -38px;
        border-top-width: 0px;
        border-top-color: rgba(0, 0, 0, .4);
    }
    a.hexagon:hover > * {
    webkit-transition: 0s;
    transition: 0s;
}
a.hexagon h3 {
    font-size: 14px;
    color: #fff;
}
.bx-wrapper .bx-prev {
    left: 0;
    background: url('/images/controls-green.png');
}
.bx-wrapper .bx-next {
    right: 0;
    background: url('/images/controls-green.png') -24px 0;
}
.bx-wrapper .bx-controls-direction a {
    top: -100px;
    width: 24px;
    height: 24px;
}
.index h3 {
    color: #aed580;
    font-size: 24px;
    font-weight: 900;
    margin: 40px 0 20px;
}
video {
    position: relative;
}
#video-content {
    position: absolute;
    top: 0;
    left: 0;

    z-index: 1;
    font-size: 20px;
    color: #eee;
    background: rgba(0,0,0, 0.3);
    padding: 10px;
    width: 310px;
    text-align: center;
}
#overlay-video{
    z-index: 100000;
    background: black;
    position: fixed;
    top: 0; bottom: 0;
    left: 0; right: 0;
}
    .loaderImage{
        display: block;
        width:50px;
        margin: 0 auto;
        position: relative;

    }
    .slideImage{

        position: relative;
        width: 100%;
    }

    .backGround{
        position: absolute;
        opacity: 0.0;
        width: 100%;
        height:100%;

    }
    #logoAfterVideo{
        opacity: 1.0;
        position: absolute;
        left: 0px;
        -webkit-animation: moveElementAfterInfro;
        animation-duration: 3.5s;
        animation-delay: 0.2s;
        animation-timing-function: linear;
        -webkit-animation-timing-function: linear;
        animation-fill-mode:forwards;
        -webkit-animation-fill-mode: forwards;
    }
    #slide1{
        z-index: 100007;
    }
    #slide1 .backGround{
        z-index: 100006;
        background: white;
        -webkit-animation: scaleBackground;
        animation-duration: 3.5s;
        animation-timing-function: linear;
        -webkit-animation-timing-function: linear;
    }
    #slide2{
        z-index: 100005;

    }
    #slide2 .backGround{
        background: black;
        -webkit-animation: scaleBackgroundR;
        animation-duration: 3.5s;
        animation-delay: 3.4s;
        animation-timing-function: linear;
        -webkit-animation-timing-function: linear;
    }
    #slide3{
        z-index: 100004;
    }
    #slide3 .backGround{
        z-index: 100003;
        background: white;
        -webkit-animation: scaleBackground;
        animation-delay: 6.8s;
        animation-duration: 3.5s;
        animation-timing-function: linear;
        -webkit-animation-timing-function: linear;
    }
    #slide4{
        z-index: 100002;
    }
    #slide4 .backGround{
        z-index: 100001;
        background: white;
        -webkit-animation: scaleBackground;
        animation-delay: 10.2s;
        animation-duration: 3.5s;
        animation-timing-function: linear;
        -webkit-animation-timing-function: linear;
    }
    #slide1 img{
        -webkit-animation: blurScaleBright;
        animation-duration: 3.5s;

        animation-timing-function: linear;
        -webkit-animation-timing-function: linear;
    }
    #slide2 img{
        -webkit-animation: blurScaleBlur;
        animation-duration: 3.5s;
        animation-delay: 3.4s;
        animation-timing-function: linear;
        -webkit-animation-timing-function: linear;
    }
    #slide3 img{
        -webkit-animation: blurScaleBright;
        animation-duration: 3.5s;
        animation-delay: 6.8s;
        animation-timing-function: linear;
        -webkit-animation-timing-function: linear;
    }
    #slide4 img{
        -webkit-animation: blurScaleBlur;
        animation-duration: 3.5s;
        animation-delay: 10.2s;
        animation-timing-function: linear;
        -webkit-animation-timing-function: linear;
    }
</style>
{if $withVideo == true}
<div id="overlay-video">
    <script>
        $('body').css('overflow', 'hidden');
    </script>
    <!-- List of images and text -->
    <ul>
        <li id="loader"><img src="/images/whiteLoader.gif" class="loaderImage"/><span>text for slide 1</span></li>
        <li id="slide1"><div class="backGround"><img src="/images/slide2.jpg" class="slideImage"/></div><span>text for slide 1</span></li>
        <li id="slide2"><div class="backGround"><img src="/images/slide2.jpg" class="slideImage"/></div><span>text for slide 2</span></li>
        <li id="slide3"><div class="backGround"><img src="/images/slide2.jpg" class="slideImage"/></div><span>text for slide 3</span></li>
        <li id="slide4"><div class="backGround"><img src="/images/slide2.jpg" class="slideImage"/></div><span>text for slide 4</span></li>
     </ul>

    <div id="logoAfterVideo">
        Select language
        <a href="#" style="display: inline-block; background-image: url('/images/flags.png'); width: 22px; height: 16px;"></a>
        <a href="#" style="display: inline-block; background-image: url('/images/flags.png'); width: 22px; height: 16px; background-position: -21px 0;"></a>
    </div>
</div>
    <script>
        $('.loaderImage').css({
            position:'absolute',
            left: ($(document).width() - $('.loaderImage').outerWidth())/2,
            top: ($(document).height() - $('.loaderImage').outerHeight())/2
        });

    </script>
{/if}
<article class="index">
    {assign var=even value=1}
    {assign var=rowStart value=0}
    {assign var=rowsEvenUnevenNum value=$hexagonUnevenRowNum + $hexagonEvenRowNum}
    {assign var=currentRow value=0}
    {for $i = 0 to $hexagonsNum - 1}
        {assign var=count value=$count+1}
        {if $i == 0 }
            {assign var=even value=1}
            {assign var=count value=0}
    <div class="even">
        {/if}
        {if $even == 0 and $count == 6}
            {assign var=even value=1}
            {assign var=count value=0}
            </div>
            <div class="even">
        {/if}
        {if $even == 1 and $count == 7}
            {assign var=even value=0}
            {assign var=count value=0}
            </div>
            <div class="odd">
        {/if}

        {assign var=class value='white'}
        {if !isset($hexagonsPhoto[$i]) && !isset($hexagonsText[$i])}
            {assign var=random value=1|rand:2}
            {if $random == 1 }
                {$class='white'}
            {elseif $random == 2}
                {$class='lightGray'}
            {/if}
            <div class="hexagon emptyHexagon {$class}">
                <div class="hexTop"></div>
                <div class="hexBottom"></div>
            </div>
        {elseif isset($hexagonsPhoto[$i])}
            <div class="hexagon photoHexagon" style="background-image: url('{if $hexagonsPhoto[$i].photo != ''}{$hexagonsPhoto[$i].photo}{/if}');">
                <div class="hexTop"></div>
                <div class="hexContent">{$hexagonsPhoto[$i].name}</div>
                <div class="hexBottom"></div>
            </div>
        {elseif isset($hexagonsText[$i])}
            {assign var=random value=1|rand:3}
            {if $random == 1 }
                {$class='lightGreen'}
            {elseif $random == 2}
                {$class='grassyGreen'}
            {else}
                {$class='gray'}
            {/if}
            <a href="{$hexagonsText[$i].link}" class="hexagon textHexagon {$class}">
                <div class="hexTop"></div>
                <div class="hexContent">
                    <div>{$hexagonsText[$i].brief_info}</div>
                </div>
                <div class="textEye"></div>
                <div class="hexBottom"></div>
            </a>
        {/if}
        {if $i == $hexagonsNum - 1}
            </div>
        {/if}
    {/for}

    <h3>Интервью</h3>
    <div class="people">
        <ul class="peopleSlider">
            {foreach $interviews as $id => $data}
                <li>
                    <div class="hexagon" style="position: absolute; left: 30px; background-image: url('{if $data.photo != ''}/upload/partnerPhotos/{$data.photo}{else}/images/nophoto.jpg{/if}');">
                        <div class="hexTop"></div>
                        <div class="hexBottom"></div>
                    </div>
                    <div class="peopleDescription">
                        <p class="signature">
                            {$data.photoLabel}                            
                        </p>
                        <p>
                            {$data.description|truncate:450:"..."}
                        </p>
                        <a href="/partners/view/{$id}" class="readMore">
                            Читать всё интервью
                        </a>
                    </div>
                </li>
            {/foreach}
        </ul>
    </div>
</article>

<script type="text/javascript">
$(document).ready(function(){


   /* $('#slide1 img').css({
        position:'absolute',
        left: ($(window).width() - $('#slide1 img').outerWidth())/2,
        top: ($(window).height() - $('#slide1 img').outerHeight())/2
    });*/
    /*$('#slide1 .backGround').css({
        position:'absolute',
        left: ($(window).width() - $('#slide1 .backGround').outerWidth())/2,
        top: ($(window).height() - $('#slide1 .backGround').outerHeight())/2
    });*/
    $('#slide1 .backGround').css({
        position:'absolute',
        left: ($(window).width() - $('#slide1 .backGround').outerWidth())/2,
        top: ($(window).height() - $('#slide1 .backGround').outerHeight())/2
    });
    $('#slide2 .backGround').css({
        position:'absolute',
        left: ($(window).width() - $('#slide2 .backGround').outerWidth())/2,
        top: ($(window).height() - $('#slide2 .backGround').outerHeight())/2
    });
    /*$('#slide3 img').css({
        position:'absolute',
        left: ($(window).width() - $('#slide3 img').outerWidth())/2,
        top: ($(window).height() - $('#slide3 img').outerHeight())/2
    });*/
    $('#slide3 .backGround').css({
        position:'absolute',
        left: ($(window).width() - $('#slide3 .backGround').outerWidth())/2,
        top: ($(window).height() - $('#slide3 .backGround').outerHeight())/2
    });
    /*$('#slide4 img').css({
        position:'absolute',
        left: ($(window).width() - $('#slide4 img').outerWidth())/2,
        top: ($(window).height() - $('#slide4 img').outerHeight())/2
    });*/
    $('#slide4 .backGround').css({
        position:'absolute',
        left: ($(window).width() - $('#slide4 .backGround').outerWidth())/2,
        top: ($(window).height() - $('#slide4 .backGround').outerHeight())/2
    });

    $('.loaderImage').remove();

    var slideDuration = 2000;

   /* $("#slide1").find('img').fadeIn(0);
    $("#slide1").find('img').fadeIn(0);*/
    /**
     * start animation
     */

    /*$("#slide1").find('img').fadeIn(1000, function() {
                setTimeout(function() {
                    $("#slide1").find('img').fadeOut(1000, function(){
                        $("#slide2").find('img').fadeIn(1000, function(){

                                }
                        );
                    });
                }, 2000);
            }
        );*/

    /*var slide1Effect = function(){

    };
    slide1Effect();
    $("#movie-id").on('load', function() {   
        $('body').css('overflow', 'hidden');
        return false;         
       
    });
    $("#movie-id").on('play', function() {   
        $('body').css('overflow', 'hidden');
        return false;         
       
    });
    $("#movie-id").on('ended', function() {   
        this.currentTime = 1;           
        $("#video-content").show();

    }).on('click', function() {
        $("#overlay-video").fadeOut('slow', function() {
            $(this).remove();
        });

        $('body').css('overflow', 'auto');
    });
    $('#video-content a').on('click', function() {
        $("#overlay-video").fadeOut('slow', function() {
            $(this).remove();
        });

        $('body').css('overflow', 'auto');
        return false;
    });

    var $vid = $('video','#overlay-video');
    var $msg = $('#video-content'); 
    $msg.css({
        top:$vid.offset().top + (($vid.height()/3) - ($msg.height()/2)),
        left:$vid.offset().left + (($vid.width()/2) - ($msg.width()/2))
    });*/
});
</script>

{include 'footer.tpl'}
