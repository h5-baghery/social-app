<?php
namespace App\Livewire;

use App\Events\ChatMessage;
use Livewire\Component;

class Chat extends Component
{
    public $textvalue = '';
    public $chatLog   = [];

    public function getListeners()
    {
        return [
            "echo-private:chatchannel,ChatMessage" => 'notifyNewMessage',
        ];
    }

    public function notifyNewMessage($x)
    {
        array_push($this->chatLog, $x['chat']);
    }

    public function send()
    {
        if (! auth()->check()) {
            abort(403, 'Unathorized');
        }

        if (trim(strip_tags($this->textvalue)) == "") {
            return;
        }

        array_push($this->chatLog, ['selfmessage' => true, 'username' => auth()->user()->username, 'avatar' => auth()->user()->avatar, 'textvalue' => strip_tags($this->textvalue)]);
        broadcast(new ChatMessage(['selfmessage' => false, 'username' => auth()->user()->username, 'avatar' => auth()->user()->avatar, 'textvalue' => strip_tags($this->textvalue)]))->toOthers();
        $this->textvalue = '';
        $this->dispatch('message-sent');
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
