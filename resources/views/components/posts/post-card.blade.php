@props(['post'])
<div>
    <a href="#">
        <div>
            <img class="w-full rounded-xl"
                src="{{$post->getThumbnailImage()}}">
        </div>
    </a>
    <div class="mt-3">
        <div class="flex items-center mb-2">
            @if($category = $post-categories()-first())

            @endif
            <x-badge wire:navigate href="{{route('posts.index',['category'=>$category->title])}}"
                :textColor="$category->text_color"
                :bgColor="$category->bg_color">{{$category->title}}</x-badge>
            @endif
            <p class="text-gray-500 text-sm">{{$post->published_at}}</p>
        </div>
        <a href="#" class="text-xl font-bold text-gray-900">{{$post->title}}</a>
    </div>

</div>