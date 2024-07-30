<?php

namespace Azzarip\Teavel;

use Azzarip\Teavel\Models\EmailFile;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class EmailContent
{
    public string $subject;
    public array $ctas;
    public array $parts;

    public function __construct(EmailFile $emailFile, public string $uuid)
    {
        $email = YamlFrontMatter::parse(file_get_contents(base_path('content/emails/' . $emailFile->file . '.md')));
        $this->subject = $email->subject;

        $text = $email->body();

        $this->parts = explode("CTA", $text);

        if(array_key_exists('url', $email->cta)) {
            $this->ctas = [$email->cta];
        } else {
            $this->ctas = $email->cta ?? [];
        }
    }

    public function getLinks(): array
    {
        $urls = [];
        foreach($this->ctas as $cta) {
            $urls[] = $cta['url'];
        }
        return $urls;
    }

}
