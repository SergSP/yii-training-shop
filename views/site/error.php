<div class="container text-center">
    <div class="logo-404">
        <a href="index.html"><img src="images/home/logo.png" alt="" /></a>
    </div>
    <div class="content-404">
        <img src="/images/404/404.png" class="img-responsive img-404" alt="" />
        <h1><b>Упс!</b> Что-то пошло не так.</h1>
        <p><?= nl2br(\yii\helpers\Html::encode($message)) ?></p>
        <h2><a href="javascript:history.back()">Вернуться назад</a></h2>
        <h2><a href="<?= \yii\helpers\Url::home('https') ?>">Вернуться на главную страницу</a></h2>
        <br />
    </div>
</div>