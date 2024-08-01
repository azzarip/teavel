<?php

namespace Azzarip\Teavel;

use Azzarip\Teavel\Models\EmailFile;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class EmailContent
{
    public string $subject;

    protected $body;

    protected array $urls;

    public function __construct(EmailFile $emailFile, public string $uuid)
    {
        $email = YamlFrontMatter::parse(file_get_contents(base_path('content/emails/' . $emailFile->file . '.md')));
        $this->subject = $email->subject;

        $this->body = $email->body();

        $this->urls = $email->urls ?? [];
    }

    public function getLinks(): array
    {
        return $this->urls;
    }

    public function getBody()
    {
        preg_match_all('/CTA: (.*?)\\n/', $this->body, $matches);
        $ctas = $matches[1];
        $texts = preg_split('/CTA: .*?\\n/', $this->body);
        return ['ctas' => $ctas, 'texts' => $texts];
    }
}
