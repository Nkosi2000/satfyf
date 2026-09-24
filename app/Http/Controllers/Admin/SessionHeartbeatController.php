<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

/**
 * Pinged by resources/js/modules/admin-idle.js while the admin is moving
 * the mouse, typing, scrolling, etc. The response itself is empty — the
 * point is that the request passes through SignOutIdleSessions, which
 * refreshes the session's last-activity time, so on-page activity that
 * never loads a new page still counts as "not idle".
 */
class SessionHeartbeatController extends Controller
{
    public function __invoke(): Response
    {
        return response()->noContent();
    }
}
