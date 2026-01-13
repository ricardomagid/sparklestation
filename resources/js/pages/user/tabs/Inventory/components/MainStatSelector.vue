<template>
    <div class="flex flex-col flex-1 overflow-hidden">
        <div class="flex gap-3 justify-center p-4 border-b border-red-800 bg-red-950/30">
            <div v-for="(stats, key) in relicMainStats" :key="key" @click="currentMainStat = key"
                class="w-14 h-14 rounded-xl border-2 cursor-pointer flex items-center justify-center bg-gradient-to-br from-red-900/30 to-red-950/50 transition-all duration-300 group hover:shadow-lg hover:shadow-red-500/20 hover:-translate-y-0.5 relative overflow-hidden"
                :class="currentMainStat === key ? 'border-red-500 bg-red-800/40' : 'border-red-800/60 hover:border-red-500'">
                <div
                    class="absolute inset-0 bg-gradient-to-t from-red-500/0 to-red-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300" />
                <img :src="`/images/filter/${key}.png`" :alt="key"
                    class="w-8 h-8 object-contain group-hover:scale-110 transition-transform duration-300 relative z-10" />
            </div>
        </div>

        <div class="p-4 overflow-y-auto flex-1">
            <div class="grid grid-cols-2 gap-2">
                <div v-for="item in relicMainStats[currentMainStat]" :key="item"
                    class="flex items-center gap-3 p-3 border-2 border-red-800 bg-red-950/30 rounded-lg hover:border-red-500 hover:bg-red-800/40 transition-all">
                    <img :src="`/images/traces/${statIcons[item]}`" :alt="item"
                        class="w-8 h-8 object-contain flex-shrink-0">
                    <p class="text-sm font-medium text-red-100 flex-1">{{ item }}</p>
                    <input type="checkbox" :value="item" @change="toggleMainstat(item)" :checked="isStatSelected(item)"
                        :disabled="relicMainStats[currentMainStat].length === 1"
                        class="w-5 h-5 flex-shrink-0 rounded border-2 border-red-800 bg-red-950/50 checked:bg-red-600 checked:border-red-600 cursor-pointer">
                </div>
            </div>
        </div>

        <div class="p-4 border-t border-red-800 flex justify-end gap-2">
            <button @click="$emit('close')"
                class="px-4 py-2 bg-red-900 text-red-100 border border-red-800 rounded-lg hover:bg-red-800 transition-colors">
                Cancel
            </button>
            <button @click="applyAndClose"
                class="px-4 py-2 bg-red-700 text-red-100 border border-red-600 rounded-lg hover:bg-red-600 transition-colors">
                Apply
            </button>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { statIcons, relicMainStats } from '../../../relicData.js'

const emit = defineEmits(['update:mainStat', 'close'])

const props = defineProps({
    initialMainStat: {
        type: Object,
        default: () => ({
            relic_head: ['HP'],
            relic_hands: ['ATK']
        })
    },
})

const localMainStat = reactive({ ...props.initialMainStat })

const currentMainStat = ref('relic_head')

function isStatSelected(stat) {
    return localMainStat[currentMainStat.value]?.includes(stat) || false
}

function toggleMainstat(item) {
    const slot = currentMainStat.value

    if (!localMainStat[slot]) {
        localMainStat[slot] = []
    }

    const index = localMainStat[slot].indexOf(item)
    if (index === -1) localMainStat[slot].push(item)
    else localMainStat[slot].splice(index, 1)
}

function applyAndClose() {
    emit('update:mainStat', localMainStat);
    emit('close');
}
</script>