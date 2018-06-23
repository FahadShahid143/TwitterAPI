<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use Twitter;
use File;


class TwitterController extends Controller
{

    /**
     *
     * Return a sample page where all the tweets will be shows and operate
     *
     */
    public function index(){
        return view('twitter');
    }




    /**
     * Create a new controller instance.
     *
     * @return void
     * It will return the timeline tweets of the entered username (twitter username)
     */
    public function twitterUserTimeLine(Request $request)
    {
        $name = $request->name;
        session(['name' => $name]);

        //$data = Twitter::getHomeTimeline(['count' => 10, 'format' => 'array']);
        $data =  Twitter::getUserTimeline(['screen_name' => $name, 'count' => 20, 'format' => 'array']);


        //dd($data);

        return view('twitter',compact('data'));
    }



    /**
     * Create a new controller instance.
     *
     * @return void
     * This function is used to post a tweet
     */
    public function tweet(Request $request)
    {
        $this->validate($request, [
            'tweet' => 'required'
        ]);


        $newTwitte = ['status' => $request->tweet];


        if(!empty($request->images)){
            foreach ($request->images as $key => $value) {
                $uploaded_media = Twitter::uploadMedia(['media' => File::get($value->getRealPath())]);
                if(!empty($uploaded_media)){
                    $newTwitte['media_ids'][$uploaded_media->media_id_string] = $uploaded_media->media_id_string;
                }
            }
        }


        $twitter = Twitter::postTweet($newTwitte);


        return back();
    }


    /**
     *
     * This function is to filter the tweets
     *
     *
     */
    public function search(Request $request)
    {
        $this->validate($request, [
            'search' => 'required'
        ]);

        $search = $request->search;
        $name = session('name');




        //$array = Twitter::getHomeTimeline(['count' => 10, 'format' => 'array']);
        $array =  Twitter::getUserTimeline(['screen_name' => $name, 'count' => 20, 'format' => 'array']);


        function search_array($array, $val){
            $ArrIterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($array));
            foreach($ArrIterator as $id => $sub){
                $childArray = $ArrIterator->getSubIterator();
                if(strstr(strtolower($sub), strtolower($val))){
                    $childArray = iterator_to_array($childArray);
                    $result[] = $childArray;
                }
            }
            return $result;
        }

        $data = search_array($array, $search);


        return view('twitter',compact('data'));

//        return back();
    }


    /**
     * This function is to retweet a selected tweet
     *
     *
     */

    public function retweet(Request $request){

        $id = $request->tweetid;
        $message = $request->message;

        $msg = ['status' => $request->message];

        $retweet = Twitter::postRt($id, $msg);


        return view('twitter');
    }
}