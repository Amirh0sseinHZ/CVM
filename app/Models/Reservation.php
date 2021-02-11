<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Reservation
 *
 * @mixin Builder
 */
class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['customer_id'];

    /**
     * Reservation Statuses
     *
     * @var array
     */
    public const STATUSES = [
        'canceled'  =>  -1,
        'waiting'   =>   0,
        'handling'  =>   1,
        'served'    =>   2
    ];

    /**
     * The length of a normal reservation in seconds
     *
     * @var int
     */
    public const RESERVATION_LENGTH = 1200;

    /**
     * Get the specialist associated to the reservation
     */
    public function specialist()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the position in the queue
     *
     * @return int
     */
    public function getPosInQueue()
    {
        return self::where([
            ['specialist_id', $this->specialist_id],
            ['status', Reservation::STATUSES['waiting']],
            ['id', '<', $this->id]
        ])->count();
    }

    /**
     * Get the estimated waiting time in the queue in seconds
     *
     * @return int
     */
    public function getEstimatedWaitingTime()
    {
        $peopleAheadInLine = $this->getPosInQueue();
        $estimatedTime = $peopleAheadInLine * self::RESERVATION_LENGTH;

        $currentSessionOfTheSpecialist = $this->specialist->getCurrentSession();
        if($currentSessionOfTheSpecialist) {
            $timePassedSinceStarted = Carbon::now()->diffInSeconds(
                $currentSessionOfTheSpecialist->updated_at
            );
            $timeRemaining = self::RESERVATION_LENGTH - $timePassedSinceStarted;
            if($timeRemaining > 0)
                $estimatedTime += $timeRemaining;
        }

        return $estimatedTime;
    }
}
