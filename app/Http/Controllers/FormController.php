<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    private $users = [
        [
            'id' => 1,
            'name' => 'Петров Вася',
            'email' => 'test1@gmail.com',
            'password' => '12wsq12'
        ],
        [
            'id' => 2,
            'name' => 'Ткачов Вася',
            'email' => 'test2@gmail.com',
            'password' => '12wsq18wew'
        ],
        [
            'id' => 30,
            'name' => 'Пупкин Вася',
            'email' => 'test3@gmail.com',
            'password' => '12rtrq12'
        ],
    ];
    public function create(Request $request) {

        $filePath = storage_path('app/logs.txt');

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $emails = array_column($this->users, 'email');
                    if (in_array($value, $emails)) {
                        $fail('Email уже существует в системе.');
                    }
                },
            ],
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            $jsonData = json_encode(['error' => $validator->errors()], JSON_PRETTY_PRINT);
            $comment = 'Помилка:';
            $newData = $comment . PHP_EOL . $jsonData . PHP_EOL;
            File::append($filePath, $newData);
            return response()->json(['errors' => $validator->errors()]);
        }

        $user = [
            'id' => $this->users[count($this->users) - 1]['id'] + 1,
            'name' => $request->post('first_name').' '.$request->post('last_name'),
            'email' => $request->post('email'),
            'password' => $request->post('password')
        ];

        $this->users = array_merge($this->users, [$user]);

        $jsonData = json_encode(['success' => $user], JSON_PRETTY_PRINT);
        $comment = 'Новий користувач:';
        $newData = $comment . PHP_EOL . $jsonData . PHP_EOL;
        File::append($filePath, $newData);

        return response()->json(['success' => 'Ви успішно зареєструвалися.']);
    }
}
