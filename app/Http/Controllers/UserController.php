<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller{
    public function createUser(Request $request) {

        $params['name'] = $request->input('name');
        $params['email'] = $request->input('email');
        $params['phone'] = $request->input('phone');
        $params['country'] = $request->input('country');

        // create user
        $user = User::create($request->all());

        return response()->json(['success' => true, 'data' => $user]);
    }

    public function updateUser(Request $request, $id) {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->country = $request->input('country');
        $user->save();

        return response()->json(['success' => true, 'data' => $user]);
    }

    public function deleteUser($id) {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'User removed successfully!']);
    }

    public function index() {
        $users = User::all();

        if (!$users) {
            return response()->json(['success' => false, 'message' => 'Users not found']);
        }

        return response()->json(['success' => true, 'data' => $users]);
    }

    public function getUser($id) {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }

        $rewardEndpoint = env('REWARD_ENDPOINT', '');
        $url = $rewardEndpoint . '/api/v1/reward/transactions/user/' . $id;

        $client = new \GuzzleHttp\Client();
        $response = $client->get($url);

        if ($response->getStatusCode() == 200) {
            $rewards = json_decode($response->getBody(), true);

            $user['rewards'] = $rewards['data'] ?? [];
        }

        return response()->json(['success' => true, 'data' => $user]);
    }

    /**
     * @param Request $request
     * @param $ids
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsersByIds(Request $request) {
        $userId = $request->input('userIds');
        $users = User::find($userId)->toArray();

        if (!$users) {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }

        return response()->json(['success' => true, 'data' => $users]);
    }
}
