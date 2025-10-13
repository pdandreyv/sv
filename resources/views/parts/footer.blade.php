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