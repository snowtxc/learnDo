<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventStreamController extends Controller
{
    public function stream(){
        return response()->stream(function () {
            while (true) {
                echo "event: ping\n";
                $curDate = date(DATE_ISO8601);
                echo 'data: {"time": "' . $curDate . '"}';
                echo "\n\n";

                // echo 'data: {"total_trades":' . $trades->count() . '}' . "\n\n";

                // if ($latestTrades) {
                //     echo 'data: {"latest_trade_user":"' . $latestTrades->user->name . '", "latest_trade_stock":"' . $latestTrades->stock->symbol . '", "latest_trade_volume":"' . $latestTrades->volume . '", "latest_trade_price":"' . $latestTrades->stock->price . '", "latest_trade_type":"' . $latestTrades->type . '"}' . "\n\n";
                // }

                ob_flush();
                flush();

                // Break the loop if the client aborted the connection (closed the page)
                if (connection_aborted()) {break;}
                usleep(50000); // 50ms
            }
        }, 200, [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream',
        ]);
    }
}
