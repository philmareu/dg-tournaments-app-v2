<?php

namespace App\Models\User;

use Database\Factories\UserEmailNotificationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEmailNotificationType extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UserEmailNotificationFactory::new();
    }
}
