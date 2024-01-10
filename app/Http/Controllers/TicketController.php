<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketCreationRequest;
use App\Models\Ticket;
use App\Models\TicketStatustHistoryModel;
use App\Traits\HttpResponses;
use App\Traits\TicketStatuses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
{

    use HttpResponses, TicketStatuses;
    
    
    public function createTicket( TicketCreationRequest $request ) : JsonResponse
    {

        $ticketModel = new Ticket();

        $ticketModel->short_description = $request->shortDescription;
        $ticketModel->long_description = $request->longDescription;
        $ticketModel->category_id = $request->categoryID;
        $ticketModel->issued_user_id = $request->user()->id;
        $ticketModel->current_status = $this->getOpenStatus();

        if( $ticketModel->save() ) {

            $this->addTicketStatusHistory( $ticketModel->id, $ticketModel->current_status );

            return $this->success(
                data: $ticketModel->toArray(),
                message: 'Ticket Created',
                code: 200
            );
        }


        return $this->error(
            data: [],
            message: 'Error in the Ticket Creation',
            code: 500
        );

        
    }
    

    private function addTicketStatusHistory( int $ticketID, string $status )
    {

        $ticketStatusHistory = new TicketStatustHistoryModel();

        $ticketStatusHistory->ticket_id = $ticketID;
        $ticketStatusHistory->status = $status;
        
        return $ticketStatusHistory->save();
    }

}
