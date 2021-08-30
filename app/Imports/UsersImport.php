<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel,WithValidation
{
    use Importable;
    /**
     * @param array $row
     *
     */
    public function model(array $row)
    {
        $user = User::withTrashed()->where('email',$row[0])->first();
        
        if(!$user) $user = new User();
        $user->email = $row[0];
        $user->name = $row[1];
        $user->password = Hash::make($row[2]);
        $user->save();

        $user->delete();
        // $user = User::create([
        //    'email' => $row[0],
        //    'name' => $row[1],
        //    'password' => $row[2],
        // ]);

    }
    public function rules(): array
    {
        return [
            '1' => 'unique:users,email',
        ];
    }
}