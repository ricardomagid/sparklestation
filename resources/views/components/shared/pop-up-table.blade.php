<div
    class="hidden w-[300px] icon-pop-up fixed z-[1000] bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden">
    <table class="pop-up-table w-full">
        <tbody class="divide-y divide-gray-100">
            @if ($enableWallpaper)
                <tr class="h-[120px]" id="popUpWallpaperRow">
                    <td colspan="2" class="p-0 relative">
                        <div class="absolute inset-0 bg-no-repeat bg-cover bg-center -z-20" id="popUpWallpaper"></div>

                        <div
                            class="absolute inset-0 pointer-events-none -z-10 bg-gradient-to-b from-black/30 to-transparent">
                        </div>

                        <img src="" alt="" id="popUpImage"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 w-20 h-auto z-10 rounded-md ring-2 ring-white/60" />
                    </td>
                </tr>
            @endif

            @foreach ($rows as $key => $label)
                <tr id="popUp{{$key}}Row">
                    <th class="text-left p-2 pr-4 text-sm text-gray-700 font-bold">{{ $label }}</th>
                    <td class="p-2 text-sm text-gray-600" id="popUp{{$key}}"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
