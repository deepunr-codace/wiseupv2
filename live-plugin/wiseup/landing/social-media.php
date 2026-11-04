<?php
/*
Template Name: Social Media Marketing (Kerala)
*/

namespace Kadence;

if (!defined('ABSPATH')) {
    exit;
}

// Tell LiteSpeed's server-level page cache to never cache this template, so
// edits here go live immediately without needing a manual cache purge.
if (!headers_sent()) {
    header('X-LiteSpeed-Cache-Control: no-cache');
}

$smm_assets = WISEUP_URL . 'assets/smm/'; // served by the Wiseup plugin

wiseup_landing_open( 'wu-landing wu-smm-page' );
?>

<div id="primary" class="content-area">
    <div class="content-container site-container">
        <div id="main" class="site-main">
            <div class="content-wrap">

                <style>
                    /* Design ported from a bespoke full-fidelity mockup built for this
                       page (dark theme, lime-green #C2F760 accent, Epilogue font) -
                       the site's real header/footer wrap it, everything else below
                       is this page's own design. */
                    #wu-smm {
                        font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', sans-serif;
                        background: #000;
                        color: #fff;
                        overflow-x: clip;
                        position: relative;
                    }

                    #wu-smm * {
                        box-sizing: border-box;
                    }

                    #wu-smm a {
                        color: #D2EAA6;
                        text-decoration: none;
                    }

                    #wu-smm a:hover {
                        color: #C2F760;
                    }

                    #wu-smm h1,
                    #wu-smm h2,
                    #wu-smm h3,
                    #wu-smm p,
                    #wu-smm figure,
                    #wu-smm blockquote {
                        margin: 0;
                    }

                    /* Kadence's own theme CSS sets a hardcoded dark color on every
                       h1-h3 element site-wide, which otherwise overrides this
                       page's inherited white/dark text by specificity. Forcing
                       inherit here restores this design's own color cascade
                       (white on dark sections, dark on the light bento/strategy
                       sections) exactly as authored. */
                    #wu-smm h1,
                    #wu-smm h2,
                    #wu-smm h3 {
                        color: inherit;
                    }

                    #wu-smm ::selection {
                        background: #C2F760;
                        color: #000;
                    }

                    #wu-smm img {
                        -webkit-user-drag: none;
                        max-width: 100%;
                    }

                    #wu-smm-progress {
                        position: fixed;
                        left: 0;
                        top: 0;
                        height: 2px;
                        width: 100%;
                        transform-origin: 0 50%;
                        transform: scaleX(0);
                        background: linear-gradient(90deg, #6E8A22, #C2F760, #F1F9B8);
                        box-shadow: 0 0 12px rgba(194, 247, 96, .7);
                        z-index: 1000;
                        pointer-events: none;
                    }

                    #wu-smm #wu-smm-totop {
                        position: fixed;
                        right: 24px;
                        bottom: 24px;
                        z-index: 600;
                        width: 52px;
                        height: 52px;
                        border-radius: 50%;
                        background: rgba(14, 18, 6, .7);
                        backdrop-filter: blur(12px);
                        border: 1px solid rgba(194, 247, 96, .35);
                        color: #C2F760;
                        display: grid;
                        place-items: center;
                        opacity: 0;
                        transform: translateY(16px);
                        pointer-events: none;
                        transition: opacity .4s, transform .4s, background .3s, color .3s;
                    }

                    #wu-smm #wu-smm-totop:hover {
                        background: #C2F760;
                        color: #0E1206;
                    }

                    #wu-smm .wu-section {
                        position: relative;
                    }

                    #wu-smm .wu-inner {
                        max-width: 1240px;
                        margin: 0 auto;
                        padding: 0 clamp(20px, 4vw, 40px);
                    }

                    #wu-smm .wu-eyebrow {
                        align-self: flex-start;
                        display: inline-flex;
                        align-items: center;
                        gap: 12px;
                        font-size: 13px;
                        font-weight: 500;
                        line-height: 1;
                        letter-spacing: .14em;
                        text-transform: uppercase;
                        color: #C2F760;
                    }

                    #wu-smm .wu-eyebrow .wu-eyebrow-line {
                        width: 36px;
                        height: 1.5px;
                        border-radius: 2px;
                        background: linear-gradient(90deg, rgba(194, 247, 96, 0), #C2F760);
                    }

                    #wu-smm h2.wu-h2 {
                        font-size: clamp(36px, 4.4vw, 64px);
                        font-weight: 400;
                        letter-spacing: -0.05em;
                        line-height: .98;
                        text-wrap: balance;
                    }

                    #wu-smm h2.wu-h2 .wu-hl {
                        color: #D2EAA6;
                    }

                    #wu-smm [data-reveal] {
                        will-change: transform, opacity;
                    }

                    /* HERO */
                    #wu-smm-hero {
                        position: relative;
                        /* Clamped instead of a raw 100vh: behaves identically to
                           100vh across normal viewport heights (confirmed at
                           1920x1080 and other real sizes), but caps the range so
                           it can't compute to an extreme value on an unusual
                           display/zoom combination. */
                        min-height: clamp(640px, 100vh, 1300px);
                        padding: 150px clamp(20px, 4vw, 40px) 80px;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        gap: 56px;
                        background: radial-gradient(60% 55% at 85% 8%, rgba(194, 247, 96, .20) 0%, rgba(194, 247, 96, 0) 70%), radial-gradient(55% 50% at 8% 95%, rgba(110, 138, 34, .28) 0%, rgba(110, 138, 34, 0) 70%), linear-gradient(160deg, #0b0d07 0%, #10140a 45%, #060705 100%);
                        overflow: hidden;
                    }

                    /* Video paints over the poster/gradient fallback above once it
                       can play; as a flex item placed first in the markup it
                       naturally stacks under every other hero child (grain,
                       copy, fan images, scroll cue) without needing z-index. */
                    #wu-smm-hero .wu-hero-video {
                        position: absolute;
                        inset: 0;
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        pointer-events: none;
                    }

                    #wu-smm-hero .wu-hero-video-overlay {
                        position: absolute;
                        inset: 0;
                        background: linear-gradient(180deg, rgba(10, 11, 8, .62), rgba(10, 11, 8, .78));
                        pointer-events: none;
                    }

                    .wu-blob {
                        position: absolute;
                        border-radius: 50%;
                        pointer-events: none;
                        filter: blur(40px);
                    }

                    #wu-smm-hero .wu-grain {
                        position: absolute;
                        inset: 0;
                        background: repeating-linear-gradient(90deg, rgba(255, 255, 255, .025) 0 1px, transparent 1px 4px);
                        pointer-events: none;
                    }

                    #wu-smm-hero .wu-fade-bottom {
                        position: absolute;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        height: 40%;
                        background: linear-gradient(180deg, rgba(0, 0, 0, 0), #000);
                        pointer-events: none;
                    }

                    .wu-scroll-cue {
                        position: relative;
                        z-index: 3;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        gap: 10px;
                        font-size: 11px;
                        letter-spacing: .24em;
                        text-transform: uppercase;
                        color: rgba(255, 255, 255, .55);
                    }

                    #wu-smm .wu-scroll-cue {
                        color: rgba(255, 255, 255, .55);
                    }

                    #wu-smm .wu-scroll-cue:hover {
                        color: #C2F760;
                    }

                    .wu-scroll-cue .wu-cue-pill {
                        width: 24px;
                        height: 38px;
                        border-radius: 999px;
                        border: 1.5px solid currentColor;
                        display: flex;
                        justify-content: center;
                        padding-top: 7px;
                    }

                    .wu-scroll-cue .wu-cue-dot {
                        width: 3px;
                        height: 8px;
                        border-radius: 3px;
                        background: #C2F760;
                    }

                    #wu-smm-hero .wu-hero-copy {
                        position: relative;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        text-align: center;
                        gap: 28px;
                        max-width: 980px;
                    }

                    .wu-badge-pill {
                        display: inline-flex;
                        align-items: center;
                        gap: 10px;
                        padding: 8px 18px 8px 10px;
                        border-radius: 999px;
                        background: rgba(0, 0, 0, .55);
                        border: 1px solid rgba(255, 255, 255, .1);
                        backdrop-filter: blur(10px);
                        font-size: 13.5px;
                        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .06);
                    }

                    .wu-badge-dot {
                        width: 16px;
                        height: 16px;
                        border-radius: 50%;
                        background: radial-gradient(circle, #E9F98A 0%, #9DBA35 70%);
                        box-shadow: 0 0 12px #C2F760;
                    }

                    #wu-smm-hero h2.wu-hero-title {
                        font-size: clamp(40px, 6.4vw, 92px);
                        letter-spacing: -0.05em;
                        word-spacing: 0.02em;
                        font-weight: 400;
                        text-wrap: balance;
                        line-height: .98;
                    }

                    #wu-smm-hero h2.wu-hero-title [data-word] {
                        display: inline-block;
                    }

                    .wu-shine {
                        display: inline-block;
                        background: linear-gradient(100deg, #D2EAA6 0%, #D2EAA6 40%, #F6FFD9 50%, #D2EAA6 60%, #D2EAA6 100%);
                        background-size: 250% 100%;
                        -webkit-background-clip: text;
                        background-clip: text;
                        color: transparent;
                        padding-right: .04em;
                    }

                    #wu-smm-hero .wu-h-lede1 {
                        font-size: clamp(18px, 2vw, 26px);
                        line-height: 1.3;
                        font-weight: 300;
                        color: #fff;
                    }

                    #wu-smm-hero .wu-h-lede2 {
                        font-size: 17px;
                        line-height: 1.65;
                        color: rgba(255, 255, 255, .82);
                        max-width: 680px;
                        text-wrap: pretty;
                    }

                    .wu-cta-row {
                        display: flex;
                        gap: 14px;
                        flex-wrap: wrap;
                        justify-content: center;
                    }

                    #wu-smm .wu-btn-primary {
                        display: inline-flex;
                        align-items: center;
                        gap: 10px;
                        padding: 16px 28px;
                        border-radius: 999px;
                        background: radial-gradient(120% 160% at 50% 0%, #F1EDB6 0%, #B9D253 42%, #5F6C27 100%);
                        color: #0E1206;
                        font-weight: 600;
                        font-size: 16px;
                        box-shadow: 0 0 0 1px rgba(210, 234, 166, .45), 0 12px 34px -10px rgba(185, 210, 83, .7);
                        transition: box-shadow .35s;
                    }

                    #wu-smm .wu-btn-primary:hover {
                        color: #0E1206;
                        box-shadow: 0 0 0 1px rgba(210, 234, 166, .7), 0 18px 40px -10px rgba(185, 210, 83, .9);
                    }

                    #wu-smm .wu-btn-primary .wu-arrow {
                        width: 32px;
                        height: 32px;
                        margin-right: -14px;
                        border-radius: 50%;
                        background: #0E1206;
                        color: #D9F57A;
                        display: grid;
                        place-items: center;
                        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .18), 0 4px 10px -2px rgba(0, 0, 0, .45);
                    }

                    #wu-smm .wu-btn-ghost {
                        display: inline-flex;
                        align-items: center;
                        padding: 16px 28px;
                        border-radius: 999px;
                        border: 1px solid rgba(255, 255, 255, .28);
                        background: rgba(255, 255, 255, .03);
                        backdrop-filter: blur(8px);
                        color: #fff;
                        font-size: 16px;
                        transition: border-color .3s, color .3s, background .3s;
                    }

                    #wu-smm .wu-btn-ghost:hover {
                        border-color: #C2F760;
                        color: #C2F760;
                        background: rgba(194, 247, 96, .06);
                    }

                    [data-magnetic] {
                        transition: translate .35s cubic-bezier(.2, .8, .2, 1);
                    }

                    .wu-hero-fan {
                        position: relative;
                        width: 100%;
                        max-width: 1240px;
                        display: flex;
                        justify-content: center;
                        align-items: flex-start;
                        gap: clamp(8px, 1.4vw, 20px);
                    }

                    .wu-hero-fan>div {
                        min-width: 0;
                    }

                    .wu-hero-fan img {
                        width: 100%;
                        aspect-ratio: 3/4;
                        object-fit: cover;
                        border-radius: 18px;
                        display: block;
                        box-shadow: 0 30px 60px -20px #000;
                        transition: transform .6s cubic-bezier(.2, .8, .2, 1), box-shadow .6s;
                    }

                    .wu-hero-fan img:hover {
                        transform: rotate(0deg) scale(1.06) translateY(-10px) !important;
                        box-shadow: 0 0 0 1px rgba(194, 247, 96, .5), 0 40px 80px -20px rgba(194, 247, 96, .35);
                    }

                    @media (max-width: 860px) {
                        .wu-hero-fan {
                            display: none;
                        }
                    }

                    /* LOGO STRIP - flat, calm horizontal strip that blends into
                       the rest of the dark page instead of cutting across it
                       with a diagonal neon band. */
                    #wu-smm-logoband {
                        position: relative;
                        background: #0A0A0A;
                        border-top: 1px solid rgba(255, 255, 255, .08);
                        border-bottom: 1px solid rgba(255, 255, 255, .08);
                        overflow: hidden;
                    }

                    #wu-smm-logoband .wu-strip {
                        padding: 30px 0;
                        /* Fade the first/last logos into the edges rather than
                           cutting them off hard. */
                        -webkit-mask: linear-gradient(90deg, transparent, #000 6%, #000 94%, transparent);
                        mask: linear-gradient(90deg, transparent, #000 6%, #000 94%, transparent);
                    }

                    [data-marquee] {
                        display: flex;
                        width: max-content;
                        align-items: center;
                    }

                    /* The logo band and testimonials sections both reuse
                       [data-marquee], but want different spacing - logos need
                       generous breathing room, testimonial cards are already
                       self-contained with their own width. */
                    #wu-smm-logoband [data-marquee] {
                        gap: 56px;
                        padding-right: 56px;
                    }

                    .wu-marquee-mask [data-marquee] {
                        gap: 16px;
                        padding-right: 16px;
                    }

                    /* Each logo gets the same bounding box regardless of its
                       own aspect ratio, so a bold wide wordmark and a thin
                       narrow one read as the same visual weight instead of
                       one dominating and another nearly disappearing. White
                       and dimmed by default - a quiet, monochrome logo wall
                       that recedes into the dark strip rather than a bright
                       graphic competing with the page around it. */
                    #wu-smm-logoband [data-marquee] img {
                        height: 24px;
                        max-width: 110px;
                        width: auto;
                        object-fit: contain;
                        filter: brightness(0) invert(1);
                        opacity: .4;
                        transition: opacity .4s, transform .4s;
                    }

                    #wu-smm-logoband [data-marquee] img:hover {
                        opacity: 1;
                        transform: scale(1.08);
                    }

                    /* VISIBILITY */
                    #wu-smm-visibility .wu-inner {
                        padding-top: clamp(80px, 10vw, 130px);
                        padding-bottom: clamp(80px, 10vw, 130px);
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(min(100%, 460px), 1fr));
                        gap: 64px;
                        align-items: center;
                    }

                    #wu-smm-visibility .wu-visibility-copy {
                        display: flex;
                        flex-direction: column;
                        gap: 28px;
                    }

                    #wu-smm-visibility .wu-lede-big {
                        font-size: clamp(20px, 1.8vw, 24px);
                        line-height: 1.45;
                        font-weight: 300;
                        text-wrap: pretty;
                    }

                    #wu-smm-visibility .wu-lede-sm {
                        font-size: 17px;
                        line-height: 1.7;
                        color: rgba(255, 255, 255, .75);
                        text-wrap: pretty;
                    }

                    #wu-smm-visibility .wu-visibility-img {
                        position: relative;
                        border-radius: 20px;
                        overflow: hidden;
                        aspect-ratio: 4/3.4;
                        background: #111;
                    }

                    #wu-smm-visibility .wu-visibility-img img {
                        position: absolute;
                        left: 0;
                        top: -10%;
                        width: 100%;
                        height: 120%;
                        object-fit: cover;
                    }

                    /* SERVICES SHOWCASE */
                    #wu-smm-services .wu-inner {
                        padding-top: clamp(40px, 5vw, 60px);
                        padding-bottom: clamp(90px, 10vw, 130px);
                        display: flex;
                        flex-direction: column;
                        gap: 48px;
                    }

                    .wu-sec-head {
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(min(100%, 420px), 1fr));
                        gap: 32px;
                        align-items: end;
                    }

                    .wu-sec-head-left {
                        display: flex;
                        flex-direction: column;
                        gap: 24px;
                    }

                    .wu-sec-head-right {
                        font-size: 17px;
                        line-height: 1.7;
                        color: rgba(255, 255, 255, .75);
                        text-wrap: pretty;
                    }

                    #wu-smm-svc-wrap {
                        display: flex;
                        flex-direction: row;
                        gap: 12px;
                        height: 580px;
                    }

                    #wu-smm-svc-wrap.is-narrow {
                        flex-direction: column;
                        height: auto;
                    }

                    .wu-svc-panel {
                        position: relative;
                        min-width: 0;
                        min-height: 0;
                        border-radius: 24px;
                        overflow: hidden;
                        cursor: pointer;
                        background: #0E0E0E;
                        border: 1px solid rgba(255, 255, 255, .08);
                        flex: 1 1 0%;
                        height: auto;
                        transition: flex .8s cubic-bezier(.2, .8, .2, 1), height .8s cubic-bezier(.2, .8, .2, 1), border-color .5s;
                    }

                    .wu-svc-panel.is-active {
                        flex: 5 1 0%;
                        border-color: rgba(194, 247, 96, .45);
                    }

                    #wu-smm-svc-wrap.is-narrow .wu-svc-panel {
                        flex: 0 0 auto;
                        height: 84px;
                    }

                    #wu-smm-svc-wrap.is-narrow .wu-svc-panel.is-active {
                        height: 440px;
                    }

                    .wu-svc-img {
                        position: absolute;
                        inset: 0;
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        transform: scale(1.08);
                        filter: grayscale(.9) brightness(.45);
                        transition: transform 1.4s cubic-bezier(.2, .7, .2, 1), filter .8s;
                    }

                    .wu-svc-panel.is-active .wu-svc-img {
                        transform: scale(1);
                        filter: grayscale(0) brightness(1);
                    }

                    .wu-svc-shade {
                        position: absolute;
                        inset: 0;
                        background: linear-gradient(180deg, rgba(0, 0, 0, .35), rgba(0, 0, 0, .6));
                        transition: background .8s;
                    }

                    .wu-svc-panel.is-active .wu-svc-shade {
                        background: linear-gradient(180deg, rgba(0, 0, 0, .15) 0%, rgba(0, 0, 0, 0) 35%, rgba(0, 0, 0, .88) 100%);
                    }

                    .wu-svc-top {
                        position: absolute;
                        left: 0;
                        right: 0;
                        top: 0;
                        padding: 22px;
                        display: flex;
                        justify-content: space-between;
                        align-items: flex-start;
                    }

                    .wu-svc-num {
                        font-size: 13px;
                        font-weight: 500;
                        letter-spacing: .1em;
                        color: #C2F760;
                        padding: 7px 11px;
                        border-radius: 999px;
                        background: rgba(0, 0, 0, .55);
                        backdrop-filter: blur(8px);
                        border: 1px solid rgba(194, 247, 96, .25);
                    }

                    .wu-svc-arrow {
                        width: 42px;
                        height: 42px;
                        border-radius: 50%;
                        background: #C2F760;
                        color: #0E1206;
                        display: grid;
                        place-items: center;
                        opacity: 0;
                        transform: rotate(-45deg) scale(.6);
                        transition: opacity .5s, transform .6s;
                    }

                    .wu-svc-panel.is-active .wu-svc-arrow {
                        opacity: 1;
                        transform: rotate(0deg) scale(1);
                    }

                    .wu-svc-vertlabel {
                        position: absolute;
                        left: 0;
                        bottom: 0;
                        padding: 22px;
                        opacity: 1;
                        transition: opacity .4s;
                        pointer-events: none;
                        writing-mode: vertical-rl;
                        transform: rotate(180deg);
                    }

                    #wu-smm-svc-wrap.is-narrow .wu-svc-vertlabel {
                        left: 64px;
                        bottom: 10px;
                        writing-mode: horizontal-tb;
                        transform: none;
                    }

                    .wu-svc-panel.is-active .wu-svc-vertlabel {
                        opacity: 0;
                    }

                    .wu-svc-vertlabel span {
                        display: block;
                        font-size: 20px;
                        font-weight: 400;
                        letter-spacing: -0.02em;
                        white-space: nowrap;
                        color: #fff;
                    }

                    .wu-svc-body {
                        position: absolute;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        padding: clamp(22px, 2.6vw, 32px);
                        display: flex;
                        flex-direction: column;
                        gap: 14px;
                        opacity: 0;
                        transform: translateY(24px);
                        transition: opacity .6s .15s, transform .8s cubic-bezier(.2, .8, .2, 1) .1s;
                    }

                    .wu-svc-panel.is-active .wu-svc-body {
                        opacity: 1;
                        transform: translateY(0);
                    }

                    .wu-svc-body h3 {
                        font-size: clamp(26px, 2.6vw, 38px);
                        font-weight: 400;
                        letter-spacing: -0.035em;
                        line-height: 1.1;
                        max-width: 440px;
                    }

                    .wu-svc-body p {
                        font-size: 15.5px;
                        line-height: 1.65;
                        color: rgba(255, 255, 255, .8);
                        max-width: 460px;
                    }

                    .wu-tag-row {
                        display: flex;
                        gap: 8px;
                        flex-wrap: wrap;
                    }

                    .wu-tag {
                        padding: 7px 13px;
                        border-radius: 999px;
                        background: rgba(255, 255, 255, .08);
                        backdrop-filter: blur(10px);
                        border: 1px solid rgba(255, 255, 255, .16);
                        font-size: 12.5px;
                        color: #fff;
                    }

                    /* PLATFORMS */
                    #wu-smm-platforms .wu-inner {
                        padding-top: clamp(40px, 5vw, 60px);
                        padding-bottom: clamp(90px, 10vw, 130px);
                        display: flex;
                        flex-direction: column;
                        gap: 48px;
                    }

                    .wu-platform-list {
                        display: flex;
                        flex-direction: column;
                        border-top: 1px solid rgba(255, 255, 255, .15);
                    }

                    #wu-smm .wu-platform-row {
                        display: grid;
                        grid-template-columns: minmax(0, 1.1fr) minmax(0, 1.3fr) 48px;
                        gap: 24px;
                        align-items: center;
                        padding: 30px 20px;
                        border-bottom: 1px solid rgba(255, 255, 255, .12);
                        color: #fff;
                        transition: background .45s cubic-bezier(.2, .8, .2, 1), color .3s, padding .45s cubic-bezier(.2, .8, .2, 1);
                    }

                    #wu-smm .wu-platform-row:hover {
                        background: #C2F760;
                        color: #000;
                        padding-left: 36px;
                    }

                    #wu-smm .wu-platform-row h3 {
                        font-size: clamp(24px, 2.6vw, 36px);
                        font-weight: 400;
                        letter-spacing: -0.035em;
                        line-height: 1.1;
                    }

                    #wu-smm .wu-platform-row p {
                        font-size: 16px;
                        line-height: 1.6;
                        opacity: .8;
                    }

                    #wu-smm .wu-platform-row .wu-circle-arrow {
                        width: 44px;
                        height: 44px;
                        border-radius: 50%;
                        border: 1.5px solid currentColor;
                        display: grid;
                        place-items: center;
                    }

                    /* CONTENT BENTO */
                    #wu-smm-content {
                        background: #fff;
                        color: #0A0A0A;
                        border-radius: 32px 32px 0 0;
                        padding: 110px 0;
                    }

                    #wu-smm-content .wu-inner {
                        display: flex;
                        flex-direction: column;
                        gap: 56px;
                    }

                    #wu-smm-content .wu-eyebrow {
                        color: #5F7A16;
                    }

                    #wu-smm-content .wu-eyebrow .wu-eyebrow-line {
                        background: linear-gradient(90deg, rgba(95, 122, 22, 0), #5F7A16);
                    }

                    #wu-smm-content .wu-sec-head-right {
                        color: #3D3D3D;
                    }

                    .wu-bento {
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(min(100%, 300px), 1fr));
                        gap: 16px;
                        grid-auto-flow: dense;
                    }

                    .wu-bento-card {
                        position: relative;
                        border-radius: 18px;
                        overflow: hidden;
                        min-height: 320px;
                        display: flex;
                        flex-direction: column;
                    }

                    .wu-bento-card.wu-tall {
                        grid-row: span 2;
                    }

                    .wu-bento-card img.wu-bg {
                        position: absolute;
                        inset: 0;
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        transition: transform .8s;
                    }

                    .wu-bento-card:hover img.wu-bg {
                        transform: scale(1.06);
                    }

                    .wu-bento-overlay {
                        position: relative;
                        margin-top: auto;
                        padding: 28px;
                        background: linear-gradient(180deg, rgba(0, 0, 0, 0), rgba(0, 0, 0, .85));
                        display: flex;
                        flex-direction: column;
                        gap: 8px;
                        pointer-events: none;
                    }

                    .wu-bento-card h3 {
                        font-size: 24px;
                        font-weight: 500;
                        letter-spacing: -0.035em;
                        line-height: 1.1;
                    }

                    .wu-bento-card p {
                        font-size: 15px;
                        line-height: 1.55;
                    }

                    .wu-bento-dark {
                        background: #0A0A0A;
                        color: #fff;
                        justify-content: flex-end;
                    }

                    .wu-bento-reel {
                        background: #FAF2F2;
                        padding: 28px;
                        gap: 20px;
                        align-items: center;
                        text-align: center;
                    }

                    .wu-bento-reel img {
                        width: 100%;
                        max-width: 300px;
                        flex: 1;
                        min-height: 360px;
                        object-fit: cover;
                        border-radius: 28px;
                        background: #000;
                    }

                    .wu-bento-caption {
                        background: #FAF2F2;
                        padding: 28px;
                        gap: 14px;
                    }

                    .wu-bento-caption p {
                        color: #3D3D3D;
                    }

                    .wu-mock-dm {
                        margin-top: auto;
                        background: #fff;
                        border-radius: 14px;
                        padding: 18px;
                        display: flex;
                        flex-direction: column;
                        gap: 10px;
                        box-shadow: 0 10px 30px -15px rgba(0, 0, 0, .25);
                    }

                    .wu-mock-dm-head {
                        display: flex;
                        align-items: center;
                        gap: 10px;
                    }

                    .wu-mock-dm-avatar {
                        flex: none;
                        width: 30px;
                        height: 30px;
                        border-radius: 50%;
                        background: radial-gradient(circle, #E9F98A, #7D9A2A);
                    }

                    .wu-bento-interactive img {
                        width: 100%;
                        height: 190px;
                        object-fit: cover;
                        display: block;
                    }

                    .wu-bento-interactive .wu-bento-pad {
                        padding: 24px 28px;
                        display: flex;
                        flex-direction: column;
                        gap: 8px;
                    }

                    .wu-bento-interactive {
                        background: #FAF2F2;
                    }

                    .wu-bento-campaign {
                        background: #3F4A14;
                        color: #fff;
                        justify-content: flex-end;
                    }

                    .wu-bento-campaign img.wu-bg {
                        opacity: .75;
                    }

                    /* STRATEGY */
                    #wu-smm-strategy {
                        position: relative;
                        background: radial-gradient(60% 80% at 15% 30%, #FFF8D9 0%, rgba(255, 248, 217, 0) 70%), radial-gradient(50% 70% at 85% 70%, #F7FBE6 0%, rgba(247, 251, 230, 0) 70%), #fff;
                        color: #0A0A0A;
                        padding: 110px 0;
                        overflow: hidden;
                    }

                    .wu-spin-deco {
                        position: absolute;
                        left: 50%;
                        top: 50%;
                        width: 1600px;
                        height: 1600px;
                        margin: -800px 0 0 -800px;
                        background: repeating-conic-gradient(from 0deg, rgba(0, 0, 0, .05) 0deg 0.6deg, transparent 0.6deg 12deg);
                        -webkit-mask: radial-gradient(circle, transparent 18%, #000 30%, transparent 60%);
                        mask: radial-gradient(circle, transparent 18%, #000 30%, transparent 60%);
                        pointer-events: none;
                    }

                    #wu-smm-strategy .wu-inner {
                        position: relative;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        gap: 40px;
                    }

                    .wu-strategy-quote {
                        max-width: 820px;
                        background: rgba(255, 255, 255, .88);
                        backdrop-filter: blur(6px);
                        border-radius: 20px;
                        padding: clamp(28px, 4vw, 52px);
                        display: flex;
                        flex-direction: column;
                        gap: 20px;
                        text-align: center;
                        box-shadow: 0 30px 60px -30px rgba(0, 0, 0, .25);
                    }

                    .wu-strategy-quote h2 {
                        font-size: clamp(32px, 3.6vw, 52px);
                        font-weight: 500;
                        text-wrap: balance;
                        letter-spacing: -0.05em;
                        line-height: .98;
                    }

                    .wu-strategy-quote p.wu-p1 {
                        font-size: 17px;
                        line-height: 1.7;
                        color: #3D3D3D;
                        text-wrap: pretty;
                    }

                    .wu-strategy-quote p.wu-p2 {
                        font-size: 19px;
                        line-height: 1.5;
                        font-weight: 500;
                        padding-top: 20px;
                        border-top: 1px solid rgba(0, 0, 0, .1);
                        text-wrap: pretty;
                    }

                    .wu-strategy-grid {
                        width: 100%;
                        max-width: 1020px;
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(min(100%, 380px), 1fr));
                        gap: 16px;
                    }

                    .wu-strategy-card {
                        border-radius: 20px;
                        padding: 36px;
                        display: flex;
                        flex-direction: column;
                        gap: 14px;
                    }

                    .wu-strategy-card.is-dark {
                        background: #0A0A0A;
                        color: #fff;
                    }

                    .wu-strategy-card.is-lime {
                        background: linear-gradient(135deg, #C2E05A, #8FA83A);
                        color: #0E1206;
                    }

                    .wu-strategy-card p {
                        font-size: 16px;
                        line-height: 1.65;
                    }

                    .wu-strategy-card.is-dark p {
                        color: rgba(255, 255, 255, .75);
                    }

                    .wu-strategy-card h3 {
                        font-size: 26px;
                        font-weight: 400;
                        letter-spacing: -0.035em;
                        line-height: 1.1;
                    }

                    .wu-strategy-icon {
                        flex: none;
                        margin-bottom: 12px;
                        width: 52px;
                        height: 52px;
                        border-radius: 16px;
                        display: grid;
                        place-items: center;
                    }

                    .wu-strategy-icon.is-lime {
                        background: radial-gradient(circle at 30% 25%, #F1F9B8, #C2F760 45%, #6E8A22);
                        color: #0E1206;
                        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .5), 0 10px 30px -10px rgba(194, 247, 96, .6);
                    }

                    .wu-strategy-icon.is-black {
                        background: #0A0A0A;
                        color: #C2F760;
                        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .12), 0 10px 24px -10px rgba(0, 0, 0, .6);
                    }

                    /* PROCESS */
                    #wu-smm-process .wu-inner {
                        padding: 120px clamp(20px, 4vw, 40px);
                        display: grid;
                        grid-template-columns: minmax(0, 0.85fr) minmax(0, 1.15fr);
                        gap: clamp(32px, 5vw, 64px);
                    }

                    #wu-smm-process .wu-proc-left {
                        display: flex;
                        flex-direction: column;
                        gap: 24px;
                        position: sticky;
                        top: 120px;
                        align-self: start;
                    }

                    #wu-smm-process .wu-proc-left p {
                        font-size: 17px;
                        line-height: 1.7;
                        color: rgba(255, 255, 255, .75);
                        max-width: 440px;
                    }

                    .wu-proc-track {
                        position: relative;
                        display: flex;
                        flex-direction: column;
                        gap: 20px;
                        padding-left: 44px;
                    }

                    .wu-proc-rail {
                        position: absolute;
                        left: 11px;
                        top: 12px;
                        bottom: 12px;
                        width: 2px;
                        background: rgba(255, 255, 255, .12);
                    }

                    .wu-proc-fill {
                        position: absolute;
                        left: 11px;
                        top: 12px;
                        width: 2px;
                        height: 0;
                        background: linear-gradient(180deg, #E9F98A, #7D9A2A);
                        box-shadow: 0 0 12px #C2F760;
                    }

                    .wu-proc-step {
                        position: relative;
                        padding: 28px;
                        border-radius: 18px;
                        background: #0E0E0E;
                        display: flex;
                        flex-direction: column;
                        gap: 10px;
                        border: 1px solid transparent;
                        transition: border-color .4s;
                    }

                    .wu-proc-step:hover {
                        border-color: rgba(194, 247, 96, .5);
                    }

                    .wu-proc-step.is-last {
                        background: linear-gradient(135deg, #1E2214, #0E0E0E);
                    }

                    .wu-proc-dot {
                        position: absolute;
                        left: -44px;
                        top: 30px;
                        width: 24px;
                        height: 24px;
                        border-radius: 50%;
                        background: #000;
                        border: 2px solid #C2F760;
                    }

                    .wu-proc-step.is-last .wu-proc-dot {
                        background: #C2F760;
                        border: none;
                        box-shadow: 0 0 14px #C2F760;
                    }

                    .wu-proc-step .wu-proc-no {
                        font-size: 14px;
                        color: #C2F760;
                        margin-bottom: 4px;
                        display: block;
                    }

                    .wu-proc-step h3 {
                        font-size: 26px;
                        font-weight: 400;
                        letter-spacing: -0.035em;
                        line-height: 1.1;
                    }

                    .wu-proc-step p {
                        font-size: 16px;
                        line-height: 1.6;
                        color: rgba(255, 255, 255, .72);
                    }

                    @media (max-width: 860px) {
                        #wu-smm-process .wu-inner {
                            grid-template-columns: minmax(0, 1fr);
                        }

                        #wu-smm-process .wu-proc-left {
                            position: relative;
                            top: 0;
                        }
                    }

                    /* WHY */
                    #wu-smm-why {
                        position: relative;
                        background: linear-gradient(90deg, #000 0%, #000 45%, #141414 55%, #000 100%);
                        padding: 120px 0;
                    }

                    #wu-smm-why .wu-inner {
                        display: flex;
                        flex-direction: column;
                        gap: 56px;
                    }

                    .wu-why-grid {
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr));
                        gap: 12px;
                    }

                    .wu-why-card {
                        position: relative;
                        overflow: hidden;
                        border-radius: 14px;
                        padding: 26px;
                        display: flex;
                        flex-direction: column;
                        gap: 10px;
                        border: 1px solid transparent;
                        background: linear-gradient(#060606, #060606) padding-box, linear-gradient(140deg, rgba(194, 247, 96, .55) 0%, rgba(255, 255, 255, .06) 35%, rgba(255, 255, 255, .03) 65%, rgba(194, 247, 96, .3) 100%) border-box;
                        transition: background .4s;
                    }

                    .wu-why-card:hover {
                        background: linear-gradient(#0C1008, #0C1008) padding-box, linear-gradient(140deg, #C2F760, rgba(194, 247, 96, .15) 50%, #C2F760) border-box;
                    }

                    .wu-why-icon {
                        flex: none;
                        margin-bottom: 14px;
                        width: 46px;
                        height: 46px;
                        border-radius: 14px;
                        background: linear-gradient(145deg, #232912 0%, #0B0B0B 70%);
                        border: 1px solid rgba(194, 247, 96, .28);
                        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .06), 0 8px 24px -10px rgba(194, 247, 96, .35);
                        display: grid;
                        place-items: center;
                        color: #C2F760;
                    }

                    .wu-why-card h3 {
                        font-size: 19px;
                        font-weight: 500;
                        letter-spacing: -0.035em;
                        line-height: 1.1;
                    }

                    .wu-why-card p {
                        font-size: 14.5px;
                        line-height: 1.6;
                        color: rgba(255, 255, 255, .65);
                    }

                    .wu-spot {
                        position: absolute;
                        inset: 0;
                        pointer-events: none;
                        opacity: 0;
                        transition: opacity .4s;
                        border-radius: inherit;
                        z-index: 0;
                    }

                    [data-spot]>*:not(.wu-spot) {
                        position: relative;
                        z-index: 1;
                    }

                    /* RESULTS */
                    #wu-smm-results .wu-inner {
                        padding: 120px clamp(20px, 4vw, 40px) 60px;
                        display: flex;
                        flex-direction: column;
                        gap: 48px;
                    }

                    .wu-results-grid {
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(min(100%, 420px), 1fr));
                        gap: 16px;
                        align-items: stretch;
                    }

                    #wu-smm .wu-result-featured {
                        display: flex;
                        flex-direction: column;
                        border-radius: 24px;
                        overflow: hidden;
                        background: #0E0E0E;
                        color: #fff;
                        min-height: 100%;
                    }

                    #wu-smm .wu-result-featured .wu-result-img {
                        flex: 1;
                        min-height: 320px;
                        overflow: hidden;
                    }

                    #wu-smm .wu-result-featured .wu-result-img img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        display: block;
                        transition: transform .9s cubic-bezier(.2, .8, .2, 1);
                    }

                    #wu-smm .wu-result-featured:hover .wu-result-img img {
                        transform: scale(1.05);
                    }

                    #wu-smm .wu-result-featured-body {
                        padding: clamp(22px, 3vw, 32px);
                        display: flex;
                        justify-content: space-between;
                        align-items: flex-end;
                        gap: 20px;
                    }

                    #wu-smm .wu-result-featured-body h3 {
                        font-size: clamp(28px, 3vw, 42px);
                        font-weight: 400;
                        letter-spacing: -0.045em;
                        line-height: 1;
                    }

                    #wu-smm .wu-eyebrow-tag {
                        font-size: 12px;
                        letter-spacing: .16em;
                        text-transform: uppercase;
                        color: #C2F760;
                    }

                    .wu-result-list {
                        display: flex;
                        flex-direction: column;
                        gap: 12px;
                    }

                    #wu-smm .wu-result-row {
                        display: grid;
                        grid-template-columns: clamp(96px, 12vw, 140px) minmax(0, 1fr) 40px;
                        gap: 20px;
                        align-items: center;
                        padding: 14px;
                        border-radius: 20px;
                        background: #0E0E0E;
                        color: #fff;
                        transition: background .4s;
                    }

                    #wu-smm .wu-result-row:hover {
                        background: #151A0C;
                        color: #fff;
                    }

                    #wu-smm .wu-result-row .wu-result-thumb {
                        aspect-ratio: 1/1;
                        border-radius: 14px;
                        overflow: hidden;
                        display: block;
                    }

                    #wu-smm .wu-result-row .wu-result-thumb img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        display: block;
                    }

                    #wu-smm .wu-result-row h3 {
                        font-size: clamp(20px, 1.8vw, 24px);
                        font-weight: 500;
                        letter-spacing: -0.03em;
                        line-height: 1.1;
                    }

                    #wu-smm .wu-result-row .wu-result-meta {
                        font-size: 13.5px;
                        line-height: 1.5;
                        color: rgba(255, 255, 255, .6);
                    }

                    #wu-smm .wu-circle-arrow-sm {
                        width: 40px;
                        height: 40px;
                        border-radius: 50%;
                        border: 1px solid rgba(255, 255, 255, .2);
                        display: grid;
                        place-items: center;
                        color: #C2F760;
                    }

                    /* TESTIMONIALS */
                    #wu-smm-testimonials {
                        padding: 100px 0 120px;
                        display: flex;
                        flex-direction: column;
                        gap: 48px;
                    }

                    #wu-smm-testimonials .wu-inner {
                        display: flex;
                        flex-direction: column;
                        gap: 24px;
                    }

                    .wu-marquee-mask {
                        overflow: hidden;
                        -webkit-mask: linear-gradient(90deg, transparent, #000 8%, #000 92%, transparent);
                        mask: linear-gradient(90deg, transparent, #000 8%, #000 92%, transparent);
                    }

                    .wu-t-card {
                        width: 380px;
                        flex: none;
                        position: relative;
                        overflow: hidden;
                        transition: transform .5s cubic-bezier(.2, .8, .2, 1);
                        background: #111;
                        border-radius: 18px;
                        padding: 28px;
                        display: flex;
                        flex-direction: column;
                        gap: 20px;
                    }

                    .wu-t-card.is-lime {
                        background: linear-gradient(135deg, #C2E05A, #8FA83A);
                        color: #0E1206;
                    }

                    .wu-t-card.is-cream {
                        background: #FAF2F2;
                        color: #0A0A0A;
                    }

                    .wu-t-quote-icon {
                        position: absolute;
                        right: 22px;
                        top: 20px;
                        opacity: .12;
                        pointer-events: none;
                    }

                    .wu-t-stars {
                        color: #C2F760;
                        display: flex;
                        gap: 3px;
                        margin-bottom: 4px;
                    }

                    .wu-t-card.is-lime .wu-t-stars,
                    .wu-t-card.is-cream .wu-t-stars {
                        color: #5F6C27;
                    }

                    .wu-t-card blockquote {
                        font-size: 17px;
                        line-height: 1.6;
                        flex: 1;
                    }

                    .wu-t-card figcaption strong {
                        display: block;
                        font-size: 15px;
                        font-weight: 600;
                    }

                    .wu-t-card figcaption span {
                        font-size: 13px;
                        color: rgba(255, 255, 255, .55);
                    }

                    .wu-t-card.is-lime figcaption span,
                    .wu-t-card.is-cream figcaption span {
                        color: rgba(10, 10, 10, .55);
                    }

                    /* FAQ */
                    #wu-smm-faq .wu-inner {
                        padding: 0 clamp(20px, 4vw, 40px) 120px;
                        display: grid;
                        grid-template-columns: minmax(0, 0.85fr) minmax(0, 1.15fr);
                        gap: clamp(32px, 5vw, 64px);
                        align-items: start;
                    }

                    #wu-smm-faq .wu-faq-left {
                        display: flex;
                        flex-direction: column;
                        gap: 24px;
                        position: sticky;
                        top: 120px;
                        align-self: start;
                    }

                    @media (max-width: 860px) {
                        #wu-smm-faq .wu-inner {
                            grid-template-columns: minmax(0, 1fr);
                        }

                        #wu-smm-faq .wu-faq-left {
                            position: relative;
                            top: 0;
                        }
                    }

                    .wu-faq-list {
                        display: flex;
                        flex-direction: column;
                        gap: 10px;
                    }

                    .wu-faq-item {
                        position: relative;
                        overflow: hidden;
                        border-radius: 14px;
                        background: #0E0E0E;
                        padding: 0 24px;
                    }

                    .wu-faq-item button {
                        all: unset;
                        cursor: pointer;
                        width: 100%;
                        box-sizing: border-box;
                        padding: 22px 0;
                        display: flex;
                        justify-content: space-between;
                        gap: 20px;
                        align-items: center;
                        font-size: 18px;
                        font-weight: 500;
                        color: #fff;
                    }

                    .wu-faq-item .wu-faq-plus {
                        flex: 0 0 32px;
                        height: 32px;
                        border-radius: 50%;
                        border: 1.5px solid #C2F760;
                        color: #C2F760;
                        display: grid;
                        place-items: center;
                        font-size: 18px;
                        transition: transform .3s;
                    }

                    .wu-faq-item.is-open .wu-faq-plus {
                        transform: rotate(45deg);
                    }

                    .wu-faq-answer {
                        display: grid;
                        grid-template-rows: 0fr;
                        transition: grid-template-rows .4s cubic-bezier(.2, .8, .2, 1);
                    }

                    .wu-faq-item.is-open .wu-faq-answer {
                        grid-template-rows: 1fr;
                    }

                    .wu-faq-answer>div {
                        overflow: hidden;
                    }

                    .wu-faq-answer p {
                        padding: 0 40px 22px 0;
                        font-size: 16px;
                        line-height: 1.7;
                        color: rgba(255, 255, 255, .72);
                    }

                    /* CTA */
                    #wu-smm-cta {
                        padding: 0 clamp(12px, 2vw, 24px) 60px;
                    }

                    .wu-cta-box {
                        position: relative;
                        max-width: 1400px;
                        margin: 0 auto;
                        border-radius: 32px;
                        overflow: hidden;
                        background: #1c1d19;
                        box-shadow: inset 0 0 0 1px rgba(194, 247, 96, .35), inset 0 1px 0 rgba(241, 249, 184, .45), 0 40px 120px -50px rgba(194, 247, 96, .35);
                        padding: clamp(64px, 8vw, 110px) clamp(24px, 5vw, 72px);
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        text-align: center;
                        gap: 28px;
                    }

                    .wu-cta-box img.wu-mascot {
                        position: relative;
                        width: 88px;
                        height: 88px;
                        border-radius: 50%;
                        object-fit: cover;
                        background: #000;
                        box-shadow: 0 0 0 2px #C2F760, 0 0 30px rgba(194, 247, 96, .5);
                    }

                    .wu-cta-box h2 {
                        position: relative;
                        font-size: clamp(36px, 5.6vw, 80px);
                        font-weight: 400;
                        max-width: 900px;
                        text-wrap: balance;
                        letter-spacing: -0.05em;
                        line-height: .98;
                    }

                    .wu-cta-box p {
                        position: relative;
                        font-size: 18px;
                        line-height: 1.65;
                        max-width: 620px;
                        color: rgba(255, 255, 255, .85);
                        text-wrap: pretty;
                    }
                    /* 2026-10-31 layout pass: wider page, compact cards */
                    #wu-smm .wu-inner { max-width: 1440px; }
                    .wu-hero-fan { max-width: 1440px; }
                    .wu-cta-box { max-width: 1440px; }

                    /* strategy: 5 cards as 3 + 2, full width, no orphan */
                    .wu-strategy-quote { max-width: 900px; }
                    .wu-strategy-grid { max-width: none; grid-template-columns: repeat(6, 1fr); gap: 14px; }
                    .wu-strategy-card { grid-column: span 2; padding: 28px; gap: 10px; }
                    .wu-strategy-card:nth-child(n+4) { grid-column: span 3; }
                    .wu-strategy-card h3 { font-size: 22px; }
                    .wu-strategy-card p { font-size: 15px; line-height: 1.6; }
                    .wu-strategy-icon { width: 44px; height: 44px; border-radius: 13px; margin-bottom: 6px; }

                    /* why: 3 + 2 instead of five narrow columns */
                    .wu-why-grid { grid-template-columns: repeat(6, 1fr); gap: 14px; }
                    .wu-why-card { grid-column: span 2; padding: 28px; }
                    .wu-why-card:nth-child(n+4) { grid-column: span 3; }
                    .wu-why-card h3 { font-size: 21px; }
                    .wu-why-card p { font-size: 15px; }
                    .wu-why-icon { margin-bottom: 8px; }

                    /* content bento: shorter reel, readable text over photos */
                    .wu-bento { grid-template-columns: repeat(3, 1fr); }
                    .wu-bento-card { min-height: 280px; }
                    .wu-bento-reel { padding: 24px; gap: 16px; }
                    .wu-bento-reel img { flex: none; min-height: 0; max-width: 230px; aspect-ratio: 9 / 13; height: auto; }
                    .wu-bento-overlay { padding: 90px 28px 28px; background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,.8) 32%, rgba(0,0,0,.94) 100%); }

                    /* services: darker base under the open panel's text */
                    .wu-svc-panel.is-active .wu-svc-shade { background: linear-gradient(180deg, rgba(0,0,0,.15) 0%, rgba(0,0,0,.05) 25%, rgba(0,0,0,.8) 55%, rgba(0,0,0,.94) 100%); }

                    @media (max-width: 1024px) {
                        .wu-strategy-grid, .wu-why-grid, .wu-bento { grid-template-columns: repeat(2, 1fr); }
                        .wu-strategy-card, .wu-strategy-card:nth-child(n+4), .wu-why-card, .wu-why-card:nth-child(n+4) { grid-column: auto; }
                        .wu-strategy-card:last-child, .wu-why-card:last-child { grid-column: 1 / -1; }
                    }
                    @media (max-width: 640px) {
                        .wu-strategy-grid, .wu-why-grid, .wu-bento { grid-template-columns: 1fr; }
                        .wu-bento-card.wu-tall { grid-row: auto; }
                        .wu-strategy-card, .wu-why-card { padding: 24px; }
                    }

                    /* doc-only pass: nothing but the doc's copy and its images */
                    .wu-svc-top { justify-content: flex-end; }

                    /* content cards: one alignment, headings left, copy justified */
                    .wu-bento-card, .wu-bento-reel { text-align: left; }
                    .wu-bento-reel { align-items: stretch; }
                    .wu-bento-reel img { align-self: center; }
                    .wu-bento-card h3 { text-align: left; }
                    .wu-bento-card p { text-align: justify; text-justify: inter-word; hyphens: manual; }

                    /* quote marks: true typographic quotes in a serif, lime, so they read as quotation marks */
                    .wu-q { font-family: Georgia, 'Times New Roman', serif; font-size: 2em; line-height: 0; color: #C2F760; vertical-align: -.36em; }
                    .wu-q:first-child { margin-right: .08em; }

                    /* standalone intro: the two paragraphs that used to sit in the hero */
                    #wu-smm-intro { padding: clamp(64px, 8vw, 112px) 0; }
                    #wu-smm-intro .wu-intro { max-width: 980px; margin: 0 auto; display: flex; flex-direction: column; gap: clamp(28px, 3.4vw, 44px); }
                    #wu-smm-intro .wu-intro-text { font-size: clamp(19px, 1.9vw, 27px); line-height: 1.55; font-weight: 300; color: rgba(255, 255, 255, .82); text-wrap: pretty; }
                    #wu-smm-intro .wu-intro-punch { position: relative; padding-top: clamp(22px, 2.6vw, 32px); font-size: clamp(26px, 3.2vw, 46px); line-height: 1.15; font-weight: 500; letter-spacing: -0.035em; color: #fff; text-wrap: balance; }
                    #wu-smm-intro .wu-intro-punch::before { content: ''; position: absolute; left: 0; top: 0; width: 64px; height: 3px; border-radius: 3px; background: linear-gradient(90deg, #6E8A22, #C2F760); }

                    /* hero title and description use the same size, weight, spacing and width as every other section heading and description */
                    #wu-smm-hero .wu-hero-copy { max-width: 860px; gap: 22px; }
                    #wu-smm-hero h2.wu-hero-title { font-size: clamp(36px, 4.4vw, 64px); font-weight: 400; letter-spacing: -0.05em; line-height: .98; text-wrap: balance; }
                    #wu-smm-hero .wu-h-lede2 { font-size: 17px; line-height: 1.7; color: rgba(255, 255, 255, .75); max-width: 680px; text-wrap: pretty; }

                    /* hero: clearer text, centred on one axis, more room below the header */
                    #wu-smm-hero { padding-top: clamp(170px, 16vw, 240px); }
                    #wu-smm-hero .wu-hero-copy { align-items: center; text-align: center; }
                    #wu-smm-hero h2.wu-hero-title { font-weight: 500; color: #fff; text-align: center; }
                    #wu-smm-hero .wu-h-lede2 { color: rgba(255, 255, 255, .94); text-align: center; margin-inline: auto; font-weight: 400; text-shadow: 0 1px 18px rgba(0, 0, 0, .6); }

                    /* hero: wider title, centred and balanced description */
                    #wu-smm-hero .wu-hero-copy { max-width: min(100%, 1280px); width: 100%; }
                    #wu-smm-hero h2.wu-hero-title { width: 100%; max-width: none; }
                    #wu-smm-hero .wu-h-lede2 { width: 100%; max-width: 720px; margin-inline: auto; text-align: center; text-wrap: balance; }

                    /* the homepage logo strip, sitting under Results */
                    .wu-logos.wiseup-in-theme { background: #000; padding: 0 0 clamp(48px, 6vw, 88px); margin: 0; }

                    /* intro, more refined: paragraph and statement side by side on a hairline frame */
                    #wu-smm-intro { border-block: 1px solid rgba(255, 255, 255, .08); background: linear-gradient(180deg, rgba(255, 255, 255, .025), rgba(255, 255, 255, 0)); padding: clamp(56px, 6vw, 96px) 0; }
                    #wu-smm-intro .wu-intro { max-width: none; display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: clamp(36px, 6vw, 110px); align-items: center; }
                    #wu-smm-intro .wu-intro-text { font-size: clamp(17px, 1.35vw, 20px); line-height: 1.8; font-weight: 400; color: rgba(255, 255, 255, .8); }
                    #wu-smm-intro .wu-intro-punch { padding: 0 0 0 clamp(24px, 3vw, 48px); font-size: clamp(28px, 3vw, 44px); line-height: 1.15; font-weight: 500; letter-spacing: -0.035em; border-left: 2px solid transparent; border-image: linear-gradient(180deg, #C2F760, rgba(194, 247, 96, 0)) 1; }
                    #wu-smm-intro .wu-intro-punch::before { display: none; }
                    @media (max-width: 860px) { #wu-smm-intro .wu-intro { grid-template-columns: 1fr; gap: 28px; } }

                    /* platforms: four tall cards, descriptions revealed on hover / tap */
                    .wu-plats { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; }
                    .wu-plat { position: relative; min-height: 480px; padding: 28px; border-radius: 24px; overflow: hidden; cursor: pointer; outline: none; display: flex; flex-direction: column; justify-content: flex-end; gap: 14px;
                        background: radial-gradient(120% 80% at 100% 0%, rgba(194, 247, 96, .10), transparent 60%), linear-gradient(180deg, #101210, #080908); box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .08); transition: box-shadow .5s, background .5s, transform .5s cubic-bezier(.2, .8, .2, 1); }
                    .wu-plat-num { position: absolute; top: 28px; right: 28px; font-size: 13px; letter-spacing: .14em; color: rgba(255, 255, 255, .35); }
                    .wu-plat-ico { position: absolute; top: 28px; left: 28px; display: flex; gap: 8px; color: #fff; transition: opacity .35s, transform .5s cubic-bezier(.2, .8, .2, 1); }
                    .wu-plat-ico svg { width: 44px; height: 44px; }
                    .wu-plat h3 { position: relative; margin: 0; font-size: clamp(24px, 2.2vw, 32px); font-weight: 500; letter-spacing: -0.035em; line-height: 1.08; color: #fff; transition: transform .5s cubic-bezier(.2, .8, .2, 1); }
                    .wu-plat-plus { position: relative; width: 36px; height: 36px; border-radius: 50%; box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .25); transition: background .4s, transform .5s, box-shadow .4s; }
                    .wu-plat-plus::before, .wu-plat-plus::after { content: ''; position: absolute; left: 50%; top: 50%; width: 12px; height: 1.5px; background: #fff; transform: translate(-50%, -50%); transition: transform .4s, background .4s; }
                    .wu-plat-plus::after { transform: translate(-50%, -50%) rotate(90deg); }
                    .wu-plat-desc { position: absolute; inset: 0; margin: 0; padding: 72px 28px 160px; display: block; font-size: 14.5px; line-height: 1.6; color: rgba(255, 255, 255, .88); opacity: 0; transform: translateY(14px); transition: opacity .45s, transform .5s cubic-bezier(.2, .8, .2, 1); pointer-events: none; }
                    .wu-plat.is-open { background: radial-gradient(120% 80% at 100% 0%, rgba(194, 247, 96, .22), transparent 60%), linear-gradient(180deg, #151a0e, #0a0c07); box-shadow: inset 0 0 0 1px rgba(194, 247, 96, .55), 0 30px 60px -30px rgba(194, 247, 96, .35); transform: translateY(-4px); }
                    .wu-plat.is-open .wu-plat-ico { opacity: 0; transform: translateY(-10px); }
                    .wu-plat.is-open h3 { transform: translateY(0); color: #D2EAA6; }
                    .wu-plat.is-open .wu-plat-desc { opacity: 1; transform: none; }
                    .wu-plat.is-open .wu-plat-plus { background: #C2F760; box-shadow: none; transform: rotate(45deg); }
                    .wu-plat.is-open .wu-plat-plus::before, .wu-plat.is-open .wu-plat-plus::after { background: #0E1206; }
                    @media (hover: hover) { .wu-plat:hover { box-shadow: inset 0 0 0 1px rgba(194, 247, 96, .4); } }
                    .wu-plat:focus-visible { box-shadow: inset 0 0 0 2px #C2F760; }
                    #wu-smm .wu-plat { transition: translate .6s cubic-bezier(.4,0,.2,1), box-shadow .5s, background .5s, opacity .8s, transform .8s; }
                    #wu-smm-testimonials .wu-inner { min-width: 0; width: 100%; box-sizing: border-box; }
                    .wu-rv-grid { width: 100%; min-width: 0; max-width: 100%; display: flex; gap: 16px; align-items: stretch; overflow-x: auto; scroll-snap-type: x mandatory; scrollbar-width: none; -webkit-overflow-scrolling: touch; padding-bottom: 4px; }
                    .wu-rv-grid::-webkit-scrollbar { display: none; }
                    .wu-rv { flex: 0 0 calc((100% - 32px) / 3); width: auto; margin: 0; scroll-snap-align: start; }
                    .wu-rv-bar { display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
                    .wu-rv-nav { display: flex; gap: 10px; }
                    .wu-rv-nav button { width: 48px; height: 48px; border-radius: 50%; border: 1px solid rgba(255,255,255,.25); background: transparent; color: #fff; cursor: pointer; display: grid; place-items: center; transition: background .3s, color .3s, opacity .3s; }
                    .wu-rv-nav button:hover:not(:disabled) { background: #C2F760; color: #0E1206; border-color: #C2F760; }
                    .wu-rv-nav button:disabled { opacity: .3; cursor: default; }
                    .wu-rv blockquote { margin: 0; padding: 0; border: 0; }
                    .wu-rv-text { display: -webkit-box; -webkit-line-clamp: 5; -webkit-box-orient: vertical; overflow: hidden; }
                    .wu-rv.is-open .wu-rv-text { display: block; -webkit-line-clamp: unset; overflow: visible; }
                    .wu-rv-more { align-self: flex-start; background: none; border: 0; padding: 0; font: inherit; font-weight: 600; font-size: 14px; text-decoration: underline; text-underline-offset: 3px; cursor: pointer; color: #C2F760; }
                    .wu-rv.is-lime .wu-rv-more, .wu-rv.is-cream .wu-rv-more { color: #2c3510; }
                    .wu-rv-more[hidden] { display: none; }
                    .wu-rv-all { align-self: flex-start; color: #C2F760; font-weight: 600; text-decoration: none; }
                    @media (max-width: 1000px) { .wu-rv { flex-basis: calc((100% - 16px) / 2); } }
                    @media (max-width: 640px) { .wu-rv { flex-basis: 88%; } }
                    @media (prefers-reduced-motion: no-preference) { .wu-rv-grid { scroll-behavior: smooth; } }
                    #wu-smm-stats { padding: 80px 0; }
                    .wu-stats { list-style: none; margin: clamp(36px, 4.5vw, 64px) 0 0; padding: 0; display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); border-top: 1px solid rgba(255,255,255,.14); }
                    .wu-stats li { padding: 32px 20px 8px 0; display: flex; flex-direction: column; gap: 6px; }
                    .wu-stats li + li { padding-left: 24px; border-left: 1px solid rgba(255,255,255,.14); }
                    .wu-stats b { font-size: clamp(44px, 5vw, 76px); font-weight: 400; letter-spacing: -.04em; line-height: 1; color: #C2F760; }
                    .wu-stats strong { font-size: 16px; font-weight: 600; color: #fff; margin-top: 10px; }
                    .wu-stats li > span { font-size: 14px; color: rgba(255,255,255,.6); }
                    @media (max-width: 1000px) { .wu-stats { grid-template-columns: repeat(3, minmax(0, 1fr)); } .wu-stats li:nth-child(4) { padding-left: 0; border-left: 0; } .wu-stats li:nth-child(n+4) { border-top: 1px solid rgba(255,255,255,.14); margin-top: 24px; } }
                    @media (max-width: 560px) { .wu-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); } .wu-stats li, .wu-stats li + li { padding: 24px 12px 0 0; border-left: 0; margin-top: 0; border-top: 0; } .wu-stats li:nth-child(even) { padding-left: 16px; border-left: 1px solid rgba(255,255,255,.14); } }
                    /* open state uses the card's existing height: heading and button collapse, icons shrink */
                    #wu-smm .wu-plat h3 { max-height: 4.4em; overflow: hidden; transition: max-height .6s cubic-bezier(.4,0,.2,1), min-height .6s cubic-bezier(.4,0,.2,1), opacity .35s ease; }
                    #wu-smm .wu-plat.is-open h3 { max-height: 0; min-height: 0; opacity: 0; }
                    #wu-smm .wu-plat .wu-plat-plus { height: 36px; overflow: hidden; transition: height .6s cubic-bezier(.4,0,.2,1), margin .6s cubic-bezier(.4,0,.2,1), opacity .35s ease, background .4s, box-shadow .4s; }
                    #wu-smm .wu-plat.is-open .wu-plat-plus { height: 0; margin-top: 0; opacity: 0; box-shadow: none; transform: none; }
                    #wu-smm .wu-plat .wu-plat-ico { transition: margin .6s cubic-bezier(.4,0,.2,1), opacity .35s, transform .5s; }
                    #wu-smm .wu-plat .wu-logo { transition: width .5s cubic-bezier(.4,0,.2,1), height .5s cubic-bezier(.4,0,.2,1), border-radius .5s; }
                    #wu-smm .wu-plat .wu-logo svg { transition: width .5s cubic-bezier(.4,0,.2,1), height .5s cubic-bezier(.4,0,.2,1); }
                    #wu-smm .wu-plat.is-open .wu-logo { width: 28px; height: 28px; border-radius: 9px; }
                    #wu-smm .wu-plat.is-open .wu-logo svg { width: 15px; height: 15px; }
                    #wu-smm .wu-plat.is-open .wu-plat-ico { margin-bottom: 14px; }
                    #wu-smm .wu-plat.is-open .wu-plat-desc { margin-top: 0; }
                    #wu-smm-hero h1.wu-hero-pill { display: inline-flex; align-items: center; gap: 10px; margin: 0 auto clamp(18px, 2vw, 28px); padding: 9px 20px 9px 12px; border-radius: 999px; background: rgba(0, 0, 0, .55); border: 1px solid rgba(255, 255, 255, .14); backdrop-filter: blur(10px); box-shadow: inset 0 1px 0 rgba(255, 255, 255, .06); font-size: 13.5px; font-weight: 500; letter-spacing: .01em; line-height: 1.2; color: #fff; text-align: center; }
                    .wu-hero-copy { text-align: center; }
                    /* CONTENT: the five formats as they look on a feed (phone) with an expanding list beside it */
                    .wu-cf2 { --dur: 7s; display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.15fr); gap: clamp(32px, 5vw, 88px); align-items: start; margin-top: clamp(36px, 4vw, 64px); }
                    .wu-cf2-stage { position: relative; display: grid; place-items: center; padding: clamp(10px, 2vw, 30px) 0; }
                    .wu-cf2-glow { position: absolute; width: min(100%, 460px); aspect-ratio: 1; border-radius: 50%; background: radial-gradient(closest-side, rgba(190, 218, 82, .55), rgba(190, 218, 82, .12) 60%, transparent 72%); filter: blur(10px); animation: wuCfFloat 9s ease-in-out infinite; }
                    @keyframes wuCfFloat { 50% { transform: translate(14px, -18px) scale(1.06); } }
                    .wu-phone { position: relative; width: clamp(236px, 22vw, 310px); aspect-ratio: 9 / 18.6; padding: 10px; border-radius: 46px; background: linear-gradient(160deg, #2a2c24, #0a0b08 55%); box-shadow: 0 0 0 1.5px rgba(255, 255, 255, .12) inset, 0 40px 70px -28px rgba(20, 28, 4, .65), 0 14px 30px -14px rgba(0, 0, 0, .5); transform: rotate(-3deg); transition: transform .8s cubic-bezier(.2, .8, .2, 1); }
                    .wu-cf2-stage:hover .wu-phone { transform: rotate(0deg) translateY(-6px); }
                    .wu-phone-notch { position: absolute; z-index: 5; top: 18px; left: 50%; width: 30%; height: 20px; border-radius: 99px; background: #000; transform: translateX(-50%); }
                    .wu-phone-screen { position: relative; width: 100%; height: 100%; overflow: hidden; border-radius: 37px; background: #0b0b0b; }
                    .ph-scr { position: absolute; inset: 0; opacity: 0; transform: scale(.96); transition: opacity .5s ease, transform .6s cubic-bezier(.2, .8, .2, 1); pointer-events: none; color: #fff; }
                    .ph-scr.is-on { opacity: 1; transform: none; }
                    .ph-scr img { display: block; width: 100%; height: 100%; object-fit: cover; }
                    .ph-sk { display: block; height: 9px; border-radius: 9px; background: rgba(255, 255, 255, .22); }
                    .ph-scr svg { width: 22px; height: 22px; }
                    /* 1 post */
                    .ph-post { display: flex; flex-direction: column; padding-top: 52px; background: #0b0b0b; }
                    .ph-top { display: flex; align-items: center; gap: 10px; padding: 0 14px 10px; }
                    .ph-av { width: 28px; height: 28px; border-radius: 50%; background: conic-gradient(#C2F760, #5B7A12, #C2F760); box-shadow: 0 0 0 2px #0b0b0b inset; }
                    .ph-img { aspect-ratio: 1; overflow: hidden; }
                    .ph-img img { transform: scale(1.08); transition: transform 6s linear; }
                    .ph-post.is-on .ph-img img { transform: scale(1); }
                    .ph-acts { display: flex; align-items: center; gap: 14px; padding: 12px 14px 6px; }
                    .ph-grow { flex: 1; }
                    .ph-heart { display: inline-flex; }
                    .ph-post.is-on .ph-heart { animation: phPop .9s cubic-bezier(.2, .8, .2, 1) .7s both; }
                    @keyframes phPop { 0% { transform: scale(1); color: #fff; } 35% { transform: scale(1.5); color: #ff4d6d; } 100% { transform: scale(1); color: #ff4d6d; } }
                    .ph-post.is-on .ph-heart svg { animation: phFillHeart .1s linear .7s forwards; }
                    @keyframes phFillHeart { to { fill: currentColor; } }
                    .ph-lines { display: grid; gap: 8px; padding: 6px 14px; }
                    /* 2 reel */
                    .ph-reel img { object-fit: cover; }
                    .ph-reel::after { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0, 0, 0, .25), transparent 25%, transparent 55%, rgba(0, 0, 0, .75)); pointer-events: none; }
                    .ph-rail { position: absolute; z-index: 2; right: 12px; bottom: 74px; display: grid; gap: 18px; }
                    .ph-cap { position: absolute; z-index: 2; left: 14px; right: 60px; bottom: 36px; display: grid; gap: 8px; }
                    .ph-prog { position: absolute; z-index: 3; left: 12px; right: 12px; bottom: 16px; height: 3px; border-radius: 3px; background: rgba(255, 255, 255, .3); overflow: hidden; }
                    .ph-prog i { display: block; height: 100%; width: 100%; background: #C2F760; transform-origin: 0 50%; transform: scaleX(0); }
                    .ph-reel.is-on .ph-prog i { animation: phFill var(--dur) linear forwards; }
                    @keyframes phFill { to { transform: scaleX(1); } }
                    /* 3 hook */
                    .ph-hook { display: flex; flex-direction: column; justify-content: center; gap: 26px; padding: 60px 24px 30px; background: radial-gradient(90% 70% at 0% 0%, rgba(194, 224, 90, .4), transparent 70%), linear-gradient(160deg, #1d240d, #0b0d07); }
                    .ph-type { min-height: 8.6em; font-size: clamp(19px, 1.8vw, 25px); font-weight: 500; letter-spacing: -.03em; line-height: 1.18; color: #fff; }
                    .ph-caret { display: inline-block; width: 2px; height: 1em; margin-left: 3px; vertical-align: -.12em; background: #C2F760; animation: phBlink 1s steps(1) infinite; }
                    @keyframes phBlink { 50% { opacity: 0; } }
                    .ph-cta { display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 10px 10px 10px 18px; border-radius: 99px; background: rgba(255, 255, 255, .1); }
                    .ph-cta i { display: grid; place-items: center; width: 34px; height: 34px; border-radius: 50%; background: #C2F760; color: #11150a; }
                    .ph-cta i svg { width: 16px; height: 16px; }
                    .ph-hook.is-on .ph-cta { animation: phNudge 1.6s ease-in-out 3.2s infinite; }
                    @keyframes phNudge { 50% { transform: translateX(6px); } }
                    /* 4 story + poll */
                    .ph-story::after { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0, 0, 0, .45), transparent 30%, transparent 50%, rgba(0, 0, 0, .8)); }
                    .ph-seg { position: absolute; z-index: 2; top: 44px; left: 12px; right: 12px; display: flex; gap: 4px; }
                    .ph-seg i { flex: 1; height: 3px; border-radius: 3px; background: rgba(255, 255, 255, .35); overflow: hidden; position: relative; }
                    .ph-seg i::after { content: ''; position: absolute; inset: 0; background: #fff; transform-origin: 0 50%; transform: scaleX(0); }
                    .ph-seg i:first-child::after { transform: scaleX(1); }
                    .ph-story.is-on .ph-seg i:nth-child(2)::after { animation: phFill calc(var(--dur) * .5) linear 1s forwards; }
                    .ph-poll { position: absolute; z-index: 2; left: 16px; right: 16px; bottom: 62px; display: grid; gap: 8px; padding: 12px; border-radius: 18px; background: rgba(255, 255, 255, .94); }
                    .ph-poll span { position: relative; height: 34px; border-radius: 99px; background: #e9e9e4; overflow: hidden; }
                    .ph-poll b { position: absolute; inset: 0 auto 0 0; width: 0; border-radius: 99px; background: #C2F760; }
                    .ph-story.is-on .ph-poll b { animation: phPoll 1.2s cubic-bezier(.2, .8, .2, 1) 1.1s forwards; }
                    @keyframes phPoll { to { width: var(--w); } }
                    .ph-poll span:last-child b { background: #5B7A12; }
                    .ph-dots { position: absolute; z-index: 2; left: 0; right: 0; bottom: 30px; display: flex; justify-content: center; gap: 6px; }
                    .ph-dots i { width: 6px; height: 6px; border-radius: 50%; background: rgba(255, 255, 255, .4); }
                    .ph-dots i:first-child { background: #fff; }
                    /* 5 campaign */
                    .ph-camp::after { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0, 0, 0, .2), transparent 35%, rgba(0, 0, 0, .8)); }
                    .ph-ring { position: absolute; z-index: 2; top: 42%; left: 50%; width: 70px; height: 70px; margin: -35px 0 0 -35px; border-radius: 50%; border: 2px solid #C2F760; opacity: 0; }
                    .ph-camp.is-on .ph-ring { animation: phRing 2.4s ease-out .4s infinite; }
                    .ph-camp.is-on .ph-ring--2 { animation-delay: 1.2s; }
                    @keyframes phRing { 0% { transform: scale(.3); opacity: .9; } 100% { transform: scale(3.2); opacity: 0; } }
                    .ph-live { position: absolute; z-index: 3; top: 48px; right: 16px; display: grid; place-items: center; width: 22px; height: 22px; border-radius: 50%; background: rgba(0, 0, 0, .45); }
                    .ph-live i { width: 9px; height: 9px; border-radius: 50%; background: #ff4d6d; animation: phBlink 1.1s steps(1) infinite; }
                    .ph-cta--camp { position: absolute; z-index: 3; left: 14px; right: 14px; bottom: 22px; }
                    /* the list: all five formats stay readable, the one the phone shows is lit */
                    .wu-cf2-stage { position: sticky; top: 110px; align-self: start; }
                    .wu-cf2-rows { display: grid; gap: clamp(8px, 1vw, 14px); }
                    .wu-cf2-row { position: relative; padding: clamp(20px, 2vw, 30px) clamp(20px, 2.4vw, 36px) clamp(20px, 2vw, 30px) clamp(24px, 2.8vw, 44px); border-radius: 24px; cursor: default; transition: background .5s ease, box-shadow .5s ease; }
                    .wu-cf2-row::before { content: ''; position: absolute; left: 14px; top: 26px; bottom: 26px; width: 3px; border-radius: 3px; background: #5B7A12; transform: scaleY(0); transform-origin: 50% 0; transition: transform .6s cubic-bezier(.2, .8, .2, 1); }
                    .wu-cf2-row.is-open { background: #F4F7EA; box-shadow: 0 0 0 1px rgba(91, 122, 18, .18); }
                    .wu-cf2-row.is-open::before { transform: scaleY(1); }
                    .wu-cf2-row h3 { margin: 0; display: flex; align-items: baseline; gap: 16px; color: rgba(10, 10, 10, .42); transition: color .4s; }
                    .wu-cf2-row.is-open h3 { color: #0A0A0A; }
                    .wu-cf2-n { font-size: 13px; letter-spacing: .14em; transition: color .4s; }
                    .wu-cf2-row.is-open .wu-cf2-n { color: #5B7A12; }
                    #wu-smm .wu-cf2-name { font-size: clamp(21px, 2vw, 30px); font-weight: 500; letter-spacing: -.035em; line-height: 1.12; }
                    .wu-cf2-body { margin-top: 12px; padding-left: 36px; }
                    #wu-smm .wu-cf2-body p { margin: 0 0 12px; font-size: clamp(15.5px, 1.1vw, 17px); line-height: 1.7; color: rgba(10, 10, 10, .5); transition: color .4s; }
                    #wu-smm .wu-cf2-body p:last-child { margin-bottom: 0; }
                    #wu-smm .wu-cf2-row.is-open .wu-cf2-body p { color: rgba(10, 10, 10, .78); }
                    @media (max-width: 860px) {
                        .wu-cf2 { grid-template-columns: minmax(0, 1fr); gap: 20px; }
                        .wu-cf2-stage { position: relative; top: 0; }
                        .wu-phone { width: min(250px, 70vw); }
                        .wu-cf2-body { padding-left: 0; }
                        .wu-cf2-row { padding-left: 26px; }
                    }
                    @media (prefers-reduced-motion: reduce) {
                        .wu-cf2-glow, .wu-phone, .ph-scr, .ph-scr * { animation: none !important; transition: none !important; }
                        .wu-cf2-row, .wu-cf2-row::before, .wu-cf2-row h3, .wu-cf2-body p { transition: none; }
                    }
                    /* CONTENT: five big cards that stack over each other as you scroll, each with its own phone */
                    .wu-cf3 { display: grid; gap: clamp(16px, 2vw, 28px); margin-top: clamp(36px, 4vw, 64px); }
                    .wu-cf3-card { --bg: #0c0e08; --fg: #fff; --mut: rgba(255, 255, 255, .78); --ac: #C2F760;
                        position: sticky; top: calc(96px + var(--i) * 16px); display: grid; grid-template-columns: minmax(0, 1.12fr) minmax(0, .88fr); gap: clamp(20px, 3vw, 56px); align-items: stretch; overflow: hidden;
                        min-height: clamp(420px, 36vw, 500px); padding: clamp(26px, 3.6vw, 56px) clamp(26px, 3.6vw, 56px) 0; border-radius: clamp(22px, 2.6vw, 36px); background: var(--bg); color: var(--fg);
                        box-shadow: 0 -18px 40px -24px rgba(0, 0, 0, .35), 0 30px 60px -34px rgba(20, 28, 4, .55); }
                    .wu-cf3-card.v2 { --bg: linear-gradient(135deg, #CFE866, #98B63A); --fg: #11150a; --mut: rgba(17, 21, 10, .78); --ac: #11150a; }
                    .wu-cf3-card.v3 { --bg: linear-gradient(150deg, #263010, #12160a); }
                    .wu-cf3-card.v4 { --bg: #F4F1E8; --fg: #0A0A0A; --mut: rgba(10, 10, 10, .72); --ac: #5B7A12; box-shadow: 0 0 0 1px rgba(10, 10, 10, .08), 0 -18px 40px -24px rgba(0, 0, 0, .25), 0 30px 60px -34px rgba(20, 28, 4, .4); }
                    .wu-cf3-card.v5 { --bg: radial-gradient(70% 90% at 100% 0%, rgba(194, 224, 90, .28), transparent 70%), #0a0b07; }
                    .wu-cf3-copy { align-self: center; padding-bottom: clamp(26px, 3.6vw, 56px); }
                    .wu-cf3-top { display: flex; align-items: baseline; gap: 10px; margin-bottom: clamp(14px, 1.6vw, 24px); }
                    .wu-cf3-n { font-size: clamp(54px, 6.4vw, 100px); font-weight: 500; letter-spacing: -.06em; line-height: .9; color: transparent; -webkit-text-stroke: 1.5px var(--ac); }
                    .wu-cf3-of { font-size: 14px; letter-spacing: .14em; color: var(--mut); }
                    #wu-smm .wu-cf3-copy h3 { font-size: clamp(26px, 3vw, 46px); font-weight: 500; letter-spacing: -.04em; line-height: 1.04; color: var(--fg); }
                    #wu-smm .wu-cf3-copy p { margin-top: 14px; max-width: 58ch; font-size: clamp(15.5px, 1.12vw, 17.5px); line-height: 1.7; color: var(--mut); }
                    #wu-smm .wu-cf3-copy h3 + p { margin-top: clamp(14px, 1.6vw, 22px); }
                    .wu-cf3-stage { position: relative; display: grid; place-items: end center; }
                    .wu-cf3-glow { position: absolute; bottom: -20%; width: min(100%, 420px); aspect-ratio: 1; border-radius: 50%; background: radial-gradient(closest-side, var(--ac), transparent 70%); opacity: .45; filter: blur(12px); }
                    .wu-cf3-card.v2 .wu-cf3-glow { opacity: .35; background: radial-gradient(closest-side, #fff, transparent 70%); }
                    .wu-cf3-stage .wu-phone { width: clamp(208px, 19vw, 270px); margin-bottom: clamp(-150px, -9vw, -90px); transform: rotate(3deg); transition: transform .8s cubic-bezier(.2, .8, .2, 1); }
                    .wu-cf3-card:nth-child(even) .wu-phone { transform: rotate(-3deg); }
                    .wu-cf3-card:hover .wu-phone { transform: rotate(0deg) translateY(-12px); }
                    @media (max-width: 860px) {
                        .wu-cf3-card { position: relative; top: 0; grid-template-columns: minmax(0, 1fr); min-height: 0; }
                        .wu-cf3-copy { padding-bottom: 0; }
                        .wu-cf3-stage .wu-phone { width: min(230px, 62vw); margin-bottom: -120px; }
                        .wu-cf3-stage { padding-top: 10px; }
                    }
                    @media (prefers-reduced-motion: reduce) { .wu-cf3-stage .wu-phone { transition: none; } .wu-cf3-card { position: relative; top: 0; } }
                    /* eyebrow pill above each section heading: the homepage's .eyebrow (white pill with an olive dot on dark, black pill with a lime dot on white) */
                    #wu-smm .wu-eb { display: inline-flex; align-items: center; gap: 10px; width: fit-content; margin: 0; padding: 10px 20px 10px 18px; border-radius: 999px; background: #fff; color: #11150a; font-size: 14px; font-weight: 500; line-height: 1.2; letter-spacing: 0; text-transform: none; transition: translate .5s cubic-bezier(.2, .8, .2, 1); }
                    #wu-smm .wu-eb::before { content: none; }
                    #wu-smm .wu-eb__dot { flex: none; width: 8px; height: 8px; border-radius: 50%; background: #5e8a14; }
                    #wu-smm-content .wu-eb, #wu-smm-strategy .wu-eb { background: #11150a; color: #fff; }
                    #wu-smm-content .wu-eb__dot, #wu-smm-strategy .wu-eb__dot { background: #beda52; box-shadow: 0 0 8px rgba(190, 218, 82, .7); }
                    #wu-smm .wu-eb:hover { translate: 0 -2px; }
                    @media (max-width: 767px) { #wu-smm .wu-eb { padding: 7px 14px 7px 12px; gap: 8px; font-size: 12.5px; } #wu-smm .wu-eb__dot { width: 6px; height: 6px; } }
                    #wu-smm-stats .wu-eb { margin-bottom: 22px; }
                    @media (max-width: 1100px) { .wu-plats { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
                    @media (max-width: 560px) { .wu-plats { grid-template-columns: 1fr; } .wu-plat { min-height: 440px; } }

                    /* strip sits flush under the intro: no gap above it, no bottom rule on the intro */
                    #wu-smm-intro { border-bottom: 0; padding-bottom: clamp(48px, 5vw, 80px); }

                    /* headings break at the meaning: the lead phrase on line one in lime, the payoff on line two in white */
                    #wu-smm h2 .wu-hl, #wu-smm h2 .wu-hw { display: block; }
                    #wu-smm h2 .wu-hw { color: #fff; }
                    #wu-smm-content h2 .wu-hw, #wu-smm-strategy h2 .wu-hw { color: inherit; }
                    #wu-smm-content h2 .wu-hl { color: #5B7A12; }

                    /* heading rows: title on its own full line, description beneath; two-line headings keep their break */
                    #wu-smm .wu-sec-head { grid-template-columns: 1fr; gap: clamp(14px, 1.6vw, 22px); align-items: start; }
                    #wu-smm .wu-sec-head-right { max-width: 760px; }
                    #wu-smm-content h2.wu-h2 .wu-hl { color: #5B7A12; }
                    .wu-cta-box h2 { max-width: none; text-wrap: initial; }
                    @media (min-width: 760px) { .wu-cta-box h2 .wu-hl, .wu-cta-box h2 .wu-hw { white-space: nowrap; } }

                    /* original brand logos named in each card's description */
                    .wu-plat-ico { gap: 8px; flex-wrap: wrap; right: 70px; }
                    .wu-plat-ico svg { width: 24px; height: 24px; }
                    .wu-logo { display: grid; place-items: center; width: 46px; height: 46px; border-radius: 14px; color: #fff; box-shadow: 0 10px 24px -12px rgba(0, 0, 0, .8); }
                    .wu-logo svg { fill: currentColor; }
                    .wu-logo--ig { background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%); }
                    .wu-logo--fb { background: #0866FF; }
                    .wu-logo--in { background: #0A66C2; }
                    .wu-logo--yt { background: #FF0000; }
                    .wu-logo--x, .wu-logo--th { background: #000; box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .35); }
                    .wu-logo--pin { background: #E60023; }
                    .wu-logo--snap { background: #FFFC00; color: #000; }
                    .wu-sr { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); white-space: nowrap; }

                    /* platforms: compact cards, no big empty middle; logos sit right above the title */
                    .wu-plats { align-items: start; }
                    .wu-plat { min-height: 0; justify-content: flex-start; gap: 0; padding: 28px; }
                    .wu-plat-ico { position: static; right: auto; margin: 0 0 clamp(28px, 3vw, 44px); padding-right: 48px; }
                    .wu-plat.is-open .wu-plat-ico { opacity: 1; transform: none; }
                    .wu-plat h3 { font-size: clamp(22px, 1.9vw, 28px); min-height: 2.16em; }
                    .wu-plat-desc { position: static; display: block; max-height: 0; overflow: hidden; padding: 0; margin: 0; font-size: 14px; line-height: 1.6; opacity: 0; transform: none; transition: max-height .6s cubic-bezier(.2, .8, .2, 1), opacity .4s, margin .4s; }
                    #wu-smm .wu-plat.is-open .wu-plat-desc { opacity: 1; margin: 24px 0 0; }
                    .wu-plat-plus { margin-top: 22px; }
                    #wu-smm .wu-plat-desc { transition: max-height .6s cubic-bezier(.4, 0, .2, 1), opacity .45s ease .05s, margin .6s cubic-bezier(.4, 0, .2, 1); }
                    .wu-plat { transition: box-shadow .5s, background .5s; }
                    .wu-plat.is-open { transform: none; }
                </style>

                <div id="wu-smm">

                    <div id="wu-smm-progress"></div>
                    <a id="wu-smm-totop" href="#wu-smm-top" aria-label="Back to top">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 19V5"></path>
                            <path d="M6 11l6-6 6 6"></path>
                        </svg>
                    </a>

                    <span id="wu-smm-top"></span>

                    <!-- HERO -->
                    <section id="wu-smm-hero" class="wu-section" data-tilt-root>
                        <div class="wu-grain"></div>
                        <div class="wu-fade-bottom"></div>

                        <div class="wu-hero-copy">
                            <h1 class="wu-hero-pill" data-reveal><span class="wu-badge-dot" aria-hidden="true"></span>Social Media Marketing Agency in Kerala</h1>
                            <h2 class="wu-hero-title" data-reveal>Chasing Every Trend, But Still Waiting for <span class="wu-shine" data-word data-shine>Results?</span></h2>
                            <p class="wu-h-lede2" data-reveal data-delay="300">That's what WiseUp is here to fix. We understand how social media algorithms work, what each platform rewards, and how to turn that into lasting visibility. Our approach to social media marketing in Kerala goes beyond following trends; we focus on what works for your brand.</p>
                        </div>

                        <div class="wu-hero-fan">
                            <div style="flex:0 1 200px;margin-top:70px"><img
                                    src="<?php echo esc_url($smm_assets . 'case-bootland.jpg'); ?>"
                                    alt="Bootland event branding" style="transform:rotate(-8deg)"></div>
                            <div style="flex:0 1 220px;margin-top:20px"><img
                                    src="<?php echo esc_url($smm_assets . 'case-indusgo.jpg'); ?>"
                                    alt="IndusGo campaign" style="transform:rotate(-3deg)"></div>
                            <div style="flex:0 1 250px"><img
                                    src="https://wiseup.in/wp-content/uploads/2026/03/Group-3.png"
                                    alt="WiseUp growth reel" style="background:#0b0f0a"></div>
                            <div style="flex:0 1 220px;margin-top:20px"><img
                                    src="<?php echo esc_url($smm_assets . 'case-karak.jpg'); ?>"
                                    alt="Golden Karak social" style="transform:rotate(3deg)"></div>
                            <div style="flex:0 1 200px;margin-top:70px"><img
                                    src="<?php echo esc_url($smm_assets . 'case-erets.jpg'); ?>"
                                    alt="Erets Space launch" style="transform:rotate(8deg)"></div>
                        </div>

                    </section>

                    <!-- INTRO -->
                    <section id="wu-smm-intro" class="wu-section">
                        <div class="wu-inner">
                            <div class="wu-intro">
                                <p class="wu-intro-text" data-reveal>WiseUp is a social media marketing agency in Kerala that brings strategy, creative work, and platform expertise together to help businesses build a stronger online presence. We work alongside you at every stage of your social media journey, from understanding your audience to creating campaigns that support measurable business goals.</p>
                                <p class="wu-intro-punch" data-reveal data-delay="150">And we hold ourselves to a simple standard: the work should always speak for itself.</p>
                            </div>
                        </div>
                    </section>

                    <!-- CLIENT LOGOS: the homepage's own strip -->
                    <div class="wiseup-home wiseup-in-theme wu-chrome wu-logos">
<section class="logos" aria-label="Brands we have worked with">
	<div class="logos__marquee">
		<div class="logos__row">
			<div class="logos__track">
				<ul>
					<li class="is-tile" style="--drop-delay: 0ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/amarapushpa.webp" alt="Amarapushpa" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 50ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/bm-prime.webp" alt="BM Prime" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 100ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/bucho.webp" alt="Bucho" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 150ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/cadd.webp" alt="CADD" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 200ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/cellar-de-mahe.webp" alt="Cellar de mahe" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 250ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/clair-veda.webp" alt="Clair veda" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 300ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/eduwizz.webp" alt="Eduwizz" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 350ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/ellisto.webp" alt="Ellisto" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 400ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/erets.webp" alt="Erets" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 450ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/flora-fauna.webp" alt="Flora fauna" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 500ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/formaa.webp" alt="Formaa" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 550ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/gloveda.webp" alt="Gloveda" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 600ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/goldekarak.webp?v=2" class="logo--original" alt="Goldekarak" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 650ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/hayath.webp" alt="Hayath" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 700ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/intervel.webp" alt="Intervel" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 750ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/lullaby.webp" alt="Lullaby" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 800ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/lunar.webp" alt="Lunar" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 850ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/mgf.webp" alt="MGF" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 900ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/mooss.webp" alt="mooss" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 950ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/onesto-marcado.webp" alt="Onesto Marcado" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 1000ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/philips.webp" alt="Philips" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 1050ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/popees.webp" alt="Popees" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 1100ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/sathya.webp" alt="Sathya" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 1150ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/superhuman.webp" alt="Superhuman" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 1200ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/tiny-mafia.webp" alt="Tiny Mafia" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 1250ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/wellah.webp" alt="Wellah" loading="lazy" decoding="async"></li>
				</ul>
				<ul aria-hidden="true">
					<li class="is-tile" style="--drop-delay: 0ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/amarapushpa.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 50ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/bm-prime.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 100ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/bucho.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 150ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/cadd.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 200ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/cellar-de-mahe.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 250ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/clair-veda.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 300ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/eduwizz.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 350ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/ellisto.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 400ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/erets.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 450ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/flora-fauna.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 500ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/formaa.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 550ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/gloveda.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 600ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/goldekarak.webp?v=2" class="logo--original" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 650ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/hayath.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 700ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/intervel.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 750ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/lullaby.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 800ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/lunar.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 850ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/mgf.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 900ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/mooss.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 950ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/onesto-marcado.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 1000ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/philips.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 1050ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/popees.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 1100ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/sathya.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 1150ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/superhuman.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 1200ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/tiny-mafia.webp" alt="" loading="lazy" decoding="async"></li>
					<li class="is-tile" style="--drop-delay: 1250ms"><img src="<?php echo esc_url( WISEUP_ASSETS ); ?>/clients/client-logos-2026/wellah.webp" alt="" loading="lazy" decoding="async"></li>
				</ul>
			</div>
		</div>
	</div>
</section>
                    </div>

                    <!-- VISIBILITY -->
                    <section id="wu-smm-visibility" class="wu-section">
                        <div class="wu-inner">
                            <div class="wu-visibility-copy">
                                <span class="wu-eb"><span class="wu-eb__dot" aria-hidden="true"></span>Visibility</span>
<h2 class="wu-h2" data-reveal><span class="wu-hl">Before we create,</span> <span class="wu-hw">we understand.</span></h2>
                                <p class="wu-lede-big" data-reveal><span class="wu-q" aria-hidden="true">“</span>5.79 billion people are represented by social media user identities worldwide, with 294 million added in the past year.<span class="wu-q" aria-hidden="true">”</span></p>
                                <p class="wu-lede-sm" data-reveal>Your audience is already online. And with more people joining every year, social media marketing has become an important way for brands to stay visible and relevant. A strong social media presence is not built by publishing more often. This is where most social media management agencies go wrong.</p>
                                <p class="wu-lede-sm" data-reveal>At WiseUp, we start by identifying what your audience values. We understand your brand's positioning, your competitors' blind spots, your audience habits, and the platforms they spend their time on. We map it all before a single piece of content takes shape. Because meaningful visibility comes from showing up in the right places with content that connects with your audience, in a voice distinctly yours. That's how we help turn a brand into one people recognise, remember, return to, and eventually trust enough to choose.</p>
                            </div>
                            <div class="wu-visibility-img" data-reveal>
                                <img data-parallax-img="0.12"
                                    src="https://wiseup.in/wp-content/uploads/2026/10/DSC00377-copy.webp"
                                    alt="The WiseUp team">
                            </div>
                        </div>
                    </section>

                    <!-- SERVICES -->
                    <section id="wu-smm-services" class="wu-section">
                        <div class="wu-inner">
                            <div class="wu-sec-head">
                                <div class="wu-sec-head-left">
                                    <span class="wu-eb"><span class="wu-eb__dot" aria-hidden="true"></span>Services</span>
<h2 class="wu-h2" data-reveal><span class="wu-hl">Everything Your Brand Needs,</span> <span class="wu-hw">All in One Place</span></h2>
                                </div>
                                <p class="wu-sec-head-right" data-reveal>At WiseUp, we know our job as a social media marketing company isn't to fill your feed. It's to build a lasting, meaningful presence for your brand. That's why our social media marketing services take an end-to-end approach, bringing strategy, content, and campaign management together. Whether you need individual SMM services or a complete social media management solution, we build an approach around your business goals.</p>
                            </div>

                            <div id="wu-smm-svc-wrap">
                                <?php
                                $services = [
                                    [
                                        'img' => 'https://wiseup.in/wp-content/uploads/2026/04/Automate-Smarter-Growth-copy.webp',
                                        'title' => 'Social Media Strategy',
                                        'desc' => 'Effective results begin with the right questions. Who is your audience, what matters to them, and where are your competitors falling short? As the best social media marketing agency in Calicut, we address these before we start the work. From there, we select the platforms worth your investment, develop the content plan, and build a campaign strategy where every post serves a clear purpose.',
                                        'tags' => [],
                                    ],
                                    [
                                        'img' => $smm_assets . 'case-karak.jpg',
                                        'title' => 'Social Media Management',
                                        'desc' => 'Consistency is essential for brands to stay on top. Managing a social media account by scheduling and publishing content is just one part of it. We engage with your audience across comments and direct messages so they stay connected. We also review performance regularly and refine our approach to stay relevant and improve results with each cycle.',
                                        'tags' => [],
                                    ],
                                    [
                                        'img' => $smm_assets . 'case-bootland.jpg',
                                        'title' => 'Content Creation',
                                        'desc' => 'Every piece of content we create is designed to capture interest. Posts, graphics, carousels, reels, videos, and stories – we tailor each format to your target audience and the platform it\'s made for. Every caption reflects your brand\'s voice, and every creative is designed to make your message clear and memorable.',
                                        'tags' => [],
                                    ],
                                    [
                                        'img' => 'https://wiseup.in/wp-content/uploads/2026/04/Scale-Campaigns-with-Data-copy.webp',
                                        'title' => 'Paid Social Media Advertising',
                                        'desc' => 'Organic reach is important, but paid campaigns help put your brand in front of the right audience at the right time. We plan and manage targeted ads, lead and traffic campaigns, and retargeting to reconnect with people who showed interest but haven\'t converted yet. We continuously monitor performance, track results, and optimise your campaigns to make the most out of your advertising budget.',
                                        'tags' => [],
                                    ],
                                    [
                                        'img' => $smm_assets . 'case-indusgo.jpg',
                                        'title' => 'Social Media Branding Services',
                                        'desc' => 'A distinct visual identity and a clear brand voice go a long way in building trust. Our social media branding services help brands stand out with an identity that is instantly recognisable. We build a cohesive brand presence across all platforms through consistent visuals, a credible voice, and memorable messages. The goal is simple: make your audience recognise your brand even before they read its name.',
                                        'tags' => [],
                                    ],
                                    [
                                        'img' => $smm_assets . 'case-erets.jpg',
                                        'title' => 'Influencer Marketing',
                                        'desc' => 'The right influencer can introduce your brand to audiences who may otherwise never discover it. Only the best SMM agency can identify, connect and pair your brand with well-matched creators who have already built a trusted following. The partnership value is not measured simply by follower count, but by audience fit, influencer credibility and genuine engagement, so the collaborations feel authentic and deliver lasting value.',
                                        'tags' => [],
                                    ],
                                ];
                                foreach ($services as $i => $s):
                                    $num = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
                                    ?>
                                    <div class="wu-svc-panel<?php echo $i === 0 ? ' is-active' : ''; ?>"
                                        data-svc-panel="<?php echo $i; ?>">
                                        <img class="wu-svc-img" src="<?php echo esc_url($s['img']); ?>"
                                            alt="<?php echo esc_attr($s['title']); ?>">
                                        <div class="wu-svc-shade"></div>
                                        <div class="wu-svc-top">
                                            <span class="wu-svc-arrow"><svg width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M7 17L17 7"></path>
                                                    <path d="M8.5 7H17v8.5"></path>
                                                </svg></span>
                                        </div>
                                        <div class="wu-svc-vertlabel">
                                            <span><?php echo esc_html($s['title']); ?></span>
                                        </div>
                                        <div class="wu-svc-body">
                                            <h3><?php echo esc_html($s['title']); ?></h3>
                                            <p><?php echo $s['desc']; ?></p>
                                            <div class="wu-tag-row">
                                                <?php foreach ($s['tags'] as $tag): ?>
                                                    <span class="wu-tag"><?php echo esc_html($tag); ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </section>

                    <!-- PLATFORMS -->
                    <section id="wu-smm-platforms" class="wu-section">
                        <div class="wu-inner">
                            <div class="wu-sec-head">
                                <div class="wu-sec-head-left">
                                    <span class="wu-eb"><span class="wu-eb__dot" aria-hidden="true"></span>Platforms</span>
<h2 class="wu-h2" data-reveal><span class="wu-hl">Social Media Marketing</span> <span class="wu-hw">Platforms We Work With</span></h2>
                                </div>
                                <p class="wu-sec-head-right" data-reveal>Being everywhere doesn't require a strategy. Our social media marketing experts select platforms based on your industry, goals, and content style. WiseUp puts your brand where your audience is, so that your time, investment, and effort only go where they make an impact.</p>
                            </div>
                            <div class="wu-plats" data-plats>
                                <?php
                                $platforms = [
                                    ['Instagram & Facebook (Meta)', 'Nothing beats Meta for brands where visual appeal, community, and reach matter most. From crafting reels, stories, and carousels to engaging with your community, we manage your Instagram and Facebook pages end to end. With targeted Meta ads and retargeting campaigns, we turn the interest we generate into leads and enquiries.'],
                                    ['LinkedIn', 'For companies that depend on professional relationships, LinkedIn is our platform of choice. We create company pages that strengthen your brand\'s industry presence and thought leadership, and publish founder-led content and industry insights that position your brand as a credible voice in your industry. Our LinkedIn campaigns are designed to generate leads of substance and drive real business opportunities.'],
                                    ['YouTube', 'YouTube Shorts are a great way for brands to open the doorway to discovery, while educational long-form videos and explainers build trust and confidence. With YouTube SEO, video campaigns and channel optimisation, we position your brand to be discovered and remembered by the right audience.'],
                                    ['X & Emerging Platforms', 'Every platform has its own audience, culture and pace. X and Threads offer opportunities to participate in real-time conversations, while Pinterest and Snapchat help brands connect with audiences through specific interests and content formats. WiseUp recommends these platforms selectively, based on whether they offer a relevant opportunity to reach your target audience.'],
                                ];
                                $plat_icons = array(
                                    '<span class="wu-logo wu-logo--ig" role="img" aria-label="Instagram" title="Instagram"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7.0301.084c-1.2768.0602-2.1487.264-2.911.5634-.7888.3075-1.4575.72-2.1228 1.3877-.6652.6677-1.075 1.3368-1.3802 2.127-.2954.7638-.4956 1.6365-.552 2.914-.0564 1.2775-.0689 1.6882-.0626 4.947.0062 3.2586.0206 3.6671.0825 4.9473.061 1.2765.264 2.1482.5635 2.9107.308.7889.72 1.4573 1.388 2.1228.6679.6655 1.3365 1.0743 2.1285 1.38.7632.295 1.6361.4961 2.9134.552 1.2773.056 1.6884.069 4.9462.0627 3.2578-.0062 3.668-.0207 4.9478-.0814 1.28-.0607 2.147-.2652 2.9098-.5633.7889-.3086 1.4578-.72 2.1228-1.3881.665-.6682 1.0745-1.3378 1.3795-2.1284.2957-.7632.4966-1.636.552-2.9124.056-1.2809.0692-1.6898.063-4.948-.0063-3.2583-.021-3.6668-.0817-4.9465-.0607-1.2797-.264-2.1487-.5633-2.9117-.3084-.7889-.72-1.4568-1.3876-2.1228C21.2982 1.33 20.628.9208 19.8378.6165 19.074.321 18.2017.1197 16.9244.0645 15.6471.0093 15.236-.005 11.977.0014 8.718.0076 8.31.0215 7.0301.0839m.1402 21.6932c-1.17-.0509-1.8053-.2453-2.2287-.408-.5606-.216-.96-.4771-1.3819-.895-.422-.4178-.6811-.8186-.9-1.378-.1644-.4234-.3624-1.058-.4171-2.228-.0595-1.2645-.072-1.6442-.079-4.848-.007-3.2037.0053-3.583.0607-4.848.05-1.169.2456-1.805.408-2.2282.216-.5613.4762-.96.895-1.3816.4188-.4217.8184-.6814 1.3783-.9003.423-.1651 1.0575-.3614 2.227-.4171 1.2655-.06 1.6447-.072 4.848-.079 3.2033-.007 3.5835.005 4.8495.0608 1.169.0508 1.8053.2445 2.228.408.5608.216.96.4754 1.3816.895.4217.4194.6816.8176.9005 1.3787.1653.4217.3617 1.056.4169 2.2263.0602 1.2655.0739 1.645.0796 4.848.0058 3.203-.0055 3.5834-.061 4.848-.051 1.17-.245 1.8055-.408 2.2294-.216.5604-.4763.96-.8954 1.3814-.419.4215-.8181.6811-1.3783.9-.4224.1649-1.0577.3617-2.2262.4174-1.2656.0595-1.6448.072-4.8493.079-3.2045.007-3.5825-.006-4.848-.0608M16.953 5.5864A1.44 1.44 0 1 0 18.39 4.144a1.44 1.44 0 0 0-1.437 1.4424M5.8385 12.012c.0067 3.4032 2.7706 6.1557 6.173 6.1493 3.4026-.0065 6.157-2.7701 6.1506-6.1733-.0065-3.4032-2.771-6.1565-6.174-6.1498-3.403.0067-6.156 2.771-6.1496 6.1738M8 12.0077a4 4 0 1 1 4.008 3.9921A3.9996 3.9996 0 0 1 8 12.0077"/></svg></span><span class="wu-logo wu-logo--fb" role="img" aria-label="Facebook" title="Facebook"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 2.103-.287 1.564h-3.246v8.245C19.396 23.238 24 18.179 24 12.044c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.628 3.874 10.35 9.101 11.647Z"/></svg></span>',
                                    '<span class="wu-logo wu-logo--in" role="img" aria-label="LinkedIn" title="LinkedIn"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></span>',
                                    '<span class="wu-logo wu-logo--yt" role="img" aria-label="YouTube" title="YouTube"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></span>',
                                    '<span class="wu-logo wu-logo--x" role="img" aria-label="X" title="X"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg></span><span class="wu-logo wu-logo--th" role="img" aria-label="Threads" title="Threads"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12.186 24h-.007c-3.581-.024-6.334-1.205-8.184-3.509C2.35 18.44 1.5 15.586 1.472 12.01v-.017c.03-3.579.879-6.43 2.525-8.482C5.845 1.205 8.6.024 12.18 0h.014c2.746.02 5.043.725 6.826 2.098 1.677 1.29 2.858 3.13 3.509 5.467l-2.04.569c-1.104-3.96-3.898-5.984-8.304-6.015-2.91.022-5.11.936-6.54 2.717C4.307 6.504 3.616 8.914 3.589 12c.027 3.086.718 5.496 2.057 7.164 1.43 1.783 3.631 2.698 6.54 2.717 2.623-.02 4.358-.631 5.8-2.045 1.647-1.613 1.618-3.593 1.09-4.798-.31-.71-.873-1.3-1.634-1.75-.192 1.352-.622 2.446-1.284 3.272-.886 1.102-2.14 1.704-3.73 1.79-1.202.065-2.361-.218-3.259-.801-1.063-.689-1.685-1.74-1.752-2.964-.065-1.19.408-2.285 1.33-3.082.88-.76 2.119-1.207 3.583-1.291a13.853 13.853 0 0 1 3.02.142c-.126-.742-.375-1.332-.75-1.757-.513-.586-1.308-.883-2.359-.89h-.029c-.844 0-1.992.232-2.721 1.32L7.734 7.847c.98-1.454 2.568-2.256 4.478-2.256h.044c3.194.02 5.097 1.975 5.287 5.388.108.046.216.094.321.142 1.49.7 2.58 1.761 3.154 3.07.797 1.82.871 4.79-1.548 7.158-1.85 1.81-4.094 2.628-7.277 2.65Zm1.003-11.69c-.242 0-.487.007-.739.021-1.836.103-2.98.946-2.916 2.143.067 1.256 1.452 1.839 2.784 1.767 1.224-.065 2.818-.543 3.086-3.71a10.5 10.5 0 0 0-2.215-.221z"/></svg></span><span class="wu-logo wu-logo--pin" role="img" aria-label="Pinterest" title="Pinterest"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"/></svg></span><span class="wu-logo wu-logo--snap" role="img" aria-label="Snapchat" title="Snapchat"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12.206.793c.99 0 4.347.276 5.93 3.821.529 1.193.403 3.219.299 4.847l-.003.06c-.012.18-.022.345-.03.51.075.045.203.09.401.09.3-.016.659-.12 1.033-.301.165-.088.344-.104.464-.104.182 0 .359.029.509.09.45.149.734.479.734.838.015.449-.39.839-1.213 1.168-.089.029-.209.075-.344.119-.45.135-1.139.36-1.333.81-.09.224-.061.524.12.868l.015.015c.06.136 1.526 3.475 4.791 4.014.255.044.435.27.42.509 0 .075-.015.149-.045.225-.24.569-1.273.988-3.146 1.271-.059.091-.12.375-.164.57-.029.179-.074.36-.134.553-.076.271-.27.405-.555.405h-.03c-.135 0-.313-.031-.538-.074-.36-.075-.765-.135-1.273-.135-.3 0-.599.015-.913.074-.6.104-1.123.464-1.723.884-.853.599-1.826 1.288-3.294 1.288-.06 0-.119-.015-.18-.015h-.149c-1.468 0-2.427-.675-3.279-1.288-.599-.42-1.107-.779-1.707-.884-.314-.045-.629-.074-.928-.074-.54 0-.958.089-1.272.149-.211.043-.391.074-.54.074-.374 0-.523-.224-.583-.42-.061-.192-.09-.389-.135-.567-.046-.181-.105-.494-.166-.57-1.918-.222-2.95-.642-3.189-1.226-.031-.063-.052-.15-.055-.225-.015-.243.165-.465.42-.509 3.264-.54 4.73-3.879 4.791-4.02l.016-.029c.18-.345.224-.645.119-.869-.195-.434-.884-.658-1.332-.809-.121-.029-.24-.074-.346-.119-1.107-.435-1.257-.93-1.197-1.273.09-.479.674-.793 1.168-.793.146 0 .27.029.383.074.42.194.789.3 1.104.3.234 0 .384-.06.465-.105l-.046-.569c-.098-1.626-.225-3.651.307-4.837C7.392 1.077 10.739.807 11.727.807l.419-.015h.06z"/></svg></span>');
                                foreach ($platforms as $pi => $p): ?>
                                    <article class="wu-plat" data-reveal data-delay="<?php echo $pi * 80; ?>" tabindex="0" role="button" aria-expanded="false">
                                        <span class="wu-plat-num"><?php echo str_pad($pi + 1, 2, '0', STR_PAD_LEFT); ?></span>
                                        <span class="wu-plat-ico"><?php echo $plat_icons[$pi]; ?></span>
                                        <h3><?php echo esc_html($p[0]); ?></h3>
                                        <span class="wu-plat-plus" aria-hidden="true"></span>
                                        <p class="wu-plat-desc"><?php echo $p[1]; ?></p>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </section>
                <script>
                    (function () {
                        var wrap = document.querySelector('[data-plats]');
                        if (!wrap) return;
                        var cards = [].slice.call(wrap.querySelectorAll('.wu-plat'));
                        var wide = function () { return matchMedia('(min-width: 1101px)').matches; };
                        window.addEventListener('resize', function () { wrap.style.height = ''; });
                        var measure = function (c, open) { var k = c.cloneNode(true); k.style.cssText = 'position:absolute;visibility:hidden;left:0;top:0;width:' + c.offsetWidth + 'px'; k.querySelectorAll('*').forEach(function (e) { e.style.transition = 'none'; }); k.style.transition = 'none'; if (open) { k.classList.add('is-open'); var kd = k.querySelector('.wu-plat-desc'); if (kd) kd.style.maxHeight = 'none'; } wrap.appendChild(k); var h = k.offsetHeight; wrap.removeChild(k); return h; };
                        var set = function (c, on) { if (on && wide() && !wrap.style.height) wrap.style.height = wrap.offsetHeight + 'px'; var shift = (on && wide()) ? Math.min(36, Math.round((measure(c, true) - measure(c, false)) / 2)) : 0; c.classList.toggle('is-open', on); c.setAttribute('aria-expanded', String(on)); var d = c.querySelector('.wu-plat-desc'); if (d) d.style.maxHeight = on ? d.scrollHeight + 'px' : '0px'; c.style.translate = '0 ' + (-shift) + 'px'; };
                        var hover = matchMedia('(hover: hover)').matches;
                        cards.forEach(function (c) {
                            c.addEventListener('click', function () { var on = hover ? true : !c.classList.contains('is-open'); cards.forEach(function (o) { set(o, false); }); set(c, on); });
                            c.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); c.click(); } });
                            if (hover) { c.addEventListener('mouseenter', function () { cards.forEach(function (o) { set(o, o === c); }); }); c.addEventListener('mouseleave', function () { set(c, false); }); }
                        });
                    })();
                </script>


                    <!-- CONTENT BENTO -->
                    <section id="wu-smm-content" class="wu-section">
                        <div class="wu-inner">
                            <div class="wu-sec-head">
                                <div class="wu-sec-head-left">
                                    <span class="wu-eb"><span class="wu-eb__dot" aria-hidden="true"></span>Content</span>
<h2 class="wu-h2" data-reveal><span class="wu-hl">Content That Makes People</span> <span class="wu-hw">Stop, Engage and Act</span></h2>
                                </div>
                                <p class="wu-sec-head-right" data-reveal>Only the best social media marketing agency can combine creative thinking, strong visuals, and clear messaging to produce content that works best for both your brand and the platform it appears on. WiseUp does that while handling English and regional languages like Malayalam, so your message gets to the right audiences for your brand. With every piece of content, our goal is to get people to notice, understand, engage with, and remember your message.</p>
                            </div>
                            <div class="wu-cf3" data-cf3>
                                <article class="wu-cf3-card v1" style="--i:0">
                                    <div class="wu-cf3-copy">
                                        <div class="wu-cf3-top"><span class="wu-cf3-n">01</span><span class="wu-cf3-of">/ 05</span></div>
                                        <h3>Social Media Creatives</h3>
                                        <p>A strong visual can stop even the most mindless scroll.</p>
                                        <p>We deliver branded graphics, promotional visuals, static posts, and creative concepts that are designed to break the scroll and capture people’s attention. Your brand identity stays intact, keeping your brand recognisable from one post to the next.</p>
                                    </div>
                                    <div class="wu-cf3-stage" aria-hidden="true">
                                        <span class="wu-cf3-glow"></span>
                                        <div class="wu-phone"><span class="wu-phone-notch"></span><div class="wu-phone-screen">
                                        <div class="ph-scr ph-post">
                                            <div class="ph-top"><i class="ph-av"></i><span class="ph-sk" style="width:38%"></span></div>
                                            <div class="ph-img"><img src="<?php echo esc_url($smm_assets . 'case-smokehouse.jpg'); ?>" alt="" loading="lazy"></div>
                                            <div class="ph-acts"><span class="ph-heart"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1-1.1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg></span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.6 8.6 0 0 1-3.6-.8L3 21l1.9-5.2A8.4 8.4 0 1 1 21 11.5z"/></svg><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4z"/></svg><span class="ph-grow"></span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg></div>
                                            <div class="ph-lines"><span class="ph-sk" style="width:82%"></span><span class="ph-sk" style="width:58%"></span></div>
                                        </div>
                                        </div></div>
                                    </div>
                                </article>
                                <article class="wu-cf3-card v2" style="--i:1">
                                    <div class="wu-cf3-copy">
                                        <div class="wu-cf3-top"><span class="wu-cf3-n">02</span><span class="wu-cf3-of">/ 05</span></div>
                                        <h3>Reels and Short-Form Videos</h3>
                                        <p>At WiseUp, we create short-form content by taking the pulse of your audience and understanding their watching habits. Our reel concepts, hooks, and scripts are all shaped by audience behaviour and relevant platform trends, designed to grab their attention instantly and hold it until the end.</p>
                                    </div>
                                    <div class="wu-cf3-stage" aria-hidden="true">
                                        <span class="wu-cf3-glow"></span>
                                        <div class="wu-phone"><span class="wu-phone-notch"></span><div class="wu-phone-screen">
                                        <div class="ph-scr ph-reel">
                                            <img src="https://wiseup.in/wp-content/uploads/2026/03/Group-3.png" alt="" loading="lazy">
                                            <div class="ph-rail"><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1-1.1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg></span><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.6 8.6 0 0 1-3.6-.8L3 21l1.9-5.2A8.4 8.4 0 1 1 21 11.5z"/></svg></span><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4z"/></svg></span></div>
                                            <div class="ph-cap"><span class="ph-sk" style="width:62%"></span><span class="ph-sk" style="width:40%"></span></div>
                                            <div class="ph-prog"><i></i></div>
                                        </div>
                                        </div></div>
                                    </div>
                                </article>
                                <article class="wu-cf3-card v3" style="--i:2">
                                    <div class="wu-cf3-copy">
                                        <div class="wu-cf3-top"><span class="wu-cf3-n">03</span><span class="wu-cf3-of">/ 05</span></div>
                                        <h3>Captions and Content Writing</h3>
                                        <p>Sometimes a powerful hook is all it takes for people to notice and remember.</p>
                                        <p>Through catchy captions, hooks, CTAs, campaign messaging, and persuasive storytelling, we not only give your brand a distinctive voice but also build lasting trust in your audience.</p>
                                    </div>
                                    <div class="wu-cf3-stage" aria-hidden="true">
                                        <span class="wu-cf3-glow"></span>
                                        <div class="wu-phone"><span class="wu-phone-notch"></span><div class="wu-phone-screen">
                                        <div class="ph-scr ph-hook">
                                            <div class="ph-type" data-type="Sometimes a powerful hook is all it takes for people to notice and remember."><span class="ph-typed"></span><b class="ph-caret"></b></div>
                                            <div class="ph-cta"><span class="ph-sk" style="width:46%"></span><i><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg></i></div>
                                        </div>
                                        </div></div>
                                    </div>
                                </article>
                                <article class="wu-cf3-card v4" style="--i:3">
                                    <div class="wu-cf3-copy">
                                        <div class="wu-cf3-top"><span class="wu-cf3-n">04</span><span class="wu-cf3-of">/ 05</span></div>
                                        <h3>Stories, Carousels and Interactive Content</h3>
                                        <p>Creating interactive content is an art that’s hard for even the best social media marketing companies to master. We create interactive stories, carousels, polls, and other social media content that invite your audience to respond, participate, and spark two-way conversations that bring your community closer.</p>
                                    </div>
                                    <div class="wu-cf3-stage" aria-hidden="true">
                                        <span class="wu-cf3-glow"></span>
                                        <div class="wu-phone"><span class="wu-phone-notch"></span><div class="wu-phone-screen">
                                        <div class="ph-scr ph-story">
                                            <img src="https://wiseup.in/wp-content/uploads/2026/04/Scale-Campaigns-with-Data-copy.webp" alt="" loading="lazy">
                                            <div class="ph-seg"><i></i><i></i><i></i><i></i></div>
                                            <div class="ph-poll"><span style="--w:64%"><b></b></span><span style="--w:36%"><b></b></span></div>
                                            <div class="ph-dots"><i></i><i></i><i></i></div>
                                        </div>
                                        </div></div>
                                    </div>
                                </article>
                                <article class="wu-cf3-card v5" style="--i:4">
                                    <div class="wu-cf3-copy">
                                        <div class="wu-cf3-top"><span class="wu-cf3-n">05</span><span class="wu-cf3-of">/ 05</span></div>
                                        <h3>Campaign Creatives</h3>
                                        <p>We create campaign assets for launches, promotions, seasonal moments, and other marketing initiatives that align with your campaign goals. Each campaign is built on a creative idea that makes people stop and pay attention, brought to life through compelling visuals and messaging that connect with your audience and inspire them to take action.</p>
                                    </div>
                                    <div class="wu-cf3-stage" aria-hidden="true">
                                        <span class="wu-cf3-glow"></span>
                                        <div class="wu-phone"><span class="wu-phone-notch"></span><div class="wu-phone-screen">
                                        <div class="ph-scr ph-camp">
                                            <img src="<?php echo esc_url($smm_assets . 'case-erets.jpg'); ?>" alt="" loading="lazy">
                                            <span class="ph-ring"></span><span class="ph-ring ph-ring--2"></span>
                                            <span class="ph-live"><i></i></span>
                                            <div class="ph-cta ph-cta--camp"><span class="ph-sk" style="width:52%"></span><i><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg></i></div>
                                        </div>
                                        </div></div>
                                    </div>
                                </article>
                            </div>
                            <script>
                            (function () {
                                var cards = [].slice.call(document.querySelectorAll('.wu-cf3-card')); if (!cards.length) return;
                                var reduced = matchMedia('(prefers-reduced-motion: reduce)').matches, typer = 0;
                                var typed = document.querySelector('.ph-typed'), full = document.querySelector('.ph-type').getAttribute('data-type');
                                var type = function () {
                                    clearInterval(typer); typed.textContent = '';
                                    if (reduced) { typed.textContent = full; return; }
                                    var k = 0; typer = setInterval(function () { k++; typed.textContent = full.slice(0, k); if (k >= full.length) clearInterval(typer); }, 42);
                                };
                                var set = function (card, on) {
                                    var sc = card.querySelector('.ph-scr'); if (!sc || sc.classList.contains('is-on') === on) return;
                                    sc.classList.remove('is-on'); if (on) { void sc.offsetWidth; sc.classList.add('is-on'); }
                                    if (sc.classList.contains('ph-hook')) { if (on) type(); else { clearInterval(typer); typed.textContent = ''; } }
                                };
                                if (!('IntersectionObserver' in window)) { cards.forEach(function (c) { set(c, true); }); return; }
                                var io = new IntersectionObserver(function (es) { es.forEach(function (e) { set(e.target, e.isIntersecting && e.intersectionRatio > 0.3); }); }, { threshold: [0, 0.3, 0.6] });
                                cards.forEach(function (c) { io.observe(c); });
                            })();
                            </script>
                        </div>
                    </section>

                    <!-- STRATEGY -->
                    <section id="wu-smm-strategy" class="wu-section">
                        <div class="wu-spin-deco" data-spin></div>
                        <div class="wu-inner">
                            <div class="wu-strategy-quote" data-reveal>
                                <span class="wu-eb"><span class="wu-eb__dot" aria-hidden="true"></span>Strategy</span>
<h2>Strategy That Hits Your Target</h2>
                                <p class="wu-p1">We don’t shoot blindly and expect to hit the target. We first understand your brand, your audience, and the market before we begin, so our efforts land where they should.</p>
                            </div>
                            <div class="wu-strategy-grid">
                                <?php
                                $strategy = [
                                    ['Audience & Customer Insights', 'Who are you really talking to? Our job as the best social media marketing agency in Kerala is to map what your audience cares about, how they spend their time on social media, and what makes them hit that “like”, “follow,” or “share”. Your content then speaks to real behaviour, not generic marketing theories or broad assumptions.'],
                                    ['Competitor & Market Research', 'We analyse your competitors and industry trends and identify the content gaps others haven\'t tapped into yet. That\'s where we position your brand to offer something unique, rise above the crowd, and gain a competitive advantage.'],
                                    ['Content Pillars & Brand Voice', 'A few core themes and a recognisable tone are key to a strong brand. We set your pillars, key messages, and voice so your brand stays consistent, on-brand, instantly recognisable, and memorable.'],
                                    ['Platform & Content Strategy', 'Not every platform fits every brand. Not every brand needs to be on every platform. We pick the right channels, formats and posting rhythm based on two main factors: where your audience is most active and what your business wants to achieve.'],
                                    ['Campaign Planning & Optimisation', 'We build campaigns around clear, measurable goals. Once the goal is set, we plan around it, track performance, and refine our approach based on what works best for your brand.'],
                                ];
                                $strategy_icons = [
                                    '<circle cx="9" cy="8" r="3.5"></circle><path d="M2.5 20c.8-3.6 3.4-5.5 6.5-5.5s5.7 1.9 6.5 5.5"></path><circle cx="17.5" cy="9.5" r="2.5"></circle><path d="M16.5 14.6c2.6.2 4.3 1.9 5 4.9"></path>',
                                    '<rect x="3" y="4" width="18" height="16" rx="4"></rect><path d="M10 9.2v5.6l4.8-2.8z" fill="currentColor"></path>',
                                ];
                                foreach ($strategy as $i => $st):
                                    $dark = $i % 2 === 0; ?>
                                <div class="wu-strategy-card <?php echo $dark ? 'is-dark' : 'is-lime'; ?>" data-tilt data-reveal data-delay="<?php echo ($i % 2) * 120; ?>">
                                    <span class="wu-strategy-icon <?php echo $dark ? 'is-lime' : 'is-black'; ?>"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><?php echo $strategy_icons[$i % 2]; ?></svg></span>
                                    <h3><?php echo esc_html($st[0]); ?></h3>
                                    <p><?php echo $st[1]; ?></p>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </section>

                    <!-- PROCESS -->
                    <section id="wu-smm-process" class="wu-section">
                        <div class="wu-inner">
                            <div class="wu-proc-left">
                                <span class="wu-eb"><span class="wu-eb__dot" aria-hidden="true"></span>Process</span>
<h2 class="wu-h2" data-reveal><span class="wu-hl">From Ideas to Campaigns:</span> <span class="wu-hw">How we work</span></h2>
                            </div>
                            <div class="wu-proc-track" id="wu-smm-proc-track">
                                <div class="wu-proc-rail"></div>
                                <div class="wu-proc-fill" id="wu-smm-proc-fill"></div>
                                <?php
                                $steps = [
                                    ['Discover', 'At WiseUp, we start by getting to know your business inside out. We study your audience, competitors, and the local market to understand what shapes social media marketing in Kerala and what will work for your business. This helps us build a strong foundation for the work ahead.'],
                                    ['Strategise', 'With a clear understanding of your brand and goals, we map out the platforms, content pillars, and campaign ideas for your social media. We develop a tailored roadmap that defines what to communicate and where, all aimed towards your larger business objectives.'],
                                    ['Create', 'Our creative team brings the strategy to life through content designed specifically for your brand– graphics, videos, reels, campaign copy, etc. that reflect your brand identity, speak in your distinct brand voice, and connect with your audience.'],
                                    ['Publish &amp; Promote', 'We put your content in front of the right people through strategic publishing and targeted campaigns, helping your brand build visibility and move closer to your brand goals.'],
                                    ['Analyse &amp; Optimise', 'We track key performance indicators like engagement, reach, traffic, leads and campaign performance. We then analyse the results to optimise our strategies, strengthen our future content and move your social media presence in the right direction.'],
                                ];
                                foreach ($steps as $i => $st):
                                    $is_last = $i === count($steps) - 1;
                                    ?>
                                    <div class="wu-proc-step<?php echo $is_last ? ' is-last' : ''; ?>" data-tilt
                                        data-reveal>
                                        <span class="wu-proc-dot"></span>
                                        <span class="wu-proc-no"><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></span>
                                        <h3><?php echo $st[0]; ?></h3>
                                        <p><?php echo $st[1]; ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </section>

                    <!-- STATS: figures the site already publishes (homepage band, podcast page, Google listing) -->
                    <section id="wu-smm-stats" class="wu-section">
                        <div class="wu-inner">
                            <span class="wu-eb"><span class="wu-eb__dot" aria-hidden="true"></span>By the numbers</span>
<h2 class="wu-h2" data-reveal><span class="wu-hl">Numbers That</span> <span class="wu-hw">Back the Work</span></h2>
                            <ul class="wu-stats">
                                <li><b><span data-count="8">8</span>+</b><strong>Years of experience</strong></li>
                                <li><b><span data-count="3">3</span>M+</b><strong>Audience reached</strong><span>across our channels</span></li>
                                <li><b><span data-count="91">91</span>K+</b><strong>YouTube subscribers</strong><span>WiseUp Podcast</span></li>
                                <li><b><span data-count="66">66</span>K+</b><strong>Instagram followers</strong><span>WiseUp Podcast</span></li>
                                <li><b><span data-count="5.0">5.0</span>★</b><strong>Google rating</strong><span>from client reviews</span></li>
                            </ul>
                        </div>
                    </section>
                    <script>
                    (function () {
                        var list = document.querySelector('.wu-stats');
                        if (!list || !('IntersectionObserver' in window) || matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                        var els = list.querySelectorAll('[data-count]');
                        els.forEach(function (e) { e.dataset.final = e.textContent; if (e.dataset.count.indexOf('.') < 0) e.textContent = '0'; });
                        var io = new IntersectionObserver(function (en) {
                            if (!en[0].isIntersecting) return; io.disconnect();
                            els.forEach(function (e) {
                                var to = parseFloat(e.dataset.count); if (e.dataset.count.indexOf('.') >= 0) return;
                                var t0 = performance.now(), d = 1400;
                                (function tick(t) { var p = Math.min(1, (t - t0) / d); e.textContent = Math.round(to * (1 - Math.pow(1 - p, 3))); if (p < 1) requestAnimationFrame(tick); else e.textContent = e.dataset.final; })(t0);
                            });
                        }, { threshold: 0.4 });
                        io.observe(list);
                    })();
                    </script>

                    <!-- WHY -->
                    <section id="wu-smm-why" class="wu-section">
                        <div class="wu-inner">
                            <div class="wu-sec-head">
                                <div class="wu-sec-head-left">
                                    <span class="wu-eb"><span class="wu-eb__dot" aria-hidden="true"></span>Why WiseUp</span>
<h2 class="wu-h2" data-reveal><span class="wu-hl">Why Brands</span> <span class="wu-hw">Choose WiseUp</span></h2>
                                </div>
                                <p class="wu-sec-head-right" data-reveal>Any social media management agency can fill your feed. But not all agencies approach social media the same way. WiseUp's social media marketing services in Kerala go beyond routine posting. Our clients choose us because we plan with purpose, create with intention, and show you exactly what your social media is delivering.</p>
                            </div>
                            <div class="wu-why-grid">
                                <?php
                                $whys = [
                                    ['Strategy Before Posting', 'We begin by understanding your brand, your audience, and your business goals. Every post we create has a clear purpose and a place in a larger plan. Nothing makes it to your feed just to fill space.', '<circle cx="12" cy="12" r="8.5"></circle><circle cx="12" cy="12" r="4.5"></circle><circle cx="12" cy="12" r="1" fill="currentColor"></circle><path d="M12 1.5v3M12 19.5v3M1.5 12h3M19.5 12h3"></path>'],
                                    ['Content Made for Your Brand', 'We don’t reuse templates or recycle trending formats for the sake of it, as most social media marketing companies do. We develop original visuals, messaging, and a brand voice that fits your business, so your posts feel distinct, consistent, and unmistakably yours.', '<path d="M12 3c.6 4.6 3.4 7.4 8 8-4.6.6-7.4 3.4-8 8-.6-4.6-3.4-7.4-8-8 4.6-.6 7.4-3.4 8-8z"></path><path d="M19 2.5v3M17.5 4h3"></path>'],
                                    ['The Right Approach for Every Platform', 'We don\'t follow a one-size-fits-all approach. What works on one platform rarely works on another. So, we develop content and strategy for each platform, adjusting format, length, pacing, and call to action to match how each audience scrolls, watches, and decides.', '<rect x="3" y="7" width="12" height="14" rx="3"></rect><path d="M8 3.5h10a3 3 0 0 1 3 3V17"></path><path d="M7 12h4M7 15.5h3"></path>'],
                                    ['Focused on Real Progress', 'Likes and follower counts can look impressive and still deliver little business value. We look beyond these numbers and measure performance using meaningful indicators such as reach, engagement quality, saves, shares, qualified leads, and campaign returns. These insights help us understand what\'s working, what needs to change, and where to focus our efforts next.', '<path d="M3 20.5h18"></path><path d="M4 16l5-5 4 3 7-7.5"></path><path d="M15 6.5h5v5"></path>'],
                                    ['Clear Communication at Every Step', 'You\'ll always know what\'s in planning, what\'s live, what\'s working, and what isn\'t. We share clear content calendars, transparent reports, and direct feedback loops, so your team stays involved, and no decision is made in the dark.', '<path d="M20 12.5a7.5 7.5 0 0 1-11 6.6L4 20.5l1.4-4.4A7.5 7.5 0 1 1 20 12.5z"></path><path d="M9 11h6M9 14h4"></path>'],
                                ];
                                foreach ($whys as $i => $w): ?>
                                    <div class="wu-why-card" data-tilt data-spot data-reveal
                                        data-delay="<?php echo $i * 80; ?>">
                                        <span class="wu-spot"></span>
                                        <span class="wu-why-icon"><svg width="22" height="22" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"><?php echo $w[2]; ?></svg></span>
                                        <h3><?php echo esc_html($w[0]); ?></h3>
                                        <p><?php echo $w[1]; ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </section>

                    <!-- RESULTS -->
                    <section id="wu-smm-results" class="wu-section">
<?php
// Results dashboard (owner, 2026-11-04): every figure is as stated on the case-study page on wiseup.in.
// Counts like "4 execution tracks" / "6 campaign formats" are the numbered sections on those pages.
$cs = function ( $f ) use ( $smm_assets ) { return esc_url( $smm_assets . $f ); };
$arrow = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg>';
$ticker = [ ['2,060,559', 'views on one Golden Karak reel'], ['+160%', 'follower growth in 60 days'], ['9+', 'international media features for Erets'], ['3', 'continents of Erets partners'], ['10', 'Indus Go campaign videos a month'], ['30', 'days to a visible impact for Smoke House'], ['6', 'formats in the Sathya launch'], ['10,100+', 'interactions in one campaign'] ];
?>
<style>
/* ---- Results dashboard ---- */
#wu-smm-results { --lime: #C2F760; }
#wu-smm-results .rx-ticker { position: relative; margin: clamp(24px, 3vw, 40px) 0 clamp(22px, 2.6vw, 34px); overflow: hidden; border-block: 1px solid rgb(255 255 255 / .1); -webkit-mask-image: linear-gradient(90deg, transparent, #000 6%, #000 94%, transparent); mask-image: linear-gradient(90deg, transparent, #000 6%, #000 94%, transparent); }
#wu-smm-results .rx-ticker__run { display: flex; width: max-content; animation: rx-tick 48s linear infinite; }
#wu-smm-results .rx-ticker__item { display: flex; align-items: baseline; gap: 10px; padding: 16px 34px; white-space: nowrap; }
#wu-smm-results .rx-ticker__item b { font-size: clamp(22px, 2vw, 30px); font-weight: 700; letter-spacing: -.03em; color: var(--lime); }
#wu-smm-results .rx-ticker__item span { font-size: 13.5px; color: rgb(255 255 255 / .62); }
#wu-smm-results .rx-ticker__item::after { content: ""; width: 6px; height: 6px; margin-left: 24px; border-radius: 50%; background: rgb(255 255 255 / .2); align-self: center; }
@keyframes rx-tick { to { transform: translateX(-50%); } }
#wu-smm-results .rx-grid { display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 14px; }
#wu-smm-results .rx-card { position: relative; display: flex; flex-direction: column; overflow: hidden; border-radius: 26px; padding: clamp(20px, 2.2vw, 30px); color: #fff; text-decoration: none; isolation: isolate;
  background: #0f1010; box-shadow: inset 0 0 0 1px rgb(255 255 255 / .08); transition: box-shadow .35s, transform .45s cubic-bezier(.2, .8, .2, 1); }
#wu-smm-results .rx-card:hover { box-shadow: inset 0 0 0 1.5px rgb(194 247 96 / .55); transform: translateY(-3px); }
#wu-smm-results .rx-bg { position: absolute; inset: 0; z-index: -1; }
#wu-smm-results .rx-bg img { width: 100%; height: 100%; object-fit: cover; opacity: .32; transition: opacity .5s, transform .8s cubic-bezier(.2, .8, .2, 1); }
#wu-smm-results .rx-card:hover .rx-bg img { opacity: .42; transform: scale(1.04); }
#wu-smm-results .rx-bg::after { content: ""; position: absolute; inset: 0; background: linear-gradient(180deg, rgb(10 10 10 / .35), rgb(10 10 10 / .82) 55%, #0b0b0b); }
#wu-smm-results .rx-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
#wu-smm-results .rx-cat { display: block; font-size: 11px; font-weight: 600; letter-spacing: .16em; text-transform: uppercase; color: var(--lime); }
#wu-smm-results .rx-name { margin: 6px 0 0; font-size: clamp(20px, 1.6vw, 26px); font-weight: 600; letter-spacing: -.02em; color: #fff; }
#wu-smm-results .rx-go { flex: none; display: grid; place-items: center; width: 38px; height: 38px; border-radius: 50%; color: var(--lime); box-shadow: inset 0 0 0 1px rgb(194 247 96 / .35); transition: background .3s, color .3s; }
#wu-smm-results .rx-card:hover .rx-go { background: var(--lime); color: #0e1206; }
#wu-smm-results .rx-hero { display: flex; align-items: flex-end; flex-wrap: wrap; gap: 8px 14px; margin-top: auto; padding-top: 22px; }
#wu-smm-results .rx-hero b { font-size: clamp(44px, 5.4vw, 84px); font-weight: 700; line-height: .9; letter-spacing: -.045em; color: var(--lime); font-variant-numeric: tabular-nums; }
#wu-smm-results .rx-hero span { padding-bottom: 6px; max-width: 18ch; font-size: 14.5px; line-height: 1.35; color: rgb(255 255 255 / .78); }
#wu-smm-results .rx-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 10px; margin-top: 18px; }
#wu-smm-results .rx-stat { padding: 12px 14px; border-radius: 16px; background: rgb(255 255 255 / .05); box-shadow: inset 0 0 0 1px rgb(255 255 255 / .08); -webkit-backdrop-filter: blur(6px); backdrop-filter: blur(6px); }
#wu-smm-results .rx-stat b { display: block; font-size: clamp(22px, 1.9vw, 30px); font-weight: 700; letter-spacing: -.03em; color: #fff; font-variant-numeric: tabular-nums; }
#wu-smm-results .rx-stat span { display: block; margin-top: 2px; font-size: 12.5px; line-height: 1.3; color: rgb(255 255 255 / .62); }
#wu-smm-results .rx-bar { display: block; margin-top: 18px; }
#wu-smm-results .rx-bar__track { display: block; }
#wu-smm-results .rx-bar__from, #wu-smm-results .rx-bar__to { display: block; }
#wu-smm-results .rx--karak .rx-stats { grid-template-columns: repeat(3, minmax(0, 1fr)); }
#wu-smm-results .rx--erets .rx-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
@media (max-width: 640px) { #wu-smm-results .rx--karak .rx-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
#wu-smm-results .rx-bar__lab { display: flex; justify-content: space-between; font-size: 12.5px; color: rgb(255 255 255 / .62); }
#wu-smm-results .rx-bar__lab b { color: #fff; font-weight: 600; }
#wu-smm-results .rx-bar__track { position: relative; height: 10px; margin-top: 8px; border-radius: 99px; background: rgb(255 255 255 / .08); overflow: hidden; }
#wu-smm-results .rx-bar__from { position: absolute; inset: 0 auto 0 0; width: 30.3%; border-radius: inherit; background: rgb(255 255 255 / .28); }
#wu-smm-results .rx-bar__to { position: absolute; inset: 0 auto 0 0; width: 0; border-radius: inherit; background: linear-gradient(90deg, rgb(255 255 255 / .28) 30%, var(--lime)); transition: width 1.8s cubic-bezier(.2, .8, .2, 1) .3s; }
#wu-smm-results.rx-in .rx-bar__to { width: 100%; }
#wu-smm-results .rx-list { display: flex; flex-wrap: wrap; gap: 6px; margin: 14px 0 0; padding: 0; list-style: none; }
#wu-smm-results .rx-list li { padding: 5px 11px; border-radius: 99px; font-size: 12px; color: rgb(255 255 255 / .75); background: rgb(255 255 255 / .05); box-shadow: inset 0 0 0 1px rgb(255 255 255 / .1); }
#wu-smm-results .rx-say { margin-top: auto; padding-top: 22px; font-size: clamp(22px, 2vw, 30px); font-weight: 600; line-height: 1.15; letter-spacing: -.02em; color: #fff; }
#wu-smm-results .rx-say em { font-style: normal; color: var(--lime); }
#wu-smm-results .rx-quote { margin-top: 10px; font-size: 13.5px; line-height: 1.5; font-style: italic; color: rgb(255 255 255 / .62); }
#wu-smm-results .rx--karak { grid-column: span 7; grid-row: span 2; min-height: 520px; }
#wu-smm-results .rx--erets { grid-column: span 5; grid-row: span 2; }
#wu-smm-results .rx--smoke, #wu-smm-results .rx--indus, #wu-smm-results .rx--sathya, #wu-smm-results .rx--boot { grid-column: span 3; min-height: 330px; }
@media (max-width: 1100px) { #wu-smm-results .rx--karak, #wu-smm-results .rx--erets { grid-column: span 12; grid-row: auto; min-height: 0; } #wu-smm-results .rx--smoke, #wu-smm-results .rx--indus, #wu-smm-results .rx--sathya, #wu-smm-results .rx--boot { grid-column: span 6; } }
@media (max-width: 640px) { #wu-smm-results .rx--smoke, #wu-smm-results .rx--indus, #wu-smm-results .rx--sathya, #wu-smm-results .rx--boot { grid-column: span 12; min-height: 0; } #wu-smm-results .rx-ticker__item { padding: 12px 22px; } }
@media (prefers-reduced-motion: reduce) { #wu-smm-results .rx-ticker__run { animation: none; } #wu-smm-results .rx-bar__to { transition: none; width: 100%; } }
</style>
                        <div class="wu-inner">
                            <div class="wu-sec-head">
                                <div class="wu-sec-head-left">
                                    <span class="wu-eb"><span class="wu-eb__dot" aria-hidden="true"></span>Client work</span>
<h2 class="wu-h2" data-reveal><span class="wu-hl">Results That Speak</span> <span class="wu-hw">for Themselves</span></h2>
                                </div>
                            </div>
                            <div class="rx-ticker" aria-hidden="true"><div class="rx-ticker__run"><?php for ( $k = 0; $k < 2; $k++ ) foreach ( $ticker as $t ) echo '<span class="rx-ticker__item"><b>' . esc_html( $t[0] ) . '</b><span>' . esc_html( $t[1] ) . '</span></span>'; ?></div></div>
                            <div class="rx-grid">
                                <a class="rx-card rx--karak" href="https://wiseup.in/case-studies/golden-karak/" target="_blank" rel="noopener">
                                    <span class="rx-bg"><img src="<?php echo $cs( 'case-karak.jpg' ); ?>" alt="Golden Karak café brand by WiseUp" loading="lazy"></span>
                                    <span class="rx-top"><span><span class="rx-cat">Café brand · Bahrain &amp; GCC</span><h3 class="rx-name">Golden Karak</h3></span><span class="rx-go"><?php echo $arrow; ?></span></span>
                                    <span class="rx-hero"><b data-rx="2060559">2,060,559</b><span>views on a single Instagram Reel</span></span>
                                    <span class="rx-bar"><span class="rx-bar__lab"><span>Followers: <b>300</b> before</span><span><b>991</b> after 60 days</span></span><span class="rx-bar__track"><span class="rx-bar__to"></span><span class="rx-bar__from"></span></span></span>
                                    <span class="rx-stats">
                                        <span class="rx-stat"><b data-rx="160" data-pre="+" data-suf="%">+160%</b><span>follower growth</span></span>
                                        <span class="rx-stat"><b data-rx="681">681</b><span>new followers gained</span></span>
                                        <span class="rx-stat"><b data-rx="75600" data-suf="+">75,600+</b><span>total views</span></span>
                                        <span class="rx-stat"><b data-rx="10100" data-suf="+">10,100+</b><span>interactions</span></span>
                                        <span class="rx-stat"><b data-rx="21">21</b><span>pieces of content</span></span>
                                        <span class="rx-stat"><b data-rx="60">60</b><span>days</span></span>
                                    </span>
                                </a>
                                <a class="rx-card rx--erets" href="https://wiseup.in/case-studies/erets/" target="_blank" rel="noopener">
                                    <span class="rx-bg"><img src="<?php echo $cs( 'case-erets.jpg' ); ?>" alt="Erets Space brand by WiseUp" loading="lazy"></span>
                                    <span class="rx-top"><span><span class="rx-cat">Space technology · London</span><h3 class="rx-name">Erets Space</h3></span><span class="rx-go"><?php echo $arrow; ?></span></span>
                                    <span class="rx-hero"><b data-rx="9" data-suf="+">9+</b><span>international media features within weeks of launch</span></span>
                                    <span class="rx-stats">
                                        <span class="rx-stat"><b data-rx="6" data-suf="+">6+</b><span>global partners at launch</span></span>
                                        <span class="rx-stat"><b data-rx="3">3</b><span>continents</span></span>
                                        <span class="rx-stat"><b data-rx="12">12</b><span>weeks, discovery to live</span></span>
                                        <span class="rx-stat"><b data-rx="3">3</b><span>mission verticals</span></span>
                                    </span>
                                </a>
                                <a class="rx-card rx--smoke" href="https://wiseup.in/case-studies/smokehouse/" target="_blank" rel="noopener">
                                    <span class="rx-bg"><img src="<?php echo $cs( 'case-smokehouse.jpg' ); ?>" alt="Smoke House restaurant branding by WiseUp" loading="lazy"></span>
                                    <span class="rx-top"><span><span class="rx-cat">Restaurant branding</span><h3 class="rx-name">Smoke House</h3></span><span class="rx-go"><?php echo $arrow; ?></span></span>
                                    <span class="rx-hero"><b data-rx="30">30</b><span>days to a visible impact</span></span>
                                    <span class="rx-stats"><span class="rx-stat"><b data-rx="4">4</b><span>execution tracks</span></span><span class="rx-stat"><b data-rx="3">3</b><span>strategy pillars</span></span></span>
                                </a>
                                <a class="rx-card rx--indus" href="https://wiseup.in/case-studies/indusgo/" target="_blank" rel="noopener">
                                    <span class="rx-bg"><img src="<?php echo $cs( 'case-indusgo.jpg' ); ?>" alt="Indus Go self-drive rentals campaign by WiseUp" loading="lazy"></span>
                                    <span class="rx-top"><span><span class="rx-cat">Self-drive rentals</span><h3 class="rx-name">Indus Go</h3></span><span class="rx-go"><?php echo $arrow; ?></span></span>
                                    <span class="rx-hero"><b data-rx="10">10</b><span>campaign videos produced per month</span></span>
                                    <span class="rx-stats"><span class="rx-stat"><b data-rx="3">3</b><span>shoot schedules</span></span></span>
                                </a>
                                <a class="rx-card rx--sathya" href="https://wiseup.in/case-studies/sathya-agencies-brand-launch-campaign-kerala/" target="_blank" rel="noopener">
                                    <span class="rx-bg"><img src="<?php echo esc_url( $smm_assets . '../work/case-sathya-540.webp' ); ?>" alt="Sathya Agencies brand launch campaign by WiseUp" loading="lazy"></span>
                                    <span class="rx-top"><span><span class="rx-cat">Brand launch · Kerala</span><h3 class="rx-name">Sathya Agencies</h3></span><span class="rx-go"><?php echo $arrow; ?></span></span>
                                    <span class="rx-hero"><b data-rx="6">6</b><span>campaign formats in one launch</span></span>
                                    <ul class="rx-list"><li>Hoardings</li><li>LED displays</li><li>Social</li><li>Reels</li><li>Street activations</li><li>Showrooms</li></ul>
                                </a>
                                <a class="rx-card rx--boot" href="https://wiseup.in/case-studies/bootland/" target="_blank" rel="noopener">
                                    <span class="rx-bg"><img src="<?php echo $cs( 'case-bootland.jpg' ); ?>" alt="Bootland event branding by WiseUp" loading="lazy"></span>
                                    <span class="rx-top"><span><span class="rx-cat">Event branding</span><h3 class="rx-name">Bootland</h3></span><span class="rx-go"><?php echo $arrow; ?></span></span>
                                    <p class="rx-say">Kerala&rsquo;s <em>largest</em> footwear exhibition</p>
                                    <p class="rx-quote">&ldquo;More than an expo: a recognizable event brand.&rdquo;</p>
                                </a>
                            </div>
                        </div>
<script>
(function () {
	var sec = document.getElementById('wu-smm-results'); if (!sec) return;
	var still = matchMedia('(prefers-reduced-motion: reduce)').matches;
	var fmt = function (n) { return Math.round(n).toLocaleString('en-US'); };
	var run = function () {
		sec.classList.add('rx-in'); if (still) return;
		sec.querySelectorAll('[data-rx]').forEach(function (el) {
			var end = +el.getAttribute('data-rx'), pre = el.getAttribute('data-pre') || '', suf = el.getAttribute('data-suf') || '', t0 = performance.now(), dur = 1800;
			(function f(now) { var k = Math.min(1, (now - t0) / dur), e = 1 - Math.pow(1 - k, 4); el.textContent = pre + fmt(end * e) + suf; if (k < 1) requestAnimationFrame(f); })(t0);
		});
	};
	if (!('IntersectionObserver' in window)) return run();
	var io = new IntersectionObserver(function (es) { if (es[0].isIntersecting) { run(); io.disconnect(); } }, { threshold: .2 });
	io.observe(sec.querySelector('.rx-grid'));
})();
</script>
                    </section>


                    <!-- TESTIMONIALS: real Google Business Profile reviews (WiseUp Marketing Agency, 5.0). Add more cards as they are fetched. -->
                    <section id="wu-smm-testimonials" class="wu-section">
                        <div class="wu-inner">
                            <span class="wu-eb"><span class="wu-eb__dot" aria-hidden="true"></span>Reviews</span>
<h2 class="wu-h2" data-reveal><span class="wu-hl">What Our Clients</span> <span class="wu-hw">Say About Us</span></h2>
                            <div class="wu-rv-grid">
                                <figure class="wu-t-card wu-rv ">
                                    <svg class="wu-t-quote-icon" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 21c0-7 2-12 7-14l1 2c-3 1.5-4 4-4 6h4v6H3zm10 0c0-7 2-12 7-14l1 2c-3 1.5-4 4-4 6h4v6h-8z"/></svg>
                                    <div class="wu-t-stars" role="img" aria-label="5 out of 5 stars">★★★★★</div>
                                    <blockquote><span class="wu-rv-text">We are very satisfied with the social media marketing services provided by WiseUp Branding. Since they started managing our social media pages, we have seen a noticeable increase in engagement and sales.<br><br>Their team is creative, professional, and always supportive whenever we need assistance or updates. They truly understand branding and marketing strategies that work.<br><br>Thank you, WiseUp Branding, for your continuous support and dedication. Highly recommended for businesses looking to grow online!</span></blockquote>
                                    <button type="button" class="wu-rv-more" hidden aria-expanded="false">Read more</button>
                                    <figcaption><strong>Mohamed Afsal K</strong><span>Director (Sales and Marketing), Onesto and Mercado Pvt Ltd</span></figcaption>
                                </figure>
                                <figure class="wu-t-card wu-rv is-lime">
                                    <svg class="wu-t-quote-icon" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 21c0-7 2-12 7-14l1 2c-3 1.5-4 4-4 6h4v6H3zm10 0c0-7 2-12 7-14l1 2c-3 1.5-4 4-4 6h4v6h-8z"/></svg>
                                    <div class="wu-t-stars" role="img" aria-label="5 out of 5 stars">★★★★★</div>
                                    <blockquote><span class="wu-rv-text">We had a wonderful experience working with WiseUp for Sathya Agencies. Their team handled our video production projects professionally with creative concepts and trending video ideas that perfectly matched our brand. The quality of the videos, editing, and overall presentation was excellent and helped us attract more customer attention online.<br><br>Apart from video production, WiseUp also provided strong support for our digital presence. Their digital marketing strategies, creative content, and consistent support helped improve our online visibility and engagement. The team was responsive, creative, and always ready to bring fresh ideas to the table.<br><br>We truly appreciate their dedication, professionalism, and innovative approach. Highly recommended for anyone looking for quality video production, branding, and digital marketing services.</span></blockquote>
                                    <button type="button" class="wu-rv-more" hidden aria-expanded="false">Read more</button>
                                    <figcaption><strong>Arjun</strong><span>Branding Manager, Sathya Agencies</span></figcaption>
                                </figure>
                                <figure class="wu-t-card wu-rv is-cream">
                                    <svg class="wu-t-quote-icon" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 21c0-7 2-12 7-14l1 2c-3 1.5-4 4-4 6h4v6H3zm10 0c0-7 2-12 7-14l1 2c-3 1.5-4 4-4 6h4v6h-8z"/></svg>
                                    <div class="wu-t-stars" role="img" aria-label="5 out of 5 stars">★★★★★</div>
                                    <blockquote><span class="wu-rv-text">Their marketing team is highly professional and excellent. Their effective marketing skills have helped our hospital reach more people and improve community outreach. Highly recommended!</span></blockquote>
                                    <button type="button" class="wu-rv-more" hidden aria-expanded="false">Read more</button>
                                    <figcaption><strong>Dr. Jinu Antony</strong></figcaption>
                                </figure>
                                <figure class="wu-t-card wu-rv ">
                                    <svg class="wu-t-quote-icon" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 21c0-7 2-12 7-14l1 2c-3 1.5-4 4-4 6h4v6H3zm10 0c0-7 2-12 7-14l1 2c-3 1.5-4 4-4 6h4v6h-8z"/></svg>
                                    <div class="wu-t-stars" role="img" aria-label="5 out of 5 stars">★★★★★</div>
                                    <blockquote><span class="wu-rv-text">I recently got my logo designed and I’m extremely happy with the result. The designer perfectly understood my vision and created a logo that looks professional, unique, and elegant. The communication was smooth, delivery was on time, and the overall experience was excellent. Highly recommend for anyone looking for quality branding and logo design work.</span></blockquote>
                                    <button type="button" class="wu-rv-more" hidden aria-expanded="false">Read more</button>
                                    <figcaption><strong>Sharlet N Shaji</strong></figcaption>
                                </figure>
                                <figure class="wu-t-card wu-rv is-lime">
                                    <svg class="wu-t-quote-icon" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 21c0-7 2-12 7-14l1 2c-3 1.5-4 4-4 6h4v6H3zm10 0c0-7 2-12 7-14l1 2c-3 1.5-4 4-4 6h4v6h-8z"/></svg>
                                    <div class="wu-t-stars" role="img" aria-label="5 out of 5 stars">★★★★★</div>
                                    <blockquote><span class="wu-rv-text">Highly recommended for anyone looking to grow their business on social media.</span></blockquote>
                                    <button type="button" class="wu-rv-more" hidden aria-expanded="false">Read more</button>
                                    <figcaption><strong>Amarapushpa Coconut Products</strong></figcaption>
                                </figure>
                                <figure class="wu-t-card wu-rv is-cream">
                                    <svg class="wu-t-quote-icon" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 21c0-7 2-12 7-14l1 2c-3 1.5-4 4-4 6h4v6H3zm10 0c0-7 2-12 7-14l1 2c-3 1.5-4 4-4 6h4v6h-8z"/></svg>
                                    <div class="wu-t-stars" role="img" aria-label="5 out of 5 stars">★★★★★</div>
                                    <blockquote><span class="wu-rv-text">Highly recommended for businesses looking to grow online.</span></blockquote>
                                    <button type="button" class="wu-rv-more" hidden aria-expanded="false">Read more</button>
                                    <figcaption><strong>Athul R</strong></figcaption>
                                </figure>
                                <figure class="wu-t-card wu-rv ">
                                    <svg class="wu-t-quote-icon" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 21c0-7 2-12 7-14l1 2c-3 1.5-4 4-4 6h4v6H3zm10 0c0-7 2-12 7-14l1 2c-3 1.5-4 4-4 6h4v6h-8z"/></svg>
                                    <div class="wu-t-stars" role="img" aria-label="5 out of 5 stars">★★★★★</div>
                                    <blockquote><span class="wu-rv-text">I’ve a nice experience with them. Very professional.</span></blockquote>
                                    <button type="button" class="wu-rv-more" hidden aria-expanded="false">Read more</button>
                                    <figcaption><strong>Sruthi O.S</strong></figcaption>
                                </figure>
                            </div>
                            <div class="wu-rv-bar">
                                <a class="wu-rv-all" href="https://share.google/EnbA9XYB0qbQo0qGB" target="_blank" rel="noopener">See all reviews on Google ↗</a>
                                <div class="wu-rv-nav">
                                    <button type="button" data-rv-prev aria-label="Previous reviews"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 6l-6 6 6 6"/></svg></button>
                                    <button type="button" data-rv-next aria-label="Next reviews"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 6l6 6-6 6"/></svg></button>
                                </div>
                            </div>
                        </div>
                    </section>
                    <script>
                    (function () {
                        var cards = document.querySelectorAll('.wu-rv');
                        var fit = function () { cards.forEach(function (c) { var t = c.querySelector('.wu-rv-text'), b = c.querySelector('.wu-rv-more'); if (c.classList.contains('is-open')) return; b.hidden = !(t.scrollHeight > t.clientHeight + 2); }); };
                        cards.forEach(function (c) { var b = c.querySelector('.wu-rv-more'); b.addEventListener('click', function () { var on = !c.classList.contains('is-open'); c.classList.toggle('is-open', on); b.setAttribute('aria-expanded', String(on)); b.textContent = on ? 'Show less' : 'Read more'; if (!on) fit(); }); });
                        fit(); window.addEventListener('resize', fit); window.addEventListener('load', fit);
                        var track = document.querySelector('.wu-rv-grid'), prev = document.querySelector('[data-rv-prev]'), next = document.querySelector('[data-rv-next]');
                        var step = function () { var c = cards[0]; return c.getBoundingClientRect().width + 16; };
                        var upd = function () { prev.disabled = track.scrollLeft < 4; next.disabled = track.scrollLeft + track.clientWidth >= track.scrollWidth - 4; };
                        prev.addEventListener('click', function () { track.scrollBy({ left: -step() }); });
                        next.addEventListener('click', function () { track.scrollBy({ left: step() }); });
                        track.addEventListener('scroll', upd, { passive: true }); window.addEventListener('resize', upd); upd();
                    })();
                    </script>

                    <!-- FAQ -->
                    <section id="wu-smm-faq" class="wu-section">
                        <div class="wu-inner">
                            <div class="wu-faq-left">
                                <span class="wu-eb"><span class="wu-eb__dot" aria-hidden="true"></span>FAQ</span>
<h2 class="wu-h2" data-reveal><span class="wu-hl">Frequently</span> <span class="wu-hw">Asked Questions</span></h2>
                            </div>
                            <div class="wu-faq-list">
                                <?php
                                $faqs = [
                                    ['How Long Does Social Media Marketing Take to Show Results?', 'Early signs like better reach and more comments and saves can be expected in 4 to 6 weeks. Real business results like regular enquiries can take 3 to 6 months, because the algorithm needs time to learn your account and your audience needs time to trust you.', true],
                                    ['Do you provide both organic and paid social media marketing services?', 'Yes. Organic marketing builds long-term reach and credibility, while paid campaigns put a brand’s best content in front of a targeted audience quickly. We usually recommend starting with organic groundwork, then adding paid support once we know which messages and formats perform well. That keeps ad spend from going toward content not tested yet.', false],
                                    ['Which Social Media Platform Is Best for a Business?', 'The best social media platform for a business is the one where your buyers already spend time and make decisions. A clothing brand may find its audience on Instagram and Facebook, a logistics company on LinkedIn, and a home appliance brand on YouTube, where product demos can help customers. Most brands need only two or three platforms done well.', false],
                                    ['How much does social media marketing cost in Kerala?', 'Social media marketing services in Kerala typically cost from ₹10,000 to ₹1,50,000 per month. Lower packages usually cover a few posts and basic management, while higher ones include strategy, video production, paid campaigns, and detailed reporting.', false],
                                    ['How Do I Choose the Best Social Media Marketing Company in Kerala?', 'When choosing the best social media marketing company in Kerala, look beyond the number of posts they promise to publish. Review their previous work, understand their content creation process, check their platform expertise, and ask how they measure campaign performance. They should understand your audience, communicate clearly, and build a strategy around your goals rather than offer the same package to everyone.', false],
                                ];
                                foreach ($faqs as $i => $f): ?>
                                    <div class="wu-faq-item<?php echo $f[2] ? ' is-open' : ''; ?>" data-spot
                                        data-faq-item>
                                        <button type="button" data-faq-toggle>
                                            <?php echo esc_html($f[0]); ?>
                                            <span class="wu-faq-plus">+</span>
                                        </button>
                                        <div class="wu-faq-answer">
                                            <div>
                                                <p><?php echo $f[1]; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </section>

                    <!-- CTA -->
                    <section id="wu-smm-cta" class="wu-section">
                        <div class="wu-cta-box">
                            <div class="wu-blob"
                                style="width:700px;height:700px;left:-200px;top:-300px;background:radial-gradient(circle,#7B8146 0%,rgba(123,129,70,0) 65%);filter:blur(30px)"
                                data-blob></div>
                            <div class="wu-blob"
                                style="width:700px;height:700px;right:-250px;bottom:-350px;background:radial-gradient(circle,#56602A 0%,rgba(86,96,42,0) 65%);filter:blur(30px)"
                                data-blob></div>
                            <img class="wu-mascot" src="<?php echo esc_url($smm_assets . 'wiso.gif'); ?>"
                                alt="Wiso">
                            <span class="wu-eb"><span class="wu-eb__dot" aria-hidden="true"></span>Get started</span>
<h2 data-reveal><span class="wu-hl">Ready to Make Your Brand</span> <span class="wu-hw">Stand Out?</span></h2>
                            <div class="wu-cta-row" data-reveal>
                                <a data-magnetic href="#wu-smm-cta" class="wu-btn-primary" data-lead-open data-lead-source="social-media">
                                    Get a Free Social Media Audit
                                    <span class="wu-arrow"><svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M7 17L17 7"></path>
                                            <path d="M8.5 7H17v8.5"></path>
                                        </svg></span>
                                </a>
                            </div>
                        </div>
                    </section>

                </div>

                <script>
                    (function () {
                        var root = document.getElementById('wu-smm');
                        if (!root) return;
                        var reduced = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
                        var fine = window.matchMedia && matchMedia('(pointer:fine)').matches;
                        var hoverable = window.matchMedia && matchMedia('(hover:hover)').matches;

                        /* Scroll progress + back-to-top */
                        var prog = document.getElementById('wu-smm-progress');
                        var toTop = document.getElementById('wu-smm-totop');
                        var navSolidState = false;

                        /* Reveal-on-scroll */
                        var revealEls = [].slice.call(root.querySelectorAll('[data-reveal]'));
                        if ('IntersectionObserver' in window) {
                            var io = new IntersectionObserver(function (entries) {
                                entries.forEach(function (e) {
                                    if (!e.isIntersecting) return;
                                    var el = e.target;
                                    io.unobserve(el);
                                    var delay = +el.dataset.delay || 0;
                                    el.style.opacity = '0';
                                    el.animate(
                                        [{ opacity: 0, transform: 'translateY(40px)' }, { opacity: 1, transform: 'none' }],
                                        { duration: 900, delay: delay, easing: 'cubic-bezier(.2,.7,.2,1)', fill: 'backwards' }
                                    );
                                    el.addEventListener('animationend', function () { el.style.opacity = ''; });
                                    setTimeout(function () { el.style.opacity = ''; }, delay + 900);
                                });
                            }, { threshold: 0.12 });
                            revealEls.forEach(function (el) {
                                var r = el.getBoundingClientRect();
                                if (r.top > window.innerHeight * 0.95) {
                                    el.style.opacity = '0';
                                    io.observe(el);
                                }
                            });
                        }

                        /* Hero word-by-word reveal + shine */
                        if (!reduced) {
                            // the heading is plain text in the HTML; words are wrapped here only to animate them
                            var ht = root.querySelector('.wu-hero-title');
                            if (ht) [].slice.call(ht.childNodes).forEach(function (n) {
                                if (n.nodeType !== 3) return;
                                var fr = document.createDocumentFragment();
                                n.textContent.split(/(\s+)/).forEach(function (t) {
                                    if (!t) return;
                                    if (/^\s+$/.test(t)) { fr.appendChild(document.createTextNode(' ')); return; }
                                    var sp = document.createElement('span'); sp.setAttribute('data-word', ''); sp.textContent = t; fr.appendChild(sp);
                                });
                                ht.replaceChild(fr, n);
                            });
                            root.querySelectorAll('[data-word]').forEach(function (w, i) {
                                w.animate(
                                    [{ opacity: 0, transform: 'translateY(0.45em) rotate(2deg)', filter: 'blur(8px)' }, { opacity: 1, transform: 'none', filter: 'blur(0)' }],
                                    { duration: 900, delay: 120 + i * 90, easing: 'cubic-bezier(.2,.7,.2,1)', fill: 'backwards' }
                                );
                            });
                            root.querySelectorAll('[data-shine]').forEach(function (el) {
                                el.animate(
                                    [{ backgroundPosition: '100% 0' }, { backgroundPosition: '-150% 0' }],
                                    { duration: 4200, delay: 1400, iterations: Infinity, easing: 'ease-in-out' }
                                );
                            });
                            root.querySelectorAll('[data-cue]').forEach(function (el) {
                                el.animate(
                                    [{ transform: 'translateY(0)', opacity: 1 }, { transform: 'translateY(12px)', opacity: 0 }],
                                    { duration: 1600, iterations: Infinity, easing: 'cubic-bezier(.5,0,.5,1)' }
                                );
                            });
                        }

                        /* Blobs */
                        root.querySelectorAll('[data-blob]').forEach(function (el, i) {
                            el.animate(
                                [{ transform: 'translate(0,0) scale(1)' }, { transform: 'translate(' + (i % 2 ? -8 : 10) + 'vw,' + (i % 3 ? 6 : -6) + 'vw) scale(1.15)' }],
                                { duration: 14000 + i * 3000, iterations: Infinity, direction: 'alternate', easing: 'ease-in-out' }
                            );
                        });

                        /* Spin decoration */
                        root.querySelectorAll('[data-spin]').forEach(function (el) {
                            el.animate([{ transform: 'rotate(0deg)' }, { transform: 'rotate(360deg)' }], { duration: 120000, iterations: Infinity });
                        });

                        /* Marquees */
                        root.querySelectorAll('[data-marquee]').forEach(function (el) {
                            var rev = el.dataset.marquee === 'rev';
                            var a = el.animate(
                                [{ transform: 'translateX(' + (rev ? -50 : 0) + '%)' }, { transform: 'translateX(' + (rev ? 0 : -50) + '%)' }],
                                { duration: +el.dataset.speed || 40000, iterations: Infinity }
                            );
                            el.addEventListener('mouseenter', function () { a.pause(); });
                            el.addEventListener('mouseleave', function () { a.play(); });
                        });

                        /* Magnetic buttons, 3D tilt, cursor spotlight */
                        if (hoverable) {
                            root.querySelectorAll('[data-magnetic]').forEach(function (el) {
                                el.style.transition = (el.style.transition ? el.style.transition + ',' : '') + 'translate .35s cubic-bezier(.2,.8,.2,1)';
                                el.addEventListener('mousemove', function (e) {
                                    var r = el.getBoundingClientRect();
                                    el.style.translate = (((e.clientX - r.left) / r.width - .5) * 14) + 'px ' + (((e.clientY - r.top) / r.height - .5) * 12) + 'px';
                                });
                                el.addEventListener('mouseleave', function () { el.style.translate = '0 0'; });
                            });
                            root.querySelectorAll('[data-tilt]').forEach(function (el) {
                                el.style.transformStyle = 'preserve-3d';
                                el.style.transition = 'rotate .5s cubic-bezier(.2,.8,.2,1),scale .5s cubic-bezier(.2,.8,.2,1),box-shadow .5s';
                                el.addEventListener('mousemove', function (e) {
                                    var r = el.getBoundingClientRect();
                                    var x = (e.clientX - r.left) / r.width - .5, y = (e.clientY - r.top) / r.height - .5;
                                    el.style.rotate = (-y).toFixed(3) + ' ' + x.toFixed(3) + ' 0 ' + (Math.hypot(x, y) * 6).toFixed(2) + 'deg';
                                    el.style.scale = '1.01';
                                    el.style.boxShadow = (-x * 18).toFixed(1) + 'px ' + (18 - y * 10).toFixed(1) + 'px 40px -18px rgba(0,0,0,.7)';
                                });
                                el.addEventListener('mouseleave', function () { el.style.rotate = 'none'; el.style.scale = '1'; el.style.boxShadow = ''; });
                                if (el.parentElement) el.parentElement.style.perspective = '1200px';
                            });
                            root.querySelectorAll('[data-spot]').forEach(function (el) {
                                if (getComputedStyle(el).position === 'static') el.style.position = 'relative';
                                el.style.overflow = 'hidden';
                                var s = el.querySelector('.wu-spot');
                                if (!s) { s = document.createElement('span'); s.className = 'wu-spot'; el.prepend(s); }
                                el.addEventListener('mousemove', function (e) {
                                    var r = el.getBoundingClientRect();
                                    s.style.background = 'radial-gradient(320px circle at ' + (e.clientX - r.left) + 'px ' + (e.clientY - r.top) + 'px,rgba(194,247,96,.16),rgba(194,247,96,0) 70%)';
                                    s.style.opacity = '1';
                                });
                                el.addEventListener('mouseleave', function () { s.style.opacity = '0'; });
                            });
                        }

                        /* Services showcase */
                        var svcWrap = document.getElementById('wu-smm-svc-wrap');
                        var svcPanels = svcWrap ? [].slice.call(svcWrap.querySelectorAll('[data-svc-panel]')) : [];
                        var svcActive = 0, svcUserPicked = false, svcTimer = null, svcVisible = false;

                        function setNarrow() {
                            if (!svcWrap) return;
                            var narrow = window.innerWidth < 960;
                            svcWrap.classList.toggle('is-narrow', narrow);
                        }
                        setNarrow();
                        window.addEventListener('resize', setNarrow);

                        function activateSvc(i) {
                            svcActive = i;
                            svcPanels.forEach(function (p, idx) {
                                p.classList.toggle('is-active', idx === i);
                            });
                        }
                        function startSvcTimer() {
                            clearInterval(svcTimer);
                            if (svcUserPicked || !svcVisible) return;
                            svcTimer = setInterval(function () {
                                activateSvc((svcActive + 1) % svcPanels.length);
                            }, 6000);
                        }
                        svcPanels.forEach(function (p, i) {
                            var go = function () {
                                svcUserPicked = true;
                                clearInterval(svcTimer);
                                if (svcActive !== i) activateSvc(i);
                            };
                            p.addEventListener('mouseenter', go);
                            p.addEventListener('click', go);
                        });
                        if (svcWrap && 'IntersectionObserver' in window) {
                            var svcIO = new IntersectionObserver(function (entries) {
                                var e = entries[0];
                                svcVisible = e.isIntersecting;
                                if (e.isIntersecting) startSvcTimer(); else clearInterval(svcTimer);
                            }, { threshold: 0.35 });
                            svcIO.observe(svcWrap);
                        }

                        /* FAQ accordion */
                        root.querySelectorAll('[data-faq-item]').forEach(function (item) {
                            var btn = item.querySelector('[data-faq-toggle]');
                            if (!btn) return;
                            btn.addEventListener('click', function () {
                                item.classList.toggle('is-open');
                            });
                        });

                        /* Process timeline fill + parallax + progress + back-to-top */
                        var track = document.getElementById('wu-smm-proc-track');
                        var fill = document.getElementById('wu-smm-proc-fill');
                        var parEls = [].slice.call(root.querySelectorAll('[data-parallax],[data-parallax-img]'));

                        var raf = 0;
                        function tick() {
                            raf = 0;
                            var vh = window.innerHeight;
                            var maxS = document.documentElement.scrollHeight - vh;
                            if (prog) prog.style.transform = 'scaleX(' + (maxS > 0 ? Math.min(1, window.scrollY / maxS).toFixed(4) : 0) + ')';
                            if (toTop) {
                                var show = window.scrollY > vh * 1.2;
                                if (show !== navSolidState) {
                                    navSolidState = show;
                                    toTop.style.opacity = show ? '1' : '0';
                                    toTop.style.transform = show ? 'none' : 'translateY(16px)';
                                    toTop.style.pointerEvents = show ? 'auto' : 'none';
                                }
                            }
                            parEls.forEach(function (el) {
                                var r = el.getBoundingClientRect();
                                var s = +(el.dataset.parallax || el.dataset.parallaxImg);
                                var off = (r.top + r.height / 2 - vh / 2) * -s;
                                // Clamped: this offset is based on distance from
                                // viewport center, so on short/unusual viewports
                                // it can grow large enough to shift the element
                                // into neighbouring content. Capping keeps the
                                // parallax feel without that risk.
                                off = Math.max(-60, Math.min(60, off));
                                el.style.transform = 'translate3d(0,' + off.toFixed(1) + 'px,0)';
                            });
                            if (track && fill) {
                                var r2 = track.getBoundingClientRect();
                                var t = Math.min(1, Math.max(0, (vh * 0.6 - r2.top) / (r2.height - 24)));
                                fill.style.height = 'calc(' + (t * 100).toFixed(1) + '% - ' + (t * 24).toFixed(1) + 'px)';
                            }
                        }
                        function onScroll() {
                            if (!raf) raf = requestAnimationFrame(tick);
                        }
                        window.addEventListener('scroll', onScroll, { passive: true });
                        window.addEventListener('resize', onScroll);
                        tick();

                        /* Custom smooth scroll (desktop fine-pointer only, respects reduced motion) */
                        if (fine && !reduced) {
                            var maxScroll = function () { return document.documentElement.scrollHeight - window.innerHeight; };
                            var cur = window.scrollY, tgt = window.scrollY, running = false, own = false;
                            var loop = function () {
                                cur += (tgt - cur) * 0.085;
                                if (Math.abs(tgt - cur) < 0.4) { cur = tgt; running = false; }
                                own = true; window.scrollTo(0, cur);
                                if (running) requestAnimationFrame(loop);
                            };
                            var go = function (y) {
                                tgt = Math.max(0, Math.min(maxScroll(), y));
                                if (!running) { running = true; cur = window.scrollY; requestAnimationFrame(loop); }
                            };
                            window.addEventListener('wheel', function (e) {
                                if (e.ctrlKey || e.defaultPrevented) return;
                                var n = e.target;
                                while (n && n !== document.body) {
                                    var cs = getComputedStyle(n);
                                    if (/(auto|scroll)/.test(cs.overflowY) && n.scrollHeight > n.clientHeight) return;
                                    n = n.parentElement;
                                }
                                e.preventDefault();
                                if (!running) tgt = window.scrollY;
                                go(tgt + e.deltaY * (e.deltaMode === 1 ? 32 : 1));
                            }, { passive: false });
                            window.addEventListener('scroll', function () {
                                if (own) { own = false; return; }
                                if (!running) { cur = tgt = window.scrollY; }
                            }, { passive: true });
                            root.addEventListener('click', function (e) {
                                var a = e.target.closest && e.target.closest('a[href^="#"]');
                                if (!a) return;
                                var id = a.getAttribute('href').slice(1);
                                var el = id ? document.getElementById(id) : null;
                                if (!el && id !== 'wu-smm-top') return;
                                e.preventDefault();
                                go(el ? el.getBoundingClientRect().top + window.scrollY - 80 : 0);
                            });
                        }
                    })();
                </script>

            </div>
        </div>
    </div>
</div>

<?php
$wu_lead_source = 'social-media';
include WISEUP_DIR . 'landing/lead-popup.php';
wiseup_landing_close( 'social-media' );