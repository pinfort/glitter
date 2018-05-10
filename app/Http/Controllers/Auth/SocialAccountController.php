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
    public function handleProviderCallback($provider)
    {
        in_array($provider, $this->services) ?: abort(404) ;
        try {
            $user = Socialite::with($provider)->user();
        } catch (\Exception $e) {
            \Log::info($e);
            return redirect('/auth/login');
        }

        $authUser = $this->findOrCreate(
            $user,
            $provider
        );

        \Log::info($authUser);

        auth()->login($authUser, true);

        return redirect()->to('/home');
    }

    protected function findOrCreate(ProviderUser $providerUser, $provider)
    {
        $account = LinkedSocialAccount::where('provider_name', $provider)
                   ->where('provider_id', $providerUser->getId())
                   ->first();

        if ($account) {
            return $account->user;
        } else {

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
            ]);

            return $user;

        }
    }
}
