<?php

namespace App\OAuth;

use GuzzleHttp\Exception\ClientException;
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
        return $this->buildAuthUrlFromBase($this->buildUrl('oauth2/auth'), $state);
    }

    /**
     * Get the token URL for the provider.
     *
     * @return string
     */
    protected function getTokenUrl()
    {
        return $this->buildUrl('oauth2/token');
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
            $response = $this->getHttpClient()->get($userUrl, $this->getRequestOptions($token));
        } catch (ClientException $e) {
            report($e);
            Log::error('Error while fetching userinfo', [$e->getResponse()->getBody()->getContents()]);
            throw $e;
        } catch (\Throwable $e) {
            report($e);
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
        // TODO: For now a fake email address is created, until userinfo endpoint provides real email
        return (new User)->setRaw($user)->map([
            'id' => $user['sub'],
            'email' => 'oauth_' . str_random(10) . '@example.com',
            'name' => 'Schul-Cloud User',
            // 'email' => $user['email'],
            // 'name' => $user['name'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return parent::getTokenFields($code) + ['grant_type' => 'authorization_code'];
    }

    private function getRequestOptions($token): array
    {
        return [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ];
    }

    private function buildUrl(string $path): string
    {
        return $this->hydraUrl . '/' . $path;
    }
}