<template>
    <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50"
        @click.self="$emit('close')">
        <div
            class="bg-gradient-to-b from-red-950 via-red-900/95 to-red-950 rounded-lg shadow-2xl w-[600px] max-h-[70vh] flex flex-col border-2 border-red-800">
            <div class="p-4 border-b border-red-800">
                <h2 class="text-xl font-bold mb-3 text-red-100">Select Set</h2>
                <input type="text" placeholder="Search sets..." v-model="searchQuery"
                    class="w-full px-4 py-2 border-2 border-red-800 bg-red-950/50 text-red-100 placeholder-red-400 rounded-lg focus:outline-none focus:border-red-600">
                <div class="mt-2 flex flex-wrap gap-2">
                    <span v-for="bonus in allBonus" :key="bonus" @click="toggleBonus(bonus)"
                        :class="['px-2 py-1 rounded cursor-pointer text-sm', selectedBonuses.includes(bonus) ? 'bg-red-600 text-white' : 'bg-red-950/50 text-red-100']">
                        {{ bonus }}
                    </span>
                </div>
            </div>

            <div class="p-4 overflow-y-auto flex-1">
                <div class="grid grid-cols-3 gap-4">
                    <div v-for="item in filteredSetList" :key="item.id" @click="selectSet(item)"
                        class="border-2 border-red-800 bg-red-950/30 rounded-lg p-3 cursor-pointer hover:border-red-500 hover:bg-red-800/40 transition-all">
                        <div class="flex flex-col items-center gap-2">
                            <img :src="item.img" :alt="item.name" class="w-16 h-16 object-contain">
                            <p class="text-sm text-center font-medium text-red-100">{{ item.name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 border-t border-red-800 flex justify-end">
                <button @click="$emit('close')"
                    class="px-4 py-2 bg-red-900 text-red-100 border border-red-800 rounded-lg hover:bg-red-800 transition-colors">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        isOpen: Boolean,
        setList: Array
    },
    data() {
        return {
            selectedBonuses: [],
            searchQuery: ''
        }
    },
    methods: {
        selectSet(item) {
            this.$emit('set-selected', item);
            this.$emit('close')
        },
        toggleBonus(bonus) {
            const idx = this.selectedBonuses.indexOf(bonus);
            if (idx > -1) this.selectedBonuses.splice(idx, 1);
            else this.selectedBonuses.push(bonus);
        }
    },
    computed: {
        allBonus() {
            const bonuses = this.setList.flatMap(item => item.set_bonus);
            return Array.from(new Set(bonuses));
        },
        filteredSetList() {
            return this.setList.filter(item => {
                const matchesBonus = this.selectedBonuses.length ? this.selectedBonuses.some(b => item.set_bonus.includes(b)) : true;

                const matchesSearch = this.searchQuery.length > 3 ? item.name.toLowerCase().includes(this.searchQuery.toLowerCase()) : true;

                return matchesBonus && matchesSearch
            })
        }
    }
}
</script>