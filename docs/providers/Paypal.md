# Paypal provider

Yii2-payments implement Paypal form generation, and Paypal responde handle (thanks to c006/yii2-paypal-ipn plugin)

You should configure this plugin in your web.php config file, or related, by using:

---

#### live (Type: `boolean`, Default value: `false`)

Define if this config is production ready config or not. Set true only in your
prod environment

---

#### debug (Type: `boolean`, Default value: `false`)

Show debug information on plugin execution

---

#### action (Type: `string`, Default value: `https://www.paypal.com/cgi-bin/webscr`)

Form action where we should send our form.

---

#### bussines (Type: `string`)

Your bussines email identification

---

#### notify_url (Type: `string`)

Where Paypal should send IPN notifications. Typical should be something like
https://my.domain/payments/paypal

