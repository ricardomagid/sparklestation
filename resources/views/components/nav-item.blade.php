{{-- Navigation Item --}}
<a href="{{$link}}" class="flex items-center shadow-md shadow-black/30 bg-ruby hover:bg-coral transition-colors duration-300">
    <div class="py-3.5 flex items-center">
        <img src="{{ asset($imgSrc) }}" alt="{{$text}}"" class="h-8 w-8 ml-4">
        <span class="text-white pl-3 hidden lg:block">{{$text}}</span>
    </div>
</a>