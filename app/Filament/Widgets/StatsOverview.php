<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array {

        $prosent = '40%';
        $data = [170, 20, 10, 3, 15, 40, 170];

        return [
            Card::make('Unique views', '192.1k')
                ->description('32k increase')
                ->chart($data)
                ->descriptionIcon('heroicon-s-trending-up'),
            Card::make('Bounce rate', $prosent)
                ->description('7% increase')
                ->descriptionIcon('heroicon-s-trending-down'),
            Card::make('Average time on page', '3:12')
                ->description('3% increase')
                ->descriptionIcon('heroicon-s-trending-up'),
        ];
    }
}
