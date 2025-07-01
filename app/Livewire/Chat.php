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
    protected $rules = [
        'textvalue' => 'required|string|max:500'
    ];

    public function send()
    {
        $this->validate();

        $message = [
            'selfmessage' => false,
            'username' => auth()->user()->username,
            'avatar' => auth()->user()->avatar,
            'textvalue' => strip_tags($this->textvalue)
        ];
        // Add to local chat immediately for instant feedback
        $this->chatLog[] = array_merge($message, ['selfmessage' => true]);

        // Dispatch broadcast in background
        dispatch(function () use ($message) {
            broadcast(new ChatMessage($message))->toOthers();
        });

        $this->reset('textvalue'); // Faster than manual reset
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
