<?php



namespace App\Enums;

use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum LeadStatuses: string
{
    use IsKanbanStatus;

    case A = 'Lead';
    case B = 'Primeiro Contato';
    case C = 'Falhou Primeiro Contato';
    case D = 'Segundo Contato';
    case E = 'Falhou Segundo Contato';
    case F = 'Reunião Marcada';
    case G = 'Noshow';
    case H = 'Follow Up';
    case I = 'Proposta Enviada/Negociação';
    case J = 'Negócio Fechado';
    case K = 'Lead Perdido';

}
