{{-- Patch Table for Bigger Screens --}}
<div class="w-4/5 mt-2 mb-5 hidden pw:block overflow-hidden rounded-lg border border-black">
    <table class="table-auto border-collapse sparkle-table" id="patch-table">
        <thead class="bg-ruby">
            <tr>
                <th>Patch Number</th>
                <th>Wallpaper</th>
                <th>Start Date</th>
                <th>Duration</th>
                <th>Characters Introduced</th>
            </tr>
        </thead>
        <tbody class="bg-mauve">
            <tr>
                <td>{{ $patch->formatted_number }}</td>
                <td>
                    <div class="flex justify-center">
                        <img class="w-96 object-cover p-3 cursor-pointer transition-transform transform hover:scale-105"
                            src="{{ $patch->img }}" alt="Patch Image" onclick="openImageModal('{{ $patch->img }}')">
                    </div>
                </td>
                <td class="w-[15%] patch-duration">
                    {{ $patch->start_date->format('j F') }}<br>
                    {{ $patch->start_date->format('Y') }}
                </td>
                <td>{{ $patch->duration }} Days</td>
                <td class="w-[35%] max-w-[35%] truncate">
                    <div class="flex justify-center items-center space-x-5 w-full">
                        @foreach ($characters as $c)
                            @if ($c->patch && $c->patch->number == $patch->number)
                                <a href="{{ route('characters.show', $c->id) }}"
                                    class="w-1/5 bg-no-repeat bg-cover bg-center hover:scale-105"
                                    style="background-image: url('{{ $c->rarity_background_img }}');">
                                    <img src="{{ $c->icon_img }}" alt="{{ $c->name . ' Icon' }}" class="w-full">
                                </a>
                            @endif
                        @endforeach
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
