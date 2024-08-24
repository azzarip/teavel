---
subject: Password Reset Request
---

Hi!

We received a request to reset the password using this email address. However, it appears that this email address is not registered.

To get started, please complete your registration by clicking the link below:

{% include 'button' with { 'text': 'Click here to complete the registration', 'action': '{!!url!!}', 'style': 'primary' } %}

If you believe this is an error or if you did not make this request, you can ignore this email.

If you need any assistance or have questions, feel free to contact us.

Thank you!

{{ app_name }}
