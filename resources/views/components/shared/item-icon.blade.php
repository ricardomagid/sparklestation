<div class="item rounded-lg shadow-md hover:shadow-lg cursor-pointer bg-no-repeat bg-cover bg-center flex items-end justify-center overflow-hidden {{ $isCharacter ? 'w-20 h-24' : 'w-24 h-28' }} 
icon-item hover:scale-105 hover:-translate-y-1 transition-all duration-200 ease-in-out"
    style="background-image: url('{{ $i->rarity_background_img }}');" data-element="{{ $i->element?->name }}"
    data-path="{{ $i->path->name }}" data-rarity="{{ $i->rarity }}" data-name="{{ $i->name }}"
    data-id="{{ $i->id }}"
    @if ($i->faction) data-faction="{{ $i->faction->name }}" @endif>
    <a href="{{ $isCharacter ? route('characters.show', $i->id) : route('lightcones.show', $i->id) }}">
        <img src="{{ $isCharacter ? $i->icon_img : $i->img }}" title="{{ $i->name }}"
            alt="{{ $i->name }} {{ $isCharacter ? 'Icon' : 'Image' }}"
            class="max-w-full max-h-full object-contain" />
    </a>
</div>
