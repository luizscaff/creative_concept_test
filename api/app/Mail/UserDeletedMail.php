<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserDeletedMail extends Mailable
{
  use Queueable, SerializesModels;

  protected $user;
  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct(User $user)
  {
    $this->user = $user;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('mail.user_deleted')->with(['user' => $this->user]);
  }
}
