<template>
    <div class="flex flex-col flex-1 overflow-hidden">
        <div class="flex border-b border-red-800">
            <button @click="currentTab = 'relics'"
                :class="['flex-1 px-4 py-3 font-medium transition-colors', currentTab === 'relics' ? 'bg-red-800/40 text-red-100 border-b-2 border-red-500' : 'text-red-300 hover:bg-red-900/30']">
                Cavern Relics
            </button>
            <button @click="currentTab = 'planar'"
                :class="['flex-1 px-4 py-3 font-medium transition-colors', currentTab === 'planar' ? 'bg-red-800/40 text-red-100 border-b-2 border-red-500' : 'text-red-300 hover:bg-red-900/30']">
                Planar Ornaments
            </button>
        </div>

        <div class="p-4 overflow-y-auto flex-1">
            <div v-show="currentTab === 'relics'" class="space-y-2">
                <div v-for="item in relicSetList" :key="item.id"
                    class="flex items-center gap-3 p-3 border-2 border-red-800 bg-red-950/30 rounded-lg hover:border-red-500 hover:bg-red-800/40 transition-all">
                    <img :src="item.img" :alt="item.name" class="w-12 h-12 object-contain">
                    <p class="text-sm font-medium text-red-100 flex-1">{{ item.name }}</p>
                    <span class="text-red-300 text-sm font-medium min-w-[2rem] text-center">
                        {{ relicSetCount?.[item.id] || 0 }}
                    </span>
                    <input type="checkbox" :checked="isSetSelected('relic', item.id)" @change="toggleSet('relic', item)"
                        class="w-5 h-5 rounded border-2 border-red-800 bg-red-950/50 checked:bg-red-600 checked:border-red-600 cursor-pointer">
                </div>
            </div>

            <div v-show="currentTab === 'planar'" class="space-y-2">
                <div v-for="item in planarSetList" :key="item.id"
                    class="flex items-center gap-3 p-3 border-2 border-red-800 bg-red-950/30 rounded-lg hover:border-red-500 hover:bg-red-800/40 transition-all">
                    <img :src="item.img" :alt="item.name" class="w-12 h-12 object-contain">
                    <p class="text-sm font-medium text-red-100 flex-1">{{ item.name }}</p>
                    <span class="text-red-300 text-sm font-medium min-w-[2rem] text-center">
                        {{ planarSetCount?.[item.id] || 0 }}
                    </span>
                    <input type="checkbox" :checked="isSetSelected('planar', item.id)"
                        @change="toggleSet('planar', item)"
                        class="w-5 h-5 rounded border-2 border-red-800 bg-red-950/50 checked:bg-red-600 checked:border-red-600 cursor-pointer">
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
import { ref } from 'vue'

const props = defineProps({
    relicSetList: {
        type: Array,
        default: () => []
    },
    planarSetList: {
        type: Array,
        default: () => []
    },
    relicSetCount: {
        type: Object,
        default: () => ({})
    },
    planarSetCount: {
        type: Object,
        default: () => ({})
    },
    initialRelicList: {
        type: Array,
        default: () => []
    },
    initialPlanarList: {
        type: Array,
        default: () => []
    }
})

const emit = defineEmits(['update:selectedSets', 'close'])

const localRelicList = ref([...(props.initialRelicList || [])])
const localPlanarList = ref([...(props.initialPlanarList || [])])

const currentTab = ref('relics')

function isSetSelected(type, setId) {
    const list = type === 'relic' ? localRelicList.value : localPlanarList.value
    return list.some(set => set.id === setId)
}

function toggleSet(type, setItem) {
    const list = type === 'relic' ? localRelicList : localPlanarList
    const index = list.value.findIndex(set => set.id === setItem.id)

    if (index === -1) {
        list.value.push(setItem)
    } else {
        list.value.splice(index, 1)
    }
}

function applyAndClose() {
    emit('update:selectedSets', {
        relic: localRelicList.value,
        planar: localPlanarList.value
    })
    emit('close')
}
</script>