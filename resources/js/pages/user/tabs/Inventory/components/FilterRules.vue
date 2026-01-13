<template>
    <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50"
        @click="$emit('close')">
        <div class="bg-gradient-to-b from-red-950 via-red-900/95 to-red-950 rounded-lg shadow-2xl w-[600px] max-h-[70vh] flex flex-col border-2 border-red-800"
            @click.stop>
            <div class="p-4 border-b border-red-800 flex justify-between items-center">
                <h2 class="text-xl font-bold text-red-100">Filter Rules</h2>
                <button @click="$emit('close')"
                    class="text-red-100 hover:text-red-300 text-3xl leading-none transition-colors">&times;</button>
            </div>
            <slot></slot>
        </div>
    </div>
</template>

<script setup>
defineProps({
    isOpen: Boolean
})

defineEmits(['close'])
</script>