<?php
/**
 * Created by PhpStorm.
 */
namespace pl\zupka\chinska\mvc\client\web\controller;

use pl\zupka\chinska\mvc\client\web\model\ClientModel;
use pl\zupka\chinska\mvc\client\web\view\ClientView;
use pl\zupka\chinska\mvc\service\client\ClientService;

/**
 * Class PrivateClientController implements functionality for the Client Controller.
 *
 * @package pl\zupka\chinska\mvc\client\web\controller
 */
class PrivateClientController implements ClientController
{
    private $clientService;
    private $clientModel;
    private $clientView;

    /**
     * PrivateClientController constructor.
     * @param $clientService
     */
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     * @return ClientService
     */
    public function getClientService(): ClientService
    {
        return $this->clientService;
    }

    /**
     * @return ClientModel
     */
    public function getClientModel(): ClientModel
    {
        return $this->clientModel;
    }

    /**
     * @return ClientView
     */
    public function getClientView(): ClientView
    {
        return $this->clientView;
    }
}