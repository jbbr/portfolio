<?php

namespace App\Policies;

use App\User;
use App\Portfolio;
use Illuminate\Auth\Access\HandlesAuthorization;

class PortfolioPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the portfolio.
     *
     * @param  \App\User $user
     * @param  \App\Portfolio $portfolio
     * @return mixed
     */
    public function view(User $user, Portfolio $portfolio)
    {
        return $user->id === $portfolio->user_id;
    }

    /**
     * Determine whether the user can update the portfolio.
     *
     * @param  \App\User $user
     * @param  \App\Portfolio $portfolio
     * @return mixed
     */
    public function update(User $user, Portfolio $portfolio)
    {
        return $user->id === $portfolio->user_id;
    }

    /**
     * Determine whether the user can delete the portfolio.
     *
     * @param  \App\User $user
     * @param  \App\Portfolio $portfolio
     * @return mixed
     */
    public function delete(User $user, Portfolio $portfolio)
    {
        return $user->id === $portfolio->user_id;
    }
}
