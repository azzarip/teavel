<?php

namespace Azzarip\Teavel\Filament\Items;

use Azzarip\Teavel\Models\Contact;
use Filament\Forms\Components\Select;

class ContactSelect
{
    public static function make()
    {
        return Select::make('contact_id')
            ->relationship('contact')
            ->required()
            ->preload()
            ->getOptionLabelFromRecordUsing(fn (Contact $record) => $record->name_email)
            ->searchable(['first_name', 'last_name', 'email']);
    }
}
