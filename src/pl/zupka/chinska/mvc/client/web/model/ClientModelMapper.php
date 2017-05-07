<?php
/**
 * Created by PhpStorm.
 */
namespace pl\zupka\chinska\mvc\client\web\model;

use pl\zupka\chinska\mvc\api\entity\dto\ClientDto;

/**
 * Class ClientModelMapper converts ClientModel to and from Client DataTransferObject.
 *
 * @package pl\zupka\chinska\mvc\client\web\model
 */
interface ClientModelMapper
{
    public function toModel(ClientDto $clientDto): ClientModel;
    public function toDto(ClientModel $clientModel): ClientDto;
}