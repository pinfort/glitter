<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Contracts\User as ProviderUser;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\LinkedSocialAccount;
use Laravel\Socialite\Facades\Socialite;

class SocialAccountController extends Controller
{
    protected $services = [
        'twitter',
        'gitlab',
    ];

    /**
     * Redirect the user to the authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        in_array($provider, $this->services) ?: abort(404) ;
        if ($provider === 'gitlab') {
            return Socialite::driver('gitlab')->scopes(['read_repository', 'read_user'])->redirect();
        }
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        in_array($provider, $this->services) ?: abort(404) ;
        try {
            $user = Socialite::with($provider)->user();
        } catch (\Exception $e) {
            return redirect('/auth/login');
        }

        $access_token = null;
        $refresh_token = null;
        $expires_in = null;

        if ($provider === 'twitter') {
            $access_token = $user->token;
            $refresh_token = $user->tokenSecret;
        } else {
            $access_token = $user->token;
            $refresh_token = $user->refreshToken;
            $time = new DateTime();
            $expires_in = $time->add(DateInterval::createFromDateString($user->expiresIn.' seconds'));
        }

        $authUser = $this->findOrCreate(
            $user,
            $provider,
            $access_token,
            $refresh_token,
            $expires_in,
        );

        auth()->login($authUser, true);

        return redirect()->to('/home');
    }

    protected function findOrCreate(ProviderUser $providerUser, $provider, $access_token, $refresh_token=null, $expires_in=null)
    {
        $account = LinkedSocialAccount::where('provider_name', $provider)
                   ->where('provider_id', $providerUser->getId())
                   ->first();

        if ($account) {
            return $account->user;
        }

        $user = Auth::user();

        if ((!$user) or is_null($user)) {
            if ($provider === 'twitter') {
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name'  => $providerUser->getName(),
                ]);
            } else {
                redirect(route('login'));
            }
        }
        $user->accounts()->create([
            'provider_id'   => $providerUser->getId(),
            'provider_name' => $provider,
            'access_token'  => $access_token,
            'refresh_token' => $refresh_token,
            'token_expires_in' => $expires_in,
        ]);

        return $user;
    }
}
