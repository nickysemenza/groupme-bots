<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{

        //return Infractions::all()->toArray();
	}
    public function csbuddies_rankings()
    {
        $scores=array();
                $all=Infractions::all();
                foreach($all as $each)
                {
                    if(isset($scores[$each->offender])) {
                        $scores[$each->offender]++;
                    }
                    else
                    {
                        $scores[$each->offender]=1;
                    }
                }
                arsort($scores);
        $data=Infractions::all()->toArray();
        return View::make('rankings',compact('data','scores'));
    }

    public function getCount($name,$type="whitegirl")
    {
        return Infractions::where('offender', '=', $name)->count();
    }
    public function csBuddies()
    {
        $callback = json_decode(file_get_contents('php://input'));
        //error_log(json_encode($callback));
        if(isset($callback->name))
        {
            $text=$callback->text;
            $name=$callback->name;
            if(substr($text, 0, 7)=="!report")
            {
                $pieces = explode(" ", $text);
                if(sizeof($pieces)>2)
                {
                    error_log("found one!");
                    $offender = strtolower($pieces[1]);
                    $reason = $sentence = implode(' ',array_slice($pieces,2));
                    $arr = array('type' => 'whitegirl',
                        'offender' => $offender,
                        'reason' => $reason,
                        'reporter' => $name);
                    $this->er($arr);
                    $infraction = Infractions::Create($arr);
                    $this->sendMessage($offender." reported for being a white girl. They now have ".$this->getCount($offender)." white girl points");



                }
            }
            if(substr($text, 0, 5)=="!rank")
            {
                $scores=array();
                $all=Infractions::all();
                foreach($all as $each)
                {
                    if(isset($scores[$each->offender])) {
                        $scores[$each->offender]++;
                    }
                    else
                    {
                        $scores[$each->offender]=1;
                    }
                }
                arsort($scores);
                $message = "";
                foreach($scores as $key => $val)
                {
                    $message = $message.str_pad($key,8).$val."\n";
                }
                $this->sendMessage($message."View Full Rankings: http://groupme.nickysemenza.com/rankings");


            }
            if(substr($text, 0, 5)=="!help")
            {
                $this->sendMessage("Commands:\n\t!report [name] [reason for being a white girl]\n\t!rankings\nAbout:\n\tView Full Rankings: http://groupme.nickysemenza.com/rankings\n\tSource Code: https://github.com/nickysemenza/groupme-bots");
            }


        }
    }
    public function sendMessage($message)
    {
        $post_text = utf8_encode($message);

        $ch = curl_init();
        $post_contents = array(
            'bot_id' => '4a7ce03af98b7517dc6752e1fe',
            'text' => $post_text,
        );

        $post = json_encode($post_contents);

        $arr = array();
        array_push($arr, 'Content-Type: application/json; charset=utf-8');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arr);
        curl_setopt($ch, CURLOPT_URL, 'https://api.groupme.com/v3/bots/post');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_exec($ch);
        curl_close($ch);
    }
    public function er($data)
    {
        ob_start();
        print_r($data);
        $contents = ob_get_contents();
        ob_end_clean();
        error_log($contents);
    }

}
