<?
/**
 * @var \Template\PHP $this
 */

?>
<div class="tab-content">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-general-add" data-toggle="tab">Основные</a></li>
        <li class=""><a href="#tab-meta-add" data-toggle="tab">Формирование мета</a></li>
        <li class=""><a href="#tab-telegram" data-toggle="tab">Настройки оповещений телеграм</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab-general-add">
            <div class="form-group">
                <label class="col-sm-2 control-label" for="phone_sale1">Телефон 1</label>
                <div class="col-sm-10">
                    <input class="form-control" id="phone_sale1" type="text" name="config_phone_sale1" value="<?php echo $config_phone_sale1; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="phone_sale2">Телефон 2</label>
                <div class="col-sm-10">
                    <input class="form-control" id="phone_sale2" type="text" name="config_phone_sale2" value="<?php echo $config_phone_sale2; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="phone_buh">Телефон 3</label>
                <div class="col-sm-10">
                    <input class="form-control" id="phone_buh" type="text" name="config_phone_buh" value="<?php echo $config_phone_buh; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="phone_constr">Телефон 4</label>
                <div class="col-sm-10">
                    <input class="form-control" id="phone_constr" type="text" name="config_phone_constr" value="<?php echo $config_phone_constr; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="contact_email">Email</label>
                <div class="col-sm-10">
                    <input class="form-control" id="contact_email" type="text" name="config_contact_email" value="<?php echo $config_contact_email; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="contact_skype">Skype</label>
                <div class="col-sm-10">
                    <input class="form-control" id="contact_skype" type="text" name="config_contact_skype" value="<?php echo $config_contact_skype; ?>">
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tab-meta-add">
            <?php echo $this->render('setting/additional/metaProd.tpl');?>
        </div>
        <div class="tab-pane" id="tab-meta-add">
            <?php echo $this->render('setting/additional/metaProd.tpl');?>
        </div>
        <div class="tab-pane" id="tab-telegram">
            <?php echo $this->render('setting/additional/telegram.tpl');?>
        </div>
    </div>
</div>