<?php

namespace Azzarip\Teavel\Mail;

use Azzarip\Teavel\Exceptions\TeavelException;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

class EmailContent
{
    public Contact $contact;

    protected array $data = [];

    public string $html;

    protected ?string $uuid = '';

    public static function raw(string $subject, string $body)
    {
        return new self($subject, $body);
    }

    public static function fromFile(string $emailPath)
    {
        if (! File::exists($emailPath)) {
            throw new TeavelException("File $emailPath does not exist");
        }

        $email = YamlFrontMatter::parse(file_get_contents($emailPath));

        if (empty($email->matter())) {
            throw new TeavelException("Invalid subject in file $emailPath");
        }

        if (empty($email->body())) {
            throw new TeavelException("Invalid body in file $emailPath");
        }

        return new self($email->subject, $email->body());
    }

    public function __construct(public string $subject, public string $body) {}

    public function to(Contact $contact)
    {
        $this->contact = $contact;

        return $this;
    }

    public function with(array $data)
    {
        $this->data = $data;

        return $this;
    }

    public function emailUuid(string $uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function render()
    {
        if (empty($this->contact)) {
            throw new TeavelException('Contact Not Set');
        }
        $loader = new ArrayLoader([
            'layout' => file_get_contents(__DIR__ . '/../../resources/views/email/html/layout.twig'),
            'email' => Str::markdown($this->body),
            'button' => file_get_contents(__DIR__ . '/../../resources/views/email/html/button.twig'),
        ]);

        $twig = new Environment($loader, ['autoescape' => false]);

        $this->html = $twig->render('layout', [
            'contact' => $this->contact,
            'app_name' => config('app.name'),
            'footer' => $this->buildFooter(),
        ] + $this->data);

        $this->renderCss();
        $this->redactUrls();
        $this->cleanHtml();

        return $this->html;
    }

    protected function redactUrls()
    {
        if (empty($this->uuid)) {
            return;
        }

        $url = $this->getClickUrl();
        $this->html = str_replace('href="/', 'href="' . $url . '/', $this->html);
    }

    protected function getUnsubscribeLink()
    {
        return url("/tvl/{$this->contact->uuid}/email/{$this->uuid}/unsubscribe");
    }

    protected function getClickUrl()
    {
        return url("/tvl/{$this->contact->uuid}/email/{$this->uuid}");
    }

    protected function buildFooter()
    {
        $footer = '';

        if ($this->uuid) {
            $unsubscribe = trans('teavel::email.unsubscribe');
            $footer .= "<a href='{$this->getUnsubscribeLink()}' style='font-size: 10px; color: gray;'>{$unsubscribe}</a>";
        }

        if (config('teavel.company')) {
            $footer = '<p>' . config('teavel.company') . '</p>';
        }

        return $footer;
    }

    protected function cleanHtml()
    {
        $this->html = str_replace('<p><table', '<table', $this->html);
        $this->html = str_replace("</table>\n</p>\n", "</table>\n", $this->html);
    }

    protected function renderCss()
    {
        $css = file_get_contents(__DIR__ . '/../../resources/css/email.css');

        if (File::exists(resource_path('css/email.css'))) {
            $css .= "\n" . file_get_contents(resource_path('css/email.css'));
        }
        $this->html = (new CssToInlineStyles)->convert($this->html, $css);
    }

    public function getAddress()
    {
        return new Address($this->contact->email, $this->contact->full_name);
    }
}
