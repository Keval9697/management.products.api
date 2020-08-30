<?php

namespace App\Widgets;

use App\Models\Picklist;
use Arrilot\Widgets\AbstractWidget;
use Carbon\Carbon;

class UserPickCounts extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count_per_user = Picklist::query()
            ->select('picker_user_id', \DB::raw('count(*) as total'), 'users.name')
            ->whereDate('picked_at', '>', Carbon::now()->subDays(7))
            ->leftJoin('users', 'picker_user_id', '=', 'users.id')
            ->groupBy('picker_user_id')
            ->get();

        return view('widgets.user_pick_counts', [
            'config' => $this->config,
            'count_per_user' => $count_per_user,
        ]);
    }
}