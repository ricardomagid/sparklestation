const limit = 3;
let backgroundTimeout;
let currentBg = null;
let isRight = false;
let currentTimelineSearch = 0;
let timelineSearchedCards = [];
const pageTitle = document.querySelector("#pageTitle");
const searchBar = document.querySelector("#searchBar");
const sliderDiv = document.querySelector("#formatSlider");
const thumb = sliderDiv?.querySelector("div");
const cardFormat = document.querySelector("#cardFormat");
const timelineFormat = document.querySelector("#timelineFormat");
const scrollContainer = document.querySelector("#scrollContainer");
const timelineLeftArrow = document.querySelector(".arrow-left");
const timelineRightArrow = document.querySelector(".arrow-right");
const searchFilters = document.querySelectorAll("input[name='searchFilter']");
const patchesBasicData = Array.from(document.querySelectorAll(".patch-card")).map(card => {
    const patchNameEl = card.querySelector(".patch-name");
    const patchName = patchNameEl ? patchNameEl.textContent.trim() : "";

    const timelineCard = Array.from(document.querySelectorAll(".timeline-card")).find(tlCard => {
        const tlNameEl = tlCard.querySelector(".timeline-patch-name");
        const tlName = tlNameEl ? tlNameEl.textContent.trim() : "";

        return patchName.includes(tlName);
    })

    return {
        card,
        patch: patchName,
        timelineCard,
        characters: Array.from(card.querySelectorAll(".character-section .item")),
        lightcones: Array.from(card.querySelectorAll(".lightcone-section .item")),
    }
})

/**
 * Limit each patch content to just limit icons
 * Iterates through all patch cards and applies toggle logic
 */
function limitPatchCard() {
    document.querySelectorAll(".patch-card-content").forEach(card => {
        const sections = getSections(card);
        sections.forEach(container => toggleItems(container, card));
        handleArrow(card);
    });
}

/**
 * Expand the patch card to show all items
 * @param {HTMLElement} card The patch card to expand
 */
function expandPatchCard(card) {
    card.querySelectorAll(".section-limited").forEach(span => span.remove());
    card.closest(".patch-content-wrapper").querySelector(".expand-indicator")
        ?.classList.add("expanding");
    card.querySelectorAll(".item").forEach(e => e.style.display = 'flex');
}

/**
 * Collapse the patch card to limit visible items
 * @param {HTMLElement} card The patch card to collapse
 */
function collapsePatchCard(card) {
    const sections = getSections(card);
    sections.forEach(container => toggleItems(container, card));
    card.closest(".patch-content-wrapper").querySelector(".expand-indicator")
        ?.classList.remove("expanding");
}

/**
 * Toggle display for items in a container and add "+N" span if needed
 * @param {HTMLElement|null} container The container element holding items
 * @param {HTMLElement} card The patch card containing the container
 */
function toggleItems(container, card) {
    if (!container) return;

    const items = Array.from(container.children)
        .filter(c => !c.classList.contains('section-limited'));

    items.forEach((item, index) => {
        item.style.display = (index < limit) ? 'flex' : 'none';
    });

    if (items.length > limit && !container.querySelector(".section-limited")) {
        container.appendChild(createSpan(items, card));
    }
}

/**
 * Get relevant sections of a card (characters and lightcones)
 * @param {HTMLElement} card The patch card
 * @returns {HTMLElement[]} Array containing the character and lightcone item containers
 */
function getSections(card) {
    return [
        card.querySelector(".character-section .item-container"),
        card.querySelector(".lightcone-section .item-container")
    ];
}

/**
 * Create a "+N" span to indicate hidden items
 * @param {HTMLElement[]} items Array of item elements in the container
 * @param {HTMLElement} card The patch card containing the items
 * @returns {HTMLSpanElement} The created span element
 */
function createSpan(items, card) {
    const span = document.createElement('span');
    span.textContent = `+${items.length - limit}`;
    span.classList.add("section-limited");
    span.style.cursor = "pointer";
    span.addEventListener("click", () => expandPatchCard(card));
    return span;
}

/**
 * Handle creation or reset of the arrow indicator
 * @param {HTMLElement} card The patch card to handle arrow for
 */
function handleArrow(card) {
    let arrow = card.closest(".patch-content-wrapper").querySelector(".expand-indicator");

    if (!arrow && card.querySelector(".section-limited")) {
        arrow = createArrowDiv(card);
        card.closest(".patch-content-wrapper").appendChild(arrow);
    }

    // If arrow exists, reset its state
    if (arrow) {
        arrow.classList.remove("expanding");
    }
}

/**
 * Create arrow div to expand/collapse the patch card
 * @param {HTMLElement} card The patch card to control
 * @returns {HTMLDivElement} The created arrow div element
 */
function createArrowDiv(card) {
    const div = document.createElement('div');
    div.classList.add("expand-indicator");
    div.innerHTML = `
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#dc2626" stroke-width="2" 
                    stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 8 12 14 18 8"></polyline>
                        <polyline points="6 12 12 18 18 12"></polyline>
                    </svg>
    `;
    div.addEventListener("click", () => {
        if (div.classList.contains("expanding")) {
            collapsePatchCard(card);
        } else {
            expandPatchCard(card);
        }
    });
    return div;
}

/**
 * Toggle the visibility of a story arc section
 * @param {HTMLElement} arc The arc header element that was clicked
 */
function toggleArcVisibility(arc) {
    const arcContainer = arc.closest(".story-arc-section");

    arcContainer.classList.toggle("closed")
}

/**
 * Toggle the visibility of search filter options
 * @param {Event} e The click event from the filter toggle button
 */
function toggleSearchFilterVisibility(e) {
    e.currentTarget.querySelector(".filter-icon").classList.toggle("rotated");

    document.querySelector(".search-tree-structure").classList.toggle("expanded");
}

/**
 * Update the patch list based on search input and active filters
 * @param {Event} e The input event from the search bar
 */
function updatePatchList(e) {
    const value = e.currentTarget.value;
    const enabledFilters = Array.from(searchFilters).filter(cb => cb.checked).map(cb => cb.value);
    let glowItems = [];
    timelineSearchedCards = [];

    patchesBasicData.forEach(p => {
        // Clear glow
        p.characters.forEach(c => c.classList.remove("focus"));
        p.lightcones.forEach(l => l.classList.remove("focus"));
        let match = false
        if (value.length > 2) {
            enabledFilters.forEach(filter => {
                let matchedItems = valueMatches(value, p[filter]);
                console.log("matched elements: ", matchedItems)
                if (matchedItems.length) {
                    p.card.classList.remove("hidden");
                    match = true;
                    if (["characters", "lightcones"].includes(filter)) {
                        glowItems.push(...matchedItems);
                    }
                }
            });

            if (!match) {
                p.card.classList.add("hidden");
            } else {
                timelineSearchedCards.push(p.timelineCard);
            }
        } else {
            p.card.classList.remove("hidden");
        }
    });

    // Hide or show the respective story arcs based on the visibility of its items
    document.querySelectorAll('.story-arc-section').forEach(section => {
        const allHidden = Array.from(section.querySelectorAll('.patch-card'))
            .every(card => card.classList.contains('hidden'));
        if (allHidden) {
            section.classList.add('all-hidden');
        } else {
            section.classList.remove('all-hidden');
        }
    });

    // Handle the search function for the timeline cards
    currentTimelineSearch = 0;
    if (timelineSearchedCards.length > 0) updateTimelineSearch();

    // Add glow effects on matched elements
    glowItems.forEach(i => i.classList.add("focus"));
};

/**
 * Return the items that match with the data (string or array)
 * @param {string} value The search value to match against
 * @param {string|string[]} data The data to search in (can be string or array of strings)
 * @returns {boolean} Array of matches (empty if none are found)
 */
function valueMatches(value, data) {
    value = value.toLowerCase();

    if (Array.isArray(data)) {
        return data.filter(d => d.dataset.name.toLowerCase().includes(value));
    } else if (typeof data === "string") {
        return data.toLowerCase().includes(value) ? [data] : [];
    }

    return [];
}

/**
 * Updates the timeline search navigation and focuses on the target card
 * 
 * @param {number} dir - Direction to move in search results:
 *                       1 = next card (left arrow)
 *                       -1 = previous card (right arrow) 
 *                       0 = stay on current card (default)
 */
function updateTimelineSearch(dir = 0) {
    // Change counter based on the arrow clicked, if any
    currentTimelineSearch += dir;

    if (timelineSearchedCards.length == 0) return;

    // Reset all focus
    document.querySelectorAll(".timeline-card").forEach(card => card.classList.remove("focus"))
    // Focus the target card
    const targetCard = timelineSearchedCards[currentTimelineSearch];
    targetCard.classList.add("focus");

    // Set the scrollbar position to the location of the card
    targetCard.scrollIntoView({
        behavior: "smooth",
        inline: "center",
        block: "nearest"
    })

    // Handle arrow visibility
    timelineLeftArrow.classList.toggle("hidden", timelineSearchedCards.length == currentTimelineSearch + 1);
    timelineRightArrow.classList.toggle("hidden", currentTimelineSearch == 0);
}

/**
 * Update the CSS custom property for vignette width based on timeline inner width
 */
function updateVignetteWidth() {
    const timelineInner = scrollContainer.querySelector('.timeline-inner');
    const fullWidth = timelineInner.scrollWidth;

    // Set CSS custom property for vignette width
    scrollContainer.style.setProperty('--vignette-width', fullWidth + 'px');
}

/**
 * Switch between card format and timeline format views
 */
function pageFormatSwitch() {
    isRight = !isRight;
    thumb.style.left = isRight ? "50%" : "0";
    pageTitle.textContent = isRight ? "Patch Timeline" : "Patch List";

    if (isRight) {
        cardFormat.classList.add("hidden");
        timelineFormat.classList.remove("hidden");
        setTimeout(updateVignetteWidth, 50);

        // Set initial background and scroll position
        setTimeout(() => {
            setInitialBackground();
            scrollContainer.scrollLeft = scrollContainer.scrollWidth - scrollContainer.clientWidth;
        }, 100);

        updateArrowPositions();
    } else {
        timelineFormat.classList.add("hidden");
        cardFormat.classList.remove("hidden");
        currentBg = null; // Reset for next time
    }
}

/**
 * Update the timeline background image based on the most centered visible card
 */
function updateTimelineBackground() {
    if (!isRight) return;

    const cards = document.querySelectorAll(".timeline-card");
    if (cards.length === 0) return;

    // Find the most centered visible card
    let centerCard = null;
    let minDistance = Infinity;

    cards.forEach(card => {
        const rect = card.getBoundingClientRect();
        const cardCenter = rect.left + rect.width / 2;
        const screenCenter = window.innerWidth / 2;
        const distance = Math.abs(cardCenter - screenCenter);

        // Only consider cards that are at least partially visible
        if (rect.right > 0 && rect.left < window.innerWidth && distance < minDistance) {
            minDistance = distance;
            centerCard = card;
        }
    });

    // Update background if we found a different card
    if (centerCard && centerCard.dataset.storyarc && centerCard.dataset.storyarc !== currentBg) {
        const newBg = centerCard.dataset.storyarc;
        scrollContainer.style.backgroundImage = `url('${newBg}')`;
        currentBg = newBg;
    }
}

/**
 * Debounced handler for background updates on scroll events
 */
function handleBackgroundUpdate() {
    clearTimeout(backgroundTimeout);
    backgroundTimeout = setTimeout(updateTimelineBackground, 150);
}

/**
 * Set the initial background when switching to timeline view
 */
function setInitialBackground() {
    const cards = document.querySelectorAll(".timeline-card");
    if (cards.length === 0) return;

    // Get the last (rightmost) card since we scroll there initially
    const lastCard = cards[cards.length - 1];
    if (lastCard && lastCard.dataset.storyarc) {
        const initialBg = lastCard.dataset.storyarc;
        scrollContainer.style.backgroundImage = `url('${initialBg}')`;
        currentBg = initialBg;
    }
}

/**
 * Adjust the position of the arrows on resize/scroll
 */
function updateArrowPositions() {
    if (!scrollContainer || !timelineLeftArrow || !timelineRightArrow) return;

    const containerRect = scrollContainer.getBoundingClientRect();
    const margin = 20;
    const arrowWidth = 50;

    // Position arrows relative to container edges
    timelineLeftArrow.style.left = `${containerRect.left + margin}px`;
    timelineRightArrow.style.left = `${containerRect.right - margin - arrowWidth}px`;

    // Keep them vertically centered on container
    const containerCenter = containerRect.top + (containerRect.height / 2);
    timelineLeftArrow.style.top = `${containerCenter}px`;
    timelineRightArrow.style.top = `${containerCenter}px`;
}

/**
 * Main setup for the patches page 
 */
export default function initializePatchPage() {
    try {
        if (initializePatchPage._done) return;
        initializePatchPage._done = true;

        window.addEventListener("resize", () => {
            updateVignetteWidth();
            updateArrowPositions();
            updateTimelineSearch();
        });
        window.addEventListener("scroll", updateArrowPositions);

        // Check if timeline is initially visible
        if (!timelineFormat.classList.contains('hidden')) {
            isRight = true;
            setTimeout(() => {
                setInitialBackground();
                scrollContainer.scrollLeft = scrollContainer.scrollWidth - scrollContainer.clientWidth;
            }, 100);
        }

        // Limit each patch content to just 3 icons
        limitPatchCard();

        // Hide arc patches upon clicking on the arc
        document.querySelectorAll(".arc-header").forEach(arc => {
            arc.addEventListener("click", () => {
                toggleArcVisibility(arc)
            })
        })

        // Show search filters upon clicking on the button
        document.querySelector("#filterToggle").addEventListener("click", toggleSearchFilterVisibility);

        // Filter the patches based on the searchbar and filters
        searchBar.addEventListener("input", updatePatchList);
        searchFilters.forEach(filter => {
            filter.addEventListener("change", updatePatchList);
        })

        // Add format switch functionality
        document.getElementById("formatSlider")?.addEventListener("click", () => {
            pageFormatSwitch();
        });

        // Add scroll listener for scroll event
        scrollContainer.addEventListener('scroll', handleBackgroundUpdate, { passive: true });

        // Add functionality to the timeline arrows
        timelineLeftArrow.addEventListener("click", () => updateTimelineSearch(1));
        timelineRightArrow.addEventListener("click", () => updateTimelineSearch(-1));

    } catch (error) {
        console.error('Failed to initialize patch page:', error);
    }
}