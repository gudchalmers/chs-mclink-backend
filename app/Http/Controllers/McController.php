<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class McController extends Controller
{
    public function register(Request $request)
    {
        $valid = $this->validate($request, [
            'email' => [
                'required',
                'email',
                'ends_with:@student.chalmers.se',
            ],
            'uuid' => [
                'required',
                'uuid',
                function ($attr, $value, $fail) {
                    $count = User::where('uuid', $value)->where('verified', true)->count();
                    $count += User::where('uuid_2', $value)->where('verified_2', true)->count();

                    if ($count > 0) {
                        $fail('uuid_taken');
                    }
                }
            ],
            'name' => [
                'required',
                'string'
            ]
        ]);

        $emailHash = hash('sha256', $valid['email'] . config('app.key'));
        $user = User::whereEmail($emailHash)->first();

        $uuidUser = User::whereUuid($valid['uuid']);
        if (!is_null($uuidUser) && is_null($user)) {
            $uuidUser->delete();
        }

        if (is_null($user)) {
            $user = new User;
            $user->email = $emailHash;
            $user->uuid = $valid['uuid'];
            $user->save();
        }

        $changed = false;
        if ($user->uuid != $valid['uuid']) {
            if (!$user->verified) {
                $user->email = $emailHash;
                $user->save();
                $changed = true;
            } else if (is_null($user->uuid_2)) {
                $user->uuid_2 = $valid['uuid'];
                $user->save();
                $changed = true;
            }
        }
        if($user->uuid != $valid['uuid'] && !$changed) {
            return response()->json(['uuid' => ['uuid_taken']]);
        }
        $user->sendRegisterMail($valid['email'], $valid['name'], $user->uuid == $valid['uuid']);

        return response()->json(['status' => 'success']);
    }

    public function verify(Request $request)
    {
        $valid = $this->validate($request, [
            'token' => 'required',
            'uuid' => 'required|uuid'
        ]);
        $user = User::whereUuid($valid['uuid'])->orWhere('uuid_2', $valid['uuid'])->first();
        if (!is_null($user)) {

            if (($user->verified && (!is_null($user->uuid_2) && $user->verified_2))) {
                return response()->json(['status' => 'done']);
            }

            $hash = hash('sha256', $user->uuid . config('app.key'));
            if (hash_equals($hash, $valid['token'])) {
                $user->verified = true;
                $user->save();
                return response()->json(['status' => 'success']);
            } else if (!is_null($user->uuid_2)) {
                $hash = hash('sha256', $user->uuid_2 . config('app.key'));
                if (hash_equals($hash, $valid['token'])) {
                    $user->verified_2 = true;
                    $user->save();
                    return response()->json(['status' => 'success']);
                }
            }
        }
        return response()->json(['status' => 'denied']);
    }

    public function unregister(Request $request)
    {
        $this->validate($request, [
            'uuid' => 'required|uuid'
        ]);
        try {
            User::whereUuid($request->input('uuid'))->delete();
        } catch (Exception $e) {
            return response()->json(['status' => 'error']);
        }
        return response()->json(['status' => 'success']);
    }

    public function check(Request $request)
    {
        $uuid = $request->input('uuid');
        if (!is_null($uuid)) {
            $r = User::whereUuid($uuid)->orWhere('uuid_2', $uuid)->first();
            $valid = !is_null($r) && ($r->verified == 1 || $r->verified_2 == 1);
            return response()->json(['status' => $valid ? 'success': 'denied']);
        } else {
            return response()->json(['status' => 'denied']);
        }
    }
}
