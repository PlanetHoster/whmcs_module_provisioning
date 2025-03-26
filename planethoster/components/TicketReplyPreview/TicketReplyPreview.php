<?php

namespace ModulesGarden\PlanetHoster\Components\TicketReplyPreview;

use ModulesGarden\PlanetHoster\Components\Container\Container;
use ModulesGarden\PlanetHoster\Components\Image\Image;
use ModulesGarden\PlanetHoster\Core\Components\Traits\ActionOnChangeTrait;
use ModulesGarden\PlanetHoster\Core\WHMCS\Helpers\AttachmentUrlGenerator;

class TicketReplyPreview extends Container
{
    use ActionOnChangeTrait;

    public const COMPONENT = 'TicketReplyPreview';
    protected $item;

    public function __construct($ticketReply)
    {
        $this->item = $ticketReply;
        $this->build();
        parent::__construct();

        $this->setTranslations([
            'posted',
            'download_attachment',
            'delete_attachment',
            'delete_attachment_message',
        ]);
    }

    /**
     * @param $button
     * @return $this
     */
    public function addEditButton($button): self
    {
        $this->addComponent('buttons', $button);

        return $this;
    }

    protected function build()
    {
        $this->buildReplyInfo();
        $this->buildUserData();
        $this->buildMessage();
        $this->buildAttachments();
    }

    protected function buildReplyInfo()
    {
        $this->setSlot('replyId', $this->item->id);
        $this->setSlot('posted', $this->item->date);
    }

    protected function buildMessage()
    {
        $markup = new \WHMCS\View\Markup\Markup();
        $this->setSlot('message', html_entity_decode($markup->transform($this->item->message, $this->item->editor)));
    }

    protected function buildUserData()
    {
        $image = new Image();

        if ($this->item->userid)
        {
            $this->setSlot('userName', $this->item->client->firstname . " " . $this->item->client->lastname);
            $image->setUrl($this->getGravatar($this->item->user->email));
        }
        else
        {
            $this->setSlot('userName', $this->item->admin);
            $image->setUrl($this->getGravatar(""));
        }

        $this->setSlot('avatarImage', $image);
    }

    protected function buildAttachments()
    {
        if (empty($this->item->attachment))
        {
            return;
        }

        $attachmentNames = explode('|', $this->item->attachment);
        $attachment      = [];

        foreach ($attachmentNames as $attachmentName)
        {
            $attachment['name']        = $attachmentName;
            $attachment['downloadUrl'] = AttachmentUrlGenerator::generateDownloadUrl('ar', $this->item->id, $index);
            $attachment['showUrl']     = AttachmentUrlGenerator::generateShowUrl('r', $this->item->id, $index);
            $attachment['deleteUrl']   = AttachmentUrlGenerator::generateDeleteUrl('r', $this->item->id, $index, $this->item->tid);
            $index++;

            $this->pushToSlot('attachments', $attachment);
        }
    }

    public static function getGravatar($email, $s = 60, $d = 'mp', $r = 'g', $img = false, array $atts = [])
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img)
        {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val)
            {
                $url .= ' ' . $key . '="' . $val . '"';
            }
            $url .= ' />';
        }
        return $url;
    }

}