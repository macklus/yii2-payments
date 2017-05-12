<form id="paypal-form" action="<?= $payment->getParameter('action'); ?>" method="post" target="<?= $payment->getParameter('form_target'); ?>">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="currency_code" value="<?= $payment->getCurrency(); ?>">
    <input type="hidden" name="amount" value="<?= $payment->getAmount(); ?>">
    <?php if ($payment->getParameter('item_name')) { ?>
        <input type="hidden" name="item_name" value="<?= $payment->getParameter('item_name'); ?>">
    <?php } ?>
    <input type="hidden" name="item_number" value="<?= $payment->getItem(); ?>">
    <input type="hidden" name="business" value="<?= $payment->getParameter('bussines'); ?>">
    <input type="hidden" name="notify_url" value="<?= $payment->getParameter('notify_url'); ?>">
    <?php if ($payment->getParameter('submit')) { ?>
        <?= $payment->getParameter('submit'); ?>
    <?php } ?>
</form>