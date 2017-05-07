<?php
/**
 * Created by PhpStorm.
 */

namespace pl\zupka\chinska\mvc\service\client;

use pl\zupka\chinska\mvc\api\entity\dto\ClientDto;

/**
 * Interface ClientService represents the Client Business Logic, it interacts with WebClient and ClientDao. It contains
 * methods/functions/operations from User perspective, data between layers are passed using DataTransferObject.
 *
 * @package pl\zupka\chinska\mvc\service\client
 */
interface ClientService
{
    public function registerClient(ClientDto $client): ClientDto;
    public function updateClientInfo(ClientDto $client): ClientDto;
    public function suspendClientAccount(ClientDto $client): ClientDto;
    public function checkClientAccount(ClientDto $client): ClientDto;
    // ... and many other ...
}