const MODAL = document.getElementById("uniqueBuffsCyreneModal");
const selectors = document.querySelectorAll(".selector");
const cards = document.querySelectorAll(".unique-buff-card");
const card_titles = document.querySelectorAll(".buff-title");
const card_descriptions = document.querySelectorAll(".buff-description");

const verticalPadding = 0.1

function getVerticalPos() {
  const { height } = getModalDims();
  const usableHeight = height * (1 - verticalPadding * 2);
  return height * verticalPadding + usableHeight / 2;
}

function getHorizontalPositions() {
  const { width } = getModalDims();
  const columnWidth = width / 5;

  return [
    0.5 * columnWidth,
    1.5 * columnWidth,
    2.5 * columnWidth,
    3.5 * columnWidth,
    4.5 * columnWidth
  ];
}

function getModalDims() {
  return {
    width: MODAL.clientWidth,
    height: MODAL.clientHeight
  };
}

function layoutSelectors() {
    const modal = document.getElementById("uniqueBuffsCyreneModal");
    const selectors = modal.querySelectorAll('.selector');
    if (!selectors.length) return;

    const columns = [
        { x: 10, indices: [0, 1, 2, 3] },
        { x: 18, indices: [4, 5, 6] },
        { x: 82, indices: [7, 8, 9] },
        { x: 90, indices: [10, 11, 12, 13] }
    ];

    columns.forEach(col => {
        const count = col.indices.length;
        
        col.indices.forEach((selectorIdx, i) => {
            const el = selectors[selectorIdx];
            if (!el) return;

            const spacing = 18;
            const totalHeight = (count - 1) * spacing;
            const startY = 50 - (totalHeight / 2);
            const yPos = startY + (i * spacing);

            el.style.left = `${col.x}%`;
            el.style.top = `${yPos}%`;
        });
    });
}

const resizeObserver = new ResizeObserver(() => {
    layoutSelectors();
});

window.addEventListener('load', () => {
    const modal = document.getElementById("uniqueBuffsCyreneModal");
    resizeObserver.observe(modal);
    layoutSelectors();
});

// Change card when clicked
selectors.forEach((selector,index) => {
    selector.addEventListener("click", () => {
        selectors.forEach(s => s.classList.remove("selected"));
        cards.forEach(c => c.style.display = "none");
        card_titles.forEach(c => c.style.display = "none");
        card_descriptions.forEach(c => c.style.display = "none");

        selector.classList.add("selected");
        cards[index].style.display = "block";
        card_titles[index].style.display = "block";
        card_descriptions[index].style.display = "block";
    })
})