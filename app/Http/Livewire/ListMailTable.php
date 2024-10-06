<?php

namespace App\Http\Livewire;

use App\Models\SendEmail;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;


class ListMailTable extends LivewireTableComponent
{
    protected $model = SendEmail::class;

    protected $listeners = ['refresh' => '$refresh', 'resetPageTable'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPageName('list-mail-table');
        $this->setDefaultSort('created_at', 'desc');
        $this->setColumnSelectStatus(false);
        $this->setPerPage(10);

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('id')) {
                return [
                    'class' => 'd-flex justify-content-center',
                ];
            }
            return [];
        });
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.common.subject'), 'subject')
                ->sortable()->searchable(),
            Column::make(__('messages.common.description'), 'description')
                ->sortable()->searchable(),
        ];
    }

    public function builder(): Builder
    {
        return SendEmail::query();
    }

    public function resetPageTable($pageName = 'list-mail-table')
    {
        $rowsPropertyData = $this->getRows()->toArray();
        $prevPageNum = $rowsPropertyData['current_page'] - 1;
        $prevPageNum = $prevPageNum > 0 ? $prevPageNum : 1;
        $pageNum = count($rowsPropertyData['data']) > 0 ? $rowsPropertyData['current_page'] : $prevPageNum;

        $this->setPage($pageNum, $pageName);
    }
}
