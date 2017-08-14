<?php if ($payment->mode == 'dev' || $payment->isDebug) { ?>
    <strong><?= Yii::t('payments', 'WARNING') ?>:</strong> <?= Yii::t('payments', 'You are running on test mode') ?><br>
    <p><?= Yii::t('payments', 'You can test your config with') ?>:</p>
    <ul>
        <li><strong><?= Yii::t('payments', 'Credit card') ?>: </strong>4548812049400004</li>
        <li><strong><?= Yii::t('payments', 'Expiration') ?>: </strong>12/20</li>
        <li><strong><?= Yii::t('payments', 'CVV2') ?>: </strong>123</li>
        <li><strong><?= Yii::t('payments', 'CIP') ?>: </strong>123456</li>
    </ul>
<?php } ?>

<form id="redsys" name="frm" action="<?= $provider->getParameter('urlPago') ?>" method="POST">
    <input type="hidden" name="Ds_SignatureVersion" value="<?= $provider->getParameter('version') ?>"/></br>
    <input type="hidden" name="Ds_MerchantParameters" value="<?= $provider->getMerchantParameters() ?>"/></br>
    <input type="hidden" name="Ds_Signature" value="<?= $provider->getSignature() ?>" /></br>
    <?php
    $submit = $payment->getParameter('submit');
    if ($submit) {
        echo $submit;
    }
    ?>
</form>