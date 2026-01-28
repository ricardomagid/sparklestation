let modalFetchController = null;

/**
 * Utility function to handle modal animations
 * @param {HTMLElement} modal - The modal element
 * @param {boolean} isOpening - Whether it is opening or closing the modal
 */
function animateModal(modal, isOpening) {
    if (!modal) return Promise.resolve();

    return new Promise((resolve) => {
        if (isOpening) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                modal.classList.remove('opacity-0', 'scale-95');
                modal.classList.add('opacity-100', 'scale-100');
                resolve();
            }, 10);
        } else {
            modal.classList.remove('opacity-100', 'scale-100');
            modal.classList.add('opacity-0', 'scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                resolve();
            }, 300);
        }
    });
}

/**
 * Opens an image modal with smooth animation effects
 * @param {string} imageSrc - The source URL of the image to display
 */
export function openImageModal(imageSrc) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');

    if (!modal || !modalImage) {
        console.error('Image modal elements not found');
        return;
    }

    // Set the image source
    modalImage.src = imageSrc;

    // Open the modal
    animateModal(modal, true);
}

/**
 * Closes the image modal with a fade-out animation
 */
export function closeImageModal() {
    const modal = document.getElementById('imageModal');
    animateModal(modal, false);
}

/**
 * Opens the filter modal and populates checkboxes based on current visibility
 * @param {boolean} isCharacter - Whether the filter is for character data
 */
export function openFilterModal(isCharacter) {
    const modal = document.getElementById('filterModal');

    if (!modal) {
        console.error('Filter modal element not found');
        return;
    }

    // Create array of all possible column filters
    let visibleFilters = ['rarity-column', 'path-column', 'atk-column', 'hp-column', 'def-column'];

    if (isCharacter) {
        visibleFilters.push('element-column', 'faction-column', 'speed-column')
    }

    // Filter to keep only columns that are currently visible (not hidden)
    visibleFilters = visibleFilters.filter(filter => {
        const element = document.getElementById(filter);
        return element && !element.classList.contains('hidden');
    });

    // Reset all checkboxes to unchecked state
    document.querySelectorAll("#column-filter input").forEach(input => {
        input.checked = false;
    });

    // Check boxes for columns that are currently visible
    visibleFilters.forEach(filter => {
        const nameFilter = filter.split("-")[0];
        const checkbox = document.querySelector(`#column-filter input[value="${nameFilter}"]`);
        if (checkbox) {
            checkbox.checked = true;
        }
    });

    // Make the Sort, Order and Items per page fields adjust based on the current window value
    if (typeof window.sortOrder !== 'undefined') {
        const orderSelect = document.querySelector('#column-order');
        if (orderSelect) orderSelect.value = window.sortOrder.toLowerCase();
    }

    if (typeof window.sortDirection !== 'undefined') {
        const directionSelect = document.querySelector('#column-direction');
        if (directionSelect) directionSelect.value = window.sortDirection;
    }

    if (typeof window.itemsPerPage !== 'undefined') {
        const itemsSelect = document.querySelector('#items-per-page');
        if (itemsSelect) itemsSelect.value = window.itemsPerPage;
    }

    // Show the modal with animation
    animateModal(modal, true);
}

/**
 * Closes the filter modal
 */
export function closeFilterModal() {
    const modal = document.getElementById('filterModal');
    animateModal(modal, false);
}

/**
 * Opens the timeline card modal and populates the data based on the patch clicked
 * @param {HTMLElement} patch - The patch element clicked
 */
export async function openTimelineModal(patchId) {
    const modal = document.getElementById("timelineModal");
    const loadingState = document.getElementById('modalLoading');
    animateModal(loadingState, true);

    modalFetchController = createModalFetchController();
    const { signal } = modalFetchController;

    try {
        const response = await fetch(`/api/patches/${patchId}`, {signal});
        const patch = await response.json();

        document.getElementById('modalBackgroundImage').style.backgroundImage = `url('${patch.img}')`;
        document.getElementById('modalPatchNumber').textContent = patch.formatted_number;
        document.getElementById('modalPatchName').textContent = patch.name;
        document.getElementById('modalDuration').textContent = patch.formatted_duration;
        document.getElementById('modalStoryArc').textContent = patch.story_arc?.name || 'N/A';

        // Populate characters
        const charactersContainer = document.getElementById('modalCharacters');
        charactersContainer.innerHTML = '';
        if (patch.characters && patch.characters.length > 0) {
            patch.characters.forEach(character => {
                const characterDiv = document.createElement('div');
                characterDiv.className = 'w-20 h-24 rounded-lg overflow-hidden hover:scale-105 transition-transform duration-200 cursor-pointer';
                characterDiv.innerHTML = `
                    <a href="/characters/${character.id}">
                        <img src="${character.icon_img}" alt="${character.name}" title="${character.name}" 
                             class="w-full h-full object-cover" />
                    </a>
                `;
                charactersContainer.appendChild(characterDiv);
            });
        } else {
            charactersContainer.innerHTML = '<p class="text-gray-400 text-sm">No new characters</p>';
        }

        // Populate lightcones
        const lightconesContainer = document.getElementById('modalLightcones');
        lightconesContainer.innerHTML = '';
        if (patch.lightcones && patch.lightcones.length > 0) {
            patch.lightcones.forEach(lightcone => {
                const lightconeDiv = document.createElement('div');
                lightconeDiv.className = 'w-24 h-[28 rounded-lg overflow-hidden hover:scale-105 transition-transform duration-200 cursor-pointer';
                lightconeDiv.innerHTML = `
                    <a href="/lightcones/${lightcone.id}">
                        <img src="${lightcone.img}" alt="${lightcone.name}" title="${lightcone.name}" 
                             class="w-full h-full object-cover" />
                    </a>
                `;
                lightconesContainer.appendChild(lightconeDiv);
            });
        } else {
            lightconesContainer.innerHTML = '<p class="text-gray-400 text-sm">No new lightcones</p>';
        }

        animateModal(loadingState, false);
        animateModal(modal, true);
    } catch (error) {
        if (error.name === 'AbortError') {
            console.log('Fetch aborted by user.');
        } else {
            console.error('Error loading patch data:', error);
        }
    }
}

/**
 * Closes the filter modal
 */
export function closeTimelineModal() {
    const modal = document.getElementById('timelineModal');
    animateModal(modal, false);
}

// Abort any previous controller and make only one request active
export function createModalFetchController() {
    if (modalFetchController) {
        modalFetchController.abort();
    }
    modalFetchController = new AbortController();
    return modalFetchController;
}

/**
 * Abort the fetch process
 */
export function stopFetch() {
    if (modalFetchController) {
        modalFetchController.abort();
        modalFetchController = null; 

        const loadingState = document.getElementById('modalLoading');

        return animateModal(loadingState, false);
    }

    return Promise.resolve();
}

/**
 * Open the loading modal
 */
export function openLoadingModal() {
    const modal = document.getElementById("modalLoading");
    animateModal(modal, true);
}

/**
 * Close the loading modal
 */
export function closeLoadingModal() {
    const modal = document.getElementById("modalLoading");
    animateModal(modal, false);
}

/**
 * Open the unique buffs modal
 */
export function openUniqueBuffsModal() {
    const modal = document.getElementById("uniqueBuffsModal")

    animateModal(modal, true);
}

/**
 * Close the unique buffs modal
 */
export function closeUniqueBuffsModal() {
    const modal = document.getElementById("uniqueBuffsModal")

    animateModal(modal, false);
}