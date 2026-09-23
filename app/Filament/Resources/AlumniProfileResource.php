<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlumniProfileResource\Pages;
use App\Models\AlumniProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AlumniProfileResource extends Resource
{
    protected static ?string $model = AlumniProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Mezunlar';

    protected static ?string $modelLabel = 'Mezun';

    protected static ?string $pluralModelLabel = 'Mezunlar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Hesap ve Bölüm Bilgileri')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Kullanıcı')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('department_id')
                            ->label('Bölüm')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('student_number')
                            ->label('Öğrenci Numarası')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('graduation_year')
                            ->label('Mezuniyet Yılı')
                            ->numeric()
                            ->minValue(1950)
                            ->maxValue(2035),
                    ])->columns(2),

                Forms\Components\Section::make('Kariyer ve İletişim Bilgileri')
                    ->schema([
                        Forms\Components\TextInput::make('current_company')
                            ->label('Şu Anki Şirket/Kurum')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('current_position')
                            ->label('Unvan / Pozisyon')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('city')
                            ->label('Şehir')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('country')
                            ->label('Ülke')
                            ->default('Turkey')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('phone')
                            ->label('Telefon Numarası')
                            ->tel()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('linkedin_url')
                            ->label('LinkedIn Profili')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('github_url')
                            ->label('GitHub Profili')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('cv_path')
                            ->label('Özgeçmiş (CV)')
                            ->directory('alumni-cvs')
                            ->acceptedFileTypes(['application/pdf']),
                        Forms\Components\Textarea::make('bio')
                            ->label('Hakkında / Biyografi')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Onay Durumu')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Durum')
                            ->options([
                                'pending' => 'Onay Bekliyor (Pending)',
                                'approved' => 'Onaylandı (Approved)',
                                'rejected' => 'Reddedildi (Rejected)',
                            ])
                            ->default('pending')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Ad Soyad')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('E-posta')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('department.name')
                    ->label('Bölüm')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('graduation_year')
                    ->label('Mezuniyet')
                    ->sortable(),
                Tables\Columns\TextColumn::make('current_company')
                    ->label('Şirket')
                    ->searchable(),
                Tables\Columns\TextColumn::make('current_position')
                    ->label('Pozisyon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('Şehir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Onay Durumu')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'approved' => 'Onaylı',
                        'pending' => 'Onay Bekliyor',
                        'rejected' => 'Reddedildi',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Kayıt Tarihi')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('department_id')
                    ->label('Bölüme Göre')
                    ->relationship('department', 'name'),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Onay Durumuna Göre')
                    ->options([
                        'pending' => 'Onay Bekleyenler',
                        'approved' => 'Onaylananlar',
                        'rejected' => 'Reddedilenler',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Onayla')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (AlumniProfile $record): bool => $record->status !== 'approved')
                    ->action(fn (AlumniProfile $record) => $record->update(['status' => 'approved'])),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve_all')
                        ->label('Seçilenleri Onayla')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['status' => 'approved'])),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlumniProfiles::route('/'),
            'create' => Pages\CreateAlumniProfile::route('/create'),
            'edit' => Pages\EditAlumniProfile::route('/{record}/edit'),
        ];
    }
}
