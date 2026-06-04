<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;

class AuthLogListener
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle user login events.
     */
    public function handleLogin(Login $event): void
    {
        $user = $event->user;
        
        ActivityLog::create([
            'description' => 'User logged in',
            'causer_id' => $user->id,
            'subject_type' => get_class($user),
            'subject_id' => $user->id,
            'properties' => [
                'ip' => $this->request->ip(),
                'user_agent' => $this->request->userAgent(),
                'role' => $user->role ?? 'unknown',
            ],
        ]);
    }

    /**
     * Handle user logout events.
     */
    public function handleLogout(Logout $event): void
    {
        $user = $event->user;

        if ($user) {
            ActivityLog::create([
                'description' => 'User logged out',
                'causer_id' => $user->id,
                'subject_type' => get_class($user),
                'subject_id' => $user->id,
                'properties' => [
                    'ip' => $this->request->ip(),
                    'user_agent' => $this->request->userAgent(),
                ],
            ]);
        }
    }
}
