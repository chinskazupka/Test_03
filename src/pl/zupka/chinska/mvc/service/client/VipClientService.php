<?php
/**
 * Created by PhpStorm.
 */
namespace pl\zupka\chinska\mvc\service;

use pl\zupka\chinska\mvc\api\entity\dto\ClientDto;
use pl\zupka\chinska\mvc\service\client\ClientService;

/**
 * Class VipClientService represents Private Client implementation as the Business Logic.
 *
 * @package pl\zupka\chinska\mvc\service
 */
class VipClientService implements ClientService
{

    public function registerClient(ClientDto $client): ClientDto
    {
        // TODO: Implement registerClient() method.
    }

    public function updateClientInfo(ClientDto $client): ClientDto
    {
        // TODO: Implement updateClientInfo() method.
    }

    public function suspendClientAccount(ClientDto $client): ClientDto
    {
        // TODO: Implement suspendClientAccount() method.
    }

    public function checkClientAccount(ClientDto $client): ClientDto
    {
        // TODO: Implement checkClientAccount() method.
    }
}