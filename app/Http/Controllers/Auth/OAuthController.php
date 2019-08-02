<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\OAuthIdentities;
use App\User;
use Auth;
use Closure;
use DB;
use Exception;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Laravel\Socialite\AbstractUser;
use Laravel\Socialite\Facades\Socialite;
use Validator;

class OAuthController extends Controller
{
    use ThrottlesLogins;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    private $redirectTo = '/';

    public function __construct()
    {
        $this->middleware(function (Request $request, Closure $next) {
            // logout currently loggedin user if any
            if (Auth::check()) {
                Auth::logout();
            }
            // check if selected oauth provider is enabled
            if (!in_array($request->provider, config('auth.oauth_login.providers'))) {
                return redirect()
                    ->route('login')
                    ->withErrors(['message' => 'Loginprovider unbekannt']);
            }
            return $next($request);
        });
    }

    /**
     * Redirect the user to the authentication page of the OAuth Provider.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try {
            // start oauth flow (redirect to auth url)
            return Socialite::driver($request->provider)->redirect();
        } catch (Exception $e) {
            report($e);
            return redirect()
                ->route('login')
                ->withErrors(['message' => 'Weiterleitung zum Loginprovider fehlgeschlagen']);
        }
    }

    /**
     * Obtain the user information from OAuth Provider.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function callback(Request $request)
    {
        try {
            $socialUser = Socialite::driver($request->provider)->user();
            $userId = $this->connectUser($request->provider, $socialUser);
        } catch (Exception $e) {
            report($e);
            return redirect()
                ->route('login')
                ->withErrors(['message' => 'Fehler beim Login.']);
        }

        Auth::loginUsingId($userId);
        return redirect()->to($this->redirectTo);
    }

    private function connectUser(string $provider, AbstractUser $socialUser): int
    {
        // custom Schul-Cloud "iframe" attribute, stored in JSON column
        $data = $socialUser->offsetExists('iframe') ? ['iframe' => $socialUser->offsetGet('iframe')] : null;

        // lookup user with oauth identify
        $identity = OAuthIdentities::query()
            ->where('provider', $provider)
            ->where('provider_user_id', $socialUser->getId())
            ->first();

        if ($identity) {
            // make sure iframe data gets updated
            $identity->data = $data;
            $identity->save();
            return $identity->user_id;
        }

        // create user and create oauth identify if it doesnt exist
        $userData = [
            'email' => $socialUser->getEmail(),
            'name' => $socialUser->getName(),
            'verified' => 1,
        ];
        $identityData = [
            'provider' => $provider,
            'provider_user_id' => $socialUser->getId(),
            'data' => $data,
        ];

        // validate new user -> including uniqueness of email
        $this->validator($userData)->validate();

        $user = null;
        DB::transaction(function () use (&$user, $identityData, $userData) {
            /** @var User $user */
            $user = User::create($userData);
            $user->oauthIdentities()->create($identityData);
        });

        return $user->getKey();
    }

    /**
     * Get a validator for incoming oauth user.
     *
     * @param  array $data
     * @return ValidatorContract
     */
    private function validator(array $data): ValidatorContract
    {
        return Validator::make($data, [
            'name' => 'max:255',
            'email' => 'nullable|email|max:255|unique:users',
        ]);
    }
}
