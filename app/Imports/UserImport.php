<?php

namespace App\Imports;

use App\Models\DepartemenModel;
use App\Models\JabatanModel;
use App\Models\UserModel;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;

class UserImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $jab = 0;
        $dep = 0;
        $getJab = JabatanModel::where('nama', $row[2])->first();
        $getDep = DepartemenModel::where('nama', $row[3])->first();
        if($getJab){
            $jab = $getJab->id;
        }
        if($getDep){
            $dep = $getDep->id;
        }
        $cek = UserModel::whereRaw("id_pegawai = '".$row[0]."' OR username = '".$row[5]."'")->first();
        if($cek){
            return new UserModel([
                'id_pegawai' => $row[0],
                'name' => $row[1],
                'id_jabatan' => $jab,
                'id_departemen' => $dep,
                'email' => $row[4],
                'username' => $row[5],
                'password' => md5('123456'),
                'jenis_kelamin' => 1,
                'tempat_lahir' => '',
                'tanggal_lahir' => '1970-01-01',
                'no_hp' => '',
                'alamat' => '',
                'no_bpjs' => '',
                'tanggal_masuk' => '1970-01-01',
                'tanggal_berakhir' => '1970-01-01',
                'foto' => '',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    public function rules(): array
    {
        return [
             // Can also use callback validation rules
             'id_pegawai' => Rule::unique('users', 'id_pegawai'),
             'username' => Rule::unique('users', 'username'),
        ];
    }
}
