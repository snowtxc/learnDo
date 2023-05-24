<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event;

class GoogleCalendarController extends Controller
{
    //

    public function MakeEvent($fecha, $hora, $duracion, $userEmail, $seminarioName, $seminarioDescripcion){
        $connectOauth = new ConnectOauthController();
        $connectOauth->connectOauthController();
        $event = new Event;
        $formatFecha = Carbon::createFromFormat('d/m/Y H:s', $fecha . " " . $hora);
        $endFecha = Carbon::createFromFormat('d/m/Y H:s', $fecha . " " . $hora)->addHours($duracion);

        $startTime =  $formatFecha->setTimezone("America/Montevideo")->addHours(3);
        $endTime = $endFecha->setTimezone("America/Montevideo")->addHours(3);

        $event->name = $seminarioName;
        $event->description = $seminarioDescripcion;
        $event->addAttendee([
            'email' => 'maximiliano.olivera@dualbootpartners.com',
        ]);
        // $event->addMeetLink(); // optionally add a google meet link to the event
        $event->startDateTime = $startTime;
        $event->endDateTime = $endTime;
        $event->save();
    }
}
