<?php
/**
 * @var $this Srv_Core_Pagination
 */
if ($this->pages) {
?><!--pagination-->
<nav>
    <ul class="pagination">
        <li class="page-item">
            <a class="page-link"
               href="?<?= http_build_query($this->params) ?>&<?= $this->key ?>=<?= max(0, $this->cur - 1) ?>"
               title="Предыдущая страница">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>

        <?php for ($i = $this->first; $i <= $this->pages; $i++) { ?>
            <?php if (abs($i - $this->cur - $this->first) < $this->together) { ?>
                <li class="page-item <?= ($i - $this->first == $this->cur ? 'active' : null) ?>">
                    <a class="page-link"
                       href="?<?= http_build_query($this->params) ?>&<?= $this->key ?>=<?= $i - $this->first ?>"
                       title="Страница <?= $i ?>"><?= $i ?></a>
                </li>
            <?php } elseif ($i == $this->first || $i == $this->pages) { ?>

                <!--before dots-->
                <?php if ($this->cur + $this->together + $this->first + 1 < $i) { ?>
                    <li class="page-item">
                        <span class="page-link">...</span>
                    </li>
                <?php } elseif ($this->cur + $this->together + $this->first < $i) { ?>
                    <li class="page-item">
                        <a class="page-link"
                           href="?<?= http_build_query($this->params) ?>&<?= $this->key ?>=<?= $this->pages - $this->first - 1 ?>"
                           title="Страница <?= $this->pages - 1 ?>"><?= $this->pages - 1 ?></a>
                    </li>
                <?php } ?>

                <!--first/last-->
                <li class="page-item">
                    <a class="page-link"
                       href="?<?= http_build_query($this->params) ?>&<?= $this->key ?>=<?= $i - $this->first ?>"
                       title="Страница <?= $i ?>"><?= $i ?></a>
                </li>

                <!--after dots-->
                <?php if ($this->cur - $this->together + $this->first - 1 > $i) { ?>
                    <li class="page-item">
                        <span class="page-link">...</span>
                    </li>
                <?php } elseif ($this->cur - $this->together + $this->first > $i) { ?>
                    <li class="page-item">
                        <a class="page-link"
                           href="?<?= http_build_query($this->params) ?>&<?= $this->key ?>=<?= $i - $this->first + 1 ?>"
                           title="Страница <?= $i + 1 ?>"><?= $i + 1 ?></a>
                    </li>
                <?php } ?>

            <?php } ?>
        <?php } ?>

        <li class="page-item">
            <a class="page-link"
               href="?<?= http_build_query($this->params) ?>&<?= $this->key ?>=<?= min($this->pages - 1, $this->cur + 1) ?>"
               title="Следующая страница">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
<?php } ?>