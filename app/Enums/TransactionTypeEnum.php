<?php
namespace App\Enums;
enum TransactionTypeEnum:string
{
    case DEBITO = 'DEBITO';
    case CREDITO = 'CREDITO';
    case ESTORNO = 'ESTORNO';
}
