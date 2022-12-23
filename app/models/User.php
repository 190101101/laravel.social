<?php

namespace App\models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';

    protected $fillable = [
        'email',
        'username',
        'password',
        'firstname',
        'lastname',
        'location',
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

    #получить имя и фамилию или имя
    public function getName()
    {
        if($this->firstname && $this->lastname)
        {
            return "{$this->firstname} {$this->lstname}";
        }

        if($this->firstname)
        {
            return "{$this->firstname}";
        }

        if($this->lastname)
        {
            return "{$this->lastname}";
        }

        return null;
    }

    #получить имя и фамилию или логин
    public function getNameOrUsername()
    {
        return $this->getName() ?: $this->username;
    }

    #получить имя или логин
    public function getFirstNameOrUsername()
    {
        return $this->firstname ?: $this->username;
    }

    public function getAvatarUrl()
    {
        $avatar = md5('orxan_shirinov_1991@mail.ru').'?d=monsterid&s50';
        return "https://www.gravatar.com/avatar/{{$avatar}}";
    }

    #пользователю принадлежит статус
    public function statuses()
    {
        return $this->hasMany('App\models\Status', 'user_id');
    }

    #
    public function likes()
    {
        return $this->hasMany('App\models\Like', 'user_id');
    }

    #устанавливаем отношения многие ко многим, мои друзья
    public function friendsOfMine()
    {
        return $this->belongstoMany('App\Models\User', 'friends', 'user_id', 'friend_id');
    }

    #устанавливаем отношения многие ко многим, друг
    public function friendOf()
    {
        return $this->belongstoMany('App\Models\User', 'friends', 'friend_id', 'user_id');
    }

    #получает друзей
    public function friends()
    {
        return $this->friendsOfMine()->wherePivot('accepted', true)->get()
            ->merge($this->friendOf()->wherePivot('accepted', true)->get());
    }

    #запросы в друзья
    public function friendRequest()
    {
        return $this->friendsOfMine()->wherePivot('accepted', false)->get();
    }

    #запросы на ожидании друга
    public function friendRequestsPending()
    {
        return $this->friendOf()->wherePivot('accepted', false)->get();
    }

    #есть запрос на добавление друзья
    public function hasFriendRequestPending(User $user)
    {
        return (bool) $this->friendRequestsPending()->where('id', $user->id)->count();
    }

    #получил запрос о дружбе
    public function hasFriendRequestReceived(User $user)
    {
        return (bool) $this->friendRequest()->where('id', $user->id)->count();
    }
    
    #добавить друга
    public function addFriend(User $user)
    {
        return $this->friendOf()->attach($user->id);
    }

    public function deleteFriend(User $user)
    {
        $this->friendOf()->detach($user->id);
        $this->friendsOfMine()->detach($user->id);
    }

    #принять запрос на дружбу
    public function acceptFriendRequest(User $user)
    {
        return $this->friendRequest()->where('id', $user->id)->first()->pivot->update([
            'accepted' => true
        ]);
    }

    #дружить с 
    public function isFriendWith(User $user)
    {
        return (bool) $this->friends()->where('id', $user->id)->count();
    }

    #
    public function hasLikedStatus(Status $status)
    {
        return (bool) $status->likes
            ->where('likeable_id', $status->id)
            ->where('likeable_type', get_class($status))
            ->where('user_id', $this->id)
            ->count();
    }
}

