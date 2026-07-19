---
name: Vigor Health System
colors:
  surface: '#f7faf9'
  surface-dim: '#d7dbda'
  surface-bright: '#f7faf9'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f1f4f3'
  surface-container: '#ebeeed'
  surface-container-high: '#e6e9e8'
  surface-container-highest: '#e0e3e2'
  on-surface: '#181c1c'
  on-surface-variant: '#5b403e'
  inverse-surface: '#2d3131'
  inverse-on-surface: '#eef1f0'
  outline: '#8f6f6d'
  outline-variant: '#e4beba'
  surface-tint: '#ba1724'
  primary: '#b71422'
  on-primary: '#ffffff'
  primary-container: '#db3237'
  on-primary-container: '#fffbff'
  inverse-primary: '#ffb3ae'
  secondary: '#586062'
  on-secondary: '#ffffff'
  secondary-container: '#dae1e3'
  on-secondary-container: '#5d6466'
  tertiary: '#006764'
  on-tertiary: '#ffffff'
  tertiary-container: '#00827f'
  on-tertiary-container: '#f3fffd'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#ffdad7'
  primary-fixed-dim: '#ffb3ae'
  on-primary-fixed: '#410004'
  on-primary-fixed-variant: '#930014'
  secondary-fixed: '#dde4e6'
  secondary-fixed-dim: '#c1c8ca'
  on-secondary-fixed: '#161d1f'
  on-secondary-fixed-variant: '#41484a'
  tertiary-fixed: '#5af9f3'
  tertiary-fixed-dim: '#2edcd7'
  on-tertiary-fixed: '#00201f'
  on-tertiary-fixed-variant: '#00504e'
  background: '#f7faf9'
  on-background: '#181c1c'
  surface-variant: '#e0e3e2'
typography:
  display-metrics:
    fontFamily: Space Grotesk
    fontSize: 48px
    fontWeight: '700'
    lineHeight: 48px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Inter
    fontSize: 30px
    fontWeight: '700'
    lineHeight: 36px
    letterSpacing: -0.01em
  headline-lg-mobile:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 30px
  headline-md:
    fontFamily: Inter
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  body-lg:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-sm:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-caps:
    fontFamily: Space Grotesk
    fontSize: 12px
    fontWeight: '600'
    lineHeight: 16px
    letterSpacing: 0.05em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 4px
  xs: 8px
  sm: 16px
  md: 24px
  lg: 32px
  xl: 48px
  container-margin: 20px
  gutter: 16px
---

## Brand & Style

The design system is engineered to evoke a sense of kinetic energy and disciplined clarity. Targeting fitness enthusiasts and individuals seeking lifestyle improvements, the aesthetic balances high-impact motivation with medical-grade precision.

The style is **Modern Corporate with a High-Contrast edge**. It utilizes expansive whitespace to reduce cognitive load during intense physical activity, while leveraging a vibrant primary red to drive urgency and focus. The visual narrative centers on "The Pulse"—the idea that every interaction should feel alive, responsive, and directional. Expect crisp lines, subtle depth to signify interactable surfaces, and a strong emphasis on data visualization.

## Colors

The palette is anchored by **Electric Crimson (#FF4D4D)**, a primary color chosen for its ability to increase heart rate and signal action. 

- **Primary**: Used for active states, primary call-to-actions, and progress indicators.
- **Secondary (Deep Charcoal)**: Reserved for high-level headings and critical navigation elements to ensure grounding.
- **Tertiary (Vital Teal)**: Used sparingly as a success state or for secondary metrics (like hydration) to provide visual relief from the heat of the primary red.
- **Neutral (Soft Slate)**: A collection of off-whites and cool grays used for backgrounds and card strokes to prevent screen glare.

## Typography

This design system utilizes a dual-font approach to maximize legibility and character. **Inter** provides a highly readable, neutral foundation for all functional UI and body text, ensuring clarity during movement. 

**Space Grotesk** is introduced specifically for numeric data and labels. Its geometric, technical nature highlights performance metrics (steps, heart rate, calories) as "engineered data." 

- Use `display-metrics` for primary daily totals.
- Use `label-caps` for small meta-data and overlines to add a professional, technical feel.
- Ensure all numeric values use tabular figures to maintain alignment in lists.

## Layout & Spacing

This design system follows a **Mobile-First Fluid Grid** philosophy. On mobile devices, a 4-column system is used with 20px side margins to ensure elements don't feel cramped against the bezel.

- **Rhythm**: All spacing is based on a 4px baseline grid. 
- **Touch Targets**: All interactive elements must maintain a minimum height of 48px.
- **Vertical Flow**: Content is grouped into logical card segments. Use `md` (24px) spacing between cards to maintain a clean, airy feel.
- **Stacking**: On tablet and desktop, the layout expands to a 12-column grid, but the max-width of the central content area is capped at 1024px to maintain readability of data-heavy tables.

## Elevation & Depth

To maintain a "clean" and "modern" feel, this design system avoids heavy shadows. Instead, it utilizes **Tonal Layering** and **Soft Ambient Shadows**.

- **Level 0 (Background)**: The base canvas uses the Neutral color.
- **Level 1 (Cards)**: White background with a 1px stroke in a slightly darker neutral. This is where most content lives.
- **Level 2 (Active/Floating)**: Used for primary buttons and active modals. These feature a soft, 12% opacity shadow of the primary red or neutral charcoal to suggest they are lifted and ready for interaction.
- **Glassmorphism**: Sticky bottom navigation bars and top headers should use a backdrop-filter blur (10px) with a semi-transparent white background to maintain context of the content scrolling beneath them.

## Shapes

The shape language is **Decisively Rounded**. This softens the aggressive nature of the primary red and makes the app feel more approachable and personalized.

- **Standard Components**: Use `rounded-md` (8px) for input fields and small cards.
- **Primary Containers**: Use `rounded-lg` (16px) for exercise cards and main dashboard widgets.
- **Interactive Elements**: Buttons and Chips utilize a "Pill" shape (full rounding) to clearly distinguish them from static content containers.
- **Progress Elements**: Progress rings must use rounded line-caps to maintain the friendly, fluid visual language.

## Components

### Buttons
- **Primary**: Full-width, pill-shaped, Electric Crimson background with white text. High-contrast and bold.
- **Secondary**: Pill-shaped, transparent background with an Electric Crimson border.
- **Ghost**: No border or background, used for "Cancel" or "Back" actions.

### Progress Rings
- Used for daily goal tracking (Water, Calories, Activity).
- Feature a thick 12px stroke. The background track is a 10% opacity version of the stroke color.
- Center the metric using `display-metrics` typography.

### Exercise Cards
- White background, 16px corner radius, 1px soft gray border.
- Include a 64px square image/icon slot on the left for the exercise type.
- Use a "Chevron-right" icon to signify drill-down capability.

### Input Fields
- Understated design: 8px corner radius, soft gray background. 
- On focus, the border transitions to Electric Crimson with a 2px width.

### Chips
- Used for filtering workout types or selecting intensity levels.
- Unselected: Soft gray background with dark text.
- Selected: Electric Crimson background with white text.

### Data Lists
- Horizontal rules should be minimal; use whitespace to separate list items.
- Values (e.g., "145 bpm") should be right-aligned and set in Space Grotesk.