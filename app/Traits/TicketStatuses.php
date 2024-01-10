<?php
namespace App\Traits;

trait TicketStatuses
{
    
    private array $statusCodes = [
        'OPEN',
        'ASSIGNED',
        'WORKING',
        'CLOSED'
    ];

    private array $statusCodeToStatusName = [
        'OPEN'     => "Aperto",
        'ASSIGNED' => "Assegnato",
        'WORKING'  => "In Gestione",
        'CLOSED'   => "Chiuso"
    ];

    protected function getStatusNameFromStatusCode( string $statusCode ) : string
    {
        return $this->statusCodeToStatusName[$statusCode];
    }

    protected function getOpenStatus() : string
    {
        return $this->statusCodes[0];
    }

}
