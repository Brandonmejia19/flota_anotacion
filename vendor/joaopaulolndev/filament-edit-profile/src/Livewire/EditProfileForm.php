<?php

namespace Joaopaulolndev\FilamentEditProfile\Livewire;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;
use Joaopaulolndev\FilamentEditProfile\Concerns\HasUser;

class EditProfileForm extends BaseProfileForm
{
    use HasUser;

    protected string $view = 'filament-edit-profile::livewire.edit-profile-form';

    public ?array $data = [];

    public $userClass;

    protected static int $sort = 10;

    public function mount(): void
    {
        $this->user = $this->getUser();

        $this->userClass = get_class($this->user);

        $this->form->fill($this->user->only(config('filament-edit-profile.avatar_column', 'avatar_url'), 'name', 'email'));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('filament-edit-profile::default.profile_information'))
                    ->aside()
                    ->description(__('Actualiza tu iformación personal.'))
                    ->schema([
                        FileUpload::make(config('filament-edit-profile.avatar_column', 'avatar_url'))
                            ->label(__('filament-edit-profile::default.avatar'))
                            ->directory('avatars') // Guardará en storage/app/public/avatars
                            ->image()
                            ->previewable(true)
                            ->imageEditor()->visibility('public')
                            ->disk('public') // Asegúrate de que esto apunte al disco 'public'
                            ->deletable(true)
                        //   ->visibility(config('filament-edit-profile.visibility', 'public')),
                        ,
                        TextInput::make('name')
                            ->readonly()
                            ->label(__('filament-edit-profile::default.name'))
                            ->required(),
                        TextInput::make('email')
                            ->label(__('filament-edit-profile::default.email'))
                            ->readonly()
                            ->email()
                            ->required()
                            ->unique($this->userClass, ignorable: $this->user),
                    ]),
            ])
            ->statePath('data');
    }

    public function updateProfile(): void
    {
        try {
            $data = $this->form->getState();

            $this->user->update($data);
        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title(__('filament-edit-profile::default.saved_successfully'))
            ->send();
    }
}
