<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * User
 *
 * @mixin Builder
 */
class User extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * Indicate whether the model should have timestamps
     */
    public $timestamps = false;

    /**
     * Get all the reservations of the specialist
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'specialist_id');
    }

    /**
     * Get all the waiting reservations of the specialist
     */
    public function getWaitingReservations()
    {
        return $this->reservations()->where('status',
            Reservation::STATUSES['waiting'])->get();
    }

    /*
     * Get the current session of the specialist being handled
     */
    public function getCurrentSession()
    {
        return $this->reservations()->where('status',
            Reservation::STATUSES['handling'])->first();
    }

    /*
     * Get the estimated waiting time for the specialist in seconds
     */
    public function estimatedWaiting()
    {
        $countOfWaitingReservations = $this->getWaitingReservations()->count();
        $estimatedTime = $countOfWaitingReservations * Reservation::RESERVATION_LENGTH;

        $currentSession = $this->getCurrentSession();
        if($currentSession) {
            $timePassedSinceStarted = Carbon::now()->diffInSeconds(
                $currentSession->updated_at
            );
            $timeRemaining = Reservation::RESERVATION_LENGTH - $timePassedSinceStarted;
            if($timeRemaining > 0)
                $estimatedTime += $timeRemaining;
        }

        return $estimatedTime;
    }
}
