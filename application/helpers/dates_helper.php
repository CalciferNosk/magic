<?php

if (!function_exists('_getDatesByRange')) :
    function _getDatesByRange($start_date, $end_date)
    {
        $end_date->modify('1 day');
        $period = new DatePeriod($start_date, new DateInterval('P1D'), $end_date);
        $available_dates = [];
        foreach ($period as $v) :
            $available_dates[] = $v->format('Y-n-j');
        endforeach;

        return $available_dates;
    }
endif;
