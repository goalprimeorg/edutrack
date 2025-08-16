<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\InventoryResource\Pages;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\LocalGovernmentArea;
use App\Models\State;
use App\Models\RequestType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Partner';

    public static function form(Form $form): Form
    {
        $user = Auth::user();
        $isSuperAdmin = Auth::guard('super-admin')->check();

        $stateOptions = $isSuperAdmin
            ? State::pluck('name', 'id')
            : State::where('id', $user->state_id)->pluck('name', 'id');

        return $form
            ->schema([
                Forms\Components\Hidden::make('partner_id')
                    ->default($user->id)
                    ->required(),

                Forms\Components\Select::make('state_id')
                    ->label(__('State'))
                    ->relationship('state', 'name')
                    ->options($stateOptions)
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('local_government_area_id', null);
                    })
                    ->visible($isSuperAdmin),

                Forms\Components\Select::make('local_government_area_id')
                    ->label(__('LGA'))
                    ->options(function (Forms\Get $get) use ($user, $isSuperAdmin) {
                        if (! $isSuperAdmin) {
                            return LocalGovernmentArea::where('state_id', $user->state_id)
                                ->pluck('name', 'id');
                        }

                        $stateId = $get('state_id');
                        if (! $stateId) {
                            return [];
                        }

                        return LocalGovernmentArea::where('state_id', $stateId)
                            ->pluck('name', 'id');
                    })
                    ->searchable()
                    ->required()
                    ->disabled(function (Forms\Get $get) use ($isSuperAdmin) {
                        return $isSuperAdmin && ! $get('state_id');
                    })
                    ->dehydrated(),

                Forms\Components\DatePicker::make('date_received')
                    ->label(__('Date Received'))
                    ->required()
                    ->closeOnDateSelection(),

                Forms\Components\TextInput::make('po_number')
                    ->label(__('PO Number'))
                    ->maxLength(50)
                    ->nullable(),

                Forms\Components\TextInput::make('warehouse')
                    ->label(__('Warehouse'))
                    ->maxLength(50)
                    ->nullable(),

                Forms\Components\Select::make('resource_type')
                    ->label(__('Resource Type'))
                    ->options(RequestType::pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('item_id')
                    ->label('Item')
                    ->options(
                        Item::query()
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->required(),

                Forms\Components\Textarea::make('items_description')
                    ->label(__('Items in PO (Description)'))
                    ->rows(3)
                    ->required(),

                Forms\Components\TextInput::make('quantity')
                    ->label('Quantity in PO')
                    ->required()
                    ->numeric()
                    ->default(0),

                Forms\Components\TextInput::make('quantity_received')
                    ->label(__('Quantity Received'))
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('received_by')
                    ->label(__('Received By'))
                    ->maxLength(50)
                    ->nullable(),

                Forms\Components\Textarea::make('remark')
                    ->label(__('Remark'))
                    ->rows(3)
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();
        $isSuperAdmin = Auth::guard('super-admin')->check();

        return $table
            ->modifyQueryUsing(function (Builder $query) use ($user, $isSuperAdmin) {
                if (! $isSuperAdmin) {
                    $query->where('state_id', $user->state_id);
                }
                return $query;
            })
            ->columns([
                Tables\Columns\TextColumn::make('state.name')->label(__('State'))->sortable()->searchable(),
                Tables\Columns\TextColumn::make('localGovernmentArea.name')->label(__('LGA'))->sortable()->searchable(),
                Tables\Columns\TextColumn::make('item.name')->label(__('Item'))->searchable(),
                Tables\Columns\TextColumn::make('quantity')->label(__('Quantity In PO'))->numeric()->sortable(),
                Tables\Columns\TextColumn::make('quantity_received')->label(__('Quantity Received'))->numeric()->sortable(),
                Tables\Columns\TextColumn::make('deficit')
                    ->label(__('Deficit'))
                    ->numeric()
                    ->getStateUsing(fn ($record) => max(0, ($record->quantity ?? 0) - ($record->quantity_received ?? 0))),
                Tables\Columns\TextColumn::make('date_received')->label(__('Date Received'))->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('items_description')->label(__('Item Description'))->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('partner.name')->label(__('Partner'))->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('state_id')
                    ->label(__('State'))
                    ->relationship('state', 'name')
                    ->options(function () use ($user, $isSuperAdmin) {
                        if (! $isSuperAdmin) {
                            return State::where('id', $user->state_id)->pluck('name', 'id');
                        }
                        return State::pluck('name', 'id');
                    })
                    ->visible($isSuperAdmin),

                Tables\Filters\SelectFilter::make('local_government_area_id')
                    ->label(__('Local Government Area'))
                    ->relationship('localGovernmentArea', 'name')
                    ->options(function () use ($user, $isSuperAdmin) {
                        if (! $isSuperAdmin) {
                            return LocalGovernmentArea::where('state_id', $user->state_id)
                                ->pluck('name', 'id');
                        }
                        return LocalGovernmentArea::pluck('name', 'id');
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                Tables\Actions\Action::make('assignGroup')
                    ->label('Assign Group')
                    ->icon('heroicon-o-rectangle-stack')
                    ->form([
                        Forms\Components\Select::make('group_item_id')
                            ->label('Group (Pack)')
                            ->options(\App\Models\GroupItem::pluck('name', 'id'))
                            ->searchable()
                            ->required(),

                        Forms\Components\Select::make('school_id')
                            ->label('School')
                            ->options(\App\Models\School::pluck('name', 'id'))
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('recipient_id', null)) // Clear recipient when school changes
                            ->required(),

                        Forms\Components\Select::make('recipient_type')
                            ->label('Recipient Type')
                            ->options([
                                'student' => 'Student',
                                'school_staff' => 'School Staff',
                            ])
                            ->reactive()
                            ->required()
                            ->afterStateUpdated(fn (callable $set) => $set('recipient_id', null)), // Clear recipient when type changes

                        Forms\Components\Select::make('recipient_id')
                            ->label(fn (Forms\Get $get) => $get('recipient_type') === 'school_staff' ? 'School Staff' : 'Student')
                            ->options(function (Forms\Get $get) {
                                $schoolId = $get('school_id');
                                $groupItemId = $get('group_item_id');
                                $recipientType = $get('recipient_type');

                                if (!$schoolId || !$groupItemId || !$recipientType) {
                                    return [];
                                }

                                if ($recipientType === 'student') {
                                    return \App\Models\Student::where('school_id', $schoolId)
                                        ->whereNotIn('id', function ($query) use ($groupItemId) {
                                            $query->select('student_id')
                                                ->from('student_distributions')
                                                ->where('group_item_id', $groupItemId)
                                                ->whereNotNull('student_id');
                                        })
                                        ->pluck('first_name', 'id');
                                } elseif ($recipientType === 'school_staff') {
                                    return \App\Models\SchoolStaff::where('school_id', $schoolId)
                                        ->whereNotIn('id', function ($query) use ($groupItemId) {
                                            $query->select('staff_id')
                                                ->from('student_distributions')
                                                ->where('group_item_id', $groupItemId)
                                                ->whereNotNull('staff_id');
                                        })
                                        ->pluck('first_name', 'id');
                                }

                                return [];
                            })
                            ->searchable()
                            ->required(),

                        Forms\Components\Hidden::make('group_item_id')
                            ->default(fn ($record) => $record->id)
                            ->required(),

                        Forms\Components\Textarea::make('remark')
                            ->label('Remark')
                            ->rows(2)
                            ->nullable(),
                    ])
                    ->requiresConfirmation()
                    ->action(function (array $data, Inventory $record) {
                        \DB::transaction(function () use ($data, $record) {
                            $group = \App\Models\GroupItem::with('details.item')->findOrFail($data['group_item_id']);
                            $user = Auth::user();
                            $recipientType = $data['recipient_type'];
                            $recipientId = $data['recipient_id'];

                            // Create distribution record
                            $distributionData = [
                                'group_item_id' => $group->id,
                                'distributed_by' => $user->id,
                                'distributed_at' => now(),
                                'remark' => $data['remark'] ?? null,
                            ];

                            // Set either student_id or staff_id based on recipient_type
                            if ($recipientType === 'student') {
                                $distributionData['student_id'] = $recipientId;
                                $recipient = \App\Models\Student::findOrFail($recipientId);
                            } else {
                                $distributionData['staff_id'] = $recipientId;
                                $recipient = \App\Models\SchoolStaff::findOrFail($recipientId);
                            }

                            $distribution = \App\Models\StudentDistribution::create($distributionData);

                            // For each item in group, deduct required qty from inventories in recipient's LGA/state FIFO
                            foreach ($group->details as $detail) {
                                $need = $detail->quantity;

                                // Find inventories for this item in same state/LGA as the inventory record or recipient's school
                                $inventoriesQuery = \App\Models\Inventory::where('item_id', $detail->item_id)
                                    ->where(function ($q) use ($record, $recipient) {
                                        if (isset($recipient->school_id)) {
                                            $school = \App\Models\School::find($recipient->school_id);
                                            if ($school) {
                                                $q->where('state_id', $school->state_id)
                                                  ->where('local_government_area_id', $school->local_government_area_id);
                                                return;
                                            }
                                        }
                                        if ($record->state_id) {
                                            $q->where('state_id', $record->state_id);
                                        }
                                        if ($record->local_government_area_id) {
                                            $q->where('local_government_area_id', $record->local_government_area_id);
                                        }
                                    })
                                    ->orderBy('date_received', 'asc');

                                $availableTotal = $inventoriesQuery->sum('quantity_received');
                                if ($availableTotal < $need) {
                                    throw new \Exception("Insufficient stock for item: {$detail->item->name}. Needed: {$need}, Available: {$availableTotal}");
                                }

                                // Consume across inventories FIFO
                                $remaining = $need;
                                foreach ($inventoriesQuery->get() as $inv) {
                                    if ($remaining <= 0) break;
                                    $take = min($inv->quantity_received, $remaining);
                                    $inv->decrement('quantity_received', $take);
                                    $remaining -= $take;
                                }

                                // Record distribution item
                                \App\Models\StudentDistributionItem::create([
                                    'student_distribution_id' => $distribution->id,
                                    'item_id' => $detail->item_id,
                                    'quantity' => $detail->quantity,
                                ]);
                            }
                        });
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventories::route('/'),
            'create' => Pages\CreateInventory::route('/create'),
            'view' => Pages\ViewInventory::route('/{record}'),
        ];
    }
}