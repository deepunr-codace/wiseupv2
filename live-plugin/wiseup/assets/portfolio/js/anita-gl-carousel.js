/**
 * Author: Shadow Themes
 * Author URL: https://shadow-themes.com
 */
"use strict";

// Resolve assets relative to this script's own URL, so renaming/versioning the
// theme's asset folder (portfolio-assets, portfolio-assets2, ...) never leaves
// a stale hardcoded path behind (that's what broke the ground reflection texture
// multiple times before).
const ANITA_GL_BASE = (function () {
    const script = document.currentScript || (function () {
        const scripts = document.getElementsByTagName("script");
        return scripts[scripts.length - 1];
    })();
    const src = script && script.src ? script.src.split("?")[0] : "";
    return src.replace(/\/js\/[^\/]*$/, "/");
})();

class Anita_GL_Carousel {
    constructor(d, e = !1) {
        if (d instanceof jQuery ? this.$el = d : this.$el = jQuery(d), !this.$el.length)
            return console.warn("gl_Carousel: Element not found"), !1;
        if (!this.$el.children(".anita-gl-gallery-item").length)
            return console.warn("gl_Carousel: There are no slides"), !1;
        if ("object" != typeof THREE)
            return console.warn("gl_Carousel: Three.js not found"), !1;

        this.options = {
            container: jQuery("body"),
            size: .75,
            antialised: !0,
            spacing: 40,
            camera_angle: .1,
            camera_move: [.5, .3],
            camera_height: 1.6,
            responsive: !1,
            slideSpeed: .04,
            cameraRotateSpeed: .025,
            cameraMoveSpeed: .02,
            nav: !1,
            wheelSensitive: 50,
            // Lower than the original .25: the reflection re-renders the whole
            // scene to an offscreen texture every single frame, so this value
            // has a quadratic effect on cost. .25 was needlessly heavy for how
            // subtle the floor reflection actually reads visually.
            reflection_q: .15
        };

        if (e) for (let [f, g] of Object.entries(e)) this.options[f] = g;

        let a = this;
        this.loader = new THREE.TextureLoader();
        if (window.location.protocol !== 'file:') {
            this.loader.setCrossOrigin("anonymous");
        }
        this.clock = new THREE.Clock();
        this.prevTime = 0;
        // The caption text's position gets rewritten on nearly every single
        // animation frame during a slide transition (see animate() below).
        // Caching the raw element and writing .style.transform directly skips
        // jQuery's per-call property normalization/hook lookup, and the
        // will-change hint tells the browser to composite this on the GPU
        // instead of potentially repainting/recalculating layout every frame.
        this.elNative = this.$el[0];
        this.elNative.style.willChange = "transform";
        this.elNative.style.transform = "translateX(0px)";
        // WiseUp plugin (2026-11-12): the scene is sized from its container, not the window, so the portfolio page can
        // give the carousel only the screen below the WiseUp header.
        this.box = function () { let el = a.options.container[0]; return [el && el.clientWidth || window.innerWidth, el && el.clientHeight || window.innerHeight]; };
        // options.inset (px, or a function returning px): the top band of the container the work must stay out of (the
        // WiseUp header floats there). The canvas still fills the whole container, so the header sits on the scene as
        // part of the hero, but the scene is composed in the area below the band (camera view offset, see frame()).
        this.inset = function () { let i = a.options.inset; i = "function" == typeof i ? i() : i; return Math.max(0, parseFloat(i) || 0); };
        // options.overhang: how far (as a fraction of the frame height) the slides reach above the frame in this design's
        // landscape composition (the camera crops their tops). With an inset that space must stay clear too, so the
        // frame is made that much shorter and set lower: every slide ends up fully below the inset. The frame's top and
        // height are published as --gl-frame-top / --gl-frame-h on the container, for the captions and arrows.
        // options.insetBottom: the same for a band at the bottom (the portfolio page keeps its category bar there).
        this.insetB = function () { let i = a.options.insetBottom; i = "function" == typeof i ? i() : i; return Math.max(0, parseFloat(i) || 0); };
        this.sceneH = function () { return a.frameH || Math.max(1, a.box()[1] - a.inset() - a.insetB()); };
        // options.caption_space (px): in a landscape frame the camera's distance and height are solved so the cards fill
        // the frame: a card's top (at the mouse parallax's highest) touches the top of the frame and its bottom sits
        // caption_space px above the frame's bottom, where the title and button go (owner, 2026-11-13: "make cards
        // more big"). Otherwise (portrait, or no caption_space) the overhang framing above. The card's bottom edge in
        // the frame is published as --gl-card-bottom, so the captions can sit right under the card.
        a.baseCamH = a.options.camera_height;
        this.frame = function () {
            let [w, h] = a.box(), bt = Math.min(a.insetB(), h * .4), i = Math.min(a.inset(), h - bt - 1), A = Math.max(1, h - i - bt),
                T = Math.tan(a.camera.fov * Math.PI / 360), Hc = 2 * a.shv * a.options.size, mv = a.options.camera_move[1],
                C = parseFloat(a.options.caption_space) || 0, el = a.options.container[0], v, t, b;
            if (C && w > A) {
                // the parallax also lowers the card by mv/(cardH + mv) of b (mouse at the top): leave the caption space below that too
                b = Math.max(.55, (A - C) / (A * (1 + mv / (Hc + mv))));
                let d = (Hc + mv) / (2 * T * b);
                a.camera_distance.land_n = d;
                a.camera_distance.land_z = d * .8;
                a.options.camera_height = (b - .5) * 2 * d * T;
                v = A; t = i;
            } else {
                a.options.camera_height = a.baseCamH;
                let r = !C && w > A ? Math.max(0, parseFloat(a.options.overhang) || 0) : 0;
                v = Math.max(1, A / (1 + r)); t = h - bt - v;
                b = .5 + a.options.camera_height / (2 * T * (a.camera_distance ? a.camera_distance.port_n : 7.5));
            }
            if (a.position) a.position.camera_tM.y = a.options.camera_height;
            a.frameH = v;
            a.frameTop = t; a.cardBottomPx = b * v; a.boxWH = [w, h]; // for the captions (animate)
            a.camera.setViewOffset(w, v, 0, -t, w, h);
            a.camera.updateProjectionMatrix();
            if (el) { el.style.setProperty("--gl-frame-top", Math.round(t) + "px"); el.style.setProperty("--gl-frame-h", Math.round(v) + "px"); el.style.setProperty("--gl-card-bottom", Math.round(b * v) + "px"); }
        };
        this.paused = !1;
        this.shv = 3.8366;
        this.p2p = 2 * this.shv / this.sceneH();
        this.spacing = this.options.spacing * this.p2p;
        this.position = { gallery_t: 0, camera_tR: { x: 0, y: 0, z: 0 }, camera_tM: { x: 0, y: a.options.camera_height, z: 5, offsetX: 0 }, text_c: 0, text_t: 0 };
        this.dimension = { slideWidth: 0 };
        this.cameraFixed = !1;
        this.isPortrait = !(this.box()[0] > this.sceneH());
        this.view_pos = { def: 0, zoom: 0 };
        this.camera_distance = { land_n: 5, land_z: 4, port_n: 7.5, port_z: 6 };
        // options.portrait_distance: the camera distance in a portrait frame (theme: 7.5); closer makes the cards bigger on phones
        if (parseFloat(this.options.portrait_distance) > 0) { this.camera_distance.port_n = parseFloat(this.options.portrait_distance); this.camera_distance.port_z = this.camera_distance.port_n * .8; }
        this.scene = new THREE.Scene();
        this.isPortrait ? this.view_pos = { def: this.camera_distance.port_n, zoom: this.camera_distance.port_z } : this.view_pos = { def: this.camera_distance.land_n, zoom: this.camera_distance.land_z };
        this.camera = new THREE.PerspectiveCamera(75, this.box()[0] / this.box()[1], .5, 1e3);
        this.camera.position.z = this.view_pos.def;
        this.camera.position.y = a.options.camera_height;
        this.camera.rotation.y = -1 * this.options.camera_angle; // was -0.1 (= the default angle); 0 keeps the cards square-on
        this.camera.rotation.x = -0.1;
        this.frame();

        // Phones/small tablets are the devices most likely to struggle with
        // MSAA + a full reflection re-render every frame, and gain the least
        // visually from either on a small screen - so scale both back there.
        this.isLowPower = window.innerWidth < 900;

        jQuery(".anita-gl-carousel-canvas").length && jQuery(".anita-gl-carousel-canvas").remove();
        // MSAA has a real, constant per-frame GPU cost on a scene that's
        // rendering continuously (never just once) - not worth it here.
        this.renderer = new THREE.WebGLRenderer({ antialias: false, alpha: !1 });
        this.renderer.setSize(this.box()[0], this.box()[1]);
        this.options.container[0].append(this.renderer.domElement);
        jQuery(this.renderer.domElement).addClass("anita-gl-carousel-canvas");

        let b = new THREE.TextureLoader();
        if (window.location.protocol !== 'file:') {
            b.setCrossOrigin("anonymous");
        }
        b = b.load(ANITA_GL_BASE + "img/ground2.jpg");
        let c = { x: 16, y: 8 };
        b.wrapS = b.wrapT = THREE.RepeatWrapping;
        b.repeat.set(c.x, c.y);

        // The reflection re-renders the entire scene to this offscreen
        // texture every frame, so its resolution has an outsized effect on
        // frame cost - cap it in absolute pixels too, so a large/4K monitor
        // doesn't multiply the work just because the window is wide.
        let reflectionCap = this.isLowPower ? 0.6 : 1;
        let reflectionW = Math.min(a.box()[0] * a.options.reflection_q, 480 * reflectionCap);
        let reflectionH = Math.min(a.box()[1] * a.options.reflection_q, 320 * reflectionCap);
        this.ground = new THREE.Reflector(new THREE.PlaneGeometry(40, 20), {
            clipBias: .03,
            textureWidth: reflectionW,
            textureHeight: reflectionH,
            color: 8421504,
            shader: {
                // blurDir/blurQ cut from 16/4 (64 samples/pixel) to 8/2 (16
                // samples/pixel) - a 4x reduction in the blur's cost, which is
                // the most expensive part of the reflection when it does
                // render. The fragment shader's normalization below was
                // changed from a magic constant tuned to exactly 16/4 to a
                // proper sample-count average, so it stays correct at any
                // blurDir/blurQ instead of only working for one hardcoded pair.
                uniforms: { color: { value: null }, tDiffuse: { value: null }, textureMatrix: { value: null }, baseColor: { value: new THREE.Color(0) }, tNormal: { value: b }, tRough: { value: b }, tSize: { value: new THREE.Vector2(1024, 1024) }, repeat: { value: new THREE.Vector2(c.x, c.y) }, roughness: { value: 2 }, blurSize: { value: 8 }, blurDir: { value: 8 }, blurQ: { value: 2 }, mixP: { value: .5 } },
                vertexShader: `uniform mat4 textureMatrix;varying vec4 vUv;varying vec2 v_texCoord;void main(){vUv=textureMatrix*vec4(position,1.0);v_texCoord=uv;gl_Position=projectionMatrix*modelViewMatrix*vec4(position,1.0);}`,
                fragmentShader: `uniform vec3 color;uniform vec3 baseColor;uniform sampler2D tDiffuse;uniform sampler2D tRough;uniform sampler2D tNormal;uniform vec2 tSize;uniform vec2 repeat;uniform float roughness;uniform float blurSize;uniform float blurDir;uniform float blurQ;uniform float mixP;varying vec4 vUv;varying vec2 v_texCoord;float bof(float base,float blend){return(base<0.5?(2.0*base*blend):(1.0-2.0*(1.0-base)*(1.0-blend)));}vec3 bo(vec3 base,vec3 blend){return vec3(bof(base.r,blend.r),bof(base.g,blend.g),bof(base.b,blend.b));}vec4 gB( sampler2D image,vec2 uv,vec2 resolution,float dir,float quality,float size){float Pi=6.28318530718;vec4 color;vec2 radius=size/resolution.xy;float samples=0.0;for(float d=0.0;d<Pi;d+=Pi/dir){for(float i=1.0/quality;i<= 1.0;i+=1.0/quality){color+=texture2D(image,uv+vec2(cos(d),sin(d))*radius*i);samples+=1.0;}}color/=samples;return color;}void main(){vec4 s=vec4(0.0);vec2 ruv=vec2(v_texCoord*repeat);vec2 up2d=vec2(vUv.s/vUv.q,vUv.t/vUv.q);vec4 nT=texture2D(tNormal,ruv);float nP=0.05;float nX=nT.r*2.0-1.0;float nY=nT.g*2.0-1.0;up2d.x+=nX*nP;up2d.y+=nY*nP;vec4 rT=texture2D(tRough,ruv);float r_blur=blurSize*rT.b*roughness;vec4 rColor=gB(tDiffuse,up2d,tSize,blurDir,blurQ,r_blur);s=vec4(mix(baseColor,rColor.rgb,mixP),1.0);vec4 result = vec4(bo(s.rgb,color),1.0);gl_FragColor=result;}`
            }
        });
        this.ground.rotation.x = -0.5 * Math.PI;

        // THREE.UniformsUtils.clone() (used inside Reflector) deep-clones textures.
        // The ground texture is still loading at that point, so the clones capture an
        // empty image and never get needsUpdate when the JPEG arrives - leaving tNormal
        // and tRough sampling black, which offsets the reflection by nP and kills the
        // blur. Point the uniforms back at the live texture object.
        this.ground.material.uniforms.tNormal.value = b;
        this.ground.material.uniforms.tRough.value = b;

        // The reflection's onBeforeRender fully re-renders the scene into an
        // offscreen texture (then blurs it) on every single call - this is by
        // far the most expensive part of each frame, and it's what makes slide
        // drags and mouse-parallax feel laggy (they share the same main thread
        // and GPU budget as this).
        if (this.isLowPower) {
            // On phones/small screens, skip the expensive re-render (and its
            // blur pass) entirely - the reflection is barely visible on a
            // small screen anyway, and this is the single biggest cost in the
            // whole frame. The ground keeps its base color, just without a
            // live reflection.
            this.ground.onBeforeRender = function () {};
        } else {
            // On desktop, the reflection only needs to track the camera's
            // slow drift, so recomputing it every 3rd frame is visually
            // seamless but removes ~2/3 of this cost, leaving far more frame
            // budget for input handling.
            let reflectionSkip = 3;
            let reflectionFrame = 0;
            let renderReflection = this.ground.onBeforeRender.bind(this.ground);
            this.ground.onBeforeRender = function (renderer, scene, camera) {
                reflectionFrame++;
                if (reflectionFrame % reflectionSkip !== 0) return;
                renderReflection(renderer, scene, camera);
            };
        }

        let h = 0;
        this.gallery = new THREE.Group();
        this.$el.children(".anita-gl-gallery-item").each(function (slideIndex) {
            let c = jQuery(this),
                sz = c.attr("data-size") || "1440x1080",
                d = sz.split("x"),
                i = parseFloat(parseInt(d[0], 10) / parseInt(d[1], 10)).toFixed(3),
                b = a.getImageSize(i),
                // Intrinsic pixel size of the asset; falls back to the plane size
                // so slides without data-natural behave exactly as before.
                nat = (c.attr("data-natural") || sz).split("x"),
                f, swapToVideoTexture = null;
            if (c.hasClass("is-video")) {
                let videoAttrs = 'webkit-playsinline="true" playsinline="true" muted loop preload="none"';
                if (window.location.protocol !== 'file:') {
                    videoAttrs += ' crossorigin="anonymous"';
                }
                // The video's actual src is intentionally NOT set here: on a page
                // with heavy JS (three.js, jquery, aos) fighting for bandwidth, an
                // eager multi-MB video download on init competes with everything
                // else needed for first paint. We attach the element now (so the
                // VideoTexture exists immediately) but only start the network
                // fetch + playback once the browser is idle after first render -
                // and only for the initially active slide (index 0). Every other
                // video slide stays untouched (poster only) until changeSlide()
                // activates it, otherwise every video on the page would start
                // downloading and playing at once on load.
                let g = jQuery('<video ' + videoAttrs + '/>');
                g.attr('data-src', c.attr('data-src'));
                c.append(g);
                if (slideIndex === 0) {
                    let startVideo = function () {
                        if (g.attr('src')) return;
                        g.attr('src', g.attr('data-src'));
                        g[0].load();
                        try { g[0].play(); } catch (err) {}
                    };
                    if ('requestIdleCallback' in window) {
                        requestIdleCallback(startVideo, { timeout: 2000 });
                    } else {
                        setTimeout(startVideo, 300);
                    }
                }

                let videoTex = new THREE.VideoTexture(g[0]);
                videoTex.minFilter = THREE.LinearFilter;
                videoTex.magFilter = THREE.LinearFilter;
                videoTex.format = THREE.RGBAFormat;

                let posterSrc = c.attr("data-poster");
                // WiseUp plugin (2026-11-12): a slide with no poster (or whose poster fails) shows a dark title card
                // until its video has a frame, instead of a black plane; also what stays if the video can't load.
                let titleCard = function () {
                    let cv = document.createElement("canvas"), w = 1024, h = Math.max(64, Math.round(w / Math.max(.2, parseFloat(i) || 1.333))), x = cv.getContext("2d");
                    cv.width = w; cv.height = h;
                    let gr = x.createLinearGradient(0, 0, w, h); gr.addColorStop(0, "#1b1b20"); gr.addColorStop(1, "#0b0b0d");
                    x.fillStyle = gr; x.fillRect(0, 0, w, h);
                    let t = jQuery.trim(c.find(".anita-gl-gallery__caption").clone().children("sup").remove().end().text()) || "";
                    x.fillStyle = "rgba(255,255,255,.55)"; x.textAlign = "center"; x.textBaseline = "middle";
                    x.font = "700 " + Math.round(w / 14) + "px Rajdhani, 'Open Sans', sans-serif";
                    x.fillText(t, w / 2, h / 2, w * .86);
                    return cv;
                };
                if (posterSrc) {
                    // Show the lightweight poster instantly instead of a blank
                    // plane while the (much heavier) video is still deferred.
                    let posterImg = new Image();
                    if (window.location.protocol !== 'file:' && (/^https?:\/\//i.test(posterSrc) || /^\/\//.test(posterSrc))) {
                        posterImg.crossOrigin = "anonymous";
                    }
                    let posterTex = new THREE.Texture(posterImg);
                    posterImg.onload = function () { posterTex.needsUpdate = true; };
                    posterImg.onerror = function () { posterTex.image = titleCard(); posterTex.needsUpdate = true; };
                    posterImg.src = posterSrc;
                    f = posterTex;
                    swapToVideoTexture = function (mesh) {
                        g[0].addEventListener('loadeddata', function () {
                            mesh.material.uniforms.tDiffuse.value = videoTex;
                        }, { once: true });
                    };
                } else {
                    let cardTex = new THREE.Texture(titleCard());
                    cardTex.needsUpdate = true;
                    f = cardTex;
                    swapToVideoTexture = function (mesh) {
                        g[0].addEventListener('loadeddata', function () {
                            mesh.material.uniforms.tDiffuse.value = videoTex;
                        }, { once: true });
                    };
                }
            } else {
                let img = new Image();
                let src = c.attr("data-src");
                if (window.location.protocol !== 'file:' && (/^https?:\/\//i.test(src) || /^\/\//.test(src))) {
                    img.crossOrigin = "anonymous";
                }
                let tex = new THREE.Texture(img);
                img.onload = function() {
                    tex.needsUpdate = true;
                };
                img.src = src;
                if (img.complete) {
                    tex.needsUpdate = true;
                }
                f = tex;
            }
            let e = new THREE.Mesh(new THREE.PlaneGeometry(b[0], b[1]), new THREE.ShaderMaterial({
                uniforms: { time: { value: 1 }, tDiffuse: { value: f }, resolution: { value: new THREE.Vector2(parseInt(d[0], 10), parseInt(d[1], 10)) }, imgSize: { value: new THREE.Vector2(parseInt(nat[0], 10), parseInt(nat[1], 10)) }, fadeLevel: { value: 1.0 } },
                vertexShader: `varying vec2 v_texCoord;void main(){v_texCoord=uv;gl_Position=projectionMatrix*modelViewMatrix*vec4(position,1.0);}`,
                fragmentShader: `uniform vec2 resolution;uniform vec2 imgSize;uniform sampler2D tDiffuse;uniform float fadeLevel;varying vec2 v_texCoord;void main(){float pa=resolution.x/resolution.y;float ia=imgSize.x/imgSize.y;vec2 s=vec2(1.0);if(ia>pa){s.x=pa/ia;}else{s.y=ia/pa;}vec2 uv=(v_texCoord-0.5)*s+0.5;vec4 texColor=texture2D(tDiffuse,uv);float fl=clamp(fadeLevel, 0.4, 1.0);gl_FragColor=vec4(mix(texColor.rgb, vec3(0.0), 1.0 - fl), 1.0);}`
            }));
            if (swapToVideoTexture) swapToVideoTexture(e);
            0 === h ? h = 0 : h += .5 * parseFloat(b[0]);
            e.position.y = .5 * parseFloat(b[1]).toFixed(3);
            e.position.x = h;
            a.gallery.add(e);
            h += .5 * parseFloat(b[0]) + parseFloat(a.spacing);
            e.width = parseFloat(b[0]) + parseFloat(a.spacing);
            e.baseW = parseFloat(b[0]); e.baseH = parseFloat(b[1]); // unscaled size, for fitCards()
        });

        this.scene.add(this.ground);
        this.scene.add(this.gallery);
        this.active = 0;
        this.max = this.gallery.children.length - 1;
        this.$el.children(".anita-gl-gallery-item").eq(this.active).addClass("is-active");

        this.moveEvent = {
            active: !1, point: 0, path: 0, fullPath: 0, moved: !1,
            f_Start: function (b) {
                jQuery(b.target).is("a.anita-gallery-nav") ? a.moveEvent.active = !1 : a.moveEvent.active || (a.moveEvent.active = !0, b.touches ? a.moveEvent.point = b.touches[0].clientX : (a.moveEvent.point = b.clientX, a.$el.parent().addClass("is-grabbed")));
            },
            f_Move: function (b) {
                if (b.preventDefault(), a.moveEvent.active) {
                    if (b.touches ? (a.moveEvent.path = .5 * (a.moveEvent.point - b.touches[0].clientX), a.moveEvent.point = b.touches[0].clientX) : (a.moveEvent.path = .5 * (a.moveEvent.point - b.clientX), a.moveEvent.point = b.clientX), a.isPortrait ? a.gallery.position.x -= a.moveEvent.path * a.p2p * 2 : a.gallery.position.x -= a.moveEvent.path * a.p2p, a.moveEvent.fullPath += a.moveEvent.path, a.position.text_c -= a.moveEvent.path, a.gallery.position.x > a.gallery.children[0].position.x || a.gallery.position.x < -1 * a.gallery.children[a.max].position.x) {
                        if (a.gallery.position.x > a.gallery.children[0].position.x && a.moveEvent.path < 0) {
                            let c = (a.gallery.position.x - a.gallery.children[0].position.x) / (.25 * a.box()[0] * a.p2p);
                            a.isPortrait && (c *= 2), a.gallery.position.x += a.moveEvent.path * a.p2p * c, a.position.text_c += a.moveEvent.path;
                        }
                        if (a.gallery.position.x < -1 * a.gallery.children[a.max].position.x && a.moveEvent.path > 0) {
                            let d = (-1 * a.gallery.children[a.max].position.x - a.gallery.position.x) / (.25 * a.box()[0] * a.p2p);
                            a.isPortrait && (d *= 2), a.gallery.position.x += a.moveEvent.path * a.p2p * d, a.position.text_c += a.moveEvent.path;
                        }
                    }
                    a.elNative.style.transform = "translateX(" + a.position.text_c + "px)";
                }
            },
            f_End: function () {
                if (Math.abs(a.moveEvent.fullPath) > 50) {
                    let b = a.gallery.position.x + a.gallery.children[a.active].position.x;
                    b < -1 ? a.nextSlide() : b > 1 && a.prevSlide();
                }
                a.moveEvent.active = !1, a.moveEvent.point = 0, a.moveEvent.path = 0, a.moveEvent.fullPath = 0, a.$el.parent().removeClass("is-grabbed");
            }
        };

        jQuery(window).on("resize", function () { a.layout(); });
        this.isTouch = !1;
        this.$el.on("mouseenter", "a", function () { a.cameraFixed = !3; }).on("mouseleave", "a", function () { a.cameraFixed = !1; });

        jQuery(document).on("mousemove", function (b) {
            if (!a.isTouch && !a.cameraFixed) {
                let c = parseFloat(b.clientX - .5 * window.innerWidth) / (.5 * window.innerWidth).toFixed(3),
                    d = parseFloat(b.clientY - .5 * window.innerHeight) / (.5 * window.innerHeight).toFixed(3);
                a.position.camera_tM.offsetX = a.options.camera_move[0] * c;
                a.position.camera_tM.y = a.options.camera_height - a.options.camera_move[1] * d;
            }
        }).on("mouseleave", function () { a.position.camera_tM.y = a.options.camera_height; });

        this.$el.parent().on("mousedown", function (b) { a.isTouch || a.moveEvent.f_Start(b); });
        this.$el.parent().on("mousemove", function (b) { a.isTouch || a.moveEvent.f_Move(b); });
        this.$el.parent().on("mouseup", function (b) { a.moveEvent.f_End(); });
        this.$el.parent().on("mouseleave", function (b) { a.moveEvent.f_End(); });

        this.wheelTime = 0;
        this.$el.parent()[0].addEventListener("wheel", function (b) {
            b.timeStamp - a.wheelTime > a.options.wheelSensitive ? (b.deltaX > 0 && a.prevSlide(), b.deltaX < 0 && a.nextSlide(), b.deltaY > 0 && a.nextSlide(), b.deltaY < 0 && a.prevSlide()) : b.preventDefault();
            a.wheelTime = b.timeStamp;
        });

        this.$el.parent().on("touchstart", function (b) { a.isTouch = !0; a.moveEvent.f_Start(b); });
        this.$el.parent().on("touchmove", function (b) { a.moveEvent.f_Move(b); });
        this.$el.parent().on("touchend", function () { a.moveEvent.f_End(); });

        jQuery(document).on("keyup", function (b) {
            37 == b.keyCode && a.prevSlide();
            39 == b.keyCode && a.nextSlide();
            13 == b.keyCode && a.$el.children().eq(a.active).children().children("a").trigger("click");
            32 == b.keyCode && (a.cameraFixed ? a.cameraFixed = !1 : a.cameraFixed = !0);
        });

        this.$el.on("click", ".anita-album-link", function () { window.localStorage.setItem("anita_listing_index", a.active); });

        if (this.options.nav) {
            this.ui = {
                prev: jQuery('<a href="javascript:void(0)" class="anita-gallery-nav anita-gallery-nav__prev">' + (a.$el.attr("data-prev-label") ? "<span>" + a.$el.attr("data-prev-label") + "</span>" : "") + "</a>"),
                next: jQuery('<a href="javascript:void(0)" class="anita-gallery-nav anita-gallery-nav__next">' + (a.$el.attr("data-next-label") ? "<span>" + a.$el.attr("data-next-label") + "</span>" : "") + "</a>")
            };
            this.$el.after(this.ui.next).after(this.ui.prev);
            this.ui.prev.on("click", function () { a.prevSlide(); });
            this.ui.next.on("click", function () { a.nextSlide(); });
        }

        a.layout();
        this.changeSlide();
        this.$el.parent().addClass("is-loaded");
        setTimeout(function () { jQuery(a.renderer.domElement).addClass("is-loaded"); }, 100, a);
        this.anim = requestAnimationFrame(() => this.animate());
    }

    prevSlide() { this.active -= 1; this.active < 0 && (this.active = 0); this.changeSlide(); }
    nextSlide() { this.active += 1; this.active > this.max && (this.active = this.max); this.changeSlide(); }
    changeSlide() {
        this.$el.children(".is-active").children("video").length && this.$el.children(".is-active").children("video")[0].pause();
        this.$el.children(".is-active").removeClass("is-active");
        this.$el.children(".anita-gl-gallery-item").eq(this.active).addClass("is-active");
        this.$el.children(".is-active").children("video").length && (function (v) {
            if (!v.getAttribute('src') && v.getAttribute('data-src')) {
                v.setAttribute('src', v.getAttribute('data-src'));
                v.load();
            }
            try { v.play().catch(function () {}); } catch (err) {}
        })(this.$el.children(".is-active").children("video")[0]);
        // Fetch the next slide's video ahead (no playback) once this one can play through, so moving on starts at once.
        let curV = this.$el.children(".is-active").children("video")[0], nextV = this.$el.children(".anita-gl-gallery-item").eq(this.active + 1).children("video")[0];
        if (nextV && !nextV.getAttribute('src') && nextV.getAttribute('data-src')) {
            let warm = function () { if (!nextV.getAttribute('src')) { nextV.preload = 'auto'; nextV.setAttribute('src', nextV.getAttribute('data-src')); nextV.load(); } };
            curV && curV.readyState < 4 ? curV.addEventListener('canplaythrough', warm, { once: true }) : setTimeout(warm, 1200);
        }
        this.position.text_t = -1 * this.active * this.dimension.slideWidth;
        this.position.gallery_t = -1 * this.gallery.children[this.active].position.x;
        let a = this.active / this.max * 2 - 1;
        this.position.camera_tR.y = this.options.camera_angle * a;
        // the camera's sideways lean toward the ends of the row; none in portrait when portrait_fit is on, so the front
        // card is centred on a phone
        this.position.camera_tM.x = (this.isPortrait && this.options.portrait_fit ? 0 : .95) * a;
        // portrait (phones): the camera height eases per piece so the front card plus its caption block (caption_space)
        // sits vertically centred below the header; cards stand on one floor line, so a wide (short) card otherwise sat
        // low with an empty band above it (owner, 2026-11-13). The captions follow through the projection in animate().
        if (this.isPortrait && this.options.portrait_fit && this.options.caption_space && this.frameH) {
            let m = this.gallery.children[this.active], d = this.view_pos.def, T2 = 2 * d * Math.tan(this.camera.fov * Math.PI / 360), A = this.frameH,
                hp = (m.baseH || 0) * m.scale.y / T2 * A, top = Math.max(0, (A - hp - parseFloat(this.options.caption_space)) / 2);
            this.options.camera_height = ((top + hp) / A - .5) * T2;
            this.position.camera_tM.y = this.options.camera_height;
        }
        this.options.nav && (0 == this.active ? this.ui.prev.addClass("is-disabled") : this.ui.prev.removeClass("is-disabled"), this.active == this.max ? this.ui.next.addClass("is-disabled") : this.ui.next.removeClass("is-disabled"));
    }
    layout() {
        let [a, b] = this.box();
        this.frame();
        this.isPortrait = !(a > this.sceneH());
        this.isPortrait ? this.view_pos = { def: this.camera_distance.port_n, zoom: this.camera_distance.port_z } : this.view_pos = { def: this.camera_distance.land_n, zoom: this.camera_distance.land_z };
        this.renderer.setSize(a, b);
        this.frame();
        this.p2p = 2 * this.shv / this.sceneH();
        this.spacing = this.options.spacing * this.p2p;
        this.fitCards();
        this.dimension.slideWidth = this.$el.children(".anita-gl-gallery-item").width();
        this.changeSlide();
    }
    // Stop rendering (and the playing video) while the carousel is off screen; the page scrolls freely meanwhile.
    setPaused(p) {
        p = !!p;
        if (p === this.paused) return;
        this.paused = p;
        let v = this.$el.children(".is-active").children("video")[0];
        if (v) p ? v.pause() : v.getAttribute('src') && v.play().catch(function () {});
        if (!p) this.prevTime = this.clock.getElapsedTime();
    }
    // WiseUp plugin (2026-11-13, "make it mobile responsive"): cards are sized by height, so in a portrait frame a 16:9
    // card came out wider than the screen. With options.portrait_fit (a fraction of the visible width), each card is
    // scaled down in portrait until it fits, bottoms kept on the floor, and the row re-spaced; landscape is unchanged.
    fitCards() {
        let fit = this.isPortrait ? parseFloat(this.options.portrait_fit) || 0 : 0, maxW = Infinity, x = 0, sp = parseFloat(this.spacing) || 0;
        if (fit) maxW = fit * 2 * this.view_pos.def * Math.tan(this.camera.fov * Math.PI / 360) * (this.box()[0] / this.sceneH());
        this.gallery.children.forEach(function (m, k) {
            if (!m.baseW) return;
            let sc = Math.min(1, maxW / m.baseW), mw = m.baseW * sc;
            m.scale.set(sc, sc, 1);
            if (k) x += .5 * mw;
            m.position.x = x;
            m.position.y = .5 * m.baseH * sc;
            x += .5 * mw + sp;
        });
    }
    getImageSize(a = 1) {
        a = parseFloat(a).toFixed(3);
        let b = parseFloat(2 * this.shv * this.options.size).toFixed(3);
        return [parseFloat(b * a).toFixed(3), b];
    }
    animate() {
        let b = this;
        this.anim = requestAnimationFrame(() => this.animate());
        // Skip the (expensive: full extra scene render + blur pass) frame
        // entirely while the tab is in the background - there's nothing to
        // see, and letting it run wastes CPU/GPU and can leave the browser
        // catching up (visible as a stutter) when the tab is refocused.
        if (document.hidden || this.paused) return; // tab hidden, or the carousel scrolled off screen (setPaused)
        let c = this.clock.getElapsedTime(), a = c - this.prevTime;
        this.prevTime = c;
        b.moveEvent.active || (this.gallery.position.x += (this.position.gallery_t - this.gallery.position.x) * 2 * a);
        this.cameraFixed ? (this.camera.rotation.x += (.07 - this.camera.rotation.x) * a, this.camera.rotation.y += (0 - this.camera.rotation.y) * a, this.camera.rotation.z = 0) : (this.camera.rotation.x += (this.position.camera_tR.x - this.camera.rotation.x) * a, this.camera.rotation.y += (this.position.camera_tR.y - this.camera.rotation.y) * a, this.camera.rotation.z = 0, this.camera.rotation.x > .07 ? this.camera.rotation.x = .07 : this.camera.rotation.x < -0.1 && (this.camera.rotation.x = -0.1), this.camera.rotation.y > this.options.camera_angle ? this.camera.rotation.y = this.options.camera_angle : this.camera.rotation.y < -1 * this.options.camera_angle && (this.camera.rotation.y = -1 * this.options.camera_angle));
        this.cameraFixed ? (this.camera.position.x += (0 - this.camera.position.x) * a, this.camera.position.y += (2.4 - this.camera.position.y) * a, this.camera.position.z += (this.view_pos.zoom - this.camera.position.z) * a) : jQuery("body").hasClass("anita-show-menu") ? (this.camera.position.x += (this.position.camera_tM.x + b.position.camera_tM.offsetX - this.camera.position.x) * a, this.camera.position.y += (this.position.camera_tM.y - this.camera.position.y) * a, this.camera.position.z += (this.view_pos.zoom - this.camera.position.z) * a * 2) : (this.camera.position.x += (this.position.camera_tM.x + b.position.camera_tM.offsetX - this.camera.position.x) * a, this.camera.position.y += (this.position.camera_tM.y - this.camera.position.y) * a, this.camera.position.z += (this.view_pos.def - this.camera.position.z) * a, this.camera.position.y > this.options.camera_height + this.options.camera_move[1] ? this.camera.position.y = this.options.camera_move[1] + this.options.camera_height : this.camera.position.y < this.options.camera_height - this.options.camera_move[1] && (this.camera.position.y = this.options.camera_height - this.options.camera_move[1]), this.camera.position.z > Math.max(this.camera_distance.port_n, this.camera_distance.land_n) ? this.camera.position.z = Math.max(this.camera_distance.port_n, this.camera_distance.land_n) : this.camera.position.z < this.camera_distance.land_z && (this.camera.position.z = this.camera_distance.land_z));
        jQuery(this.gallery.children).each(function (a) {
            a !== b.active && this.material.uniforms.fadeLevel.value > .3 && (this.material.uniforms.fadeLevel.value -= (this.material.uniforms.fadeLevel.value - .3) * .05);
        });
        this.gallery.children[this.active].material.uniforms.fadeLevel.value < 1 && (this.gallery.children[this.active].material.uniforms.fadeLevel.value += (1 - this.gallery.children[this.active].material.uniforms.fadeLevel.value) * .05);
        if (!b.moveEvent.active) {
            let d = this.position.text_t - this.position.text_c, e = this.position.text_c;
            .01 > Math.abs(d) ? this.position.text_c += 0 : this.position.text_c += (1 - Math.pow(.97, Math.min(a, .1) * 60)) * d; // time-based (was .03 per frame): the captions keep up with the cards at any frame rate
        }
        // WiseUp plugin (2026-11-13, "text not coming under correct place"): the captions sit at the centre of the screen,
        // but the camera leans toward the ends of the row and follows the mouse, so the front card is rarely centred.
        // Each frame the point where a settled front card's bottom centre is (world 0,0,0) is projected to the screen
        // and the caption strip is moved by its offset, so the title stays right under its card.
        if (this.boxWH) {
            this.camera.updateMatrixWorld();
            let pv = this.capV || (this.capV = new THREE.Vector3()), bw = this.boxWH[0], bh = this.boxWH[1];
            pv.set(0, 0, 0).project(this.camera);
            let dx = (pv.x + 1) / 2 * bw - bw / 2, dy = (1 - pv.y) / 2 * bh - this.frameTop - this.cardBottomPx,
                tf = "translate(" + (this.position.text_c + dx).toFixed(1) + "px," + dy.toFixed(1) + "px)";
            tf !== this.capTf && (this.elNative.style.transform = this.capTf = tf);
        } else {
            this.elNative.style.transform = "translateX(" + this.position.text_c + "px)";
        }
        this.renderer.render(this.scene, this.camera);
    }
}