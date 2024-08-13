<?php

namespace Azzarip\Teavel\Mail;

use Twig\Environment;
use Illuminate\Support\Str;
use Twig\Loader\ArrayLoader;
use Azzarip\Teavel\Models\EmailFile;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class EmailContent
{
    public string $subject;


    public $html;

    public function __construct(EmailFile $emailFile, public string $uuid)
    {
        $email = YamlFrontMatter::parse(file_get_contents(base_path('content/emails/' . $emailFile->file . '.md')));
        $this->subject = $email->subject;
        $this->html = $this->getHtml($email->body());
    }

    protected function getHtml($body)
    {

        $loader = new ArrayLoader([
            'layout' => file_get_contents(__DIR__ . '/../../resources/views/email/html/layout.twig'),
            'email' => Str::markdown($body),
            'button' => file_get_contents(__DIR__ . '/../../resources/views/email/html/button.twig'),
        ]);

        $twig = new Environment($loader, [
            'autoescape' => false,
        ]);

        $html = $twig->render('layout', [
            'title' => config('app.name'),
            'footer' => $this->buildFooter(),
        ]);

        $html = $this->redactUrls($html);
        $html = $this->cleanHtml($html);
        $html = $this->renderCss($html);
        return $html;
    }


    protected function redactUrls($html)
    {
        $url = $this->getClickUrl();

        return str_replace('href="/', 'href="' . $url . '/', $html);
    }

    protected function getUnsubscribeLink()
    {
        return url("/tvl/{! contact.uuid !}/email/{$this->uuid}/unsubscribe");
    }

    protected function getClickUrl()
    {
        return url("/tvl/{! contact.uuid !}/email/{$this->uuid}");
    }

    protected function buildFooter()
    {
        $unsubscribe = trans('teavel::email.unsubscribe');
        $footer =  '<p>' .
            trans('teavel::email.footer_pre') . '{{ footer_date }}' . trans('teavel::email.footer_post') . '</p>';
        $footer .= "<a href='{$this->getUnsubscribeLink()}'>{$unsubscribe}</a>";

        if(config('teavel.company')) {
            $footer .= "<p>" . config('teavel.company') . "</p>";
        }

        return $footer;
    }

    protected function cleanHtml($html)
    {
        $html = str_replace('{!', '{{', $html);
        $html = str_replace('!}', '}}', $html);
        $html = str_replace('<p><table', '<table', $html);
        $html = str_replace("</table>\n</p>\n", '</table>\n', $html);
        return $html;
    }

    protected function renderCss($html)
    {
        $css = file_get_contents(__DIR__ . '/../../resources/css/email.css');

        if(File::exists(resource_path('css/email.css'))){
            $css .= '\n' . file_get_contents(resource_path('css/email.css'));
        }
        return (new CssToInlineStyles())->convert($html, $css);
    }


}
