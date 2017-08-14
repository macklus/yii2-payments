# Redsys provider

[Redsys](http://www.redsys.es/) is a TPV provider from Spain.

Yii2-payments implement this provider

You should configure this provider in your web.php config file, or related, by using:

---
#### urlPago (Type: `string`)

This URL should be provided by Redsys when you activate your account.
Current urls are:

 - **Dev:** https://sis-t.redsys.es:25443/sis/realizarPago
 - **Prod:** https://sis.redsys.es/sis/realizarPago

---
#### key (Type: `string`)

Encription key provided by Redsys

---
#### merchant (Type: `string`)

Commerce id provided by Redsys

---
#### terminal (Type: `number`)

Terminal id provided by Redsys. Usually 1

---
#### currency (Type: `number`)

Currency value provided by Redsys.

---
#### transactionType (Type: `number`)

Provided by Redsys. Usually 0

---
#### merchantURL (Type: `string`)

Where Redsys should send IPN notifications. Typical should be something like
https://my.domain/payments/redsys

