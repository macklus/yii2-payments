<form id="redsys" name="frm" action="<?= $payment->getParameter('urlPago') ?>" method="POST">
    <input type="hidden" name="Ds_SignatureVersion" value="<?= $payment->getParameter('version') ?>"/></br>
    <input type="hidden" name="Ds_MerchantParameters" value="<?= $payment->getMerchantParameters() ?>"/></br>
    <input type="hidden" name="Ds_Signature" value="<?= $payment->getSignature() ?>" /></br>
    <?php
    $submit = $payment->getParameter('submit');
    if ($submit) {
        echo $submit;
    }
    ?>
</form>