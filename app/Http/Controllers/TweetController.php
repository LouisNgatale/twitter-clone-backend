<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetResource;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TweetController extends Controller
{
    /**
     * @return TweetResource
     */
    public function get(Request $request)
    {
        // Get user id
        $user_id = $request->user()->id;


        // Get tweets for user's following
//        return Tweet::whereIn('author_id',User::find($user_id)->followings->id);
        return User::find($user_id)->followings->id;
//        return new TweetResource(Tweet::paginate());
    }
}
