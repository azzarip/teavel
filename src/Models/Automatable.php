<?php

namespace Azzarip\Teavel\Models;

use Azzarip\Teavel\Automations\SequenceHandler;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Automatable extends Model
{
    use HasFactory;

    protected readonly string $automationPath;

    public function getAutomation()
    {
        $Name = ns_case($this->name);
        $className = 'App\\Teavel\\' . $this->automationPath . '\\' . $Name;

        if (! class_exists($className)) {
            throw new MissingClassException("Sequence $Name class not found!");
        }

        return $className;
    }
}