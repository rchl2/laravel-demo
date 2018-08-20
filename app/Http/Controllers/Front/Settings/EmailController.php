<?php

namespace App\Http\Controllers\Front\Settings;

use Auth;
use App\Queries\UserQueries;
use App\Http\Controllers\Controller;
use App\Jobs\Front\Settings\UpdateEmail;
use App\Events\AccountRequestedEmailChange;
use App\Jobs\Front\Settings\SetAccountForEmailChange;
use App\Http\Requests\Front\Settings\UpdateEmailRequest;

class EmailController extends Controller
{
    private $accountService;

    public function __construct($accountService)
    {
        $this->accountService = $accountService;
    }

    public function showForm()
    {
        return view('front.pages.account.email');
    }

    /**
     * Request email change.
     */
    public function requestNewEmail(UpdateEmailRequest $request)
    {
        // Check user password hash
        if ($this->accountService->checkUserPasswordHash($request->password, Auth::user()->password())) {
            // Update user with token for verification and new email.
            $this->dispatchNow(new SetAccountForEmailChange(Auth::user(), $request->new_email));

            // Fire requested email change.
            event(new AccountRequestedEmailChange(Auth::user()));

            // Redirect back and flash message.
            return back()->with('message', trans('pages/account.change_email.user_requested_email_change'));
        }

        return back()->with('message', trans('pages/account.change_email.cant_change_email'));
    }

    /**
     * Update email.
     */
    public function updateEmail(string $login, string $token)
    {
        $user = UserQueries::findToVerifyEmailChange($login);
        if ($user) {
            // Compare tokens
            $token = $this->accountService->isNewEmailTokenCorrect($user, $token);

            if ($token) {
                $this->dispatchNow(new UpdateEmail($user, $user->new_email()));

                return redirect()->route('settings')->with('message', trans('pages/account.change_email.user_changed_email'));
            } else {
                return redirect()->route('settings')->with('message', trans('pages/account.change_email.incorrect_verification_token'));
            }
        }

        return redirect()->route('settings')->with('message', trans('pages/account.change_email.no_change_for_this_user'));
    }
}
