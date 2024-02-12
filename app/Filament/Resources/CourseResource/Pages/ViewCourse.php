<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseResource;
use App\Models\Lesson;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;

class ViewCourse extends Page implements HasTable
{
    use InteractsWithRecord;
    use InteractsWithTable;

    protected static string $resource = CourseResource::class;

    protected static string $view = 'filament.resources.course-resource.pages.view-course';

    public function mount($record)
    {
        $this->record = $this->resolveRecord($record);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Add lesson')
                ->label('Add lesson')
                ->icon('heroicon-o-plus-circle')
                ->modalHeading('Upload Lesson')
                ->modalDescription('Some description here...')
                ->form([
                    TextInput::make('title')
                        ->required()
                        ->inlineLabel(),
                    TextInput::make('content')
                        ->required()
                        ->inlineLabel(),
                    FileUpload::make('cover_image')
                        ->visibility('public')
                        ->disk(space())
                        ->image()
                        ->inlineLabel(),
                ]),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->relationship(fn (): HasMany => $this->getRecord()->lessons())
            ->columns([
                Stack::make([
                    TextColumn::make('title')
                        ->weight(FontWeight::Bold)
                        ->searchable(),
                    TextColumn::make('content'),
                ]),
            ])
            ->contentGrid([
                'md' => 2,
            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make()
                    ->label('')
                    ->size('md')
                    ->tooltip('Edit'),
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
