<?php

namespace Joaopaulolndev\FilamentEditProfile\Livewire;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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
                            ->deletable(true)
                            // ->avatar()
                            ->downloadable()
                            ->avatar()
                            ->previewable(true)
                            ->imageEditor()
                            ->disk('public') // Asegúrate de que esto apunte al disco 'public'
                            ->visibility('public')
                            ->previewable(true),                        //   ->visibility(config('filament-edit-profile.visibility', 'public')),
                        TextInput::make('name')
                            ->readonly()
                            ->placeholder('Ingrese su nombre completo')
                            ->prefixicon('heroicon-o-user')
                            ->columnSpanFull()
                            ->label(__('filament-edit-profile::default.name'))
                            ->required(),
                        TextInput::make('email')
                            ->label(__('filament-edit-profile::default.email'))
                            ->readonly()
                            ->prefixicon('heroicon-o-envelope')
                            ->email()
                            ->placeholder('ejemplo@salud.gob.sv')
                            ->required()
                            ->unique($this->userClass, ignorable: $this->user),
                        TextInput::make('dui')
                            ->numeric()
                            ->placeholder('Ejemplo: 00000000-0')
                            ->prefixicon('heroicon-o-identification')
                            ->label('DUI')
                            ->required(),
                        TextInput::make('telefono')
                            ->numeric()
                            ->placeholder('Ejemplo: 7777-7777')
                            ->prefixicon('heroicon-o-phone')
                            ->label('Teléfono')
                            ->required(),
                        Select::make('cargo')
                            ->prefixicon('heroicon-o-briefcase')
                            ->options([
                                'Administrador' => 'Administrador',
                                'Empleado' => 'Empleado',
                                'Cliente' => 'Cliente',
                            ])
                            ->label('Cargo')
                            ->required(),
                    ])->columns(2),
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
