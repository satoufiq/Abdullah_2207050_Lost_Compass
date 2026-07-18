@extends('layouts.app')

@section('title', 'The Lost Compass | Where Legends Sail')
@section('meta_description', 'The Lost Compass — An immersive interactive Pirates Universe. Choose your character, sail legendary ships, complete dangerous missions, and claim your destiny.')
@section('body_class', 'home-page')

@section('use_base_css', true)

@section('styles')
<style>
/* ============================================================
   HOME PAGE — PIRATE UNIVERSE PREMIUM v4.0
   Warm amber-gold palette, deep ocean warmth, candlelight glow
   ============================================================ */

/* ── Scrollbar ─────────────────────────────────────────────── */
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: hsl(22, 35%, 5%); }
::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #c9a44c, #b8943f);
    border-radius: 3px;
}

/* ── Animated Ocean Background — warm deep sea ─────────────── */
body {
    background:
        radial-gradient(ellipse 80% 50% at 20% 10%, rgba(201, 164, 76, 0.1), transparent),
        radial-gradient(ellipse 60% 40% at 80% 20%, rgba(184, 148, 63, 0.1), transparent),
        radial-gradient(ellipse 100% 60% at 50% 100%, rgba(15, 12, 8, 0.9), transparent),
        linear-gradient(180deg, hsl(22, 35%, 5%) 0%, hsl(215, 40%, 8%) 30%, hsl(220, 35%, 7%) 60%, hsl(22, 30%, 4%) 100%);
    min-height: 100vh;
}

/* Animated floating stars/sparkles — warm candlelight */
body::after {
    content: '';
    position: fixed;
    inset: 0;
    pointer-events: none;
    z-index: 0;
    background-image:
        radial-gradient(1px 1px at 20% 15%, rgba(255, 220, 120, 0.5) 0%, transparent 100%),
        radial-gradient(1.5px 1.5px at 45% 8%, rgba(240, 180, 73, 0.6) 0%, transparent 100%),
        radial-gradient(1px 1px at 70% 22%, rgba(255, 240, 180, 0.4) 0%, transparent 100%),
        radial-gradient(1px 1px at 88% 5%, rgba(201, 164, 76, 0.5) 0%, transparent 100%),
        radial-gradient(1.5px 1.5px at 12% 40%, rgba(255, 255, 255, 0.2) 0%, transparent 100%),
        radial-gradient(1px 1px at 60% 35%, rgba(240, 190, 80, 0.4) 0%, transparent 100%),
        radial-gradient(1px 1px at 33% 55%, rgba(255, 240, 200, 0.3) 0%, transparent 100%),
        radial-gradient(2px 2px at 78% 48%, rgba(255, 215, 100, 0.5) 0%, transparent 100%);
    animation: starsTwinkle 8s ease-in-out infinite alternate;
}

@keyframes starsTwinkle {
    0%  { opacity: 0.6; }
    100% { opacity: 1; }
}

/* ═══════════════════════════════════════════════════════════
   HERO SECTION
   ═══════════════════════════════════════════════════════════ */
.hero {
    width: 100%;
    min-height: 100vh;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero-video {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 1;
    filter: saturate(1.3) brightness(0.9) sepia(0.08);
}

/* Multi-layer cinematic overlay */
.hero-overlay {
    position: absolute;
    inset: 0;
    z-index: 2;
    background:
        radial-gradient(ellipse 90% 60% at 50% 60%, transparent 0%, rgba(15, 10, 5, 0.65) 80%),
        linear-gradient(180deg,
            rgba(15, 10, 5, 0.3) 0%,
            rgba(20, 14, 8, 0.1) 30%,
            rgba(20, 14, 8, 0.15) 65%,
            rgba(15, 10, 5, 0.85) 100%
        );
}

/* Animated light rays */
.hero-overlay::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        conic-gradient(from 200deg at 50% 120%,
            rgba(240, 180, 73, 0.0) 0deg,
            rgba(240, 180, 73, 0.05) 30deg,
            rgba(240, 180, 73, 0.0) 60deg);
    animation: lightRaysRotate 18s linear infinite;
    pointer-events: none;
}


/* Vignette shimmer sweep */
.hero-overlay::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(110deg, transparent 25%, rgba(240, 180, 73, 0.04) 50%, transparent 75%);
    animation: heroSweep 8s ease-in-out infinite;
}

@keyframes heroSweep {
    0%, 100% { transform: translateX(-30%); opacity: 0.5; }
    50%       { transform: translateX(30%); opacity: 1; }
}

/* Scroll-down wave bottom edge */
.hero::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 90px;
    z-index: 5;
    background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 90'%3E%3Cpath fill='%23110d08' fill-opacity='1' d='M0,64L48,58.7C96,53,192,43,288,42.7C384,43,480,53,576,53.3C672,53,768,43,864,37.3C960,32,1056,32,1152,42.7C1248,53,1344,75,1392,85.3L1440,96L1440,90L1392,90C1344,90,1248,90,1152,90C1056,90,960,90,864,90C768,90,672,90,576,90C480,90,384,90,288,90C192,90,96,90,48,90L0,90Z'%3E%3C/path%3E%3C/svg%3E") no-repeat bottom / cover;
    pointer-events: none;
}

.hero-content {
    position: relative;
    z-index: 10;
    text-align: center;
    width: 92%;
    max-width: 900px;
    padding-top: 80px;
}

/* Eyebrow label */
.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    background: rgba(201, 164, 76, 0.1);
    border: 1px solid rgba(201, 164, 76, 0.35);
    border-radius: 100px;
    padding: 0.35rem 1rem;
    margin-bottom: 1.5rem;
    font-family: 'Cinzel', serif;
    font-size: 0.7rem;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: rgba(240, 200, 130, 0.9);
    text-shadow: 0 0 12px rgba(240, 180, 73, 0.5);
    box-shadow: 0 0 20px rgba(201, 164, 76, 0.1);
    animation: eyebrowFadeIn 1s ease-out 0.2s both, eyebrowPulse 4s ease-in-out 1.2s infinite;
    backdrop-filter: blur(8px);
}

.hero-eyebrow .eyebrow-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #f0b449;
    box-shadow: 0 0 8px rgba(240, 180, 73, 0.8);
    animation: dotBlink 2s ease-in-out infinite;
}

@keyframes dotBlink {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.4; transform: scale(0.7); }
}

@keyframes eyebrowFadeIn {
    from { opacity: 0; transform: translateY(-15px); }
    to   { opacity: 1; transform: translateY(0); }
}

@keyframes eyebrowPulse {
    0%, 100% { box-shadow: 0 0 20px rgba(201, 164, 76, 0.1); border-color: rgba(201, 164, 76, 0.35); }
    50%       { box-shadow: 0 0 30px rgba(201, 164, 76, 0.3); border-color: rgba(201, 164, 76, 0.6); }
}

.hero-title {
    font-size: clamp(2.6rem, 8vw, 6rem);
    font-family: 'Cinzel Decorative', 'Pirata One', cursive;
    color: transparent;
    background: linear-gradient(
        135deg,
        #ffe8a0 0%,
        #f0b449 20%,
        #ffd97a 40%,
        #c9a44c 60%,
        #f0b449 80%,
        #ffe8a0 100%
    );
    background-size: 200% 200%;
    -webkit-background-clip: text;
    background-clip: text;
    line-height: 1.1;
    margin-bottom: 0.75rem;
    letter-spacing: 3px;
    animation:
        titleRise 1s cubic-bezier(0.16, 1, 0.3, 1) 0.4s both,
        titleGoldShift 6s ease-in-out 1.4s infinite;
    filter: drop-shadow(0 0 50px rgba(240, 180, 73, 0.5));
}

@keyframes titleRise {
    from { opacity: 0; transform: translateY(50px) scale(0.96); filter: drop-shadow(0 0 0 rgba(240,180,73,0)); }
    to   { opacity: 1; transform: translateY(0) scale(1);       filter: drop-shadow(0 0 50px rgba(240,180,73,0.5)); }
}

@keyframes titleGoldShift {
    0%, 100% { background-position: 0% 50%; }
    50%       { background-position: 100% 50%; }
}

.hero-subtitle {
    color: rgba(255, 225, 170, 0.95);
    margin-bottom: 2.5rem;
    font-size: clamp(1rem, 2.5vw, 1.5rem);
    font-family: 'Lora', serif;
    font-style: italic;
    line-height: 1.7;
    animation: subtitleRise 1s ease-out 0.7s both;
    text-shadow: 0 2px 20px rgba(0, 0, 0, 0.7), 0 0 30px rgba(240, 180, 73, 0.15);
    max-width: 680px;
    margin-left: auto;
    margin-right: auto;
}

@keyframes subtitleRise {
    from { opacity: 0; transform: translateY(25px); }
    to   { opacity: 1; transform: translateY(0); }
}

.hero-buttons {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
    animation: buttonsRise 1s ease-out 1s both;
}

@keyframes buttonsRise {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

.btn {
    position: relative;
    padding: 1rem 2.2rem;
    font-family: 'Cinzel', serif;
    font-size: 0.82rem;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 700;
    text-decoration: none;
    border-radius: 6px;
    cursor: pointer;
    overflow: hidden;
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1),
                box-shadow 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

/* Shimmer sweep on all buttons */
.btn::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -80%;
    width: 50%;
    height: 200%;
    background: linear-gradient(105deg, transparent 30%, rgba(255,255,255,0.18) 50%, transparent 70%);
    transform: skewX(-15deg);
    transition: left 0.6s ease;
}

.btn:hover::before {
    left: 130%;
}

.btn:hover {
    transform: translateY(-4px) scale(1.03);
}

.btn:active {
    transform: translateY(-1px) scale(0.99);
}

.btn-primary {
    background: linear-gradient(135deg, rgba(240,180,73,0.22) 0%, rgba(200,140,30,0.28) 100%);
    border: 2px solid rgba(240,180,73,0.75);
    color: #ffd97a;
    box-shadow: 0 0 20px rgba(240,180,73,0.25), 0 6px 20px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,220,120,0.2);
}

.btn-primary:hover {
    background: linear-gradient(135deg, rgba(240,180,73,0.35) 0%, rgba(200,140,30,0.42) 100%);
    border-color: rgba(240,180,73,1);
    color: #fff5cc;
    box-shadow: 0 0 40px rgba(240,180,73,0.55), 0 12px 30px rgba(0,0,0,0.6), inset 0 1px 0 rgba(255,220,120,0.3);
}

.btn-secondary {
    background: rgba(184, 148, 63, 0.08);
    border: 2px solid rgba(184, 148, 63, 0.45);
    color: rgba(220, 195, 130, 0.9);
    box-shadow: 0 0 15px rgba(184, 148, 63, 0.15), 0 6px 20px rgba(0,0,0,0.4);
}

.btn-secondary:hover {
    background: rgba(184, 148, 63, 0.18);
    border-color: rgba(201, 164, 76, 0.85);
    color: #ffe8c0;
    box-shadow: 0 0 35px rgba(184, 148, 63, 0.35), 0 12px 30px rgba(0,0,0,0.5);
}

/* Scroll indicator — sits BELOW the buttons, inside hero-content */
.hero-scroll-hint {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.35rem;
    margin-top: 3rem;
    cursor: pointer;
    opacity: 0.65;
    transition: opacity 0.3s ease;
    animation: buttonsRise 1s ease-out 1.8s both;
}

.hero-scroll-hint:hover { opacity: 1; }

.hero-scroll-hint span {
    font-family: 'Cinzel', serif;
    font-size: 0.58rem;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: rgba(240, 200, 120, 0.75);
}

.scroll-chevron {
    width: 20px;
    height: 20px;
    border-right: 2px solid rgba(201, 164, 76, 0.7);
    border-bottom: 2px solid rgba(201, 164, 76, 0.7);
    transform: rotate(45deg);
    animation: chevronBounce 2s ease-in-out infinite;
}

@keyframes chevronBounce {
    0%, 100% { transform: rotate(45deg) translateY(0); }
    50%       { transform: rotate(45deg) translateY(5px); }
}

/* ── Live Stats Bar ─────────────────────────────────────────── */
.stats-bar {
    position: relative;
    z-index: 6;
    background: linear-gradient(90deg,
        hsl(25, 30%, 8%) 0%,
        hsl(28, 28%, 11%) 50%,
        hsl(25, 30%, 8%) 100%
    );
    border-top: 2px solid rgba(184, 148, 63, 0.3);
    border-bottom: 2px solid rgba(184, 148, 63, 0.3);
    padding: 1.4rem 2rem;
    backdrop-filter: blur(20px);
    box-shadow: 0 0 40px rgba(0,0,0,0.5), inset 0 1px 0 rgba(240,180,73,0.15);
}

.stats-inner {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0;
    position: relative;
}

.stats-inner::before {
    content: '';
    position: absolute;
    inset: -1.4rem -2rem;
    background: linear-gradient(90deg, transparent, rgba(240,180,73,0.03), transparent);
    animation: statsSweep 6s linear infinite;
    pointer-events: none;
}

@keyframes statsSweep {
    0%   { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.3rem;
    padding: 0.5rem 1rem;
    border-right: 1px solid rgba(240, 180, 73, 0.15);
    position: relative;
}

.stat-item:last-child { border-right: none; }

.stat-number {
    font-family: 'Cinzel Decorative', 'Cinzel', serif;
    font-size: clamp(1.4rem, 3vw, 2.2rem);
    font-weight: 700;
    color: #ffd97a;
    text-shadow: 0 0 20px rgba(240, 180, 73, 0.6);
    line-height: 1;
    animation: countUp 1.5s cubic-bezier(0.4, 0, 0.2, 1) both;
}

.stat-label {
    font-family: 'Cinzel', serif;
    font-size: 0.62rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: rgba(220, 195, 130, 0.8);
    text-shadow: 0 0 8px rgba(201, 164, 76, 0.3);
}

.stat-icon {
    font-size: 1rem;
    margin-bottom: 0.15rem;
}

/* ═══════════════════════════════════════════════════════════
   WAVE DIVIDER
   ═══════════════════════════════════════════════════════════ */
.wave-divider {
    position: relative;
    height: 80px;
    overflow: hidden;
    pointer-events: none;
}

.wave-divider svg {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
}

/* ═══════════════════════════════════════════════════════════
   WELCOME / INTRO SECTION
   ═══════════════════════════════════════════════════════════ */
.welcome-section {
    position: relative;
    z-index: 1;
    padding: 5rem 2rem 3rem;
    overflow: hidden;
}

.welcome-section::before {
    content: '';
    position: absolute;
    top: -200px;
    left: -200px;
    width: 600px;
    height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(201,164,76,0.08), transparent 70%);
    pointer-events: none;
    animation: ambientFloat1 12s ease-in-out infinite alternate;
}

.welcome-section::after {
    content: '';
    position: absolute;
    bottom: -100px;
    right: -100px;
    width: 500px;
    height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(240,180,73,0.07), transparent 70%);
    pointer-events: none;
    animation: ambientFloat2 10s ease-in-out infinite alternate;
}

@keyframes ambientFloat1 {
    0%   { transform: translate(0, 0); }
    100% { transform: translate(60px, 40px); }
}

@keyframes ambientFloat2 {
    0%   { transform: translate(0, 0); }
    100% { transform: translate(-50px, -30px); }
}

.welcome-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
    position: relative;
    z-index: 2;
}

/* Ship showcase with ambient ring */
.ship-showcase {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
}

.ship-showcase::before {
    content: '';
    position: absolute;
    inset: -30px;
    border-radius: 50%;
    background: radial-gradient(ellipse at center, rgba(201,164,76,0.15) 0%, rgba(184,148,63,0.08) 50%, transparent 70%);
    animation: shipAmbientPulse 6s ease-in-out infinite;
}

.ship-showcase::after {
    content: '';
    position: absolute;
    bottom: -20px;
    left: 10%;
    right: 10%;
    height: 40px;
    background: radial-gradient(ellipse at center, rgba(0,0,0,0.6), transparent 70%);
    filter: blur(15px);
    animation: shipFloat 6.5s ease-in-out infinite;
}

@keyframes shipAmbientPulse {
    0%, 100% { opacity: 0.6; transform: scale(1); }
    50%       { opacity: 1;   transform: scale(1.05); }
}

.ship-large {
    max-width: 100%;
    height: 360px;
    object-fit: contain;
    animation: shipFloat 6.5s ease-in-out infinite;
    filter: drop-shadow(0 0 25px rgba(240,180,73,0.35)) drop-shadow(0 20px 40px rgba(0,0,0,0.6));
    position: relative;
    z-index: 2;
}

@keyframes shipFloat {
    0%, 100% { transform: translateY(0) rotate(-0.5deg); }
    50%       { transform: translateY(-22px) rotate(0.5deg); }
}

.welcome-content {
    position: relative;
}

.section-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-family: 'Cinzel', serif;
    font-size: 0.65rem;
    letter-spacing: 3.5px;
    text-transform: uppercase;
    color: rgba(201,164,76,0.85);
    margin-bottom: 1rem;
}

.section-eyebrow::before {
    content: '';
    display: block;
    width: 30px;
    height: 1px;
    background: linear-gradient(90deg, rgba(201,164,76,0.8), rgba(184,148,63,0.2));
}

.welcome-content h2 {
    font-size: clamp(1.9rem, 4vw, 3rem);
    font-family: 'Cinzel Decorative', 'Pirata One', cursive;
    color: transparent;
    background: linear-gradient(135deg, #ffd97a 0%, #f0b449 40%, #ffe4a0 70%, #d4941a 100%);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    background-clip: text;
    margin-bottom: 1.25rem;
    line-height: 1.2;
    letter-spacing: 1.5px;
    animation: titleGoldShift 6s ease-in-out infinite;
}

.welcome-content > p {
    color: rgba(255, 210, 140, 0.85);
    line-height: 1.85;
    margin-bottom: 0.5rem;
    font-size: 1.05rem;
}

.welcome-content ul {
    list-style: none;
    margin-top: 1.5rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.6rem;
}

.welcome-content li {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    color: rgba(240, 200, 130, 0.85);
    font-size: 0.95rem;
    padding: 0.55rem 0.75rem;
    border-radius: 6px;
    background: rgba(240,180,73,0.05);
    border: 1px solid rgba(240,180,73,0.12);
    transition: background 0.3s ease, border-color 0.3s ease, transform 0.3s ease;
}

.welcome-content li:hover {
    background: rgba(240,180,73,0.1);
    border-color: rgba(240,180,73,0.3);
    transform: translateX(4px);
}

.welcome-content li::before {
    content: '⚝';
    color: #f0b449;
    font-size: 0.9rem;
    flex-shrink: 0;
    filter: drop-shadow(0 0 4px rgba(240,180,73,0.7));
}

.legend-tags {
    margin-top: 1.6rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0.6rem;
}

.legend-tags span {
    padding: 0.4rem 0.9rem;
    border-radius: 100px;
    border: 1px solid rgba(184,148,63,0.3);
    color: rgba(220,195,130,0.85);
    font-size: 0.72rem;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    font-family: 'Cinzel', serif;
    background: rgba(184,148,63,0.06);
    transition: all 0.3s ease;
    cursor: default;
}

.legend-tags span:hover {
    background: rgba(184,148,63,0.15);
    border-color: rgba(201,164,76,0.6);
    color: #ffe8c0;
    box-shadow: 0 0 14px rgba(201,164,76,0.2);
}

/* ═══════════════════════════════════════════════════════════
   FEATURES SECTION — 3D TILT CARDS
   ═══════════════════════════════════════════════════════════ */
.features-section {
    position: relative;
    z-index: 1;
    padding: 2rem 2rem 5rem;
    overflow: hidden;
}

.features-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(201,164,76,0.35), rgba(184,148,63,0.25), rgba(201,164,76,0.35), transparent);
}

.section-header {
    text-align: center;
    margin-bottom: 3.5rem;
    position: relative;
    z-index: 2;
}

.section-title {
    font-family: 'Cinzel Decorative', 'Pirata One', cursive;
    color: transparent;
    background: linear-gradient(135deg, #ffd97a 0%, #f0b449 40%, #ffe4a0 70%, #d4941a 100%);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    background-clip: text;
    font-size: clamp(1.8rem, 3.5vw, 2.8rem);
    margin-bottom: 0.75rem;
    letter-spacing: 2px;
    animation: titleGoldShift 6s ease-in-out infinite;
}

.section-desc {
    color: rgba(240, 200, 130, 0.7);
    font-size: 1rem;
    max-width: 500px;
    margin: 0 auto;
    font-style: italic;
    line-height: 1.7;
}

.section-divider {
    width: 80px;
    height: 2px;
    margin: 1rem auto 0;
    background: linear-gradient(90deg, transparent, rgba(201,164,76,0.7), rgba(184,148,63,0.5), rgba(201,164,76,0.7), transparent);
    border-radius: 2px;
}

.features-container-v3 {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.75rem;
    position: relative;
    z-index: 2;
}

.feature-card-v3 {
    position: relative;
    background: linear-gradient(145deg, hsl(25, 22%, 10%) 0%, hsl(220, 28%, 9%) 100%);
    border: 1px solid rgba(240,180,73,0.2);
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1),
                box-shadow 0.4s ease,
                border-color 0.4s ease;
    box-shadow:
        0 10px 40px rgba(0,0,0,0.7),
        0 0 0 1px rgba(255,255,255,0.03),
        inset 0 1px 0 rgba(255,255,255,0.04);
}

.feature-card-v3::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 16px;
    background: linear-gradient(135deg, rgba(201,164,76,0.06), transparent 50%, rgba(184,148,63,0.04));
    opacity: 0;
    transition: opacity 0.4s ease;
    pointer-events: none;
    z-index: 1;
}

.feature-card-v3:hover {
    transform: translateY(-12px) scale(1.02);
    border-color: rgba(240,180,73,0.55);
    box-shadow:
        0 0 0 1px rgba(240,180,73,0.2),
        0 20px 60px rgba(0,0,0,0.85),
        0 0 50px rgba(240,180,73,0.2),
        inset 0 1px 0 rgba(255,220,120,0.1);
}

.feature-card-v3:hover::before {
    opacity: 1;
}

/* Card number badge */
.card-number {
    position: absolute;
    top: 1rem;
    right: 1rem;
    z-index: 5;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(240,180,73,0.15);
    border: 1px solid rgba(240,180,73,0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Cinzel', serif;
    font-size: 0.75rem;
    font-weight: 700;
    color: #ffd97a;
    box-shadow: 0 0 12px rgba(240,180,73,0.3);
    transition: all 0.3s ease;
}

.feature-card-v3:hover .card-number {
    background: rgba(240,180,73,0.3);
    box-shadow: 0 0 20px rgba(240,180,73,0.5);
    transform: scale(1.1) rotate(10deg);
}

.feature-image-v3 {
    height: 240px;
    overflow: hidden;
    position: relative;
}

.feature-image-v3::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 80px;
    background: linear-gradient(to top, hsl(220, 28%, 9%) 0%, transparent 100%);
    pointer-events: none;
    z-index: 2;
}

.feature-image-v3 img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1), filter 0.4s ease;
    filter: saturate(0.8) brightness(0.8);
}

.feature-card-v3:hover .feature-image-v3 img {
    transform: scale(1.1);
    filter: saturate(1.1) brightness(0.95);
}

.feature-overlay-gradient {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(10,26,44,0) 0%, rgba(10,26,44,0.25) 100%);
    pointer-events: none;
    z-index: 1;
}

.feature-content-v3 {
    padding: 1.6rem;
    position: relative;
    z-index: 3;
}

.feature-category {
    font-family: 'Cinzel', serif;
    font-size: 0.6rem;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: rgba(201, 164, 76, 0.8);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.feature-category::before {
    content: '';
    display: block;
    width: 20px;
    height: 1px;
    background: rgba(201,164,76,0.6);
}

.feature-title-v3 {
    color: #ffd97a;
    font-size: 1.35rem;
    margin-bottom: 0.75rem;
    font-family: 'Cinzel', serif;
    font-weight: 700;
    letter-spacing: 0.8px;
    text-shadow: 0 0 15px rgba(240, 180, 73, 0.35);
    transition: text-shadow 0.3s ease;
}

.feature-card-v3:hover .feature-title-v3 {
    text-shadow: 0 0 25px rgba(240, 180, 73, 0.7);
}

.feature-text-v3 {
    color: rgba(240, 210, 160, 0.8);
    font-size: 0.95rem;
    line-height: 1.7;
    margin-bottom: 1rem;
}

.feature-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: rgba(240,180,73,0.9);
    text-decoration: none;
    font-family: 'Cinzel', serif;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    font-weight: 600;
    position: relative;
    padding-bottom: 2px;
    transition: all 0.3s ease;
}

.feature-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 1px;
    background: linear-gradient(90deg, #ffd97a, rgba(240,180,73,0.4));
    transition: width 0.35s ease;
    box-shadow: 0 0 6px rgba(240,180,73,0.6);
}

.feature-link:hover {
    color: #fff5cc;
    text-shadow: 0 0 12px rgba(240,180,73,0.7);
}

.feature-link:hover::after { width: 100%; }

.feature-link .arrow {
    transition: transform 0.3s ease;
}

.feature-link:hover .arrow {
    transform: translateX(4px);
}

/* ═══════════════════════════════════════════════════════════
   VOYAGE HIGHLIGHTS
   ═══════════════════════════════════════════════════════════ */
.voyage-highlights {
    position: relative;
    z-index: 1;
    padding: 1rem 2rem 5rem;
    overflow: hidden;
}

.highlights-inner {
    max-width: 1200px;
    margin: 0 auto;
}

.highlights-intro {
    color: rgba(240, 200, 130, 0.75);
    text-align: center;
    max-width: 640px;
    margin: -1rem auto 2.5rem;
    font-style: italic;
    font-size: 1rem;
    line-height: 1.7;
}

.highlight-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.highlight-card {
    position: relative;
    border: 1px solid rgba(240,180,73,0.18);
    border-radius: 14px;
    padding: 0;
    background: linear-gradient(145deg, hsl(25, 22%, 10%) 0%, hsl(220, 28%, 9%) 100%);
    backdrop-filter: blur(12px);
    overflow: hidden;
    transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1),
                border-color 0.35s ease,
                box-shadow 0.35s ease;
    box-shadow: 0 8px 30px rgba(0,0,0,0.6);
}

.highlight-card:hover {
    transform: translateY(-10px) scale(1.02);
    border-color: rgba(240,180,73,0.5);
    box-shadow: 0 20px 50px rgba(0,0,0,0.8), 0 0 30px rgba(240,180,73,0.15);
}

.highlight-media-wrap {
    position: relative;
    overflow: hidden;
    height: 180px;
}

.highlight-media-wrap::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: linear-gradient(to top, hsl(220, 28%, 9%) 0%, transparent 100%);
    pointer-events: none;
    z-index: 2;
}

.highlight-media {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.5s ease, filter 0.4s ease;
    filter: saturate(0.8) brightness(0.85);
}

.highlight-card:hover .highlight-media {
    transform: scale(1.08);
    filter: saturate(1.1) brightness(0.95);
}

.highlight-body {
    padding: 1.25rem 1.25rem 1.5rem;
}

.highlight-kicker {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    color: rgba(201,164,76,0.9);
    text-transform: uppercase;
    letter-spacing: 1.5px;
    font-size: 0.65rem;
    margin-bottom: 0.5rem;
    font-family: 'Cinzel', serif;
    font-weight: 600;
}

.highlight-kicker::before {
    content: '';
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: rgba(201,164,76,0.9);
    box-shadow: 0 0 6px rgba(201,164,76,0.7);
    animation: dotBlink 2s ease-in-out infinite;
}

.highlight-card h3 {
    color: #ffd97a;
    margin-bottom: 0.5rem;
    font-size: 1.15rem;
    letter-spacing: 0.5px;
    font-family: 'Cinzel', serif;
    text-shadow: 0 0 12px rgba(240,180,73,0.3);
}

.highlight-card p {
    color: rgba(240, 200, 130, 0.75);
    font-size: 0.92rem;
    line-height: 1.65;
}

/* Captain Chips — glassmorphic horizontal cards */
.captain-strip {
    margin-top: 1.5rem;
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1rem;
}

.captain-chip {
    display: flex;
    align-items: center;
    gap: 1rem;
    border: 1px solid rgba(240,180,73,0.2);
    padding: 0.9rem 1rem;
    background: linear-gradient(135deg, hsl(25, 22%, 10%) 0%, hsl(220, 26%, 9%) 100%);
    backdrop-filter: blur(12px);
    border-radius: 12px;
    transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    box-shadow: 0 6px 20px rgba(0,0,0,0.5);
    overflow: hidden;
    position: relative;
}

.captain-chip::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 50%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(240,180,73,0.05), transparent);
    transition: left 0.5s ease;
}

.captain-chip:hover {
    transform: translateY(-6px) scale(1.02);
    border-color: rgba(240,180,73,0.6);
    box-shadow: 0 14px 35px rgba(0,0,0,0.7), 0 0 25px rgba(240,180,73,0.15);
}

.captain-chip:hover::before {
    left: 150%;
}

.captain-chip-image {
    width: 72px;
    height: 72px;
    object-fit: cover;
    border-radius: 10px;
    border: 1px solid rgba(240,180,73,0.5);
    flex-shrink: 0;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 0 12px rgba(240,180,73,0.2);
}

.captain-chip:hover .captain-chip-image {
    transform: scale(1.05);
    box-shadow: 0 0 20px rgba(240,180,73,0.4);
}

.captain-chip-copy h4 {
    color: #ffd97a;
    font-size: 1rem;
    margin-bottom: 0.25rem;
    letter-spacing: 0.5px;
    font-family: 'Cinzel', serif;
    font-weight: 700;
}

.captain-chip-copy p {
    color: rgba(240, 200, 130, 0.75);
    font-size: 0.85rem;
    line-height: 1.4;
}

/* ═══════════════════════════════════════════════════════════
   QUOTE SECTION — CINEMATIC
   ═══════════════════════════════════════════════════════════ */
.quote-section-v3 {
    position: relative;
    z-index: 1;
    padding: 8rem 2rem;
    min-height: 520px;
    overflow: hidden;
    display: flex;
    align-items: center;
    border-top: 1px solid rgba(240,180,73,0.2);
    border-bottom: 1px solid rgba(240,180,73,0.2);
}

.quote-section-v3::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 70% at 50% 50%, rgba(15, 10, 5, 0.5), transparent),
        linear-gradient(135deg, rgba(20, 14, 8, 0.4), rgba(15, 10, 5, 0.5));
    z-index: 1;
    pointer-events: none;
}

/* Dynamic background layer (updated via JS) */
.quote-bg-layer {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    opacity: 0.65;
    z-index: 0;
    filter: saturate(0.85);
    transition: background-image 0.7s ease, opacity 0.7s ease;
}

.quote-overlay {
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 90% 80% at 50% 50%, rgba(15, 10, 5, 0.3), transparent),
        linear-gradient(135deg, rgba(20, 14, 8, 0.5) 0%, rgba(15, 10, 5, 0.6) 100%);
    z-index: 1;
    pointer-events: none;
}

.quote-container-v3 {
    max-width: 900px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
    text-align: center;
    width: 100%;
}

.quote-ornament {
    font-size: 6rem;
    color: rgba(201, 164, 76, 0.2);
    font-family: Georgia, serif;
    line-height: 1;
    margin-bottom: -1rem;
    display: block;
    text-shadow: 0 0 30px rgba(201, 164, 76, 0.15);
}

/* Quote items are wrapped in .quote-items-wrapper using Grid to stack them perfectly without absolute positioning bugs */
.quote-items-wrapper {
    display: grid;
    min-height: 200px;
    place-items: center;
}

.quote-item-v3 {
    grid-area: 1 / 1;
    width: 100%;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.6s ease-in-out;
    z-index: 1;
}

.quote-item-v3.active {
    opacity: 1;
    pointer-events: auto;
    z-index: 2;
}


.quote-text-v3 {
    color: #ffd97a;
    font-size: clamp(1.3rem, 3vw, 2.1rem);
    line-height: 1.9;
    font-style: italic;
    margin-bottom: 1.5rem;
    font-family: 'Lora', 'Cormorant Garamond', serif;
    text-shadow: 0 2px 15px rgba(0, 0, 0, 0.8), 0 0 10px rgba(240, 180, 73, 0.3);
}

.quote-author-v3 {
    color: rgba(220, 195, 130, 0.9);
    font-size: 1rem;
    letter-spacing: 2px;
    font-family: 'Cinzel', serif;
    text-transform: uppercase;
    text-shadow: 0 0 15px rgba(201, 164, 76, 0.3);
}

.quote-dots {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    margin-top: 2rem;
}

.quote-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(240,180,73,0.3);
    border: 1px solid rgba(240,180,73,0.4);
    cursor: pointer;
    transition: all 0.3s ease;
}

.quote-dot.active {
    background: rgba(240,180,73,0.9);
    box-shadow: 0 0 8px rgba(240,180,73,0.6);
    transform: scale(1.3);
}




/* ═══════════════════════════════════════════════════════════
   SCROLL REVEAL
   ═══════════════════════════════════════════════════════════ */
.reveal-on-scroll {
    opacity: 0;
    transform: translateY(35px);
    transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    will-change: opacity, transform;
}

.reveal-on-scroll.is-visible {
    opacity: 1;
    transform: translateY(0);
}

.reveal-on-scroll:nth-child(2) { transition-delay: 0.1s; }
.reveal-on-scroll:nth-child(3) { transition-delay: 0.2s; }

/* ═══════════════════════════════════════════════════════════
   LOADING SCREEN
   ═══════════════════════════════════════════════════════════ */
.loading-screen {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: radial-gradient(ellipse at center, hsl(25, 28%, 10%), hsl(22, 35%, 4%));
}

.loading-screen::before {
    content: '';
    position: absolute;
    inset: 0;
    background: repeating-conic-gradient(rgba(240,180,73,0.03) 0deg 5deg, transparent 5deg 10deg);
    animation: loadBgSpin 30s linear infinite;
}

@keyframes loadBgSpin {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
}

.loading-compass {
    width: 90px;
    height: 90px;
    object-fit: contain;
    margin-bottom: 1.25rem;
    animation: compassLoadingSpin 2s linear infinite;
    filter: drop-shadow(0 0 20px rgba(240,180,73,0.7));
    position: relative;
    z-index: 1;
}

@keyframes compassLoadingSpin {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
}

.loading-text {
    color: rgba(240,180,73,0.9);
    font-family: 'Cinzel', serif;
    font-size: 0.85rem;
    letter-spacing: 4px;
    text-transform: uppercase;
    animation: textFlicker 2.5s ease-in-out infinite;
    position: relative;
    z-index: 1;
}

@keyframes textFlicker {
    0%, 100% { opacity: 1; }
    50%       { opacity: 0.5; }
}

/* ═══════════════════════════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 1024px) {
    .stats-inner { grid-template-columns: repeat(2, 1fr); }
    .stat-item:nth-child(2) { border-right: none; }
    .stat-item:nth-child(1),
    .stat-item:nth-child(2) { border-bottom: 1px solid rgba(240,180,73,0.1); padding-bottom: 1rem; margin-bottom: 0.5rem; }
}

@media (max-width: 900px) {
    .welcome-container { grid-template-columns: 1fr; gap: 2.5rem; }
    .welcome-content ul { grid-template-columns: 1fr; }
    .ship-large { height: 260px; }
    .features-container-v3 { grid-template-columns: 1fr; }
    .highlight-grid { grid-template-columns: 1fr 1fr; }
    .captain-strip { grid-template-columns: 1fr; }
    .footer-content { grid-template-columns: 1fr; gap: 2rem; }
    .hero-buttons { flex-direction: column; align-items: center; }
    .btn { min-width: 220px; justify-content: center; }
}

@media (max-width: 600px) {
    .highlight-grid { grid-template-columns: 1fr; }
    .stats-inner { grid-template-columns: repeat(2, 1fr); }
    .hero-content { padding-top: 60px; }
    .quote-section-v3 { padding: 5rem 1.25rem; }
}

@media (max-width: 480px) {
    .stats-bar { padding: 1rem; }
    .stat-number { font-size: 1.5rem; }
    .welcome-section,
    .features-section,
    .voyage-highlights { padding-left: 1rem; padding-right: 1rem; }
}
</style>
@endsection

@section('content')
    {{-- Loading Screen --}}
    @include('partials.loading', ['message' => 'Charting the Seas...'])

    {{-- Navigation --}}
    @include('partials.nav')

    {{-- ═══ HERO ═══ --}}
    <section class="hero" id="home">
        <video class="hero-video" autoplay muted loop playsinline>
            <source src="{{ asset('assets/videos/home/Moonlit ocean background.mp4') }}" type="video/mp4">
        </video>

        <div class="hero-overlay"></div>

        <div class="hero-content">
            

            @if(isset($cookieGreeting))
                <div style="display: inline-block; background: rgba(0,0,0,0.6); padding: 5px 15px; border-radius: 5px; color: #ffd97a; margin-bottom: 15px; border: 1px solid #ffd97a; font-family: 'Cinzel', serif; font-size: 0.8rem; letter-spacing: 1px;">
                    {{ $cookieGreeting }}
                </div>
            @endif

            <h1 class="hero-title">The Lost Compass</h1>

            <p class="hero-subtitle">
                @if($isLoggedIn)
                    {{ $greeting }}
                @else
                    {{ $greeting }}
                @endif
            </p>

            <div class="hero-buttons">
                @if($isLoggedIn)
                    @if($continueMission)
                        <a href="{{ url('/missions') }}" class="btn btn-secondary" id="continue-voyage-btn" style="text-decoration:none;">
                            ⚔ Continue: {{ Str::limit($continueMission->title, 24) }}
                        </a>
                    @endif
                    <a href="{{ $ctaLink }}" class="btn btn-primary" id="begin-voyage-btn" style="text-decoration:none;">
                        ⚓ {{ $ctaText }}
                    </a>
                    <a href="{{ url('/profile') }}" class="btn btn-secondary" id="view-profile-btn" style="text-decoration:none;">
                        🧭 Captain's Cabin
                    </a>
                @else
                    <a href="{{ $ctaLink }}" class="btn btn-primary" id="begin-voyage-btn" style="text-decoration:none;">
                        ⚓ {{ $ctaText }}
                    </a>
                    <a href="{{ url('/quiz') }}" class="btn btn-secondary" id="discover-fate-btn" style="text-decoration:none;">
                        🔮 Explore the Seas
                    </a>
                @endif
            </div>

            {{-- Scroll hint — lives in-flow below the buttons --}}
            <div class="hero-scroll-hint" onclick="document.getElementById('stats-bar').scrollIntoView({behavior:'smooth'})">
                <span>Scroll to Explore</span>
                <div class="scroll-chevron"></div>
            </div>
        </div>
    </section>

    {{-- ═══ STATS BAR ═══ --}}
    <div class="stats-bar" id="stats-bar">
        <div class="stats-inner">
            <div class="stat-item">
                <div class="stat-icon">🏴‍☠️</div>
                <div class="stat-number" data-count="12">12</div>
                <div class="stat-label">Legendary Captains</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">⛵</div>
                <div class="stat-number" data-count="8">8</div>
                <div class="stat-label">Iconic Ships</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">⚔️</div>
                <div class="stat-number" data-count="6">6</div>
                <div class="stat-label">Adventurous Missions</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">🗺️</div>
                <div class="stat-number" data-count="6">6</div>
                <div class="stat-label">Charted Territories</div>
            </div>
        </div>
    </div>

    {{-- ═══ WELCOME SECTION ═══ --}}
    <section class="welcome-section" id="welcome">
        <div class="welcome-container">
            <div class="welcome-image reveal-on-scroll">
                <div class="ship-showcase">
                    <img src="{{ asset('assets/images/ships/black pearl for hero section.png') }}" alt="Black Pearl" class="ship-large">
                </div>
            </div>
            <div class="welcome-content reveal-on-scroll">
                <div class="section-eyebrow">Our World</div>
                @if($isLoggedIn)
                    <h2>Your Legend Continues</h2>
                    <p>
                        Captain <strong style="color:#ffd97a">{{ $pirateName }}</strong>, the seas grow restless.
                        Your rank of <strong style="color:#c9a44c">{{ $pirateRank }}</strong> precedes you across every port.
                        The compass still points true — where will it lead you next?
                    </p>
                @else
                    <h2>Step Into Legend</h2>
                    <p>
                        The Lost Compass is not merely a place — it's a world where the impossible becomes reality.
                        Where cursed treasures gleam in moonlit waters and legendary captains command the seven seas.
                    </p>
                @endif
                <ul>
                    <li>Discover ancient pirate legends</li>
                    <li>Uncover cursed treasures &amp; relics</li>
                    <li>Meet fearless legendary captains</li>
                    <li>Navigate dangerous, magical seas</li>
                </ul>
                <div class="legend-tags">
                    <span>Ancient Relics</span>
                    <span>Cursed Waters</span>
                    <span>Legendary Duels</span>
                    <span>Secret Ports</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ EXPLORE OUR WORLD ═══ --}}
    <section class="features-section" id="features-v3">
        <div class="section-header reveal-on-scroll">
            <h2 class="section-title">Explore Our World</h2>
            <p class="section-desc">Three pillars of an unforgettable adventure await you across the seven seas.</p>
            <div class="section-divider"></div>
        </div>
        <div class="features-container-v3">
            <div class="feature-card-v3 reveal-on-scroll">
                <div class="card-number">01</div>
                <div class="feature-image-v3">
                    <img src="{{ asset('assets/images/home/551567-1920x1080-desktop-1080p-will-turner-pirates-of-the-caribbean-background-photo.jpg') }}" alt="Meet the Captains">
                    <div class="feature-overlay-gradient"></div>
                </div>
                <div class="feature-content-v3">
                    <div class="feature-category">Characters</div>
                    <h3 class="feature-title-v3">Meet the Captains</h3>
                    <p class="feature-text-v3">
                        Encounter legendary pirates like Jack Sparrow, Will Turner, and many more.
                        Each with their own story, powers, and cursed connections.
                    </p>
                    <a href="{{ url('/characters') }}" class="feature-link" style="text-decoration:none;">
                        Explore Characters <span class="arrow">→</span>
                    </a>
                </div>
            </div>
            <div class="feature-card-v3 reveal-on-scroll">
                <div class="card-number">02</div>
                <div class="feature-image-v3">
                    <img src="{{ asset('assets/images/home/f9006df007e36bc5e6931a31ff420a9db7b1ef3da2ea876ebe9f7f26688bac76._SX1080_FMjpg_.jpg') }}" alt="Legendary Ships">
                    <div class="feature-overlay-gradient"></div>
                </div>
                <div class="feature-content-v3">
                    <div class="feature-category">Ships</div>
                    <h3 class="feature-title-v3">Legendary Ships</h3>
                    <p class="feature-text-v3">
                        Sail the seven seas aboard the Black Pearl, the Flying Dutchman, or Queen Anne's Revenge.
                        Each vessel holds dark secrets and ancient curses.
                    </p>
                    <a href="{{ url('/ships') }}" class="feature-link" style="text-decoration:none;">
                        View Ships <span class="arrow">→</span>
                    </a>
                </div>
            </div>
            <div class="feature-card-v3 reveal-on-scroll">
                <div class="card-number">03</div>
                <div class="feature-image-v3">
                    <img src="{{ asset('assets/images/home/5d293ce66407ed52f19a20b8680bb319.jpg') }}" alt="Treasure Missions">
                    <div class="feature-overlay-gradient"></div>
                </div>
                <div class="feature-content-v3">
                    <div class="feature-category">Missions</div>
                    <h3 class="feature-title-v3">Treasure Missions</h3>
                    <p class="feature-text-v3">
                        Embark on dangerous quests. Recover cursed coins, escape the Kraken,
                        duel rival captains, and discover hidden wealth across uncharted waters.
                    </p>
                    <a href="{{ url('/missions') }}" class="feature-link" style="text-decoration:none;">
                        Accept Quest <span class="arrow">→</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ FEATURED MISSIONS (DB) ═══ --}}
    @if($featuredMissions->count() > 0)
    <section class="features-section" id="featured-missions-v3" style="padding-top: 0; margin-top: -2rem;">
        <div class="section-header reveal-on-scroll">
            <h2 class="section-title">Featured Missions</h2>
            <p class="section-desc">Hand-picked quests from the depths of the seven seas.</p>
            <div class="section-divider"></div>
        </div>
        <div class="features-container-v3">
            @foreach($featuredMissions as $index => $mission)
                <div class="feature-card-v3 reveal-on-scroll">
                    <div class="card-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                    <div class="feature-image-v3">
                        @if($mission->image)
                            <img src="{{ asset($mission->image) }}" alt="{{ $mission->title }}">
                        @else
                            <img src="{{ asset('assets/images/home/5d293ce66407ed52f19a20b8680bb319.jpg') }}" alt="{{ $mission->title }}">
                        @endif
                        <div class="feature-overlay-gradient"></div>
                    </div>
                    <div class="feature-content-v3">
                        <div class="feature-category">Featured Quest</div>
                        <h3 class="feature-title-v3">{{ $mission->title }}</h3>
                        <p class="feature-text-v3">
                            {{ $mission->description ?? 'Embark on this dangerous quest and claim your reward.' }}
                        </p>
                        <a href="{{ url('/missions') }}" class="feature-link" style="text-decoration:none;">
                            Accept Quest <span class="arrow">→</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ═══ CAPTAIN'S LOG HIGHLIGHTS ═══ --}}
    <section class="voyage-highlights" id="highlights">
        <div class="highlights-inner reveal-on-scroll">
            <div class="section-header" style="margin-bottom:2.5rem;">
                <h2 class="section-title">Captain's Log Highlights</h2>
                <p class="section-desc">Fresh whispers from the horizon — what's rising in The Lost Compass this season.</p>
                <div class="section-divider"></div>
            </div>

            <div class="highlight-grid">
                <article class="highlight-card">
                    <div class="highlight-media-wrap">
                        <img src="{{ asset('assets/images/home/new images/kraken hunt.jpg') }}" alt="Kraken Hunt event" class="highlight-media">
                    </div>
                    <div class="highlight-body">
                        <span class="highlight-kicker">Live Event</span>
                        <h3>Kraken Hunt Week</h3>
                        <p>Form your crew, track the beast through storm routes, and win rare relic rewards.</p>
                    </div>
                </article>
                <article class="highlight-card">
                    <div class="highlight-media-wrap">
                        <img src="{{ asset('assets/images/home/new images/Compass codex.jpg') }}" alt="Compass Codex lore" class="highlight-media">
                    </div>
                    <div class="highlight-body">
                        <span class="highlight-kicker">New Lore</span>
                        <h3>The Compass Codex</h3>
                        <p>Unlocked scroll entries now reveal hidden links between cursed captains and lost islands.</p>
                    </div>
                </article>
                <article class="highlight-card">
                    <div class="highlight-media-wrap">
                        <img src="{{ asset('assets/images/home/new images/crew showcase.jpeg') }}" alt="Crew showcase" class="highlight-media">
                    </div>
                    <div class="highlight-body">
                        <span class="highlight-kicker">Community</span>
                        <h3>Crew Showcase</h3>
                        <p>Featured crews and fan voyages are now pinned in the tavern hall each fortnight.</p>
                    </div>
                </article>
            </div>

            <div class="captain-strip reveal-on-scroll">
                <article class="captain-chip">
                    <img src="{{ asset('assets/images/home/new images/jack sparrow.jpg') }}" alt="Captain Jack Sparrow" class="captain-chip-image">
                    <div class="captain-chip-copy">
                        <h4>Jack Sparrow</h4>
                        <p>Master of misdirection and impossible escapes.</p>
                    </div>
                </article>
                <article class="captain-chip">
                    <img src="{{ asset('assets/images/home/new images/barbosa.jpg') }}" alt="Captain Barbossa" class="captain-chip-image">
                    <div class="captain-chip-copy">
                        <h4>Barbossa</h4>
                        <p>Cunning strategist with an eye on every horizon.</p>
                    </div>
                </article>
                <article class="captain-chip">
                    <img src="{{ asset('assets/images/home/new images/salazar.jpeg') }}" alt="Captain Salazar" class="captain-chip-image">
                    <div class="captain-chip-copy">
                        <h4>Salazar</h4>
                        <p>Relentless hunter haunting the Devil's Triangle.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    {{-- ═══ QUOTE SECTION ═══ --}}
    <section class="quote-section-v3" id="quote-v3">
        {{-- Dynamic background image that changes with quote --}}
        <div id="quote-bg-v3" class="quote-bg-layer" aria-hidden="true"></div>
        <div class="quote-overlay" aria-hidden="true"></div>

        <div class="quote-container-v3">
            <span class="quote-ornament" aria-hidden="true">"</span>

            <div class="quote-items-wrapper" id="quote-items-wrapper">
            @if($allQuotes->count() > 0)
                @foreach($allQuotes as $index => $q)
                    @php
                        $charKey = strtolower(trim($q->speaker));
                        $imageMap = [
                            'jack sparrow'   => 'assets/images/home/new images/jack sparrow.jpg',
                            'captain jack sparrow' => 'assets/images/home/new images/jack sparrow.jpg',
                            'davy jones'     => 'assets/images/home/davy jones.jpeg',
                            'barbossa'       => 'assets/images/home/new images/barbosa.jpg',
                            'captain barbossa' => 'assets/images/home/new images/barbosa.jpg',
                            'salazar'        => 'assets/images/home/new images/salazar.jpeg',
                            'captain salazar' => 'assets/images/home/new images/salazar.jpeg',
                            'blackbeard'     => 'assets/images/home/new images/Compass codex.jpg',
                            'will turner'    => 'assets/images/home/551567-1920x1080-desktop-1080p-will-turner-pirates-of-the-caribbean-background-photo.jpg',
                        ];
                        $img = $imageMap[$charKey] ?? 'assets/images/home/Moonlit ocean background.png';
                    @endphp
                    <div class="quote-item-v3 {{ $index === 0 ? 'active' : '' }}"
                         data-character="{{ $q->speaker }}"
                         data-image="{{ asset($img) }}">
                        <p class="quote-text-v3">"{{ $q->quote }}"</p>
                        <p class="quote-author-v3">— {{ $q->speaker }}</p>
                    </div>
                @endforeach
            @else
                <div class="quote-item-v3 active"
                     data-character="Jack Sparrow"
                     data-image="{{ asset('assets/images/home/new images/jack sparrow.jpg') }}">
                    <p class="quote-text-v3">"Not all treasure is silver and gold, mate."</p>
                    <p class="quote-author-v3">— Captain Jack Sparrow</p>
                </div>
                <div class="quote-item-v3"
                     data-character="Davy Jones"
                     data-image="{{ asset('assets/images/home/davy jones.jpeg') }}">
                    <p class="quote-text-v3">"Do you fear death? Do you fear that dark abyss?"</p>
                    <p class="quote-author-v3">— Davy Jones</p>
                </div>
                <div class="quote-item-v3"
                     data-character="Barbossa"
                     data-image="{{ asset('assets/images/home/new images/barbosa.jpg') }}">
                    <p class="quote-text-v3">"The problem is not the problem. The problem is your attitude about the problem."</p>
                    <p class="quote-author-v3">— Captain Barbossa</p>
                </div>
            @endif
            </div>{{-- /.quote-items-wrapper --}}

            <div class="quote-dots" id="quote-dots"></div>
        </div>
    </section>

    {{-- Footer --}}
    @include('partials.footer-main')

    {{-- Custom Cursor placeholders (kept for JS compatibility) --}}
    <div class="cursor" id="cursor"></div>
    <div class="cursor-dot" id="cursor-dot"></div>
@endsection

@section('use_base_js', true)

@section('scripts')
<script>
/* ── Scroll Reveal ─────────────────────────────────────── */
(function () {
    var els = document.querySelectorAll('.reveal-on-scroll');
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) {
                e.target.classList.add('is-visible');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    els.forEach(function (el) { io.observe(el); });
}());

/* ── Quote Rotator with background image sync ──────────── */
(function () {
    var items  = document.querySelectorAll('.quote-item-v3');
    var dotsEl = document.getElementById('quote-dots');
    var bgEl   = document.getElementById('quote-bg-v3');
    if (!items.length || !dotsEl) return;

    /* Build navigation dots */
    items.forEach(function (_, i) {
        var dot = document.createElement('button');
        dot.className = 'quote-dot' + (i === 0 ? ' active' : '');
        dot.setAttribute('aria-label', 'Quote ' + (i + 1));
        dot.addEventListener('click', function () { goTo(i); });
        dotsEl.appendChild(dot);
    });

    var current = 0;
    var dots    = dotsEl.querySelectorAll('.quote-dot');

    /* Set initial background */
    function setBackground(item) {
        if (!bgEl) return;
        var img = item.dataset.image;
        if (img) {
            bgEl.style.opacity = '0';
            setTimeout(function() {
                bgEl.style.backgroundImage  = 'url("' + img + '")';
                bgEl.style.backgroundSize   = 'cover';
                bgEl.style.backgroundPosition = 'center';
                bgEl.style.opacity = '0.65';
            }, 350); // Swap image mid-fade
        }
    }

    // Set initial background immediately without fade
    if (bgEl && items.length > 0) {
        var initialImg = items[0].dataset.image;
        bgEl.style.backgroundImage = 'url("' + initialImg + '")';
        bgEl.style.backgroundSize = 'cover';
        bgEl.style.backgroundPosition = 'center';
        bgEl.style.opacity = '0.65';
    }

    var isAnimating = false;

    function goTo(idx) {
        if (isAnimating || current === idx) return;
        isAnimating = true;

        /* exit current */
        items[current].classList.remove('active');
        dots[current].classList.remove('active');
        
        /* Wait for fade out to complete before fading in new quote */
        setTimeout(function() {
            /* enter new */
            current = idx;
            items[current].classList.add('active');
            dots[current].classList.add('active');
            /* swap background */
            setBackground(items[current]);
            
            setTimeout(function() {
                isAnimating = false;
            }, 600); // Wait for fade in
        }, 600); // 600ms matches the CSS transition time
    }

    var timer = setInterval(function () { goTo((current + 1) % items.length); }, 6000);
    /* reset timer when user manually clicks a dot */
    dotsEl.addEventListener('click', function (e) {
        if (e.target.classList.contains('quote-dot')) {
            clearInterval(timer);
            timer = setInterval(function () { goTo((current + 1) % items.length); }, 6000);
        }
    });
}());
</script>
@endsection
