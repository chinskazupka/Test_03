<?php
/**
 * Created by PhpStorm.
 */
namespace pl\zupka\chinska\mvc\client\web;

use pl\zupka\chinska\mvc\client\web\controller\ClientController;
use pl\zupka\chinska\mvc\service\client\ClientService;
use pl\zupka\chinska\mvc\service\login\LoginService;
use pl\zupka\chinska\mvc\service\session\SessionService;

/**
 * Class MvcWebApplication - application main entry point.
 *
 * @package pl\zupka\chinska\mvc\client\web
 */
class MvcWebApplication
{
    private $loginService;
    private $sessionService;

    private $clientService;
    private $clientController;

    // FIXME: enjoy implementing ;) This is just a starting point, I don't know if it will look like that at the end :)

    /**
     * @return LoginService
     */
    public function getLoginService(): LoginService
    {
        return $this->loginService;
    }

    /**
     * @return SessionService
     */
    public function getSessionService(): SessionService
    {
        return $this->sessionService;
    }

    /**
     * @return ClientService
     */
    public function getClientService(): ClientService
    {
        return $this->clientService;
    }

    /**
     * @return ClientController
     */
    public function getClientController(): ClientController
    {
        return $this->clientController;
    }

}