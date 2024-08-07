<?php

namespace Azzarip\Teavel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function tags()
    {
        return $this->hasMany(Tag::class, 'category_id');
    }

    public static function name(string $name)
    {
        $category = self::where('name', $name)->first();

        if (! $category) {
            $category = self::create([
                'name' => $name,
                'description' => 'Automatically generated description.',
            ]);
        }

        return $category;
    }
}
