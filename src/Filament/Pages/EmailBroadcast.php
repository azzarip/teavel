<?php

namespace Azzarip\Teavel\Filament\Pages;

use App\Models\Contact;
use Azzarip\Teavel\Mail\EmailContent;
use Azzarip\Teavel\Mail\TeavelMail;
use Azzarip\Teavel\Models\Tag;
use Filament\Actions\Action;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class EmailBroadcast extends Page
{
    use InteractsWithFormActions;

    public ?string $subject = null;

    public ?string $body = null;

    public ?int $contact_id = null;

    public ?int $tag_id = null;

    public string $type = 'contact';

    protected static ?string $navigationIcon = 'heroicon-o-envelope-open';

    protected static string $view = 'teavel::filament.pages.email-broadcast';

    protected static ?string $navigationLabel = 'Email Broadcast';

    public function form(Form $form): Form
    {
        return $form
            ->operation('send')
            ->columns(2)
            ->schema([
                Select::make('type')
                    ->label('Group')
                    ->options([
                        'contact' => 'Contact',
                        'tag' => 'Tag',
                    ])
                    ->default('contact')
                    ->selectablePlaceholder(false)
                    ->placeholder(false)
                    ->required()
                    ->live()
                    ->columnSpan(1),
                Select::make('contact_id')
                    ->required()
                    ->preload()
                    ->hidden(fn (Get $get): bool => $get('type') != 'contact')
                    ->label('Contact')
                    ->searchable()
                    ->getSearchResultsUsing(fn (string $search): array => Contact::where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->get()
                        ->mapWithKeys(fn (Model $record): array => [$record->id => $record->name_email])
                        ->toArray()),
                Select::make('tag_id')
                    ->required()
                    ->preload()
                    ->hidden(fn (Get $get): bool => $get('type') != 'tag')
                    ->label('Tag')
                    ->searchable()
                    ->getSearchResultsUsing(fn (string $search): array => Tag::where('name', 'like', "%{$search}%")
                        ->get()
                        ->mapWithKeys(fn (Model $record): array => [$record->id => $record->name . " ({$record->count_contacts})"])
                        ->toArray()),
                TextInput::make('subject')->required()->columnSpanFull(),
                MarkdownEditor::make('body')
                    ->required()
                    ->disableToolbarButtons(['attachFiles'])
                    ->columnSpanFull(),
            ]);
    }

    public function send(): void
    {
        $data = $this->form->getState();

        if ($data['type'] == 'contact') {
            $contacts = Contact::where('id', $data['contact_id'])->get();
        } elseif ($data['type'] == 'tag') {
            $contacts = Tag::find($data['tag_id'])->contacts;
        }

        foreach ($contacts as $contact) {
            $content = EmailContent::raw($data['subject'], $data['body'])->to($contact);
            Mail::send(new TeavelMail($content));
        }
        Notification::make()
            ->title("{$contacts->count()} emails sent!")
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
        ];
    }

    protected function getCreateFormAction(): Action
    {
        return Action::make('send')
            ->label('Send Email')
            ->submit('send')
            ->keyBindings(['mod+s']);
    }
}
