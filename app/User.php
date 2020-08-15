<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use App\Models\Rank;
use App\Models\Settings;
use App\Models\Message;
use Carbon\Carbon;
use App\Models\Conversation;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    use Notifiable;
    /**
     * Minutes of inactivity before user is marked as offline
     */
    private $MINUTES_BEFORE_INACTIVE = 10;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'last_online'
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
     * Update last_online of user.
     */
    public function updateActivity() {
        $this->last_online = Carbon::now();
        $this->save();
    }

    /**
     * Check if user has been active in the past 10 minutes.
     */
    public function isOnline() {
        return Carbon::createFromDate($this->last_online)->diffInMinutes(Carbon::now()) < $this->MINUTES_BEFORE_INACTIVE;
    }

    /**
     * Return rank of User.
     * If Rank is null, return default rank.
     */
    public function getRank() {
        $rank = Rank::find($this->rank);
        if($rank == null) {
            $settings = Settings::first();
            $rank = Rank::find($settings->default_rank);
        }
        return $rank;
    }

    /**
     * Returns false only if user doesn't have rank and there is no default set.
     */
    public function hasRank() {
        return $this->getRank() == null ? false : true;
    }

    /**
     * Return Avatar of User.
     * If Avatar is null, return default_avatar.png.
     */
    public function getAvatar() {
        $avatar = asset('img/default_avatar.png');
        if($this->avatar != null) $avatar = base64_decode($this->avatar);
        return $avatar;
    }

    /**
     * Return URI of user profile.
     */
    public function getURI() {
        return asset('/profile/' . $this->name);
    }

    /**
     * Return all Message results for user (outgoing & incoming)
     */
    public function getConversations() {
        $conversations = [];
        $users = [];
        $messages = Message::where('sender', $this->id)->orWhere('recipient', $this->id)->get();
        foreach($messages as $m) {
            $user = $m->sender === $this->id ? $m->recipient : $m->sender;
            if(!in_array($user, $users)) array_push($users, $user);
        }
        foreach($users as $u) {
            array_push($conversations, new Conversation($this->id, $u, []));
        }
        foreach($messages as $m) {
            Conversation::addMessageToReleventConversation($m, $conversations);
        }
        return $conversations;
    }

    /**
     * Return conversation between user and $userId
     * 
     * @param {int} $userId
     */
    public function getConversation($userId) {
        $messages = Message::where('sender', $this->id)->where('recipient', $userId)->get();
        $messages2 = Message::where('recipient', $this->id)->where('sender', $userId)->get();
        return new Conversation($this->id, $userId, array_merge($messages->toArray(), $messages2->toArray()));
    }
 }