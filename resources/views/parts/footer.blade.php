{{-- Старые блоки статистики оставлены на случай возврата.
<div class="row">
    <div class="col-md-2">

    </div>
      <div class="col-md-8">
        <div class="row">
            <div class="col-6 row">
                <h5 class="col-12">Уникальные посещения</h5>
                    <div class="today col-12">
                    <span>
                        За сегодня:
                        <strong>
                            {{app('request')->attributes->get('statistic')['dayStatistic']}}
                        </strong>
                    </span>
                </div>
                <div class="week col-12">
                    <span>
                        За неделю:
                        <strong>
                            {{app('request')->attributes->get('statistic')['weekStatistic']}}
                        </strong>
                    </span>
                </div>
                <div class="month col-12">
                    <span>
                        За месяц:
                        <strong>
                            {{app('request')->attributes->get('statistic')['mounthStatistic']}}
                        </strong>
                    </span>
                </div>
                <div class="total col-12">
                    <span>Всего посещений:
                        <strong>
                            {{app('request')->attributes->get('statistic')['allVisits']}}
                        </strong>
                    </span>
                </div>
            </div>
            <div class="col-6 row">
                <h5 class="col-12">Пользователи</h5>
                <div class="users-count col-12">
                    <span>Всего зарегистрировано пользователей:
                        <strong>
                            {{app('request')->attributes->get('statistic')['allUsers']}}
                        </strong>
                    </span>
                </div>
                <div class="coop-users-count col-12">
                    <span>Участников кооператива:
                        <strong>
                            {{app('request')->attributes->get('statistic')['allCooperativeMembers']}}
                        </strong>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">

    </div>
</div>
--}}

<div class="footer-panel-wrap">
    <div class="footer-panel row">
        <div class="col-md-4 col-sm-6 col-12 footer-panel-col">
            <h5>Контакты</h5>
            <p class="footer-contact-name">Андрей</p>
            <a href="tel:+380979823294" class="footer-link">+38-097-982-32-94</a>
        </div>

        <div class="col-md-4 col-sm-6 col-12 footer-panel-col">
            <h5>Документы</h5>
            <a href="/ustav" class="footer-link">Устав</a>
            <a href="/faq" class="footer-link">FAQ</a>
            <a href="/kak-vstupit" class="footer-link">Как вступить</a>
        </div>

        <div class="col-md-4 col-sm-12 col-12 footer-panel-col">
            <h5>Соцсети</h5>
            <a href="#" class="footer-link">Telegram</a>
            <a href="#" class="footer-link">VK</a>
            <a href="#" class="footer-link">YouTube</a>
        </div>
    </div>
    <img src="/images/foot_tree.png" alt="" class="footer-tree">
</div>