<?php

namespace App\Enums;


enum AppointmentStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case DONE = 'done';
    case CANCEL = 'cancel';
    case RESCHEDULE = 'reschedule';
    case REJECT = 'reject';

    public static function toArray(): array
    {
        $array = [];

        foreach(self::cases() as $case){
            $array[] = $case->value;
        }

        return $array;
    }
}
