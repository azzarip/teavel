<?php

namespace Azzarip\Teavel\Automations;

use Illuminate\Support\Carbon;

class Wait
{
    public string $step;
    protected ?int $randomMinutes;

    public function __construct(public \Carbon\Carbon $timestamp) {}

    public static function until(string $until) {
        $timestamp = Carbon::parse($until);
        return new self($timestamp);
    }

    public static function carbon(\Carbon\Carbon $carbon) {
        return new self($carbon);
    }

    public function then(string $step) {
        $this->step = $step;
        return $this;
    }

    public function addRandomMinutes(int $max_minutes = 15) {
        $this->randomMinutes = rand(0, $max_minutes);
        return $this;
    }

    public function IsPast(): bool
    {
        return Carbon::now()->gte($this->timestamp);
    }

    public function precise()
    {
        $this->randomMinutes = 0;
    }

    public function getAdjustedTimestamp()
    {
        if(empty($this->randomMinutes)) {
            return $this->timestamp->addMinutes(rand(0, 15));
        }

        return $this->timestamp->addMinutes($this->randomMinutes);
    }
}
