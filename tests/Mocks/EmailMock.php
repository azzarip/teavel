<?php

namespace Azzarip\Teavel\Tests\Mocks;
use Azzarip\Teavel\Automations\EmailAutomation;

class EmailMock extends EmailAutomation
{
    public function click(){
        return '/test';
    }
}
