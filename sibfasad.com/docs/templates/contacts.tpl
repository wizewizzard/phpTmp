{include 'header.tpl'}

<style>
iframe {
    margin: 20px 0;
    padding: 0px;
}
.contacts {
    display: table;
    font-size: 14px;
    margin-bottom: 40px;
}
.cell {
    display: table-cell;
    width: 50%;
}
    .cell .right {
        display: inline-block;
        float: right;
        width: 300px;
        text-align: left;
    }
    .cell a {
        color: #000;
        text-decoration: none;
    }
        .cell a:hover {
            text-decoration: underline;
        }
</style>
<nav class="inner tabs">
    <a href="#office">{t}Офис{/t}</a>
    <a href="#production">{t}Производство{/t}</a>
</nav>
<article class="inner tabs-content">
    <div rel="#office" class="tab-content office">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2286.9740575515534!2d82.911712!3d55.026147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x42dfe5d3691ae3f9%3A0x52c3cb06bfcc8f0f!2sul.+Maksima+Gorkogo%2C+24%2C+Novosibirsk%2C+Novosibirskaya+oblast&#39;%2C+630099!5e0!3m2!1sen!2sru!4v1435588978245" width="100%" height="500" frameborder="0" style="border:0"></iframe>
        <div class="inner contacts">
            <div class="cell">
                {t}Российская Федерация, Новосибирская область, г. Новосибирск{/t},<br />
                {t}улица Максима Горького, 24{/t}
            </div>
            <div class="cell">
                {t}Отдел продаж{/t}:                 <span class="right">+7 (383) 567 78 87</span><br />
                {t}Технический отдел{/t}:        <span class="right">+7 (383) 678 76 65</span><br />
                {t}Бухгалтерия{/t}:                    <span class="right">+7 (383) 567 85 49</span><br />
                <br />
                {t}Директор{/t}:                          <span class="right">+7 (383) 567 44 56</span><br />
                {t}Зам. Директора{/t}:              <span class="right">+7 (383) 543 67 65</span><br />
                <br />
                <br />
                <a href="mailto:info@sibfasad.com">info@sibfasad.com</a>
            </div>
        </div>
    </div>
    <div rel="#production" class="tab-content production">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4577.482641815429!2d83.05237062698284!3d54.99516926116643!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x42dfe91aa417555b%3A0xd23facddb94636c6!2z0J_RgNC-0LvQtdGC0LDRgNGB0LrQsNGPINGD0LsuLCAzNjAsINCd0L7QstC-0YHQuNCx0LjRgNGB0LosINCd0L7QstC-0YHQuNCx0LjRgNGB0LrQsNGPINC-0LHQuy4sIDYzMDExNA!5e0!3m2!1sru!2sru!4v1435523178499" width="100%" height="500" frameborder="0" style="border:0"></iframe>

        <div class="inner contacts">
            <div class="cell">
                {t}Российская Федерация, Новосибирская область, г. Новосибирск{/t},<br />
                {t}Пролетарская улица, дом 360{/t}
            </div>
            <div class="cell">
                {t}Отдел продаж{/t}:                 <span class="right">+7 (383) 567 78 87</span><br />
                {t}Технический отдел{/t}:        <span class="right">+7 (383) 678 76 65</span><br />
                {t}Бухгалтерия{/t}:                    <span class="right">+7 (383) 567 85 49</span><br />
                <br />
                {t}Директор{/t}:                          <span class="right">+7 (383) 567 44 56</span><br />
                {t}Зам. Директора{/t}:              <span class="right">+7 (383) 543 67 65</span><br />
                <br />
                <br />
                <a href="mailto:info@sibfasad.com">info@sibfasad.com</a>
            </div>
        </div>
    </div>
</article>

{include 'footer.tpl'}