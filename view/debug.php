<?php
/**
 * @var $this Srv_Core_View
 */
?>
<?php if (Srv_Group::hasAccessAdmin()) { ?>
    <div class="debug">

        <div class="btn btn-primary btn-debug" data-toggle="collapse" data-target="#collapseDebug" aria-expanded="false"
             aria-controls="collapseDebug">
            <i class="fa fa-cogs" aria-hidden="true"></i>
        </div>

        <div class="collapse collapse-debug" id="collapseDebug">
            <div class="card card-block bg-faded text-xs-left">
                <div>Отладочная информация</div>

                <div>
                    Process Time: <?= microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]; ?>
                </div>

                <div id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading1">
                            <div class="panel-title">
                                <a data-toggle="collapse" href="#collapse1" aria-expanded="true" aria-controls="collapse1">1. View</a>
                            </div>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                            <pre><?php print_r($this); ?></pre>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <div class="panel-title">
                                <a data-toggle="collapse" href="#collapse2" aria-expanded="true" aria-controls="collapse2">2. Current user</a>
                            </div>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                            <pre><?php Srv_User::getCurrent() ? print_r(Srv_User::getCurrent()) : var_dump(Srv_User::getCurrent()); ?></pre>
                            <pre><?php Srv_Group::getCurrent2user() ? print_r(Srv_Group::getCurrent2user()) : var_dump(Srv_Group::getCurrent2user()); ?></pre>
                            <pre><?php Srv_Group::getCurrent() ? print_r(Srv_Group::getCurrent()) : var_dump(Srv_Group::getCurrent()); ?></pre>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <div class="panel-title">
                                <a data-toggle="collapse" href="#collapse3" aria-expanded="true" aria-controls="collapse3">3. Current handler</a>
                            </div>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                            <pre><?php print_r(Srv_Page::getCurHandler()); ?></pre>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <div class="panel-title">
                                <a data-toggle="collapse" href="#collapse4" aria-expanded="true" aria-controls="collapse4">4. Current page</a>
                            </div>
                        </div>
                        <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                            <pre><?php Srv_Page::getCurrent() ? print_r(Srv_Page::getCurrent()) : var_dump(Srv_Page::getCurrent()); ?></pre>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <div class="panel-title">
                                <a data-toggle="collapse" href="#collapse5" aria-expanded="true" aria-controls="collapse5">5. Pages</a>
                            </div>
                        </div>
                        <div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                            <pre><?php Srv_Page::getPages() ? print_r(Srv_Page::getPages()) : var_dump(Srv_Page::getPages()); ?></pre>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <div class="panel-title">
                                <a data-toggle="collapse" href="#collapse6" aria-expanded="true" aria-controls="collapse6">6. Server</a>
                            </div>
                        </div>
                        <div id="collapse6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                            <pre><?php print_r($_SERVER); ?></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>