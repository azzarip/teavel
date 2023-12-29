<?php

namespace Azzarip\Teavel\Filament\ContactPanel\Resources\Dashboard\Widgets;

use Azzarip\Teavel\Models\Contact;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ContactsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $total_contacts = Contact::count();
        $last_week = Contact::where('created_at', '>', Carbon::now()->subWeek())->count();

        return [
            Stat::make('Contacts', $total_contacts)
            ->description('+'. $last_week . ' in last week')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success')
        ];
    }
}
