<?php
function utf_substr($str,$len)
    {
        for($i=0;$i<$len;$i++)
        {
            $temp_str=substr($str,0,1);
            if(ord($temp_str) > 127)
            {
                $i++;
                if($i<$len)
                {
                    $new_str[]=substr($str,0,3);
                    $str=substr($str,3);
                }
            }
            else
            {
                $new_str[]=substr($str,0,1);
                $str=substr($str,1);
            }
        }
        return join($new_str);
}