<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TicketComment;
use App\Http\Requests\TicketRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    //create or Update Ticket
    public function createAndUpdate(Request $request){
        try{

            $validator = Validator::make($request->all(), [
                'ticket_title' => 'required|max:255', 
                'ticket_category' => 'required|string', 
                'description' => 'required|string',
                'ticket_img.*' => 'mimes:jpeg,png,jpg,gif,svg,pdf|max:2048', 
            ]);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);
            };

            $ticket_unique_id = 'TKT-'.Str::random(7).'-'.time();;

            $ticket_collection=[];

            if($request->has('ticket_img')){

                foreach($request->file('ticket_img') as $ticket){
                    
                    $ticketimage = time().rand(1,100).'.'.$ticket->extension();
                    $ticket->move(public_path('/tenants/ticketimages'), $ticketimage);
                    $ticketURL = '/tenants/ticketimages/'.$ticketimage;
                    array_push($ticket_collection, $ticketURL);
                };

            };

            $user = Auth::user();

            $ticket = Ticket::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'ticket_unique_id' => $ticket_unique_id,
                    'ticket_status' => 'Open', 
                    'ticket_title' => $request->ticket_title, 
                    'ticket_category' => $request->ticket_category, 
                    'description' => $request->description,
                    'ticket_img' => $ticket_collection, 
                    'assigned_id' => $request->assigned_id
                ]
            );
            
            $data['status'] = 'Success';
            $data['message'] = 'Ticket Created Successfully';
            return response()->json($data, 200);

       } catch (\Exception $exception) {

            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);

       }
    }



    public function resolveTicket($unique_id){
        try{
            $ticket = Ticket::where('ticket_unique_id', $unique_id)->first();
            $ticket->ticket_status = 'Resolved';
            $ticket->save();

            $data['status'] = 'Success';
            $data['message'] = 'Ticket Resolved Successfully';
            return response()->json($data, 200);

        } catch (\Exception $exception) {

            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);

         }
    }

    public function reopenTicket($unique_id){
        try{
            $ticket = Ticket::where('ticket_unique_id', $unique_id)->first();
            $ticket->ticket_status = 'Open';
            $ticket->save();

            $data['status'] = 'Success';
            $data['message'] = 'Ticket Reopened Successfully';
            return response()->json($data, 200);

        } catch (\Exception $exception) {

            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);

        }
    }

    // Fetch all tickets
    public function fetchAll(){
        try{

            $user = Auth::user();
            $tickets = Ticket::where('user_id','=', $user->id)
                        ->orWhere('assigned_id','=', $user->id)
                        ->orderBy('created_at', 'desc')->get();

            $data['status'] = 'Success';
            $data['message'] = 'Tickets Fetched Successfully';
            $data['data'] = $tickets;
            return response()->json($data, 200);
            
        } catch (\Exception $exception) {

            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);
        }
    }

    // Fetch single ticket
    public function fetchSingle($unique_id){
        try{
            $user = Auth::user();

            $ticket = Ticket::where('ticket_unique_id', $unique_id)
                        ->with('user', 'ticketComment')->get();

            if(!$ticket){
                $data['status'] = 'Failed';
                $data['message'] = 'Ticket not found';
                return response()->json($data, 404);
            }

            // $ticket['user_id'] = $user->id;
            // $ticket['user_first_name'] = $user->first_name;
            // $ticket['user_last_name'] = $user->last_name;
            // $ticket['user_picture'] = $user->profile_pic;
            // $role = $user->role;
            // switch ($role) {
            //     case 1:
            //         $ticket['user_role'] = 'Admin';
            //         break;
            //     case 2:
            //         $ticket['user_role'] = 'Landlord';
            //         break;
            //     case 3:
            //         $ticket['user_role'] = 'Agent';
            //         break;
            //     case 4:
            //         $ticket['user_role'] = 'Tenant';
            //         break;
            //     default:
            //         # code...
            //         break;
            // }

            // id, firstname, lastname, image and role is fine
            // $data['status'] = 'Success';
            // $data['message'] = 'Ticket Fetched Successfully';
            // $data['data'] = $ticket;
            return response()->json($ticket, 200);

        } catch (\Exception $exception) {

            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);
        }
    }

    // comment on ticket
    public function ticketComment(Request $request, $id){
        try{

            $validator = Validator::make($request->all(), [
                'comment' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);
            }
            
            $user = Auth::user();

            TicketComment::create([
                'ticket_id' => $id,
                'user_id' => $user->id,
                'comment' => $request->comment
            ]);

            $data['status'] = 'Success';
            $data['message'] = 'Comment Created Successfully';
            return response()->json($data, 200);

        } catch (\Exception $exception) {
            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);
        }
    }

    public function deleteTicket($unique_id){
        try{

            $user = Auth::user();
            $ticket = Ticket::where('ticket_unique_id', $unique_id)
                        ->with('user', 'ticketComment')->get();

            if(!$ticket){
                $data['status'] = 'Failed';
                $data['message'] = 'Ticket not found';
                return response()->json($data, 404);
            };

            $ticket->delete();

            $data['status'] = 'Success';
            $data['message'] = 'Document Deleted Successfully';
            return response()->json($data, 200);

        } catch (\Exception $exception) {

            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);
        }
    }

}
