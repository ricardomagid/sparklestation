import { stopFetch, createModalFetchController } from '../modal.js';

import { updatePopupContent, positionPopup } from '../utils.js';

const itemCards = document.querySelectorAll(".item-card");
const itemIconPopup = document.querySelector(".icon-pop-up");

class RelicsFilter {
    constructor({ minSearchLen = 3, debounceMs = 180 } = {}) {
        this.minSearchLen = minSearchLen;
        this.debounceMs = debounceMs;

        this.items = Array.from(itemCards).map(el => {
            const img = el.querySelector("img");
            const rawName = el.dataset.name || img?.alt || "";
            const name = String(rawName).trim().toLowerCase();
            const effects = [el.dataset.firstset, el.dataset.secondset];
            const type = (el.dataset.type || "").toLowerCase().split("_")[0];
            return { el, name, effects, type };
        });

        this.searchInput = document.getElementById("relicSearch");
        this.relicBtn = document.getElementById("relicFilter");
        this.planarBtn = document.getElementById("planarFilter");

        this._buttonType = btn => (btn.dataset.type || btn.id.replace(/Filter$/i, "")).toLowerCase();

        this.activeTypes = new Set(
            [this.relicBtn, this.planarBtn]
                .filter(b => b && b.classList.contains("active"))
                .map(b => this._buttonType(b))
        );

        this.searchValue = "";

        this._debounced = this._debounce(value => {
            this.searchValue = value.trim().toLowerCase();
            this.applyFilters();
        }, this.debounceMs);

        this.bindEvents();
        this.applyFilters();
    }

    bindEvents() {
        if (this.searchInput) {
            this.searchInput.addEventListener("input", (e) => {
                const v = e.target.value;
                if (v.length < this.minSearchLen && v.length > 0) {
                    this._debounced("");
                    return;
                }
                this._debounced(v);
            });
        }

        [this.relicBtn, this.planarBtn].forEach(btn => {
            if (!btn) return;
            btn.setAttribute("aria-pressed", btn.classList.contains("active"));
            btn.addEventListener("click", (e) => {
                const b = e.currentTarget;
                b.classList.toggle("active");
                const active = b.classList.contains("active");
                b.setAttribute("aria-pressed", String(active));

                const t = this._buttonType(b);
                if (active) this.activeTypes.add(t);
                else this.activeTypes.delete(t);

                this.applyFilters();
            });
        });
    }

    applyFilters() {
        const search = this.searchValue;

        this.items.forEach(({ el, name, effects, type }) => {
            const typeOk = this.activeTypes.has(type);
            const nameOk = !search || name.includes(search);
            const descriptionOk = !search || effects.some(effect => effect && effect.toLowerCase().includes(search));
            if (typeOk && (nameOk || descriptionOk)) el.classList.remove("hidden");
            else el.classList.add("hidden");
        });
    }

    refresh() {
        this.items = Array.from(document.querySelectorAll(".item-card")).map(el => {
            const img = el.querySelector("img");
            const rawName = el.dataset.name || img?.alt || "";
            return {
                el,
                name: String(rawName).trim().toLowerCase(),
                type: (el.dataset.type || "").toLowerCase().split("_")[0]
            };
        });
        this.applyFilters();
    }

    _debounce(fn, ms) {
        let id = null;
        return (...args) => {
            clearTimeout(id);
            id = setTimeout(() => fn(...args), ms);
        };
    }
}

class RelicsSPA {
    constructor() {
        this.listView = document.getElementById("listView");
        this.detailsView = document.getElementById("detailsView");
        this.backBtn = document.getElementById("backBtn");
        this.pageTitle = document.getElementById("pageTitle");
        this.detailsViewPieces = ".relic-wrapper > div";
        let currentPieces = document.querySelectorAll(this.detailsViewPieces);

        this.handleInitialLoad();
        this.bindEvents();
        this.updateDetailsViewEventListeners();
        this.updateDetailsView(currentPieces[0]);
    }

    bindEvents() {
        // Show details on item click
        itemCards.forEach(item => {
            item.addEventListener("click", (e) => {
                const card = e.target.closest('.item-card');
                const id = card.dataset.id;
                const type = card.dataset.type;

                this.showDetails(id, type, true)
            })
        })

        // Show list on arrow click
        this.backBtn.addEventListener("click", () => {
            this.showList(true)
        })

        // Browser back/foward
        window.addEventListener('popstate', (ev) => {
            const state = ev.state;
            if (state && state.type && state.id) {
                // Has state with details info
                this.showDetails(state.id, state.type, false)
            } else {
                // Empty state or no state - show list or parse URL
                this.handleRouteChange();
            }
        })
    }

    async fetchDetail(type, id, signal) {
        const apiUrl = type === 'relic'
            ? `/api/relics/relic/${id}`
            : `/api/relics/planar/${id}`;

        const res = await fetch(apiUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            },
            signal
        });

        if (!res.ok) {
            throw new Error(`HTTP ${res.status}: Item not found`);
        }
        return res.text();
    }

    showList(push = true) {
        if (push) {
            history.pushState({}, '', '/relics');
        }

        this.detailsView.classList.remove('hidden');
        this.listView.classList.remove('hidden');

        this.detailsView.style.transform = 'translateX(0)';
        this.listView.style.transform = 'translateX(-100%)';
        this.detailsView.style.opacity = '1';
        this.listView.style.opacity = '0';

        void this.detailsView.offsetHeight;

        requestAnimationFrame(() => {
            this.detailsView.style.transform = '';
            this.listView.style.transform = '';
            this.detailsView.style.opacity = '';
            this.listView.style.opacity = '';

            this.detailsView.classList.add('slide-out-right');
            this.listView.classList.add('slide-in-left');
        });

        setTimeout(() => {
            this.detailsView.classList.add('hidden');
            this.detailsView.classList.remove('slide-out-right');
            this.listView.classList.remove('slide-in-left');
            this.backBtn.classList.add('hidden');
        }, 300);

        this.pageTitle.textContent = "Relic List";
    }

    async showDetails(id, type, push = true) {
        // Ensure any previous fetch is aborted
        await stopFetch();

        openLoadingModal();

        const controller = createModalFetchController();
        const { signal } = controller;

        try {
            const html = await this.fetchDetail(type, id, signal);

            // Update content
            this.listView.classList.add('slide-out-left');
            this.detailsView.classList.remove('hidden');
            this.detailsView.classList.add('slide-in-right');
            this.backBtn.classList.remove('hidden');
            this.pageTitle.textContent = "Relic Details";

            setTimeout(() => {
                this.detailsView.innerHTML = html;

                requestAnimationFrame(() => {
                    let firstPiece = this.detailsView.querySelector('.relic-wrapper > div');
                    this.updateDetailsViewEventListeners();
                    this.updateDetailsView(firstPiece);
                });
            }, 50);

            setTimeout(() => {
                this.listView.classList.add('hidden');
                this.listView.classList.remove('slide-out-left');
                this.detailsView.classList.remove('slide-in-right');
            }, 300);

            // Update URL and state
            if (push) {
                const url = `/relics/${type}/${id}`;
                history.pushState({ type, id }, '', url);
            } else {
                const currentState = history.state || {};
                if (currentState.id !== id || currentState.type !== type) {
                    history.replaceState({ type, id }, '', window.location.pathname);
                }
            }
        } catch (err) {
            console.error('Error loading item:', err);

            if (err.name !== 'AbortError') {
                newNotification('error', `Error loading item: ${err}`)
            }

            if (!push) {
                history.replaceState({}, '', '/relics');
                this.showList(false);
            }
        } finally {
            closeLoadingModal();
        }
    }

    // Server-side rendering already shows correct initial view
    // This ensures SPA history.state is initialized for back/forward navigation
    handleInitialLoad() {
        // If URL is already a details page, keep details visible
        const path = window.location.pathname;
        const match = path.match(/\/relics\/(\w+)\/(\d+)/);

        if (match) {
            // On details page
            this.backBtn.classList.remove("hidden");
            const [, type, id] = match;

            const currentState = history.state || {};
            if (currentState.id !== id || currentState.type !== type) {
                history.replaceState({ type, id }, '', path);
            }
        } else {
            // On list page
            if (!history.state || Object.keys(history.state).length === 0) {
                history.replaceState({}, '', '/relics');
            }
        }
    }

    handleRouteChange() {
        const path = window.location.pathname;
        const match = path.match(/\/relics\/(\w+)\/(\d+)/);

        if (match) {
            const [, type, id] = match;
            this.showDetails(id, type, false);
        } else {
            this.showList(false);
        }
    }

    updateDetailsViewEventListeners() {
        this.detailsView.querySelectorAll(this.detailsViewPieces).forEach(piece => {
            piece.addEventListener("click", (e) => {
                this.updateDetailsView(e.currentTarget);
            })
        })
    }

    updateDetailsView(element) {
        if (!element) return;

        const allPieces = this.detailsView.querySelectorAll(this.detailsViewPieces);
        allPieces.forEach(piece => piece.classList.remove("active"));

        // Update the view
        element.classList.add("active");
        let detailsViewTitle = document.getElementById("relicTitle");
        let detailsViewStory = document.getElementById("relicStory");
        detailsViewTitle.textContent = element.dataset.name;
        detailsViewStory.textContent = element.dataset.story;
    }
}

/**
 * Main setup for the relic page
 */
export default function initializeRelicPage() {
    try {
        if (initializeRelicPage._done) return;
        initializeRelicPage._done = true;

        const app = new RelicsSPA();

        const filterApp = new RelicsFilter();

        // Open a pop-up window if mouse hovers over the item icons
        let hideTimeout;
        itemCards.forEach(item => {
            item.addEventListener('mouseenter', () => {
                clearTimeout(hideTimeout);
                updatePopupContent(item, itemIconPopup);
                positionPopup(item, itemIconPopup);
                itemIconPopup.classList.remove("hidden");
            })

            item.addEventListener("mouseleave", () => {
                hideTimeout = setTimeout(() => {
                    itemIconPopup.classList.add("hidden");
                }, 300);
            })
        })

        itemIconPopup.addEventListener("mouseenter", () => {
            clearTimeout(hideTimeout);
        })
        itemIconPopup.addEventListener("mouseleave", () => {
            itemIconPopup.classList.add("hidden")
        })

    } catch (error) {
        console.error('Error initializing relic page:', error);
    }
}