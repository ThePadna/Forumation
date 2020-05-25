<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use App\Models\Rank;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Return rank of User.
     */
    public function getRank() {
        return Rank::find($this->rank);
    }

    /**
     * Return Avatar of User.
     * If Avatar is null, return default_avatar.png.
     */
    public function getAvatar() {
        $avatar = asset('default_avatar.png');
        if($this->avatar != null) $avatar = $this->avatar;
        return $avatar;
    }

    /**
     * Return URI of user profile.
     */
    public function getURI() {
        return "/forum/profile/" . $this->name;
    }
 }