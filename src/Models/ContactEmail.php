<?php

namespace Azzarip\Teavel\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

class ContactEmail extends Pivot
{
    public $timestamps = false;
    protected $casts = [
        'sent_at' => 'datetime',
        'clicked_at' => 'datetime',
    ];


    public function reset()
    {
        $this->clicked_at = null;
        $this->sent_at = now();
        $this->save();

        return $this;
    }

    public function click()
    {

        if($this->clicked_at) return $this;

        $this->clicked_at = now();
        $this->save();

        return $this;
    }


}
