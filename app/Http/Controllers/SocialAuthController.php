<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\AuthenticationController;
use App\Models\UserExternalData;
use Carbon\Carbon;

use Illuminate\Http\RedirectResponse;

class SocialAuthController extends Controller
{

  public function redirect($drive)
  {
    $rediredUrl =  Socialite::driver($drive)->stateless()->redirect()->getTargetUrl();
    return $rediredUrl;
  }


  public function callback($drive)
  {
    $user = Socialite::driver($drive)->stateless()->user();
    $accountId = $user->getId();
    $userDetails = UserExternalData::getDetailsByUserIdDrive($accountId, $drive);
    if ($userDetails == null) {
      $userData = array();

      $userData['created_at'] = Carbon::now()->toDateTimeString();
      $userData['updated_at'] = Carbon::now()->toDateTimeString();
      $userData['account_id'] = $accountId;
      $userData['drive'] = $drive;
      $userData['email'] = $user->getEmail();
      $userData['name'] = $user->getName();
      $userData['nickname'] = $user->getNickname();
      $userData['avatar_original'] = $user->getAvatar();
      $userData['token'] = $user->token;
      $userData['user_details'] = json_encode($user->user, true);
      $res = UserExternalData::saveDetails($userData);
      
      return redirect('/register/' . $drive . '/' . $user->token);
    }else{
      $userData = array();
      $userData['updated_at'] = Carbon::now()->toDateTimeString();
      $userData['token'] = $user->token;
      UserExternalData::updateExternal($accountId,$userData);

      return redirect('/login/' . $drive . '/' . $user->token);
    }
  }
}
