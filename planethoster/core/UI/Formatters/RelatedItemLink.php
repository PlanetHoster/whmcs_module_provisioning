<?php

namespace ModulesGarden\PlanetHoster\Core\UI\Formatters;

use ModulesGarden\PlanetHoster\Components\Link\Link;
use ModulesGarden\PlanetHoster\Core\Components\Traits\TranslatorTrait;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\Admins;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\Client;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\Domain;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\Hosting;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\HostingAddon;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\Invoice;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\Order;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\Ticket;
use ModulesGarden\PlanetHoster\Core\WHMCS\URL;

class RelatedItemLink
{
    use TranslatorTrait;

    const TYPE_INVOICE = 'invoice';
    const TYPE_TICKET  = 'ticket';
    const TYPE_ORDER   = 'order';

    static string $defaultReturn = '-';

    public function format($type, $id)
    {
        $formatFunction = "format" . ucfirst($type);
        if (!empty(trim($type)) && method_exists($this, $formatFunction))
        {
            return $this->$formatFunction($id);
        }

        return static::$defaultReturn;
    }

    public function formatAdmin($id)
    {
        $admin = Admins::find($id);
        if (!$admin)
        {
            return self::$defaultReturn;
        }

        $link = new Link();
        $link->setUrl(URL\Admin::adminSummary($admin->id));
        $link->setTitle(html_entity_decode('#' . $admin->id . " " . $admin->username));

        return $link;
    }

    public function formatClient($id)
    {
        $client = Client::find($id);
        if (!$client)
        {
            return static::$defaultReturn;
        }

        $link = new Link();
        $link->setUrl(URL\Admin::clientSummary($client->id));
        $link->setTitle( html_entity_decode('#' . $client->id . ' ' . $client->firstname . ' ' . $client->lastname . ($client->companyname ? (" (" . $client->companyname . ")") : '')));

        return $link;
    }

    public function formatHosting($id)
    {
        $service = Hosting::find($id);
        if (!$service)
        {
            return static::$defaultReturn;
        }

        $parameters['productselect'] = $service->id;

        $link = new Link();
        $link->setUrl(URL\Admin::clientServices($service->userid, $parameters));
        $link->setTitle(html_entity_decode('#' . $service->id . ' ' . $service->product->name . (!empty($service->domain) ? " ({$service->domain})" : "")));

        return $link;
    }

    public function formatService($id)
    {
        return $this->formatHosting($id);
    }

    public function formatDomain($id)
    {
        $domain = Domain::find($id);
        if (!$domain)
        {
            return static::$defaultReturn;
        }

        $parameters['id'] = $domain->id;

        $link = new Link();
        $link->setUrl(URL\Admin::clientDomains($domain->userid, $parameters));
        $link->setTitle(html_entity_decode('#' . $domain->id . ' ' . $domain->domain));

        return $link;
    }

    public function formatAddon($id)
    {
        $addon = HostingAddon::find($id);
        if (!$addon)
        {
            return static::$defaultReturn;
        }

        $parameters['productselect'] = 'a' . $addon->id;

        $link = new Link();
        $link->setUrl(URL\Admin::clientServices($addon->userid, $parameters));
        $link->setTitle(html_entity_decode('#' . $addon->id . ' ' . $addon->addon->name));

        return $link;
    }

    public function formatTicket($id)
    {
        $ticket = Ticket::find($id);
        if (!$ticket)
        {
            return static::$defaultReturn;
        }

        $link = new Link();
        $link->setUrl(URL\Admin::tickets($ticket->id));
        $link->setTitle(html_entity_decode('#' . $ticket->id . " " . $this->translate(self::TYPE_TICKET)));

        return $link;
    }

    public function formatInvoice($id)
    {
        $invoice = Invoice::find($id);
        if (!$invoice)
        {
            return static::$defaultReturn;
        }

        $link = new Link();
        $link->setUrl(URL\Admin::invoices($invoice->id));
        $link->setTitle(html_entity_decode('#' . $invoice->invoicenum ?: $invoice->id . " " . $this->translate(self::TYPE_INVOICE)));

        return $link;
    }

    public function formatOrder($id)
    {
        $order = Order::find($id);
        if (!$order)
        {
            return static::$defaultReturn;
        }

        $link = new Link();
        $link->setUrl(URL\Admin::orders($order->id));
        $link->setTitle(html_entity_decode('#' . $order->id . " " . $this->translate(self::TYPE_ORDER)));

        return $link;
    }
}