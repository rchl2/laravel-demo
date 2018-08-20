<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Alert;
use App\Models\User;
use App\Queries\UserQueries;
use Illuminate\Http\Request;
use App\Services\AccountService;
use App\Http\Controllers\Controller;
use App\Jobs\Admin\Account\UpdateUser;
use App\Jobs\Admin\Account\BlockAccount;
use App\Jobs\Admin\Account\UnblockAccount;
use App\Http\Requests\Admin\Account\BlockAccountRequest;
use App\Http\Requests\Admin\Account\UpdateAccountRequest;

class AccountController extends Controller
{
    private $accountService;

    public function __construct($accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searching = request('search');
        $users = $searching ? UserQueries::searchAccounts($searching) : UserQueries::latestPaginated();

        return view('admin.account.index', ['users' => $users]);
    }

    /**
     * Display user profile.
     */
    public function show(User $user)
    {
        return view('admin.account.show', ['user' => $user]);
    }

    /**
     * Show the form for editing user.
     */
    public function edit(User $user)
    {
        return view('admin.account.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, User $user)
    {
        $this->dispatchNow(UpdateUser::UpdateAccountRequest($user, $request));

        Alert::success(trans('admin/partials/alerts.informations.user_successfully_edited'))->autoclose(2000);
        return redirect()->route('users.show', [$user]);
    }

    /**
     * Show the form for block user.
     */
    public function blockUserForm(User $user)
    {
        if ($user->isAdmin() || $user->isBlocked())
        {
            Alert::error(trans('admin/partials/alerts.errors.cant_ban_admin_or_user_is_already_blocked'))->autoclose(2000);
            return back();
        }

        return view('admin.account.block', ['user' => $user]);
    }

    /**
     * Block user.
     */
    public function blockUser(BlockAccountRequest $request, User $user)
    {
        $this->dispatchNow(BlockAccount::BlockAccountRequest($user, $request));

        Alert::success(trans('admin/partials/alerts.informations.user_successfully_blocked'))->autoclose(2000);
        return redirect()->route('users.show', [$user]);
    }

    /**
     * Unblock user.
     */
    public function unblockUser(Request $request, User $user)
    {
        if (!$user->isBlocked()) 
        {
            Alert::error(trans('admin/partials/alerts.errors.cant_unban_user'))->autoclose(2000);
            return back();
        }

        $this->dispatchNow(new UnblockAccount($user));

        Alert::success(trans('admin/partials/alerts.informations.user_successfully_unblocked'))->autoclose(2000);
        return redirect()->route('users.show', [$user]);
    }
}
