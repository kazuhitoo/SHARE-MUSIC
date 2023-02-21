<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Music extends Model
{
    use HasFactory;
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'music';

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable =
    [
        'user_id',
        'music_name',
        'music_path',
        'category',
        'image',
        'description',
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

    public function musicSave($music_data)
    {

        DB::beginTransaction();
        try {
            $music = new Music();
            $music->fill([
                'user_id'    => $music_data['user_id'],
                'music_name'  => $music_data['music_name'],
                'music_path'  => $music_data['music_path'],
                'category'    => $music_data['category'],
                'image'       => $music_data['image'],
                'description' => $music_data['description']
            ]);
            $music->save();
            DB::commit();
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();
        }
    }

    public function getmusicdata()
    {
        $music_data = Music::select([
            'id',
            'user_id',
            'music_name',
            'music_path',
            'category',
            'image',
            'description',
            'created_at',
            'updated_at',
        ])
            ->from('music')
            ->join('users', 'music' . 'user_id', '=', 'users' . 'id')
            ->orderby('created_at', 'desc')
            ->pagenate(5)
            ->get();
        return $music_data;
    }

    public function likes()
    {
        return $this->hasMany(Like::class,'music_id');
    }

    public function users()
    {
        return $this->hasMany(User::class,'id');
    }

    public function isLikedBy($music):bool
    {
        return Like::where('user_id', $music->user_id)->where('music_id', $music->id)->first() !== null;

    }
}
