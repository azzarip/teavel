<?php

namespace Azzarip\Teavel;

use Spatie\YamlFrontMatter\YamlFrontMatter;

class EmailContent
{
    public string $subject; 
    public array $cta; 
    public bool $has_cta;
    public array $parts;

    public function __construct(EmailFile $emailFile, public string $uuid)
    {
        $email = YamlFrontMatter::parse(file_get_contents(base_path('content/emails/' . $emailFile->file . '.md')));
        $this->subject = $email->subject;

        $text = $email->body();
        $this->has_cta = strpos($text, "CTA\n");
        
        if($this->has_cta) {
            $this->parts = explode("CTA\n", $text);
            $this->cta = $email->cta;
        } else {
            $this->parts = [$text];
        }
    }

}