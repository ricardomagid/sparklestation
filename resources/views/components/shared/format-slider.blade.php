<div class="flex gap-2">  
    <div class="flex items-center gap-2 mt-2">
        <!-- Left Icon -->
        <div class="w-10 h-10 bg-gradient-to-br from-red-300 via-red-400 to-red-500 rounded-lg shadow-md p-1">
            <img src="{{ asset($firstImg)  }}" class="w-full h-full object-cover rounded" />
        </div>
    
        <!-- Slider Track -->
        <div id="formatSlider" class="relative w-20 h-10 bg-red-100 rounded-full overflow-hidden shadow-inner cursor-pointer">
            <div class="absolute top-0 left-0 w-10 h-10 bg-red-500 rounded-full smooth-transition"></div>
        </div>
    
        <!-- Right Icon -->
        <div class="w-10 h-10 bg-gradient-to-br from-red-300 via-red-400 to-red-500 rounded-lg shadow-md p-1">
            <img src="{{ asset($secondImg) }}" class="w-full h-full object-cover rounded" />
        </div>    
    </div>                
</div>