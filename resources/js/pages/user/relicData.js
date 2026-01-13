const rolls = {
  SPD: { low: 2, med: 2.3, high: 2.6 },
  HP: { low: 33.87, med: 38.103755, high: 42.33751 },
  ATK: { low: 16.935, med: 19.051877, high: 21.168754 },
  DEF: { low: 16.935, med: 19.051877, high: 21.168754 },
  "HP%": { low: 3.456, med: 3.888, high: 4.32 },
  "ATK%": { low: 3.456, med: 3.888, high: 4.32 },
  "DEF%": { low: 4.32, med: 4.86, high: 5.4 },
  "Break Effect": { low: 5.184, med: 5.832, high: 6.48 },
  "Effect Hit Rate": { low: 3.456, med: 3.888, high: 4.32 },
  "Effect RES": { low: 3.456, med: 3.888, high: 4.32 },
  "CRIT Rate": { low: 2.592, med: 2.916, high: 3.24 },
  "CRIT DMG": { low: 5.184, med: 5.832, high: 6.48 }
};

export const statIcons = {
    HP: 'global-hp.webp',
    ATK: 'global-atk.webp',
    DEF: 'global-def.webp',
    'HP%': 'global-hp.webp',
    'ATK%': 'global-atk.webp',
    'DEF%': 'global-def.webp',
    SPD: 'global-spd.webp',
    'Effect Hit Rate': 'global-effect.webp',
    'Effect RES': 'global-res.webp',
    'Outgoing Healing': 'global-res.webp',
    'CRIT Rate': 'global-cr.webp',
    'CRIT DMG': 'global-cd.webp',
    'Break Effect': 'global-break.webp',
    'Energy Regeneration Rate': 'global-energy.webp',
    'Physical DMG': 'global-physical.webp',
    'Fire DMG': 'global-fire.webp',
    'Ice DMG': 'global-ice.webp',
    'Wind DMG': 'global-wind.webp',
    'Lightning DMG': 'global-lightning.webp',
    'Quantum DMG': 'global-quantum.webp',
    'Imaginary DMG': 'global-imaginary.webp'
};

export const subStatList = [
    "ATK%",
    "HP%",
    "DEF%",
    "CRIT DMG",
    "CRIT Rate",
    "Effect Hit Rate",
    "SPD",
    "Break Effect",
    "ATK",
    "HP",
    "DEF",
    "Effect RES"
]

export const relicMainStats = {
    relic_head: ['HP'],
    relic_hands: ['ATK'],
    relic_body: [
        'HP%',
        'ATK%',
        'DEF%',
        'Effect Hit Rate',
        'Outgoing Healing',
        'CRIT Rate',
        'CRIT DMG'
    ],
    relic_feet: ['HP%', 'ATK%', 'DEF%', 'SPD'],
    relic_orb: [
        'HP%',
        'ATK%',
        'DEF%',
        'Physical DMG',
        'Fire DMG',
        'Ice DMG',
        'Wind DMG',
        'Lightning DMG',
        'Quantum DMG',
        'Imaginary DMG'
    ],
    relic_link: ['HP%', 'ATK%', 'DEF%', 'Break Effect', 'Energy Regeneration Rate']
};

export const typeKeyMap = {
  Head: 'relic_head',
  Hands: 'relic_hands',
  Body: 'relic_body',
  Feet: 'relic_feet',
  'Planar Sphere': 'relic_orb',
  'Link Rope': 'relic_link'
};

export const statPerLevel = {
  SPD: 1.4,
  ATK: 19.7568,
  HP: 39.5136,
  "ATK%": 2.4192,
  "HP%": 2.4192,
  "DEF%": 3.024,
  "CRIT DMG": 3.6288,
  "CRIT Rate": 1.8144,
  "Outgoing Healing": 1.9354,
  "Physical DMG": 2.1773,
  "Fire DMG": 2.1773,
  "Ice DMG": 2.1773,
  "Lightning DMG": 2.1773,
  "Wind DMG": 2.1773,
  "Quantum DMG": 2.1773,
  "Imaginary DMG": 2.1773,
  "Energy Regeneration Rate": 1.0886,
  "Effect Hit Rate": 2.4192,
  "Break Effect": 3.6277
};

export function formatStat(stat) {
  switch (stat.stat_type) {
    case 'ATK':
    case 'HP':
    case 'DEF':
    case 'SPD':
      return Math.floor(stat.value);
    default:
      return stat.value.toFixed(1) + '%';
  }
}

export function enhanceRandomModifier(item) {
    const roll = Math.random() * 100;
    const subStats = item.subStats;
    const randomSubStat = subStats[Math.floor(Math.random() * 4)];
    const randomSubStatName = randomSubStat.stat_type;

    if (!rolls[randomSubStatName]) return null;

    let modifierValue;
    if (roll <= 10) modifierValue = rolls[randomSubStatName].high;
    else if (roll <= 30) modifierValue = rolls[randomSubStatName].med;
    else modifierValue = rolls[randomSubStatName].low;

    if (randomSubStat) {
        randomSubStat.value += modifierValue;
        randomSubStat.rolls += 1;
        return {
            id: randomSubStat.id,
            value: randomSubStat.value,
            rolls: randomSubStat.rolls
        };
    }

    return null;
}