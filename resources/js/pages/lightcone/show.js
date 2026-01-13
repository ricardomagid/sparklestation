import { updateEnemySlider, hideStatsPanel } from '../../utils.js';

/**
 * Truncates story text in a container and adds "show more / show less" toggles
 * @param {HTMLElement} textDiv - The container holding the story text
 * @param {number} [maxLength=200] - Maximum characters to show before truncation
 */
function limitStoryText(textDiv, maxChars = 200) {
    const fullHTML = textDiv.innerHTML;
    const fullText = textDiv.textContent;

    if (fullText.length <= maxChars) return;

    // Simple truncation while preserving some HTML
    const truncated = fullText.substring(0, maxChars).replace(/\s+\S*$/, '');

    textDiv.innerHTML = `
        <span class="preview">${truncated}... <span class="show-more" style="color: blue; cursor: pointer;">Show More</span></span>
        <span class="full hidden">${fullHTML} <span class="show-less" style="color: blue; cursor: pointer;">Show Less</span></span>
    `;

    textDiv.querySelector('.show-more').onclick = () => {
        textDiv.querySelector('.preview').classList.add('hidden');
        textDiv.querySelector('.full').classList.remove('hidden');
    };

    textDiv.querySelector('.show-less').onclick = () => {
        textDiv.querySelector('.full').classList.add('hidden');
        textDiv.querySelector('.preview').classList.remove('hidden');
    };
}

/**
 * Updates light cone skill display when the slider changes
 * Syncs slider values, level numbers and recalculates ability numbers in the description
 *
 * @param {HTMLInputElement} slider - The skill level slider element
 */
function updateLightconeSkill(slider) {
    const levelSelected = parseInt(slider.value, 10);

    // Update the number and input value on both layouts
    document.querySelectorAll(".skill-slider-number").forEach(el => {
        el.textContent = levelSelected;
    });
    document.querySelectorAll(".skill-slider").forEach(el => {
        el.value = slider.value
    })

    // Update the description
    const descriptionElement = document.querySelector(".skill-description");
    const baseNumbers = JSON.parse(descriptionElement.dataset.baseNumbers);
    skillValues.forEach(value => {
        let pos = value['position'] - 1
        // Grab the base value (level 1) at the right position from the array of all numbers
        let baseValue = parseInt(baseNumbers[pos], 10);
        let newValue = baseValue + (value["difference"] * (levelSelected - 1));
        // Update the number on the description div in both layouts
        let displayValue = Number.isInteger(newValue) ? newValue : newValue.toFixed(2);

        document.querySelectorAll(".skill-description").forEach(description => {
            description.querySelectorAll(".ability-number")[pos].textContent = displayValue;
        })
    });
}

/**
 * Main setup for the lightcone page
 */
export default function initializeLightconePage() {
    try {
        if (initializeLightconePage._done) return;
        initializeLightconePage._done = true;

        // Add slider functionality for the enemy mats
        document.querySelectorAll('.stat-slider-input')?.forEach(statSlider => {
            if (statSlider) {
                statSlider.addEventListener('input', function () {
                    updateEnemySlider(this.value);
                });
            }
        });

        // Add slider functionality for the lightcone skill
        document.querySelectorAll(".skill-slider").forEach(slider => {
            slider.addEventListener("input", function () {
                updateLightconeSkill(this)
            })
        })

        // Initialize story text limiting
        const storyText = document.querySelectorAll('.story-text');
        if (storyText.length > 0) {
            storyText.forEach(element => {
                limitStoryText(element)
            })
        }

        // Add click event listener for lightcone stats toggle
        const lcStatsButton = document.querySelector("#lcStatsButton");
        if (lcStatsButton) {
            lcStatsButton.addEventListener("click", function (event) {
                hideStatsPanel();
                event.target.classList.toggle("active");
            })
        }
    } catch (error) {
        console.error('Error initializing lightcone page:', error);
    }
}