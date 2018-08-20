<?php

namespace App\Jobs\Admin\Account;

use App\Models\User;
use App\Http\Requests\Admin\Account\UpdateAccountRequest;

final class UpdateUser
{
    private $user;
    private $data;

    public function __construct(User $user, array $data = [])
    {
        $this->user = $user;
        $this->data = array_only($data, ['login', 'pin', 'email', 'social_id', 'silver_expire', 'gold_expire', 'money_drop_rate_expire', 'fish_mind_expire', 'mining_expire']);
    }

    public static function UpdateAccountRequest(User $user, UpdateAccountRequest $request): self
    {
        return new static($user, [
            'login'                  => $request->login(),
            'pin'                    => $request->pin(),
            'email'                  => $request->email(),
            'social_id'              => $request->social_id(),
            'silver_expire'          => $request->silver_expire(),
            'gold_expire'            => $request->gold_expire(),
            'money_drop_rate_expire' => $request->money_drop_rate_expire(),
            'fish_mind_expire'       => $request->fish_mind_expire(),
            'mining_expire'          => $request->mining_expire(),
        ]);
    }

    public function handle(): User
    {
        $this->user->update($this->data);

        return $this->user;
    }
}
