<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\OAuthIdentities;
use App\User;
use DB;
use Exception;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\User as SocialUser;
use Laravel\Socialite\Facades\Socialite;
use Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function credentials(Request $request)
    {
        return [
            'email' => $request->email,
            'password' => $request->password,
            'verified' => 1,
        ];
    }

    /**
     * Redirect the user to the authentication page of the OAuth Provider.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        $provider = request('provider');

        try {
            return Socialite::driver($provider)->redirect();
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
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $provider = request('provider');
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            report($e);
            return redirect()
                ->route('login')
                ->withErrors(['message' => 'Fehler beim Login.']);
        }

        $userId = $this->connectUser($provider, $socialUser);
        $this->guard()->loginUsingId($userId);

        return redirect()->to($this->redirectTo);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return ValidatorContract
     */
    protected function validator(array $data): ValidatorContract
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
        ]);
    }

    private function connectUser(string $provider, SocialUser $socialUser): int {

        // lookup user with oauth identify
        $identity = OAuthIdentities::query()
            ->where('provider', $provider)
            ->where('provider_user_id', $socialUser->getId())
            ->first();

        if ($identity) {
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
}
