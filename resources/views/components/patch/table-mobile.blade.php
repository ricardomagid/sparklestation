{{-- Patch Table for Smaller Screens --}}
<div class="pw:hidden mb-5">
    <div class="border border-black mb-2">
        <h3 class="font-bold text-md text-center bg-ruby text-white">Patch {{ $patch->formatted_number }}</h3>
        <div class="bg-mauve flex justify-between">
            <div class="flex flex-col pl-5 w-1/2 justify-center items-center">
                <div class="w-full bg-dustyRose flex items-center justify-center">
                    <p>Start Date</p>
                </div>
                <p class="text-center">{{ $patch->start_date->format('j F Y') }}</p>
                <div class="w-full bg-dustyRose flex items-center justify-center">
                    <p>Duration</p>
                </div>
                <p class="text-center">{{ $patch->duration }} Days</p>
                <div class="w-full bg-dustyRose flex items-center justify-center">
                    <p class="text-center">Characters Introduced</p>
                </div>
                <div class="flex justify-center items-center space-x-5 w-full">
                    @foreach ($characters as $c)
                        @if ($c->patch && $c->patch->number == $patch->number)
                            <a href="{{ route('characters.show', $c->id) }}"
                                class="w-1/5 p-1 bg-no-repeat bg-cover bg-center hover:scale-105"
                                style="background-image: url('{{ $c->rarity_background_img }}');">
                                <img src="{{ $c->icon_img }}" alt="{{ $c->name . ' Icon' }}" class="w-full">
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
            <img class="w-1/2 ml-2 object-cover p-3 cursor-pointer transition-transform transform hover:scale-105"
                src="{{ $patch->img }}" alt="Patch Image" onclick="openImageModal('{{ $patch->img }}')">
        </div>
    </div>
</div>
