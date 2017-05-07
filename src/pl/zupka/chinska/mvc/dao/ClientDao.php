<?php
/**
 * Created by PhpStorm.
 */
namespace pl\zupka\chinska\mvc;

use pl\zupka\chinska\mvc\api\entity\dto\ClientDto;

/**
 * Interface ClientDao represents Client DAO - Data Access Object. DAO allow access to Data Sources without specifying
 * the type of the Data Source. ClientDao can have implementation for Network Resource or File Resource.
 *
 * @package pl\zupka\chinska\mvc
 */
interface ClientDao
{
    public function create(ClientDto $client): ClientDto;
    public function read(int $clientId): ClientDto;
    public function readAll(): array;
    public function update(ClientDto $client): ClientDto;
    public function delete($id): bool;
}
