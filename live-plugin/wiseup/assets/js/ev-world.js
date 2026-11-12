/*
 * Event Branding hero: "Wiso sets the stage".
 * A small real-time 3D world behind the hero (three.js, built from scratch, no photos):
 *   an event stage on the right (round platform with a thin lime light ring, two neon lines on the dark back wall,
 *   a slatted light wall, an entrance arch, two velvet tub chairs with lime cushions, a side table with flowers,
 *   a palm, floor reflections, soft shadows) and Wiso, the WiseUp mascot, a plush lime character.
 * The story (about 10 s): Wiso climbs down a jute rope from the header logo and waves, drops onto the heading, flips
 * across to the dark, unarranged stage, and with a little magic each piece floats into its place and the lights fade
 * up. After that the stage is calm: only Wiso breathes, blinks and looks at the visitor's cursor.
 *
 * The hero stays black: the stage is drawn only inside a soft ellipse around its column, nothing behind the text.
 *
 * Weight: this file and three.js are loaded by the page only after the visitor's first interaction, never during page
 * load (see the loader in landing/event-branding.php); until then the page shows a small still of the same scene.
 * While Wiso travels the canvas covers the hero; once Wiso has landed it shrinks to the stage, and the finished scene
 * renders at half frame rate. Nothing renders while the hero is off screen or the tab is hidden.
 */
import * as THREE from './vendor/three/three.module.min.js';
import { RoomEnvironment } from './vendor/three/addons/environments/RoomEnvironment.js';
import { EffectComposer } from './vendor/three/addons/postprocessing/EffectComposer.js';
import { RenderPass } from './vendor/three/addons/postprocessing/RenderPass.js';
import { ShaderPass } from './vendor/three/addons/postprocessing/ShaderPass.js';
import { UnrealBloomPass } from './vendor/three/addons/postprocessing/UnrealBloomPass.js';
import { OutputPass } from './vendor/three/addons/postprocessing/OutputPass.js';

const hero = document.querySelector('.wu-ev .ev-hero');
const host = hero && hero.querySelector('[data-ev-world]');
const spot = hero && hero.querySelector('[data-ev-spot]');
if (host && spot) {
	try { boot(); } catch (e) { hero.classList.add('ev-world--still'); if (window.console) console.warn(e); }
}

function boot() {
	const V3 = THREE.Vector3, PI = Math.PI;
	const LIME = new THREE.Color('#b6ff00');
	const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;
	const small = () => innerWidth < 760;

	// ---------- renderer, scene, post ----------
	const renderer = new THREE.WebGLRenderer({ antialias: false, powerPreference: 'high-performance' });
	renderer.setClearColor(0x000000, 1);
	renderer.outputColorSpace = THREE.SRGBColorSpace;
	renderer.toneMapping = THREE.ACESFilmicToneMapping;
	renderer.toneMappingExposure = 1.0;
	renderer.shadowMap.enabled = true;
	renderer.shadowMap.type = THREE.PCFSoftShadowMap;
	renderer.shadowMap.autoUpdate = false;
	renderer.domElement.setAttribute('aria-hidden', 'true');
	host.appendChild(renderer.domElement);

	const scene = new THREE.Scene();
	scene.background = new THREE.Color(0x000000);
	const pmrem = new THREE.PMREMGenerator(renderer);
	scene.environment = pmrem.fromScene(new RoomEnvironment(), 0.04).texture;

	const camera = new THREE.PerspectiveCamera(30, 1, 0.1, 120);
	const CAM = new V3(0.3, 1.78, 10.2), TARGET = new V3(0.15, 1.22, 0);
	camera.position.copy(CAM); camera.lookAt(TARGET);
	camera.updateProjectionMatrix = function () {}; // the projection is set by hand (lens shift to the stage column)

	// layer 0 = the stage (and Wiso, so the stage can shadow it), layer 1 = Wiso, rope and sparkles again, on top
	class LayerPass extends RenderPass {
		constructor(layer) { super(scene, camera); this.layer = layer; }
		render(r, w, rd, dt, mask) {
			const m = camera.layers.mask, bg = scene.background;
			camera.layers.set(this.layer);
			if (this.layer) scene.background = null;   // the top layer must not paint the black background over the stage
			super.render(r, w, rd, dt, mask);
			camera.layers.mask = m; scene.background = bg;
		}
	}
	const composer = new EffectComposer(renderer, new THREE.WebGLRenderTarget(16, 16, { type: THREE.HalfFloatType, samples: 4 }));
	composer.addPass(new LayerPass(0));
	// the hero stays black: the stage only shows inside a soft ellipse around its column (drawn before Wiso, who travels outside it)
	const veil = new ShaderPass({
		uniforms: { tDiffuse: { value: null }, uC: { value: new THREE.Vector2(0.5, 0.5) }, uR: { value: new THREE.Vector2(0.5, 0.5) } },
		vertexShader: 'varying vec2 vUv; void main(){ vUv = uv; gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0); }',
		fragmentShader: 'uniform sampler2D tDiffuse; uniform vec2 uC, uR; varying vec2 vUv; void main(){ vec4 c = texture2D(tDiffuse, vUv); float d = length((vUv - uC) / uR); float a = clamp((d - 0.56) / 0.44, 0.0, 1.0); a = a * a * (3.0 - 2.0 * a); gl_FragColor = vec4(c.rgb * (1.0 - a), c.a); }'
	});
	composer.addPass(veil);
	const top = new LayerPass(1); top.clear = false; top.clearDepth = true; composer.addPass(top);
	const bloom = new UnrealBloomPass(new THREE.Vector2(256, 256), 0.3, 0.4, 0.92);
	composer.addPass(bloom);
	composer.addPass(new OutputPass());

	// ---------- textures (generated) ----------
	const canvasTex = (w, h, draw, srgb) => { const c = document.createElement('canvas'); c.width = w; c.height = h; draw(c.getContext('2d'), w, h); const t = new THREE.CanvasTexture(c); if (srgb) t.colorSpace = THREE.SRGBColorSpace; return t; };
	const radial = canvasTex(128, 128, (g) => { const r = g.createRadialGradient(64, 64, 0, 64, 64, 64); r.addColorStop(0, '#fff'); r.addColorStop(0.35, 'rgba(255,255,255,.5)'); r.addColorStop(1, 'rgba(255,255,255,0)'); g.fillStyle = r; g.fillRect(0, 0, 128, 128); });
	const floorFade = canvasTex(256, 256, (g) => { const r = g.createRadialGradient(128, 128, 20, 128, 128, 128); r.addColorStop(0, '#fff'); r.addColorStop(0.6, '#fff'); r.addColorStop(1, '#000'); g.fillStyle = r; g.fillRect(0, 0, 256, 256); });
	const columnTex = canvasTex(4, 256, (g) => { const r = g.createLinearGradient(0, 0, 0, 256); r.addColorStop(0, 'rgba(255,255,255,0)'); r.addColorStop(1, 'rgba(255,255,255,1)'); g.fillStyle = r; g.fillRect(0, 0, 4, 256); });
	const furTex = canvasTex(128, 128, (g) => { const d = g.createImageData(128, 128); for (let i = 0; i < d.data.length; i += 4) { const v = Math.random() * 255; d.data[i] = d.data[i + 1] = d.data[i + 2] = v; d.data[i + 3] = 255; } g.putImageData(d, 0, 0); });
	furTex.wrapS = furTex.wrapT = THREE.RepeatWrapping; furTex.repeat.set(10, 7);
	const ropeTex = canvasTex(64, 64, (g) => {
		g.fillStyle = '#a88d5c'; g.fillRect(0, 0, 64, 64);
		for (let i = -64; i < 128; i += 16) { g.fillStyle = '#7a6238'; g.beginPath(); g.moveTo(i, 0); g.lineTo(i + 7, 0); g.lineTo(i + 39, 64); g.lineTo(i + 32, 64); g.fill(); }
		for (let k = 0; k < 220; k++) { g.fillStyle = 'rgba(' + (Math.random() > 0.5 ? '235,215,170' : '70,55,30') + ',.35)'; g.fillRect(Math.random() * 64, Math.random() * 64, 1.5, 0.8); }
	}, true);
	ropeTex.wrapS = ropeTex.wrapT = THREE.RepeatWrapping;
	const blushTex = canvasTex(64, 64, (g) => { const r = g.createRadialGradient(32, 32, 0, 32, 32, 32); r.addColorStop(0, 'rgba(255,120,145,.9)'); r.addColorStop(1, 'rgba(255,120,145,0)'); g.fillStyle = r; g.fillRect(0, 0, 64, 64); }, true);

	// ---------- materials ----------
	const stageMats = [];
	const sm = (m) => { stageMats.push(m); return m; };
	const M = {
		lacquer: sm(new THREE.MeshPhysicalMaterial({ color: 0x0a0a0c, roughness: 0.3, metalness: 0.1, clearcoat: 1, clearcoatRoughness: 0.16 })),
		matte: sm(new THREE.MeshStandardMaterial({ color: 0x111113, roughness: 0.8 })),
		top: sm(new THREE.MeshPhysicalMaterial({ color: 0x08080a, roughness: 0.55, clearcoat: 0.4, clearcoatRoughness: 0.4 })),
		fabric: sm(new THREE.MeshPhysicalMaterial({ color: 0x2a2b30, roughness: 0.94, sheen: 1, sheenColor: new THREE.Color(0x9a9aa4), sheenRoughness: 0.5, side: THREE.DoubleSide })),
		pillow: sm(new THREE.MeshPhysicalMaterial({ color: 0x8fb916, roughness: 0.85, sheen: 1, sheenColor: new THREE.Color(0xe6ff9a), sheenRoughness: 0.45 })),
		metal: sm(new THREE.MeshStandardMaterial({ color: 0xa3a8ae, metalness: 1, roughness: 0.28 })),
		leaf: sm(new THREE.MeshStandardMaterial({ color: 0x2c6b1c, roughness: 0.6, side: THREE.DoubleSide })),
		stem: sm(new THREE.MeshStandardMaterial({ color: 0x3a5a1c, roughness: 0.8 })),
		petal: sm(new THREE.MeshStandardMaterial({ color: 0xd9d6ca, roughness: 0.7 })),
		bud: sm(new THREE.MeshStandardMaterial({ color: 0xa9c94f, roughness: 0.6 })),
		soil: sm(new THREE.MeshStandardMaterial({ color: 0x17110b, roughness: 1 })),
		glass: sm(new THREE.MeshPhysicalMaterial({ color: 0xffffff, roughness: 0.04, transparent: true, opacity: 0.2, clearcoat: 1, depthWrite: false }))
	};
	const neon = () => new THREE.MeshStandardMaterial({ color: 0x050505, emissive: LIME, emissiveIntensity: 0, roughness: 0.4 });
	const N = { ring: neon(), wall: neon(), arch: neon(), panel: neon() };
	const glowMat = (opacity, map, color) => new THREE.MeshBasicMaterial({ map: map || radial, color: color || LIME, transparent: true, opacity, blending: THREE.AdditiveBlending, depthWrite: false, side: THREE.DoubleSide, toneMapped: false });

	// ---------- the stage ----------
	const stage = new THREE.Group(); scene.add(stage);
	const shadowy = (o) => { o.traverse((m) => { if (m.isMesh) { m.castShadow = true; m.receiveShadow = true; } }); return o; };

	// floor: pure black and glossy; all it shows is the stage's mirror image (the reflection), fading out with distance
	const floor = new THREE.Mesh(new THREE.PlaneGeometry(24, 24), new THREE.MeshBasicMaterial({ color: 0x000000, transparent: true, opacity: 0.82, alphaMap: floorFade }));
	floor.rotation.x = -PI / 2; floor.position.set(0.2, 0, 0); floor.renderOrder = 1; scene.add(floor);

	// platform
	const PR = 1.9;
	const platform = new THREE.Group(); stage.add(platform);
	const plat = new THREE.Mesh(new THREE.CylinderGeometry(PR, PR + 0.03, 0.32, 160, 1, true), M.lacquer); plat.position.y = 0.16; platform.add(plat);
	const platTop = new THREE.Mesh(new THREE.CircleGeometry(PR, 160), M.top); platTop.rotation.x = -PI / 2; platTop.position.y = 0.32; platTop.receiveShadow = true; platform.add(platTop);
	const ring = new THREE.Mesh(new THREE.TorusGeometry(PR + 0.045, 0.016, 12, 320), N.ring); ring.rotation.x = PI / 2; ring.position.y = 0.04; platform.add(ring);

	// two thin neon lines on the (black) back wall
	const WR = 4.6, WZ = 1.6;
	const onWall = (a, y) => new V3(WR * Math.sin(a), y, WZ - WR * Math.cos(a));
	const wallTubes = [
		[[-0.6, 0.35], [-0.5, 1.35], [-0.36, 2.45], [-0.18, 3.4], [0.04, 4.15]],
		[[-0.64, 0.75], [-0.36, 0.86], [-0.08, 1.3], [0.2, 1.95], [0.46, 2.26], [0.64, 2.32]]
	].map((pts) => {
		const curve = new THREE.CatmullRomCurve3(pts.map(([a, y]) => onWall(a, y)));
		const m = new THREE.Mesh(new THREE.TubeGeometry(curve, 360, 0.018, 8, false), N.wall); stage.add(m); return m;
	});
	// slatted light wall (left)
	const slats = new THREE.Group(); slats.position.set(-1.72, 0, -1.3); slats.rotation.y = 0.34; stage.add(slats);
	for (let i = 0; i < 11; i++) { const s = new THREE.Mesh(new THREE.BoxGeometry(0.055, 3.6, 0.11), M.matte); s.position.set(-0.45 + i * 0.09, 1.8, 0); slats.add(s); }
	const slatStrip = new THREE.Mesh(new THREE.BoxGeometry(1.0, 0.025, 0.05), N.panel); slatStrip.position.set(0, 0.03, -0.09); slats.add(slatStrip);
	const slatGlow = new THREE.Mesh(new THREE.PlaneGeometry(1.05, 2.4), glowMat(0, columnTex)); slatGlow.position.set(0, 1.2, -0.08); slats.add(slatGlow);

	// entrance arch with a softly lit doorway
	const arch = new THREE.Group(); stage.add(arch);
	let archDoor;
	{
		const s = new THREE.Shape(); s.moveTo(-0.98, 0); s.lineTo(-0.98, 1.85); s.absarc(0, 1.85, 0.98, PI, 0, true); s.lineTo(0.98, 0); s.lineTo(-0.98, 0);
		const h = new THREE.Path(); h.moveTo(-0.62, 0); h.lineTo(0.62, 0); h.lineTo(0.62, 1.85); h.absarc(0, 1.85, 0.62, 0, PI, false); h.lineTo(-0.62, 0); s.holes.push(h);
		const g = new THREE.ExtrudeGeometry(s, { depth: 0.4, bevelEnabled: true, bevelThickness: 0.03, bevelSize: 0.03, bevelSegments: 4, curveSegments: 64 }); g.translate(0, 0, -0.2);
		arch.add(new THREE.Mesh(g, M.lacquer));
		const pts = []; for (let i = 0; i <= 10; i++) pts.push(new V3(-0.595, (i / 10) * 1.85, 0.235));
		for (let i = 1; i <= 48; i++) { const a = PI - (i / 48) * PI; pts.push(new V3(Math.cos(a) * 0.595, 1.85 + Math.sin(a) * 0.595, 0.235)); }
		for (let i = 9; i >= 0; i--) pts.push(new V3(0.595, (i / 10) * 1.85, 0.235));
		arch.add(new THREE.Mesh(new THREE.TubeGeometry(new THREE.CatmullRomCurve3(pts), 260, 0.016, 8, false), N.arch));
		const door = new THREE.Shape(); door.moveTo(-0.62, 0); door.lineTo(0.62, 0); door.lineTo(0.62, 1.85); door.absarc(0, 1.85, 0.62, 0, PI, false); door.lineTo(-0.62, 0);
		const dg = new THREE.ShapeGeometry(door, 32); dg.translate(0, 0, -0.1);
		const uv = dg.attributes.uv; for (let i = 0; i < uv.count; i++) uv.setXY(i, 0.5, 1 - dg.attributes.position.getY(i) / 2.5);
		archDoor = new THREE.Mesh(dg, glowMat(0, columnTex)); arch.add(archDoor);
		const plinth = new THREE.Mesh(new THREE.BoxGeometry(2.3, 0.06, 0.7), M.lacquer); plinth.position.y = 0.03; arch.add(plinth);
	}
	shadowy(arch);

	// tub chairs
	function chair() {
		const c = new THREE.Group(), body = new THREE.Group(); body.scale.setScalar(1.12); c.add(body);
		const prof = [[0.3, 0.2], [0.37, 0.235], [0.4, 0.36], [0.41, 0.52], [0.4, 0.655], [0.375, 0.69], [0.34, 0.672], [0.33, 0.52], [0.325, 0.36], [0.29, 0.26], [0.3, 0.2]].map(([x, y]) => new THREE.Vector2(x, y));
		const p0 = PI - 2.05, pl = 4.1;
		body.add(new THREE.Mesh(new THREE.LatheGeometry(prof, 96, p0, pl), M.fabric));
		const capShape = new THREE.Shape(prof.slice(0, -1));
		[p0, p0 + pl].forEach((phi) => { const cap = new THREE.Mesh(new THREE.ShapeGeometry(capShape), M.fabric); cap.rotation.y = phi - PI / 2; body.add(cap); });
		const cush = [[0, 0], [0.29, 0], [0.33, 0.025], [0.345, 0.065], [0.335, 0.105], [0.3, 0.13], [0, 0.138]].map(([x, y]) => new THREE.Vector2(x, y));
		const seat = new THREE.Mesh(new THREE.LatheGeometry(cush, 64), M.fabric); seat.position.y = 0.205; body.add(seat);
		[[0.19, 0.17], [-0.19, 0.17], [0.19, -0.17], [-0.19, -0.17]].forEach(([x, z]) => {
			const l = new THREE.Mesh(new THREE.CylinderGeometry(0.012, 0.009, 0.215, 12), M.metal);
			l.position.set(x * 1.06, 0.1, z * 1.06); l.rotation.set(z > 0 ? 0.14 : -0.14, 0, x > 0 ? -0.14 : 0.14); body.add(l);
		});
		const pg = new THREE.BoxGeometry(0.34, 0.3, 0.13, 14, 14, 4), pp = pg.attributes.position;
		for (let i = 0; i < pp.count; i++) { const x = pp.getX(i) / 0.17, y = pp.getY(i) / 0.15; pp.setZ(i, pp.getZ(i) * Math.max(0.12, (1 - x * x * 0.85) * (1 - y * y * 0.85))); pp.setX(i, pp.getX(i) * (1 - 0.08 * y * y)); pp.setY(i, pp.getY(i) * (1 - 0.08 * x * x)); }
		pg.computeVertexNormals();
		const pil = new THREE.Mesh(pg, M.pillow); pil.position.set(0, 0.47, -0.17); pil.rotation.x = -0.28; body.add(pil);
		return shadowy(c);
	}
	const chairL = chair(), chairR = chair(); stage.add(chairL, chairR);

	// side table + flowers
	const table = new THREE.Group(); stage.add(table);
	{
		const ped = [[0.0, 0], [0.17, 0], [0.17, 0.018], [0.07, 0.07], [0.032, 0.3], [0.045, 0.53], [0, 0.535]].map(([x, y]) => new THREE.Vector2(x, y));
		table.add(new THREE.Mesh(new THREE.LatheGeometry(ped, 64), M.lacquer));
		const tt = new THREE.Mesh(new THREE.CylinderGeometry(0.27, 0.27, 0.025, 72), M.lacquer); tt.position.y = 0.548; table.add(tt);
	}
	shadowy(table);
	const bouquet = new THREE.Group(); stage.add(bouquet);
	{
		const vase = new THREE.Mesh(new THREE.SphereGeometry(0.085, 32, 24), M.glass); vase.scale.y = 0.9; vase.position.y = 0.075; bouquet.add(vase);
		const heads = [[0, 0.27, 0, 1], [0.06, 0.24, 0.03, 1], [-0.06, 0.245, 0.02, 1], [0.03, 0.25, -0.06, 1], [-0.04, 0.22, -0.05, 1], [0.08, 0.2, -0.02, 0], [-0.08, 0.205, 0.05, 0], [0.0, 0.215, 0.08, 0], [0.04, 0.3, 0.02, 0]];
		heads.forEach(([x, y, z, w]) => {
			const s = new THREE.Mesh(new THREE.CylinderGeometry(0.003, 0.003, y, 5), M.stem); s.position.set(x * 0.5, 0.05 + y / 2, z * 0.5); s.rotation.set(z * 2, 0, -x * 2); bouquet.add(s);
			const h = new THREE.Mesh(new THREE.IcosahedronGeometry(w ? 0.036 : 0.022, 2), w ? M.petal : M.bud); h.position.set(x, 0.06 + y, z); h.scale.set(1, 0.82, 1); bouquet.add(h);
		});
		for (let i = 0; i < 6; i++) { const l = new THREE.Mesh(new THREE.SphereGeometry(0.03, 10, 8), M.leaf); const a = (i / 6) * PI * 2; l.position.set(Math.cos(a) * 0.09, 0.2, Math.sin(a) * 0.09); l.scale.set(1.9, 0.25, 0.7); l.rotation.set(0, -a, 0.4); bouquet.add(l); }
	}
	shadowy(bouquet);

	// potted palm
	const plant = new THREE.Group(); stage.add(plant);
	{
		const potP = [[0, 0], [0.17, 0], [0.2, 0.05], [0.23, 0.58], [0.235, 0.6], [0.2, 0.6], [0, 0.56]].map(([x, y]) => new THREE.Vector2(x, y));
		plant.add(new THREE.Mesh(new THREE.LatheGeometry(potP, 48), M.lacquer));
		const soil = new THREE.Mesh(new THREE.CircleGeometry(0.2, 32), M.soil); soil.rotation.x = -PI / 2; soil.position.y = 0.57; plant.add(soil);
		const leafShape = new THREE.Shape(); leafShape.moveTo(0, 0); leafShape.quadraticCurveTo(0.12, 0.022, 0.26, 0); leafShape.quadraticCurveTo(0.12, -0.012, 0, 0);
		const leafGeo = new THREE.ShapeGeometry(leafShape, 4);
		const fronds = 9, per = 22, inst = new THREE.InstancedMesh(leafGeo, M.leaf, fronds * per * 2);
		const dm = new THREE.Matrix4(), up = new V3(0, 1, 0); let k = 0;
		for (let f = 0; f < fronds; f++) {
			const ang = (f / fronds) * PI * 2 + (f % 2) * 0.3, sc = 0.8 + (f % 3) * 0.11, lift = 0.75 + (f % 4) * 0.12;
			const dir = new V3(Math.cos(ang), 0, Math.sin(ang));
			const pts = [new V3(0, 0.58, 0), dir.clone().multiplyScalar(0.12 * sc).add(new V3(0, 0.58 + 0.55 * lift, 0)), dir.clone().multiplyScalar(0.5 * sc).add(new V3(0, 0.58 + 0.95 * lift, 0)), dir.clone().multiplyScalar(0.88 * sc).add(new V3(0, 0.58 + 0.9 * lift, 0)), dir.clone().multiplyScalar(1.1 * sc).add(new V3(0, 0.58 + 0.62 * lift, 0))];
			const cv = new THREE.CatmullRomCurve3(pts);
			plant.add(new THREE.Mesh(new THREE.TubeGeometry(cv, 24, 0.008, 5, false), M.stem));
			for (let i = 0; i < per; i++) {
				const u = 0.22 + (i / per) * 0.76, p = cv.getPointAt(u), T = cv.getTangentAt(u);
				const S = new V3().crossVectors(T, up).normalize();
				for (const side of [-1, 1]) {
					const len = (1 - Math.abs(u - 0.55) * 1.2) * sc;
					const x = T.clone().multiplyScalar(0.35).addScaledVector(S, side * 0.92).add(new V3(0, -0.28, 0)).normalize();
					const z = new V3().crossVectors(x, T).normalize(), y = new V3().crossVectors(z, x).normalize();
					dm.makeBasis(x, y, z).scale(new V3(len, 1, 1)).setPosition(p);
					inst.setMatrixAt(k++, dm);
				}
			}
		}
		plant.add(inst);
	}
	shadowy(plant);

	// ---------- the mirror image under the floor (reflections) ----------
	const mirror = stage.clone(); mirror.scale.y = -1; scene.add(mirror);
	mirror.traverse((o) => { o.castShadow = false; o.receiveShadow = false; });
	const twin = (o) => mirror.children[stage.children.indexOf(o)];

	// ---------- light (soft; no beams, no haze) ----------
	const amb = new THREE.AmbientLight(0xdfe4ff, 0.05); scene.add(amb);
	const front = new THREE.DirectionalLight(0xffffff, 0); front.position.set(-2, 3.5, 9); scene.add(front);
	const rim = new THREE.DirectionalLight(0xdfe6ff, 0.4); rim.position.set(1, 5, -6); scene.add(rim);
	const spotL = new THREE.SpotLight(0xfff4e2, 0, 14, 0.26, 0.7, 1.5); spotL.position.set(-1.5, 6.6, 3.0); spotL.target.position.set(-0.7, 0.4, -0.1);
	spotL.castShadow = true; spotL.shadow.mapSize.set(1024, 1024); spotL.shadow.bias = -0.0004; spotL.shadow.normalBias = 0.02; spotL.shadow.radius = 4;
	const spotR = new THREE.SpotLight(0xfff4e2, 0, 14, 0.26, 0.7, 1.5); spotR.position.set(1.7, 6.6, 3.0); spotR.target.position.set(0.72, 0.4, -0.1);
	scene.add(spotL, spotL.target, spotR, spotR.target);
	const limeBack = new THREE.PointLight(LIME, 0, 6, 1.6); limeBack.position.set(0, 1.0, -1.3); scene.add(limeBack);
	const limeDoor = new THREE.PointLight(LIME, 0, 3.5, 1.6); limeDoor.position.set(1.65, 1.2, -0.35); scene.add(limeDoor);

	// ---------- Wiso ----------
	const wiso = new THREE.Group(); scene.add(wiso);
	const spin = new THREE.Group(); wiso.add(spin);
	const R = 0.25, BY = 0.06 + R * 0.95;            // body radius, body centre height above the feet
	spin.position.y = BY;
	const W = {};
	{
		const geo = new THREE.SphereGeometry(R, 72, 54), p = geo.attributes.position, v = new V3();
		for (let i = 0; i < p.count; i++) {
			v.fromBufferAttribute(p, i).normalize();
			const w = Math.hypot(v.x, v.y), phi = Math.atan2(v.y, v.x);
			const f = 1 + 0.055 * Math.cos(8 * phi + 0.4) * w * w + 0.02 * Math.cos(5 * phi) * w;
			p.setXYZ(i, v.x * R * f, v.y * R * f * 0.95, v.z * R * f * 0.97);
		}
		geo.computeVertexNormals();
		const skin = new THREE.MeshPhysicalMaterial({ color: 0x9fd61a, roughness: 0.82, sheen: 1, sheenColor: new THREE.Color(0xf2ffb8), sheenRoughness: 0.42, emissive: new THREE.Color(0x3a5200), emissiveIntensity: 0.4, envMapIntensity: 0.85 });
		W.skin = skin;
		const body = new THREE.Mesh(geo, skin); body.castShadow = true; spin.add(body);
		for (let k = 1; k <= 3; k++) {
			const fur = new THREE.Mesh(geo, new THREE.MeshStandardMaterial({ color: 0xb4e830, roughness: 0.9, alphaMap: furTex, alphaTest: 0.42 + k * 0.14, emissive: new THREE.Color(0x3a5200), emissiveIntensity: 0.35, envMapIntensity: 0.85 }));
			fur.scale.setScalar(1 + k * 0.014); spin.add(fur);
		}
		const fz = (x, y) => Math.sqrt(Math.max(0, R * R - x * x - (y / 0.95) * (y / 0.95))) * 0.97;
		const white = new THREE.MeshPhysicalMaterial({ color: 0xffffff, roughness: 0.12, clearcoat: 1, emissive: new THREE.Color(0xffffff), emissiveIntensity: 0.1 });
		const ink = new THREE.MeshStandardMaterial({ color: 0x0d1205, roughness: 0.3 });
		W.eyes = []; W.pupils = [];
		[-1, 1].forEach((s) => {
			const x = s * 0.074, y = 0.042;
			const eye = new THREE.Group(); eye.position.set(x, y, fz(x, y) - 0.012); spin.add(eye);
			const ball = new THREE.Mesh(new THREE.CapsuleGeometry(0.043, 0.05, 8, 20), white); ball.scale.z = 0.6; eye.add(ball);
			const pupil = new THREE.Group(); pupil.position.z = 0.024; eye.add(pupil);
			const pm = new THREE.Mesh(new THREE.SphereGeometry(0.029, 20, 16), ink); pm.scale.set(1, 1.22, 0.45); pupil.add(pm);
			const hi = new THREE.Mesh(new THREE.SphereGeometry(0.0105, 10, 8), new THREE.MeshBasicMaterial({ color: 0xffffff })); hi.position.set(-0.009, 0.015, 0.012); pupil.add(hi);
			const hi2 = new THREE.Mesh(new THREE.SphereGeometry(0.005, 8, 6), new THREE.MeshBasicMaterial({ color: 0xffffff })); hi2.position.set(0.01, -0.012, 0.012); pupil.add(hi2);
			W.eyes.push(eye); W.pupils.push(pupil);
			const cx = s * 0.158, cy = -0.04, cheek = new THREE.Mesh(new THREE.CircleGeometry(0.045, 24), new THREE.MeshBasicMaterial({ map: blushTex, transparent: true, depthWrite: false, opacity: 0.9 }));
			cheek.position.set(cx, cy, fz(cx, cy) + 0.006); cheek.lookAt(cheek.position.clone().multiplyScalar(2)); spin.add(cheek);
		});
		const my = -0.07, mz = fz(0, my);
		W.smile = new THREE.Mesh(new THREE.TorusGeometry(0.034, 0.008, 8, 24, PI), ink); W.smile.rotation.z = PI; W.smile.position.set(0, my + 0.014, mz); spin.add(W.smile);
		W.mouth = new THREE.Group(); W.mouth.position.set(0, my + 0.014, mz - 0.004); spin.add(W.mouth);
		W.mouth.add(new THREE.Mesh(new THREE.CircleGeometry(0.04, 24, PI, PI), ink));
		const tongue = new THREE.Mesh(new THREE.CircleGeometry(0.018, 16), new THREE.MeshStandardMaterial({ color: 0xff7f8f, roughness: 0.6 })); tongue.position.set(0, -0.027, 0.002); tongue.scale.y = 0.6; W.mouth.add(tongue);
		W.arms = [];
		[-1, 1].forEach((s) => {
			const piv = new THREE.Group(); piv.position.set(s * 0.215, -0.02, 0.02); spin.add(piv);
			const a = new THREE.Mesh(new THREE.CapsuleGeometry(0.04, 0.08, 6, 14), skin); a.position.y = -0.07; a.castShadow = true; piv.add(a);
			const h = new THREE.Mesh(new THREE.SphereGeometry(0.05, 20, 16), skin); h.position.y = -0.14; h.scale.set(1, 0.92, 0.9); piv.add(h);
			W.arms.push(piv);
		});
		W.hands = W.arms.map((a) => a.children[1]);
		const footMat = new THREE.MeshPhysicalMaterial({ color: 0x77a314, roughness: 0.8, sheen: 1, sheenColor: new THREE.Color(0xd8ff8a), emissive: new THREE.Color(0x253400), emissiveIntensity: 0.4 });
		[-1, 1].forEach((s) => { const f = new THREE.Mesh(new THREE.SphereGeometry(0.068, 20, 14), footMat); f.scale.set(1.1, 0.55, 1.35); f.position.set(s * 0.092, 0.036, 0.03); f.castShadow = true; wiso.add(f); });
		// a little sprout on top
		const tp = R * 0.95;
		const stemC = new THREE.CatmullRomCurve3([new V3(0, tp - 0.01, 0), new V3(0.005, tp + 0.045, 0.005), new V3(0.02, tp + 0.08, 0)]);
		W.sprout = new THREE.Group(); spin.add(W.sprout);
		W.sprout.add(new THREE.Mesh(new THREE.TubeGeometry(stemC, 12, 0.006, 6, false), new THREE.MeshStandardMaterial({ color: 0x4f8f17, roughness: 0.7 })));
		const ls = new THREE.Shape(); ls.moveTo(0, 0); ls.quadraticCurveTo(0.03, 0.03, 0.07, 0); ls.quadraticCurveTo(0.03, -0.022, 0, 0);
		[[1, 0.5], [-1, -0.2]].forEach(([s, r]) => { const l = new THREE.Mesh(new THREE.ShapeGeometry(ls, 6), new THREE.MeshStandardMaterial({ color: 0x5cb81e, roughness: 0.55, side: THREE.DoubleSide, emissive: new THREE.Color(0x1d3a06), emissiveIntensity: 0.6 })); l.position.set(0.02, tp + 0.08, 0); l.rotation.set(0.3, s > 0 ? 0 : PI, r); W.sprout.add(l); });
		W.glow = new THREE.PointLight(LIME, 0.2, 1.6, 1.5); W.glow.position.y = BY; wiso.add(W.glow);
	}
	wiso.traverse((o) => o.layers.enable(1));       // drawn with the stage (layer 0) and again on top (layer 1)

	// rope (jute)
	const ropeMat = new THREE.MeshStandardMaterial({ map: ropeTex, roughness: 0.95, color: 0xffffff });
	const rope = new THREE.Mesh(new THREE.BufferGeometry(), ropeMat); rope.layers.set(1); rope.frustumCulled = false; scene.add(rope);
	const knot = new THREE.Mesh(new THREE.SphereGeometry(0.035, 16, 12), ropeMat); knot.layers.set(1); scene.add(knot);

	// a few sparkles for the magic (stateless: every particle's state is a function of time)
	const SPK = 96, spkG = new THREE.BufferGeometry();
	const sPos = new Float32Array(SPK * 3), sCol = new Float32Array(SPK * 3), sSize = new Float32Array(SPK);
	spkG.setAttribute('position', new THREE.BufferAttribute(sPos, 3)); spkG.setAttribute('color', new THREE.BufferAttribute(sCol, 3)); spkG.setAttribute('size', new THREE.BufferAttribute(sSize, 1));
	const sparkles = new THREE.Points(spkG, new THREE.ShaderMaterial({
		uniforms: { uScale: { value: 400 } },
		vertexShader: 'uniform float uScale; attribute float size; attribute vec3 color; varying vec3 vC; void main(){ vC = color; vec4 mv = modelViewMatrix * vec4(position, 1.0); gl_PointSize = size * uScale / -mv.z; gl_Position = projectionMatrix * mv; }',
		fragmentShader: 'varying vec3 vC; void main(){ vec2 p = gl_PointCoord * 2.0 - 1.0; float d = length(p); float core = smoothstep(1.0, 0.0, d); core *= core; gl_FragColor = vec4(vC * core, 1.0); }',
		transparent: true, depthWrite: false, depthTest: false, blending: THREE.AdditiveBlending
	}));
	sparkles.frustumCulled = false; sparkles.layers.set(1); scene.add(sparkles);

	// ---------- layout: final places and the unarranged start ----------
	const E = (x, y, z) => new THREE.Euler(x, y, z);
	const PLACE = new Map([
		[chairL, { p: new V3(-0.74, 0.32, -0.1), r: E(0, 0.5, 0), mp: new V3(-1.72, 0.04, 1.55), mr: E(-1.5, 1.0, 0.25) }],
		[chairR, { p: new V3(0.74, 0.32, -0.1), r: E(0, -0.5, 0), mp: new V3(1.75, 0.36, 1.9), mr: E(0.1, -1.9, 1.5) }],
		[table, { p: new V3(0, 0.32, -0.3), r: E(0, 0, 0), mp: new V3(0.45, 0.27, 2.0), mr: E(1.57, 0.35, 0) }],
		[bouquet, { p: new V3(0, 0.88, -0.3), r: E(0, 0.4, 0), mp: new V3(-0.5, 0.05, 2.3), mr: E(1.45, 0, 0.9) }],
		[plant, { p: new V3(-1.98, 0, 0.5), r: E(0, 0.3, 0), mp: new V3(-1.25, 0.22, 2.0), mr: E(0, 0.4, 1.48) }],
		[arch, { p: new V3(1.86, 0, -0.85), r: E(0, -0.42, 0), mp: new V3(1.95, 0.22, -0.35), mr: E(-1.57, -0.42, 0) }]
	]);
	const ORDER = [[chairL, 2.0], [chairR, 2.3], [table, 2.6], [bouquet, 2.9], [plant, 3.2], [arch, 3.5]];
	const LAND = new V3(1.26, 0.32, 1.02);

	// ---------- helpers ----------
	const clamp = (v) => Math.min(1, Math.max(0, v));
	const seg = (t, a, b) => clamp((t - a) / (b - a));
	const io = (x) => (x < 0.5 ? 4 * x * x * x : 1 - Math.pow(-2 * x + 2, 3) / 2);
	const out3 = (x) => 1 - Math.pow(1 - x, 3);
	const mix = (a, b, k) => a + (b - a) * k;
	const bez = (a, c, b, u, o) => o.set((1 - u) * (1 - u) * a.x + 2 * (1 - u) * u * c.x + u * u * b.x, (1 - u) * (1 - u) * a.y + 2 * (1 - u) * u * c.y + u * u * b.y, (1 - u) * (1 - u) * a.z + 2 * (1 - u) * u * c.z + u * u * b.z);
	const fade = (t, t0) => io(seg(t, t0, t0 + 0.7));           // lights come up softly, one after another
	const qa = new THREE.Quaternion(), qb = new THREE.Quaternion(), tmp = new V3(), tmp2 = new V3(), tmp3 = new V3(), tmp4 = new V3();

	// ---------- size, the stage's box, projection ----------
	// While Wiso travels the canvas covers the hero; afterwards it covers only the stage's box (the column plus a margin).
	let Wpx = 0, Hpx = 0, focal = 900, compact = true, lowMode = false, lastBox = '', dirty = true;
	const box = () => { const hr = hero.getBoundingClientRect(), sr = spot.getBoundingClientRect(); return { x: sr.left - hr.left - sr.width * 0.11, y: sr.top - hr.top - sr.height * 0.17, w: sr.width * 1.22, h: sr.height * 1.3 }; };
	const layout = () => {
		const b = box();
		if (compact) {
			const s = Math.round(b.x) + '|' + Math.round(b.y) + '|' + Math.round(b.w) + '|' + Math.round(b.h);
			if (s !== lastBox) { lastBox = s; host.style.cssText = 'inset:auto;left:' + Math.round(b.x) + 'px;top:' + Math.round(b.y) + 'px;width:' + Math.round(b.w) + 'px;height:' + Math.round(b.h) + 'px'; }
		} else if (lastBox !== 'full') { lastBox = 'full'; host.style.cssText = ''; }
		const w = host.clientWidth, h = host.clientHeight;
		if (w !== Wpx || h !== Hpx || dirty) {
			dirty = false; Wpx = w; Hpx = h;
			const dpr = host.evDpr || Math.min(devicePixelRatio || 1, lowMode ? 1 : compact ? 1.6 : small() ? 1.5 : 1.25);
			renderer.setPixelRatio(dpr); renderer.setSize(w, h, false);
			composer.setPixelRatio(dpr); composer.setSize(w, h);
		}
		if (compact) { veil.uniforms.uC.value.set(0.5, 0.5); veil.uniforms.uR.value.set(0.5, 0.5); }
		else { veil.uniforms.uC.value.set((b.x + b.w / 2) / Wpx, 1 - (b.y + b.h / 2) / Hpx); veil.uniforms.uR.value.set(b.w / 2 / Wpx, b.h / 2 / Hpx); }
	};
	const project = () => {
		const hr = host.getBoundingClientRect(), sr = spot.getBoundingClientRect();
		const cx = sr.left - hr.left + sr.width / 2, cy = sr.top - hr.top + sr.height / 2;
		const D = camera.position.distanceTo(TARGET);
		focal = Math.min(sr.height * D / 4.5, sr.width * D / 5.6);
		const n = camera.near;
		camera.projectionMatrix.makePerspective(-cx * n / focal, (Wpx - cx) * n / focal, cy * n / focal, -(Hpx - cy) * n / focal, n, camera.far);
		camera.projectionMatrixInverse.copy(camera.projectionMatrix).invert();
		sparkles.material.uniforms.uScale.value = focal * renderer.getPixelRatio();
	};
	// a point of the page (px in the canvas) on the plane z = zp
	const toWorld = (px, py, zp, o) => {
		tmp.set((px / Wpx) * 2 - 1, -(py / Hpx) * 2 + 1, 0.5).unproject(camera).sub(camera.position).normalize();
		return o.copy(camera.position).addScaledVector(tmp, (zp - camera.position.z) / tmp.z);
	};

	// ---------- the route on the page ----------
	const ZP = 2.6;
	let route = null, wisoScale = 1;
	const readRoute = () => {
		const hr = hero.getBoundingClientRect();
		const logo = document.querySelector('.hd__logo img') || document.querySelector('.hd__logo');
		const L = logo ? logo.getBoundingClientRect() : { left: hr.left + 40, width: 140, bottom: hr.top + 80 };
		const h1el = hero.querySelector('.ev-hero__h'), h1 = h1el.getBoundingClientRect(), fs = parseFloat(getComputedStyle(h1el).fontSize);
		const eb = hero.querySelector('.ev-hero__copy .eyebrow, .ev-hero__copy [class*="eyebrow"]');
		const ebTop = eb ? eb.getBoundingClientRect().top : h1.top - fs * 1.4;
		const ax = L.left - hr.left + L.width * 0.5, ay = L.bottom - hr.top + 2;
		route = {
			anchor: [ax, ay],
			hang: [ax, ebTop - hr.top - 6],                                                    // feet just above the eyebrow
			perch: [h1.left - hr.left + Math.min(h1.width * 0.5, fs * 5.2), h1.top - hr.top + fs * 0.16] // on the first line
		};
		// Wiso's height on screen: about 78 px on a laptop, 50 px on a phone
		wisoScale = (small() ? 46 : 66) / (focal * 0.63 / (camera.position.z - LAND.z));
	};

	// ---------- poses ----------
	const POSE = { hold: [2.98, -2.98], waveHold: [2.98, 2.5], air: [-2.0, 2.0], rest: [-0.18, 0.18], cast: [-2.55, 2.55] };
	const turn = (a, b, k) => { let d = (b - a) % (2 * PI); if (d > PI) d -= 2 * PI; if (d < -PI) d += 2 * PI; return a + d * k; }; // the short way round
	const setArms = (a, b, k) => { W.arms[0].rotation.z = turn(a[0], b[0], k); W.arms[1].rotation.z = turn(a[1], b[1], k); };
	const face = (happy, open, lookX, lookY, blink) => {
		W.eyes.forEach((e) => { e.scale.y = Math.max(0.08, (1 - happy * 0.6) * (1 - blink)); e.position.y = 0.042 + happy * 0.008; });
		W.pupils.forEach((p) => { p.position.x = lookX * 0.012; p.position.y = lookY * 0.013; });
		W.mouth.scale.setScalar(Math.max(0.001, open)); W.smile.scale.setScalar(Math.max(0.001, 1 - open));
	};
	const blinkAt = (t) => { const c = t % 4.3; return c > 4.12 ? Math.sin(((c - 4.12) / 0.18) * PI) : 0; };

	const pointer = { x: 0, y: 0, on: false };
	addEventListener('pointermove', (e) => { pointer.x = e.clientX; pointer.y = e.clientY; pointer.on = true; }, { passive: true });

	// ---------- one moment of the story ----------
	const hangP = new V3(), perchP = new V3(), anchorP = new V3(), feet = new V3(), ctrl = new V3(), hand0 = new V3(), hand1 = new V3();
	const T_END = 6.6;
	function story(t, now) {
		// stage pieces: from where they lie to their place
		for (const [o, st] of ORDER) {
			const P = PLACE.get(o), k = seg(t, st, st + 1.1), e = out3(k);
			tmp.copy(P.mp).lerp(P.p, e); tmp.y += Math.sin(k * PI) * 0.9;
			o.position.copy(tmp);
			qa.setFromEuler(P.mr); qb.setFromEuler(P.r); o.quaternion.copy(qa).slerp(qb, io(k));
			const tw = twin(o); tw.position.copy(o.position); tw.quaternion.copy(o.quaternion);
		}
		// lights: a soft fade up, the neon one line after another (no flicker, no beams)
		const lit = io(seg(t, 4.4, 5.6));
		stageMats.forEach((m) => { m.envMapIntensity = mix(0.06, 0.3, lit); });
		N.ring.emissiveIntensity = 1.5 * fade(t, 4.5);
		N.panel.emissiveIntensity = 1.3 * fade(t, 4.7);
		N.arch.emissiveIntensity = 1.5 * fade(t, 4.9);
		N.wall.emissiveIntensity = t >= 4.8 ? 1.35 : 0;
		const draw = io(seg(t, 4.8, 5.9));
		wallTubes.forEach((m, i) => { const n = m.geometry.index.count; m.geometry.setDrawRange(0, Math.floor((n * clamp(draw * 1.15 - i * 0.15)) / 3) * 3); });
		spotL.intensity = 58 * fade(t, 4.6); spotR.intensity = 58 * fade(t, 4.7);
		limeBack.intensity = 1.6 * lit; limeDoor.intensity = 1.1 * fade(t, 4.9);
		slatGlow.material.opacity = 0.1 * fade(t, 4.7);
		archDoor.material.opacity = 0.13 * fade(t, 4.9);
		front.intensity = 0.1 + 0.5 * lit; rim.intensity = 0.4 + 0.3 * lit; amb.intensity = 0.05 + 0.06 * lit;

		// Wiso
		if (!route) return;
		const S = wisoScale * Math.max(0.001, out3(seg(t, 0, 0.35)));
		const ropeOn0 = 0;
		let sx = 1, sy = 1, rotY = 0.15, rotZ = 0, flip = 0, happy = 0.3, open = 0, lookX = 0, lookY = 0, ropeOn = ropeOn0, holdBoth = 1, glow = 0, wave = 0;
		let armsA = POSE.hold, armsB = POSE.hold, armK = 0;

		if (t < T_END) {                              // Wiso pops up on the stage, waves, casts, the pieces arrange, the lights come up
			feet.copy(LAND);
			const pop = seg(t, 0, 0.5); sy = pop < 1 ? 0.6 + 0.4 * out3(pop) + Math.sin(pop * PI) * 0.15 : 1; sx = 2 - sy;
			const wv = seg(t, 0.5, 0.7) * (1 - seg(t, 1.3, 1.5));
			wave = wv; armsA = POSE.rest; armsB = POSE.waveHold; armK = wv;
			happy = 0.35 + wv * 0.5; open = wv * 0.8;
			const cast = seg(t, 1.6, 1.95) * (1 - seg(t, 4.3, 4.7));
			if (cast > 0) { armsA = POSE.rest; armsB = POSE.cast; armK = io(cast); }
			glow = cast;
			rotY = 0.15 - 0.55 * io(seg(t, 1.6, 2.0)) + 0.55 * seg(t, 4.3, 4.8);
			if (cast > 0) { open = Math.max(open, cast * 0.6); lookX = -0.6 * cast; lookY = 0.2 * cast; }
			const hop = seg(t, 5.7, 6.2);              // one small happy hop when the lights are on
			if (hop > 0) { feet.y += Math.sin(hop * PI) * 0.22 * wisoScale; armsA = POSE.rest; armsB = POSE.cast; armK = Math.sin(hop * PI) * 0.9; open = Math.sin(hop * PI); happy = 0.8; }
		} else {                                      // afterwards: calm. Breathing, blinking, eyes on the cursor
			feet.copy(LAND);
			const breathe = Math.sin(now * 2.0) * 0.016;
			sy = 1 + breathe; sx = 1 - breathe * 0.6;
			armsA = POSE.rest; armsB = POSE.rest;
			if (pointer.on) {
				tmp3.copy(LAND); tmp3.y += BY * wisoScale; tmp3.project(camera);
				const hr = host.getBoundingClientRect();
				const wx = (tmp3.x * 0.5 + 0.5) * Wpx + hr.left, wy = (-tmp3.y * 0.5 + 0.5) * Hpx + hr.top;
				lookX = Math.max(-1, Math.min(1, (pointer.x - wx) / 420)); lookY = Math.max(-1, Math.min(1, -(pointer.y - wy) / 320));
			}
			rotY = 0.15 + lookX * 0.28;
			happy = 0.35;
		}

		const ft = t < T_END ? t : now;
		wiso.visible = t > 0.02;
		wiso.position.copy(feet);
		wiso.scale.set(S * sx, S * sy, S * sx);
		wiso.rotation.set(0, rotY, rotZ);
		spin.rotation.z = flip;
		setArms(armsA, armsB, armK);
		if (wave > 0) W.arms[1].rotation.z += Math.sin(t * 13) * 0.32 * wave;
		face(happy, open, lookX, lookY, blinkAt(ft));
		W.sprout.rotation.z = Math.sin(ft * 2.4) * 0.1;
		W.skin.emissiveIntensity = 0.4 + glow * 0.5;
		W.glow.intensity = 0.2 + glow * 0.9 + 0.2 * lit;

		// rope from the logo to Wiso's hands
		wiso.updateMatrixWorld(true);
		W.hands[0].getWorldPosition(hand0); W.hands[1].getWorldPosition(hand1);
		rope.visible = knot.visible = ropeOn > 0.01 && t > 0.02;
		if (rope.visible) {
			const end = holdBoth >= 0.5 ? tmp2.copy(hand0).add(hand1).multiplyScalar(0.5) : tmp2.copy(hand0);
			const e2 = tmp3.copy(anchorP).lerp(end, ropeOn);
			const c2 = tmp4.copy(anchorP).lerp(e2, 0.5); c2.x += rotZ * -0.4 * wisoScale; c2.y -= 0.02;
			rope.geometry.dispose(); rope.geometry = new THREE.TubeGeometry(new THREE.QuadraticBezierCurve3(anchorP.clone(), c2.clone(), e2.clone()), 24, 0.0105 * wisoScale, 6, false);
			ropeTex.repeat.set(Math.max(1, anchorP.distanceTo(e2) / (0.05 * wisoScale)), 1);
			knot.position.copy(anchorP); knot.scale.set(1.3 * wisoScale, wisoScale, wisoScale);
		}

		// a few sparkles: a small puff when Wiso casts, a short trail to each piece while it floats
		let n = 0;
		const put = (p, f, size) => { if (n >= SPK || f <= 0) return; sPos[n * 3] = p.x; sPos[n * 3 + 1] = p.y; sPos[n * 3 + 2] = p.z; sCol[n * 3] = 0.9 * f; sCol[n * 3 + 1] = 1.25 * f; sCol[n * 3 + 2] = 0.35 * f; sSize[n] = size; n++; };
		const rnd = (i, k) => { const x = Math.sin(i * 127.1 + k * 311.7) * 43758.5453; return x - Math.floor(x); };
		if (t > 1.6 && t < 2.4) for (let i = 0; i < 16; i++) {
			const u = seg(t, 1.6 + rnd(i, 1) * 0.25, 2.4); if (u <= 0 || u >= 1) continue;
			const a = rnd(i, 2) * PI * 2, r = u * (0.3 + rnd(i, 3) * 0.4) * wisoScale * 1.4;
			tmp.set(hand1.x + Math.cos(a) * r, hand1.y + Math.sin(a) * r * 0.8 + u * 0.2, hand1.z + 0.05); put(tmp, 1 - u, 0.028 * (1 - u * 0.5));
		}
		for (const [o, st] of ORDER) {
			if (t < st - 0.05 || t > st + 1.0) continue;
			const life = seg(t, st - 0.05, st + 0.2) * (1 - seg(t, st + 0.7, st + 1.0));
			for (let i = 0; i < 9; i++) {
				const u = ((t - st) * 1.4 + i / 9 + 10) % 1;
				ctrl.copy(hand1).lerp(o.position, 0.5); ctrl.y += 0.9;
				bez(hand1, ctrl, o.position, u, tmp); tmp.x += (rnd(i, 4) - 0.5) * 0.08; tmp.y += (rnd(i, 5) - 0.5) * 0.08 + 0.25 * u;
				put(tmp, Math.sin(u * PI) * life * 0.9, 0.022 + rnd(i, 6) * 0.016);
			}
		}
		spkG.attributes.position.needsUpdate = spkG.attributes.color.needsUpdate = spkG.attributes.size.needsUpdate = true;
		spkG.setDrawRange(0, n);
		sparkles.visible = n > 0;
	}

	// ---------- run ----------
	let t0 = null, onScreen = true, frozen = false, shown = false, tick = 0, slow = 0, slowN = 0, last = 0;
	const frame = (time, t) => {
		layout();
		const px = parseFloat(spot.style.getPropertyValue('--rx')) || 0, py = parseFloat(spot.style.getPropertyValue('--ry')) || 0;
		camera.position.set(CAM.x + px * 0.4, CAM.y - py * 0.2, CAM.z); camera.lookAt(TARGET); camera.updateMatrixWorld(); project();
		if (!route) readRoute();
		story(t, time / 1000);
		renderer.shadowMap.needsUpdate = true;
		composer.render();
		if (!shown) { shown = true; hero.classList.add('ev-world--on'); }
	};
	const loop = (time) => {
		if (frozen) return;
		const t = t0 == null ? 0 : Math.max(0, time / 1000 - t0);
		if (t > T_END + 0.5 && (tick++ & 1)) return;            // the finished scene runs at half frame rate
		// slow device? measure during the first seconds and step down once (no bloom, fewer pixels)
		if (!lowMode && t > 0.5 && t < 5 && last) { slow += time - last; if (++slowN === 50 && slow / slowN > 55) { lowMode = true; bloom.enabled = false; dirty = true; } }
		last = time;
		frame(time, t);
	};
	const runIfVisible = () => { last = 0; renderer.setAnimationLoop(onScreen && !document.hidden && !frozen && !reduce ? loop : null); };
	new IntersectionObserver((es) => { onScreen = es[0].isIntersecting; runIfVisible(); }).observe(hero);
	document.addEventListener('visibilitychange', runIfVisible);
	addEventListener('resize', () => { dirty = true; route = null; if (reduce || frozen) frame(performance.now(), T_END + 1); });
	// the story only makes sense while the stage is in view: if the visitor has scrolled on, finish it quietly
	addEventListener('scroll', () => { if (t0 != null && !frozen) { const sr = spot.getBoundingClientRect(), now = performance.now() / 1000; if (now - t0 < T_END && (sr.bottom < 60 || sr.top > innerHeight)) t0 = now - T_END - 0.6; } }, { passive: true });

	// test hook: render one exact moment of the story (used by the page checks and to make the still images)
	host.evPose = (t, o) => {
		o = o || {}; frozen = true; renderer.setAnimationLoop(null);
		if (o.dpr) host.evDpr = o.dpr;
		dirty = true; route = null;
		spot.style.removeProperty('--rx'); spot.style.removeProperty('--ry');
		frame((o.now != null ? o.now : t) * 1000, t);
		return o.grab ? renderer.domElement.toDataURL('image/png') : null;
	};

	layout(); project(); readRoute(); story(0, 0);
	const go = () => {
		const sr = spot.getBoundingClientRect(), now = performance.now() / 1000;
		t0 = (reduce || sr.bottom < 60 || sr.top > innerHeight) ? now - T_END - 0.6 : now + 0.15;
		if (reduce) frame(performance.now(), T_END + 1); else runIfVisible();
	};
	if (renderer.compileAsync) renderer.compileAsync(scene, camera).then(go, go); else go();
}
