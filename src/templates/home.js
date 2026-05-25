let isBackgroundDrawn = false;

function heroSize() {
    const hero = document.querySelector("section.hero");
    return hero
        ? { w: hero.offsetWidth, h: hero.offsetHeight }
        : { w: windowWidth, h: windowHeight };
}

function setup() {
    const { w, h } = heroSize();
    let c = createCanvas(w, h, WEBGL);
    c.id("main");

    const hero = document.querySelector("section.hero");
    if (hero) hero.appendChild(c.elt);

    let el = document.getElementById("main");
    el.style.position = "absolute";
    el.style.top      = "0";
    el.style.left     = "0";
    el.style.zIndex   = "-1";

    angleMode(DEGREES);
    brush.load();
    brush.scaleBrushes(3.5);

    brush.add("watercolor", {
        type:    "custom",
        weight:  10,
        scatter: 1.05,
        opacity: 9,
        spacing: 0.3,
        pressure: [0.8, 1.3],
        rotate:  "natural",
        tip: (_m) => {
            _m.fill(0, 200);
            _m.rect(-20, -20, 50, 50);
            _m.rect(25, 25, 20, 20);
        },
    });

    background("#fffceb");
    frameRate(30);
}

function windowResized() {
    const { w, h } = heroSize();
    resizeCanvas(w, h);
    isBackgroundDrawn = false;
}

function draw() {
    translate(-width / 2, -height / 2);

    if (!isBackgroundDrawn) {
        background("#fffceb");
        isBackgroundDrawn = true;
    }

    const colores = ["#2c695a", "#4ad6af", "#7facc6", "#4e93cc", "#f6684f", "#ffd300"];
    const brushes = ["marker", "watercolor", "spray", "charcoal", "HB", "2B", "cpencil", "2H", "rotring"];

    brush.field("seabed");
    brush.set(random(brushes), random(colores), random(0.7, 1.6));
    brush.flowLine(random(width), random(height), random(140, 240), random(360));
}

function mouseClicked() {
    noLoop();
}

document.addEventListener("visibilitychange", () => {
    if (document.hidden) {
        noLoop();
    } else {
        loop();
    }
});

window.setup         = setup;
window.draw          = draw;
window.mouseClicked  = mouseClicked;
window.windowResized = windowResized;
