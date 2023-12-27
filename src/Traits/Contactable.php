<?php

namespace Azzarip\Teavel\Traits;

trait Contactable
{
    public function getFullNameAttribute() {
        return trim($this->name . ' ' . $this->surname);
    }
}