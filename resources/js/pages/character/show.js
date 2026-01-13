import { DiagramManager } from './diagrams/DiagramManager.js';

import { updateEnemySlider, hideStatsPanel } from '../../utils.js';

// For Char Pages
let isTransitioning = false;
// For Story Panels
let isSwitching = false;
let activePanel = 'overview';

const divCharModel = document.getElementById("char-model");
const divCharDetails = document.getElementById("char-details");
const divCharSplash = document.getElementById("characterSplash");
const divCharSplashBackground = document.getElementById("characterSplashBackground");
const skillTabButtons = document.querySelectorAll('[data-category]');
const skillPanels = document.querySelectorAll("[data-skill-panel]");
const activeStoryCardHeader = document.querySelector("#currentStoryDescription");
const XL = window.matchMedia('(min-width: 1440px)');

const DESKTOP_ELEMENTS = {
    overview: [
        [divCharModel, false],
        [divCharDetails, true],
        [divCharSplash, true],
        [divCharSplashBackground, false]
    ],
    default: [
        [divCharModel, true],
        [divCharDetails, false],
        [divCharSplash, false],
        [divCharSplashBackground, true]
    ]
};

/**
 * Sets the model image height to match the details table height for lightcone and characters
 * Used for mobile screens
 */
export function setModelHeight(modelSelector, detailsSelector) {
    const model = document.querySelector(modelSelector);
    const details = document.querySelector(detailsSelector);
    if (model && details) {
        const height = details.getBoundingClientRect().height;
        model.style.height = `${height}px`;
    }
}

/**
 * Show or hide a panel with transition classes
 * @param {HTMLElement} element - The DOM element to update
 * @param {boolean} shouldShow - Whether the element should be shown or hidden
 */
function setElementState(element, shouldShow) {
    if (!element) return;

    element.classList.remove('panel-enter', 'panel-exit', 'panel-hidden');

    if (shouldShow) {
        element.classList.add('panel-enter');
    } else {
        element.classList.add('panel-exit');
        setTimeout(() => {
            if (!element.classList.contains('panel-enter')) {
                element.classList.add('panel-hidden');
            }
        }, 500);
    }
}

/**
 * Toggle desktop-only elements depending on active panel
 * @param {string} panelName - The name of the active panel
 */
function updateDesktopElements(panelName) {
    const config = DESKTOP_ELEMENTS[panelName] || DESKTOP_ELEMENTS.default;
    config.forEach(([element, shouldShow]) => {
        setElementState(element, shouldShow);
    });
}

/**
 * Switch active panel for both mobile and desktop layouts
 * @param {string} panelName - The name of the panel to activate
 */
function updatePanels(panelName) {
    const layouts = ['mobile', 'desktop'];

    layouts.forEach(layout => {
        const root = document.querySelector(`[data-layout="${layout}"]`);
        if (!root) return;

        // Update navigation tabs
        updateNavTabs(root, panelName);

        // Update right panels
        updateRightPanels(root, panelName);

        // Handle desktop-specific elements
        if (layout === 'desktop') {
            updateDesktopElements(panelName);
        }
    });
}

/**
 * Highlight the active tab
 * @param {HTMLElement} root - The layout root element
 * @param {string} activePanelName - The name of the currently active panel
 */
function updateNavTabs(root, activePanelName) {
    root.querySelectorAll('.char-nav .tab').forEach(tab => {
        const isActive = tab.textContent.trim().toLowerCase() === activePanelName;
        tab.classList.toggle('active', isActive);
    });
}

/**
 * Show the matching right panel and hide the rest
 * @param {HTMLElement} root - The layout root element
 * @param {string} activePanelName - The name of the currently active panel
 */
function updateRightPanels(root, activePanelName) {
    root.querySelectorAll('.right-panel[data-panel]').forEach(panel => {
        const isActive = panel.dataset.panel === activePanelName;

        setElementState(panel, isActive);
        panel.classList.toggle('active-panel', isActive);

        if (root.dataset.layout === "mobile") {
            const wrapper = panel.querySelector('.panel-wrapper');

            if (wrapper) {
                if (isActive) {
                    panel.classList.add("flex-1", "min-h-0");
                    panel.classList.remove("panel-hidden");
                    wrapper.classList.add("inset-0", "h-full", "overflow-y-auto");
                    wrapper.classList.remove("h-max");
                } else {
                    panel.classList.remove("flex-1", "min-h-0", "overflow-y-auto");
                    wrapper.classList.remove("inset-0", "h-full", "overflow-y-auto");
                    wrapper.classList.add("h-max");
                }
            } else {
                if (isActive) {
                    panel.classList.remove("panel-hidden");
                }
            }
        }
    });
}

/**
 * Change the current panel and refresh UI
 * @param {string} name - The name of the panel to activate
 */
function setActivePanel(name) {
    activePanel = name;
    updatePanels(name);
}

/**
 * Handle tab clicks to switch panels (with transition guard)
 * @param {HTMLElement} tab - The clicked tab element
 */
export function switchPage(tab) {
    if (isTransitioning) return;

    const name = tab.textContent.trim().toLowerCase();
    if (name === activePanel) return;

    isTransitioning = true;
    setActivePanel(name);

    setTimeout(() => { isTransitioning = false; }, 500);
}

/**
 * Reset a panel to its initial state
 * @param {HTMLElement} panel - The panel element to hydrate
 * @param {boolean} isActive - Whether this panel should be active initially
 */
function hydratePanel(panel, isActive) {
    panel.classList.remove('panel-enter', 'panel-exit');
    panel.classList.toggle('active-panel', isActive);
    panel.classList.toggle('panel-hidden', !isActive);

    if (isActive) {
        panel.classList.add('panel-enter');
    }
}

/**
 * Set up panels on page load, picking the initial active one
 */
function initializePanel() {
    const panels = document.querySelectorAll('.right-panel[data-panel]');

    // Determine initial active panel
    const current = document.querySelector('.right-panel.active-panel') ||
        document.querySelector('.right-panel[data-panel="overview"]');
    activePanel = current?.dataset.panel || 'overview';

    panels.forEach(panel => {
        const isActive = panel.dataset.panel === activePanel;
        hydratePanel(panel, isActive);
    });
}

/**
 * Refresh panels when screen size changes
 */
function handleBreakpointChange() {
    updatePanels(activePanel, false);
}

/**
 * Switch skill tab and display matching panel
 * @param {HTMLElement} tab - The clicked skill tab button element
 */
export function changeSkillTabs(tab) {
    const category = tab.getAttribute('data-category');

    // Hide all panels
    skillPanels.forEach(panel => {
        panel.classList.add('hidden');
    });

    // Reset all tab button styles
    skillTabButtons.forEach(btn => {
        btn.classList.remove('skill-tab-active');
        btn.classList.add('skill-tab-unactive');
    });

    // Show selected panel in both layouts
    document.querySelectorAll(`[data-skill-panel="${category}"]`).forEach(panel => {
        panel.classList.remove('hidden');
    });

    // Style active tab in both layouts
    document.querySelectorAll(`[data-category="${category}"]`).forEach(btn => {
        btn.classList.remove('skill-tab-unactive');
        btn.classList.add('skill-tab-active');
    });
}

/**
 * Updates ability slider values and recalculates skill descriptions
 * @param {HTMLInputElement} slider - The ability slider element that was changed
 * @param {boolean} [updateAbilityPositions=true] - Whether to update ability position mappings
 */
export function updateAbilitySlider(slider, updateAbilityPositions = true) {
    const level = Number(slider.value);
    const category = slider.dataset.ability;

    // Assign the value and text content for both mobile and desktop layouts
    document.querySelectorAll(`[data-skill-panel="${category}"]`).forEach(panel => {
        // Update the number display
        panel.querySelectorAll(".ability-slider-number").forEach(el => {
            el.textContent = level;
        });

        // Update the slider
        panel.querySelectorAll(".ability-slider").forEach(slider => {
            slider.value = level;
        });
    });

    let currentLayout;

    // Update the values of the corresponding category
    let descriptions;
    if (slider.classList.contains("skill-slider")) {
        descriptions = document.querySelectorAll(`[data-skill-panel="${category}"] .ability-description`);
    } else if (slider.classList.contains("trace-slider")) {
        descriptions = document.querySelectorAll(`#circleTraces .ability-description`);
    }

    descriptions?.forEach(description => {
        const abilityId = description.dataset.abilityId;
        const abilityValues = window.characterData.abilityValues[abilityId];
        const baseValues = JSON.parse(description.dataset.baseNumbers);
        if (description.closest("#app-mobile")) {
            currentLayout = "mobile"
        } else if (description.closest("#app-desktop")) {
            currentLayout = "desktop"
        }

        // Replace the "position" column of abilityValues with the baseValue of the corresponding ability if not empty
        if (abilityValues && abilityValues[0] && abilityValues[0].length > 0) {
            // Only runs once (desktop by default)
            if (updateAbilityPositions && currentLayout != "mobile") {
                abilityValues[1] = abilityValues[1].map(position => {
                    return Number(baseValues[position - 1])
                })
            }

            // Select all numbers from the description and change the ones that match
            description.querySelectorAll(".ability-number").forEach((numberElement, index) => {
                let number = Number(baseValues[index])
                if (abilityValues[1].includes(number)) {
                    const foundIndex = abilityValues[1].indexOf(number)
                    const difference = abilityValues[0][foundIndex]

                    // Increase difference by 25% for each level between 7~10
                    let bonus = 0;
                    let amountBonus = 0;
                    if (level >= 7 && category != "basic-atk") {
                        // Amount of levels with the 25% bonus, capped at 4
                        amountBonus = Math.min(level - 6, 4);
                        // Multiply with the difference
                        bonus = abilityValues[0][foundIndex] * (0.25 * amountBonus);
                    }
                    // Base Value + (level * difference)
                    numberElement.textContent = parseFloat(abilityValues[1][foundIndex] + ((level - 1) * difference) + bonus).toFixed(2);
                }
            })
        }
    })

    // Add Materials
    const maxSliderLevel = Number(slider.getAttribute("max"));
    if (
        slider.classList.contains("trace-slider") &&
        ((level < 10 && maxSliderLevel === 15) || (level < 8 && maxSliderLevel === 10))
    ) {
        const materialContainer = document.querySelector("#sidePanel #traceMaterialsPanel");
        if (!materialContainer) return;

        materialContainer.innerHTML = "";
        if (level > 1) {
            const pointer = getMaterialPointer(level, maxSliderLevel);
            const materials = window.characterData.traceMaterials[pointer];
            materialContainer.innerHTML = renderMaterials(materials);
        }
    }
}

/**
 * Determine the material pointer key for trace materials
 * based on the current level and the slider's max level
 *
 * @param {number} level - The current level of the trace slider
 * @param {number} maxSliderLevel - The maximum value allowed by the slider
 * @returns {string} The key used to fetch the correct material set
 */
function getMaterialPointer(level, maxSliderLevel) {
    if (maxSliderLevel === 10) {
        if (level === 10) return "basic_max";
        return "ability" + (level + 2);
    }
    return "ability" + level;
}

/**
 * Generate the HTML markup for a given list of materials
 *
 * @param {Array<{material: {image_url: string, name: string}, quantity: number}>} materials
 *   - Array of material objects, each containing metadata and quantity
 * @returns {string} HTML string representing the materials in a grid layout
 */
function renderMaterials(materials) {
    if (!materials) return "";

    const items = materials.map(mat => `
        <div class="flex flex-col items-center">
            <div class="w-12 h-12 rounded-full bg-[#FFE0E0] p-1 flex items-center justify-center">
                <img src="${mat.material.image_url}" alt="${mat.material.name}" class="w-10 h-10 object-contain">
            </div>
            <span class="text-white text-xs mt-1 text-center break-words max-w-[4rem]">
                ${mat.material.name}
            </span>
            <span class="text-yellow-200 text-xs font-bold">×${mat.quantity}</span>
        </div>
    `).join("");

    return `<div class="grid grid-cols-2 gap-4 justify-items-center">${items}</div>`;
}

/**
 * Initializes the trace diagram component
 * Creates and initializes a DiagramManager instance for character traces
 */
export function setTraceDiagram() {
    const diagramContainer = document.querySelector("#traceDiagram")
    const pathName = diagramContainer.dataset.path.toLowerCase().replace(/\s+/g, '-');
    const characterName = diagramContainer.dataset.characterName;

    const diagramManager = new DiagramManager(diagramContainer, pathName, characterName)
    diagramManager.init()
}

/**
 * Extracts the numeric index from a story card element's ID
 * @param {HTMLElement} card - The story card element with ID format "storyBlockN"
 * @returns {number} The numeric index of the story card, or -1 if invalid
 */
function getStoryCardIndex(card) {
    const raw = card.id.replace("storyBlock", "");
    const n = parseInt(raw, 10);
    return Number.isFinite(n) ? n : -1;
}

/**
 * Updates the visual state of a story card based on whether it's active or inactive
 * @param {HTMLElement} card - The story card element to update
 * @param {boolean} isActive - Whether the card should be in active state
 */
function updateCardVisualState(card, isActive) {
    const header = card.querySelector(".story-header");
    const description = card.querySelector(".story-description");
    const headerText = header.querySelector("p");

    header?.classList.toggle("p-6", isActive);
    header?.classList.toggle("p-4", !isActive);

    card.classList.toggle("max-w-4xl", isActive);
    card.classList.toggle("cursor-pointer", !isActive);

    if (description) description.classList.toggle("hidden", !isActive);

    if (headerText) {
        headerText.classList.toggle("p-header-clicked", isActive);
        headerText.classList.toggle("p-header", !isActive);
    }
}


/**
 * Reinserts a story card back into the grid in its proper numerical order
 * Maintains the correct sequence of story cards based on their numeric indices
 * @param {HTMLElement} currentCard - The card element to reinsert
 */
function reinsertCardInOrder(currentCard) {
    const currentIndex = getStoryCardIndex(currentCard)
    const allCards = [...document.querySelectorAll('.story-card')];

    // Find where to reinsert the current card to preserve order
    let reinserted = false;
    for (let card of allCards) {
        const index = getStoryCardIndex(card)
        if (index > currentIndex) {
            card.before(currentCard);
            reinserted = true;
            break;
        }
    }

    if (!reinserted) {
        // Put it at the end if it's the last in order
        const listContainer = document.querySelector('.story-card-list');
        if (listContainer) listContainer.appendChild(currentCard);
        else document.body.append(currentCard);
    }
}

/**
 * Switches the active story card with smooth transitions
 * Moves the current card back to the grid and displays the selected card in the main story area
 * @param {HTMLElement} newActiveCard - The story card element to make active
 */
export function switchStoryCards(newActiveCard) {
    if (isSwitching) return;
    if (activeStoryCardHeader.contains(newActiveCard)) return;

    isSwitching = true;
    const currentCard = activeStoryCardHeader.querySelector('.story-card');

    const removeCurrentCard = () => {
        return new Promise(resolve => {
            if (!currentCard) return resolve();

            currentCard.classList.add('fade-out');

            currentCard.addEventListener('transitionend', () => {
                updateCardVisualState(currentCard, false);
                reinsertCardInOrder(currentCard);
                currentCard.classList.remove('fade-out');
                resolve();
            }, { once: true });
        })
    }

    const showNewCard = () => {
        return new Promise(resolve => {
            activeStoryCardHeader.append(newActiveCard);
            updateCardVisualState(newActiveCard, true);
            newActiveCard.classList.add('fade-in');

            // Trigger reflow for transition
            void newActiveCard.offsetWidth;
            newActiveCard.classList.add('show');

            newActiveCard.addEventListener('transitionend', () => {
                newActiveCard.classList.remove('fade-in', 'show');
                resolve()
            }, { once: true });
        });
    }

    removeCurrentCard().then(showNewCard).finally(() => isSwitching = false)
}

/**
 * Fills trace material containers on mobile with character data
 * Populates material requirement displays for character trace upgrades
 */
function fillTraceMaterialContainer() {
    document.querySelectorAll(".mobile-trace-mat-container").forEach(container => {
        const traceId = container.dataset.traceId;

        const mats = window.characterData.traceMaterials[traceId]

        mats.forEach(mat => {
            const materialEl = document.createElement('div');
            materialEl.className = 'flex flex-col items-center';
            materialEl.innerHTML = `
                                    <div class="w-12 h-12 rounded-full bg-[#FFE0E0] p-1 flex items-center justify-center">
                                    <img src="${mat.material.image_url}" alt="${mat.material.name}" class="w-10 h-10 object-contain">
                                    </div>
                                    <span class="text-white text-xs mt-1 text-center break-words max-w-[4rem]">${mat.material.name}</span>
                                    <span class="text-yellow-200 text-xs font-bold">×${mat.quantity}</span>
                                `;
            container.appendChild(materialEl.cloneNode(true));
        });
    });
}

/**
 * Main setup for the character page (panels, sliders, events, etc.)
 */
export default function initializeCharacterPage() {
    try {
        if (initializeCharacterPage._done) return;
        initializeCharacterPage._done = true;

        // Initialize panels
        initializePanel();

        // Fill trace material containers
        fillTraceMaterialContainer();

        // Add slider functionality for the enemy mats
        document.querySelectorAll(".stat-slider-input")?.forEach(statSlider => {
            statSlider.addEventListener("input", function () {
                updateEnemySlider(this.value)
            })
        });

        // Add navigation tab event listeners
        document.querySelectorAll(".char-nav .tab")?.forEach(tab => {
            tab.addEventListener("click", function (event) {
                switchPage(event.currentTarget)
            })
        })

        // Add skill tab event listeners
        const skillTabButtons = document.querySelectorAll('[data-category]');
        skillTabButtons.forEach(button => {
            button.addEventListener("click", function (event) {
                changeSkillTabs(event.currentTarget)
            })
        });

        // Add slider functionality for the ability levels in both layouts
        const abilitySliders = document.querySelectorAll(".ability-slider");
        abilitySliders.forEach(slider => {
            slider.addEventListener("input", function (event) {
                updateAbilitySlider(event.currentTarget, false);
            })
            if (slider.closest("#app-desktop")) {
                updateAbilitySlider(slider);
            }
        })

        // Set the trace diagram
        setTraceDiagram()

        // Add click event listeners to story cards
        const storyCards = document.querySelectorAll(".story-card")
        storyCards.forEach(storyCard => {
            storyCard.addEventListener("click", function (event) {
                switchStoryCards(event.currentTarget)
            })
        })

        // Set char model height (for smaller screens)
        window.addEventListener('resize', () => {
            setModelHeight('#tableMobileModel', '.mobile-details-table');
        });
        setModelHeight('#tableMobileModel', '.mobile-details-table');

        // Add click event listener for character stats toggle
        const charStatsButton = document.querySelector("#charStatsButton");
        if (charStatsButton) {
            charStatsButton.addEventListener("click", function (event) {
                hideStatsPanel();
                event.target.classList.toggle("active");
            })
        }

        // Expand trace material panel for mobile on click
        document.querySelectorAll(".main-trace-panel").forEach(panel => {
            const arrow = panel.querySelector(".arrow");
            const traceMaterialTab = panel.querySelector(".mobile-trace-mat-container");

            panel.addEventListener("click", () => {
                // Check if panel is currently closed (has 'hidden' class)
                const isCurrentlyClosed = traceMaterialTab.classList.contains("hidden");

                if (isCurrentlyClosed) {
                    // Open the panel
                    traceMaterialTab.classList.remove("hidden");
                    traceMaterialTab.classList.add("flex");
                    arrow.classList.add("rotate-90");
                } else {
                    // Close the panel
                    traceMaterialTab.classList.add("hidden");
                    traceMaterialTab.classList.remove("flex");
                    arrow.classList.remove("rotate-90");
                }
            });
        });

        // Expand story panel on click
        document.querySelectorAll(".story-clickable").forEach(container => {
            const arrow = container.querySelector(".arrow");
            const storyContainer = container.closest(".story-container")

            container.addEventListener("click", function (event) {
                const storyDescriptionContainer = storyContainer.querySelector('div[data-story]');
                const isCurrentlyClosed = storyDescriptionContainer.classList.contains("hidden");

                if (isCurrentlyClosed) {
                    // Open the panel
                    storyDescriptionContainer.classList.remove("hidden");
                    storyDescriptionContainer.classList.add("flex");
                    arrow.classList.add("rotate-90");
                } else {
                    // Close the panel
                    storyDescriptionContainer.classList.add("hidden");
                    storyDescriptionContainer.classList.remove("flex");
                    arrow.classList.remove("rotate-90");
                }
            })
        });

        // Handle breakpoint changes
        XL.addEventListener('change', handleBreakpointChange);
    } catch (error) {
        console.error('Failed to initialize character page:', error);
    }
}