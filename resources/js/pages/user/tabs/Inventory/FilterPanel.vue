<template>
    <div
        class="h-full flex flex-col p-6 bg-gradient-to-b from-black via-red-950/90 to-red-950/90 border-4 border-l-0 border-red-900 shadow-2xl gap-6 overflow-y-auto filter-panel-scrollbar">
        <div>
            <div class="grid grid-cols-4 gap-3 mb-3">
                <div v-for="icon in ['relic_head', 'relic_hands', 'relic_body', 'relic_feet']" :key="icon"
                    @click="setRelicPieces(icon)"
                    class="aspect-square rounded-xl border-2 border-red-800/60 hover:border-red-500 cursor-pointer flex items-center justify-center bg-gradient-to-br from-red-900/30 to-red-950/50 transition-all duration-300 group hover:shadow-lg hover:shadow-red-500/20 hover:-translate-y-0.5 relative overflow-hidden"
                    :class="{ 'activeIcon': filterState.pieceToggles.relic?.includes(icon) }">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-red-500/0 to-red-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300" />
                    <img :src="`/images/filter/${icon}.png`" :alt="icon"
                        class="w-8 h-8 object-contain group-hover:scale-110 transition-transform duration-300 relative z-10" />
                </div>
            </div>
            <div class="flex justify-center gap-3">
                <div v-for="icon in ['relic_link', 'relic_orb']" :key="icon" @click="setPlanarPieces(icon)"
                    class="aspect-square rounded-xl border-2 border-red-800/60 hover:border-red-500 cursor-pointer flex items-center justify-center bg-gradient-to-br from-red-900/30 to-red-950/50 transition-all duration-300 group hover:shadow-lg hover:shadow-red-500/20 hover:-translate-y-0.5 relative overflow-hidden p-1"
                    :class="{ 'activeIcon': filterState.pieceToggles.planar?.includes(icon) }">
                    <img :src="`/images/filter/${icon}.png`" :alt="icon"
                        class="w-8 h-8 object-contain group-hover:scale-110 transition-transform duration-300 relative z-10" />
                </div>
            </div>
        </div>

        <div class="flex gap-2 mt-2">
            <select v-model="orderActive"
                class="flex-1 bg-gradient-to-br from-red-900/40 to-red-950/40 border-2 border-red-800/60 rounded-xl px-4 py-3 text-red-400 font-medium focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 cursor-pointer hover:border-red-700 appearance-none bg-no-repeat bg-right pr-10"
                style="background-image: url('data:image/svg+xml,<svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'#fca5a5\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 9l-7 7-7-7\'/></svg>'); background-size: 1.5rem; background-position: right 0.75rem center;">
                <option v-if="!orderActive" value="">Order by...</option>
                <option value="level">Level</option>
                <option value="obtained">Last Obtained</option>
            </select>

            <button @click="updateDirection()"
                class="w-12 h-12 bg-gradient-to-br from-red-900/40 to-red-950/40 border-2 border-red-800/60 rounded-xl flex items-center justify-center transition-all duration-300 hover:shadow-lg hover:shadow-red-500/20 group"
                :class="{ descending: !isAsc }">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-300 transition-transform duration-300"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
            </button>
        </div>

        <div class="bg-red-950/20 rounded-xl p-2 border border-red-900/40">
            <button
                class="w-full bg-gradient-to-r from-red-800/50 to-red-900/50 hover:from-red-700/70 hover:to-red-800/70 border-2 border-red-700/60 hover:border-red-600 rounded-xl py-3 text-red-50 font-semibold text-center transition-all duration-300 shadow-lg hover:shadow-red-500/20 hover:-translate-y-0.5 relative overflow-hidden group"
                @click="openModal('sets')">
                <span class="relative z-10">Choose Sets</span>
                <div
                    class="absolute inset-0 bg-gradient-to-r from-red-500/0 via-red-500/10 to-red-500/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700" />
            </button>

            <div v-if="filterState.selectedSets.relic.length > 0 || filterState.selectedSets.planar.length > 0"
                class="grid grid-cols-3 gap-2 max-h-[8.2rem] overflow-y-auto mt-3 p-2 bg-red-950/30 rounded-lg">
                <div v-for="item in [...filterState.selectedSets.relic, ...filterState.selectedSets.planar]"
                    :key="item.id"
                    class="w-15 h-15 rounded-lg border-2 border-red-800/60 bg-red-950/30 p-1.5 flex items-center justify-center hover:scale-110">
                    <img :src="item.img" :alt="item.name" class="w-full h-full object-contain">
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-3 p-4 bg-red-950/30 rounded-xl border border-red-900/40">
            <label class="flex items-center justify-between cursor-pointer group">
                <span class="text-red-100 font-medium text-sm group-hover:text-red-50 transition-colors">
                    Show Discarded
                </span>
                <div class="relative">
                    <input type="checkbox" class="sr-only peer" v-model="isDiscarded" />
                    <div class="w-11 h-6 bg-red-950/60 rounded-full border-2 border-red-800/60
             peer-checked:bg-red-700/40 peer-checked:border-red-600 transition-all duration-300" />
                    <div class="absolute left-1 top-1 w-4 h-4 bg-red-400 rounded-full transition-all duration-300
             peer-checked:translate-x-5 peer-checked:bg-red-300 shadow-lg" />
                </div>
            </label>

            <label class="flex items-center justify-between cursor-pointer group">
                <span class="text-red-100 font-medium text-sm group-hover:text-red-50 transition-colors">
                    Show Locked
                </span>
                <div class="relative">
                    <input type="checkbox" class="sr-only peer" v-model="isLocked" />
                    <div class="w-11 h-6 bg-red-950/60 rounded-full border-2 border-red-800/60
             peer-checked:bg-red-700/40 peer-checked:border-red-600 transition-all duration-300" />
                    <div class="absolute left-1 top-1 w-4 h-4 bg-red-400 rounded-full transition-all duration-300
             peer-checked:translate-x-5 peer-checked:bg-red-300 shadow-lg" />
                </div>
            </label>
        </div>

        <div class="flex flex-col gap-3">
            <div class="bg-red-950/20 rounded-xl p-3 border border-red-900/40">
                <button
                    class="w-full bg-gradient-to-r from-red-800/60 to-red-900/60 hover:from-red-700/80 hover:to-red-800/80 border-2 border-red-700/70 hover:border-red-600 rounded-xl py-3.5 text-red-50 font-bold text-center transition-all duration-300 shadow-lg hover:shadow-red-500/30 hover:-translate-y-0.5 relative overflow-hidden group"
                    @click="openModal('mainstats')">
                    <span class="relative z-10">Mainstats</span>
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-red-500/0 via-red-400/20 to-red-500/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700" />
                </button>

                <div v-if="Object.keys(filterState.mainStats).length > 0"
                    class="mt-3 space-y-2 max-h-32 overflow-y-auto p-2 bg-red-950/30 rounded-lg">
                    <div v-for="(stats, key) in filterState.mainStats" :key="key"
                        class="flex flex-wrap gap-1.5 items-center">
                        <img :src="`/images/filter/${key}.png`" :alt="key" class="w-6 h-6 object-contain opacity-60">
                        <div class="flex flex-wrap gap-1">
                            <span v-for="stat in stats" :key="stat"
                                class="px-2 py-0.5 bg-red-800/40 border border-red-700/60 rounded text-red-100 text-xs font-medium">
                                {{ stat }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-red-950/20 rounded-xl p-3 border border-red-900/40">
                <button
                    class="w-full bg-gradient-to-r from-red-800/60 to-red-900/60 hover:from-red-700/80 hover:to-red-800/80 border-2 border-red-700/70 hover:border-red-600 rounded-xl py-3.5 text-red-50 font-bold text-center transition-all duration-300 shadow-lg hover:shadow-red-500/30 hover:-translate-y-0.5 relative overflow-hidden group"
                    @click="openModal('substats')">
                    <span class="relative z-10">Substats</span>
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-red-500/0 via-red-400/20 to-red-500/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700" />
                </button>

                <div v-if="filterState.subStats.list && filterState.subStats.list.length > 0" class="mt-3 space-y-2">
                    <div class="p-2 bg-red-900/40 border border-red-700/60 rounded-lg">
                        <div class="flex items-center gap-2">
                            <span
                                class="px-2.5 py-1 bg-gradient-to-r from-red-700 to-red-800 border-2 border-red-600 rounded-md text-red-50 font-bold uppercase text-xs tracking-wide shadow-lg">
                                {{ filterState.subStats.type }}
                            </span>
                            <span class="text-red-200 font-semibold text-xs">
                                {{ filterState.subStats.number }} affix{{ filterState.subStats.number !== 1 ? 'es' : ''
                                }}
                            </span>
                        </div>
                    </div>

                    <div class="p-2 bg-red-950/30 rounded-lg">
                        <div class="flex flex-wrap gap-1.5">
                            <div v-for="stat in filterState.subStats.list" :key="stat"
                                class="flex items-center gap-1.5 px-2 py-1 bg-red-800/40 border border-red-700/60 rounded hover:bg-red-800/60 transition-colors group"
                                :title="stat">
                                <img :src="`/images/traces/${statIcons[stat]}`" :alt="stat"
                                    class="w-5 h-5 object-contain group-hover:scale-110 transition-transform">
                                <span class="text-red-100 text-xs font-medium">{{ stat }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <FilterRules :isOpen="showFilterRules" @close="closeModal">
        <SetSelector v-if="modalType === 'sets'" :relicSetList="relicSetList" :planarSetList="planarSetList"
            :initialRelicList="filterState.selectedSets.relic" :initialPlanarList="filterState.selectedSets.planar"
            @update:selectedSets="updateFilter({ selectedSets: $event })" :relicSetCount="relicSetCount"
            :planarSetCount="planarSetCount" @close="closeModal" />

        <MainStatSelector v-if="modalType === 'mainstats'" :initialMainStat="filterState.mainStats"
            @update:mainStat="updateFilter({ mainStats: $event })" @close="closeModal" />

        <SubStatSelector v-if="modalType === 'substats'" :initialSubStat="filterState.subStats"
            @update:subStats="updateFilter({ subStats: $event })" @close="closeModal" />
    </FilterRules>
</template>


<script setup>
import { computed, ref } from 'vue'
import FilterRules from './components/FilterRules.vue'
import SetSelector from './components/SetSelector.vue'
import MainStatSelector from './components/MainStatSelector.vue'
import SubStatSelector from './components/SubStatSelector.vue'
import { statIcons } from '../../relicData.js';

const props = defineProps({
    filterState: {
        type: Object,
        required: true
    },
    relicSetList: Array,
    planarSetList: Array,
    relicSetCount: Object,
    planarSetCount: Object
})

const emit = defineEmits(['update:filterState'])

function updateFilter(updates) {
    emit('update:filterState', { ...props.filterState, ...updates })
}

const isDiscarded = computed({
    get: () => props.filterState.discarded,
    set: (val) => {
        updateFilter({
            discarded: val,
            locked: val ? false : props.filterState.locked
        })
    }
})

const isLocked = computed({
    get: () => props.filterState.locked,
    set: (val) => {
        updateFilter({
            locked: val,
            discarded: val ? false : props.filterState.discarded
        })
    }
})

const orderActive = computed({
    get: () => props.filterState.order.by,
    set: (val) => {
        updateFilter({
            order: { ...props.filterState.order, by: val }
        })
    }
})

const isAsc = computed({
    get: () => props.filterState.order.asc,
    set: (val) => {
        updateFilter({
            order: { ...props.filterState.order, asc: val }
        })
    }
})

const modalType = ref(null) // 'sets' | 'mainstats' | 'substats' | null
const showFilterRules = computed(() => modalType.value !== null)

function openModal(type) {
    modalType.value = type;
}

function closeModal() {
    modalType.value = null;
}

function setRelicPieces(icon) {
    const current = props.filterState.pieceToggles.relic || []
    const newValue = current.includes(icon)
        ? current.filter(r => r !== icon)
        : [...current, icon]

    updateFilter({
        pieceToggles: {
            ...props.filterState.pieceToggles,
            relic: newValue
        }
    })
}

function setPlanarPieces(icon) {
    const current = props.filterState.pieceToggles.planar || []
    const newValue = current.includes(icon)
        ? current.filter(p => p !== icon)
        : [...current, icon]

    updateFilter({
        pieceToggles: {
            ...props.filterState.pieceToggles,
            planar: newValue
        }
    })
}

function updateDirection() {
    isAsc.value = !isAsc.value
}
</script>