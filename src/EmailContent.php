<?php

namespace Azzarip\Teavel;

use Azzarip\Teavel\Models\EmailFile;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class EmailContent
{
    public string $subject;

    public $body;

    public $html;

    public function __construct(EmailFile $emailFile, public string $uuid)
    {
        $email = YamlFrontMatter::parse(file_get_contents(base_path('content/emails/' . $emailFile->file . '.md')));
        $this->subject = $email->subject;
        $this->body = $email->body();
        $this->html = $this->getHtml();
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getHtml()
    {
        $body = $this->setHtmlNamespace($this->body);
        $footer = $this->buildFooter();
        $view = '<x-teavel::mail.html.layout>' . $body . $footer . '</x-teavel::mail.html.layout>';
        $html = \Illuminate\Support\Facades\Blade::render($view, []);
        dd($html);
        
        return $this->redactUrls($html);
    }

    protected function redactUrls($html) 
    {
        $url = $this->getClickUrl();

        return str_replace('href="/', 'href="' . $url . '/', $html);
    }

    protected function getUnsubscribeLink()
    {
        return url("/tvl/{UUID}/email/{$this->uuid}/unsubscribe");
    }

    protected function getClickUrl()
    {
        return url("/tvl/{UUID}/email/{$this->uuid}");
    }

    protected function buildFooter() 
    {

        return <<<EOD
        <x-slot:footer><x-teavel::mail.html.footer>
        
        @lang('teavel::email.footer_pre')
        {FOOTER_DATE} 
        @lang('teavel::email.footer_post')
        
        <p><a href='{$this->getUnsubscribeLink()}'>@lang('teavel::email.unsubscribe')</a></p>
    
        <p>{{ config('teavel.company') }}</p>
        </x-teavel::mail.html.footer>
        </x-slot:footer>
        EOD;
        
    }

    
    protected function setHtmlNamespace($html)
    {  
        return str_replace('mail::', 'teavel::mail.html.', $html);
    }

}
