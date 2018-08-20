<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Queries\PlayerQueries;

class SidebarsComposer
{
    /**
     * Bind data to the view (sidebars).
     */
    public function compose(View $view)
    {
        $view->with(['players' => PlayerQueries::getForSidebarRanklist(10)]);
    }
}
