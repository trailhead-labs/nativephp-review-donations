## Adaptive: size the work before spending it

Read the item and its thread (Read the item properly), then score it. Do not clone or build yet.

| Signal | 0 | 1 | 2 |
|---|---|---|---|
| Where the code lives | PHP only | one native platform | both platforms, or PHP plus native |
| How big | under 50 changed or suspect lines, 1 or 2 files | up to 300 lines or 5 files | more |
| How the bug shows | an exception or wrong value | visual, layout or navigation | timing, focus, keyboard, gestures, or only on some devices |
| How much is known | clear repro steps and debug output | a partial repro | vague, or contradicts itself |
| Stakes | cosmetic | a feature is broken | data loss, crash, or a broken build |
| Related work | none | one linked or overlapping item | a companion PR, or several overlapping |

- 0 to 3: **Quick**
- 4 to 7: **Thorough**
- 8 and up: **Deep**

Never go above `CEILING`. If the score says Deep and the ceiling is Thorough, run Thorough and list in the report what a Deep run would add.

Before continuing, print one line for the donor: the score per signal, the level chosen, and the level's token range. On prove tracks, a score of 2 on "where the code lives" also means both platforms must be in `PLATFORMS`; if only one is, cap at Thorough and say so.

Then follow the chosen level's steps below, exactly as written for that level.
