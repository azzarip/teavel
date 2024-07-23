<?php

namespace App\Teavel\Sequences;

use Azzarip\Teavel\Automations\SequenceAutomation;

class SequenceMock extends SequenceAutomation
{
    public function start()
    {
        return 'hello!';
    }
}
