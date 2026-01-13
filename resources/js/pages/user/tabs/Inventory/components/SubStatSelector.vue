<template>
    <div class="flex flex-col flex-1 overflow-hidden">
        <!-- Filter Type Section -->
        <div class="p-4 border-b border-red-800 bg-red-950/30">
            <p class="text-sm font-medium text-red-100 mb-3">Filter Type</p>
            <div class="flex gap-3">
                <label
                    class="flex-1 flex items-center justify-center gap-2 p-3 border-2 rounded-lg cursor-pointer transition-all duration-300 hover:shadow-lg hover:shadow-red-500/20"
                    :class="localSubStats.type === 'include' ? 'border-red-500 bg-red-800/40' : 'border-red-800/60 bg-red-950/30 hover:border-red-500'">
                    <input type="radio" value="include" v-model="localSubStats.type" name="selectorType"
                        class="w-4 h-4 text-red-600 bg-red-950/50 border-red-800 focus:ring-red-500">
                    <span class="text-sm font-medium text-red-100">Include Selected</span>
                </label>
                <label
                    class="flex-1 flex items-center justify-center gap-2 p-3 border-2 rounded-lg cursor-pointer transition-all duration-300 hover:shadow-lg hover:shadow-red-500/20"
                    :class="localSubStats.type === 'exclude' ? 'border-red-500 bg-red-800/40' : 'border-red-800/60 bg-red-950/30 hover:border-red-500'">
                    <input type="radio" value="exclude" v-model="localSubStats.type" name="selectorType"
                        class="w-4 h-4 text-red-600 bg-red-950/50 border-red-800 focus:ring-red-500">
                    <span class="text-sm font-medium text-red-100">Exclude Selected</span>
                </label>
            </div>
        </div>

        <!-- Number of Affixes Section -->
        <div class="p-4 border-b border-red-800 bg-red-950/30">
            <p class="text-sm font-medium text-red-100 mb-3">Number of affixes containing any of the following stats</p>
            <div class="flex items-center justify-center gap-4">
                <button @click="decrementNumber"
                    class="w-10 h-10 flex items-center justify-center bg-red-900/30 border-2 border-red-800 rounded-lg hover:border-red-500 hover:bg-red-800/40 transition-all duration-300 text-red-100 font-bold text-xl disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="localSubStats.number <= 0">
                    −
                </button>
                <span
                    class="w-16 h-10 flex items-center justify-center bg-gradient-to-br from-red-900/30 to-red-950/50 border-2 border-red-500 rounded-lg text-lg font-bold text-red-100">
                    {{ localSubStats.number }}
                </span>
                <button @click="localSubStats.number++"
                    class="w-10 h-10 flex items-center justify-center bg-red-900/30 border-2 border-red-800 rounded-lg hover:border-red-500 hover:bg-red-800/40 transition-all duration-300 text-red-100 font-bold text-xl disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="localSubStats.number >= 4">
                    +
                </button>
            </div>
        </div>

        <!-- Subsidiary Stats List -->
        <div class="p-4 overflow-y-auto flex-1">
            <p class="text-sm font-medium text-red-100 mb-3">Subsidiary Stats</p>
            <div class="grid grid-cols-2 gap-2">
                <div v-for="item in subStatList" :key="item"
                    class="flex items-center gap-3 p-3 border-2 border-red-800 bg-red-950/30 rounded-lg hover:border-red-500 hover:bg-red-800/40 transition-all">
                    <img :src="`/images/traces/${statIcons[item]}`" :alt="item"
                        class="w-8 h-8 object-contain flex-shrink-0">
                    <p class="text-sm font-medium text-red-100 flex-1">{{ item }}</p>
                    <input type="checkbox" :value="item" @change="toggleSubStat(item)" :checked="isStatSelected(item)"
                        class="w-5 h-5 flex-shrink-0 rounded border-2 border-red-800 bg-red-950/50 checked:bg-red-600 checked:border-red-600 cursor-pointer">
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="p-4 border-t border-red-800 flex justify-end gap-2">
            <button @click="$emit('close')"
                class="px-4 py-2 bg-red-900 text-red-100 border border-red-800 rounded-lg hover:bg-red-800 transition-colors">
                Cancel
            </button>
            <button @click="applyAndClose" :disabled="localSubStats.type === ''" :title="localSubStats.type === '' ? 'Please select filter type' : ''"
                class="px-4 py-2 bg-red-700 text-red-100 border border-red-600 rounded-lg hover:bg-red-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-red-900 disabled:border-red-800 disabled:hover:bg-red-900">
                Apply
            </button>
        </div>
    </div>
</template>

<script setup>
import { reactive } from 'vue'
import { statIcons, subStatList } from '../../../relicData.js'

const emit = defineEmits(['update:subStats', 'close'])

const props = defineProps({
    initialSubStat: {
        type: Object,
        default: () => ({
            type: '',
            number: 1,
            list: []
        })
    },
})

const localSubStats = reactive({
    type: props.initialSubStat.type,
    number: props.initialSubStat.number,
    list: [...(props.initialSubStat.list || [])]
})

function isStatSelected(sub) {
    return localSubStats.list.includes(sub)
}

function toggleSubStat(sub) {
    const index = localSubStats.list.indexOf(sub);
    if (index === -1) localSubStats.list.push(sub)
    else localSubStats.list.splice(index, 1)
}

function decrementNumber() {
    if (localSubStats.number > 1) {
        localSubStats.number--
    }
}

function applyAndClose() {
    emit('update:subStats', localSubStats);
    emit('close');
}
</script>