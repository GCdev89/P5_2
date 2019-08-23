<?php
class Check
{
    public static function postFormOk()
    {
        if (isset($_POST('title')) && isset($_POST('meta_title')) && isset($_POST('meta_desc')) && isset($_POST('content'))) {
            return true;
        }
        else {
            return false;
        }
    }
}
