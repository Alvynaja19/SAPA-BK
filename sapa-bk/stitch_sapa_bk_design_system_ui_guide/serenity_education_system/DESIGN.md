---
name: Serenity Education System
colors:
  surface: '#f7f9fb'
  surface-dim: '#d8dadc'
  surface-bright: '#f7f9fb'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f2f4f6'
  surface-container: '#eceef0'
  surface-container-high: '#e6e8ea'
  surface-container-highest: '#e0e3e5'
  on-surface: '#191c1e'
  on-surface-variant: '#3d4a42'
  inverse-surface: '#2d3133'
  inverse-on-surface: '#eff1f3'
  outline: '#6d7a72'
  outline-variant: '#bccac0'
  surface-tint: '#006c4a'
  primary: '#006948'
  on-primary: '#ffffff'
  primary-container: '#00855d'
  on-primary-container: '#f5fff7'
  inverse-primary: '#68dba9'
  secondary: '#006c49'
  on-secondary: '#ffffff'
  secondary-container: '#6cf8bb'
  on-secondary-container: '#00714d'
  tertiary: '#505f59'
  on-tertiary: '#ffffff'
  tertiary-container: '#687872'
  on-tertiary-container: '#f4fff9'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#85f8c4'
  primary-fixed-dim: '#68dba9'
  on-primary-fixed: '#002114'
  on-primary-fixed-variant: '#005137'
  secondary-fixed: '#6ffbbe'
  secondary-fixed-dim: '#4edea3'
  on-secondary-fixed: '#002113'
  on-secondary-fixed-variant: '#005236'
  tertiary-fixed: '#d5e6df'
  tertiary-fixed-dim: '#bacac3'
  on-tertiary-fixed: '#101e1a'
  on-tertiary-fixed-variant: '#3b4a44'
  background: '#f7f9fb'
  on-background: '#191c1e'
  surface-variant: '#e0e3e5'
typography:
  headline-xl:
    fontFamily: Inter
    fontSize: 48px
    fontWeight: '700'
    lineHeight: '1.1'
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Inter
    fontSize: 32px
    fontWeight: '700'
    lineHeight: '1.2'
    letterSpacing: -0.01em
  headline-md:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: '1.3'
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: '1.6'
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: '1.6'
  label-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '500'
    lineHeight: '1.4'
  headline-lg-mobile:
    fontFamily: Inter
    fontSize: 28px
    fontWeight: '700'
    lineHeight: '1.2'
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  container-max: 1280px
  gutter: 1.5rem
  margin-x: 2rem
  stack-sm: 0.5rem
  stack-md: 1rem
  stack-lg: 2rem
---

## Brand & Style
The design system is engineered for a digital counseling environment, prioritizing a sense of safety, professionalism, and accessibility. The target audience is high school students and faculty, requiring a balance between academic authority and modern friendliness. 

The style is **Modern Corporate with Soft Minimalism**. It utilizes heavy whitespace, refined typography, and purposeful use of color to reduce cognitive load. The UI should evoke a "calm digital sanctuary" feeling, moving away from cluttered traditional portals toward a clean, supportive interface that encourages open communication and trust.

## Colors
The palette is centered around Emerald and Mint tones to symbolize growth, health, and tranquility. 

- **Primary Green** is used for core actions and brand identification.
- **Primary Green Light** serves as a functional "surface" color for alerts, badges, and soft sectioning.
- **Neutral Background** (#F8FAFC) must be used for the page canvas to ensure that white cards (#FFFFFF) possess a clear visual lift.
- **Text Dark** is reserved for high-hierarchy information, while **Text Body** ensures long-form content remains readable and less aggressive than pure black.

## Typography
This design system utilizes **Inter** for its exceptional legibility and systematic character. 

- **Headings** should always use a tighter letter-spacing to maintain a "locked-in" professional look. 
- **Body Text** uses a generous 1.6 line-height to assist students in reading counseling resources or long-form feedback without fatigue. 
- **Labels** are utilized for metadata, chips, and small captions, using a medium weight to maintain visibility at smaller scales.

## Layout & Spacing
The layout follows a **12-column Fluid Grid** with a maximum container width of 1280px. 

- **Desktop:** 24px (1.5rem) gutters and 32px (2rem) page margins.
- **Mobile:** 16px (1rem) gutters and 16px page margins.
- **Rhythm:** Use an 8px base unit. Vertical stack spacing between cards should be consistent (stack-lg), while internal card padding should be slightly more compact to keep elements related. 

All content should be centered within the main container, using ample white space to separate "Self-Service" areas (like resource articles) from "Interactive" areas (like chat or scheduling).

## Elevation & Depth
The design system uses **Tonal Layering** combined with **Ambient Shadows**. 

- **Level 0 (Background):** #F8FAFC - The base canvas.
- **Level 1 (Cards/Surface):** #FFFFFF - Pure white with a very soft, diffused shadow (Blur: 15px, Opacity: 4%, Color: Text Dark).
- **Level 2 (Interactive/Floating):** Use a slightly more pronounced shadow for hover states on buttons or active cards to indicate clickability.

Avoid heavy dark shadows. The goal is to make elements appear as though they are resting gently on the background, not floating high above it.

## Shapes
The shape language is primarily **Rounded**, transitioning to **Pill-shaped** for specific interactive elements.

- **Standard Cards/Containers:** 1rem (rounded-2xl) to provide a soft, non-threatening aesthetic.
- **Buttons & Search Bars:** Rounded-full (pill) to distinguish them as actionable touchpoints.
- **Highlight Cards:** Must include a 4px solid left border in Primary Green to draw immediate visual attention.

## Components

### Navbar
- **Structure:** A floating pill-shaped container.
- **Styling:** Light gray background or semi-transparent white backdrop-blur. 
- **Items:** Active items use Primary Green text with a small bottom dot indicator. The far right features a "Solid Green" pill button for the primary CTA (e.g., "Konsultasi Sekarang").

### Buttons
- **Primary:** Solid Primary Green, White text, Pill-shaped. Hover: Primary Green Dark.
- **Secondary:** Transparent background, Primary Green border, Primary Green text.
- **Ghost:** No border, Primary Green text, light Primary Green Light background on hover.

### Cards
- **Base:** White background, Rounded-2xl, soft shadow.
- **Highlight Variant:** Adds a 4px solid Primary Green stroke on the left edge.
- **Content:** Titles in Headline-md, Body in Body-md.

### Badges & Chips
- **Neutral Status:** Primary Green Light background with Primary Green text.
- **Active Status:** Solid Primary Green background with White text.
- **Shape:** Full pill-shaped.

### Lists & Inputs
- **Numbered Lists:** Numbers are placed inside 24px circles of Primary Green Light with Primary Green text.
- **Inputs:** Rounded-lg, 1px border (#E2E8F0). On focus, the border changes to Primary Green with a soft green outer glow.

### Icons
- **Style:** Thin or Light weight minimalist line icons.
- **Usage:** Inactive icons are Text Body; active or primary icons are Primary Green.