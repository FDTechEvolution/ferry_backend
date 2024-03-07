<?php
namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CalendarHelper
{
    public static function getMonthCalendar($date = null)
    {
        $date = empty($date) ? Carbon::now() : Carbon::createFromDate($date);
        $startOfCalendar = $date->copy()->firstOfMonth()->startOfWeek(Carbon::SUNDAY);
        $endOfCalendar = $date->copy()->lastOfMonth()->endOfWeek(Carbon::SATURDAY);
        $month = $date->format('n');

        //Log::debug($startOfCalendar);
        //Log::debug($endOfCalendar);

        //Build data to array
        $data = [];
        while ($startOfCalendar <= $endOfCalendar) {
            array_push($data, [
                'day' => $startOfCalendar->format('j'),
                'day_name' => $startOfCalendar->format('l'),
                'day_of_week' => $startOfCalendar->format('N'),
                'current_month'=>$startOfCalendar->format('n') == $month?'Y':'N',
                'date' => $startOfCalendar,
            ]);

            $startOfCalendar->addDay();
        }

        $rows = array_chunk($data,7);

        return $rows;
    }
}
