<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory;
    use HasFactory;

    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable =
    [
        'name',
        'email',
        'password',
        'image',
        'self_introduction',
        'created_at',
        'updated_at',
    ];
    /**
     * 複数代入しない属性
     * 
     * 
     * @var array
     */
    protected $guarded =
    [
        'id'
    ];

    public function UserSave($user_data)
    {
        DB::beginTransaction();
        try {
            $user = new User();
            $user->fill([
                'name'     => $user_data['name'],
                'email'    => $user_data['email'],
                'password' => Hash::make($user_data['password'])
            ]);
            $user->save();
            DB::commit();
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();
        }
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function music()
    {
        return $this->hasMany(Music::class);
    }
}
