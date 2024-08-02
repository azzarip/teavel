<?php

namespace Azzarip\Teavel\Models;

use Azzarip\Teavel\Exceptions\MissingClassException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Automatable extends Model
{
    use HasFactory;

    protected string $automationPath;

    public function getAutomation()
    {
        $Name = ns_case($this->name);
        $className = 'App\\Teavel\\' . $this->automationPath . '\\' . $Name;

        if (! class_exists($className)) {
            throw new MissingClassException("$Name class not found!");
        }

        return $className;
    }
}
