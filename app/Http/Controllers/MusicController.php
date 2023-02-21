<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Music;
use App\Models\Like;
use Illuminate\Http\Request;
use App\Http\Requests\MusicPostRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class MusicController extends Controller
{
    //トップページ
    public function top()
    {

        $music_model = new Music;
        $music_data  = Music::withCount('likes')->orderBy('id', 'desc')->get();

        return view('page.top', [
            'music_data' => $music_data,
            'music_model' => $music_model
        ]);
    }

    public function like(Request $request)
    {
        $like = new Like;
        $user_id = Auth::user()->id;
        $music_id = $request->music_id;
        $already_liked = Like::where('user_id', $user_id)->where('music_id', $music_id)->first();

        if (!$already_liked) {
            $like->music_id = $music_id;
            $like->user_id = $user_id;
            $like->save();
        } else {
            Like::where('music_id', $music_id)->where('user_id', $user_id)->delete();
        }

        $music_likes_count = Music::withCount('likes')->findOrFail($music_id)->likes_count;

        $param = [
            'music_likes_count' => $music_likes_count,
        ];
        return response()->json($param);
    }

    /**
     * 音楽投稿ページ
     * @return view
     */
    public function post()
    {
        $categories = Categories::all();
        return view('page.musicpost')->with([
            'categories' => $categories
        ]);
    }

    /**
     * 投稿確認ページ
     * @return view
     */
    public function confirm(MusicpostRequest $request)
    {
        $music_data = $request->all();

        //画像データ
        $music_image = $request->file('image');
        if (isset($music_image)) {
            $image_name = $music_image->getClientOriginalName(); //画像の名前
            $new_image_name = date('YmdHis') . $image_name; //画像の新しい名前

            $music_image->move(public_path() . '/img/tmp', $new_image_name); //画像ファイルの移動
            $image = $new_image_name; //画像のパス名

        } else {
            $image = 'no_image500.jpeg';
        }

        //音楽データ
        $music_audio = $request->file('music_path');
        if (isset($music_audio)) {
            $music_name = $music_audio->getClientOriginalName(); //曲の名前
            $new_music_name = date('YmdHis') . $music_name; //曲の新しい名前


            $music_audio->move(public_path() . '/audio/tmp', $new_music_name); //曲ファイルの移動
            $music_path = $new_music_name; //曲のパス名
        }

        return view(
            'page.musicconfirm',
            [
                'image' => $image,
                'music_path' => $music_path,
                'music_data' => $music_data
            ]
        );
    }

    /**
     * 投稿完了ページ
     * @return view
     */
    public function complete(Request $request)
    {
        $music = new Music();
        $action = $request->input('action');
        $music_data = $request->except('action');
        $music_data['user_id'] = Auth::user()->id;



        if (file_exists(public_path() . '/img/tmp/' . $music_data['image'])) {
            File::move(public_path() . '/img/tmp/' . $music_data['image'], storage_path() . '/app/public/img/' . $music_data['image']);
        } else {
            File::copy(public_path() . '/img/' . $music_data['image'], storage_path() . '/app/public/img/' . $music_data['image']);
        };
        //ファイルの移動
        File::move(public_path() . '/audio/tmp/' . $music_data['music_path'], storage_path() . '/app/public/audio/' . $music_data['music_path']);

        $music->musicSave($music_data);
        $request->session()->regenerateToken();


        if ($action == "back") {
            return redirect()->route('post')->withInput($music_data);
        } elseif ($action == "send") {
            return view('page.musiccomplete');
        }
    }
}
