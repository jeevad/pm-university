<?php

namespace App\Presenters;

use Auth;
use Carbon\Carbon;

trait DatePresenter
{
    /**
     * Format created_at attribute.
     *
     * @param Carbon $date
     *
     * @return string
     */
    public function getCreatedAtAttribute($date)
    {
        return $this->getDateFormated($date);
    }

    /**
     * Format updated_at attribute.
     *
     * @param Carbon $date
     *
     * @return string
     */
    public function getUpdatedAtAttribute($date)
    {
        return $this->getDateFormated($date);
    }

    /**
     * Format date.
     *
     * @param Carbon $date
     *
     * @return string
     */
    private function getDateFormated($date)
    {
        if (session('status') === 'admin' or session('status') === 'super_admin') {
            return Carbon::parse($date)->toFormattedDateString();
        } elseif (Auth::guard(env('API_GUARD'))->user() && Auth::guard(env('API_GUARD'))->user()->accessApisAll()) {
            return Carbon::parse($date)->toFormattedDateString();
        }

        return Carbon::parse($date)->format('Y-m-d H:i:s');
    }
}
