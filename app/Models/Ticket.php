<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
  protected $fillable = ['fullname', 'email', 'ticket_title', 'ticket_description', 'status'];

}
