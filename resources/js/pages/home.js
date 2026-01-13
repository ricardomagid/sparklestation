import Chart from 'chart.js/auto';

const chartElements = document.querySelectorAll('.pie-chart');
const nextPatchElement = document.querySelector("#nextPatch");

const defaultColors = [
    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
    '#9966FF', '#FF5733', '#6DBE45', '#FFC300'
];

/**
 * Creates a reusable external tooltip element
 * @returns {HTMLDivElement}
 */
function createTooltipElement() {
    const el = document.createElement('div');
    Object.assign(el.style, {
        opacity: 0,
        position: 'absolute',
        background: 'rgba(0,0,0,0.7)',
        color: 'white',
        borderRadius: '3px',
        padding: '0px',
        pointerEvents: 'none',
        transform: 'translate(-50%, 0)',
        zIndex: '1000'
    });
    document.body.appendChild(el);
    return el;
}

/**
 * Formats a countdown based on target date
 * @param {Date} targetDate
 * @returns {string}
 */
function formatCountdown(targetDate) {
    const diff = targetDate - new Date();
    if (diff <= 0) {
        return "Update is live!";
    }

    const seconds = Math.floor(diff / 1000) % 60;
    const minutes = Math.floor(diff / (1000 * 60)) % 60;
    const hours = Math.floor(diff / (1000 * 60 * 60)) % 24;
    const days = Math.floor(diff / (1000 * 60 * 60 * 24));

    return `${days} days ${hours} hours ${minutes} minutes ${seconds} seconds`;
}

/**
 * Sets up a countdown timer on a DOM element
 * @param {HTMLElement} element
 * @param {Date} targetDate
 */
function setupCountdown(element, targetDate) {
    setInterval(() => {
        element.textContent = formatCountdown(targetDate);
    }, 1000);
}

/**
 * Initializes all charts on the page
 * @param {NodeList} chartElements
 * @param {Object} chartConfigs
 * @param {Array} defaultColors
 */
function initCharts(chartElements, chartConfigs, defaultColors) {
    const tooltipEl = createTooltipElement();

    chartElements.forEach((element, index) => {
        const chartName = Object.keys(chartConfigs)[index];
        const chartConfig = chartConfigs[chartName];
        const ctx = element.getContext('2d');
        const colors = chartConfig.colors || defaultColors;

        // Determine tooltip config
        const tooltipConfig = chartConfig.defaultToolbar ? {
            enabled: true,
            callbacks: {
                label: ctx => {
                    const label = ctx.label || '';
                    const value = ctx.raw || 0;
                    const total = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                    const percentage = Math.round((value / total) * 100);
                    return `${label}: ${value} (${percentage}%)`;
                }
            }
        } : {
            enabled: false,
            external: function (context) {
                const tooltipModel = context.tooltip;
                if (tooltipModel.opacity === 0) { tooltipEl.style.opacity = 0; return; }

                const pos = context.chart.canvas.getBoundingClientRect();
                tooltipEl.style.opacity = 1;
                tooltipEl.style.left = pos.left + window.pageXOffset + tooltipModel.caretX + 'px';
                tooltipEl.style.top = pos.top + window.pageYOffset + tooltipModel.caretY + 'px';

                if (tooltipModel.body) {
                    const idx = context.tooltip.dataPoints[0].dataIndex;
                    const label = chartConfig.labels[idx];
                    const value = chartConfig.data[idx];
                    const image = chartConfig.images?.[idx] || '';
                    const total = chartConfig.data.reduce((a, b) => a + b, 0);
                    const pct = Math.round((value / total) * 100);

                    tooltipEl.innerHTML = `
                        <div style="display:flex; flex-direction:column; align-items:center; text-align:center; font-size:12px">
                            ${image ? `<img src="${image}" alt="${label}" style="width:50px;height:50px;margin-top:5px;">` : ''}
                            <div><strong>${label}</strong>: ${value} (${pct}%)</div>
                        </div>
                    `;
                }
            }
        };

        // Create the chart
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: chartConfig.labels,
                datasets: [{
                    data: chartConfig.data,
                    backgroundColor: colors.slice(0, chartConfig.labels.length),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    title: { display: true, text: chartConfig.title },
                    legend: { position: 'bottom' },
                    tooltip: tooltipConfig
                }
            }
        });
    });
}

let nextPatchDate = new Date(document.querySelector(".patch-duration").textContent);
nextPatchDate.setDate(nextPatchDate.getDate() + 42);

setupCountdown(nextPatchElement, nextPatchDate);
initCharts(chartElements, charts, defaultColors);
