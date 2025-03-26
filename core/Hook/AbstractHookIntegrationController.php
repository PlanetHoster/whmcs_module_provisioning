<?php

namespace ModulesGarden\PlanetHoster\Core\Hook;

/**
 * a base class for every hook integration controller
 */
abstract class AbstractHookIntegrationController
{
    /** @var string
     * allowed insert integration type
     */
    public const INSERT_TYPE_CONTENT = 'content';

    /** @var string
     * allowed insert integration type
     */
    public const INSERT_TYPE_FULL = 'full';

    /** @var string
     * allowed insert integration type, this type includes only the main container conetnt
     */
    public const INSERT_TYPE_MC_CONTENT = 'mc_content';

    /** @var string
     * allowed integration type
     */
    public const TYPE_AFTER = 'after';

    /** @var string
     * allowed integration type
     */
    public const TYPE_APPEND = 'append';

    /** @var string
     * allowed integration type
     */
    public const TYPE_BEFORE = 'before';

    /** @var string
     * allowed integration type
     */
    public const TYPE_CUSTOM = 'custom';

    /** @var string
     * allowed integration type
     */
    public const TYPE_PREPEND = 'prepend';

    /** @var string
     * allowed integration type
     */
    public const TYPE_REPLACE = 'replace';

    /** @var null|callable
     * a callback for the admin area controller
     */
    protected $controllerCallback = null;

    /** @var null|string
     *  determines the file name to be integrated which
     *  if null, will not integrate
     */
    protected $fileName = null;

    /** @var string
     * states what type of insert integration should be used
     */
    protected $insertIntegrationType = self::INSERT_TYPE_CONTENT;

    /** @var string
     * states what type of integration should be used
     */
    protected $integrationType = self::TYPE_APPEND;

    /** @var null|string
     *  a jQuery selector determines a DOM object to which the Vue App should be added
     * e.g '#exampleDiv', '.btn-container:first'
     */
    protected $jqSelector = null;

    /** @var null|string
     * a js function name, just for custom integration type
     */
    protected $jsFunctionName = null;

    /** @var null|array
     *  determines the $_REQUEST params for which the integration should be done
     *  if null, this condition will be skipped
     */
    protected $requestParams = null;

    /**
     * a wrapper to set up integration process quickly
     */
    public function addIntegration(string $fileName = null, array $requestParams = [], $controllerCallback = null, $jqSelector = null,
                                   $integrationType = null, $jsFunctionName = null, $insertIntegrationType = self::INSERT_TYPE_FULL)
    {
        $this->setFileName($fileName);
        $this->setRequestParams($requestParams);
        $this->setControllerCallback($controllerCallback);
        $this->setJqSelector($jqSelector);
        $this->setIntegrationType($integrationType);
        $this->setJsFunctionName($jsFunctionName);
        $this->setIntegrationInsertType($insertIntegrationType);
    }

    /**
     * @param string $type
     * @return self::class
     */
    public function setIntegrationInsertType($type = null)
    {
        if (in_array($type, $this->getAvailableInsertIntegrationTypes()))
        {
            $this->insertIntegrationType = $type;
        }

        return $this;
    }

    /**
     * @return type array
     */
    public function getAvailableInsertIntegrationTypes()
    {
        return [
            self::INSERT_TYPE_CONTENT,
            self::INSERT_TYPE_FULL,
            self::INSERT_TYPE_MC_CONTENT,
        ];
    }

    /**
     * @return array
     *  returns a list of integration types possible to use
     */
    public function getAvailableIntegrationTypes()
    {
        return [
            self::TYPE_APPEND,
            self::TYPE_PREPEND,
            self::TYPE_REPLACE,
            self::TYPE_CUSTOM,
            self::TYPE_AFTER,
            self::TYPE_BEFORE,
        ];
    }

    /**
     * @return callable|null
     */
    public function getControllerCallback()
    {
        return $this->controllerCallback;
    }

    /**
     * @param callable|null $controllerCallback
     */
    public function setControllerCallback($controllerCallback)
    {
        $this->controllerCallback = $controllerCallback;
    }

    /**
     * @return null|string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param null|string $fileName
     */
    public function setFileName($fileName)
    {
        if ((is_string($fileName) && $fileName !== '') || $fileName === null)
        {
            $this->fileName = $fileName;
        }

        return $this;
    }

    /**
     * @return type string
     */
    public function getIntegrationInsertType()
    {
        return $this->insertIntegrationType;
    }

    /**
     * @return string
     */
    public function getIntegrationType()
    {
        return $this->integrationType;
    }

    /**
     * @param string $type
     * @return self::class
     */
    public function setIntegrationType($type = null)
    {
        if (in_array($type, $this->getAvailableIntegrationTypes()))
        {
            $this->integrationType = $type;
        }

        return $this;
    }

    /**
     * @return null|string
     */
    public function getJqSelector()
    {
        return $this->jqSelector;
    }

    /**
     * @param null|string $jqSelector
     */
    public function setJqSelector($jqSelector)
    {
        if ((is_string($jqSelector) && $jqSelector !== '') || $jqSelector === null)
        {
            $this->jqSelector = $jqSelector;
        }
    }

    /**
     * @return null|string
     */
    public function getJsFunctionName()
    {
        return $this->jsFunctionName;
    }

    /**
     * @param null|string $jsFunctionName
     */
    public function setJsFunctionName($jsFunctionName)
    {
        if ($jsFunctionName !== '' && is_string($jsFunctionName))
        {
            $this->jsFunctionName = $jsFunctionName;
        }

        return $this;
    }

    /**
     * @return null|array
     */
    public function getRequestParams()
    {
        return $this->requestParams;
    }

    /**
     * @param null|array $requestParams
     */
    public function setRequestParams($requestParams = null)
    {
        if (is_array($requestParams) || $requestParams === null)
        {
            $this->requestParams = $requestParams;
        }

        return $this;
    }
}
