<?php

namespace Azzarip\Teavel\Models;

use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\File;
use Azzarip\Teavel\Models\CompiledForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Form extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'namespace'];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_form')->using(CompiledForm::class)
                ->withPivot(['id', 'created_at', 'utm_source_id', 'utm_click_id', 'utm_medium_id', 'utm_campaign_id', 'utm_term_id', 'utm_content_id']);
    }

    public static function name(string $name)
    {
        $form = self::where('name', $name)->first();

        if (! $form) {
            $form = self::create([
                'name' => $name,
                'namespace' => '\\App\\Teavel\\Goals\\Forms\\',
                'description' => 'Automatic Generated Form',
            ]);
        }

        $form->findClass();
        return $form;
    }

    protected function findClass()
    {
        $name =
        $allFiles = File::allFiles(app_path("Teavel/Goals/Forms/"));

        foreach ($allFiles as $file) {
            if ($file->getFilename() === $name . '.php') {
                $match = $file->getPathname();
                break;
            }
        }
        require_once $match;
        $class = new \App\Teavel\Goals\Forms\Formbb();
        dd($class);
    }
}
