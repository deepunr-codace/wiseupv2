// All visible copy for the WiseUp homepage lives here.
// Source: Downloads/wiseup-home.html (owner content, 2026-10-21). Items not in that file are kept
// from the earlier live homepage (process step 4, client segments, FAQ). Notes for the owner:
// - The Smoke House cover image shows a "Bucho" logo. Confirm it is the right file.
// - Process card mockups are illustrative UI, not screenshots of a real tool.
// - The scroll sequence (public/seq) is AI-generated footage (Seedance 2.5), not a client shoot.
import smokehouse from '../assets/work/case-smokehouse.jpg';
import karak from '../assets/work/case-karak.jpg';
import indusgo from '../assets/work/case-indusgo.jpg';
import bootland from '../assets/work/case-bootland.jpg';
import erets from '../assets/work/case-erets.jpg';
import sathya from '../assets/work/case-sathya.jpg';

export const site = {
  name: 'WiseUp',
  role: 'Branding & marketing agency in Kerala',
  url: 'https://wiseup.in',
  description:
    'WiseUp is a branding and digital marketing agency in Kozhikode (Calicut), Kerala, serving brands across India and the Middle East.',
  email: 'brandingwithwiseup@gmail.com',
  phone: '+91 62824 34503',
  phoneHref: 'tel:+916282434503',
  whatsapp: 'https://wa.me/916282434503',
  coords: '11.2588°N 75.7804°E',
  city: 'Kozhikode (Calicut), Kerala',
  socials: [
    { label: 'Instagram', href: 'https://www.instagram.com/branding_with_wiseup/' },
    { label: 'LinkedIn', href: 'https://www.linkedin.com/company/wiseup-marketing-agency/' },
    { label: 'Behance', href: 'https://www.behance.net/brandingwithwiseup' },
    { label: 'Pinterest', href: 'https://in.pinterest.com/brandingwithwiseup/' },
    { label: 'YouTube', href: 'https://www.youtube.com/@Brandingwithwiseup' },
  ],
  // Footer social row on /podcast, matching the live wiseup.in/podcast/ footer (checked 2026-10-24): the
  // podcast's own Instagram and YouTube, the agency's WhatsApp, LinkedIn and email. Other pages use
  // WhatsApp + `socials` + email, matching wiseup.in's footer. Labels must match an icon in Footer.astro.
  podcastSocials: [
    { label: 'WhatsApp', href: 'https://wa.me/916282434503' },
    { label: 'Instagram', href: 'https://www.instagram.com/wiseuppod/' },
    { label: 'LinkedIn', href: 'https://www.linkedin.com/company/wiseup-marketing-agency/' },
    { label: 'YouTube', href: 'https://www.youtube.com/@WiseUpPodcast_' },
    { label: 'Email', href: 'mailto:brandingwithwiseup@gmail.com' },
  ],
  // Real wiseup.in nav (the live site's own WordPress menu, user-supplied 2026-10-23) — external
  // links to other WiseUp properties, not in-page anchors on this site. Replaces the previous
  // in-page nav (Who we are/Work/Services/CodeAce); Header.astro renders these as plain external
  // links (target="_blank"), not the old scroll-spy/current-section-highlight anchors.
  // Owner's menu (2026-11-03): Podcast, TV, Studio, Services, Portfolio, Resources (Blogs, Case Studies), About Us.
  // Contact is a phone-icon button beside the menu (Header.astro), not a text link.
  nav: [
    { label: 'WiseUp Podcast', href: 'https://wiseup.in/podcast/' },
    { label: 'WiseUp TV', href: 'https://wiseup.in/wiseup-tv/' },
    { label: 'Studio', href: 'https://wiseup.in/wiseup-studio/' },
    { label: 'Services', href: 'https://wiseup.in/services/' },
    { label: 'Portfolio', href: 'https://wiseup.in/studio/portfolio/' },
    { label: 'Resources', children: [
      { label: 'Blogs', href: '/blog/' },
      { label: 'Case Studies', href: 'https://wiseup.in/case-studies/' },
    ] },
    { label: 'About Us', href: '/about/' },
  ],
  contactHref: '/contact/',
  // Street address as given by the owner, 2026-11-03 (same as wiseup.in's LocalBusiness schema).
  address: 'Third Floor, Sahya Building Govt. Cyberpark, Nellikkode, Kozhikode, Kerala 673016',
  mapHref: 'https://www.google.com/maps/search/?api=1&query=Sahya+Building+Govt+Cyberpark+Nellikkode+Kozhikode',
  cta: 'Get our plan first',
  ctaShort: 'Get our plan',
};

export const hero = {
  eyebrow: 'Branding & marketing agency in Kerala',
  line: ['We create a voice.', 'Not dragon fire.', 'A burning flame.'],
  lede:
    'Judge us by the plan we send before we even talk numbers. WiseUp is a creative marketing agency in Kozhikode (Calicut), built around how you see your business.',
  stats: [
    { value: '120+', label: 'Projects delivered' },
    { value: '3M+', label: 'Audience reached' },
    { value: '8', label: 'Years of CodeAce engineering' },
    { value: '1', label: 'Goal: scale your business' },
  ],
};

// Pulled from the live homepage's logo ticker (.azb-ticker-section at wiseup.in), 2026-10-22 —
// the real, current client roster for this strip, replacing the older placeholder set (some of
// which, e.g. Smoke House/Bootland/Erets Space, are case-study clients shown elsewhere on the
// site but aren't actually in this particular ticker). Logo files mirrored to public/clients/.
export const marquee = [
  { name: 'Amarapushpa', src: '/clients/client-logos-2026/amarapushpa.webp', tile: true },
  { name: 'BM Prime', src: '/clients/client-logos-2026/bm-prime.webp' },
  { name: 'Bucho', src: '/clients/client-logos-2026/bucho.webp', tile: true },
  { name: 'CADD', src: '/clients/client-logos-2026/cadd.webp', tile: true },
  { name: 'Cellar de mahe', src: '/clients/client-logos-2026/cellar-de-mahe.webp', tile: true },
  { name: 'Clair veda', src: '/clients/client-logos-2026/clair-veda.webp' },
  { name: 'Eduwizz', src: '/clients/client-logos-2026/eduwizz.webp', tile: true },
  { name: 'Ellisto', src: '/clients/client-logos-2026/ellisto.webp' },
  { name: 'Erets', src: '/clients/client-logos-2026/erets.webp', tile: true },
  { name: 'Flora fauna', src: '/clients/client-logos-2026/flora-fauna.webp', tile: true },
  { name: 'Formaa', src: '/clients/client-logos-2026/formaa.webp', tile: true },
  { name: 'Gloveda', src: '/clients/client-logos-2026/gloveda.webp', tile: true },
  { name: 'Golden Karak', src: '/clients/golden-karak-sm.webp' },
  { name: 'Hayath', src: '/clients/client-logos-2026/hayath.webp', tile: true },
  { name: 'Intervel', src: '/clients/client-logos-2026/intervel.webp', tile: true },
  { name: 'Lullaby', src: '/clients/client-logos-2026/lullaby.webp', tile: true },
  { name: 'Lunar', src: '/clients/client-logos-2026/lunar.webp', tile: true },
  { name: 'MGF', src: '/clients/client-logos-2026/mgf.webp', tile: true },
  { name: 'mooss', src: '/clients/client-logos-2026/mooss.webp', tile: true },
  { name: 'Onesto Marcado', src: '/clients/client-logos-2026/onesto-marcado.webp', tile: true },
  { name: 'Philips', src: '/clients/client-logos-2026/philips.webp', tile: true },
  { name: 'Popees', src: '/clients/client-logos-2026/popees.webp' },
  { name: 'Sathya', src: '/clients/client-logos-2026/sathya.webp' },
  { name: 'Superhuman', src: '/clients/client-logos-2026/superhuman.webp', tile: true },
  { name: 'Tiny Mafia', src: '/clients/client-logos-2026/tiny-mafia.webp', tile: true },
  { name: 'Wellah', src: '/clients/client-logos-2026/wellah.webp', tile: true },
];

export const about = {
  tag: 'Our point of view',
  heading: ['We do one thing: scale your business.', 'Because that is the only way we scale ours.'],
  body:
    "We are a brand strategy agency and digital marketing agency in Kozhikode, Kerala: AI-integrated and technologically advanced, yet deeply human. We work with brands across Kerala, India and the Middle East, from startups to established names. If you believe your brand has untapped potential, connect with us. We don't just provide a service. We provide that future.",
  // The fit/not-fit distinction, as a contrast statement rather than a checklist.
  contrast: {
    statement: ['Posts fade.', 'Brands last.'],
    rows: [
      { no: 'Vendors deliver files.', yes: 'Partners deliver growth.' },
      { no: 'If you want posters and reels by the piece, we’re not your fit.', yes: 'If you want an associate invested in your brand, we’re built for you.' },
    ],
  },
};

export const process = {
  tag: 'Our process',
  heading: ['You see the plan', 'before you see a number.'],
  // Exactly the 3 steps from wiseup-home.html (nested under "Our point of view" there; promoted
  // to its own section here). No 4th step: an earlier "Watch it against the goal." step had no
  // basis in that content file and has been removed.
  steps: [
    // img: public/process/step-N.webp (+ -sm), the step's own illustration; label + chips are read off that image.
    { id: 'brief', title: 'Listen first.', text: 'Who we are is shaped by who you are. We align with your business and ambition.', label: 'Understand', chips: ['Business goals', 'Audience', 'Insights', 'Opportunities'] },
    { id: 'plan', title: 'Plan before we price.', text: 'You see the strategy before you see a number.', label: 'Strategy', chips: ['Research', 'Positioning', 'Roadmap', 'KPIs'] },
    { id: 'launch', title: 'Execute with intent.', text: "Every asset has a job. If it doesn't serve a purpose, we don't make it.", label: 'Build & launch', chips: ['Design', 'Content', 'Development', 'Campaigns'] },
  ],
};

export const services = {
  tag: 'What we do',
  heading: ['Every channel.', 'One strategy.'],
  lead: 'Branding, design, web and digital marketing for businesses in Kozhikode, Kerala and across India, all from one team.',
  // Words on the rolling drum: the channels, in short form.
  drum: ['Identity', 'Packaging', 'Websites', 'SEO', 'Google Ads', 'Meta Ads', 'Reels', 'Influencers', 'TV ads', 'Product shoots', 'OOH', 'Media buying'],
  items: [
    { title: 'Brand Strategy & Identity', icon: 'signature', tags: ['Brand Strategy & Positioning', 'Logo & Brand Identity Design', 'Personal Branding', 'Market Research', 'Consultancy'] },
    { title: 'Packaging Design & Events', icon: 'box', tags: ['Product Packaging Design', 'Signage & Print Production', 'Event Branding'] },
    { title: 'Web Development', icon: 'code', tags: ['Business Websites', 'Online Stores', 'Built to be found and to convert'] },
    { title: 'SEO Services', icon: 'search', tags: ['Search Engine Optimization', 'Local SEO in Kozhikode & Kerala', 'Be found. Be chosen.'] },
    { title: 'Performance Marketing', icon: 'target', tags: ['Google Ads', 'Meta Ads', 'Lead generation & PPC'] },
    { title: 'Digital Marketing', icon: 'globe', tags: ['Strategy & Creatives', 'PR & Crisis Management'] },
    { title: 'Social Media Marketing', icon: 'chat', tags: ['Reels', 'Influencer Marketing', 'Engagement & Sponsorship'], href: 'https://wiseup.in/services/social-media-marketing-agency-in-kerala/' },
    { title: 'Video & Photography', icon: 'video', tags: ['TV Commercials', 'Theater & Digital Ads', 'Photoshoot & Product Shoot', 'Corporate & Concept Films', 'CGI & AI Videos'] },
    { title: 'Campaigns & Media Buying', icon: 'megaphone', tags: ['OOH, Print & Radio Campaigns', 'Digital & Video Campaigns', 'Media Planning & Buying', 'Monitoring'] },
  ],
};

export const clients = {
  tag: 'Who we work with',
  heading: ['Branding for brands', 'at every stage.'],
  segments: [
    { id: 'startups', title: 'Startups', text: 'A clear identity, a sharp message and a launch plan sized to a young company’s budget.', points: ['Naming & identity', 'Launch plan', 'First website'] },
    { id: 'retail', title: 'Retail & consumer', text: 'Restaurants, cafés, hospitality and product brands, from Kozhikode to the Gulf.', points: ['Packaging', 'Store & signage', 'Always-on social'], featured: true },
    { id: 'founders', title: 'Founders & professionals', text: 'Personal branding that turns what you know into visibility.', points: ['Personal brand', 'Search presence', 'Press'] },
    { id: 'established', title: 'Established businesses', text: 'Repositioning and rebrands for companies that outgrew their first identity.', points: ['Repositioning', 'Rebrand', 'Growth marketing'] },
  ],
};

export type Project = {
  slug: string;
  title: string;
  category: string;
  place?: string;
  summary: string;
  cover: { src: ImageMetadata; alt: string };
  externalUrl: string;
};

export const projects: Project[] = [
  {
    slug: 'smoke-house',
    title: 'Smoke House',
    category: 'Restaurant branding',
    place: 'Kozhikode',
    summary: 'A quiet restaurant near Calicut Beach, turned into a high-demand dining destination.',
    cover: { src: smokehouse, alt: 'Skewers on a charcoal grill over open flame, with a cream restaurant logo set over the smoke' },
    externalUrl: 'https://wiseup.in/case-studies/smokehouse/',
  },
  {
    slug: 'golden-karak',
    title: 'Golden Karak',
    category: 'Café brand',
    place: 'Bahrain',
    summary: 'Strong offline fame, small digital footprint. We built the online presence to match.',
    cover: { src: karak, alt: 'Golden Karak Restaurant roundel logo, orange and maroon, over a night photo of the restaurant front' },
    externalUrl: 'https://wiseup.in/case-studies/golden-karak/',
  },
  {
    slug: 'indus-go',
    title: 'Indus Go',
    category: 'Self-drive rentals',
    summary: "Marketing for one of India's leading self-drive car rental brands.",
    cover: { src: indusgo, alt: 'Black Toyota MPV in a grey studio with the Indus Go wordmark in lime across it' },
    externalUrl: 'https://wiseup.in/case-studies/indusgo/',
  },
  {
    slug: 'bootland',
    title: 'Bootland',
    category: 'Event branding',
    summary: 'Full identity and stage branding for a footwear and lifestyle expo, built to read across a crowded hall.',
    cover: { src: bootland, alt: 'Bootland Footwear & Lifestyle Retail Expo identity, lime and black, over a blurred stage with an audience' },
    externalUrl: 'https://wiseup.in/case-studies/bootland/',
  },
  {
    slug: 'erets-space',
    title: 'Erets Space',
    category: 'Space technology',
    summary: 'Brand story for laser and AI systems tackling space debris.',
    cover: { src: erets, alt: 'Erets wordmark in white and red between a satellite and a blue planet in a field of debris' },
    externalUrl: 'https://wiseup.in/case-studies/erets/',
  },
  {
    slug: 'sathya-agencies',
    title: 'Sathya Agencies',
    category: 'Brand launch campaign',
    place: 'Kerala',
    summary: 'WiseUp created a memorable brand launch campaign for Sathya Agencies across Kerala through creative storytelling and integrated marketing.',
    cover: { src: sathya, alt: 'Sathya “Spreading Happiness” logo on a red backdrop, with home appliances on one side and a brand ambassador holding a phone on the other' },
    externalUrl: 'https://wiseup.in/case-studies/sathya-agencies-brand-launch-campaign-kerala/',
  },
];

export const work = {
  tag: 'Selected work',
  heading: ['Proof, not bluff.', 'Restaurants, cafés, expos and space tech, from Kozhikode to the Gulf.'],
};

export const codeace = {
  tag: 'Our roots',
  heading: ['The creative wing', 'of CodeAce.'],
  body:
    'For eight years, CodeAce has engineered digital platforms for growing businesses. WiseUp is its creative wing. It joins that technical backbone to brand storytelling, so your strategy, your story and your systems are built by one team.',
  // The body, split across the three cards (same sentences, no new claims).
  cards: [
    { mono: 'C', name: 'CodeAce', role: 'Eight years of engineering', text: 'For eight years, CodeAce has engineered digital platforms for growing businesses.', mark: 'codeace.com' },
    { mono: 'W', name: 'WiseUp', role: 'The creative wing', text: 'WiseUp is its creative wing. It joins that technical backbone to brand storytelling.', mark: 'wiseup.in' },
    { mono: '1', name: 'One team', role: 'Strategy, story, systems', text: 'So your strategy, your story and your systems are built by one team.', mark: 'One team' },
  ],
  href: 'https://codeace.com',
};

export const faq = {
  tag: 'Questions',
  heading: ['Choosing a branding', 'agency in Kerala.'],
  items: [
    { q: 'What does a branding agency in Kerala actually do?', a: 'It decides how a business is positioned and how it looks and sounds: strategy, naming, logo and identity, packaging and the guidelines that keep it consistent. We also carry that identity into websites, campaigns and social media.' },
    { q: 'How do I choose the best branding agency in Kerala?', a: 'Look past portfolio polish. Ask for case studies with real outcomes, a team that starts with strategy, and a plan before any pricing. That is how we work: you see the plan first, then the numbers.' },
    { q: 'Do you work with startups and brands outside Kerala?', a: 'Yes. We are based in Kozhikode and work with startups, retail and consumer brands across India and the Middle East, from a first identity to full campaigns.' },
    { q: 'What is the difference between a branding agency and a digital marketing agency?', a: 'Branding decides who you are and why people should choose you. Digital marketing, including SEO, ads and social, takes that story to the right audience. One team doing both keeps the message consistent.' },
    { q: 'Can you handle web development, SEO and ads together?', a: 'Yes. CodeAce builds the websites and online stores; WiseUp handles SEO, Google and Meta ads, content and creative. Your site, search presence and campaigns work as one system.' },
  ],
};

// About page (owner content, 2026-10-22). Restored verbatim on the owner's request ("use my
// content only"): only the light edits from the first import remain (sentence case, no
// "seamless"/"cutting-edge", typo fixed). Images are linked from wiseup.in on purpose (owner's choice).
export const aboutPage = {
  tagline: ['Learn smarter.', 'Grow faster.', 'Rise higher.'],
  intro:
    'We are a dedicated team focused on delivering innovative solutions that help businesses thrive in the digital world. With an emphasis on quality and creativity, we build lasting relationships with our clients, combining expertise and technology to create impactful services.',
  who: {
    tag: 'Who we are',
    heading: 'The strategic creative arm of CodeAce IT Solutions.',
    body: [
      'CodeAce is a technology company with over seven years of experience engineering high-performance digital platforms. WiseUp is its strategic creative arm.',
      'We bridge the gap between complex technical execution and brand storytelling. CodeAce provides the technology backbone; WiseUp focuses on brand building, marketing strategy and growth-led campaigns. Together that means data-driven marketing and technical innovation from one team.',
    ],
  },
  expertise: {
    tag: 'Our expertise',
    stats: [
      { value: 7, suffix: '+', label: 'Years of industry experience', text: 'Driving growth for startups, brands and businesses.' },
      { value: 120, suffix: '+', label: 'Projects delivered', text: 'Helping brands scale through strategy, design and marketing.' },
      { value: 3, suffix: 'M+', label: 'Audience reached', text: 'Campaigns generating visibility across digital platforms.' },
    ],
  },
  values: {
    tag: 'Our values',
    items: [
      { title: 'Integrity', text: 'Honesty, transparency, and building trust with our clients.' },
      { title: 'Quality', text: 'High-quality solutions that meet the highest standards.' },
      { title: 'Innovation', text: 'New ideas and technologies, used to make modern, effective solutions.' },
      { title: 'Customer commitment', text: 'Our clients’ success is our priority. We work closely with them to understand their goals and deliver results.' },
    ],
  },
  team: {
    tag: 'Our team',
    text: 'Our team is made up of talented professionals who bring creativity, technical expertise and dedication to every project. We collaborate, share ideas and keep learning, so every client gets our best work.',
    photo: { src: 'https://wiseup.in/wp-content/uploads/2026/10/DSC00377-copy.webp', alt: 'The WiseUp team together on stage at a brand launch event', width: 1500, height: 822 },
  },
  founders: {
    tag: 'Our founders',
    people: [
      { name: 'Jijin Mohan', role: 'CEO', photo: { src: 'https://wiseup.in/wp-content/uploads/2026/10/Frame-1984078518.webp', width: 750, height: 889 } },
      { name: 'Sarath Kumar', role: 'COO', photo: { src: 'https://wiseup.in/wp-content/uploads/2026/10/Frame-1984078518-1.webp', width: 750, height: 891 } },
    ],
  },
};

export const contact = {
  tag: "Let's talk",
  heading: ['Ready to light', 'the fire?'],
  body: "Tell us where you want your brand to go. We'll send the plan before we talk numbers.",
};

// Contact page (redesign 2026-10-22). The brief is one sentence the visitor completes; the preview
// beside it is the exact WhatsApp message it composes (see briefForm() in motion/main.ts).
export const contactPage = {
  title: ['Tell us what', 'you want branded.'],
  intro:
    "Tell us where you want your brand to go. We'll send the plan before we talk numbers. Fill in the form, message us on WhatsApp, or drop by the studio.",
  formHeading: 'Send us a brief',
  detailsHeading: 'Reach us directly',
  mapHeading: 'Find us',
  // city-level coordinates (site.coords): no street address is on file for the studio yet.
  mapEmbed: 'https://www.google.com/maps?q=Sahya+Building,+Govt.+Cyberpark,+Nellikkode,+Kozhikode&z=16&output=embed', // the studio's building (owner's address, 2026-11-03)
};
