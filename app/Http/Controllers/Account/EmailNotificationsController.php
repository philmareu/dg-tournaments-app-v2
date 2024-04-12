<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User\UserEmailNotificationType;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class EmailNotificationsController extends Controller implements HasMiddleware
{
    protected $emailNotificationType;

    public function __construct(UserEmailNotificationType $emailNotificationType)
    {
        $this->emailNotificationType = $emailNotificationType;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function index()
    {
        return view('pages.account.notifications')
            ->withUser(auth()->user())
            ->withEmailNotificationTypes($this->emailNotificationType->all());
    }

    public function update(Request $request)
    {
        if ($request->has('email_notifications')) {
            $request->user()->emailNotificationSettings()->sync($request->email_notifications);
        } else {
            $request->user()->emailNotificationSettings()->sync([]);
        }

        return redirect('account/notifications')->with('success', 'Settings updated.');
    }
}
