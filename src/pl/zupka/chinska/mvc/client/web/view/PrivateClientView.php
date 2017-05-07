<?php
/**
 * Created by PhpStorm.
 */
namespace pl\zupka\chinska\mvc\client\web\view;


use pl\zupka\chinska\mvc\client\web\controller\ClientController;

class PrivateClientView implements ClientView
{
    private $clientController;

    /**
     * PrivateClientView constructor.
     * @param $clientController
     */
    public function __construct(ClientController $clientController)
    {
        $this->clientController = $clientController;
    }

    /**
     * @return ClientController
     */
    public function getClientController(): ClientController
    {
        return $this->clientController;
    }

}