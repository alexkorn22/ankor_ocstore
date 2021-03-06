<?php if (count($currencies) > 1) { ?>
<div class="pull-left">
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-currency">
    <div class="btn-group">
    <button class="btn btnh btn-link dropdown-toggle" data-toggle="dropdown">
    <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_currency; ?></span> 
    <?php foreach ($currencies as $currency) { ?>
    <?php if ($currency['symbol_left'] && $currency['code'] == $code) { ?>
    <strong class="current_col">&nbsp;<?php echo $currency['symbol_left']; ?>&nbsp;&nbsp;</strong>
    <?php } elseif ($currency['symbol_right'] && $currency['code'] == $code) { ?>
    <strong class="current_col">&nbsp;<?php echo $currency['symbol_right']; ?>&nbsp;&nbsp;</strong>
    <?php } ?>
    <?php } ?><i class="fa fa-caret-down"></i></button>
    <ul class="dropdown-menu">
      <?php foreach ($currencies as $currency) { ?>
      <?php if ($currency['symbol_left']) { ?>
      <li><button class="currency-select btn btnh btn-link btn-block" type="button" name="<?php echo $currency['code']; ?>"><?php echo $currency['symbol_left']; ?> <?php echo $currency['title']; ?></button></li>
      <?php } else { ?>
      <li><button class="currency-select btn btnh btn-link btn-block" type="button" name="<?php echo $currency['code']; ?>"><?php echo $currency['symbol_right']; ?> <?php echo $currency['title']; ?></button></li>
      <?php } ?>
      <?php } ?>
    </ul>
  </div>
  <input type="hidden" name="code" value="" />
  <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
</form>
</div>
<?php } ?>
