<?php
/**
 * Created by PhpStorm.
 */
namespace pl\zupka\chinska\mvc\api\entity\mapper;

use pl\zupka\chinska\mvc\api\entity\dto\ClientDto;
use pl\zupka\chinska\mvc\api\entity\vo\ClientVo;

/**
 * Interface ClientEntityMapper converts Client ValueObject to and from Client DataTransferObject.
 *
 * @package pl\zupka\chinska\mvc\api\entity\mapper
 */
interface ClientEntityMapper
{
    public function toDto(ClientVo $clientVo): ClientDto;
    public function toVo(ClientDto $clientDto): ClientVo;
}