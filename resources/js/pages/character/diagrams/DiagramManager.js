import { Circle } from './Circle.js';

export class DiagramManager {
    constructor(container, pathName, characterName) {
        this.container = container;
        this.pathName = pathName;
        this.characterName = characterName;
        this.config = null;
        this.svg = null;
        this.circles = [];
        this.characterData = window.characterData;
    }

    async init() {
        const configModule = await import(`./configs/${this.pathName}-config.js`);
        this.config = configModule.default

        this.createSVG();
        this.setBackgroundImage();
        this.createCircles();
    }

    createSVG() {
        this.svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        this.svg.setAttribute('viewBox', `0 0 ${this.config.width} ${this.config.height}`);
        this.svg.setAttribute('preserveAspectRatio', 'xMidYMid meet');
        this.svg.classList.add('diagram-svg');
        this.container.appendChild(this.svg);

        if (!this.svg.querySelector('defs')) {
            const defs = document.createElementNS('http://www.w3.org/2000/svg', 'defs');
            this.svg.appendChild(defs);
        }

        /*         
        // needed for future paths
        this.svg.addEventListener('click', (e) => {
            const pt = this.svg.createSVGPoint();
            pt.x = e.clientX;
            pt.y = e.clientY;

            // Transform to SVG coordinates
            const svgP = pt.matrixTransform(this.svg.getScreenCTM().inverse());

            console.log(`Clicked at X: ${svgP.x}, Y: ${svgP.y}`);
            navigator.clipboard.writeText(`x: ${Math.round(parseFloat(svgP.x))}, y: ${Math.round(parseFloat(svgP.y))}`)
        }); 
        */
    }

    setBackgroundImage() {
        document.querySelector("#traceDiagramBackground").style.backgroundImage = `url('/images/paths/${this.config.backgroundImage}')`;
    }

    createCircles() {
        let mainTraceCounter = 1;

        this.config.circles.forEach(circleConfig => {
            let circleTitle = '';
            let circleTraceData = [];
            let circleSliderData = { visibility: false };
            let materials = characterData.traceMaterials[circleConfig.data.name] ?? [];
            const sliderHiddenFor = ['Technique']

            switch (circleConfig.type) {
                case 'ability': {
                    const abilities = this.characterData.groupedAbilities[circleConfig.data.name] || [];

                    circleTitle = circleConfig.data.name; // "Basic ATK", "Skill", etc
                    const isBasicAtkOrMemosprite = circleTitle === "Basic ATK" || circleTitle.includes("Memosprite");
                    const maxSliderLevel = isBasicAtkOrMemosprite ? 10 : 15;
                    
                    if (!sliderHiddenFor.some(ability => circleTitle === ability)) {
                        circleSliderData = { visibility: true, maxSliderLevel };
                    }
                    const circleImageSkill = circleTitle.toLowerCase() === 'basic atk' ? 'basic' : circleTitle.toLowerCase().replace(/\s+/g, '-');;
                    const baseImagePath = `/images/abilities/${this.characterName}-${circleImageSkill}.webp`;

                    abilities.forEach(ability => {
                        circleTraceData.push({
                            name: ability?.name || circleTitle,
                            description: ability?.description || '',
                            values: ability?.base_numbers || [],
                            id: ability?.id || null,
                            materials: [],
                            image: baseImagePath
                        });
                    });
                    break;
                }

                case 'mainTrace': {
                    const trace = this.getTrace(circleConfig.data.name);
                    circleTitle = "Bonus Ability";

                    if (trace) {
                        const name = trace?.name || 'Unknown Trace';
                        const description = trace?.description || '';
                        const padded = String(mainTraceCounter).padStart(2, '0');
                        const image = `/images/traces/${this.characterName}-${padded}.webp`;

                        circleTraceData.push({
                            name,
                            description,
                            image,
                            values: [],
                            id: null,
                            materials: materials
                        });
                    }
                    mainTraceCounter++;
                    break;
                }

                default: {
                    const trace = this.getTrace(circleConfig.data.name);

                    if (trace) {
                        circleTitle = "Trace";

                        const name = trace?.name || 'Unknown Trace';
                        const description = trace?.description || '';
                        const image = `/images/traces/${this.getMinorTraceImage(name)}`;

                        circleTraceData.push({
                            name,
                            description,
                            image,
                            values: [],
                            id: null,
                            materials: materials
                        });
                    }
                    break;
                }
            }

            if (circleTraceData.length != 0) {
                const circle = new Circle(
                    circleConfig.x,
                    circleConfig.y,
                    circleConfig.size,
                    circleConfig.type,
                    circleConfig.data,
                    circleTitle,
                    circleTraceData,
                    circleSliderData,
                    this.handleCircleClick.bind(this)
                );

                // Create the SVG element and add it to the SVG
                const defs = this.svg.querySelector('defs');
                const circleElement = circle.create(defs);
                this.svg.appendChild(circleElement);

                // Store reference for later use
                this.circles.push(circle);
            }
        });
    }

    getTrace(name) {
        const position = parseInt(name.replace('trace', ''));
        return this.characterData.traces.find(t => t.position === position);
    }

    getMinorTraceImage(circleName) {
        switch (true) {
            case circleName.includes("HP"):
                return "global-hp.webp";
            case circleName.includes("ATK"):
                return "global-atk.webp";
            case circleName.includes("DEF"):
                return "global-def.webp";
            case circleName.includes("RES"):
                return "global-res.webp";
            case circleName.includes("Effect"):
                return "global-effect.webp";
            case circleName.includes("Rate"):
                return "global-cr.webp";
            case circleName.includes("CRIT DMG"):
                return "global-cd.webp";
            case circleName.includes("Break"):
                return "global-break.webp";
            case circleName.includes("SPD"):
                return "global-spd.webp";
            case circleName.includes("Fire"):
                return "global-fire.webp";
            case circleName.includes("Quantum"):
                return "global-quantum.webp";
            case circleName.includes("Imaginary"):
                return "global-imaginary.webp";
            case circleName.includes("Ice"):
                return "global-ice.webp";
            case circleName.includes("Lightning"):
                return "global-lightning.webp";
            case circleName.includes("Physical"):
                return "global-physical.webp";
            case circleName.includes("Wind"):
                return "global-wind.webp";
        }
    }

    handleCircleClick(circle, isClicked) {
        // Clear other clicked circles 
        this.circles.forEach(c => {
            if (c !== circle) {
                c.element.classList.remove("clicked");
            }
        });

        // Handle side panel logic
        const container = document.querySelector("#traceDiagram");
        const traceDiv = document.querySelector("#traceDiagramBackground").parentElement;

        if (isClicked) {
            // Show side panel with circle data
            this.showSidePanel(circle);
            container?.classList.remove("mx-auto");
            container?.classList.add("smooth-transition");
            traceDiv.classList.remove("self-center");
            traceDiv.classList.add("self-start", "smooth-transition");
        } else {
            // Hide side panel
            this.hideSidePanel();
            container?.classList.add("mx-auto");
            container?.classList.add("smooth-transition");

            traceDiv.classList.remove("self-start");
            traceDiv.classList.add("self-center", "smooth-transition");
        }
    }

    showSidePanel(circle) {
        const sidePanel = document.querySelector("#sidePanel");
        if (sidePanel) {
            sidePanel.classList.remove("hidden");
            sidePanel.classList.remove("animate-fadeOut");
            sidePanel.classList.add("animate-slideIn");
            sidePanel.querySelector("#circleTitle").textContent = circle.title;
            // Clear old data
            const traceContainer = sidePanel.querySelector("#circleTraces");
            traceContainer.innerHTML = "";
            sidePanel.querySelector(".ability-slider-number").textContent = 1;
            sidePanel.querySelector(".trace-slider").value = 1;

            // Add new data
            circle.circleData.forEach(({ name, description, image, values, id, materials }) => {
                const abilityBlock = document.createElement("div");
                abilityBlock.className = "bg-red-950/50 border border-red-800 p-3 rounded-lg";
                const baseNumbersAttr = values ? `data-base-numbers='${JSON.stringify(values)}'` : '';
                const abilityIDAttr = id ? `data-ability-id='${id}'` : '';

                abilityBlock.innerHTML = `
                    <div class="flex flex-col items-center">
                        <p class="text-red-200 font-medium mb-1">${name}</p>
                        <img src="${image}" alt="${name}" class="w-10 h-10 mb-2">
                    </div>
                    <p class="text-red-300 text-sm leading-relaxed ability-description" ${baseNumbersAttr} ${abilityIDAttr}>${description}</p>
                    `;

                traceContainer.appendChild(abilityBlock);

                // Add materials
                const materialContainer = sidePanel.querySelector("#traceMaterialsPanel");
                const materialsHTML = materials.map(mat => `
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full bg-[#FFE0E0] p-1 flex items-center justify-center">
                            <img src="${mat.material.image_url}" alt="${mat.material.name}" class="w-10 h-10 object-contain">
                        </div>
                        <span class="text-white text-xs mt-1 text-center break-words max-w-[4rem]">${mat.material.name}</span>
                        <span class="text-yellow-200 text-xs font-bold">×${mat.quantity}</span>
                    </div>
                `).join('');

                materialContainer.innerHTML = `
                    <div class="grid grid-cols-2 gap-4 justify-items-center">
                        ${materialsHTML}
                    </div>
                `;

                if (circle.sliderData.visibility) {
                    sidePanel.querySelector("#circleSlider").classList.remove("hidden")
                    sidePanel.querySelector(".ability-slider").setAttribute("max", circle.sliderData.maxSliderLevel);
                } else {
                    sidePanel.querySelector("#circleSlider").classList.add("hidden");
                }
            })
        }
    }

    hideSidePanel() {
        const sidePanel = document.querySelector("#sidePanel");
        if (sidePanel) {
            sidePanel.classList.remove("animate-slideIn");
            sidePanel.classList.add("animate-fadeOut");

            setTimeout(() => {
                sidePanel.classList.add("hidden");
                sidePanel.classList.remove("animate-fadeOut");
            }, 300);
        }
    }
}