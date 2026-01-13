<template>
    <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        @click.self="$emit('close')">
        <div class="bg-red-900 rounded-lg p-6 max-w-4xl w-full mx-4">
            <div>
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-white">Success!</h2>
                </div>

                <div class="flex justify-center items-center gap-4 flex-wrap">
                    <div v-for="relic in generatedRelics" :key="relic.id" class="relative group">
                        <div
                            class="w-20 h-20 bg-red-950/40 rounded-lg overflow-hidden border-2 border-gray-600 hover:border-blue-400 transition-colors cursor-pointer">
                            <img v-if="relic.piece?.img" :src="relic.piece.img" :alt="relic.piece?.name || 'Relic'"
                                class="w-full h-full object-cover" />
                            <div v-else class="w-full h-full flex items-center justify-center text-gray-500">
                                <span class="text-xs">No Image</span>
                            </div>
                        </div>

                        <div
                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-10">
                            <div
                                class="bg-gray-900 border border-gray-700 rounded-lg p-3 shadow-xl min-w-48 whitespace-nowrap">
                                <div class="text-sm font-semibold text-white mb-2 border-b border-gray-700 pb-2">
                                    {{ relic.piece?.name || 'Unknown Relic' }}
                                    <span class="text-xs text-gray-400 ml-2">Lv.{{ relic.level }}</span>
                                </div>

                                <div v-if="relic.mainStat" class="mb-2">
                                    <div class="text-xs text-blue-400 font-semibold">Main Stat</div>
                                    <div class="text-sm text-white">
                                        {{ (relic.mainStat.stat_type).replace(/%/g, '') }}: {{ formatStat(relic.mainStat) }}
                                    </div>
                                </div>

                                <div v-if="relic.subStats && relic.subStats.length > 0">
                                    <div class="text-xs text-green-400 font-semibold mb-1">Sub Stats</div>
                                    <div v-for="stat in relic.subStats" :key="stat.id" class="text-sm text-gray-300">
                                        <div v-if="stat.isHidden == 0">{{ (stat.stat_type).replace(/%/g, '') }}: {{ formatStat(stat) }}</div>
                                    </div>
                                </div>

                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-px">
                                    <div class="border-8 border-transparent border-t-gray-900"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-6">
                    <button @click="$emit('close')"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { formatStat } from '../../relicData.js';

export default {
    props: {
        isOpen: Boolean,
        loading: Boolean,
        generatedRelics: {
            type: Array,
            default: () => []
        }
    },
    emits: ['close'],
    data() {
        return {

        }
    },
    methods: {
        formatStat
    }
}
</script>