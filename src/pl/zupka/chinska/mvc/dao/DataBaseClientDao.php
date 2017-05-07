<?php
/**
 * Created by PhpStorm.
 */
namespace pl\zupka\chinska\mvc\dao;

use pl\zupka\chinska\mvc\api\entity\dto\ClientDto;
use pl\zupka\chinska\mvc\api\entity\mapper\ClientEntityMapper;
use pl\zupka\chinska\mvc\ClientDao;

/**
 * Class DataBaseClientDao represents Data Base implementation as the Data Source for Data Access Objects.
 *
 * @package pl\zupka\chinska\mvc\dao
 */
class DataBaseClientDao implements ClientDao
{
    /**
     * @var ClientEntityMapper
     */
    private $clientEntityMapper;

    public function create(ClientDto $client): ClientDto
    {
        $clientVo = $this->getClientEntityMapper()->toVo($client);
        // TODO: Implement create() method.
        // persist $clientVo into Data Base ...
    }

    public function read(int $clientId): ClientDto
    {
        // TODO: Implement read() method.
    }

    public function readAll(): array
    {
        // TODO: Implement readAll() method.
    }

    public function update(ClientDto $client): ClientDto
    {
        // TODO: Implement update() method.
    }

    public function delete($id): bool
    {
        // TODO: Implement delete() method.
    }

    /**
     * @return mixed
     */
    public function getClientEntityMapper(): ClientEntityMapper
    {
        return $this->clientEntityMapper;
    }

}