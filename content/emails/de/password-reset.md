---
subject: Passwortzurücksetzung
---
# Passwortzurücksetzungsanfrage

Wir haben eine Anfrage zur Zurücksetzung des Passworts für Ihr Konto erhalten. Um mit der Passwortzurücksetzung fortzufahren, klicken Sie bitte auf den folgenden Link:

{% include 'button' with { 'text': 'Klicken Sie hier, um das Passwort zurückzusetzen', 'action': '{!!url!!}&uuid={!!contact.uuid!!}', 'style': 'primary' } %}

Falls Sie diese Anfrage nicht gestellt haben, können Sie diese E-Mail ignorieren. Ihr Passwort bleibt unverändert.

Aus Sicherheitsgründen ist dieser Link **nur 60 Minuten gültig**. Wenn Sie Probleme bei der Passwortzurücksetzung haben, wenden Sie sich bitte an unser Support-Team.

Vielen Dank!

{{ app_name }}
