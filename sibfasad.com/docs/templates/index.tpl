{include 'header.tpl'}

<style>
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

</style>
{if $withVideo == true}
<div id="overlay-video" style="position: fixed; top: 0; bottom: 0; left: 0; right: 0; z-index: 10000; background: #000">
    <!-- Begin Video.js -->
    <video id="movie-id" class="video-js vjs-default-skin alignleft" width="100%" height="100%" preload="auto" autoplay data-setup="{}">
        <source src="/upload/video/intro.mp4" type='video/mp4' />
    </video>
    <div id="video-content" style="display: none;">
        <img src="/images/logo.png" alt="Сибирские фасады"><br>
        <a href="#" style="display: inline-block; background-image: url('/images/flags.png'); width: 22px; height: 16px;"></a>
        <a href="#" style="display: inline-block; background-image: url('/images/flags.png'); width: 22px; height: 16px; background-position: -21px 0;"></a>
    </div>
    <!-- End Video.js -->
</div>
{/if}
<article class="index">
    {foreach $hexagons as $id => $data}
        {assign var=count value=$count+1}
        {if $data@first}
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
        {if $data == 'space'}
            <div class="hexagon">
                <div class="hexTop"></div>
                <div class="hexBottom"></div>
            </div>
        {else}
        <a href="{$data.link}" class="hexagon" style="background-image: url('{if $data.photo != ''}{$data.photo}{/if}');">
            <div class="hexTop"></div>
            <div class="hexContent">{$data.name}</div>
            <div class="hexBottom"></div>
        </a>
        {/if}
        {if $data@last}
            </div>
        {/if}
    {/foreach}
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
    });
});
</script>

{include 'footer.tpl'}
