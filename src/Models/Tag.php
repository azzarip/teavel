<?php

namespace Azzarip\Teavel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'category_id'];

    public function category()
    {
        return $this->belongsTo(TagCategory::class, 'category_id');
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class)
            ->withPivot('tagged_at');
    }

    public function getCountContactsAttribute()
    {
        return $this->contacts()->count();
    }

    public static function name(string $name)
    {
        $tag = self::where('name', $name)->first();

        if (! $tag) {
            $category = TagCategory::name('unassigned');
            $tag = self::create([
                'name' => $name,
                'description' => 'Automatic Generated Tag',
                'category_id' => $category->id,
            ]);
        }

        return $tag;
    }
}
