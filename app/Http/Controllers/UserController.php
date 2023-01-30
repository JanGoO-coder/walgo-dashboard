<?php

namespace App\Http\Controllers;

use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class UserController extends Controller
{
    public function requests()
    {
        $users = User::where('status', UserStatusEnum::PENDING)->paginate(config("general.rows_per_page"));
        return view('users.requests', ["users" => $users]);
    }

    public function verified()
    {
        $users = User::where('status', UserStatusEnum::VERIFIED)->paginate(config("general.rows_per_page"));
        return view('users.verified', ["users" => $users]);
    }

    public function rejected()
    {
        $users = User::where('status', UserStatusEnum::REJECTED)->paginate(config("general.rows_per_page"));
        return view('users.rejected', ["users" => $users]);
    }

    public function accept($id)
    {
        $response = User::where('id', $id)->update([
            "status" => UserStatusEnum::VERIFIED
        ]);
        if ($response) {
            return redirect()->route("verified-users")->with("message", "User Request Accepted Successfully!");
        }
        return redirect()->route("verified-users")->with("error", "Something went wrong while accepting user request");
    }

    public function reject($id)
    {
        $response = User::where('id', $id)->update([
            "status" => UserStatusEnum::REJECTED
        ]);
        if ($response) {
            return redirect()->route("rejected-users")->with("message", "User Request Rejected Successfully!");
        }
        return redirect()->route("rejected-users")->with("error", "Something went wrong while rejected user request");
    }

    public function profile($id)
    {
        $user = User::where('id', $id)->with(["personalDetails", "personalDetails.location", "identityDetails"])->first();
        return view("profile", ["user" => $user]);
    }

    // api methods
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function yeildUserType($type) {
        if ($type == 't') {
            return UserTypeEnum::TOURIST;
        } else if ($type == 'g') {
            return UserTypeEnum::TOUR_GUIDE;
        } else {
            return UserTypeEnum::TOURIST;
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'type' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'type' => $this->yeildUserType($request->get("type")),
            'status' => UserStatusEnum::PENDING
        ]);

        $token = JWTAuth::fromUser($user, $user->toArray());

        return response()->json(compact('user', 'token'), 201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }
}
