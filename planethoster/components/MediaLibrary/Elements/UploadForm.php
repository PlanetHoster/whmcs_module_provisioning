<?php

namespace ModulesGarden\PlanetHoster\Components\MediaLibrary\Elements;

use ModulesGarden\PlanetHoster\Components\Form\Form;


abstract class UploadForm extends Form
{
    protected const UPLOAD_ACTION = 'upload';
    protected $providerAction = self::UPLOAD_ACTION;

 
}
