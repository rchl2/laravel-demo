<?php

namespace App\Http\Controllers\Front\Settings;

use Auth;
use App\Models\User;
use App\Services\AccountService;
use App\Http\Controllers\Controller;
use App\Jobs\Front\Settings\UpdatePassword;
use App\Http\Requests\Front\Settings\UpdatePasswordRequest;

class PasswordController extends Controller
{
    private $accountService;

    public function __construct($accountService)
    {
        $this->accountService = $accountService;
    }

    public function showForm()
    {
        return view('front.pages.account.password');
    }

    /**
     * Update password for user.
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        // Check user password hash.
        if ($this->accountService->checkUserPasswordHash($request->old_password, Auth::user()->password())) 
        {
            // Dispatch job.
            $this->dispatchNow(new UpdatePassword(Auth::user(), $request->new_password));

            // Logout and redirect to home.
            Auth::logout();
            return redirect()->route('home');
        }

        return back()->with('message', trans('pages/account.change_password.cant_change_password'));
    }
}
