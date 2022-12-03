<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Spot;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    { 
        $user = \Auth::user();
        $spot = Spot::get(['spots_id', 'spots_name']);

        return view('layouts/app', compact('user', 'spot'));
    }

    public function createUser(Request $request)
    { 
        $data = $request->all();
        $user = \Auth::user();
        $spot = Spot::get(['spots_id', 'spots_name']);

        $idList = [];
        $usersList = [];

        if (is_null($data['create_spots'])) {
            return view('layouts/app', compact('user', 'spot'));
        } else {
            if ($data['create_spots'] === '0') {
                $users = User::get(['id', 'name', 'email', 'created_at', 'updated_at']);
                $spots = Spot::get(['spots_id', 'users_id', 'spots_name', 'created_at', 'updated_at']);

                for ($i = 0; $i < count($spots); $i++) {
                    array_push($idList, $spots[$i]['users_id']); 
                }

                for ($i = 0; $i < count($users); $i++) {
                    if (in_array($users[$i]['id'], $idList)) {
                        for ($i2 = 0; $i2 < count($spots); $i2++) {
                            if ($users[$i]['id'] === $spots[$i2]['users_id']) {
                                $data = [
                                    'users_id' => $users[$i]['id'],
                                    'users_name' => $users[$i]['name'],
                                    'users_email' => $users[$i]['email'],
                                    'spots_name' => $spots[$i2]['spots_name'],
                                    'created_at' => $spots[$i2]['created_at'],
                                    'updated_at' => $spots[$i2]['updated_at']
                                ];
                                array_push($usersList, $data);
                            }
                        }                         
                    } else {
                        $data = [
                            'users_id' => $users[$i]['id'],
                            'users_name' => $users[$i]['name'],
                            'users_email' => $users[$i]['email'],
                            'spots_name' => '情報無し',
                            'created_at' => '情報無し',
                            'updated_at' => '情報無し'
                        ];
                        array_push($usersList, $data);
                    }
                }
            } else {
                $spots = Spot::where('spots_id', $data['create_spots'])->get(['spots_id', 'users_id', 'spots_name', 'created_at', 'updated_at']);
                $users = User::where('id', $spots[0]['users_id'])->get(['id', 'name', 'email', 'created_at', 'updated_at']);

                for ($i = 0; $i < count($spots); $i++) {
                    $data = [
                        'users_id' => $users[0]['id'],
                        'users_name' => $users[0]['name'],
                        'users_email' => $users[0]['email'],
                        'spots_name' => $spots[$i]['spots_name'],
                        'created_at' => $spots[$i]['created_at'],
                        'updated_at' => $spots[$i]['updated_at']
                    ];
                    array_push($usersList, $data);         
                }
            }
        }

        return view('layouts/app', compact('user', 'spot', 'usersList'));
    }
}
