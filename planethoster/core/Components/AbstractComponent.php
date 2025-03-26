<?php

namespace ModulesGarden\PlanetHoster\Core\Components;

use ModulesGarden\PlanetHoster\Core\Components\FallbackTraits\BackwardCompatibilityTrait;
use ModulesGarden\PlanetHoster\Core\Components\Tools\IdGenerator;
use ModulesGarden\PlanetHoster\Core\Components\Traits\AjaxTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\SlotsTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\TranslatorTrait;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ComponentInterface;
use ModulesGarden\PlanetHoster\Core\Events\Events\ComponentPreToArray;
use ModulesGarden\PlanetHoster\Core\Helper\ModuleNamespace;
use ModulesGarden\PlanetHoster\Core\ModuleConstants;
use ReflectionException;
use function ModulesGarden\PlanetHoster\Core\fire;

abstract class AbstractComponent implements ComponentInterface
{
    use BackwardCompatibilityTrait;
    use SlotsTrait;
    use TranslatorTrait;
    use AjaxTrait;

    public const COMPONENT = '';

    public const ID = null;

    /**
     * @var
     */
    private string $namespace;

    protected string $cid;

    /**
     * @var
     */
    private string $uniq = '';

    /**
     * AbstractComponent constructor.
     * @param null $parent
     * @throws ReflectionException
     */
    public function __construct()
    {
        $this->setDefaultValues();
        $this->setDefaultSlots();
    }

    private function setDefaultValues()
    {
        //set namespace, based on this value we run ajax calls
        $this->cid       = $this->cid ?? (static::ID ?? IdGenerator::generate($this));
        $this->namespace = ModuleNamespace::convertNamespaceToString($this);
        $this->uniq      = uniqid($this->getId() . '-');
    }

    private function setDefaultSlots()
    {
        $this->setSlot('cid');
        $this->setSlot('namespace');
        $this->setSlot('data', false);
        $this->setSlot('ref');
        $this->setSlot('uniq');
    }

    /**
     * @return mixed
     */
    public function getId(): string
    {
        return $this->cid;
    }

    public function setId(string $id): self
    {
        $this->cid = $id;

        return $this;
    }

    public function __clone()
    {
        $this->setDefaultValues();
    }

    #[\ReturnTypeWillChange]
    final public function jsonSerialize()
    {
        return $this->toArray();
    }

    final public function toArray(): array
    {
        if (!isset($this->namespace))
        {
            throw new \Exception(sprintf('Component namespace is not set. Did you run component constructor in %s?', get_class($this)));
        }

        fire(ComponentPreToArray::class, [$this]);

        return [
            'name'  => $this->getComponentName(),
            'slots' => $this->prepareSlots(),
            'cid'   => $this->cid,
            'uniq'  => $this->uniq,
        ];
    }

    /**
     * @return string
     */
    public static function getComponentName(): string
    {
        $name = ModuleConstants::getModuleName() . '-' . static::COMPONENT;

        return strtolower(preg_replace('%([a-z])([A-Z])%', '\1-\2', $name));
    }

    /**
     * @return string
     */
    public static function getComponentTemplateName(): string
    {
        $nameComponent = get_called_class();
        $nameExploded  = explode('\\', $nameComponent);
        $name          = ModuleConstants::getModuleName() . '-' . end($nameExploded);

        return strtolower(preg_replace('%([a-z])([A-Z])%', '\1-\2', $name));
    }

    public function preLoadHtml(): void
    {
    }

    public function loadHtml(): void
    {
    }

    public function postLoadHtml(): void
    {
    }

    public final function buildHtml(): void
    {
        $this->preLoadHtml();
        $this->loadHtml();
        $this->loadHtmlChildElements($this->getSlots());
        $this->postLoadHtml();
    }

    private function loadHtmlChildElements(array $slots)
    {
        foreach ($slots as $slotValue)
        {
            if ($slotValue instanceof ComponentInterface)
            {
                $slotValue->buildHtml();
            }
            elseif (is_array($slotValue))
            {
                $this->loadHtmlChildElements($slotValue);
            }
        }
    }


    public function preLoadData(): void
    {

    }

    public function loadData(): void
    {
    }

    public function postLoadData(): void
    {

    }
}
