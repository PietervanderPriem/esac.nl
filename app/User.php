<?php

namespace App;

use App\Models\ApplicationForm\ApplicationResponse;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'firstname',
        'preposition',
        'lastname',
        'street',
        'houseNumber',
        'city',
        'zipcode',
        'country',
        'phonenumber',
        'phonenumber_alt',
        'emergencyNumber',
        'emergencyHouseNumber',
        'emergencystreet',
        'emergencycity',
        'emergencyzipcode',
        'emergencycountry',
        'birthDay',
        'kind_of_member',
        'IBAN',
        'BIC',
        'incasso',
        'remark',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Rol', 'rol_user');
    }

    public function certificates()
    {
        return $this->belongsToMany('App\Certificate', 'certificate_user')
            ->withTimestamps()->withTrashed();
    }

    public function hasRole(...$rols)
    {
        foreach ($rols as $rol) {
            if ($this->roles->contains($rol)) {
                return true;
            }
        }
        return false;

    }

    public function getCertificationsAbbreviations()
    {
        $certificates = "";
        foreach ($this->certificates as $certificate) {
            $certificates .= $certificate->abbreviation . ", ";
        }
        return trim($certificates, ", ");
    }

    //checks if a user has role like admin or content administrator
    public function hasBackendRigths()
    {
        return count($this->roles) > 0;
    }

    public function getName()
    {
        $name = $this->firstname;
        $name .= ($this->preposition == null) ? ' ' : ' ' . $this->preposition . ' ';
        $name .= $this->lastname;

        return $name;
    }

    public function isOldMember()
    {
        return $this->lid_af !== null;
    }

    public function isPendingMember()
    {
        return $this->pending_user !== null;
    }

    public function isActiveMember()
    {
        return ($this->lid_af === null && $this->pending_user === null);
    }

    public function removeAsActiveMember()
    {
        $this->lid_af = Carbon::now();
        $this->save();

        $this->roles()->detach();

        if (Auth::user()->id === $this->id) {
            Auth::logout();
        }
    }

    public function makeActiveMember()
    {
        if ($this->email) {
            $this->lid_af = null;
            $this->save();
        }
    }

    public function getAdress()
    {
        return $this->street . " " . $this->houseNumber;
    }

    public function applicationResponses()
    {
        return $this->hasMany(ApplicationResponse::class, 'user_id');
    }

    public function approveAsPendingMember()
    {
        $this->pending_user = null;
        $this->save();
    }
    public function removeAsPendingMember()
    {
        $this->delete();
    }

}
