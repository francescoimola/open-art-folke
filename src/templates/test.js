/**************************************************
 * The Poetry Clouds by Kyle Geske (stungeye.com) *
 **************************************************/

// Defines the size of the text grid in pixels.
const cloudPixelScale = 7;

// Character spacing multiplier (1 = normal grid, increase for wider spacing)
const charSpacingMultiplier = 0.85;

// Line spacing multiplier (1 = normal grid, increase for taller spacing)
const lineSpacingMultiplier = 1.2;

// Cloud coverage between 0.3 (plentiful) and 0.6 (sparse).
const cloudCutOff = 0.5;

// Speed of cloud panning. Larger values make it faster.
const panSpeed = 16;

// Speed of cloud transformation over time. Larger is faster.
const cloudEvolutionSpeed = 4;

// Mouse-based easing variables
let easedMouseX = 0;
let easedMouseY = 0;
const easingFactor = 0.08; // 0.05-0.15 for subtle easing

// Bloom post-process shader — brightens high-luminance pixels (the white cloud
// text) using an 11×11 blur kernel, then mixes back proportional to pixel
// brightness so the dark sky background stays mostly unaffected.
const bloomFragSrc = `
precision mediump float;

varying vec2 vTexCoord;
uniform sampler2D tex0;
uniform vec2 uResolution;
uniform float uIntensity;

void main() {
  vec2 uv = vTexCoord;
  vec4 color = texture2D(tex0, uv);

  float brightness = (color.r + color.g + color.b) / 3.0;

  float blur = 0.0;
  for (float x = -5.0; x <= 5.0; x++) {
    for (float y = -5.0; y <= 5.0; y++) {
      vec2 offset = vec2(x, y) / uResolution;
      blur += texture2D(tex0, uv + offset).r;
    }
  }
  blur /= 121.0;

  vec4 bloom = vec4(color.rgb + uIntensity * blur, 1.0);
  gl_FragColor = mix(color, bloom, brightness);
}
`;

let bloomShader;

let artistNames = [];
let artistsText = "";
let randomSeed = 0;

// Load artist names immediately
fetch('/artists.json')
  .then(r => r.json())
  .then(data => {
    artistNames = data.artists;
    // Create a long string of all artist names in caps with spaces between them
    artistsText = artistNames.map(name => name.toUpperCase()).join(" ");
    randomSeed = artistsText.length;
  })
  .catch(err => console.error('Failed to load artists:', err));

// Seeded random for consistent but varied results
function seededRandom(seed) {
  const x = Math.sin(seed) * 10000;
  return x - Math.floor(x);
}

function heroSize() {
  const hero = document.querySelector("section.hero");
  return hero
    ? { w: hero.offsetWidth, h: hero.offsetHeight }
    : { w: windowWidth, h: windowHeight };
}

function setup() {
  const { w, h } = heroSize();
  let c = createCanvas(w, h);
  c.id("poetry-clouds");

  const hero = document.querySelector("section.hero");
  if (hero) hero.appendChild(c.elt);

  let el = document.getElementById("poetry-clouds");
  el.style.position = "absolute";
  el.style.top = "0";
  el.style.left = "0";
  el.style.zIndex = "-1";

  bloomShader = createFilterShader(bloomFragSrc);

  // Align text to left so it flows naturally
  textAlign(LEFT, CENTER);
  noStroke();
}

function draw() {
  // Ease mouse position for smooth transitions
  easedMouseX += (mouseX - easedMouseX) * easingFactor;
  easedMouseY += (mouseY - easedMouseY) * easingFactor;
  
  // Calculate normalized mouse influence (-0.5 to 0.5)
  const mouseInfluenceX = (easedMouseX / width) - 0.5;
  const mouseInfluenceY = (easedMouseY / height) - 0.5;
  
  // Apply very subtle influence to cloud evolution (±0.5 at most)
  const evolveModifier = 1 + (mouseInfluenceY * 0.5);
  const panModifier = 1 + (mouseInfluenceX * 0.6);
  const cutoffModifier = cloudCutOff + (mouseInfluenceX * 0.05);

  // A beautiful sky blue background.
  background(19, 142, 192);

  // Nested loop to draw a grid of letters across the canvas.
  const charSpacing = cloudPixelScale * charSpacingMultiplier;
  const lineSpacing = cloudPixelScale * lineSpacingMultiplier;
  
  for (let x = 0; x <= width; x += charSpacing) {
    for (let y = 0; y <= height; y += lineSpacing) {
      let tinyTimeOffset = millis() / 100000;
      // Defines the scale of noise for visually appealing clouds.
      let noiseScale = 0.01; 
      
      // 3D noise sampling: The first two dimensions are tied to
      // the canvas position, with the x and y values panning
      // slowly over time. The third dimension is solely influenced
      // by time, enabling the clouds to gradually change shape.
      let n = noise(
        x * noiseScale + tinyTimeOffset * panSpeed * panModifier,
        y * noiseScale + tinyTimeOffset * 0.25 * panSpeed * panModifier,
        tinyTimeOffset * cloudEvolutionSpeed * evolveModifier
      );
      
      // Skip this position/letter if noise value is under cutoff.
      if (n < cutoffModifier) { continue; }

      // Use the alpha channel to fade out the edges of the clouds.
      let alpha = map(n, cutoffModifier, 0.65, 10, 255);
      fill(255, alpha);

      // Set the text size to be 15% larger than the grid.
      textSize(cloudPixelScale * 1.15);
      text(getLetterForCoordinate(x, y), x, y);
    }
  }

  bloomShader.setUniform('uResolution', [width, height]);
  bloomShader.setUniform('uIntensity', 0.8);
  filter(bloomShader);
}

function getLetterForCoordinate(x, y) {
  if (artistsText.length === 0) return "•";
  
  const charSpacing = cloudPixelScale * charSpacingMultiplier;
  const lineSpacing = cloudPixelScale * lineSpacingMultiplier;
  
  // Calculate characters per line based on width and character spacing
  const charsPerLine = floor(width / charSpacing);
  
  // Calculate position as if reading left-to-right, top-to-bottom
  const lineIndex = floor(y / lineSpacing);
  const xIndex = floor(x / charSpacing);
  
  // Generate a seed based on the line number for deterministic randomization
  const lineSeed = lineIndex * 12.9898; // Prime number for variation
  const lineOffset = floor(seededRandom(lineSeed) * artistsText.length);
  
  // Offset the index by the line-based seed to vary starting positions
  const index = (lineOffset + lineIndex * charsPerLine + xIndex) % artistsText.length;
  
  return artistsText[index];
}

function windowResized() {
  const { w, h } = heroSize();
  resizeCanvas(w, h);
}

window.setup         = setup;
window.draw          = draw;
window.windowResized = windowResized;
