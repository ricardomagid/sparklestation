export class Circle {
    constructor(x, y, size, type, data, title, circleData, sliderData, onClickCallback) {
        this.x = x;
        this.y = y;
        this.size = size;
        this.type = type;
        this.data = data;
        this.title = title;
        this.circleData = circleData;
        this.sliderData = sliderData;
        this.element = null;
        this.onClickCallback = onClickCallback;
    }

create(svgDefs) {
    const patternId = `pattern-${this.data.id}`;
    const radius = this.getRadius();
    const diameter = radius * 2;

    // Create pattern
    const pattern = document.createElementNS('http://www.w3.org/2000/svg', 'pattern');
    pattern.setAttribute('id', patternId);
    pattern.setAttribute('patternUnits', 'userSpaceOnUse');
    pattern.setAttribute('width', diameter);
    pattern.setAttribute('height', diameter);
    pattern.setAttribute('x', this.x - radius);
    pattern.setAttribute('y', this.y - radius);

    // Create image inside pattern
    const image = document.createElementNS('http://www.w3.org/2000/svg', 'image');
    image.setAttributeNS('http://www.w3.org/1999/xlink', 'href', this.circleData[0].image);
    image.setAttribute('width', diameter);
    image.setAttribute('height', diameter);
    image.setAttribute('x', '0');
    image.setAttribute('y', '0');
    image.setAttribute('preserveAspectRatio', 'xMidYMid slice');

    // Add error handling for image loading
    image.addEventListener('error', (e) => {
        console.error('Image failed to load:', this.circleData[0].image, e);
    });

    pattern.appendChild(image);
    svgDefs.appendChild(pattern);

    // Create circle
    this.element = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
    this.element.setAttribute('cx', this.x);
    this.element.setAttribute('cy', this.y);
    this.element.setAttribute('r', radius);
    this.element.setAttribute('fill', `url(#${patternId})`);
    this.element.style.fill = `url(#${patternId}) !important`;
    this.element.setAttribute('stroke', '#333');
    this.element.setAttribute('stroke-width', '1');
    this.element.classList.add('trace-circle', `trace-circle--${this.size}`, 'trace-circle--pattern');

    this.element.style.transformOrigin = `${this.x}px ${this.y}px`;

    this.element.addEventListener("click", this.handleClick.bind(this));

    return this.element;
}

    getRadius() {
        const sizes = { small: 13, medium: 17, large: 20 }

        return sizes[this.size]
    }

    handleClick(event) {
        // Toggle clicked state
        const isCurrentlyClicked = this.element.classList.contains("clicked");

        if (!isCurrentlyClicked) {
            this.element.classList.add("clicked");
        } else {
            this.element.classList.remove("clicked");
        }

        // Call the callback with the new state
        if (this.onClickCallback) {
            this.onClickCallback(this, !isCurrentlyClicked);
        }
    }
}