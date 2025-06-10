<div x-data="{isOpen:false}">
    <span x-on:click="isOpen = true; document.querySelector('#chatField').focus()" class="text-white mr-2 header-chat-icon" title="Chat" data-toggle="tooltip" data-placement="bottom"><i class="fas fa-comment"></i></span>
    <div data-username="{{auth()->user()->username}}" data-avatar="{{auth()->user()->avatar}}" id="chat-wrapper" x-bind:class="isOpen ? 'chat--visible' : '' " class="chat-wrapper chat-wrapper--ready shadow border-top border-left border-right">
        <div class="chat-title-bar">Chat <span class="chat-title-bar-close"><i x-on:click="isOpen = false" class="fas fa-times-circle"></i></span></div>
        <div id="chat" class="chat-log">
            @if (count($chatLog))
                @foreach ($chatLog as $chat)
                    @if ($chat['selfmessage'])
                        <div class="chat-self">
                            <div class="chat-message">
                            <div class="chat-message-inner">
                                {{$chat['textvalue']}}
                            </div>
                            </div>
                            <img class="chat-avatar avatar-tiny" src="{{$chat['avatar']}}">
                        </div>
                    @else
                        <div class="chat-other">
                            <a href="{{ route('user.profile', ['user' => $chat['username']])}}"><img class="avatar-tiny" src="{{$chat['avatar']}}"></a>
                            <div class="chat-message">
                                <div class="chat-message-inner">
                                    <a href="{{ route('user.profile', ['user' => $chat['username']])}}"><strong>{{$chat['username']}}:</strong></a>
                                    {{$chat['textvalue']}}
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
        
        <form wire:submit="send" id="chatForm" class="chat-form border-top">
            <input wire:model="textvalue" type="text" class="chat-field" id="chatField" placeholder="Type a message…" autocomplete="off">
        </form>
    </div>
</div>
