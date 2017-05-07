<?php
/**
 * Created by PhpStorm.
 */
namespace pl\zupka\chinska\mvc\service\client;

use pl\zupka\chinska\mvc\api\entity\dto\ClientDto;
use pl\zupka\chinska\mvc\ClientDao;
use pl\zupka\chinska\mvc\dao\DataBaseClientDao;

/**
 * Class PrivateClientService represents Private Client implementation as the Business Logic.
 *
 * @package pl\zupka\chinska\mvc\service\client
 */
class PrivateClientService implements ClientService
{
    /**
     * @var ClientDao
     */
    private $clientDao;

    /**
     * PrivateClientService constructor.
     */
    public function __construct()
    {
        $this->clientDao = new DataBaseClientDao();
    }

    public function registerClient(ClientDto $client): ClientDto
    {
        // FIXME: put some business logic?
        return $this->getClientDao()->create($client);
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

    /**
     * @return ClientDao
     */
    public function getClientDao(): ClientDao
    {
        return $this->clientDao;
    }

}