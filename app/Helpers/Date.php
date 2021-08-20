<?php


namespace App\Helpers;


class Date
{
    public function readableDateFirebase($data) {
        return str_replace(array('T', 'Z'), array(' ', ''), $data);
    }

}