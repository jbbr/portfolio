<?php

namespace App\OAuth;

use Illuminate\Http\Request;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class SchulCloudProvider extends AbstractProvider implements ProviderInterface
{
    /**
     * The scopes being requested.
     *
     * @var array
     */
    protected $scopes = ['openid'];

    private $hydraUrl;

    public function __construct(
        Request $request,
        $clientId,
        $clientSecret,
        $redirectUrl,
        $guzzle = [],
        $hydraUrl = 'https://schul-cloud.org/hydra')
    {
        parent::__construct($request, $clientId, $clientSecret, $redirectUrl, $guzzle);
        $this->hydraUrl = $hydraUrl;
    }

    /**
     * Get the authentication URL for the provider.
     *
     * @param string $state
     * @return string
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase($this->buildUrl('auth'), $state);
    }

    /**
     * Get the token URL for the provider.
     *
     * @return string
     */
    protected function getTokenUrl()
    {
        return $this->buildUrl('token');
    }

    /**
     * Get the raw user for the given access token.
     *
     * @param string $token
     * @return array
     */
    protected function getUserByToken($token)
    {
        $userUrl = $this->buildUrl('userinfo');
        try {
            $response = $this->getHttpClient()->get($userUrl, $this->getRequestOptions());
        } catch (\Exception $e) {
            \Log::error('Error while fetching userinfo', [$e]);
            return;
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * Map the raw user array to a Socialite User instance.
     *
     * @param array $user
     * @return \Laravel\Socialite\Two\User
     */
    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id' => $user['sub'],
            'email' => $user['email'],
            'name' => $user['name'],
        ]);
    }

    private function getRequestOptions($token): array
    {
        return [
            'headers' => [
                'Bearer' => $token,
            ],
        ];
    }

    private function buildUrl(string $path): string
    {
        return $this->hydraUrl . '/oauth2/' . $path;
    }
}