<div class="w-full md:flex justify-center hidden">
    <div class="w-full scroll-wrapper sparkle-table-scrollbar">
        <table class="w-full mt-4 text-center sparkle-table whitespace-nowrap min-w-[700px]">
            <thead>
                <tr>
                    <th class="py-2 px-4 cursor-pointer sort-column">
                        <div class="flex items-center justify-between w-full">
                            <span class="th-title mx-auto"> {{ $title }} </span>
                            <div class="sort-icon"></div>
                        </div>
                    </th>

                    <th class="py-2 px-4 cursor-pointer sort-column" id="rarity-column">
                        <div class="flex items-center justify-between w-full">
                            <span class="th-title mx-auto">Rarity</span>
                            <div class="sort-icon"></div>
                        </div>
                    </th>

                    @if ($title == 'Character')
                        <th class="py-2 px-4 cursor-pointer sort-column" id="element-column">
                            <div class="flex items-center justify-between w-full">
                                <span class="th-title mx-auto">Element</span>
                                <div class="sort-icon"></div>
                            </div>
                        </th>
                    @endif

                    <th class="py-2 px-4 cursor-pointer sort-column" id="path-column">
                        <div class="flex items-center justify-between w-full">
                            <span class="th-title mx-auto">Path</span>
                            <div class="sort-icon"></div>
                        </div>
                    </th>

                    @if ($title == 'Character')
                        <th class="py-2 px-4 cursor-pointer sort-column" id="faction-column">
                            <div class="flex items-center justify-between w-full">
                                <span class="th-title mx-auto">Faction</span>
                                <div class="sort-icon"></div>
                            </div>
                        </th>
                    @endif

                    <th class="py-2 px-4 cursor-pointer sort-column" id="atk-column">
                        <div class="flex items-center justify-between w-full">
                            <span class="th-title mx-auto">ATK</span>
                            <div class="sort-icon"></div>
                        </div>
                    </th>

                    <th class="py-2 px-4 cursor-pointer sort-column" id="hp-column">
                        <div class="flex items-center justify-between w-full">
                            <span class="th-title mx-auto">HP</span>
                            <div class="sort-icon"></div>
                        </div>
                    </th>

                    <th class="py-2 px-4 cursor-pointer sort-column" id="def-column">
                        <div class="flex items-center justify-between w-full">
                            <span class="th-title mx-auto">DEF</span>
                            <div class="sort-icon"></div>
                        </div>
                    </th>

                    @if ($title == 'Character')
                        <th class="py-2 px-4 cursor-pointer sort-column" id="speed-column">
                            <div class="flex items-center justify-between w-full">
                                <span class="th-title mx-auto">Speed</span>
                                <div class="sort-icon"></div>
                            </div>
                        </th>
                    @endif

                    <th class="hidden">
                        <div class="flex items-center justify-between w-full">
                            <span class="th-title mx-auto">ID</span>
                            <div class="sort-icon"></div>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $i)
                    <tr class="item border-b border-b-black" data-element="{{ $i->element?->name }}"
                        data-path="{{ $i->path->name }}" data-rarity="{{ $i->rarity }}"
                        data-name="{{ $i->name }}" data-id="{{ $i->id }}">


                        <td class="py-2 px-4 data-item">
                            <a href="{{ $title == "Character" ? route('characters.show', $i->id) : route('lightcones.show', $i->id) }}">
                                <div class="flex flex-col items-center">
                                    <img src="{{ $i->icon_img }}" alt="{{ $i->name }} Icon" class="h-20 w-22 mb-2" />
                                    <p class="text-sm font-bold">{{ $i->name }}</p>
                                </div>
                            </a>
                        </td>

                        <td class="py-2 px-4 data-rarity">{{ $i->rarity }} <span>★</span></td>
                        @if ($i->element?->name)
                            <td class="py-2 px-4 data-element">{{ $i->element->name }}</td>
                        @endif
                        <td class="py-2 px-4 data-path">{{ $i->path->name }}</td>

                        @if ($i->faction?->name)
                            <td class="py-2 px-4 data-faction">{{ $i->faction->name }}</td>
                        @endif

                        <td class="py-2 px-4 data-atk">{{ $i->stats->atk }}</td>
                        <td class="py-2 px-4 data-hp">{{ $i->stats->hp }}</td>
                        <td class="py-2 px-4 data-def">{{ $i->stats->def }}</td>

                        @if ($i->stats->speed)
                            <td class="py-2 px-4 data-speed">{{ $i->stats->speed }}</td>
                        @endif

                        <td class="hidden data-id">{{ $i->id }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
