<?php

namespace Azzarip\Teavel\Automations;

use Azzarip\Teavel\Exceptions\TeavelException;
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

        return $this;
    }

    public function getRandomizedTimestamp()
    {
        if(empty($this->randomMinutes)) {
            return $this->timestamp->addMinutes(rand(0, 15));
        }

        return $this->timestamp->addMinutes($this->randomMinutes);
    }

    public static function for(string $timeString)
    {
        $timestamp = now();
        try {
            $parts = explode(' ', $timeString);

            for ($i = 0; $i < count($parts); $i += 2) {
                $value = $parts[$i];
                $unit = $parts[$i + 1];

                switch ($unit) {
                    case 'hour':
                    case 'hours':
                        $timestamp->addHours($value);
                        break;
                    case 'minute':
                    case 'minutes':
                        $timestamp->addMinutes($value);
                        break;
                    case 'second':
                    case 'seconds':
                        $timestamp->addSeconds($value);
                        break;
                    case 'day':
                    case 'days':
                        $timestamp->addDays($value);
                        break;
                    case 'week':
                    case 'weeks':
                        $timestamp->addWeeks($value);
                        break;
                    case 'month':
                    case 'months':
                        $timestamp->addMonths($value);
                        break;
                    case 'year':
                    case 'years':
                        $timestamp->addYears($value);
                        break;
                    default:
                        throw new TeavelException("Invalid time unit: $unit");
                }
            }
        } catch (TeavelException $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        return new self($timestamp);
    }
}
