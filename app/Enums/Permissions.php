<?php



namespace App\Enums;

use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

class Permissions
{

    const enumPermissions = [
        '*' => 'Controle Geral',
        'venda' => 'Vendas',
        'recebimento' => 'Recebimentos',
        'comercial' => 'Comercial',
        'colaboradores' => 'Colaboradores',
    ];
}
