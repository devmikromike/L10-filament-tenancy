<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\User;
use Filament\Widgets\BarChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsersChart extends BarChartWidget
{
    use HandlesAuthorization;

    protected static ?string $heading = 'Users';
    protected static ?string $maxHeight = '300px';
    protected static ?string $maxWeight = '100px';

    protected function getData(): array {
        $users = User::select('created_at')->get()->groupBy(function($users) {
            return Carbon::parse($users->created_at)->format('F');
        });
        $quantities = [];
        foreach ($users as $user => $value) {
            array_push($quantities, $value->count());
        }
        return [
            'datasets' => [
                [
                    'label' => 'Users Joined',
                    'data' => $quantities,
                    'backgroundColor' => [
                        'rgba(255, 100, 132, 0.2)',

                    ],
                    'borderColor' => [
                        'rgb(255, 19, 132)',

                    ],
                    'borderWidth' => 3
                ],
            ],
            'labels' => $users->keys(),
        ];
    }

    public static function canView(): bool
    {
       return auth()->user()->hasAnyRole(['manager','admin']);
      // return auth()->user()->is_admin;

    }
}
