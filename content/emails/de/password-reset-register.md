---
subject: Passwortzurücksetzung
---

Hi {!!contact.first_name!!}, 

Wir haben eine Anfrage zur Zurücksetzung des Passworts mit dieser E-Mail-Adresse erhalten. Es scheint jedoch, dass diese E-Mail-Adresse nicht registriert ist.

Um loszulegen, schliessen Sie bitte Ihre Registrierung ab, indem Sie auf den folgenden Link klicken:

{% include 'button' with { 'text': 'Hier klicken, um die Registrierung abzuschliessen', 'action': '{!!url!!}', 'style': 'primary' } %}

Falls Sie glauben, dass dies ein Fehler ist oder Sie diese Anfrage nicht gestellt haben, können Sie diese E-Mail ignorieren.

Sollten Sie Unterstützung benötigen oder Fragen haben, können Sie uns gerne kontaktieren.

Vielen Dank!

{{ app_name }}
