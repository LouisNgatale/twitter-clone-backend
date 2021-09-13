<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetResource;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TweetController extends Controller
{
    /**
     * @param Request $request
     * @return TweetResource
     */
    public function get(Request $request): TweetResource
    {
        $user_id = $request->user()->id;

        // TODO: Use redis or memcache instead
        return Cache::remember('user.'.$user_id.'tweets',now()->addSeconds(30),function () use ($user_id){
            // Get user id

            // TODO: Cache User's followers and followings
            // Initialize empty followers array
            $followers_id = [];

            // Get tweets for user's following
            $followings = User::find($user_id)->followings;

            // Loop through records and obtain ids
            // TODO: Use map or streams instead, for faster loop
            foreach ($followings as $follower){
                array_push($followers_id,$follower->id);
            }

            // Get collection of tweets
            $collection = Tweet::whereIn('author_id',$followers_id)->paginate(15);
            return new TweetResource($collection);
        });
    }
}
