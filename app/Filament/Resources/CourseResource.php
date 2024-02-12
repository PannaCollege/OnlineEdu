<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\Pages\ViewCourse;
use App\Models\Course;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Course Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->inlineLabel(),
                        DatePicker::make('start_date')
                            ->required()
                            ->date()
                            ->inlineLabel(),
                        DatePicker::make('end_date')
                            ->required()
                            ->date()
                            ->inlineLabel(),
                        FileUpload::make('cover_image')
                            ->visibility('public')
                            ->disk(space())
                            ->image()
                            ->inlineLabel(),
                        Toggle::make('is_active')
                            ->default(true)
                            ->inlineLabel(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('start_date')
                    ->date('d/m/Y'),
                TextColumn::make('end_date')
                    ->date('d/m/Y'),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('instructor.name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('detail')
                    ->label('')
                    ->size('md')
                    ->icon('heroicon-o-magnifying-glass')
                    ->tooltip('Detail')
                    ->url(fn (Course $course) => route('filament.admin.resources.courses.detail', $course)),
                Tables\Actions\EditAction::make()
                    ->label('')
                    ->size('md')
                    ->tooltip('Edit'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
            'detail' => ViewCourse::route('/{record}/detail'),
        ];
    }
}
