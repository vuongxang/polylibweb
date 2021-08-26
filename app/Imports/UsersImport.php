<?php

namespace App\Imports;

use App\Xxx;
use Maatwebsite\Excel\Concerns\ToModel;
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
     * @return Xxx|null
     */
    public function model(array $row)
    {
        $post = User::create([
           'email'      => $row[0],
           'name'       => $row[1],
           'password'   => Hash::make('123456')
        ]);
    }
    public function rules(): array
    {
        return [
            '1' => 'unique:users,email',
        ];
    }
}