<?php

    header("Content-Type: text/html; charset=utf-8");
    
    function curl_get_http($url, $api)
    {
        // create curl resource
        $ch = curl_init();
        
        // set url
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $api);
        curl_setopt($ch, CURLOPT_HEADER, 0);
      
     
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     
        // $output contains the output string
        $output = curl_exec($ch);
        
        // close curl resource to free up system resources
        curl_close($ch);
        
        return $output;
    }
    
    function curl_get_http_p($ourl, $api, $param)
    {
        // create curl resource
        $ch = curl_init();
        
        $url = $ourl . '?' . http_build_query($param);
        
        // set url
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $api);
        curl_setopt($ch, CURLOPT_HEADER, 0);
      
     
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     
        // $output contains the output string
        $output = curl_exec($ch);
        
        // close curl resource to free up system resources
        curl_close($ch);
        
        return $output;
    }
    
    function curl_get_http0($ourl, $param)
    {
        // create curl resource
        $ch = curl_init();
        
        $url = $ourl . '?' . http_build_query($param);
        
        // set url
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
     
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     
        // $output contains the output string
        $output = curl_exec($ch);
        echo $output;
        
        // close curl resource to free up system resources
        curl_close($ch);
    }
    
    function detail_output($pro, $mno, $cno)
    {
        if ($pro['Response']['character']['data']['classType'] == 1)
        {
            $classcontent = "?????? ";
        }
        else if($pro['Response']['character']['data']['classType'] == 2)
        {
            $classcontent = "?????? ";
        }
        else
        {
            $classcontent = "?????? ";
        }
        
        if ($pro['Response']['character']['data']['raceType'] == 0)
        {
            $classcontent = $classcontent."??????";
        }
        else if($pro['Response']['character']['data']['raceType'] == 1)
        {
            $classcontent = $classcontent."?????????";
        }
        else
        {
            $classcontent = $classcontent."EXO";
        }
        
        if ($pro['Response']['character']['data']['genderType'] == 0)
        {
            $classcontent = $classcontent."??????";
        }
        else
        {
            $classcontent = $classcontent."??????";
        }
        
        $str = $pro['Response']['character']['data']['dateLastPlayed'];
        $i1 = strpos($str, "T");
        $str = substr($str, 0, $i1)."  ".substr($str, ($i1+1), (strlen($str)));
        $i2 = strpos($str, "Z");
        $str = substr($str, 0, $i2);
        
        $strt = $pro['Response']['character']['data']['minutesPlayedTotal'];
        $time = intval($strt);
        if($time > 60)
        {
            $timeh = $time / 60;
            $timeh = (int)$timeh;
            $timem = $time % 60;
            
            $timecontent = $timeh."??????".$timem."??????";
        }
        else
        {
            $timecontent = $time."??????";
        }
        
        $light = $pro['Response']['character']['data']['light'];
        $mobility = $pro['Response']['character']['data']['stats']['2996146975'];
        $resilience = $pro['Response']['character']['data']['stats']['392767087'];
        $recovery = $pro['Response']['character']['data']['stats']['1943323491'];
        $discipline = $pro['Response']['character']['data']['stats']['1735777505'];
        $intellect = $pro['Response']['character']['data']['stats']['144602215'];
        $strength = $pro['Response']['character']['data']['stats']['4244567218'];
        
        $table = "<table frame=\"void\">
        <tr>
        <td>?????????</td>
        <td>$classcontent</td>
        </tr>
        <tr>
        <td>?????????????????????</td>
        <td>$str</td>
        </tr>
        <tr>
        <td>???????????????</td>
        <td>$timecontent</td>
        </tr>
        <tr>
        <td>?????????</td>
        <td>$light</td>
        </tr>
        <tr>
        <td>?????????</td>
        <td>$mobility</td>
        </tr>
        <tr>
        <td>?????????</td>
        <td>$resilience</td>
        </tr>
        <tr>
        <td>?????????</td>
        <td>$recovery</td>
        </tr>
        <tr>
        <td>?????????</td>
        <td>$discipline</td>
        </tr>
        <tr>
        <td>?????????</td>
        <td>$intellect</td>
        </tr>
        <tr>
        <td>?????????</td>
        <td>$strength</td>
        </tr>
        </table>";
        echo $table;
        
        $url = "YOUR WEB/db/getName.php";
        $param = array(
            'mno' => $mno,
            'cno' => $cno,
        );
        curl_get_http0($url, $param);
        
        echo "<br/>";
    }
    
    // ????????????
    function clan_detail($clan)
    {
        echo "<b>???????????????</b>".$clan['Response']['results'][0]['group']['name']." <b>[</b>".$clan['Response']['results'][0]['group']['clanInfo']['clanCallsign']."<b>]</b>"."<br/>";
        echo $clan['Response']['results'][0]['group']['memberCount']."?????????"."<br/>";
        echo "<b>ABOUT US???</b>"."<br/>";
        echo $clan['Response']['results'][0]['group']['motto']."<br/>";
        
        $str = $clan['Response']['results'][0]['group']['about'];
        while(strpos($str, "\n") !== false)
        {
            $i1 = strpos($str, "\n");
            $str = substr($str, 0, $i1)."<br/>".substr($str, ($i1+2), strlen($str));
        }
        
        echo $str."<br/>";
    }
    
    //get the q parameter from URL
    $q=$_GET["q"];
    
    //lookup all hints from array if length of q>0
    if (strlen($q) > 0)
    {
        $hint=$q;
    }
    
    // Set output to "no suggestion" if no hint were found
    // or to the correct values
    if ($hint == "")
    {
        $response="no suggestion";
    }
    else
    {
        while(strpos($hint, "#") !== false)
        {
            $i1 = strpos($hint, "#");
            $hint = substr($hint, 0, $i1)."%23".substr($hint, ($i1+1), strlen($hint));
        }
        
        $myapi = array(
            'X-API-Key:'.'YOUR BUNGIE API',
        );
        $purl = "https://www.bungie.net/Platform/Destiny2/SearchDestinyPlayer/-1/".$hint."/";
        
        $soutput = curl_get_http($purl, $myapi);
        
        $info = json_decode($soutput, true);
        $infocheck = $info['Response'];
        
        if(empty($infocheck))
        {
            echo "??????????????????Bungie?????????<br/>";
        }
        else
        {
            echo "???????????????<br/>";
            
            // ??????membershipId
            $infonum = $info['Response'][0]['membershipId'];
            
            $curl = "https://www.bungie.net/Platform/Destiny2/3/Profile/".$infonum."/";
            $cparam = array(
                'components' => '100',
            );
            $coutput = curl_get_http_p($curl, $myapi, $cparam);
            //echo $coutput;
            
            // ???????????????characterIds
            $character = json_decode($coutput, true);
            
            $cnum[1] = $character['Response']['profile']['data']['characterIds'][0];
            $cnum[2] = $character['Response']['profile']['data']['characterIds'][1];
            $cnum[3] = $character['Response']['profile']['data']['characterIds'][2];
            
            //???????????????????????????
            if(empty($cnum[1]))
            {
                $cnumcheck = 0;
            }
            else if(empty($cnum[2]))
            {
                $cnumcheck = 1;
            }
            else if(empty($cnum[3]))
            {
                $cnumcheck = 2;
            }
            else
            {
                $cnumcheck = 3;
            }
            
            $idparam = array(
                'components' => '200',
            );
            
            $coutput1 = curl_get_http_p(("https://www.bungie.net/Platform/Destiny2/3/Profile/".$infonum."/Character/".$cnum[1]."/"), $myapi, $idparam);
            $coutput2 = curl_get_http_p(("https://www.bungie.net/Platform/Destiny2/3/Profile/".$infonum."/Character/".$cnum[2]."/"), $myapi, $idparam);
            $coutput3 = curl_get_http_p(("https://www.bungie.net/Platform/Destiny2/3/Profile/".$infonum."/Character/".$cnum[3]."/"), $myapi, $idparam);
            
            $pro[1] = json_decode($coutput1, true);
            $pro[2] = json_decode($coutput2, true);
            $pro[3] = json_decode($coutput3, true);
            
            $picurl[1] = "https://www.bungie.net".$pro[1]['Response']['character']['data']['emblemBackgroundPath'];
            $picurl[2] = "https://www.bungie.net".$pro[2]['Response']['character']['data']['emblemBackgroundPath'];
            $picurl[3] = "https://www.bungie.net".$pro[3]['Response']['character']['data']['emblemBackgroundPath'];
            
            // ?????????????????????
            $ccount = 1;
            while ($ccount <= $cnumcheck)
            {
                $pic[$ccount] = "<img src=\"".$picurl[$ccount]."\" />";
                //echo htmlentities($pic[$ccount],ENT_QUOTES,"UTF-8");
                echo $pic[$ccount];
                echo "<br/>";
                detail_output($pro[$ccount], $infonum, $cnum[$ccount]);
                $ccount = $ccount + 1;
            }
            
            // ??????????????????
            $clanurl = "https://www.bungie.net/Platform/GroupV2/User/3/".$infonum."/0/1/";
            
            $clanoutput = curl_get_http($clanurl, $myapi);
            
            $claninfo = json_decode($clanoutput, true);
            
            if($claninfo['Response']['totalResults'] > 0)
            {
                $piccurl1 = "https://www.bungie.net".$claninfo['Response']['results'][0]['group']['bannerPath'];
            
                echo "???????????????<br/>";
                $cpic1 = "<img src=\"".$piccurl1."\" width=\"50%\" height=\"50%\" />";
                //echo htmlentities($cpic1,ENT_QUOTES,"UTF-8");
                echo $cpic1;
                echo "<br/>";
                clan_detail($claninfo);
            }
        }
    }

?>
