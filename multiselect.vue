<template>
    <div class="w-100 rounded-s border-highlight d-flex flex-column gap-2">

        <div class="form-custom form-label form-icon form-border rounded-m m-0 flex-shrink-0">
            <i class="bi bi-search font-14"></i>
            <input type="text" class="form-control rounded-xs" v-model="searchQuery" @input="searchDebounced"
                placeholder="Search" pattern="[A-Za-z ]{1,32}" ref="validChecker" :required="isRequired" />

            <div class="invalid-feedback">You need to select at least one (1) user.</div>
        </div>

        <slot name="filters" :filterColor="filterColor" :setFilter="setFilter" />

        <div ref="selectedItemsContainer" id="selected-items"
            class="d-flex gap-4 p-2 border border-2 border-highlight rounded-s align-items-start flex-shrink-0"
            style="height:64px;max-height:300px;overflow-x:scroll">

            <template v-if="items.length == 0">
                <span ref="selectedItems" class="px-3 py-2 text-center rounded-s flex-shrink-0 text-black-50">
                    Selected items appear here
                </span>
            </template>
            <template v-else>
                <button ref="selectedItems" @click.prevent="removeItem(item)" v-for="item in items"
                    class="btn btn-s border border-red-dark color-red-dark text-center rounded-s flex-shrink-0">
                    @{{ item.first_name }} @{{ item.last_name }} (@{{ item.username }})
                </button>
            </template>

        </div>

        <div id="selectables" class="d-flex gap-2 p-2 border border-2 rounded-s align-items-start flex-wrap flex-fill"
            style="height:300px;max-height:300px;overflow-y:scroll;align-content:start">

            <button @click.prevent="addItem(selectable)" v-for="selectable in selectables"
                class="btn btn-s text-center rounded-s flex-grow-0" :class="selectedColor(selectable)">
                @{{ selectable.first_name }} @{{ selectable.last_name }} (@{{ selectable.username }})
            </button>

            <div ref="observerPaginationApi" v-show="dataReadyToLoad"
                class="btn btn-s border text-black-50 text-center rounded-s w-100">
                Loading...
            </div>
        </div>

    </div>
</template>


<script>
export default {
    props: {

        isLoading: {
            type: Boolean,
            default: false
        },

        items: {
            type: Array,
            default: () => ([])
        },

        selectables: {
            type: Array,
            default: () => ([])
        },

        paginationApi: {
            type: Object,
            default: () => ({})
        },

        isOpened: {
            type: String,
            default: ""
        }
    },

    data: () => ({
        scrollBooster: null,
        filter: "ALL",
        searchQuery: "",
        searchDebounced: null,
        validChecker: null
    }),

    name: "VMultiSelect",
    template: `<x-chatapp::desktop.search-users/>`,

    watch: {
        selectables(newSelectables) {
            newSelectables.forEach(ns => {
                const { useArrayFind } = window.VueUse;
                const oldSelected = useArrayFind(this.items, i => i.id == ns.id);
                if (oldSelected.value != undefined) {
                    ns.isSelected = true;
                }
            });
        },
    },

    computed: {
        dataReadyToLoad() {
            return this.selectables.length >= 14
                && this.paginationApi !== null
                && this.paginationApi.next_page_url !== null;
        },

        isRequired() {
            return this.items.length === 0;
        }
    },

    mounted() {

        const { useIntersectionObserver, useDebounceFn } = window.VueUse;

        this.searchDebounced = useDebounceFn(() => this.search(), 250, { maxWait: 1000 })

        useIntersectionObserver(
            this.$refs.observerPaginationApi,
            ([{ isIntersecting }]) => {
                console.log("RUN PAGINATION API");
                if (!isIntersecting) return;
                if (!this.dataReadyToLoad) return;
                if (this.isLoading) return;
                this.$emit("update:isLoading", true);
                this.$emit("run:api", {
                    filter: this.filter,
                    paginationApi: this.paginationApi,
                    searchQuery: this.searchQuery
                });
            });
    },


    methods: {
        addItem(item) {
            if (item.isSelected === true) return this.removeItem(item);

            console.log("adding item");
            this.$emit('update:items', [...this.items, item]);
            // this.$emit('update:selectables', this.selectables.filter(i => i != item));
            const { useArrayFind } = window.VueUse;
            const selectable = useArrayFind(this.selectables, s => s.id === item.id);
            selectable.value.isSelected = true;
        },

        filterColor(filter) {
            if (filter === this.filter) {
                return "border border-highlight color-highlight";
            }

            return "border text-black-50";
        },

        search() {
            if (this.isLoading) return;
            this.$emit("update:isLoading", true);
            this.$emit("run:api", {
                filter: this.filter,
                paginationApi: this.paginationApi,
                isFiltered: true,
                searchQuery: this.searchQuery
            });
        },

        selectedColor(selectable) {
            if (selectable.isSelected === true) {
                return "border border-red-dark color-red-dark";
            }

            return "border border-highlight color-highlight";
        },

        removeItem(targetSelectable) {
            console.log("removing item", targetSelectable);
            // this.$emit('update:selectables', [...this.selectables, item]);
            this.$emit('update:items', this.items.filter(i => i.id != targetSelectable.id));
            const { useArrayFind } = window.VueUse;
            const selectable = useArrayFind(this.selectables, s => s.id === targetSelectable.id);
            selectable.value.isSelected = false;
        },

        setFilter(filter) {
            this.filter = filter;
            if (this.isLoading) return;
            this.$emit("update:isLoading", true);
            this.$emit("run:api", { filter: this.filter, paginationApi: this.paginationApi, isFiltered: true });
        }

    }
};
</script>