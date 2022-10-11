<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use Carbon\Carbon;

use App\Models\User;
use App\Models\UserDetails;
use App\Models\UserType;
use App\Models\UserRole;
use App\Models\UserStatus;
use App\Models\DepedVerifiers;

class SettingsController extends Controller
{

    public function index(Type $var = null)
    {
        return response()->json([], 403);
    }

    # Users

    public function users()
    {
        $users = UserDetails::getAll();

        return response()->json($users, 200);
    }

    public function userById($id)
    {
        $user = UserDetails::getById($id);

        $userRoles = explode(",", $user->user_role_id);
        $userRoleResult = array();
        foreach ($userRoles as $key => $role) {
            $roleDetails = UserRole::getById($role);

            $options = array();
            $options['id']      = $roleDetails->id;
            $options['name']    = $roleDetails->name;

            array_push($userRoleResult, $options);
        }
        $user->user_roles = $userRoleResult;

        return response()->json($user, 200);
    }

    public function userSave(Request $request)
    {
        //checking of required fields
        $requiredFields = ['username', 'password', 'user_type', 'user_role', 'firstname', 'lastname', 'email', 'mobile', 'status'];
        foreach ($request->input() as $field => $value) {
            if(in_array($field, $requiredFields) && !$value){
                return response()->json(array(
                    'status' => 'Failed',
                    'message' => ucwords($field).' is required.'
                ), 400);
            }
        }

        $result = array();

        $isDuplicateUsername = UserDetails::isUsernameExisted($request->username);
        $isDuplicateEmail = UserDetails::isEmailExisted($request->email);

        if (strpos($request->email, '+') !== false) {
            return response()->json(array(
                'status' => 'Failed',
                'message' => 'Plus sign is not allowed on Email.',
            ), 400);
        }else if ($isDuplicateUsername) {
            return response()->json(array(
                'status' => 'Failed',
                'message' => 'Duplicated Username.',
            ), 400);
        }else if ($isDuplicateEmail) {
            return response()->json(array(
                'status' => 'Failed',
                'message' => 'Duplicated Email.',
            ), 400);
        }else{

            $fullname = $request->firstname . ($request->middlename ? " " . $request->middlename : "") . " " . $request->lastname;

            $user = array();
            $user['user_type_id']   = $request->user_type;
            $userRoles = json_decode($request->user_role);
            $userRoles = array_column($userRoles, 'id');
            $user['user_role_id']   = implode(",", $userRoles);

            $user['name']           = $fullname;
            $user['email']          = $request->email;
            $user['password']       = Hash::make($request->password);
            $user['created_by']     = auth()->id();
            $user['created_at']     = Carbon::now()->toDateTimeString();

            DB::transaction(function () use ($user, &$result, &$request, &$fullname) { // Automatically rollback transaction if there's a fault
                $userId = UserDetails::saveUser($user);

                if($userId){

                    $userDetails = array();
                    $userDetails['user_id']     = $userId;
                    $userDetails['firstname']   = $request->firstname;
                    $userDetails['middlename']  = $request->middlename;
                    $userDetails['lastname']    = $request->lastname;
                    $userDetails['email']       = $request->email;
                    $userDetails['mobile']      = $request->mobile;
                    $userDetails['created_by']  = auth()->id();

                    $userDetailsResult = UserDetails::saveUserDetails($userDetails);
                    if($userDetailsResult){
                        $result = array(
                            'status' => 'Success',
                            'message' => 'User successfully saved.'
                        );

                        // Realtime Notification
                        $title      = "Welcome to Policy Portal!";
                        $message    = "Hi $fullname, welcome to your Policy Portal account.";
                        $link       = "/";
                        $variant    = 'primary';
                        NotificationController::createNotification($title, $message, $link, $variant, $userId);
                    }else{
                        $result = array(
                            'status' => 'Failed',
                            'message' => 'An error occured while updating an admin, please contact the administrator.',
                        );
                    }
                } else {
                    $result = array(
                        'status' => 'Failed',
                        'message' => 'An error occured while updating an admin, please contact the administrator.',
                    );
                }
            }); // End transaction
        }

        return response()->json($result, 201);
    }

    public function userUpdate(Request $request)
    {
        //checking of required fields
        $requiredFields = ['user_type', 'user_role', 'firstname', 'lastname', 'email', 'mobile', 'status'];
        foreach ($request->input() as $field => $value) {
            if(in_array($field, $requiredFields) && !$value){
                return response()->json(array(
                    'status' => 'Failed',
                    'message' => ucwords($field).' is required.'
                ), 400);
            }
        }

        $result = array();

        $isDuplicateEmail = [];

        $userDetails = UserDetails::getById($request->user_id);

        if (!$userDetails) {
            return response()->json(array(
                'status' => 'Failed',
                'message' => 'User ID is not existing.',
            ), 400);
        }

        if($userDetails->email != $request->email){
            $isDuplicateEmail = UserDetails::isEmailExisted($request->email);
        }

        if (strpos($request->email, '+') !== false) {
            return response()->json(array(
                'status' => 'Failed',
                'message' => 'Plus sign is not allowed on Email.',
            ), 400);
        }else if ($isDuplicateEmail) {
            return response()->json(array(
                'status' => 'Failed',
                'message' => 'Duplicated Email.',
            ), 400);
        }else{

            $uud = UserDetails::find($userDetails->user_detail_id);
            $uud->firstname = $request->firstname;
            $uud->middlename = $request->middlename;
            $uud->lastname = $request->lastname;
            $uud->email = $request->email;
            $uud->mobile = $request->mobile;
            $uud->updated_by = auth()->id();

            DB::transaction(function () use ($uud, &$result, &$userDetails, &$request) { // Automatically rollback transaction if there's a fault
                if($uud->save()){
                    $fullname = $uud->firstname . ($uud->middlename ? " " . $uud->middlename : "") . " " . $uud->lastname;

                    $user = User::find($userDetails->id);
                    $user->user_type_id = $request->user_type;

                    $userRoles = json_decode($request->user_role);
                    $userRoles = array_column($userRoles, 'id');
                    $user->user_role_id = implode(",", $userRoles);
                    $user->name = $fullname;
                    $user->status = $request->status;
                    $user->updated_by = auth()->id();

                    if($user->save()){
                        $result = array(
                            'status' => 'Success',
                            'message' => 'User successfully updated.'
                        );
                    }else{
                        $result = array(
                            'status' => 'Failed',
                            'message' => 'An error occured while updating an admin, please contact the administrator.',
                        );
                    }
                } else {
                    $result = array(
                        'status' => 'Failed',
                        'message' => 'An error occured while updating an admin, please contact the administrator.',
                    );
                }
            }); // End transaction
        }

        return response()->json($result, 201);
    }

    # User Type

    public function userTypes()
    {
        $userTypes = UserType::getAll();

        return response()->json($userTypes, 200);
    }

    public function userTypeById($id)
    {
        $userType = UserType::getById($id);

        return response()->json($userType, 200);
    }

    # User Role

    public function userRoles()
    {
        $userRoles = UserRole::getAll();

        return response()->json($userRoles, 200);
    }

    public function userRoleById($id)
    {
        $userRole = UserRole::getById($id);

        return response()->json($userRole, 200);
    }

    public function userRoleSave(Request $request)
    {
        //checking of required fields
        $requiredFields = ['code', 'name', 'status'];
        foreach ($request->input() as $field => $value) {
            if(in_array($field, $requiredFields) && !$value){
                return response()->json(array(
                    'status' => 'Failed',
                    'message' => ucwords($field).' is required.'
                ), 400);
            }
        }

        $result = array();

        $user_role = array();
        $user_role['code']           = $request->code;
        $user_role['name']           = $request->name;
        $user_role['status']         = $request->status;
        $user_role['created_by']     = auth()->id();
        $user_role['created_at']     = Carbon::now()->toDateTimeString();

        DB::transaction(function () use ($user_role, &$result, &$request) { // Automatically rollback transaction if there's a fault
            if(UserRole::saveUser($user_role)){
                $result = array(
                    'status' => 'Success',
                    'message' => 'User Role successfully saved.'
                );
            }else{
                $result = array(
                    'status' => 'Failed',
                    'message' => 'An error occured while updating an admin, please contact the administrator.',
                );
            }
        }); // End transaction

        return response()->json($result, 201);
    }

    public function userRoleUpdate(Request $request)
    {
        //checking of required fields
        $requiredFields = ['name', 'status'];
        foreach ($request->input() as $field => $value) {
            if(in_array($field, $requiredFields) && !$value){
                return response()->json(array(
                    'status' => 'Failed',
                    'message' => ucwords($field).' is required.'
                ), 400);
            }
        }

        $result = array();

        $user_role                  = UserRole::find($request->user_role_id);
        $user_role->name            = $request->name;
        $user_role->status          = $request->status;
        $user_role->updated_by    = auth()->id();

        DB::transaction(function () use ($user_role, &$result, &$request) { // Automatically rollback transaction if there's a fault
            if($user_role->save()){
                $result = array(
                    'status' => 'Success',
                    'message' => 'User Role successfully updated.'
                );
            } else {
                $result = array(
                    'status' => 'Failed',
                    'message' => 'An error occured while updating an admin, please contact the administrator.',
                );
            }
        }); // End transaction

        return response()->json($result, 201);
    }

    # User Status

    public function userStatus()
    {
        $status = UserStatus::getAll();

        return response()->json($status, 200);
    }

    public function userActiveStatus()
    {
        $status = UserStatus::getAllActive();

        return response()->json($status, 200);
    }
}
