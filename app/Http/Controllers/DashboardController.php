<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function numberOfUsers()
    {
        $numberOfUser = DB::select('select count(*) AS users from User');

        $upcomingEvent = DB::select("
                                    SELECT COUNT(a.id) AS upcomingEvent
                                    FROM Entertainment AS a
                                    WHERE startTime >= ?",[strtotime(now()->format('y-m-d'))]);

        $latestEvent = DB::select("
                                    SELECT COUNT(a.id) AS latestgEvent
                                    FROM Entertainment AS a
                                    WHERE startTime < ?",[strtotime(now()->format('y-m-d'))]);

        return response()->json([
            "numberOfUser" => $numberOfUser[0]->users,
            "upcomingEvent" => $upcomingEvent[0]->upcomingEvent,
            "latestEvent" => $latestEvent[0]->latestgEvent,
        ]);
    }


}
