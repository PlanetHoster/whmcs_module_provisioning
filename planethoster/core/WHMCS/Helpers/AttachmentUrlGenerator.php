<?php

namespace ModulesGarden\PlanetHoster\Core\WHMCS\Helpers;

class AttachmentUrlGenerator
{
    public static function generateDownloadUrl($type, $id, $index): string
    {
        return "../dl.php?type=$type&id=$id&i=$index";
    }

    public static function generateShowUrl($type, $id, $index): string
    {
        return "../includes/thumbnail.php?{$type}id=$id&i=$index";
    }


    public static function generateDeleteUrl($type, $id, $index, $ticketId): string
    {
        $token = \generate_token("link");

        if (is_null($type)) {

            return "/admin/supporttickets.php?action=viewticket&id=$id&removeattachment=true&idsd=$id&filecount=$index$token";
        }
        return "/admin/supporttickets.php?action=viewticket&id=$ticketId&removeattachment=true&type=$type&idsd=$id&filecount=$index$token";
    }
}