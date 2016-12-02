<div class="simple jumbotron jumbotron-fluid">
    <div class="container">
        <i class="status"><?= $this->status ?></i>
        <h1 class="display-1 title"><?= Srv_Page::getTitle() ?></h1>

        <p>
            <?php if (isset($this->btn)) { ?>

                <a class="btn btn-lg btn-primary" href="<?= $this->btn ?>"
                   title="Войти">Войти &raquo;</a>

            <?php } elseif ($href = Srv_Page::getBackUrl()) { ?>

                <a class="btn btn-lg btn-primary" href="<?= $href ?>"
                   title="Нaзад">Нaзад &raquo;</a>

            <?php } else { ?>

                <a class="btn btn-lg btn-primary" href="/" title="Нa главную страницу">Нa главную</a>

            <?php } ?>
        </p>
    </div>
</div>