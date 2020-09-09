<?php

namespace Modules\User\Observers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\User\Entities\User;

class UserObserver
{
    /**
     * Handle the User "creating" event.
     *
     * @param User $user
     * @return void
     */
    public function creating(User $user)
    {
        $nickname = Str::slug(
            $user->getAttribute('nickname') ?: Arr::first(explode('@', $user->email))
        );

        if (User::whereNickname($nickname = Str::slug($nickname))->exists()) {
            $nickname = $this->nicknameIncrement($nickname);
        }

        $user->setAttribute('nickname', $nickname);
    }

    /**
     * Increment for user unique nickname.
     *
     * @param $nickname
     * @return string
     */
    private function nicknameIncrement($nickname)
    {
        $original = $nickname;
        $count = 1;

        while (User::whereNickname($nickname)->exists()) {
            $nickname = "{$original}-" . $count++;
        }

        return $nickname;
    }

    /**
     * Handle the User "updating" event.
     *
     * @param User $user
     * @return void
     */
    public function updating(User $user)
    {
        if ($user->getAttribute('nickname')) {
            $nickname = Str::slug($user->getAttribute('nickname'));

            if (User::whereNickname($nickname = Str::slug($nickname))->where('id', '!=', $user->id)->exists()) {
                $nickname = $this->nicknameIncrement($nickname);
            }

            $user->setAttribute('nickname', $nickname);
        }
    }
}
