<div class="p-8 max-w-3xl mx-auto">
    @php
        @endphp
    {{--start of new comment--}}
    <div>
        <form action="" >

            <div class="block">
                <input type="text" class="w-full mb-2" wire:model.lazy="newName" placeholder="Your Name" >
                @error('newName')
                <span class="text-red-600 text-xs">{{$message}}</span>
                @enderror
                <input type="text" class="w-full mb-2" wire:model.lazy="newComment" placeholder="Your Comment" >
                @error('newComment')
                <span class="text-red-600 text-xs">{{$message}}</span>
                @enderror
                <input type="email" class="w-full mb-2" wire:model.lazy="newEmail" placeholder="Your Email" >
                @error('newEmail')
                <span class="text-red-600 text-xs">{{$message}}</span>
                @enderror
            </div>
            <div>
                <div class="" wire:offline>
                    You are offline
                </div>
                <input type="file" wire:model.lazy="photo" class="mb-2">
                <span wire:loading wire:target="photo">Loading .........</span>
                @if($photo)
                    <img src="{{$photo->temporaryUrl()}}" alt="" class="block h-36 w-auto mx-auto">
                @endif
                @error('photo')
                <div>
                    <span class="text-red-600 text-xs">{{$message}}</span>
                </div>
                @enderror
            </div>
            <div x-data>

                <input x-show="$wire.editState!=-1" type="submit" wire:click.prevent=updateComment({{$commentId}})" value="Edit"
                       class="p-4 text-white cursor-pointer mb-2 bg-green-500">
                <input x-show="$wire.editState==-1" type="submit" wire:click.prevent="addComment" value="Add"
                       class="p-4 text-white cursor-pointer mb-2 bg-indigo-500 ">
            </div>
            <div class="">
                @error('newComment')
                <span class="text-red-600 text-xs">{{$message}}</span>
                @enderror
                @if(session()->has('message'))
                    <div class="bg-green-400 text-white p-4">
                        {{session('message')}}
                    </div>
                @else
                @endif
            </div>
        </form>
    </div>
    {{--end of new comment--}}
    <div>
        {{--comments list--}}
        @foreach($comments as $comment)
            {{--comment section--}}
            <div class="block p-4 bg-white my-2 border border-gray-300 relative" id="{{$loop->index}}">
                {{--add button--}}
                <span class="absolute top-0
                        right-0 bg-red-600 bg-opacity-50 p-2 text-black cursor-pointer" wire:click="remove({{$loop->index}})">x</span>
                {{--edit button--}}
                <span class="absolute top-0
                        right-6 bg-blue-500 bg-opacity-50 p-2 text-black cursor-pointer" wire:click="editComment({{$loop->index}})">Edit</span>
                <div class="flex flex-row content-center items-center">
                    <span class="font-bold text-xl">{{$comment['name']}}</span>
                    <span class="font-light text-gray-500 text-xs ml-2">
                        {{$comment['date']}}
                    </span>
                </div>
                <div>
                    {{$comment['email']}}
                </div>
                <div class="">
                    <p>{{$comment['text']}}</p>
                </div>
                <div>
                    <img src="{{asset($comment['img'])}}" alt="" class="block h-36 w-auto mx-auto">
                </div>
            </div>
        @endforeach
    </div>

</div>


