import { newNotification } from '../notifications.js';
import { updatePopupContent, positionPopup } from '../utils.js';

// Cache DOM elements
const itemElements = document.querySelectorAll(".item-section > div");
const searchInput = document.querySelector("#search");
const sliderDiv = document.getElementById("formatSlider");
const thumb = sliderDiv?.querySelector("div");
const tableColumns = document.querySelectorAll(".sort-column");
const itemIcons = document.querySelectorAll(".icon-item");
const itemIconPopup = document.querySelector(".icon-pop-up");
window.itemsPerPage = window.authUser?.itemsPerPage || 20;
window.columnsToShow = window.authUser?.columnsToShow || ['rarity', 'element', 'path', 'faction'];
const allColumns = ['rarity', 'element', 'path', 'faction', 'atk', 'hp', 'def', 'speed'];
// Pre-process item data for faster filtering
const itemData = Array.from(itemElements).map(item => {
    const name = item.dataset.name?.toLowerCase() || '';
    return {
        element: item.dataset.element,
        path: item.dataset.path,
        rarity: item.dataset.rarity,
        name: name,
        nameWords: name.split(" "),
        domElements: document.querySelectorAll(`tr[data-id="${item.dataset.id}"], div[data-id="${item.dataset.id}"]`)
    };
});

// Initialize slider variables
let isRight = false;

// Initialize sorting variable
let sortSystem = {
    "num": ["id", "rarity", "atk", "hp", "def"],
    "str": ["item", "element", "path", "faction"]
}

/**
 * Toggles the active state of a filter element and updates the item list
 * @param {HTMLElement} element - The filter element to toggle
 */
export function toggleFilterBackground(element) {
    // Get the div instead of the image
    element.classList.toggle('filter-activated');

    updateItemList();
}

/**
 * Updates the visibility of item elements based on active filters and search text
 * Applies all filtering criteria and updates pagination
 */
export function updateItemList() {
    // Load necessary variables
    const text = searchInput.value.toLowerCase();
    const activatedFilterDivs = document.querySelectorAll('.filter-activated');

    // Get filters
    const activatedFilters = activatedFilterDivs.length > 0 ?
        retrieveFilters(activatedFilterDivs) : { 'element': [], 'path': [], 'rarity': [] };

    // Batch DOM updates
    const hiddenItems = new Set();

    // Filter items
    itemData.forEach((item, index) => {
        // Start assuming visible
        let shouldShow = true;

        // Check all filters
        if ((activatedFilters.path.length > 0 && !activatedFilters.path.includes(item.path)) ||
            (activatedFilters.element.length > 0 && !activatedFilters.element.includes(item.element)) ||
            (activatedFilters.rarity.length > 0 && !activatedFilters.rarity.includes(item.rarity))) {
            shouldShow = false;
        }

        // Check search text (only if still visible)
        if (shouldShow && text) {
            shouldShow = item.nameWords.some(word => word.startsWith(text));
        }

        // Mark for visibility update
        if (!shouldShow) {
            hiddenItems.add(index);
        }
    });

    // Apply all visibility changes
    itemData.forEach((item, index) => {
        const isHidden = hiddenItems.has(index);
        item.domElements.forEach(domElement => {
            domElement.classList.toggle('hidden', isHidden);
        });
    });

    // Update the pagination with the currently visible items
    sortColumns(window.sortOrder || 'id', window.sortDirection || 'desc');
}

/**
 * Extracts filter values from activated filter elements
 * @param {NodeList} filters - Collection of activated filter elements
 * @returns {Object} Object containing arrays of active filters by type
 */
function retrieveFilters(filters) {
    let result = {
        'element': [],
        'path': [],
        'rarity': []
    }

    filters.forEach(filter => {
        result[filter.dataset.type].push(filter.dataset.value);
    })

    return result;
}

/**
 * Clears all active filters and resets item visibility
 * Maintains search filter if search text exists
 */
export function removeAllFilters() {
    const activatedFilterDivs = document.querySelectorAll('.filter-activated');

    activatedFilterDivs.forEach(div => {
        div.classList.remove('filter-activated');
    });

    // Show all items initially
    itemData.forEach(item => {
        item.domElements.forEach(domElement => {
            domElement.classList.remove('hidden');
        })
    });

    // Apply only the search filter if there's text in the search box
    const text = searchInput?.value.toLowerCase();
    if (text) {
        itemData.forEach(item => {
            const matchFound = item.nameWords.some(word => word.startsWith(text));

            if (!matchFound) {
                item.domElements.forEach(domElement => {
                    domElement.classList.add('hidden');
                });
            }
        });
    }

    sortColumns(window.sortOrder || 'id', window.sortDirection || 'desc');
}

/**
 * Toggles between card and table views of item display
 * Updates visibility of respective sections and animates the switch thumb
 */
export function itemFormatSwitch() {
    isRight = !isRight;
    thumb.style.left = isRight ? "50%" : "0";

    // Switch visibility to the list
    document.querySelector(".item-section").classList.toggle("hidden");
    document.querySelector(".item-section-table").classList.toggle("hidden");

    // Switch visibility to the table filter
    document.querySelector(".table-filter-button").classList.toggle("hidden");
}

/**
 * Updates sort icons in table headers based on sort direction
 * @param {string} columnName - The name of the column to sort by
 * @param {string} order - Sort direction ('asc', 'desc', or '' for toggle behavior)
 */
export function rearrangeSortIcons(columnName, order = "") {
    // Get the Desktop Column
    const column = [...tableColumns].find(col => {
        const title = col.querySelector(".th-title");
        return title?.textContent.trim() === columnName;
    });

    const iconDiv = column.querySelector(".sort-icon");
    if (!iconDiv) return;

    const currentSort = iconDiv.textContent;

    // Reset all columns first
    tableColumns.forEach(tableColumn => {
        const sortIcon = tableColumn.querySelector(".sort-icon");
        const title = tableColumn.querySelector(".th-title");

        if (sortIcon) sortIcon.textContent = "";
        if (title) title.classList.add("mx-auto");
    });

    // If there's no order, it was a click event and the sort icons will rearrange in a specific order
    if (order == "") {
        // Set the right icon and fill sort configuration data
        const title = column.querySelector(".th-title");
        if (title && currentSort !== "▼") {
            title.classList.remove("mx-auto");
        }

        switch (currentSort) {
            case "":
                iconDiv.textContent = "▲";
                order = "asc";
                break;
            case "▲":
                iconDiv.textContent = "▼";
                order = "desc";
                break;
            case "▼":
                iconDiv.textContent = "";
                columnName = "ID";
                order = "desc";
                break;
        }
    } else if (columnName != "ID") {
        const title = column.querySelector(".th-title");
        if (title) title.classList.remove("mx-auto");

        iconDiv.textContent = order === "asc" ? "▲" : "▼";
    }

    sortColumns(columnName, order);
}

/**
 * Applies the selected filters and updates the display
 */
export function applyFilters() {
    // Get current options
    const itemsPerPageEl = document.getElementById("items-per-page");
    const columnOrderEl = document.getElementById("column-order");
    const columnDirectionEl = document.getElementById("column-direction");

    if (!itemsPerPageEl || !columnOrderEl || !columnDirectionEl) {
        closeFilterModal();
        return;
    }

    const options = {
        itemsPerPage: itemsPerPageEl.value,
        sortOrder: columnOrderEl.value,
        sorterDirection: columnDirectionEl.value
    };

    // Check if anything changed
    if (
        options.itemsPerPage !== window.itemsPerPage ||
        options.sortOrder !== window.sortOrder ||
        options.sorterDirection !== window.sortDirection
    ) {
        // Update window values
        window.itemsPerPage = options.itemsPerPage;
        window.sortOrder = options.sortOrder;
        window.sorterDirection = options.sorterDirection;

        sortColumns(options.sortOrder, options.sorterDirection);
    }

    // Hide all columns first
    allColumns.forEach(column => {
        document.querySelectorAll(`.data-${column}`).forEach(field => {
            field.classList.add("hidden");
        });
        document.querySelectorAll(`#${column}-column`).forEach(columnElement => {
            columnElement.classList.add("hidden");
        });
    });

    // Get checked columns 
    const columnsToShow = Array.from(document.querySelectorAll('input[name="column"]:checked'))
        .map(input => input.value);

    // Show selected columns
    columnsToShow.forEach(column => {
        document.querySelectorAll(`.data-${column}`).forEach(field => {
            field.classList.remove("hidden");
        });
        document.querySelectorAll(`#${column}-column`).forEach(columnElement => {
            columnElement.classList.remove("hidden");
        });
    });

    // Save user preference if logged in and if values are different
    if (window.authUser) {
        const preferencesChanged =
            options.itemsPerPage != window.authUser.itemsPerPage ||
            !arraysEqual(columnsToShow, window.authUser.columnsToShow);

        if (preferencesChanged) {
            // Update user preferences
            window.authUser.itemsPerPage = options.itemsPerPage;
            window.authUser.columnsToShow = columnsToShow;

            updateUserPreferences(options.itemsPerPage, columnsToShow);

        }
    }

    // Close the filter modal when done
    closeFilterModal();
}

/**
 * Helper function to compare arrays
 */
function arraysEqual(a, b) {
    if (!a || !b) return false;
    if (a.length !== b.length) return false;

    for (let i = 0; i < a.length; i++) {
        if (a[i] !== b[i]) return false;
    }

    return true;
}

/**
 * Makes an AJAX call to apply user preferences to the server
 * @param {number} itemsPerPage - The number of items to display per page
 * @param {Array<string>} columnsToShow - A list of columns to be displayed by default, represented as an array of column identifiers
 */
function updateUserPreferences(itemsPerPage, columnsToShow) {
    const data = {
        itemsPerPage: itemsPerPage,
        columnsToShow: columnsToShow
    }

    fetch('/api/user/update', {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                newNotification("success", "User preferences updated successfully.");
            } else {
                newNotification("error", 'Update failed: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            newNotification("error", "Error saving user preferences.");
            console.error(error)
        });
}

/**
 * Sorts table elements by the specified column and order
 * @param {string} columnName - The column to sort by
 * @param {string} order - Sort direction ('asc' or 'desc')
 */
export function sortColumns(columnName, order) {
    columnName = columnName || 'id';
    order = order || 'desc';

    // Change column name if it's either Character or Lightcone
    if (columnName == "Character" || columnName == "Lightcone") {
        columnName = "item"
    }

    // Update global variables
    window.sortOrder = columnName;
    window.sortDirection = order;

    // Determine sort type and selector attribute
    const sortType = getSortType(columnName);
    const columnSelector = `data-${columnName.toLowerCase()}`;

    // Sort desktop table rows
    sortElements({
        items: ".sparkle-table tbody tr:not(.hidden)",
        container: ".sparkle-table tbody",
        valueSelector: `td.${columnSelector}`,
        extractValue: element => element.textContent.trim(),
        sortType,
        order
    });

    // Sort mobile cards
    sortElements({
        items: ".mobile-item-table div.item:not(.hidden)",
        container: ".mobile-item-table",
        valueSelector: `div.${columnSelector}`,
        // Extract only the value part (text not inside spans)
        extractValue: element => {
            // Get all text nodes that are direct children of the element
            const textNodes = Array.from(element.childNodes)
                .filter(node => node.nodeType === Node.TEXT_NODE)
                .map(node => node.textContent.trim())
                .filter(text => text !== '');

            // Join and trim in case there are multiple text nodes
            return textNodes.join(' ').trim();
        },
        sortType,
        order
    });

    // Update pagination after the order is fixed
    updatePagination();
}

/**
 * Sorts DOM elements based on their content
 * @param {Object} config - Configuration object
 */
function sortElements({ items, container, valueSelector, extractValue, sortType, order }) {
    const elements = Array.from(document.querySelectorAll(items));
    const containerEl = document.querySelector(container);

    if (!containerEl || elements.length === 0) return;

    elements.sort((a, b) => {
        const elementA = a.querySelector(valueSelector);
        const elementB = b.querySelector(valueSelector);

        if (!elementA || !elementB) return 0;

        const valueA = extractValue(elementA);
        const valueB = extractValue(elementB);

        return compareValues(valueA, valueB, sortType, order);
    });

    const fragment = document.createDocumentFragment();
    elements.forEach(item => fragment.appendChild(item));
    containerEl.appendChild(fragment);
}

/**
 * Compares two values based on sort type and order
 * @param {string} valueA - First value to compare
 * @param {string} valueB - Second value to compare
 * @param {string} sortType - Type of sort ('str' or 'num')
 * @param {string} order - Sort direction ('asc' or 'desc')
 * @returns {number} - Comparison result
 */
function compareValues(valueA, valueB, sortType, order) {
    const isAscending = order === "asc";

    if (sortType === "str") {
        return isAscending ? valueA.localeCompare(valueB) : valueB.localeCompare(valueA);
    } else {
        const numA = parseFloat(valueA);
        const numB = parseFloat(valueB);

        // Handle NaN cases
        if (isNaN(numA) && isNaN(numB)) return 0;
        if (isNaN(numA)) return isAscending ? 1 : -1;
        if (isNaN(numB)) return isAscending ? -1 : 1;

        return isAscending ? numA - numB : numB - numA;
    }
}

/**
 * Determines sort type based on column name
 * @param {string} label - Column name
 * @returns {string} - Sort type ('num', 'str', or 'num' as default)
 */
function getSortType(label) {
    if (sortSystem.num.includes(label.toLowerCase())) return "num";
    if (sortSystem.str.includes(label.toLowerCase())) return "str";
    return "num";
}

/**
 * Updates pagination based on current filters and sort order
 */
function updatePagination() {
    const itemsPerPage = window.itemsPerPage || 20;
    const desktopItems = Array.from(document.querySelectorAll(".sparkle-table tbody tr:not(.hidden)"));
    const mobileItems = Array.from(document.querySelectorAll(".mobile-item-table div.item:not(.hidden)"));

    const desktopTable = document.querySelector(".sparkle-table");
    const mobileContainer = document.querySelector(".mobile-item-table");

    if (!desktopTable || !mobileContainer) return;

    const totalItems = desktopItems.length;
    const numberOfPages = Math.max(1, Math.ceil(totalItems / itemsPerPage))

    // Clear old pagination and handle hidden items
    clearAndRebuildPagination(mobileContainer, mobileItems, desktopTable, desktopItems, numberOfPages, itemsPerPage);

    // Build pagination buttons
    buildPaginationButtons(numberOfPages);
}

/**
 * Clears existing pagination and rebuilds it
 */
function clearAndRebuildPagination(mobileContainer, mobileItems, desktopTable, desktopItems, numberOfPages, itemsPerPage) {
    // MOBILE: Handle hidden items
    const hiddenDivContainer = document.createElement("div");
    const hiddenDivRows = document.querySelectorAll(".mobile-item-table div.item.hidden");
    hiddenDivContainer.append(...hiddenDivRows);

    // Clear all pagination rows
    mobileContainer.querySelectorAll(".pagination")?.forEach(page => page.remove());

    // DESKTOP: Handle hidden items
    const hiddenTBodyContainer = document.createElement("tbody");
    hiddenTBodyContainer.classList.add("hidden-items-container");
    const hiddenTableRows = document.querySelectorAll(".sparkle-table tbody tr.hidden");
    hiddenTBodyContainer.append(...hiddenTableRows);

    // Clear all pagination rows
    document.querySelectorAll(".sparkle-table .pagination").forEach(page => page.remove());

    // Build mobile pagination
    const mobilePages = [];
    for (let i = 0; i < numberOfPages; i++) {
        const pageDiv = document.createElement("div");
        pageDiv.classList.add("pagination");
        if (i !== 0) pageDiv.classList.add("hidden");
        pageDiv.id = `mobile-page-${i}`;

        const pageItems = mobileItems.slice(i * itemsPerPage, (i + 1) * itemsPerPage);
        pageItems.forEach(item => pageDiv.appendChild(item));

        mobilePages.push(pageDiv);
    }

    // Append all pages at once
    const mobileFrag = document.createDocumentFragment();
    mobilePages.forEach(page => mobileFrag.appendChild(page));
    mobileContainer.appendChild(mobileFrag);
    mobileContainer.appendChild(hiddenDivContainer);

    // Build desktop pagination
    const desktopPages = [];
    for (let i = 0; i < numberOfPages; i++) {
        const pageTbody = document.createElement("tbody");
        pageTbody.classList.add("pagination");
        if (i !== 0) pageTbody.classList.add("hidden");
        pageTbody.id = `desktop-page-${i}`;

        const pageItems = desktopItems.slice(i * itemsPerPage, (i + 1) * itemsPerPage);
        pageItems.forEach(row => pageTbody.appendChild(row));

        desktopPages.push(pageTbody);
    }

    // Replace existing tbody or append new ones
    const existingTbody = desktopTable.querySelector("tbody:not(.hidden-items-container)");
    if (existingTbody) {
        existingTbody.replaceWith(...desktopPages);
    } else {
        const desktopFrag = document.createDocumentFragment();
        desktopPages.forEach(page => desktopFrag.appendChild(page));
        desktopTable.appendChild(desktopFrag);
    }

    // Append hidden rows container
    const existingHiddenContainer = desktopTable.querySelector(".hidden-items-container");
    if (existingHiddenContainer) {
        existingHiddenContainer.replaceWith(hiddenTBodyContainer);
    } else {
        desktopTable.appendChild(hiddenTBodyContainer);
    }
}

/**
 * Creates pagination buttons based on the total number of pages
 * @param {number} numberOfPages - Total number of pages to generate buttons for
 */
function buildPaginationButtons(numberOfPages) {
    const navContainer = document.querySelector(".pagination-nav");
    if (!navContainer) return;

    // Clear previous buttons
    navContainer.innerHTML = "";

    const fragment = document.createDocumentFragment();

    for (let i = 0; i < numberOfPages; i++) {
        const btn = document.createElement("button");
        btn.textContent = i + 1;
        btn.classList.add("pagination-btn", "px-3", "py-1", "border", "mx-1", "rounded", "bg-crimson");

        if (i === 0) {
            btn.classList.add("item-active");
            btn.classList.remove("bg-crimson");
        }

        btn.addEventListener("click", () => {
            showPage(i);
            document.querySelectorAll(".pagination-btn").forEach(b => {
                b.classList.remove("item-active");
                b.classList.add("bg-crimson");
            });

            btn.classList.add("item-active");
            btn.classList.remove("bg-crimson");
        });

        fragment.appendChild(btn);
    }

    navContainer.appendChild(fragment);
}

/**
 * Displays the specified page of content and updates active page state
 * @param {number} pageNumber - The page number to display (1-based index)
 */
function showPage(pageNumber) {
    // Reset the visiblity of the pagination
    document.querySelectorAll(".pagination").forEach(page => {
        page.classList.add("hidden");
    })

    // Make only the correct page visible for both mobile and desktop versions
    const desktopPage = document.getElementById(`desktop-page-${pageNumber}`);
    const mobilePage = document.getElementById(`mobile-page-${pageNumber}`);

    if (desktopPage) desktopPage.classList.remove("hidden");
    if (mobilePage) mobilePage.classList.remove("hidden");
}

/**
 * Hide columns based on user data on launch
 */
export function hideAdditionalColumns() {
    const columnsToHide = allColumns.filter(column => !window.columnsToShow.includes(column));

    columnsToHide.forEach(column => {
        document.querySelectorAll(`.data-${column}`).forEach(field => {
            field.classList.add("hidden");
        });
        document.querySelectorAll(`#${column}-column`).forEach(columnEl => {
            columnEl.classList.add("hidden");
        });
    });
}

/**
 * Main setup for the item page (filters, sorting, pagination, etc.)
 */
function initializeItemPage() {
    try {
        // Add filter functionality
        const filterElements = document.querySelectorAll(".element-filter, .path-filter, .rarity-filter");
        filterElements?.forEach(filterElement => {
            filterElement.addEventListener("click", function (event) {
                toggleFilterBackground(event.currentTarget);
            });
        });

        // Add remove all filters functionality
        document.getElementById("remove-filter")?.addEventListener("click", function () {
            removeAllFilters();
        });

        // Add search functionality with debouncing
        let debounceTimeout;
        document.getElementById("search")?.addEventListener("input", function () {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(updateItemList, 200);
        });

        // Add format switch functionality
        document.getElementById("formatSlider")?.addEventListener("click", () => {
            itemFormatSwitch();
        });

        // Add sorting functionality
        document.querySelectorAll(".sort-column")?.forEach(column => {
            column.addEventListener("click", function (event) {
                rearrangeSortIcons(event.currentTarget.querySelector(".th-title")?.textContent.trim());
            })
        })

        // Initialize default sorting
        window.sortOrder = "ID";
        window.sortDirection = "desc"
        sortColumns("ID", "desc");

        // Hide columns based on user preferences
        hideAdditionalColumns();

        // Open a pop-up window if mouse hovers over the item icons
        let hideTimeout;
        itemIcons.forEach(icon => {
            icon.addEventListener('mouseenter', () => {
                clearTimeout(hideTimeout);
                updatePopupContent(icon, itemIconPopup);
                positionPopup(icon, itemIconPopup);
                itemIconPopup.classList.remove("hidden");
            })

            icon.addEventListener("mouseleave", () => {
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

        // Set up the apply filters button
        const applyButton = document.getElementById('apply-filters-btn');
        if (applyButton) {
            applyButton.addEventListener('click', applyFilters);
        }

    } catch (error) {
        console.error('Failed to initialize item page:', error);
    }
}

// Initialize when DOM is ready or immediately if already loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeItemPage);
} else {
    initializeItemPage();
}