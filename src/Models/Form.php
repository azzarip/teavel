<?php

namespace Azzarip\Teavel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class)
            ->withPivot(['created_at', 'utm_source', 'utm_click_id', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content']);
    }

    public static function name(string $name)
    {
        $form = self::where('name', $name)->first();

        if (! $form) {
            $form = self::create([
                'name' => $name,
                'description' => 'Automatic Generated Form',
            ]);
        }

        return $form;
    }
}
