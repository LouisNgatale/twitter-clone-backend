<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetResource;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class TweetController extends Controller
{
    /**
     * @return TweetResource
     */
    public function get(Request $request)
    {
        // Get user id
        $user_id = $request->user()->id;

        // Initialize empty followers array
        $followers_id = [];

        // Get tweets for user's following
        $followings = User::find($user_id)->followings;

        // Loop through records and obtain ids
        foreach ($followings as $follower){
            array_push($followers_id,$follower->id);
        }

        // Get collection of tweets
        $collection = Tweet::whereIn('author_id',$followers_id)->paginate(15);

        // Return response
        return new TweetResource($collection);
    }
}
